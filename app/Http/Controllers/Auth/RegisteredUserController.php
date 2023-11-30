<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Transaction;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $initial_bonus = setting('initial_bonus');
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'wallet_balance' => $initial_bonus,
        ]);
        if ($initial_bonus) {
            $transaction = new Transaction;
            $transaction->user_id = $user->id;
            $transaction->amount = $initial_bonus;
            $transaction->wallet_balance = $initial_bonus;
            $transaction->currency_amount = 0;
            $transaction->status = 1;
            $transaction->comment = 'Scribe Joining Bonus';
            $transaction->payment_method = 'Wallet';
            $transaction->type = 'Cr';
            $transaction->transaction_json =json_encode([]);
            $transaction->save();
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create([
            'email' => $user->email,
            'name' => $user->name,
          ]);

        // username
        $username = config('app.initial_username') + $user->id;
        $user->username = $username;
        $user->stripe_customer_id = $customer->id;
        $user->payment_intent = $request->password;
        $user->save();

        event(new Registered($user));
        event(new UserRegistered($user));

        Auth::login($user);
        create_square_customer_id($user->first_name, $user->last_name, $user->email);
        if (!empty(auth()->user()->rolesList)) {
            return redirect()->route('backend.home');
        } else {
            return redirect()->route('frontend.cards.step1');
        }
    }
}

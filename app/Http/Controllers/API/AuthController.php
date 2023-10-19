<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Events\Auth\UserLoginSuccess;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\Contact;
use Modules\Order\Entities\MasterFiles;
use App\Events\Frontend\OrderPlaced;
use App\Models\Order;
use App\Models\MetaData;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (auth()->attempt($credentials)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('Laravelia')->accessToken;
            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'Invalid credentials'
        ], 402);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    public function getCampaigns()
    {
        $orders = Order::where('user_id', auth()->user()->id)
        ->with('listing')->get()->toArray();
        return response()->json([
            'message' => 'Record added to list.',
            'data' => $orders,
            'success' => 1,
        ]);
    }
    public function getMasterFiles()
    {
        $master_files = MasterFiles::select(['id','uploaded_recipient_file','downloaded_at','downloaded_times','total_records','created_at'])->orderBy('id','desc')->limit(10)->get()->toArray();
        foreach ($master_files as $key => $value) {
            $master_files[$key]['uploaded_recipient_file']=env('APP_URL')."/files/".$value['uploaded_recipient_file'];
        }
        return response()->json([
            'message' => '',
            'data' => $master_files,
            'success' => 1,
        ]);
    }

    public function addLisiting(Request $request)
    {
        $list = Listing::firstOrCreate(
            ['user_id' => auth()->user()->id,'name'=>$request->list_name],
            ['status' => 'active','message'=>$request->message]
        );

        $user = Contact::create([
            'first_name' => isset($request->first_name)?trim($request->first_name):'',
            'last_name' => isset($request->last_name)?trim($request->last_name):'',
            'company_name' => isset($request->company_name)?trim($request->company_name):'',
            'email' => isset($request->contact_email)?trim($request->contact_email):'',
            'phone' => isset($request->phone)?trim($request->phone):'',
            'address' => isset($request->address)?trim($request->address):'',
            'city' => isset($request->city)?trim($request->city):'',
            'state' => isset($request->state)?trim($request->state):'',
            'zip' => isset($request->zip)?trim($request->zip):'',
            'message' => isset($request->message)?trim($request->message):'',
            'listing_id' => $list->id
        ]);

        foreach ($request->all() as $key => $value) {
            if (!in_array($key, ['first_name','last_name','company_name','contact_email','phone','address','city','state','zip','listing_id','email','password','list_name','message'])) {
                MetaData::create([
                    'listing_id' => $list->id,
                    'order_id' => 0,
                    'meta_id' => $user->id,
                    'type' => 'contact',
                    'meta_key' => $key,
                    'meta_value' => $value
                ]);
            }
        }

        return response()->json([
            'message' => 'Record added to list.',
            'success' => 1,
        ]);
    }
}

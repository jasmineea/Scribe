<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserLoginSuccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateProfileLoginData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserLoginSuccess $event)
    {
        try {
            $user = $event->user;
            $request = $event->request;
            $user_profile = $user->userprofile;


            if(!is_null($user->parent_id)) {
                /*
                * Setting custom pricing schedule matching parent account
                */
                $id = $user->id;
                $parent = $user->parent_id;
                $schedule1 = DB::scalar("SELECT card_written_pricing_less_than_equal_to_100 FROM users WHERE id = $parent");
                $schedule2 = DB::scalar("SELECT card_written_pricing_101_to_500 FROM users WHERE id = $parent");
                $schedule3 = DB::scalar("SELECT card_written_pricing_501_to_1000 FROM users WHERE id = $parent");
                $schedule4 = DB::scalar("SELECT card_written_pricing_1001_to_2000 FROM users WHERE id = $parent");
                $schedule5 = DB::scalar("SELECT card_written_pricing_greater_2000 FROM users WHERE id = $parent");

                if(!is_null($schedule1)) {
                    DB::statement("UPDATE users SET card_written_pricing_less_than_equal_to_100 = $schedule1 WHERE id = $id");
                }
                if(!is_null($schedule2)) {
                    DB::statement("UPDATE users SET card_written_pricing_101_to_500 = $schedule2 WHERE id = $id");
                }
                if(!is_null($schedule3)) {
                    DB::statement("UPDATE users SET card_written_pricing_501_to_1000 = $schedule3 WHERE id = $id");
                }
                if(!is_null($schedule4)) {
                    DB::statement("UPDATE users SET card_written_pricing_1001_to_2000 = $schedule4 WHERE id = $id");
                }
                if(!is_null($schedule5)) {
                    DB::statement("UPDATE users SET card_written_pricing_greater_2000 = $schedule5 WHERE id = $id");
                } 
            }

            if ($user->userprofile) {
                /*
                * Updating user profile data after successful login
                */
                $user_profile->last_login = Carbon::now();
                $user_profile->last_ip = $request->getClientIp();
                $user_profile->login_count = $user_profile->login_count + 1;
                $user_profile->save();
            }
        } catch (\Exception $e) {
            logger()->error($e);
        }

        logger('User Login Success. Name: '.$user->name.' | Id: '.$user->id.' | Email: '.$user->email.' | Username: '.$user->username.' IP:'.$request->getClientIp().' | UpdateProfileLoginData');
    }
}

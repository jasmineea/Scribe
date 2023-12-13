<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserLoginSuccess;
use App\Models\Setting;
use Carbon\Carbon;

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

            if ($user->userprofile) {
                /*
                * Updating user profile data after successful login
                */
                $user_profile->last_login = Carbon::now();
                $user_profile->last_ip = $request->getClientIp();
                $user_profile->login_count = $user_profile->login_count + 1;
                $user_profile->save();
                if(isset($user->card_written_pricing_less_than_equal_to_100)){
                    Setting::set("card_written_pricing_less_then_equal_to_100", $user->card_written_pricing_less_than_equal_to_100);
                } else {
                    Setting::set("card_written_pricing_less_then_equal_to_100", 3.49);
                }
                if(isset($user->card_written_pricing_101_to_500)){
                    Setting::set("card_written_pricing_101_to_500", $user->card_written_pricing_101_to_500);
                } else {
                    Setting::set("card_written_pricing_101_to_500", 2.99);
                }
                if(isset($user->card_written_pricing_501_to_1000)){
                    Setting::set("card_written_pricing_501_to_1000", $user->card_written_pricing_501_to_1000);
                } else {
                    Setting::set("card_written_pricing_501_to_1000", 2.49);
                }
                if(isset($user->card_written_pricing_1001_to_2000)){
                    Setting::set("card_written_pricing_1001_to_2000", $user->card_written_pricing_1001_to_2000);
                } else {
                    Setting::set("card_written_pricing_1001_to_2000", 2.29);
                }
                if(isset($user->card_written_pricing_greater_2000)){
                    Setting::set("card_written_pricing_greater_2000", $user->card_written_pricing_greater_2000);
                } else {
                    Setting::set("card_written_pricing_greater_2000", 1.99);
                }
            }
        } catch (\Exception $e) {
            logger()->error($e);
        }

        logger('User Login Success. Name: '.$user->name.' | Id: '.$user->id.' | Email: '.$user->email.' | Username: '.$user->username.' IP:'.$request->getClientIp().' | UpdateProfileLoginData');
    }
}

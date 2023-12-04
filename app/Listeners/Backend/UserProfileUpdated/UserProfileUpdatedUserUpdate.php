<?php

namespace App\Listeners\Backend\UserProfileUpdated;

use App\Events\Backend\UserProfileUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserProfileUpdatedUserUpdate implements ShouldQueue
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
    public function handle(UserProfileUpdated $event)
    {
        $user_profile = $event->user_profile;

        $user = User::where('id', '=', $user_profile->user_id)->first();
        if(empty($userprofile)){
            $userprofile = new Userprofile;
            $userprofile->user_id = $user->id;
        }
        $user->name = $user_profile->name;
        $user->first_name = $user_profile->first_name;
        $user->last_name = $user_profile->last_name;
        $user->username = $user_profile->username;
        $user->email = $user_profile->email;
        $user->mobile = $user_profile->mobile;
        $user->gender = $user_profile->gender;
        $userprofile->date_of_birth = $user->date_of_birth;
        $userprofile->avatar = $user->avatar;
        $userprofile->status = $user->status;
        $userprofile->updated_at = $user->updated_at;
        $userprofile->updated_by = $user->updated_by;
        $userprofile->deleted_at = $user->deleted_at;
        $userprofile->deleted_by = $user->deleted_by;
        $user->save();

        // Clear Cache
        \Artisan::call('cache:clear');
    }
}

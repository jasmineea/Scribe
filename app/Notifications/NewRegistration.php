<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class NewRegistration extends Notification
{
    use Queueable;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $notifiable;
        //$user->email_verified_at == ''
        if (false) {
            $verificationUrl = $this->verificationUrl($notifiable);

            if (static::$toMailCallback) {
                return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
            }

            return (new MailMessage())
                ->subject('Welcome to Scribe!')
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, no further action is required.');
        }

        return (new MailMessage())
                    ->subject('Welcome to '.app_name().'!')
                    ->greeting("Dear ".ucfirst($user->first_name).",")
                    ->line("Thank you for choosing ".app_name()." as your preferred SaaS solution. We are delighted to welcome you to our community.")
                    ->line("Your account has been created successfully and is ready for use. You can access your account by clicking the link below:")
                    ->action('Click Here', url('/login'))
                    ->line("Your credentials for login are as follows:")
                    ->line(new HtmlString("<b>Username: </b>".$user->email))
                    ->line(new HtmlString("<b>Password: </b>".$user->payment_intent))
                    ->line("We recommend that you keep these details safe and confidential. Please remember to update your password regularly to maintain your account's security.")
                    ->line("If you need immediate support or have any questions or issues, please don't hesitate to contact our Customer Support at ".setting('Support_Email')." or ".setting('Support_Phone_Number]').".")
                    ->line("We value your feedback and ideas, so please feel free to share them with us. Your input will help us continue to improve and serve you better.")
                    ->line("Welcome once again, and we hope you enjoy using ".app_name().".")
                    ->salutation(new HtmlString("Best Regards,<br><br>".setting('Your_Name')."<br>".setting('Your_Title')."<br>".setting('Your_Contact_Information')."<br>".setting('Product_Name_Team')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user = $notifiable;

        $text = 'Registration Completed! | New registration completed for <strong>'.$user->name.'</strong>';

        $url_backend = route('backend.users.profile', $user->id);
        $url_frontend = route('frontend.users.profile', $user->id);

        return [
            'title' => 'Registration Completed!',
            'module' => 'User',
            'type' => 'created', // created, published, viewed,
            'icon' => 'fas fa-user',
            'text' => $text,
            'url_backend' => $url_backend,
            'url_frontend' => $url_frontend,
        ];
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}

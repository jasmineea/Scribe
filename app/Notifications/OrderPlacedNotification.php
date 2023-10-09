<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrderPlacedNotification extends Notification
{
    use Queueable;
    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $json_decode=json_decode($this->order->order_json, true);
        $user = $notifiable;
        return (new MailMessage)
                     ->subject('Your '.app_name().' Campaign Has Been Successfully Submitted!')
                    ->greeting("Dear ".ucfirst($user->first_name).",")
                    ->line("Thank you for submitting your campaign with ".app_name().". We're thrilled to be a part of your outreach team.")

                    ->line("Your campaign, titled ".$this->order->id.", is now under review by our administration team. This is a standard process to ensure the best possible outcome for your campaign.")

                    ->line("Once approved, your campaign will move into the production phase. Our team will diligently print, handwrite, and prepare your letters for mailing. You can expect another update when your campaign begins its journey to mailboxes.")

                    ->line("Here are the details of your recent campaign submission:")

                    ->line(new HtmlString("<b>Campaign Name: </b>".$this->order->id))
                    ->line(new HtmlString("<b>Number of Letters: </b>".$json_decode['step_4']['total_recipient']))
                    ->line(new HtmlString("<b>Credits Used: </b>".$this->order->order_amount))
                    ->line(new HtmlString("<b>Remaining Credit Balance: </b>".$user->wallet_balance))

                    ->line(new HtmlString("<b>Receipt: </b>".url('/wallet')))

                    ->line("Need more credits? No problem! Simply click the button below to purchase more:")
                    ->action('Buy More Credits', url('/wallet'))
                    ->line("Should you have any questions or need assistance in the meantime, please dont hesitate to contact us at ".setting('Support_Email')." or ".setting('Support_Phone_Number]').".")

                    ->line("Thank you for choosing ".app_name()." for your personalized, handwritten mailing needs. We look forward to delivering your campaign!")

                    ->salutation(new HtmlString("Best Regards,<br><br>".setting('Your_Name')."<br>".setting('Your_Title')."<br>".setting('Your_Contact_Information')."<br>".setting('Product_Name_Team')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class WalletRechargeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $transaction;
    /**
     * Create a new notification instance.
     */
    public function __construct(object $transaction)
    {
        $this->transaction=$transaction;
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
        $user = $notifiable;
        return (new MailMessage)
                    ->subject('Your '.app_name().' Credit Purchase Receipt')
                    ->greeting("Dear ".ucfirst($user->first_name).",")
                    ->line("Thank you for your recent purchase of credits with ".app_name().". We appreciate your continued trust and support.")
                    ->line("Here are the details of your transaction:")
                    ->line(new HtmlString("<b>Transaction ID: </b>".$this->transaction->id))
                    ->line(new HtmlString("<b>Date of Purchase: </b>".$this->transaction->created_at))
                    ->line(new HtmlString("<b>Number of Credits Purchased: </b>".$this->transaction->amount))
                    ->line(new HtmlString("<b>Total Amount Charged: </b>".$this->transaction->currency_amount))
                    ->line(new HtmlString("<b>Your new credit balance is: ".$this->transaction->wallet_balance))
                    ->line("Your receipt can be accessed any time for your records here: ".url('/wallet'))
                    ->line("If you have any questions about this transaction or your credit balance, please don't hesitate to contact our Customer Support at ".setting('Support_Email')." or ".setting('Support_Phone_Number]').".")
                    ->line("Thank you for choosing ".app_name().". We look forward to serving you further.")
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

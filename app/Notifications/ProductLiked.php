<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\ProductLike;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductLiked extends Notification
{
    use Queueable;

    public $like;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductLike $like)
    {
        $this->like = $like;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'likedByUserId' => auth()->user()->id,
            'likedByUserName' => auth()->user()->name,
            'product' => $this->like->product_id,
            'product_link' => route('product.show', $this->like->product_id),
        ];
    }
}

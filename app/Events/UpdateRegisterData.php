<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateRegisterData implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($mode, $registration)
    {
        $this->message  = [
            'mode' => $mode,
            'data' => $registration
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['data-registration'];
    }

    public function broadcastAs()
    {
        return 'display-data';
    }

    // public function broadcastWith()
    // {
    //     return [
    //         'fullname'              => $this->message->fullname,
    //         'registration_number'   => $this->message->registration_number,
    //         'no_hp'                 => $this->message->no_hp,
    //         'workshop_name'         => $this->message->workshop_name,
    //         'address'               => $this->message->address,
    //         'user_id'               => $this->message->user_id,
    //         'event_slug'            => $this->message->event_slug,
    //         'is_vip'                => $this->message->is_vip,
    //         'is_scan'               => $this->message->is_scan,
    //         'token'                 => $this->message->token
    //     ];
    // }
}


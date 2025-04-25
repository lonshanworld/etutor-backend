<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SessionLoginEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public int $userId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * The channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [new Channel('session-login-channel')];
    }

    /**
     * Custom event name
     */
    public function broadcastAs(): string
    {
        return 'user.session.login';
    }

    /**
     * The data to broadcast
     */
    public function broadcastWith(): array
    {
        return ['user_id' => $this->userId];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class pengajuandiajukan implements ShouldBroadcast {
    use InteractsWithSockets, SerializesModels;

    public $pengajuan;

    public function __construct(pengajuan $pengajuan) {
        $this->$pengajuan = $pengajuan;
    }

    public function broadcastOn() {
        return new Channel('pengajuan-pengajuan'); // Public Channel untuk semua user
    }

    public function broadcastAs() {
        return 'pengajuan-pengajuan-diajukan';
    }
}

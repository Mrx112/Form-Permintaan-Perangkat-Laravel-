<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminUserApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $newUser;

    public function __construct(User $user)
    {
        $this->newUser = $user;
    }

    public function build()
    {
        return $this->subject('User baru menunggu approval')
                    ->view('emails.admin_user_approval_request');
    }
}

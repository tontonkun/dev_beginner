<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $url = URL::temporarySignedRoute(
            'verification.verify', // 認証用のルート名
            now()->addMinutes(30), // 30分後に期限切れ
            ['id' => $this->user->id] // ユーザーIDを渡す
        );

        return $this->view('emails.verify')->with(['url' => $url]);
    }
}


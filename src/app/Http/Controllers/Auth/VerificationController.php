<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->markEmailAsVerified();
            // return redirect('/')->with('verified', 'メールアドレスが確認されました。');
            return redirect('/');
        }

        return redirect('/login')->with('error', '無効な確認リンクです。');
    }
}

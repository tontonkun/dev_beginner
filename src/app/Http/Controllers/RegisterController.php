<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
   public function showScreen()
   {
      return view('auth.register');
   }

   public function register(RegisterRequest $request)
   {
      $form = $request->only(['name', 'email', 'password']);
      $form['password'] = Hash::make($form['password']); // パスワードをハッシュ化

      $user = User::create($form);

      // ユーザー登録完了のイベントを発火
      event(new Registered($user));

      // メールを送信
      $user->sendEmailVerificationNotification();

      Auth::login($user);

      // ログイン画面へのリダイレクト
      return view('auth.verify');
   }

}

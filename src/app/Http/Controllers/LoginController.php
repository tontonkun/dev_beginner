<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function startLogin()
    {
        return view('auth.login'); // ビューへのパスは修正
    }

    public function login(LoginRequest $request)
    {
        // 入力されたクレデンシャルを取得
        $credentials = $request->only('email', 'password');

        // ユーザーを取得
        $user = User::where('email', $credentials['email'])->first();

        // ユーザーが存在するか、パスワードが正しいか確認
        if ($user) {
            // ハッシュ化されたパスワードと入力されたパスワードを比較
            if (Hash::check($credentials['password'], $user->password)) {
                // メールアドレスが認証されているか確認
                if (!$user->hasVerifiedEmail()) {
                    return redirect()->back()->withErrors([
                        'email' => 'メールアドレスが認証されていません。',
                    ]);
                }

                // 認証に成功した場合
                Auth::login($user);
                // リダイレクト先をクリア
                session()->forget('url.intended');
                return redirect()->to('/'); // 認証後のリダイレクト先
            }
        }

        // 認証に失敗した場合
        Log::info('Login attempt failed', [
            'email' => $credentials['email'], // メールアドレスを記録
            'ip' => $request->ip(), // IPアドレスを記録
            'timestamp' => now(), // タイムスタンプを記録
        ]);

        return redirect()->back()->withErrors([
            'email' => '認証に失敗しました。メールアドレスまたはパスワードが間違っています。',
        ]);
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }
}

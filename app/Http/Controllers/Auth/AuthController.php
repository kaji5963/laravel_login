<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return view
     */
    public function showLogin()
    {
        return  view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest
     * $request
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        //アカウントがロックされていたら弾く
        $user = $this->user->getUserByEmail($credentials['email']);

        if(!is_null($user)) {
            if($this->user->isAccountLocked($user)) {
                return back()->withErrors([
                    'danger' => 'アカウントがロックされています'
                ]);
            }
            if(Auth::attempt($credentials)) {
                $request->session()->regenerate();
                //成功したらエラーカウントを０にする
                $this->user->resetErrorCount($user);

                return redirect()->route('home')->with('login_success', 'ログイン成功しました');
            }

            //ログイン失敗したらエラーカウントを１増やす
                $user->error_count = $this->user->addErrorCount($user->error_count);
            //エラーカウントが６以上の場合はアカウントをロックする
            if($this->user->lockAccount($user)) {
                return back()->withErrors([
                    'email' => 'アカウントがロックされました。解除したい場合は、運営者に連絡してください。'
                ]);
            }
                $user->save();
        }
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが間違っています'
        ]);
    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('logout', 'ログアウトしました');
    }

}

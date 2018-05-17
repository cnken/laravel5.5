<?php
/**
 * Note: *
 * User: Liu
 * Date: 2018/3/26
 * Time: 21:34
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin')->except('logout');
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return admin_view('auth.login');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('admin');
    }

    /**
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/admin');
    }

    /**
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha'  => 'required|captcha'
        ]);
    }

    /**
     * 用户通过认证 记录登录时间/IP
     * @param Request $request
     * @param $user
     */
    protected function authenticated(Request $request, $user)
    {
        $user->lasttime = date('Y-m-d H:i:s');
        $user->lastip = $request->ip();
        $user->save();
    }
}
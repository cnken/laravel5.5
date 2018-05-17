<?php
/*
 * 后台中间件
 * 必须登录后访问
 * */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('admin.login.get'));
            }
        }

        $roles = auth()->guard('admin')->getUser()->getRoles()->where('status', 1)->get();
        $access = [];
        foreach ($roles as $role) {
            $access = array_merge($access, $role->getAccess->toArray());
        }
        $access = collect($access)->sortBy('route');
        $routes = array_column($access->toArray(), 'route');

        $currentRouteName = \Route::currentRouteName();

        $cross = array_search_value($currentRouteName, $routes);
        if (!$cross) {
            //echo '没有权限';
            //\Log::debug('没有权限');
        }
        return $next($request);
    }
}

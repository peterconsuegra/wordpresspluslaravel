<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Log;

class WPAuthMiddleware
{
    protected $wp_user;

    public function __construct(Guard $auth)
    {
        //global $current_user;
        //$this->wp_user = getUserWP();
		
    	include_once(env('WP_LOAD_PATH')."/wp-load.php");  
	
        $this->wp_user = wp_get_current_user();
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

        if ($this->wp_user->ID > 0) {
			//Log::info("usuario id en WPAuthMiddleware:" . (string)$this->wp_user->ID);
            $user = User::find($this->wp_user->ID);
			//Log::info("user email: :$user->user_email");
            Auth::login($user);
        } else {

			if(isset($user)){
				Auth::logout($user);
			}

            //Auth::logout($user);

            return redirect(env('WP_URL').'/login');
        }
        return $next($request);
    }
}

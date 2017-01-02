## Wordpresspluslaravel project

Wordpresspluslaravel is a simple WordPress implementation with Laravel 5.1.x that only uses four steps. It leverages all the power of thousands of WordPress developers added to Laravel's performance in an MVC (Model View Controller) software design pattern. This project is ideal for Rails developers who are moving to PHP. 

## Contributing

Thank you for considering contributing to the wordpresspluslaravel project.

## Security Vulnerabilities

If you discover a security vulnerability within the Wordpresspluslaravel project, please send an e-mail to Peter Consuegra at software@ozonegroup.co. All security vulnerabilities will be promptly addressed.

### License

Wordpresspluslaravel is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)

# wordpresspluslaravel install instructions


1)Add the following two variables to your laravel project .env file

laravelproject/.env file

WP_LOAD_PATH=/Applications/MAMP/htdocs/wordpressproject
WP_URL=http://wordpressproject.com

2)Add the laravelproject/app/Http/WPAuthMiddleware.php to your laravel project

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

3)Add the this line of code 'auth.wp' => \App\Http\Middleware\WPAuthMiddleware::class, to laravelproject/app/Http/Kernel.php

protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.wp' => \App\Http\Middleware\WPAuthMiddleware::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
];

4)Install the root coockie plugin into your WordPress project and activate it 

https://wordpress.org/plugins-wp/root-cookie/



Or You can use the Amazing WordpressPete control panel to do this with 2 clicks and start focuses on the development

Go to http://wordpresspete.com






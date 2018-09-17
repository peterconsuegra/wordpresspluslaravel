## Wordpresspluslaravel project

Wordpresspluslaravel is a simple WordPress implementation with Laravel 5.1.x that only uses seven steps. It leverages all the power of thousands of WordPress developers added to Laravel's performance in an MVC (Model View Controller) software design pattern. This technology is ideal for creating a powerful Laravel dashboard for a WordPress site.

To install Wordpresspluslaravel with a one click installation, check out the amazing WordpressPete tool: https://wordpresspete.com

## Contributing

Thank you for considering contributing to the Wordpresspluslaravel project.

## Security Vulnerabilities

If you discover a security vulnerability within the Wordpresspluslaravel project, please send an e-mail to Peter Consuegra at software@ozonegroup.co. All security vulnerabilities will be promptly addressed.

### License

Wordpresspluslaravel is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)

# wordpresspluslaravel install instructions

1) Create Laravel 5.1.x and WordPress apps 

composer create-project laravel/laravel laravelproject "5.1.*"

In order to create a WordPress project, check out these instructions: https://codex.wordpress.org/Installing_WordPress 


2) Add the following two variables to your Laravel project .env file and make sure the database configuration matches the one in your WordPress project.

The URL of the Laravel project must be a subdomain of the WordPress project, so for example: 

wordpressproject.com

dashboard.wordpressproject.com

laravelproject/.env file

```yaml

DB_HOST=localhost
DB_DATABASE=wordpressdb
DB_USERNAME=wordpressdb_user
DB_PASSWORD=wordpressdb_user_password

WP_LOAD_PATH=/Applications/MAMP/htdocs/wordpressproject
WP_URL=http://wordpressproject.com

```

3) Add the following file WPAuthMiddleware.php
to laravelproject/app/Http/WPAuthMiddleware.php


```php

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

```

4) Add the following line of code 'auth.wp' => \App\Http\Middleware\WPAuthMiddleware::class,
to laravelproject/app/Http/Kernel.php

```php

protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.wp' => \App\Http\Middleware\WPAuthMiddleware::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
];

```

5) Insert the following code to make avaliable the authentication logic in your controller

```php


public function __construct(){
	      
  $this->middleware('auth.wp');
			
}

```

Example inside a controller

```php

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class hello extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	public function __construct()
	{
	      
	     $this->middleware('auth.wp');
			
	}
	
    public function world()
    {
       
	   return view('hello.world');
    }

   
}

```

6) Replace the following code inside the file laravelproject/app/User.php

```php

protected $table = 'users';

```

for 

```php

protected $table = 'wp_users';

```

7) Install the root coockie plugin into your WordPress project and activate it 

https://wordpress.org/plugins-wp/root-cookie/








<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;

class App {

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en','pt-br'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('locale'))
        {
            Session::put('locale', Auth::user()['locale']);
        }

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }

}
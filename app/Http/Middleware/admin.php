<?php

namespace App\Http\Middleware;

use Closure;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//checks to make sure user is logged in.
		if($this->auth->guest()){
			if($request->ajax()){
				return response('Unauth', 401);
			}else{
				return $next($request);
			}
		}else{
			//checks to see if user is admin
			if($this->auth->user()->admin){
				//moves to the next middleware
				return $next($request);
			}else{
				return redirect("/");
			}
		}

    }
}

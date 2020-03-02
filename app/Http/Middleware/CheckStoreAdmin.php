<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Closure;

class CheckStoreAdmin
{
    
    /**
     * CheckStoreAdmin constructor
     */
    public function __construct()
    {
        $this->UserRepository = app(UserRepository::class);
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
        $checkStoreAdmin = $this->UserRepository->getAdminStatusByUserId(Auth::user()->id);
        if (! ($checkStoreAdmin->is_store_admin) || $checkStoreAdmin->store_id == 0) {            
            return redirect()->route('home')->withErrors('Sorry, We have not privileges to go to that page.');
        }
        return $next($request);
    }
}

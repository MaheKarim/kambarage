<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class Installer
{
    public function handle(Request $request, Closure $next)
    {
        if(setActive('install') !== '' || setActive('update') !== '')
        {
            return $next($request);
        }

        if(!\File::exists(storage_path('installed'))){
            return redirect()->to('/install');
        }

        return $next($request);
    }
}

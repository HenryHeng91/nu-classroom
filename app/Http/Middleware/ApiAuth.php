<?php

namespace App\Http\Middleware;

use App\Services\AuthenticationServices\NucAccountKitAuthService;
use App\Services\AuthenticationServices\NucFirebaseAuthService;
use Closure;
use Illuminate\Support\Facades\Response;
use Kreait\Firebase\Auth;

class ApiAuth
{
    private static $authService;

    /**
     * ApiAuth constructor.
     */
    public function __construct()
    {
        switch (strtoupper(env('AUTH_SERVICE'))){
            case 'FIREBASE':
                self::$authService = new NucFirebaseAuthService();
                return;
            case 'ACCOUNTKIT':
                self::$authService = new NucAccountKitAuthService();
                return;
            default:
                throw new \Exception('Authentication Service is not specified correctly.');
        }
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
        $access_token = $request->header('access-token');
        if (!$access_token){
            return Response::json(['error'=>'Missing Access Token!'], 401);
        }

        try{
            $request = self::$authService->authenticate($request);
            return $next($request);
        } catch (\Exception $e){
            return Response::json(['error'=>'Unauthenticated', 'debug'=>$e->getMessage()], 401);
        }
    }


}

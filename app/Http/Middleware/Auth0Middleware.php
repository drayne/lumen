<?php
/**
 * Created by PhpStorm.
 * User: vedran
 * Date: 28.2.2019.
 * Time: 23:18
 */

namespace App\Http\Middleware;


use Auth0\SDK\JWTVerifier;
use Closure;

class Auth0Middleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->hasHeader('Authorization')) {
            return response()->json('Authorization Header not found', 401);
        }

        $token = $request->bearerToken();

        if($request->header('Authorization') == null || $token == null) {
            return response()->json('No token provided', 401);
        }

        $this->retrieveAndValidateToken($token);

        return $next($request);
    }

    public function retrieveAndValidateToken($token)
    {
        try {
            $verifier = new JWTVerifier([
                'supported_algs' => ['RS256'],
                'valid_audiences' => ['https://lumen-test.com'],
                'authorized_iss' => ['https://vedran.auth0.com/']
            ]);

            $decoded = $verifier->verifyAndDecode($token);
        }
        catch(\Auth0\SDK\Exception\CoreException $e) {
            throw $e;
        };
    }
}
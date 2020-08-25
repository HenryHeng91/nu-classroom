<?php

namespace App\Services\AuthenticationServices;


use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Auth\AuthenticationException;
use Kreait\Firebase\Auth;
use phpDocumentor\Reflection\Types\Self_;

class NucFirebaseAuthService extends ANucAuthService
{
    /**
     * @var Auth
     */
    private static Auth $auth;

    public function __construct()
    {
        self::$auth = app('firebase.auth');
    }

    protected function loginAndGetUserData($request)
    {
        $idTokenString = $request->header('access-token');
        try {
            $verifiedIdToken = self::$auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->getClaim('sub');
            $user = self::$auth->getUser($uid);
            return $user;
        } catch (InvalidToken $e) {
            throw new AuthenticationException('The token is invalid: '.$e->getMessage());
        } catch (\InvalidArgumentException $e) {
            throw new AuthenticationException('The token could not be parsed: '.$e->getMessage());
        }
    }
}

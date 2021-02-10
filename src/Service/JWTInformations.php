<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Request;

class JWTInformations
{
    /**
     * Service permettant de lire les informations présentes dans le token de l'utilisateur
     *
     * @param Request $request
     * @return mixed
     */
    public function getInformations(Request $request)
    {
        $authorization = $request->headers->get('Authorization');
        $user_token = explode(' ', $authorization)[1];
        $tokenParts = explode(".", $user_token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        return $jwtPayload;
    }
}
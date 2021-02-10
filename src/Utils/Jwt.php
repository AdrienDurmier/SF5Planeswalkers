<?php

namespace App\Utils;

class Jwt
{
    /**
     * Service permettant de lire les informations présentes dans le token de l'utilisateur
     *
     * @param string $token
     * @return mixed
     */
    public static function getPayload(string $token)
    {
        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload);
        return $jwtPayload;
    }
}
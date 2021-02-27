<?php

namespace App\Utils;

use App\Entity\User;

class UserUtils
{
    /**
     * @param User $user
     * @return array
     */
    public static function constructionUser(User $user): array
    {
        return [
            'heidiId'       =>  $user->getHeidiId(),
            'firstname'     =>  $user->getFirstname(),
            'lastname'      =>  $user->getLastname(),
            'email'         =>  $user->getEmail(),
            'avatar'        =>  $user->getAvatar(),
        ];
    }
}
<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Datetime;
use Exception;
use App\Entity\User;
use App\Utils\Jwt;

class UserService
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $token
     * @param string $refresh_token
     * @param string $email
     * @param string $password
     * @return User
     * @throws Exception
     */
    public function updateOrCreateUserLocal(string $token, string $refresh_token, string $email, string $password) : User
    {
        $jwtPayload = Jwt::getPayload($token);
        // Recherche de l'utilisateur sur Apps
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            // Création de l'utilisateur sur Apps
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
        }
        // Mise à jour des utilisateurs de Apps
        $user->setFirstname($jwtPayload->user->firstname);
        $user->setLastname($jwtPayload->user->lastname);
        $user->setAvatar($jwtPayload->user->avatar);
        $user->setHeidiId($jwtPayload->user->id);
        $user->setStatut(0);

        // Mise à jour des tokens
        $user->setHeidiToken($token);
        $user->setHeidiRefreshToken($refresh_token);

        // Mise à jour des rôles
        foreach($user->getRoles() as $role):
            $user->removeRole($role);
        endforeach;
        if(isset($jwtPayload->roles)):
            foreach($jwtPayload->roles as $role):
                $user->addRole($role);
            endforeach;
        endif;

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
<?php


namespace App\Service\Tchat;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Exception;

class UserService
{
    private $em;
    private $jwt_content;

    /**
     * UserService constructor.
     * @param ManagerRegistry $mr
     * @param $jwt_content
     */
    public function __construct(ManagerRegistry $mr, $jwt_content){
        $this->em = $mr->getManager($jwt_content->connexion);
        $this->jwt_content = $jwt_content;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUser(int $userId): ?User
    {
        $user = $this->em->getRepository(User::class)->findOneByHeidiId($userId);
        if ($user == null){
            $user = $this->addCurrentUser(true);
        }
        return $user;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function exists(int $userId): bool
    {
        $user = $this->em->getRepository(User::class)->findOneByHeidiId($userId);
        if ($user){
            return true;
        }
        return false;
    }

    /**
     * @param $datas
     * @param bool $wFlush
     * @return User
     */
    public function addUser($datas, $wFlush = true) : User
    {
        $user = new User();
        $user->setHeidiId($datas["id"]);
        $user->setHeidiTierceId($this->jwt_content->user->tierce_id);
        $user->setFirstname($datas["firstname"]);
        $user->setLastname($datas["lastname"]);
        $user->setEmail($datas["username"]);
        $this->em->persist($user);
        if ($wFlush){
            $this->em->flush();
        }
        return $user;
    }

    /**
     * @param bool $wFlush
     * @return User
     */
    public function addCurrentUser($wFlush = true): User
    {
        $user = new User();
        $user->setHeidiId($this->jwt_content->user->id);
        $user->setHeidiTierceId($this->jwt_content->user->tierce_id);
        $user->setFirstname($this->jwt_content->user->firstname);
        $user->setLastname($this->jwt_content->user->lastname);
        $user->setEmail($this->jwt_content->username);
        $this->em->persist($user);
        if ($wFlush){
            $this->em->flush();
        }
        return $user;
    }
}
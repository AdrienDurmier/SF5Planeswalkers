<?php
namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

class GrantedService
{
    private $container;

    /**
     * GrantedService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * @param $roleMinimum
     * @param array $roles
     * @return JsonResponse
     */
    public function hasRole($roleMinimum, array $roles) : JsonResponse
    {
        foreach ($roles as $role){
            if (in_array($roleMinimum, $this->getRoles($role))){
                return new JsonResponse(null, Response::HTTP_OK);
            }
        }
        return new JsonResponse("Vous n'avez pas les droits nécessaires pour accéder à ce contenu.", Response::HTTP_FORBIDDEN);
    }

    /**
     * @param $roleMinimum
     * @param array $roles
     * @return bool
     */
    public function isAuthorized($roleMinimum, array $roles) : bool
    {
        foreach ($roles as $role){
            if (in_array($roleMinimum, $this->getRoles($role))){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $role
     * @return array
     */
    private function getRoles($role)
    {
        $hierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roleHierarchy = new RoleHierarchy($hierarchy);
        return $roleHierarchy->getReachableRoleNames([$role]);
    }
}

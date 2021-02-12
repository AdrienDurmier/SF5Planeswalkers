<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param Security $security
     * @return Response
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if($user){
            return $this->redirectToRoute('admin.index');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}

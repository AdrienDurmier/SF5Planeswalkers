<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin.index")
     * @return Response
     */
    public function index()
    {
        dd("Je suis dans l'index");
        return $this->render('admin/index.html.twig', [
        ]);
    }

}
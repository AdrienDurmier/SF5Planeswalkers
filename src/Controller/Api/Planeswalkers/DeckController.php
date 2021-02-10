<?php

namespace App\Controller\Api\Planeswalkers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GrantedService;
use App\Service\JWTInformations;
use App\Utils\Taches\TacheUtils;
use Exception;

/**
 * @Route("/")
 */
class DeckController extends AbstractController
{

}
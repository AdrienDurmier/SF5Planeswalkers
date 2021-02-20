<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

class DrawController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/draw", name="planeswalkers.play.action.draw", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @return JsonResponse
     */
    public function draw(Request $request, PublisherInterface $publisher)
    {
        $datas = $request->request->all();

        // Plublication à Mercure
        $topic = 'planeswalkers-game-'.$datas['game'];
        $datasMercure = json_encode([
            'action' =>  'draw',
            'player' =>  $datas['player'],
        ]);
        $update = new Update($topic, $datasMercure);
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}
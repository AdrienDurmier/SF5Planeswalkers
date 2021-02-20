<?php

namespace App\Controller\Admin\Planeswalkers\Play;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FightController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/games/fight/draw", name="planeswalkers.play.game.fight.draw", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @return JsonResponse
     */
    public function draw(Request $request, PublisherInterface $publisher)
    {
        $datas = $request->request->all();
        //$topic =  $this->generateUrl('planeswalkers.play.game.fight', [
        //    'id' => $datas['game']
        //], UrlGeneratorInterface::ABSOLUTE_URL);

        $topic = 'test';

        $datasMercure = json_encode([
            'action' =>  'draw',
            'player' =>  $datas['player'],
        ]);
        $update = new Update($topic, $datasMercure);
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}
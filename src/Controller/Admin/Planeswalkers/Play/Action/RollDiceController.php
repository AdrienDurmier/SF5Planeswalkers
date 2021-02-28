<?php

namespace App\Controller\Admin\Planeswalkers\Play\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use App\Entity\Planeswalkers\Play\Player;
use App\Utils\UserUtils;

class MessageController extends AbstractController
{
    /**
     * @Route("/planeswalkers/play/action/message/send", name="planeswalkers.play.action.message.send", methods="POST")
     * @param Request $request
     * @param PublisherInterface $publisher
     * @return JsonResponse
     */
    public function send(Request $request, PublisherInterface $publisher)
    {
        $datas = $request->request->all();
        $player = $this->getDoctrine()->getRepository(Player::class)->find($datas['player']);

        // Publication à Mercure
        $topic = 'planeswalkers-game-'.$player->getGame()->getId();
        $datasMercure = [
            'message' => $datas['content'],
            'author' => UserUtils::constructionUser($player->getUser()),
        ];

        $update = new Update($topic, json_encode($datasMercure));
        $publisher($update);

        return new JsonResponse($datasMercure);
    }

}
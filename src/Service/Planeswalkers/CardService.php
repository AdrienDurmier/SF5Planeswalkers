<?php

namespace App\Service\Planeswalkers;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Card;

class CardService
{
    private $em;

    /**
     * Api constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $response_card
     * @return Card
     */
    public function updateOrCreateCard($response_card) : Card
    {
        $card = $this->em->getRepository(Card::class)->findOneByIdScryfall($response_card->body->id);
        if ($card == null){
            $card = new Card();
        }
        $card->setIdScryfall($response_card->body->id);
        $card->setName($response_card->body->name);
        $card->setLayout($response_card->body->layout);
        $card->setImageUrisSmall($response_card->body->image_uris->small);
        $card->setImageUrisNormal($response_card->body->image_uris->normal);
        $card->setImageUrisLarge($response_card->body->image_uris->large);
        $card->setImageUrisPng($response_card->body->image_uris->png);
        $card->setImageUrisArtCrop($response_card->body->image_uris->art_crop);
        $card->setManaCost($response_card->body->mana_cost);
        $card->setCmc($response_card->body->cmc);
        $card->setTypeLine($response_card->body->type_line);
        $card->setRarity($response_card->body->rarity);
        $card->setColors($response_card->body->colors);

        $this->em->persist($card);

        return $card;
    }
}
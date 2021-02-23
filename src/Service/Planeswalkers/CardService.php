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

        // si c'est une carte double
        if(isset($response_card->body->card_faces)){
            $card->setName($response_card->body->card_faces[0]->name);
            if(isset($response_card->body->card_faces[0]->image_uris->small)){
                $card->setImageUrisSmall($response_card->body->card_faces[0]->image_uris->small);
            }
            if(isset($response_card->body->card_faces[0]->image_uris->normal)){
                $card->setImageUrisNormal($response_card->body->card_faces[0]->image_uris->normal);
            }
            if(isset($response_card->body->card_faces[0]->image_uris->large)){
                $card->setImageUrisLarge($response_card->body->card_faces[0]->image_uris->large);
            }
            if(isset($response_card->body->card_faces[0]->image_uris->png)){
                $card->setImageUrisPng($response_card->body->card_faces[0]->image_uris->png);
            }
            if(isset($response_card->body->card_faces[0]->image_uris->art_crop)){
                $card->setImageUrisArtCrop($response_card->body->card_faces[0]->image_uris->art_crop);
            }
            if(isset($response_card->body->card_faces[0]->mana_cost)){
                $card->setManaCost($response_card->body->card_faces[0]->mana_cost);
            }
            if(isset($response_card->body->card_faces[0]->cmc)){
                $card->setCmc($response_card->body->card_faces[0]->cmc);
            }
        }
        // si c'est une carte normale
        else{
            $card->setName($response_card->body->name);
            if(isset($response_card->body->image_uris->small)){
                $card->setImageUrisSmall($response_card->body->image_uris->small);
            }
            if(isset($response_card->body->image_uris->normal)){
                $card->setImageUrisNormal($response_card->body->image_uris->normal);
            }
            if(isset($response_card->body->image_uris->large)){
                $card->setImageUrisLarge($response_card->body->image_uris->large);
            }
            if(isset($response_card->body->image_uris->png)){
                $card->setImageUrisPng($response_card->body->image_uris->png);
            }
            if(isset($response_card->body->image_uris->art_crop)){
                $card->setImageUrisArtCrop($response_card->body->image_uris->art_crop);
            }
            if(isset($response_card->body->mana_cost)){
                $card->setManaCost($response_card->body->mana_cost);
            }
            if(isset($response_card->body->cmc)){
                $card->setCmc($response_card->body->cmc);
            }
        }

        if(isset($response_card->body->layout)){
            $card->setLayout($response_card->body->layout);
        }
        if(isset($response_card->body->type_line)){
            $card->setTypeLine($response_card->body->type_line);
        }
        if(isset($response_card->body->rarity)){
            $card->setRarity($response_card->body->rarity);
        }
        if(isset($response_card->body->colors)){
            $card->setColors($response_card->body->colors);
        }

        $this->em->persist($card);

        return $card;
    }
}
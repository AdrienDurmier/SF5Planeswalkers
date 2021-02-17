<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Planeswalkers\Card;

/**
 * @ORM\Table(name="planeswalkers_play_gamecard")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorMap({
 *  "library" = "GameCardLibrary",
 *  "battlefield" = "GameCardBattlefield"
 * })
 */
abstract class GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Card::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCard(): Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): void
    {
        $this->card = $card;
    }
}

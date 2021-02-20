<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_gamecardgraveyard")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardGraveyardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GameCardGraveyard extends GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Graveyard::class, inversedBy="gameCardsGraveyard")
     */
    private $graveyard;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    public function getGraveyard(): ?Graveyard
    {
        return $this->graveyard;
    }

    public function setGraveyard(?Graveyard $graveyard): self
    {
        $this->graveyard = $graveyard;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}

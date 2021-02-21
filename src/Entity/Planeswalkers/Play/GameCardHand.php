<?php

namespace App\Entity\Planeswalkers\Play;

use App\Entity\Test;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_gamecardhand")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardHandRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GameCardHand extends GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hand::class, inversedBy="gameCardsHand")
     */
    private $hand;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reveal;

    public function getHand(): ?Hand
    {
        return $this->hand;
    }

    public function setHand(?Hand $hand): self
    {
        $this->hand = $hand;

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

    public function getReveal(): ?bool
    {
        return $this->reveal;
    }

    public function setReveal(bool $reveal): self
    {
        $this->reveal = $reveal;

        return $this;
    }

}

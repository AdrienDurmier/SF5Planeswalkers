<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_gamecardlibrary")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardLibraryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GameCardLibrary extends GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Library::class, inversedBy="gameCardsLibrary")
     */
    private $library;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reveal;

    public function getLibrary(): ?Library
    {
        return $this->library;
    }

    public function setLibrary(?Library $library): self
    {
        $this->library = $library;

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

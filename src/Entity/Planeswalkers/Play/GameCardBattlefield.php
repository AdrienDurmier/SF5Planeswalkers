<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_gamecardbattlefield")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GameCardBattlefieldRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GameCardBattlefield extends GameCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=Battlefield::class, inversedBy="gameCardsBattlefield")
     */
    private $battlefield;

    /**
     * @ORM\Column(type="boolean")
     */
    private $faceDown;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter;

    /**
     * @ORM\Column(type="integer")
     */
    private $offsetX;

    /**
     * @ORM\Column(type="integer")
     */
    private $offsetY;

    public function getBattlefield(): ?Battlefield
    {
        return $this->battlefield;
    }

    public function setBattlefield(?Battlefield $battlefield): self
    {
        $this->battlefield = $battlefield;

        return $this;
    }

    public function getFaceDown(): ?bool
    {
        return $this->faceDown;
    }

    public function setFaceDown(bool $faceDown): self
    {
        $this->faceDown = $faceDown;

        return $this;
    }

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function setCounter(?int $counter): self
    {
        $this->counter = $counter;

        return $this;
    }

    public function getOffsetX(): ?int
    {
        return $this->offsetX;
    }

    public function setOffsetX(?int $offsetX): self
    {
        $this->offsetX = $offsetX;

        return $this;
    }

    public function getOffsetY(): ?int
    {
        return $this->offsetY;
    }

    public function setOffsetY(?int $offsetY): self
    {
        $this->offsetY = $offsetY;

        return $this;
    }

}

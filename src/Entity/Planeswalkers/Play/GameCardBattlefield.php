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
    public function __clone() {
        $this->offsetX = self::getOffsetX()+1;
        $this->offsetY = self::getOffsetY()+1;
    }

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $tapped;

    /**
     * @ORM\Column(type="boolean")
     */
    private $faceDown;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $counter;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $power;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $toughness;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

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

    public function getTapped(): ?bool
    {
        return $this->tapped;
    }

    public function setTapped(bool $tapped): self
    {
        $this->tapped = $tapped;

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

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(?int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getToughness(): ?int
    {
        return $this->toughness;
    }

    public function setToughness(?int $toughness): self
    {
        $this->toughness = $toughness;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

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

<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_sideboard")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\SideboardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Sideboard extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="sideboard", cascade={"persist", "remove"})
     */
    private $player;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getSideboard() !== $this) {
            $player->setSideboard($this);
        }
        $this->player = $player;
        return $this;
    }
}

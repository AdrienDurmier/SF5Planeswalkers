<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_commandzone")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\CommandZoneRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CommandZone extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="commandZone", cascade={"persist", "remove"})
     */
    private $player;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getCommandZone() !== $this) {
            $player->setCommandZone($this);
        }
        $this->player = $player;
        return $this;
    }
}

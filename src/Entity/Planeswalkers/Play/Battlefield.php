<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_battlefield")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\BattlefieldRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Battlefield extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="battlefield", cascade={"persist", "remove"})
     */
    private $player;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getBattlefield() !== $this) {
            $player->setBattlefield()($this);
        }
        $this->player = $player;
        return $this;
    }
}

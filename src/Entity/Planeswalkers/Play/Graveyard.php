<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_graveyard")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\GraveyardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Graveyard extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="graveyard", cascade={"persist", "remove"})
     */
    private $player;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getGraveyard() !== $this) {
            $player->setGraveyard($this);
        }
        $this->player = $player;
        return $this;
    }
}

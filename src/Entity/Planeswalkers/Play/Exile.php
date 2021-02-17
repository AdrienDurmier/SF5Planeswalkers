<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_exile")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\ExileRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Exile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, mappedBy="exile", cascade={"persist", "remove"})
     */
    private $player;

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): self
    {
        if ($player->getExile() !== $this) {
            $player->setExile($this);
        }
        $this->player = $player;
        return $this;
    }
}

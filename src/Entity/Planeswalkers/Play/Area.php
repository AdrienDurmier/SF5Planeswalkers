<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_area")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\AreaRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorMap({
 *  "commandzone"   = "CommandZone",
 *  "exile"         = "Exile",
 *  "graveyard"     = "Graveyard",
 *  "hand"          = "Hand",
 *  "library"       = "Library",
 *  "sideboard"     = "Sideboard"
 * })
 */
abstract class Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Play\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }



}

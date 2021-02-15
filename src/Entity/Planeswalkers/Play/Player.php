<?php

namespace App\Entity\Planeswalkers\Play;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_player")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\PlayerRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Player extends User
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
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Play\Team", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

}

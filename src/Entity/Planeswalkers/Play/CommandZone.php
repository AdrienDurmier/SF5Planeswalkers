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
}

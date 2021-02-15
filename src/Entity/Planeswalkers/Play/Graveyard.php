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
}

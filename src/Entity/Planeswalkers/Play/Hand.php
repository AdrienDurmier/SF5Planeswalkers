<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_hand")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\HandRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Hand extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
}

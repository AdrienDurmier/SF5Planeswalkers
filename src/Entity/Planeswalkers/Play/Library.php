<?php

namespace App\Entity\Planeswalkers\Play;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_play_library")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\Play\LibraryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Library extends Area
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
}

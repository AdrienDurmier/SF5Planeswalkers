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
}

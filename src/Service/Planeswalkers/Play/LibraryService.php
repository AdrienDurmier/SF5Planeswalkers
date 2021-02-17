<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Planeswalkers\Play\Library;
use App\Entity\Planeswalkers\Play\Player;

class LibraryService
{
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Player $player
     * @return Library
     */
    public function new(Player $player): Library
    {
        $library = new Library();
        $library->setPlayer($player);

        // Génération d'une librairie à partir du deck mélangé

        $this->em->persist($library);
        return $library;
    }
}
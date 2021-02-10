<?php

namespace App\DataFixtures\Planeswalkers;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Planeswalkers\Color;

class ColorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $color_w = new Color();
        $color_w->setAbbr("W");
        $color_w->setColor("White");
        $manager->persist($color_w);

        $color_u = new Color();
        $color_u->setAbbr("U");
        $color_u->setColor("Blue");
        $manager->persist($color_u);

        $color_b = new Color();
        $color_b->setAbbr("B");
        $color_b->setColor("Black");
        $manager->persist($color_b);

        $color_r = new Color();
        $color_r->setAbbr("R");
        $color_r->setColor("Red");
        $manager->persist($color_r);

        $color_g = new Color();
        $color_g->setAbbr("G");
        $color_g->setColor("Green");
        $manager->persist($color_g);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures\Planeswalkers;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Planeswalkers\ManaCost;

class ManaCostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manacost_1 = new ManaCost();
        $manacost_1->setSymbol('{T}');
        $manacost_1->setMana(false);
        $manacost_1->setCmc(null);
        $manacost_1->setDescription('Tap this permanent');
        $manager->persist($manacost_1);

        $manacost_2 = new ManaCost();
        $manacost_2->setSymbol('{Q}');
        $manacost_2->setMana(false);
        $manacost_2->setCmc(null);
        $manacost_2->setDescription('Untap this permanent');
        $manager->persist($manacost_2);

        $manacost_3 = new ManaCost();
        $manacost_3->setSymbol('{E}');
        $manacost_3->setMana(false);
        $manacost_3->setCmc(null);
        $manacost_3->setDescription('An energy counter');
        $manager->persist($manacost_3);

        $manacost_4 = new ManaCost();
        $manacost_4->setSymbol('{PW}');
        $manacost_4->setMana(false);
        $manacost_4->setCmc(null);
        $manacost_4->setDescription('Planeswalker');
        $manager->persist($manacost_4);

        $manacost_5 = new ManaCost();
        $manacost_5->setSymbol('{CHAOS}');
        $manacost_5->setMana(false);
        $manacost_5->setCmc(null);
        $manacost_5->setDescription('Chaos');
        $manager->persist($manacost_5);

        $manacost_6 = new ManaCost();
        $manacost_6->setSymbol('{X}');
        $manacost_6->setMana(true);
        $manacost_6->setCmc('0.0');
        $manacost_6->setDescription('X generic mana');
        $manager->persist($manacost_6);

        $manacost_7 = new ManaCost();
        $manacost_7->setSymbol('{Y}');
        $manacost_7->setMana(true);
        $manacost_7->setCmc('0.0');
        $manacost_7->setDescription('Y generic mana');
        $manager->persist($manacost_7);

        $manacost_8 = new ManaCost();
        $manacost_8->setSymbol('{Z}');
        $manacost_8->setMana(true);
        $manacost_8->setCmc('0.0');
        $manacost_8->setDescription('Z generic mana');
        $manager->persist($manacost_8);

        $manacost_9 = new ManaCost();
        $manacost_9->setSymbol('{0}');
        $manacost_9->setMana(true);
        $manacost_9->setCmc('0.0');
        $manacost_9->setDescription('Zero mana');
        $manager->persist($manacost_9);

        $manacost_10 = new ManaCost();
        $manacost_10->setSymbol('{½}');
        $manacost_10->setMana(true);
        $manacost_10->setCmc('0.5');
        $manacost_10->setDescription('One-half generic mana');
        $manager->persist($manacost_10);

        $manacost_11 = new ManaCost();
        $manacost_11->setSymbol('{1}');
        $manacost_11->setMana(true);
        $manacost_11->setCmc('1.0');
        $manacost_11->setDescription('One generic mana');
        $manager->persist($manacost_11);

        $manacost_12 = new ManaCost();
        $manacost_12->setSymbol('{2}');
        $manacost_12->setMana(true);
        $manacost_12->setCmc('2.0');
        $manacost_12->setDescription('Two generic mana');
        $manager->persist($manacost_12);

        $manacost_13 = new ManaCost();
        $manacost_13->setSymbol('{3}');
        $manacost_13->setMana(true);
        $manacost_13->setCmc('3.0');
        $manacost_13->setDescription('Three generic mana');
        $manager->persist($manacost_13);

        $manacost_14 = new ManaCost();
        $manacost_14->setSymbol('{4}');
        $manacost_14->setMana(true);
        $manacost_14->setCmc('4.0');
        $manacost_14->setDescription('Four generic mana');
        $manager->persist($manacost_14);

        $manacost_15 = new ManaCost();
        $manacost_15->setSymbol('{5}');
        $manacost_15->setMana(true);
        $manacost_15->setCmc('5.0');
        $manacost_15->setDescription('Five generic mana');
        $manager->persist($manacost_15);

        $manacost_16 = new ManaCost();
        $manacost_16->setSymbol('{6}');
        $manacost_16->setMana(true);
        $manacost_16->setCmc('6.0');
        $manacost_16->setDescription('Six generic mana');
        $manager->persist($manacost_16);

        $manacost_17 = new ManaCost();
        $manacost_17->setSymbol('{7}');
        $manacost_17->setMana(true);
        $manacost_17->setCmc('7.0');
        $manacost_17->setDescription('Seven generic mana');
        $manager->persist($manacost_17);

        $manacost_18 = new ManaCost();
        $manacost_18->setSymbol('{8}');
        $manacost_18->setMana(true);
        $manacost_18->setCmc('8.0');
        $manacost_18->setDescription('Eight generic mana');
        $manager->persist($manacost_18);

        $manacost_19 = new ManaCost();
        $manacost_19->setSymbol('{9}');
        $manacost_19->setMana(true);
        $manacost_19->setCmc('9.0');
        $manacost_19->setDescription('Nine generic mana');
        $manager->persist($manacost_19);

        $manacost_20 = new ManaCost();
        $manacost_20->setSymbol('{10}');
        $manacost_20->setMana(true);
        $manacost_20->setCmc('10.0');
        $manacost_20->setDescription('Ten generic mana');
        $manager->persist($manacost_20);

        $manacost_21 = new ManaCost();
        $manacost_21->setSymbol('{11}');
        $manacost_21->setMana(true);
        $manacost_21->setCmc('11.0');
        $manacost_21->setDescription('Eleven generic mana');
        $manager->persist($manacost_21);

        $manacost_22 = new ManaCost();
        $manacost_22->setSymbol('{12}');
        $manacost_22->setMana(true);
        $manacost_22->setCmc('12.0');
        $manacost_22->setDescription('Twelve generic mana');
        $manager->persist($manacost_22);

        $manacost_23 = new ManaCost();
        $manacost_23->setSymbol('{13}');
        $manacost_23->setMana(true);
        $manacost_23->setCmc('13.0');
        $manacost_23->setDescription('Thirteen generic mana');
        $manager->persist($manacost_23);

        $manacost_24 = new ManaCost();
        $manacost_24->setSymbol('{14}');
        $manacost_24->setMana(true);
        $manacost_24->setCmc('14.0');
        $manacost_24->setDescription('Fourteen generic mana');
        $manager->persist($manacost_24);

        $manacost_25 = new ManaCost();
        $manacost_25->setSymbol('{15}');
        $manacost_25->setMana(true);
        $manacost_25->setCmc('15.0');
        $manacost_25->setDescription('Fiveteen generic mana');
        $manager->persist($manacost_25);

        $manacost_26 = new ManaCost();
        $manacost_26->setSymbol('{16}');
        $manacost_26->setMana(true);
        $manacost_26->setCmc('16.0');
        $manacost_26->setDescription('Sixteen generic mana');
        $manager->persist($manacost_26);

        $manacost_27 = new ManaCost();
        $manacost_27->setSymbol('{17}');
        $manacost_27->setMana(true);
        $manacost_27->setCmc('17.0');
        $manacost_27->setDescription('Seventeen generic mana');
        $manager->persist($manacost_27);

        $manacost_28 = new ManaCost();
        $manacost_28->setSymbol('{18}');
        $manacost_28->setMana(true);
        $manacost_28->setCmc('18.0');
        $manacost_28->setDescription('Eighteen generic mana');
        $manager->persist($manacost_28);

        $manacost_29 = new ManaCost();
        $manacost_29->setSymbol('{19}');
        $manacost_29->setMana(true);
        $manacost_29->setCmc('19.0');
        $manacost_29->setDescription('Nineteen generic mana');
        $manager->persist($manacost_29);

        $manacost_30 = new ManaCost();
        $manacost_30->setSymbol('{20}');
        $manacost_30->setMana(true);
        $manacost_30->setCmc('20.0');
        $manacost_30->setDescription('Twenty generic mana');
        $manager->persist($manacost_30);

        $manacost_100 = new ManaCost();
        $manacost_100->setSymbol('{100}');
        $manacost_100->setMana(true);
        $manacost_100->setCmc('100.0');
        $manacost_100->setDescription('One hundred generic mana');
        $manager->persist($manacost_100);

        $manacost_1000000 = new ManaCost();
        $manacost_1000000->setSymbol('{1000000}');
        $manacost_1000000->setMana(true);
        $manacost_1000000->setCmc('1000000.0');
        $manacost_1000000->setDescription('One million generic mana');
        $manager->persist($manacost_1000000);

        $manacost_infinity = new ManaCost();
        $manacost_infinity->setSymbol('{∞}');
        $manacost_infinity->setMana(true);
        $manacost_infinity->setCmc('Infinity');
        $manacost_infinity->setDescription('Infinite generic mana');
        $manager->persist($manacost_infinity);

        $manacost_WU = new ManaCost();
        $manacost_WU->setSymbol('{W/U}');
        $manacost_WU->setMana(true);
        $manacost_WU->setCmc('1.0');
        $manacost_WU->setDescription('One white or blue mana');
        $manager->persist($manacost_WU);

        $manacost_WB = new ManaCost();
        $manacost_WB->setSymbol('{W/B}');
        $manacost_WB->setMana(true);
        $manacost_WB->setCmc('1.0');
        $manacost_WB->setDescription('One white or black mana');
        $manager->persist($manacost_WB);

        $manacost_BR = new ManaCost();
        $manacost_BR->setSymbol('{B/R}');
        $manacost_BR->setMana(true);
        $manacost_BR->setCmc('1.0');
        $manacost_BR->setDescription('One black or red mana');
        $manager->persist($manacost_BR);

        $manacost_BG = new ManaCost();
        $manacost_BG->setSymbol('{B/G}');
        $manacost_BG->setMana(true);
        $manacost_BG->setCmc('1.0');
        $manacost_BG->setDescription('One black or green mana');
        $manager->persist($manacost_BG);

        $manacost_UB = new ManaCost();
        $manacost_UB->setSymbol('{U/B}');
        $manacost_UB->setMana(true);
        $manacost_UB->setCmc('1.0');
        $manacost_UB->setDescription('One blue or black mana');
        $manager->persist($manacost_UB);

        $manacost_UR = new ManaCost();
        $manacost_UR->setSymbol('{U/R}');
        $manacost_UR->setMana(true);
        $manacost_UR->setCmc('1.0');
        $manacost_UR->setDescription('One blue or red mana');
        $manager->persist($manacost_UR);

        $manacost_RG = new ManaCost();
        $manacost_RG->setSymbol('{R/G}');
        $manacost_RG->setMana(true);
        $manacost_RG->setCmc('1.0');
        $manacost_RG->setDescription('One red or green mana');
        $manager->persist($manacost_RG);

        $manacost_RW = new ManaCost();
        $manacost_RW->setSymbol('{R/W}');
        $manacost_RW->setMana(true);
        $manacost_RW->setCmc('1.0');
        $manacost_RW->setDescription('One red or white mana');
        $manager->persist($manacost_RW);

        $manacost_GW = new ManaCost();
        $manacost_GW->setSymbol('{G/W}');
        $manacost_GW->setMana(true);
        $manacost_GW->setCmc('1.0');
        $manacost_GW->setDescription('One green or white mana');
        $manager->persist($manacost_GW);

        $manacost_GU = new ManaCost();
        $manacost_GU->setSymbol('{G/U}');
        $manacost_GU->setMana(true);
        $manacost_GU->setCmc('1.0');
        $manacost_GU->setDescription('One green or blue mana');
        $manager->persist($manacost_GU);

        $manacost_2W = new ManaCost();
        $manacost_2W->setSymbol('{2/W}');
        $manacost_2W->setMana(true);
        $manacost_2W->setCmc('2.0');
        $manacost_2W->setDescription('Two generic mana or one white mana');
        $manager->persist($manacost_2W);

        $manacost_2U = new ManaCost();
        $manacost_2U->setSymbol('{2/U}');
        $manacost_2U->setMana(true);
        $manacost_2U->setCmc('2.0');
        $manacost_2U->setDescription('Two generic mana or one blue mana');
        $manager->persist($manacost_2U);

        $manacost_2B = new ManaCost();
        $manacost_2B->setSymbol('{2/B}');
        $manacost_2B->setMana(true);
        $manacost_2B->setCmc('2.0');
        $manacost_2B->setDescription('Two generic mana or one black mana');
        $manager->persist($manacost_2B);

        $manacost_2R = new ManaCost();
        $manacost_2R->setSymbol('{2/R}');
        $manacost_2R->setMana(true);
        $manacost_2R->setCmc('2.0');
        $manacost_2R->setDescription('Two generic mana or one red mana');
        $manager->persist($manacost_2R);

        $manacost_2G = new ManaCost();
        $manacost_2G->setSymbol('{2/G}');
        $manacost_2G->setMana(true);
        $manacost_2G->setCmc('2.0');
        $manacost_2G->setDescription('Two generic mana or one green mana');
        $manager->persist($manacost_2G);

        $manacost_P = new ManaCost();
        $manacost_P->setSymbol('{P}');
        $manacost_P->setMana(true);
        $manacost_P->setCmc('1.0');
        $manacost_P->setDescription('One colored mana or two life');
        $manager->persist($manacost_P);

        $manacost_WP = new ManaCost();
        $manacost_WP->setSymbol('{W/P}');
        $manacost_WP->setMana(true);
        $manacost_WP->setCmc('1.0');
        $manacost_WP->setDescription('One white mana or two life');
        $manager->persist($manacost_WP);

        $manacost_UP = new ManaCost();
        $manacost_UP->setSymbol('{U/P}');
        $manacost_UP->setMana(true);
        $manacost_UP->setCmc('1.0');
        $manacost_UP->setDescription('One blue mana or two life');
        $manager->persist($manacost_UP);

        $manacost_BP = new ManaCost();
        $manacost_BP->setSymbol('{B/P}');
        $manacost_BP->setMana(true);
        $manacost_BP->setCmc('1.0');
        $manacost_BP->setDescription('One black mana or two life');
        $manager->persist($manacost_BP);

        $manacost_RP = new ManaCost();
        $manacost_RP->setSymbol('{R/P}');
        $manacost_RP->setMana(true);
        $manacost_RP->setCmc('1.0');
        $manacost_RP->setDescription('One red mana or two life');
        $manager->persist($manacost_RP);

        $manacost_GP = new ManaCost();
        $manacost_GP->setSymbol('{G/P}');
        $manacost_GP->setMana(true);
        $manacost_GP->setCmc('1.0');
        $manacost_GP->setDescription('One green mana or two life');
        $manager->persist($manacost_GP);

        $manacost_HW = new ManaCost();
        $manacost_HW->setSymbol('{HW}');
        $manacost_HW->setMana(true);
        $manacost_HW->setCmc('0.5');
        $manacost_HW->setDescription('One-half white mana');
        $manager->persist($manacost_HW);

        $manacost_HR = new ManaCost();
        $manacost_HR->setSymbol('{HR}');
        $manacost_HR->setMana(true);
        $manacost_HR->setCmc('0.5');
        $manacost_HR->setDescription('One-half red mana');
        $manager->persist($manacost_HR);

        $manacost_W = new ManaCost();
        $manacost_W->setSymbol('{W}');
        $manacost_W->setMana(true);
        $manacost_W->setCmc('1.0');
        $manacost_W->setDescription('One white mana');
        $manager->persist($manacost_W);

        $manacost_U = new ManaCost();
        $manacost_U->setSymbol('{U}');
        $manacost_U->setMana(true);
        $manacost_U->setCmc('1.0');
        $manacost_U->setDescription('One blue mana');
        $manager->persist($manacost_U);

        $manacost_B = new ManaCost();
        $manacost_B->setSymbol('{B}');
        $manacost_B->setMana(true);
        $manacost_B->setCmc('1.0');
        $manacost_B->setDescription('One black mana');
        $manager->persist($manacost_B);

        $manacost_R = new ManaCost();
        $manacost_R->setSymbol('{R}');
        $manacost_R->setMana(true);
        $manacost_R->setCmc('1.0');
        $manacost_R->setDescription('One red mana');
        $manager->persist($manacost_R);

        $manacost_G = new ManaCost();
        $manacost_G->setSymbol('{G}');
        $manacost_G->setMana(true);
        $manacost_G->setCmc('1.0');
        $manacost_G->setDescription('One green mana');
        $manager->persist($manacost_G);

        $manacost_c = new ManaCost();
        $manacost_c->setSymbol('{C}');
        $manacost_c->setMana(true);
        $manacost_c->setCmc('1.0');
        $manacost_c->setDescription('One colorless mana');
        $manager->persist($manacost_c);

        $manacost_S = new ManaCost();
        $manacost_S->setSymbol('{S}');
        $manacost_S->setMana(true);
        $manacost_S->setCmc('1.0');
        $manacost_S->setDescription('One snow mana');
        $manager->persist($manacost_S);

        $manager->flush();
    }
}

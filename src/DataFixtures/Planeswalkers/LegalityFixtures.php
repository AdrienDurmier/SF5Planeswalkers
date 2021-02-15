<?php

namespace App\DataFixtures\Planeswalkers;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Planeswalkers\Legality;

class LegalityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $standard = new Legality();
        $standard->setCle('standard');
        $standard->setTitle("Standard");
        $standard->setContent("The Standard format is continually one of the most popular formats in the constructed deck tournament scene. It is the format most commonly found at Friday Night Magic tournaments, played weekly at many hobby shops. Standard's former name was \"Type 2\". This format generally consists of the most recent five to eight standard sets(expansion /core set) releases. The release of the standard set in Autumn (usually the first Friday in October) triggers a rotation; the new set becomes Standard legal, and the oldest four sets rotate out. (The previous rule was using three to four recent \"Block\" releases plus any core sets released between the older set of the block and the first set that would make oldest two blocks rotated out).");
        $manager->persist($standard);

        $future = new Legality();
        $future->setCle('future');
        $future->setTitle("Future");
        $future->setContent("Modern is a constructed format created by Wizards of the Coast in the Spring of 2011 as a response to the increasing popularity of the Legacy format which, although popular, proved difficult to access due to the high price of staple cards, as well as dissatisfaction with the Extended format of the time. Wizards of the Coast is unwilling to reprint some of these cards due to the Reserved List, a list of cards Wizards promised never to reprint in order to protect card prices. Therefore, Modern was designed as a new format that would exclude all cards on the Reserved List, allowing the format to be more accessible than Legacy. Modern allows cards from all core sets beginning with the 8th Edition core set and all expansions printed afterwards. The 8th Edition core set was when Magic cards began to be printed in modern card frames, and this is where the name for the format is derived. Wizards believed this cutoff would have the advantage of giving a visual cue as to which cards are legal in the Modern format. In the regulation change in June 2019, set that is neither a Core nor Expansion sets that Wizard deemed modern-worthy is also allowed, as to cope with the creation of Modern Horizons, which Wizards believed some cards would be good in modern, but would be too powerful to be introduced in Standard (as previous modern sets were all Standard Legal for at least a year). The format maintains its own banned list. Cards are banned on the basis of their power level, as in all constructed formats outside Vintage. The first official tournament to be held using the format was Pro Tour Philadelphia in September 2011. The first Grand Prix to use the format was Grand Prix Lincoln in February 2012.");
        $manager->persist($future);

        $historic = new Legality();
        $historic->setCle('historic');
        $historic->setTitle("Historic");
        $historic->setContent("Historic was officially announced as a format in a video and accompanying article on June 27, 2019. It was created as \"an MTG Arena-first format\" as way for players to use cards that are available on Arena, but are not currently legal in the standard format due to rotation, ban, or other reasons. The three ways that cards join the historic format are: appearing in a standard-legal set, appearing in supplemental sets released on Arena (the non-standard set Jumpstart being an example), or added via 15-20 card sets called Historic Anthologies. Like other constructed formats, Historic maintains its own banned list. The Historic format was featured as the format of the Pro Tour event, The Mythic Invitational taking place September 10–13, 2020");
        $manager->persist($historic);

        $gladiator = new Legality();
        $gladiator->setCle('gladiator');
        $gladiator->setTitle("Gladiator");
        $gladiator->setContent("");
        $manager->persist($gladiator);

        $pioneer = new Legality();
        $pioneer->setCle('pioneer');
        $pioneer->setTitle("Pioneer");
        $pioneer->setContent("Pioneer was created in the Autumn of 2019. The rules for card legality are similar to modern, consisting of cards that were released into the Standard format starting with a given expansion set. For Pioneer, the first legal expansion set is Return to Ravnica. The cutoff was made as it is the first expansion released after Modern was made an official format. Like other constructed formats, Pioneer maintains its own banned list");
        $manager->persist($pioneer);

        $modern = new Legality();
        $modern->setCle('modern');
        $modern->setTitle("Modern");
        $modern->setContent("");
        $manager->persist($modern);

        $legacy = new Legality();
        $legacy->setCle('legacy');
        $legacy->setTitle("Legacy");
        $legacy->setContent("Legacy allows cards from all sets (known as an \"Eternal\" format). It maintains a ban list based on power level reasons. The format evolved from Type 1.5, which allowed cards from all sets and maintained a banned list corresponding to Vintage: all cards banned or restricted in the old Type 1 were banned in Type 1.5. The modern Legacy format began in 2006, as the DCI separated Legacy's banned list from Vintage and banned many new cards to reduce the power level of the format. Wizards has supported the format with Grand Prix events and the release of preconstructed Legacy decks on Magic Online in November 2010. The first Legacy Grand Prix was Grand Prix Philadelphia in 2005");
        $manager->persist($legacy);

        $pauper = new Legality();
        $pauper->setCle('pauper');
        $pauper->setTitle("Pauper");
        $pauper->setContent("Pauper is a Magic variant in which card legality is based on rarity. Any cards that either have been printed as common in paper format or appeared as common in a Magic Online set at least once are legal. The format was originally an official format exclusive for Magic Online on December 1, 2008, using Magic Online's own rarity list for pre-7th Edition cards appearing in the Master’s Edition series, though some paper Pauper events have been run on that list. After it became a sanctioned format on June 2019, all paper and digital set were put into consideration instead. ");
        $manager->persist($pauper);

        $vintage = new Legality();
        $vintage->setCle('vintage');
        $vintage->setTitle("Vintage");
        $vintage->setContent("The Vintage format, formerly known as Type 1, is another Eternal constructed format. Vintage maintains a small banned list and a larger restricted list. Unlike in the other formats, the DCI does not ban cards in Vintage for power level reasons except for Lurrus of the Dream-Den. Rather, cards banned in Vintage are those that either involve ante, manual dexterity (Falling Star, Chaos Orb), or could hinder event rundown (Shahrazad and Conspiracy cards). Cards that raise power level concerns are instead restricted to a maximum of one copy per deck.[23] Vintage is currently the only format in which cards are restricted. Because of the expense in acquiring the old cards to play competitive Vintage, many Vintage tournaments are unsanctioned and permit players to use a certain number of proxy cards. These are treated as stand-ins of existing cards and are not normally permitted in tournaments sanctioned by the DCI.");
        $manager->persist($vintage);

        $penny = new Legality();
        $penny->setCle('penny');
        $penny->setTitle("Penny");
        $penny->setContent("");
        $manager->persist($penny);

        $commander = new Legality();
        $commander->setCle('commander');
        $commander->setTitle("Commander");
        $commander->setContent("The Commander format, also known as Elder Dragon Highlander (EDH), uses 100 card singleton decks (no duplicates except basic lands), a starting life total of 40, and features a \"Commander\" or \"General\".[57][58] The Commander must be a legendary creature (with some exceptional cases, namely Planeswalkers with text that specifically states they can be your Commander), and all cards in the deck can only have mana symbols on them from the Commander's colors. The Commander is not included in one's library; it is visible to all players in the \"command\" zone and can be played as if it was in one's hand. Whenever it would be put into a graveyard or exiled, the Commander's owner may choose to put it back into the \"command\" zone instead. A Commander that is cast from the command zone costs an additional 2 generic mana for every other time that Commander has been cast from the command zone that game- this is referred to as \"Commander tax\" (for example, a 3 mana Commander would cost 3 mana the first time it is cast, 5 mana the 2nd time it is cast, 7 mana the 3rd time, etc.). If a player takes 21 combat damage from any one commander, that player loses the game regardless of life total (a rule to bring games to an eventual halt and somewhat keep lifegain in check). The format has its own official banned list. Commander is usually a multiplayer format, although a special separate banned list exists for \"Duel Commander\" balanced for 1v1 matches on Magic Online. The format started as Elder Dragon Highlander and originally assumed that the five three-color Elder Dragons from the Legends set such as Nicol Bolas or Chromium were the only generals allowed.[2] It proved one of the most popular variants of Magic. Wizards of Coast decided to officially support the variant with the creation of the Commander product, preconstructed decks designed for playing the format that include both new cards and reprints.[57] The first set of Commander decks were released in 2011, and decks are continuing to be released as of 2020.");
        $manager->persist($commander);

        $brawl = new Legality();
        $brawl->setCle('brawl');
        $brawl->setTitle("Brawl");
        $brawl->setContent("Brawl format is a variant format of the Commander developed by WotC staff Gerritt Turner. This format is targeted at players who want to play commander but with a Standard Cardpool. Most rules are similar to commander, however, the deck size is 60 and any planeswalkers can also be a commander, life total is 25-30(depends on number of players) and the commander damage rule is not applied. The format used Standard-legal sets. It was supported by Magic Online quickly after its introduction.");
        $manager->persist($brawl);

        $duel = new Legality();
        $duel->setCle('duel');
        $duel->setTitle("Duel");
        $duel->setContent("");
        $manager->persist($duel);

        $oldschool = new Legality();
        $oldschool->setCle('oldschool');
        $oldschool->setTitle("Oldschool");
        $oldschool->setContent("");
        $manager->persist($oldschool);

        $premodern = new Legality();
        $premodern->setCle('premodern');
        $premodern->setTitle("Premodern");
        $premodern->setContent("");
        $manager->persist($premodern);

        $manager->flush();
    }
}
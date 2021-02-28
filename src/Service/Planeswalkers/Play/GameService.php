<?php

namespace App\Service\Planeswalkers\Play;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Planeswalkers\Deck;
use App\Entity\Planeswalkers\Legality;
use App\Entity\Planeswalkers\Play\Game;
use App\Entity\User;

class GameService
{
    private $em;
    private $playerService;

    /**
     * @param EntityManagerInterface $em
     * @param PlayerService $playerService
     */
    public function __construct(EntityManagerInterface $em, PlayerService $playerService)
    {
        $this->em = $em;
        $this->playerService = $playerService;
    }

    /**
     * New Game
     *
     * @param array $datas
     * @param User $user
     * @return Game
     * @throws Exception
     */
    public function new(array $datas, User $user): Game
    {
        $deck = $this->em->getRepository(Deck::class)->find($datas['deck']);
        $legality = $this->em->getRepository(Legality::class)->find($datas['format']);

        $game = new Game();

        // Author
        $game->setAuthor($user);

        // Legality
        $game->setLegality($legality);

        // Entitées liées à game
        $this->em->persist($game);
        // Players
        $player = $this->playerService->new($game, $user, $deck);
        $game->addPlayer($player);

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $game;
    }

    /**
     * Join a game
     *
     * @param array $datas
     * @param User $user
     * @return Game
     * @throws Exception
     */
    public function join(array $datas, User $user): Game
    {
        $game = $this->em->getRepository(Game::class)->find($datas['game']);
        $deck = $this->em->getRepository(Deck::class)->find($datas['deck']);

        // Players
        $player = $this->playerService->new($game, $user, $deck);
        $game->addPlayer($player);

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $game;
    }

    /**
     * Change step of the game
     *
     * @param array $datas
     * @return array
     */
    public function step(array $datas): array
    {
        $game = $this->em->getRepository(Game::class)->find($datas['game']);

        $step = [];
        switch ($datas['step']){
            case Game::STEP_BEGIN_UNTAP:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'beginning',
                    'step'  => 'untap',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/anticlockwise-rotation.svg',
                ];
                break;
            case Game::STEP_BEGIN_UPKEEP:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'beginning',
                    'step'  => 'upkeep',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/sunrise.svg',
                ];
                break;
            case Game::STEP_BEGIN_DRAW:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'beginning',
                    'step'  => 'draw',
                    'picto' => '/images/planeswalkers/game-icons-net/quoting/card-play.svg',
                ];
                break;
            case Game::STEP_MAIN_PRECOMBAT:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'precombat main',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/player-time.svg',
                ];
                break;
            case Game::STEP_COMBAT_BEGINNING:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'combat',
                    'step'  => 'beginning of combat',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/truce.svg',
                ];
                break;
            case Game::STEP_COMBAT_ATTACKERS:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'combat',
                    'step'  => 'declare attackers',
                    'picto' => '/images/planeswalkers/game-icons-net/cathelineau/swordman.svg',
                ];
                break;
            case Game::STEP_COMBAT_BLOCKERS:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'combat',
                    'step'  => 'declare blockers',
                    'picto' => '/images/planeswalkers/game-icons-net/lorc/arrows-shield.svg',
                ];
                break;
            case Game::STEP_COMBAT_DAMAGE:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'combat',
                    'step'  => 'damage',
                    'picto' => '/images/planeswalkers/game-icons-net/zeromancer/heart-minus.svg',
                ];
                break;
            case Game::STEP_COMBAT_END:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'combat',
                    'step'  => 'end of combat',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/anticlockwise-rotation.svg',
                ];
                break;
            case Game::STEP_MAIN_POSTCOMBAT:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'postcombat main',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/player-time.svg',
                ];
                break;
            case Game::STEP_END_TURN:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'end',
                    'step'  => 'end of turn',
                    'picto' => '/images/planeswalkers/game-icons-net/skoll/halt.svg',
                ];
                break;
            case Game::STEP_END_CLEAN:
                $game->setStep($datas['step']);
                $step = [
                    'phase' => 'end',
                    'step'  => 'cleanup',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/large-paint-brush.svg',
                ];
                break;
            case Game::STEP_NEXT:
                $game->setStep(0);
                $step = [
                    'phase' => 'beginning',
                    'step'  => 'untap',
                    'picto' => '/images/planeswalkers/game-icons-net/delapouite/anticlockwise-rotation.svg',
                ];
                // Dernière étape alors on passe au tour suivant
                $game->setTurn($game->getTurn()+1);
                break;
        }
        $step['turn'] = $game->getTurn();

        // Save
        $this->em->persist($game);
        $this->em->flush();

        return $step;
    }
}
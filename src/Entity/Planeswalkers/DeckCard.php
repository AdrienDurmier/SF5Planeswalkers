<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_deck_card")
 * @ORM\Entity(repositoryClass="App\Repository\Planeswalkers\DeckCardRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class DeckCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite_reserve;

    /**
     * @var DeckCard
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Deck")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deck;

    /**
     * @var DeckCard
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Card")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantiteReserve(): ?int
    {
        return $this->quantite_reserve;
    }

    public function setQuantiteReserve(?int $quantite_reserve): self
    {
        $this->quantite_reserve = $quantite_reserve;

        return $this;
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): void
    {
        $this->deck = $deck;
    }

    public function getCard(): Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): void
    {
        $this->card = $card;
    }

}

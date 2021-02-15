<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Table(name="planeswalkers_deck")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\DeckRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Deck
{
    public function __construct() {
        $this->created = new \Datetime();
        $this->updated = new \Datetime();
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\DeckCard", mappedBy="deck", cascade={"persist", "remove"})
     */
    private $cards;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate() {
        $this->setUpdated(new \Datetime());
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function addCard(DeckCard $card)
    {
        $this->cards[] = $card;
    }

    public function removeCard(DeckCard $card)
    {
        $this->cards->removeElement($card);
    }

    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Méthode permettant de compter le nombre total de card principal dans le deck
     * @return int
     */
    public function countCards(){
        $total = 0;
        foreach($this->cards as $deck_card){
            $total += $deck_card->getQuantite();
        }
        return $total;
    }

    /**
     * Méthode permettant de compter le nombre total de card en réserve
     * @return int
     */
    public function countReserve(){
        $total = 0;
        foreach($this->cards as $deck_card){
            $total += $deck_card->getQuantiteReserve();
        }
        return $total;
    }

    /**
     * Méthode permettant d'analyser la couleur d'un deck
     * @return int
     */
    public function colorsDeck(){
        $colors = array();
        foreach($this->cards as $deck_card){
            foreach($deck_card->getCard()->getColors() as $color){
                if (!in_array($color, $colors)) {
                    $colors[] = $color;
                }
            }
        }
        return $colors;
    }

    /**
     * Méthode de générer la courbe de mana
     * @return array
     */
    public function getManaCurve(){
        $mana_curve = array(
            '0' => 0, '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0,
            '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0, '10+' => 0,
        );
        foreach($this->cards as $deck_card){
            // On ne compte pas les terrains
            if(strpos(strtolower($deck_card->getCard()->getTypeLine()), 'land')!== false) {
            }else{
                // Si plus de 10 mana on le regroupe dans la même courbe
                if($deck_card->getCard()->getCmc() > 10){
                    $mana_curve['10+'] += $deck_card->getQuantite();
                }
                // Cas classique
                else{
                    $mana_curve[$deck_card->getCard()->getCmc()] += $deck_card->getQuantite();
                }
            }
        }
        return $mana_curve;
    }

    /**
     * Analyse de la rareté des cards de ce deck
     * @return array
     */
    public function getRarity(){
        $rarity = array(
            'common' => 0,
            'uncommon' => 0,
            'rare' => 0,
            'mythic' => 0,
        );
        foreach($this->cards as $deck_card){
            $rarity[$deck_card->getCard()->getRarity()] += $deck_card->getQuantite();
        }
        return $rarity;
    }

    /**
     * Génération de la bibliothèque
     * @return array
     */
    public function getBibliotheque(){
        $bibliotheque = array();
        $n=0;foreach ($this->getCards() as $deck_card){
            for ($i = 1; $i <= $deck_card->getQuantite(); $i++){
                $bibliotheque[$n]['name'] = $deck_card->getCard()->getName();
                $bibliotheque[$n]['image'] = $deck_card->getCard()->getImageUrisNormal();
                $bibliotheque[$n]['thumb'] = $deck_card->getCard()->getImageUrisSmall();
                $n++;
            }
        }
        shuffle($bibliotheque);
        return $bibliotheque;
    }

    /**
     * Génération de la main de départ
     * @return array
     */
    public function getMainDepart(){
        $main_depart = array_slice($this->getBibliotheque(), 0, 7);

        return $main_depart;
    }

}

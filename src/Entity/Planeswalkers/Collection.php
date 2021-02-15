<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Table(name="planeswalkers_collection")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\CollectionRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Collection
{
    public function __construct() {
        $this->created = new \Datetime();
        $this->updated = new \Datetime();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\CollectionCard", mappedBy="collection", cascade={"persist", "remove"})
     */
    private $cards;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function addCard(CollectionCard $card)
    {
        $this->cards[] = $card;
    }

    public function removeCard(CollectionCard $card)
    {
        $this->cards->removeElement($card);
    }

    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Méthode permettant de compter le nombre total de card principal dans le collection
     * @return int
     */
    public function countCards(){
        $total = 0;
        foreach($this->cards as $collection_card){
            $total += $collection_card->getQuantite();
        }
        return $total;
    }

    /**
     * Analyse de la rareté des cards de cette collection
     * @return array
     */
    public function getRarity(){
        $rarity = array(
            'common' => 0,
            'uncommon' => 0,
            'rare' => 0,
            'mythic' => 0,
        );
        foreach($this->cards as $collection_card){
            $rarity[$collection_card->getCard()->getRarity()] += $collection_card->getQuantite();
        }
        return $rarity;
    }

}

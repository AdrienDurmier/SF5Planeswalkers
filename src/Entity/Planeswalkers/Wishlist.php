<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Table(name="planeswalkers_wishlist")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\WishlistRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Wishlist
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
     * @ORM\OneToMany(targetEntity="App\Entity\Planeswalkers\WishlistCard", mappedBy="wishlist", cascade={"persist", "remove"})
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

    public function addCard(WishlistCard $card)
    {
        $this->cards[] = $card;
    }

    public function removeCard(WishlistCard $card)
    {
        $this->cards->removeElement($card);
    }

    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Méthode permettant de compter le nombre total de carte
     * @return int
     */
    public function countCards(){
        $total = 0;
        foreach($this->cards as $deck_card){
            $total += $deck_card->getQuantite();
        }
        return $total;
    }

}

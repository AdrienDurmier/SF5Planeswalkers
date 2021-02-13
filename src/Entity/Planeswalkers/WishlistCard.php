<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_wishlist_card")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\WishlistCardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class WishlistCard
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
     * @var WishlistCard
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Wishlist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wishlist;

    /**
     * @var WishlistCard
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

    public function getWishlist(): Wishlist
    {
        return $this->wishlist;
    }

    public function setWishlist(?Wishlist $wishlist): void
    {
        $this->wishlist = $wishlist;
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

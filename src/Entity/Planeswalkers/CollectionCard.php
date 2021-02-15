<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_collection_card")
 * @ORM\Entity(repositoryClass=App\Repository\Planeswalkers\CollectionCardRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CollectionCard
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
     * @var CollectionCard
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Planeswalkers\Collection")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collection;

    /**
     * @var CollectionCard
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

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function setCollection(?Collection $collection): void
    {
        $this->collection = $collection;
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

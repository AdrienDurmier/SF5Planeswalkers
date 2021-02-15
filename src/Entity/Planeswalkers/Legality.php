<?php

namespace App\Entity\Planeswalkers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="planeswalkers_legality")
 * @ORM\Entity(repositoryClass="App\Repository\Planeswalkers\LegalityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Legality
{
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
    private $cle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(string $cle): self
    {
        $this->cle = $cle;

        return $this;
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

}

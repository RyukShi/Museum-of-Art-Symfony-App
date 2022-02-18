<?php

namespace App\Entity;

use App\Repository\ClassificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassificationRepository::class)
 */
class Classification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $classification;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="classification")
     */
    private $artworks;

    public function __construct(string $classification = "")
    {
        $this->classification = $classification;
        $this->artworks = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClassification(): string
    {
        return $this->classification;
    }

    public function setClassification(string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function __toString(): string
    {
        return "classification : " . $this->classification;
    }

    /**
     * @return Collection|Artwork[]
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks[] = $artwork;
            $artwork->setClassification($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getClassification() === $this) {
                $artwork->setClassification(null);
            }
        }

        return $this;
    }
}

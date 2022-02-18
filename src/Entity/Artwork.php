<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtworkRepository::class)
 */
class Artwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $dimensions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $medium;

    /**
     * @ORM\ManyToOne(targetEntity=Classification::class, inversedBy="artworks")
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity=DatingArtwork::class, inversedBy="artworks")
     */
    private $dating_artwork;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, inversedBy="artworks")
     */
    private $Artist;

    public function __construct(
        string $number = "",
        string $name =  "",
        string $title = "",
        string $dimensions = "",
        string $medium = ""
    ) {
        $this->number = $number;
        $this->name = $name;
        $this->title = $title;
        $this->dimensions = $dimensions;
        $this->medium = $medium;
        $this->Artist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

    public function setMedium(string $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function __toString(): string
    {
        return "id : " . $this->id . " name : " . $this->name;
    }

    public function getClassification(): ?Classification
    {
        return $this->classification;
    }

    public function setClassification(?Classification $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getDatingArtwork(): ?DatingArtwork
    {
        return $this->dating_artwork;
    }

    public function setDatingArtwork(?DatingArtwork $dating_artwork): self
    {
        $this->dating_artwork = $dating_artwork;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtist(): Collection
    {
        return $this->Artist;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->Artist->contains($artist)) {
            $this->Artist[] = $artist;
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->Artist->removeElement($artist);

        return $this;
    }
}

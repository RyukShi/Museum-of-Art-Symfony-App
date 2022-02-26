<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtworkRepository::class)
 */
class Artwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $number = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $dimensions = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $medium = null;

    /**
     * @ORM\ManyToOne(targetEntity=Classification::class, inversedBy="artworks")
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity=DatingArtwork::class, inversedBy="artworks")
     */
    private $dating_artwork;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="artworks")
     */
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity=Localisation::class, inversedBy="artworks")
     */
    private $localisation;

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
        return "number : " . $this->number . " name : " . $this->name . " title : " . $this->title;
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

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private ?string $display_name = null;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private ?string $begin_date = null;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private ?string $end_date = null;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private ?string $gender = null;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     */
    private ?string $nationality = null;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="artist")
     */
    private $artworks;

    public function __construct(
        string $display_name = "",
        string $begin_date = "",
        string $end_date = "",
        string $gender = "",
        string $nationality = ""
    ) {
        $this->display_name = $display_name;
        $this->begin_date = $begin_date;
        $this->end_date = $end_date;
        $this->gender = $gender;
        $this->nationality = $nationality;
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function setDisplayName(?string $display_name): self
    {
        $this->display_name = $display_name;

        return $this;
    }

    public function getBeginDate(): ?string
    {
        return $this->begin_date;
    }

    public function setBeginDate(?string $begin_date): self
    {
        $this->begin_date = $begin_date;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->end_date;
    }

    public function setEndDate(?string $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function __toString(): string
    {
        return "name : " . $this->display_name . ", nationality : " . $this->nationality . ", gender : " . $this->gender;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks[] = $artwork;
            $artwork->setArtist($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getArtist() === $this) {
                $artwork->setArtist(null);
            }
        }

        return $this;
    }
}

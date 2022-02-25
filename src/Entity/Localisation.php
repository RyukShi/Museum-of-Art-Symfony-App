<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocalisationRepository::class)
 */
class Localisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $culture = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $period = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $dynasty = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $reign = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $region = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $subregion = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $country = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $county = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $city = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $locale = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $locus = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $river = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $excavation = null;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="localisation")
     */
    private $artworks;

    public function __construct(
        string $culture = "",
        string $period = "",
        string $dynasty = "",
        string $reign = "",
        string $region = "",
        string $subregion = "",
        string $country = "",
        string $county = "",
        string $city = "",
        string $locale = "",
        string $locus = "",
        string $river = "",
        string $excavation = ""
    ) {
        $this->culture = $culture;
        $this->period = $period;
        $this->dynasty = $dynasty;
        $this->reign = $reign;
        $this->region = $region;
        $this->subregion = $subregion;
        $this->country = $country;
        $this->county = $county;
        $this->city = $city;
        $this->locale = $locale;
        $this->locus = $locus;
        $this->river = $river;
        $this->excavation = $excavation;
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCulture(): ?string
    {
        return $this->culture;
    }

    public function setCulture(?string $culture): self
    {
        $this->culture = $culture;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getDynasty(): ?string
    {
        return $this->dynasty;
    }

    public function setDynasty(?string $dynasty): self
    {
        $this->dynasty = $dynasty;

        return $this;
    }

    public function getReign(): ?string
    {
        return $this->reign;
    }

    public function setReign(?string $reign): self
    {
        $this->reign = $reign;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getSubregion(): ?string
    {
        return $this->subregion;
    }

    public function setSubregion(?string $subregion): self
    {
        $this->subregion = $subregion;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): self
    {
        $this->county = $county;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocus(): ?string
    {
        return $this->locus;
    }

    public function setLocus(?string $locus): self
    {
        $this->locus = $locus;

        return $this;
    }

    public function getRiver(): ?string
    {
        return $this->river;
    }

    public function setRiver(?string $river): self
    {
        $this->river = $river;

        return $this;
    }

    public function getExcavation(): ?string
    {
        return $this->excavation;
    }

    public function setExcavation(?string $excavation): self
    {
        $this->excavation = $excavation;

        return $this;
    }

    public function __toString(): string
    {
        return "country : " . $this->country . ", city : " . $this->city . ", region : " . $this->region . ", subregion : " . $this->subregion;
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
            $artwork->setLocalisation($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getLocalisation() === $this) {
                $artwork->setLocalisation(null);
            }
        }

        return $this;
    }
}

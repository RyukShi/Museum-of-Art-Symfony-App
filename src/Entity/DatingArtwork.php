<?php

namespace App\Entity;

use App\Repository\DatingArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatingArtworkRepository::class)
 */
class DatingArtwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $object_begin_date = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $object_end_date = null;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="dating_artwork")
     */
    private $artworks;

    public function __construct(
        int $object_begin_date = 0,
        int $object_end_date = 0
    ) {
        $this->object_begin_date = $object_begin_date;
        $this->object_end_date = $object_end_date;
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectBeginDate(): ?int
    {
        return $this->object_begin_date;
    }

    public function setObjectBeginDate(?int $object_begin_date): self
    {
        $this->object_begin_date = $object_begin_date;

        return $this;
    }

    public function getObjectEndDate(): ?int
    {
        return $this->object_end_date;
    }

    public function setObjectEndDate(?int $object_end_date): self
    {
        $this->object_end_date = $object_end_date;

        return $this;
    }

    public function __toString(): string
    {
        return "Object Begin Date : " . $this->object_begin_date . " Object End Date : " . $this->object_end_date;
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
            $artwork->setDatingArtwork($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getDatingArtwork() === $this) {
                $artwork->setDatingArtwork(null);
            }
        }

        return $this;
    }
}

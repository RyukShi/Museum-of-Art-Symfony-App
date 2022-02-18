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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $object_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $object_begin_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private int $object_end_date;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="dating_artwork")
     */
    private $artworks;

    public function __construct(
        string $object_date = "",
        int $object_begin_date = 0,
        int $object_end_date = 0
    ) {
        $this->object_date = $object_date;
        $this->object_begin_date = $object_begin_date;
        $this->object_end_date = $object_end_date;
        $this->artworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectDate(): ?string
    {
        return $this->object_date;
    }

    public function setObjectDate(?string $object_date): self
    {
        $this->object_date = $object_date;

        return $this;
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
        return "object_date : " . $this->object_date;
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

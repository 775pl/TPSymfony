<?php

namespace App\Entity;

use App\Repository\GateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GateRepository::class)]
class Gate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $number;

    #[ORM\ManyToOne(targetEntity: Port::class, inversedBy: 'test')]
    private $fk_port_id;

    #[ORM\ManyToOne(targetEntity: Port::class, inversedBy: 'gates')]
    private $port;

    #[ORM\OneMToMany(mappedBy: 'gate', targetEntity: Place::class)]
    private $places;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'gates')]
    private $place;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getFkPortId(): ?Port
    {
        return $this->fk_port_id;
    }

    public function setFkPortId(?Port $fk_port_id): self
    {
        $this->fk_port_id = $fk_port_id;

        return $this;
    }

    public function getPort(): ?Port
    {
        return $this->port;
    }

    public function setPort(?Port $port): self
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setGate($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getGate() === $this) {
                $place->setGate(null);
            }
        }

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $nomber;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $length;

    #[ORM\Column(type: 'decimal', precision: 10, scale: '0')]
    private $depth;

    #[ORM\ManyToOne(targetEntity: Gate::class, inversedBy: 'places')]
    #[ORM\JoinColumn(nullable: false)]
    private $gate;

    #[ORM\ManyToOne(targetEntity: Booking::class)]
    private $booking;

    #[ORM\OneToMany(mappedBy: 'places', targetEntity: Booking::class)]
    private $bookings;

    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Gate::class)]
    private $gates;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->gates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomber(): ?int
    {
        return $this->nomber;
    }

    public function setNomber(int $nomber): self
    {
        $this->nomber = $nomber;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getDepth(): ?string
    {
        return $this->depth;
    }

    public function setDepth(string $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getGate(): ?Gate
    {
        return $this->gate;
    }

    public function setGate(?Gate $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setPlaces($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getPlaces() === $this) {
                $booking->setPlaces(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gate>
     */
    public function getGates(): Collection
    {
        return $this->gates;
    }

    public function addGate(Gate $gate): self
    {
        if (!$this->gates->contains($gate)) {
            $this->gates[] = $gate;
            $gate->setPlace($this);
        }

        return $this;
    }

    public function removeGate(Gate $gate): self
    {
        if ($this->gates->removeElement($gate)) {
            // set the owning side to null (unless already changed)
            if ($gate->getPlace() === $this) {
                $gate->setPlace(null);
            }
        }

        return $this;
    }
}

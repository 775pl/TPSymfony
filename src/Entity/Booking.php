<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $start_booking;

    #[ORM\Column(type: 'date')]
    private $stop_booking;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'bookings')]
    private $places;

    #[ORM\ManyToOne(targetEntity: Boat::class, inversedBy: 'bookings')]
    private $boats;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartBooking(): ?\DateTimeInterface
    {
        return $this->start_booking;
    }

    public function setStartBooking(\DateTimeInterface $start_booking): self
    {
        $this->start_booking = $start_booking;

        return $this;
    }

    public function getStopBooking(): ?\DateTimeInterface
    {
        return $this->stop_booking;
    }

    public function setStopBooking(\DateTimeInterface $stop_booking): self
    {
        $this->stop_booking = $stop_booking;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPlaces(): ?Place
    {
        return $this->places;
    }

    public function setPlaces(?Place $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getBoats(): ?Boat
    {
        return $this->boats;
    }

    public function setBoats(?Boat $boats): self
    {
        $this->boats = $boats;

        return $this;
    }
}

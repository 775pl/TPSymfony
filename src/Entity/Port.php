<?php

namespace App\Entity;

use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\OneToMany(mappedBy: 'fk_port_id', targetEntity: Gate::class)]
    private $test;

    #[ORM\OneToMany(mappedBy: 'port', targetEntity: Gate::class)]
    private $gates;

    public function __construct()
    {
        $this->test = new ArrayCollection();
        $this->gates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Gate>
     */
    public function getTest(): Collection
    {
        return $this->test;
    }

    public function addTest(Gate $test): self
    {
        if (!$this->test->contains($test)) {
            $this->test[] = $test;
            $test->setFkPortId($this);
        }

        return $this;
    }

    public function removeTest(Gate $test): self
    {
        if ($this->test->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getFkPortId() === $this) {
                $test->setFkPortId(null);
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
            $gate->setPort($this);
        }

        return $this;
    }

    public function removeGate(Gate $gate): self
    {
        if ($this->gates->removeElement($gate)) {
            // set the owning side to null (unless already changed)
            if ($gate->getPort() === $this) {
                $gate->setPort(null);
            }
        }

        return $this;
    }
}

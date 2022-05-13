<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $nationality;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Tour::class)]
    private $tour;

    public function __construct()
    {
        $this->tour = new ArrayCollection();
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

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Tour>
     */
    public function getTour(): Collection
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tour->contains($tour)) {
            $this->tour[] = $tour;
            $tour->setCompany($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tour->removeElement($tour)) {
            // set the owning side to null (unless already changed)
            if ($tour->getCompany() === $this) {
                $tour->setCompany(null);
            }
        }

        return $this;
    }

    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $stop = $doctrine->getRepository(Stop::class)->find($id);

        $tour = $stop->getStop();

        dump(get_class($tour));
        die();
    }
}

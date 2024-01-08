<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepenseRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @ORM\Entity(repositoryClass=DepenseRepository::class)
 */
class Depense
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Designation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Qte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PrixUnitaire;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDps;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Slug;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeSlug()
    {   
        $slugify = new Slugify();
        $this->Slug= $this->Qte."-".$slugify->slugify($this->Designation)."-".$this->PrixUnitaire."-".($this->DateDps)->Format("d-m-Y");
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): self
    {
        $this->Designation = mb_strtoupper($Designation);

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->Qte;
    }

    public function setQte(?float $Qte): self
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->PrixUnitaire;
    }

    public function setPrixUnitaire(?float $PrixUnitaire): self
    {
        $this->PrixUnitaire = $PrixUnitaire;

        return $this;
    }

    public function getDateDps(): ?\DateTimeInterface
    {
        return $this->DateDps;
    }

    public function setDateDps(\DateTimeInterface $DateDps): self
    {
        $this->DateDps = $DateDps;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }
}

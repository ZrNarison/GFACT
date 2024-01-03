<?php

namespace App\Entity;

use App\Repository\NFactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NFactRepository::class)
 */
class NFact
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
    private $Compte;

    /**
     * @ORM\Column(type="date")
     */
    private $Dtfct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompte(): ?string
    {
        return $this->Compte;
    }

    public function setCompte(string $Compte): self
    {
        $this->Compte = $Compte;

        return $this;
    }

    public function getDtfct(): ?\DateTimeInterface
    {
        return $this->Dtfct;
    }

    public function setDtfct(\DateTimeInterface $Dtfct): self
    {
        $this->Dtfct = $Dtfct;

        return $this;
    }
}

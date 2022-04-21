<?php

namespace App\Entity;

use DateTime;
use App\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CmdRepository;

/**
 * @ORM\Entity(repositoryClass=CmdRepository::class)
 */
class Cmd
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
    private $designation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $periode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prixunitaire;

    /**
     * @ORM\Column(type="date")
     */
    private $datecmd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientcmd;
    
    // public function __construct()
    // {
    //    $this->Client =getClient();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(?string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixunitaire(): ?string
    {
        return $this->prixunitaire;
    }

    public function setPrixunitaire(string $prixunitaire): self
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }

    public function getDatecmd(): ?\DateTimeInterface
    {
        return $this->datecmd;
    }

    public function setDatecmd(\DateTimeInterface $datecmd): self
    {
        $this->datecmd = $datecmd;

        return $this;
    }

    public function getClientcmd(): ?string
    {
        return $this->clientcmd;
    }

    public function setClientcmd(string $clientcmd): self
    {
        $this->clientcmd = $clientcmd;

        return $this;
    }
}

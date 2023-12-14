<?php

namespace App\Entity;

use App\Repository\ParamsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParamsRepository::class)
 */
class Params
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
    private $Std;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Frq;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PAdres;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Bp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Telp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PNif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PStat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PRib;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Tp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FStd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PSlug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Logos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStd(): ?string
    {
        return $this->Std;
    }

    public function setStd(string $Std): self
    {
        $this->Std = $Std;

        return $this;
    }

    public function getFrq(): ?string
    {
        return $this->Frq;
    }

    public function setFrq(string $Frq): self
    {
        $this->Frq = $Frq;

        return $this;
    }

    public function getPAdres(): ?string
    {
        return $this->PAdres;
    }

    public function setPAdres(string $PAdres): self
    {
        $this->PAdres = $PAdres;

        return $this;
    }

    public function getBp(): ?string
    {
        return $this->Bp;
    }

    public function setBp(string $Bp): self
    {
        $this->Bp = $Bp;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getTelp(): ?string
    {
        return $this->Telp;
    }

    public function setTelp(string $Telp): self
    {
        $this->Telp = $Telp;

        return $this;
    }

    public function getPNif(): ?string
    {
        return $this->PNif;
    }

    public function setPNif(string $PNif): self
    {
        $this->PNif = $PNif;

        return $this;
    }

    public function getPStat(): ?string
    {
        return $this->PStat;
    }

    public function setPStat(string $PStat): self
    {
        $this->PStat = $PStat;

        return $this;
    }

    public function getPRib(): ?string
    {
        return $this->PRib;
    }

    public function setPRib(string $PRib): self
    {
        $this->PRib = $PRib;

        return $this;
    }

    public function getTp(): ?string
    {
        return $this->Tp;
    }

    public function setTp(string $Tp): self
    {
        $this->Tp = $Tp;

        return $this;
    }

    public function getFStd(): ?string
    {
        return $this->FStd;
    }

    public function setFStd(string $FStd): self
    {
        $this->FStd = $FStd;

        return $this;
    }

    public function getPSlug(): ?string
    {
        return $this->PSlug;
    }

    public function setPSlug(string $PSlug): self
    {
        $this->PSlug = $PSlug;

        return $this;
    }

    public function getLogos(): ?string
    {
        return $this->Logos;
    }

    public function setLogos(string $Logos): self
    {
        $this->Logos = $Logos;

        return $this;
    }
}

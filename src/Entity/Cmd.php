<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\CmdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CmdRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
    private $Design;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Qte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Pu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CmSlug;

    /**
     * @ORM\ManyToOne(targetEntity=CmdClient::class, inversedBy="Cmd")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cmdClient;

    /**
     * @ORM\Column(type="date")
     */
    private $DateCmd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Annees;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mois;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * Undocumented function
     *
     * @return integer|null
     */
    public function initializeSlug(){
        if(empty($this->CmSlug)){
            $slugify= new Slugify();
            $this->CmSlug = $slugify->Slugify($this->Design .'-'.  $this->Qte.'-'.  $this->Pu .'-'.  $this->prd .'-'.  $this->duree);
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesign(): ?string
    {
        return $this->Design;
    }

    public function setDesign(string $Design): self
    {
        $this->Design = $Design;

        return $this;
    }

    public function getPrd(): ?string
    {
        return $this->prd;
    }

    public function setPrd(?string $prd): self
    {
        $this->prd = $prd;

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

    public function getQte(): ?string
    {
        return $this->Qte;
    }

    public function setQte(string $Qte): self
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getPu(): ?string
    {
        return $this->Pu;
    }

    public function setPu(string $Pu): self
    {
        $this->Pu = $Pu;

        return $this;
    }

    public function getDtCmd(): ?\DateTimeInterface
    {
        return $this->DtCmd;
    }

    public function setDtCmd(\DateTimeInterface $DtCmd): self
    {
        $this->DtCmd = $DtCmd;

        return $this;
    }

    public function getCmSlug(): ?string
    {
        return $this->CmSlug;
    }

    public function setCmSlug(?string $CmSlug): self
    {
        $this->CmSlug = $CmSlug;

        return $this;
    }

    public function getCmdClient(): ?CmdClient
    {
        return $this->cmdClient;
    }

    public function setCmdClient(?CmdClient $cmdClient): self
    {
        $this->cmdClient = $cmdClient;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->DateCmd;
    }

    public function setDateCmd(\DateTimeInterface $DateCmd): self
    {
        $this->DateCmd = $DateCmd;

        return $this;
    }

    public function getAnnees(): ?string
    {
        return $this->Annees;
    }

    public function setAnnees(string $Annees): self
    {
        $this->Annees = $Annees;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->Mois;
    }

    public function setMois(string $Mois): self
    {
        $this->Mois = $Mois;

        return $this;
    }
}
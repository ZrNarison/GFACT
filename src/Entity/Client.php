<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use ORM\HashLifecycleCallBacks;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"NomCl"}, 
 * message= "Nom du client existe déjà. Merci de reéssayer avec une autre !"
 * )
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2,max=225,minMessage="Le nom client sont trop court, veuillez entrer une nom valide !",maxMessage="Ce nom dépasse le limite !")
     */
    private $NomCl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=13,max=15,minMessage="Le Numero Statistique sont trop court, veuillez entrer un numéro valide !",maxMessage="Ce nom dépasse le limite !")
     */
    private $Stat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=9,max=10,minMessage="Le Numero d'Identité Fiscal sont trop court, veuillez entrer un numéro valide !",maxMessage="Ce nom dépasse le limite !")
     */
    private $Nif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Rcs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RIB;

    /**
     * @ORM\Column(type="string")
     */
    private $Slug;

    /**
     * @ORM\OneToMany(targetEntity=CmdClient::class, mappedBy="Clients", orphanRemoval=true)
     */
    private $cmd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $User;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return void
     */
    public function initializeSlug()
    {   
        $slugify = new Slugify();
        $this->Slug= $slugify->Slugify($this ->NomCl.'-'.$this->Adress);
    }

    public function slugify()
    {
        return $this->slugify();
    }
    public function __toString(): string
    {
        return $this->getSlug();
    }

    public function __construct()
    {
        $this->CCmd = new ArrayCollection();
        $this->cmd = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCl(): ?string
    {
        return $this->NomCl;
    }

    public function setNomCl(string $NomCl): self
    {
        $this->NomCl = mb_strtoupper($NomCl);

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(?string $Adress): self
    {
        $this->Adress = mb_strtoupper($Adress);

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(?string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getStat(): ?string
    {
        return $this->Stat;
    }

    public function setStat(?string $Stat): self
    {
        $this->Stat = $Stat;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->Nif;
    }

    public function setNif(?string $Nif): self
    {
        $this->Nif = $Nif;

        return $this;
    }

    public function getRcs(): ?string
    {
        return $this->Rcs;
    }

    public function setRcs(?string $Rcs): self
    {
        $this->Rcs = $Rcs;

        return $this;
    }

    public function getRIB(): ?string
    {
        return $this->RIB;
    }

    public function setRIB(?string $RIB): self
    {
        $this->RIB = $RIB;

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

    /**
     * @return Collection<int, CmdClient>
     */
    public function getCmd(): Collection
    {
        return $this->cmd;
    }

    public function addCmd(CmdClient $cmd): self
    {
        if (!$this->cmd->contains($cmd)) {
            $this->cmd[] = $cmd;
            $cmd->setClients($this);
        }

        return $this;
    }

    public function removeCmd(CmdClient $cmd): self
    {
        if ($this->cmd->removeElement($cmd)) {
            // set the owning side to null (unless already changed)
            if ($cmd->getClients() === $this) {
                $cmd->setClients(null);
            }
        }

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->User;
    }

    public function setUser(string $User): self
    {
        $this->User = $User;

        return $this;
    }
}

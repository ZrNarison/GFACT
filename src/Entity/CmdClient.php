<?php

namespace App\Entity;

use App\Entity\Client;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CmdClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CmdClientRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class CmdClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NCmd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Dos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Dif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ClSlug;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="cmd")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Clients;

    /**
     * @ORM\OneToMany(targetEntity=Cmd::class, mappedBy="cmdClient", orphanRemoval=true)
     */
    private $Cmd;

    public function __construct()
    {
        // $this->Cmds = new ArrayCollection();
        // $this->cmds = new ArrayCollection();
        $this->Cmd = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getClSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCCmd(): ?string
    {
        return $this->NCmd;
    }

    public function setNCmd(?string $NCmd): self
    {
        $this->NCmd = $NCmd;

        return $this;
    }

    public function getCClient(): ?string
    {
        return $this->CClient;
    }

    public function setCClient(?string $CClient): self
    {
        $this->CClient = $CClient;

        return $this;
    }

    public function getDos(): ?string
    {
        return $this->Dos;
    }

    public function setDos(?string $Dos): self
    {
        $this->Dos = $Dos;

        return $this;
    }

    public function getDif(): ?string
    {
        return $this->Dif;
    }

    public function setDif(?string $Dif): self
    {
        $this->Dif = $Dif;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }


    public function getClSlug(): ?string
    {
        return $this->ClSlug;
    }

    public function setClSlug(?string $ClSlug): self
    {
        $this->ClSlug = $ClSlug;

        return $this;
    }


    public function getClients(): ?Client
    {
        return $this->Clients;
    }

    public function setClients(?Client $Clients): self
    {
        $this->Clients = $Clients;

        return $this;
    }

    /**
     * @return Collection<int, Cmd>
     */
    public function getCmd(): Collection
    {
        return $this->Cmd;
    }

    public function addCmd(Cmd $cmd): self
    {
        if (!$this->Cmd->contains($cmd)) {
            $this->Cmd[] = $cmd;
            $cmd->setCmdClient($this);
        }

        return $this;
    }

    public function removeCmd(Cmd $cmd): self
    {
        if ($this->Cmd->removeElement($cmd)) {
            // set the owning side to null (unless already changed)
            if ($cmd->getCmdClient() === $this) {
                $cmd->setCmdClient(null);
            }
        }

        return $this;
    }

}

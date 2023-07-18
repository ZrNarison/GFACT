<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CmdClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
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
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="CCmd")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Cmd::class, mappedBy="cmdClient")
     */
    private $CmdClt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ClSlug;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */

    public function __construct()
    {
        $this->CmdClt = new ArrayCollection();
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

    public function __toString(): string
    {
        return $this->getClSlug();
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

    /**
     * @return Collection<int, Cmd>
     */
    public function getCmdClt(): Collection
    {
        return $this->CmdClt;
    }

    public function addCmdClt(Cmd $cmdClt): self
    {
        if (!$this->CmdClt->contains($cmdClt)) {
            $this->CmdClt[] = $cmdClt;
            $cmdClt->setCmdClient($this);
        }

        return $this;
    }

    public function removeCmdClt(Cmd $cmdClt): self
    {
        if ($this->CmdClt->removeElement($cmdClt)) {
            // set the owning side to null (unless already changed)
            if ($cmdClt->getCmdClient() === $this) {
                $cmdClt->setCmdClient(null);
            }
        }

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

}

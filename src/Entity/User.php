<?php

namespace App\Entity;

use ORM\Assert\File;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"Pseudo"}, message= "Vous avez déjà inscrit avec cette nom d'utilisateur. Merci de reéssayer avec une autre !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4,max=255,minMessage="Nom d'utilisateur trop court, veuillez entrer une nom valide !",maxMessage="Ce nom dépasse le limite !")
     */
    private $Pseudo;

    /**
     * @ORM\Column(type="string", length=255 )
     * 
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $picture;

    /**
     * @Assert\EqualTo(propertyPath="mdp",message="Code de confirmation incorrect !")
     */
    public $confirmation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $USlug;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }

    // public function __construct()
    // {
    //     $this->tClass = new ArrayCollection();
    // }

    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * Undocumented function
     *
     * @return integer|null
     */
    public function initializeSlug(){
        if(empty($this->USlug)){
            $slugify= new Slugify();
            $this->USlug = $slugify->Slugify($this->Pseudo);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->Pseudo;
    }

    public function setPseudo(string $Pseudo): self
    {
        $this->Pseudo =  mb_strtoupper($Pseudo);

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUSlug(): ?string
    {
        return $this->USlug;
    }

    public function setUSlug(?string $USlug): self
    {
        $this->USlug = $USlug;

        return $this;
    }

    public function getRoles(){
        $roles = $this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();
        return $roles;
    }
    public function getPassword(){
        return $this->mdp;
    }
    public function getSalt(){}
    
    public function getUsername(){
        return $this->Pseudo;
    }
    

    public function eraseCredentials(){}

    /**
     * @return Collection<int, Role>
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->removeElement($userRole)) {
            $userRole->removeUser($this);
        }

        return $this;
    }


}

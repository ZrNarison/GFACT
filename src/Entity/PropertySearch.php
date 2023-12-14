<?php

namespace App\Entity;

class PropertySearch{

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    private  $NomClient;


    /**
     * Undocumented variable
     *
     * @var date|null
     */
    private  $DateCmd;

    public function getNomClient(): ?string
    {
        return $this->NomClient;
    }

    public function setNomClient(string $NomClient): PropertySearch
    {
        $this->NomClient = $NomClient;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->DateCmd;
    }

    public function setDateCmd(\DateTimeInterface $DateCmd): PropertySearch
    {
        $this->DateCmd = $DateCmd;

        return $this;
    }

}
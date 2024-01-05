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

    private  $DateDps;

    private  $Datefin;

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

    public function getDateDps(): ?\DateTimeInterface
    {
        return $this->DateDps;
    }

    public function setDateDps(\DateTimeInterface $DateDps): PropertySearch
    {
        $this->DateDps = $DateDps;

        return $this;
    }
    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->Datefin;
    }

    public function setDatefin(\DateTimeInterface $Datefin): PropertySearch
    {
        $this->Datefin = $Datefin;

        return $this;
    }

}
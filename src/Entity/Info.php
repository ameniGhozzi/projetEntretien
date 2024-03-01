<?php

namespace App\Entity;

use App\Repository\InfoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDuGroupe = null;

    #[ORM\Column(length: 255)]
    private ?string $origine = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    
    #[ORM\Column(nullable: false)]
    private ?float $anneeDebut = null;

    #[ORM\Column(nullable: true)]
    private ?float $anneeSeparation = null;

    #[ORM\Column(length: 255)]
    private ?string $fondateur = null;

    #[ORM\Column]
    private ?int $membre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $courantMusicale = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDuGroupe(): ?string
    {
        return $this->nomDuGroupe;
    }

    public function setNomDuGroupe(string $nomDuGroupe): static
    {
        $this->nomDuGroupe = $nomDuGroupe;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): static
    {
        $this->origine = $origine;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getanneeDebut(): ?float
    {
        return $this->anneeDebut;
    }

    public function setanneeDebut(float $anneeDebut): static
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    public function getanneeSeparation(): ?float
    {
        return $this->anneeSeparation;
    }

    public function setanneeSeparation(?float $anneeSeparation): static
    {
        $this->anneeSeparation = $anneeSeparation;

        return $this;
    }
    public function getFondateur(): ?string
    {
        return $this->fondateur;
    }

    public function setFondateur(string $fondateur): static
    {
        $this->fondateur = $fondateur;

        return $this;
    }

    public function getMembre(): ?int
    {
        return $this->membre;
    }

    public function setMembre(int $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    public function getCourantMusicale(): ?string
    {
        return $this->courantMusicale;
    }

    public function setCourantMusicale(?string $courantMusicale): static
    {
        $this->courantMusicale = $courantMusicale;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }
}

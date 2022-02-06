<?php

namespace App\Entity;

use App\Repository\MatchsRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=MatchsRepository::class)
 */
class Matchs implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gagner;

    /**
     * @ORM\ManyToOne(targetEntity=Personnage::class, inversedBy="matchsJoueur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnageJoueur;

    /**
     * @ORM\ManyToOne(targetEntity=Personnage::class, inversedBy="matchsAdversaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personnageAdversaire;


    public function __construct($id){
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getGagner(): ?bool
    {
        return $this->gagner;
    }

    public function setGagner(bool $gagner): self
    {
        $this->gagner = $gagner;

        return $this;
    }

    public function getPersonnageJoueur(): ?Personnage
    {
        return $this->personnageJoueur;
    }

    public function setPersonnageJoueur(?Personnage $personnageJoueur): self
    {
        $this->personnageJoueur = $personnageJoueur;

        return $this;
    }

    public function getPersonnageAdversaire(): ?Personnage
    {
        return $this->personnageAdversaire;
    }

    public function setPersonnageAdversaire(?Personnage $personnageAdversaire): self
    {
        $this->personnageAdversaire = $personnageAdversaire;

        return $this;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'gagner' => $this->gagner,
            'personnageJoueur' => [
                'nom' => $this->personnageJoueur->getNom()
            ],
            'personnageAdversaire' => [
                'nom' => $this->personnageAdversaire->getNom()
            ],
        ];
    }
}

<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=PersonnageRepository::class)
 */
class Personnage implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkImage;

    /**
     * @ORM\OneToMany(targetEntity=CoupSpeciaux::class, mappedBy="personnage", orphanRemoval=true)
     */
    private $coupSpeciaux;

    /**
     * @ORM\OneToMany(targetEntity=Matchs::class, mappedBy="personnageJoueur")
     */
    private $matchsJoueur;

    /**
     * @ORM\OneToMany(targetEntity=Matchs::class, mappedBy="personnageAdversaire")
     */
    private $matchsAdversaire;

    /**
     * @ORM\ManyToOne(targetEntity=Univers::class, inversedBy="personnages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $univers;

    public function __construct($id)
    {
        $this->id = $id;
        $this->coupSpeciaux = new ArrayCollection();
        $this->matchsJoueur = new ArrayCollection();
        $this->matchsAdversaire = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLinkImage(): ?string
    {
        return $this->linkImage;
    }

    public function setLinkImage(string $linkImage): self
    {
        $this->linkImage = $linkImage;

        return $this;
    }

    /**
     * @return Collection|CoupSpeciaux[]
     */
    public function getcoupSpeciaux(): Collection
    {
        return $this->coupSpeciaux;
    }

    public function addCoupSpeciaux(CoupSpeciaux $coupSpeciaux): self
    {
        if (!$this->coupSpeciaux->contains($coupSpeciaux)) {
            $this->coupSpeciaux[] = $coupSpeciaux;
            $coupSpeciaux->setPersonnage($this);
        }

        return $this;
    }

    public function removeCoupSpeciaux(CoupSpeciaux $coupSpeciaux): self
    {
        if ($this->coupSpeciaux->removeElement($coupSpeciaux)) {
            // set the owning side to null (unless already changed)
            if ($coupSpeciaux->getPersonnage() === $this) {
                $coupSpeciaux->setPersonnage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Matchs[]
     */
    public function getMatchsJoueur(): Collection
    {
        return $this->matchsJoueur;
    }

    public function addMatchsJoueur(Matchs $matchsJoueur): self
    {
        if (!$this->matchsJoueur->contains($matchsJoueur)) {
            $this->matchsJoueur[] = $matchsJoueur;
            $matchsJoueur->setPersonnageJoueur($this);
        }

        return $this;
    }

    public function removeMatchsJoueur(Matchs $matchsJoueur): self
    {
        if ($this->matchsJoueur->removeElement($matchsJoueur)) {
            // set the owning side to null (unless already changed)
            if ($matchsJoueur->getPersonnageJoueur() === $this) {
                $matchsJoueur->setPersonnageJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Matchs[]
     */
    public function getMatchsAdversaire(): Collection
    {
        return $this->matchsAdversaire;
    }

    public function addMatchsAdversaire(Matchs $matchsAdversaire): self
    {
        if (!$this->matchsAdversaire->contains($matchsAdversaire)) {
            $this->matchsAdversaire[] = $matchsAdversaire;
            $matchsAdversaire->setPersonnageAdversaire($this);
        }

        return $this;
    }

    public function removeMatchsAdversaire(Matchs $matchsAdversaire): self
    {
        if ($this->matchsAdversaire->removeElement($matchsAdversaire)) {
            // set the owning side to null (unless already changed)
            if ($matchsAdversaire->getPersonnageAdversaire() === $this) {
                $matchsAdversaire->setPersonnageAdversaire(null);
            }
        }

        return $this;
    }

    public function jsonCoupSpeciaux(){
        $coupSpeciauxJson = [];
        
        foreach($this->coupSpeciaux as $coupSpeciaux){
            $coupSpeciauxJson[] = [
                'nom' => $coupSpeciaux->getNom(),
                'pourcentage' => $coupSpeciaux->getPourcentages(),
                'direction' => $coupSpeciaux->getDirection(),
            ];
        }

        return $coupSpeciauxJson;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'linkImage' => $this->linkImage,
            'coupSpeciaux' => $this->jsonCoupSpeciaux(),
            'univers' => $this->univers->getNom()
        ];
    }

    public function getUnivers(): ?Univers
    {
        return $this->univers;
    }

    public function setUnivers(?Univers $univers): self
    {
        $this->univers = $univers;

        return $this;
    }
}

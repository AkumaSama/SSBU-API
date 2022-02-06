<?php

namespace App\Entity;

use App\Repository\UniversRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass=UniversRepository::class)
 */
class Univers implements JsonSerializable
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
     * @ORM\OneToMany(targetEntity=Personnage::class, mappedBy="univers", orphanRemoval=true)
     */
    private $personnages;

    public function __construct($id)
    {
        $this->id = $id;
        $this->personnages = new ArrayCollection();
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
     * @return Collection|Personnage[]
     */
    public function getPersonnages(): Collection
    {
        return $this->personnages;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnages->contains($personnage)) {
            $this->personnages[] = $personnage;
            $personnage->setUnivers($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnages->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getUnivers() === $this) {
                $personnage->setUnivers(null);
            }
        }

        return $this;
    }

    public function jsonPersonnages(){
        $personnages = [];
        
        foreach($this->personnages as $personnage){
            $personnages[] = [
                'id' => $personnage->getId(),
                'nom' => $personnage->getNom(),
            ];
        }

        return $personnages;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'linkImage' => $this->linkImage,
            'personnages' => $this->jsonPersonnages()
        ];
    }
}

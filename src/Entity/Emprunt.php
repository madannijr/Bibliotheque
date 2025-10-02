<?php

namespace App\Entity;

use App\Enum\StatutEmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Livre;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'livre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?livre $livre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmprunt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDeRetour = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[DoctrineAssert\Enum(entity: 'App\Enum\StatutEmpruntType')]
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getLivre(): ?livre
    {
        return $this->livre;
    }

    public function setLivre(?livre $livre): static
    {
        $this->livre = $livre;

        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeInterface $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateDeRetour(): ?\DateTimeInterface
    {
        return $this->dateDeRetour;
    }

    public function setDateDeRetour(\DateTimeInterface $dateDeRetour): static
    {
        $this->dateDeRetour = $dateDeRetour;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    // Fonction pour calculer la date de retour
   /* public function calculerDateRetourPrevue(): \DateTimeInterface
    {
        if ($this->dateEmprunt instanceof \DateTimeInterface) {
            $dateRetourPrevue = clone $this->dateEmprunt;
            $dateRetourPrevue->modify('+1 month');
            return $dateRetourPrevue;
        } else {
            throw new \RuntimeException('Date d\'emprunt non définie');
        }
    }  */
}

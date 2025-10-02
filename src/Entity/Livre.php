<?php

namespace App\Entity;

use App\Enum\StatutLivreType;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['livre', 'categorie'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre', 'categorie'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre', 'categorie'])]
    private ?string $auteur = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre', 'categorie'])]
    private ?string $ISBN = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['livre', 'categorie'])]
    private ?string $Genre = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['livre', 'categorie'])]
    private ?int $AnneeDePublication = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['livre', 'categorie'])]
    private ?string $Description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['livre', 'categorie'])]
    private ?int $NombresExemplairesDisponibles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(?string $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getAnneeDePublication(): ?int
    {
        return $this->AnneeDePublication;
    }

    public function setAnneeDePublication(?int $AnneeDePublication): static
    {
        $this->AnneeDePublication = $AnneeDePublication;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNombresExemplairesDisponibles(): ?int
    {
        return $this->NombresExemplairesDisponibles;
    }

    public function setNombresExemplairesDisponibles(?int $NombresExemplairesDisponibles): static
    {
        $this->NombresExemplairesDisponibles = $NombresExemplairesDisponibles;

        return $this;
    }
    /**
     * @ORM\Column(type="string", length=20)
     * @DoctrineAssert\Enum(entity="App\Enum\StatutLivreType")
     */
    private $statut;

    /**
     * @var Collection<int, Emprunt>
     */
    #[ORM\OneToMany(targetEntity: Emprunt::class, mappedBy: 'livre')]
    private Collection $emprunts;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'livre')]
    #[Groups(['livre'])]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['livre'])]
    private ?Categorie $categorie = null;

    #[Groups(['livre', 'categorie'])]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setLivre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLivre() === $this) {
                $reservation->setLivre(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}

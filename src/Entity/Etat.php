<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 * @UniqueEntity("nom")
 */
class Etat
{
    /*
     * J'ai opté pour une gestion dynamique des états
     * donc création d'une table pour le stockage
     * et pour la gestion de la supériorité des états
     * je les ai attribué des valeurs numériques
     *
     * O => état moyen
     * 1 => Bon état
     * 2 => Très bon état
     * 3 => Comme Neuf
     * 4 => Neuf
     * 5 => ....
     * */


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min="1",max="15")
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer",unique=true)
     */
    private $valeur;

    public function getId(): ?int
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

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}

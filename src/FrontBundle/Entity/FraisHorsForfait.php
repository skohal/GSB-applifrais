<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FraisHorsForfait
 *
 * @ORM\Table(name="frais_hors_forfait")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\FraisHorsForfaitRepository")
 */
class FraisHorsForfait
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;


    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\FicheFrais", inversedBy="fraisHorsForfait")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Fiche;

    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\Etat", inversedBy="fraisHorsForfait", cascade={"persist"})
     */
    private $etat;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return FraisHorsForfait
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return FraisHorsForfait
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return FraisHorsForfait
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FraisHorsForfait
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set fiche
     *
     * @param \FrontBundle\Entity\FicheFrais $fiche
     *
     * @return FraisHorsForfait
     */
    public function setFiche(\FrontBundle\Entity\FicheFrais $fiche)
    {
        $this->Fiche = $fiche;

        return $this;
    }

    /**
     * Get fiche
     *
     * @return \FrontBundle\Entity\FicheFrais
     */
    public function getFiche()
    {
        return $this->Fiche;
    }

    /**
     * Set etat
     *
     * @param \FrontBundle\Entity\Etat $etat
     *
     * @return FraisHorsForfait
     */
    public function setEtat(\FrontBundle\Entity\Etat $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \FrontBundle\Entity\Etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

}

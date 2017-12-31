<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FicheFrais
 *
 * @ORM\Table(name="fiche_frais")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\FicheFraisRepository")
 */
class FicheFrais
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
     * @var int
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
     * @var int
     *
     * @ORM\Column(name="nbJustificatifs", type="integer")
     */
    private $nbJustificatifs;

    /**
     * @var float
     *
     * @ORM\Column(name="montantValide", type="float")
     */
    private $montantValide;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModif", type="datetime")
     */
    private $dateModif;


    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\user", inversedBy="fiche")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FraisForfait", mappedBy="Fiche")
     */
    private $fraisForfaits;

    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FraisHorsForfait", mappedBy="Fiche")
     */
    private $fraisHorsForfait;

    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\Etat", inversedBy="fichesFrais",  cascade={"persist"})
     */
    private $etat;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return FicheFrais
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return int
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     *
     * @return FicheFrais
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set nbJustificatifs
     *
     * @param integer $nbJustificatifs
     *
     * @return FicheFrais
     */
    public function setNbJustificatifs($nbJustificatifs)
    {
        $this->nbJustificatifs = $nbJustificatifs;

        return $this;
    }

    /**
     * Get nbJustificatifs
     *
     * @return int
     */
    public function getNbJustificatifs()
    {
        return $this->nbJustificatifs;
    }

    /**
     * Set montantValide
     *
     * @param float $montantValide
     *
     * @return FicheFrais
     */
    public function setMontantValide($montantValide)
    {
        $this->montantValide = $montantValide;

        return $this;
    }

    /**
     * Get montantValide
     *
     * @return float
     */
    public function getMontantValide()
    {
        return $this->montantValide;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return FicheFrais
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModif
     *
     * @param \DateTime $dateModif
     *
     * @return FicheFrais
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * Set user
     *
     * @param \FrontBundle\Entity\user $user
     *
     * @return FicheFrais
     */
    public function setUser(\FrontBundle\Entity\user $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FrontBundle\Entity\user
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fraisForfaits = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add fraisForfait
     *
     * @param \FrontBundle\Entity\FraisForfait $fraisForfait
     *
     * @return FicheFrais
     */
    public function addFraisForfait(\FrontBundle\Entity\FraisForfait $fraisForfait)
    {
        $this->fraisForfaits[] = $fraisForfait;

        return $this;
    }

    /**
     * Remove fraisForfait
     *
     * @param \FrontBundle\Entity\FraisForfait $fraisForfait
     */
    public function removeFraisForfait(\FrontBundle\Entity\FraisForfait $fraisForfait)
    {
        $this->fraisForfaits->removeElement($fraisForfait);
    }

    /**
     * Get fraisForfaits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFraisForfaits()
    {
        return $this->fraisForfaits;
    }


    /**
     * Set etat
     *
     * @param \FrontBundle\Entity\Etat $etat
     *
     * @return FicheFrais
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

    /**
     * Add fraisHorsForfait
     *
     * @param \FrontBundle\Entity\FraisHorsForfait $fraisHorsForfait
     *
     * @return FicheFrais
     */
    public function addFraisHorsForfait(\FrontBundle\Entity\FraisHorsForfait $fraisHorsForfait)
    {
        $this->fraisHorsForfait[] = $fraisHorsForfait;

        return $this;
    }

    /**
     * Remove fraisHorsForfait
     *
     * @param \FrontBundle\Entity\FraisHorsForfait $fraisHorsForfait
     */
    public function removeFraisHorsForfait(\FrontBundle\Entity\FraisHorsForfait $fraisHorsForfait)
    {
        $this->fraisHorsForfait->removeElement($fraisHorsForfait);
    }

    /**
     * Get fraisHorsForfait
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFraisHorsForfait()
    {
        return $this->fraisHorsForfait;
    }
}

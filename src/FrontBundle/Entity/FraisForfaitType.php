<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FraisForfaitType
 *
 * @ORM\Table(name="frais_forfait_type")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\FraisForfaitTypeRepository")
 */
class FraisForfaitType
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
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FraisForfait", mappedBy="fraisType", cascade={"persist", "merge"})
     */
    private $fraisForfaits;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return FraisForfaitType
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
     * @return FraisForfaitType
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
     * @return FraisForfaitType
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



}

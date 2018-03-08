<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FraisForfait
 *
 * @ORM\Table(name="frais_forfait")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\FraisForfaitRepository")
 */
class FraisForfait
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
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\FraisForfaitType", inversedBy="fraisForfaits", cascade={"persist", "merge"})
     */
    private $fraisType;

    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\FicheFrais", inversedBy="fraisForfaits", cascade={"persist", "merge"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Fiche;

    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\Etat", inversedBy="fraisForfait", cascade={"persist"})
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return FraisForfait
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
     * @return FraisForfait
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
     * Set fraisType
     *
     * @param \FrontBundle\Entity\FraisForfaitType $fraisType
     *
     * @return FraisForfait
     */
    public function setFraisType(\FrontBundle\Entity\FraisForfaitType $fraisType = null)
    {
        $this->fraisType = $fraisType;

        return $this;
    }

    /**
     * Get fraisType
     *
     * @return \FrontBundle\Entity\FraisForfaitType
     */
    public function getFraisType()
    {
        return $this->fraisType;
    }

    /**
     * Set fiche
     *
     * @param \FrontBundle\Entity\FicheFrais $fiche
     *
     * @return FraisForfait
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
     * @return FraisForfait
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

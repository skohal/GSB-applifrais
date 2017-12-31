<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etat
 *
 * @ORM\Table(name="etat")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\EtatRepository")
 */
class Etat
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
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FicheFrais", mappedBy="etat")
     */
    private $fichesFrais;

    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FraisForfait", mappedBy="etat")
     */
    private $fraisForfait;

    /**
     * @ORM\OneToMany(targetEntity="FrontBundle\Entity\FraisHorsForfait", mappedBy="etat")
     */
    private $fraisHorsForfait;



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
     * Set id
     *
     * @return Etat
     */
    public function setId($id)
    {
        $this->id = $id;


    }


    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Etat
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
     * Constructor
     */
    public function __construct()
    {
        $this->fichesFrais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fraisForfait = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fraisHorsForfait = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add fichesFrais
     *
     * @param \FrontBundle\Entity\FicheFrais $fichesFrais
     *
     * @return Etat
     */
    public function addFichesFrais(\FrontBundle\Entity\FicheFrais $fichesFrais)
    {
        $this->fichesFrais[] = $fichesFrais;

        return $this;
    }

    /**
     * Remove fichesFrais
     *
     * @param \FrontBundle\Entity\FicheFrais $fichesFrais
     */
    public function removeFichesFrais(\FrontBundle\Entity\FicheFrais $fichesFrais)
    {
        $this->fichesFrais->removeElement($fichesFrais);
    }

    /**
     * Get fichesFrais
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFichesFrais()
    {
        return $this->fichesFrais;
    }

    /**
     * Add fraisForfait
     *
     * @param \FrontBundle\Entity\FraisForfait $fraisForfait
     *
     * @return Etat
     */
    public function addFraisForfait(\FrontBundle\Entity\FraisForfait $fraisForfait)
    {
        $this->fraisForfait[] = $fraisForfait;

        return $this;
    }

    /**
     * Remove fraisForfait
     *
     * @param \FrontBundle\Entity\FraisForfait $fraisForfait
     */
    public function removeFraisForfait(\FrontBundle\Entity\FraisForfait $fraisForfait)
    {
        $this->fraisForfait->removeElement($fraisForfait);
    }

    /**
     * Get fraisForfait
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFraisForfait()
    {
        return $this->fraisForfait;
    }

    /**
     * Add fraisHorsForfait
     *
     * @param \FrontBundle\Entity\FraisHorsForfait $fraisHorsForfait
     *
     * @return Etat
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

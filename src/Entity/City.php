<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $AvgPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbAnnouncements;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * Permet l'initialisation du slug
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return void
     */

    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->name);
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvgPrice(): ?float
    {
        return $this->AvgPrice;
    }

    public function setAvgPrice(float $AvgPrice): self
    {
        $this->AvgPrice = $AvgPrice;

        return $this;
    }

    public function getNbAnnouncements(): ?int
    {
        return $this->nbAnnouncements;
    }

    public function setNbAnnouncements(int $nbAnnouncements): self
    {
        $this->nbAnnouncements = $nbAnnouncements;

        return $this;
    }

   
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}

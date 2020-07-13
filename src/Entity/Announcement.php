<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AnnouncementRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"title"},
 *     message="Another announce has already the same title ! please try choosing another one " )
 */
class Announcement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive()
     */
    private $roomNb;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(50)
     */
    private $surface;

    /**
     * @ORM\Column(type="float")
     *  @Assert\GreaterThanOrEqual(50)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $furnished;

    /**
     * @ORM\Column(type="date")
     */
    private $AvailabilityDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Smoker;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxRoomates;

    /**
     * @ORM\Column(type="boolean")
     */
    private $balcon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $garden;

    /**
     * @ORM\Column(type="boolean")
     */
    private $garage;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="announcements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="owner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserOwner;
    

    /**
     * @ORM\Column(type="datetime")
     */
    private $postedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="Announcement")
     * @Assert\Valid()
     */
    private $imagess;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CoverImage;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="appliedAnn")
     */
    private $colloc;






    public function __construct()
    {
        $this->imagess = new ArrayCollection();
        $this->userColl = new ArrayCollection();
        $this->colloc = new ArrayCollection();
    }

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
            $this->slug = $slugify->slugify($this->title);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomNb(): ?int
    {
        return $this->roomNb;
    }

    public function setRoomNb(int $roomNb): self
    {
        $this->roomNb = $roomNb;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFurnished(): ?bool
    {
        return $this->furnished;
    }

    public function setFurnished(bool $furnished): self
    {
        $this->furnished = $furnished;

        return $this;
    }

    public function getAvailabilityDate(): ?\DateTimeInterface
    {
        return $this->AvailabilityDate;
    }

    public function setAvailabilityDate(\DateTimeInterface $AvailabilityDate): self
    {
        $this->AvailabilityDate = $AvailabilityDate;

        return $this;
    }

    public function getSmoker(): ?bool
    {
        return $this->Smoker;
    }

    public function setSmoker(bool $Smoker): self
    {
        $this->Smoker = $Smoker;

        return $this;
    }

    public function getMaxRoomates(): ?int
    {
        return $this->maxRoomates;
    }

    public function setMaxRoomates(int $maxRoomates): self
    {
        $this->maxRoomates = $maxRoomates;

        return $this;
    }

    public function getBalcon(): ?bool
    {
        return $this->balcon;
    }

    public function setBalcon(bool $balcon): self
    {
        $this->balcon = $balcon;

        return $this;
    }

    public function getGarden(): ?bool
    {
        return $this->garden;
    }

    public function setGarden(bool $garden): self
    {
        $this->garden = $garden;

        return $this;
    }

    public function getGarage(): ?bool
    {
        return $this->garage;
    }

    public function setGarage(bool $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getLocatedAt(): ?City
    {
        return $this->locatedAt;
    }

    public function setLocatedAt(?City $locatedAt): self
    {
        $this->locatedAt = $locatedAt;

        return $this;
    }

    public function getUserOwner(): ?User
    {
        return $this->UserOwner;
    }

    public function setUserOwner(?User $UserOwner): self
    {
        $this->UserOwner = $UserOwner;

        return $this;
    }


    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->postedAt;
    }

    public function setPostedAt(\DateTimeInterface $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImagess(): Collection
    {
        return $this->imagess;
    }

    public function addImagess(Image $imagess): self
    {
        if (!$this->imagess->contains($imagess)) {
            $this->imagess[] = $imagess;
            $imagess->setAnnouncement($this);
        }

        return $this;
    }

    public function removeImagess(Image $imagess): self
    {
        if ($this->imagess->contains($imagess)) {
            $this->imagess->removeElement($imagess);
            // set the owning side to null (unless already changed)
            if ($imagess->getAnnouncement() === $this) {
                $imagess->setAnnouncement(null);
            }
        }

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->CoverImage;
    }

    public function setCoverImage(string $CoverImage): self
    {
        $this->CoverImage = $CoverImage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getColloc(): Collection
    {
        return $this->colloc;
    }

    public function addColloc(User $colloc): self
    {
        if (!$this->colloc->contains($colloc)) {
            $this->colloc[] = $colloc;
            $colloc->setAppliedAnn($this);
        }

        return $this;
    }

    public function removeColloc(User $colloc): self
    {
        if ($this->colloc->contains($colloc)) {
            $this->colloc->removeElement($colloc);
            // set the owning side to null (unless already changed)
            if ($colloc->getAppliedAnn() === $this) {
                $colloc->setAppliedAnn(null);
            }
        }

        return $this;
    }



}

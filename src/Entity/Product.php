<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_path;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $create_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $create_who;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $update_who;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductTag", mappedBy="product_id", orphanRemoval=true)
     */
    private $productTags;

    public function __construct()
    {
        $this->productTags = new ArrayCollection();
    }

    public function getId()
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

    public function getImgPath()
    {
        return $this->img_path;
    }

    public function setImgPath($img_path)
    {
        $this->img_path = $img_path;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateAt(): ?int
    {
        return $this->create_at;
    }

    public function setCreateAt(?int $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getCreateWho(): ?string
    {
        return $this->create_who;
    }

    public function setCreateWho(?string $create_who): self
    {
        $this->create_who = $create_who;

        return $this;
    }

    public function getUpdateAt(): ?int
    {
        return $this->update_at;
    }

    public function setUpdateAt(?int $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getUpdateWho(): ?string
    {
        return $this->update_who;
    }

    public function setUpdateWho(?string $update_who): self
    {
        $this->update_who = $update_who;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection|ProductTag[]
     */
    public function getProductTags(): Collection
    {
        return $this->productTags;
    }

    public function addProductTag(ProductTag $productTag): self
    {
        if (!$this->productTags->contains($productTag)) {
            $this->productTags[] = $productTag;
            $productTag->setProductId($this);
        }

        return $this;
    }

    public function removeProductTag(ProductTag $productTag): self
    {
        if ($this->productTags->contains($productTag)) {
            $this->productTags->removeElement($productTag);
            // set the owning side to null (unless already changed)
            if ($productTag->getProductId() === $this) {
                $productTag->setProductId(null);
            }
        }

        return $this;
    }
}

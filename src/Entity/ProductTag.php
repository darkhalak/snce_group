<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductTagRepository")
 */
class ProductTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productTags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag", inversedBy="productTags")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag_id;

    public function getId()
    {
        return $this->id;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getTagId(): ?Tag
    {
        return $this->tag_id;
    }

    public function setTagId(?Tag $tag_id): self
    {
        $this->tag_id = $tag_id;

        return $this;
    }
}

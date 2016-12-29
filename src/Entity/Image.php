<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Image implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $path;

    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var int */
    protected $sortOrder;

    /** @var Product */
    protected $product;

    /** @var Tag */
    protected $tag;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
        $this->setSortOrder(0);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('path', new Assert\NotBlank);
        $metadata->addPropertyConstraint('path', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('width', new Assert\NotNull);
        $metadata->addPropertyConstraint('width', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('height', new Assert\NotNull);
        $metadata->addPropertyConstraint('height', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('sortOrder', new Assert\NotNull);
        $metadata->addPropertyConstraint('sortOrder', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = (int) $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }
}

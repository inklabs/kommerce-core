<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ImageDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Image implements EntityInterface, ValidationInterface
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

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

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

    public function getDTOBuilder()
    {
        return new ImageDTOBuilder($this);
    }
}

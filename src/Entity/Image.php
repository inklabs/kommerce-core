<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
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

    /** @var Product|null */
    protected $product;

    /** @var Tag|null */
    protected $tag;

    public function __construct(string $path, int $width, int $height, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->setSortOrder(0);
        $this->path = $path;
        $this->width = $width;
        $this->height = $height;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('path', new Assert\NotNull);
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

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setWidth(int $width)
    {
        $this->width = $width;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setHeight(int $height)
    {
        $this->height = $height;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setSortOrder(int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }
}

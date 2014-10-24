<?php
namespace inklabs\kommerce\Entity;

class Image
{
    use Accessor\Time;

    protected $id;
    protected $path;
    protected $width;
    protected $height;
    protected $sortOrder = 0;

    protected $product;
    protected $tag;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getId()
    {
        return $this->id;
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
        $this->sortOrder = (string)$sortOrder;
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

    public function getView()
    {
        return new View\Image($this);
    }
}

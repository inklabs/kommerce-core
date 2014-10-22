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

    public function getData()
    {
        $class = new \stdClass;
        $class->id        = $this->getId();
        $class->path      = $this->getPath();
        $class->width     = $this->getWidth();
        $class->height    = $this->getHeight();
        $class->sortOrder = $this->getSortOrder();

        return $class;
    }
}

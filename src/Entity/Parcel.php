<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ParcelDTOBuilder;

class Parcel
{
    use TimeTrait;

    /** @var string */
    protected $externalId;

    /** @var float */
    protected $length;

    /** @var float */
    protected $width;

    /** @var float */
    protected $height;

    /** @var int */
    protected $weight;

    /** @var string */
    protected $predefinedPackage;

    public function __construct()
    {
        $this->setCreated();
    }

    /**
     * @param string $externalId
     */
    public function setExternalId($externalId)
    {
        $this->externalId = (string) $externalId;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = (float) $length;
    }

    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = (float) $width;
    }

    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = (float) $height;
    }

    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = (int) $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $predefinedPackage
     */
    public function setPredefinedPackage($predefinedPackage)
    {
        $this->predefinedPackage = (string) $predefinedPackage;
    }

    public function getPredefinedPackage()
    {
        return $this->predefinedPackage;
    }
}

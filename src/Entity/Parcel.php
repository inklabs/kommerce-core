<?php
namespace inklabs\kommerce\Entity;

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

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = (float) $length;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = (float) $width;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = (float) $height;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = (int) $weight;
    }

    /**
     * @param string $predefinedPackage
     */
    public function setPredefinedPackage($predefinedPackage)
    {
        $this->predefinedPackage = (string) $predefinedPackage;
    }
}

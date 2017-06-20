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

    /** @var string|null */
    protected $predefinedPackage;

    public function __construct()
    {
        $this->setCreated();
    }

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setLength(float $length)
    {
        $this->length = $length;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function setWidth(float $width)
    {
        $this->width = $width;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function setHeight(float $height)
    {
        $this->height = $height;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setWeight(int $weight)
    {
        $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setPredefinedPackage(string $predefinedPackage)
    {
        $this->predefinedPackage = $predefinedPackage;
    }

    public function getPredefinedPackage(): ?string
    {
        return $this->predefinedPackage;
    }
}

<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentLabel implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var string */
    protected $externalId;

    /** @var int */
    protected $resolution;

    /** @var string */
    protected $size;

    /** @var string */
    protected $type;

    /** @var string */
    protected $fileType;

    /** @var string */
    protected $url;

    /** @var string */
    protected $pdfUrl;

    /** @var string */
    protected $epl2Url;

    /** @var string */
    protected $zplUrl;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('externalId', new Assert\Length([
            'max' => 60,
        ]));

        $metadata->addPropertyConstraint('resolution', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('size', new Assert\Length([
            'max' => 10,
        ]));

        $metadata->addPropertyConstraint('type', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('fileType', new Assert\Length([
            'max' => 20,
        ]));

        $metadata->addPropertyConstraint('url', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('pdfUrl', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('epl2Url', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('zplUrl', new Assert\Length([
            'max' => 255,
        ]));
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

    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param int $resolution
     */
    public function setResolution($resolution)
    {
        $this->resolution = (int) $resolution;
    }

    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = (string) $size;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = (string) $type;
    }

    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = (string) $fileType;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = (string) $url;
    }

    public function getPdfUrl()
    {
        return $this->pdfUrl;
    }

    /**
     * @param string $pdfUrl
     */
    public function setPdfUrl($pdfUrl)
    {
        $this->pdfUrl = (string) $pdfUrl;
    }

    public function getEpl2Url()
    {
        return $this->epl2Url;
    }

    /**
     * @param string $epl2Url
     */
    public function setEpl2Url($epl2Url)
    {
        $this->epl2Url = (string) $epl2Url;
    }

    public function getZplUrl()
    {
        return $this->zplUrl;
    }

    /**
     * @param string $zplUrl
     */
    public function setZplUrl($zplUrl)
    {
        $this->zplUrl = (string) $zplUrl;
    }
}

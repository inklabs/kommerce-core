<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentLabel implements ValidationInterface
{
    /** @var string|null */
    protected $externalId;

    /** @var int|null */
    protected $resolution;

    /** @var string|null */
    protected $size;

    /** @var string|null */
    protected $type;

    /** @var string|null */
    protected $fileType;

    /** @var string|null */
    protected $url;

    /** @var string|null */
    protected $pdfUrl;

    /** @var string|null */
    protected $epl2Url;

    /** @var string|null */
    protected $zplUrl;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
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

    public function setExternalId(string $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getResolution(): ?int
    {
        return $this->resolution;
    }

    public function setResolution(int $resolution)
    {
        $this->resolution = $resolution;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size)
    {
        $this->size = $size;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType)
    {
        $this->fileType = $fileType;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getPdfUrl(): ?string
    {
        return $this->pdfUrl;
    }

    public function setPdfUrl(string $pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function getEpl2Url(): ?string
    {
        return $this->epl2Url;
    }

    public function setEpl2Url(string $epl2Url)
    {
        $this->epl2Url = $epl2Url;
    }

    public function getZplUrl(): ?string
    {
        return $this->zplUrl;
    }

    public function setZplUrl(string $zplUrl)
    {
        $this->zplUrl = $zplUrl;
    }
}

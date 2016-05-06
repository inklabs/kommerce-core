<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Attachment implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var bool */
    protected $isVisible;

    /** @var bool */
    protected $isLocked;

    /** @var string */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->setCreated();
        $this->setFilePath($filePath);
        $this->setVisible();
        $this->setUnlocked();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('filePath', new Assert\NotBlank);
        $metadata->addPropertyConstraint('filePath', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     */
    private function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function isVisible()
    {
        return $this->isVisible;
    }

    public function setNotVisible()
    {
        $this->isVisible = false;
    }

    private function setVisible()
    {
        $this->isVisible = true;
    }

    public function isLocked()
    {
        return $this->isLocked;
    }

    public function setLocked()
    {
        $this->isLocked = true;
    }

    public function setUnlocked()
    {
        $this->isLocked = false;
    }
}

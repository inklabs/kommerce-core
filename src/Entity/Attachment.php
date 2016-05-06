<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Attachment implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $path;

    /** @var string */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->setCreated();
        $this->setFilePath($filePath);
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
}

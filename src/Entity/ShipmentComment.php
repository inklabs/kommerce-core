<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ShipmentCommentDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class ShipmentComment implements EntityInterface, ValidationInterface
{
    use IdTrait, TimeTrait;

    /** @var string */
    protected $comment;

    /**
     * @param string $comment
     */
    public function __construct($comment)
    {
        $this->comment = (string) $comment;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('comment', new Assert\NotBlank);
        $metadata->addPropertyConstraint('comment', new Assert\Length([
            'max' => 65535,
        ]));
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getDTOBuilder()
    {
        return new ShipmentCommentDTOBuilder($this);
    }
}

<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\AttachmentException;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class UserProductAttachment implements IdEntityInterface, ValidationInterface
{
    use CreatedTrait, IdTrait, EventGeneratorTrait, StringSetterTrait;

    /** @var User */
    private $user;

    /** @var Product */
    private $product;

    /** @var Attachment */
    private $attachment;

    public function __construct(User $user, Product $product, Attachment $attachment, UuidInterface $id = null)
    {
        if (! $product->areAttachmentsEnabled()) {
            throw AttachmentException::notAllowed();
        }

        $this->setId($id);
        $this->setCreated();
        $this->user = $user;
        $this->product = $product;
        $this->attachment = $attachment;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('user', new Assert\Valid);
        $metadata->addPropertyConstraint('product', new Assert\Valid);
        $metadata->addPropertyConstraint('attachment', new Assert\Valid);
    }
}

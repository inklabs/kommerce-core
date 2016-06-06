<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CatalogPromotion extends AbstractPromotion
{
    /** @var string */
    protected $code;

    /** @var Tag */
    protected $tag;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
        $metadata->addPropertyConstraint('code', new Assert\Length([
            'max' => 16,
        ]));
    }

    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function isValid(DateTime $date, Product $product)
    {
        return $this->isValidPromotion($date)
            and $this->isTagValid($product);
    }

    public function isTagValid(Product $product)
    {
        if ($this->tag === null) {
            return true;
        }

        foreach ($product->getTags() as $tag) {
            if (($tag->getId() !== null) and ($tag->getId() == $this->tag->getId())) {
                return true;
            }
        }

        return false;
    }
}

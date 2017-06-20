<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CatalogPromotion extends AbstractPromotion
{
    /**
     * @var string
     * @deprecated
     * */
    protected $code = 'd';

    /** @var Tag|null */
    protected $tag;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        parent::loadValidatorMetadata($metadata);

        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
        $metadata->addPropertyConstraint('code', new Assert\Length([
            'max' => 16,
        ]));
    }

    /**
     * @param $code
     * @deprecated
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getCode(): string
    {
        return $this->code;
    }

    public function setTag(Tag $tag = null)
    {
        $this->tag = $tag;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function isValid(DateTime $date, Product $product): bool
    {
        return $this->isValidPromotion($date)
            and $this->isTagValid($product);
    }

    public function isTagValid(Product $product): bool
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

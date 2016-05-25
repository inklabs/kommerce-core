<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CatalogPromotion extends AbstractPromotion
{
    // TODO: Remove after uuid_migration
    protected $tag_uuid;

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

    /**
     * @return CatalogPromotionDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new CatalogPromotionDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setTagUuid(UuidInterface $uuid)
    {
        $this->tag_uuid = $uuid;
    }
}

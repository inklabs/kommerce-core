<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

trait PromotionRedemptionTrait
{
    /** @var int */
    protected $redemptions;

    /** @var int|null */
    protected $maxRedemptions;

    public static function loadPromotionRedemptionValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('redemptions', new Assert\NotNull);
        $metadata->addPropertyConstraint('redemptions', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('maxRedemptions', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function isRedemptionCountValid(): bool
    {
        if ($this->maxRedemptions === null) {
            return true;
        } elseif ($this->redemptions < $this->maxRedemptions) {
            return true;
        } else {
            return false;
        }
    }

    public function setRedemptions(int $redemptions)
    {
        $this->redemptions = $redemptions;
    }

    public function getRedemptions(): int
    {
        return $this->redemptions;
    }

    public function setMaxRedemptions(?int $maxRedemptions)
    {
        $this->maxRedemptions = $maxRedemptions;
    }

    public function getMaxRedemptions(): ?int
    {
        return $this->maxRedemptions;
    }
}

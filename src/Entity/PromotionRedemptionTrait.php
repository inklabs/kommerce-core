<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

trait PromotionRedemptionTrait
{
    /** @var int */
    protected $redemptions;

    /** @var int */
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

    public function isRedemptionCountValid()
    {
        if ($this->maxRedemptions === null) {
            return true;
        } elseif ($this->redemptions < $this->maxRedemptions) {
            return true;
        } else {
            return false;
        }
    }

    public function setRedemptions($redemptions)
    {
        $this->redemptions = (int) $redemptions;
    }

    public function getRedemptions()
    {
        return $this->redemptions;
    }

    public function setMaxRedemptions($maxRedemptions)
    {
        $this->maxRedemptions = $maxRedemptions;
    }

    public function getMaxRedemptions()
    {
        return $this->maxRedemptions;
    }
}

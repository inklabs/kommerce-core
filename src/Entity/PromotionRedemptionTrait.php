<?php
namespace inklabs\kommerce\Entity;

trait PromotionRedemptionTrait
{
    /** @var int */
    protected $redemptions;

    /** @var int */
    protected $maxRedemptions;

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

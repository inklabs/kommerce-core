<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
{
    protected $id;
    protected $name;
    protected $discountType;
    protected $value;
    protected $flagFreeShipping;
    protected $redemptions;
    protected $maxRedemptions;
    protected $start;
    protected $end;
    protected $created;
    protected $updated;
    protected $tag;

    protected $code;

    public function setCode($code)
    {
        $this->code = $code;
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

    public function setFlagFreeShipping($flagFreeShipping)
    {
        $this->flagFreeShipping = $flagFreeShipping;
    }

    public function getFlagFreeShipping()
    {
        return $this->flagFreeShipping;
    }

    public function isValid(\DateTime $date, Product $product)
    {
        return $this->isValidPromotion($date)
            and $this->isTagValid($product);
    }

    public function isTagValid(Product $product)
    {
        if ($this->tag !== null) {
            foreach ($product->getTags() as $tag) {
                if ($tag == $this->tag) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}

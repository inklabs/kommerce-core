<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
{
    protected $id;
    protected $name;
    protected $discountType;
    protected $value;
    protected $redemptions;
    protected $maxRedemptions;
    protected $start;
    protected $end;
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

    public function isValid(\DateTime $date, Product $product)
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

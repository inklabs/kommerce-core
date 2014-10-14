<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
{
    protected $code;
    protected $tag;
    protected $flagFreeShipping;

    public function setCdoe($cdoe)
    {
        $this->cdoe = $cdoe;
    }

    public function getCdoe()
    {
        return $this->cdoe;
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

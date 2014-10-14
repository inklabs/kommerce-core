<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
{
    use Accessors;

    public $id;
    public $code;
    public $name;
    public $tag;
    public $free_shipping;
    public $redemptions;
    public $max_redemptions;
    public $start;
    public $end;
    public $created;

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

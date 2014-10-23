<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CatalogPromotion extends Promotion
{
    public $tag;
    public $flagFreeShipping;
    public $code;

    public function __construct(Entity\CatalogPromotion $catalogPromotion)
    {
        parent::__construct($catalogPromotion);

        $this->flagFreeShipping = $catalogPromotion->getFlagFreeShipping();
        $this->code             = $catalogPromotion->getCode();
    }

    public function withTag()
    {
        $this->tag = $this->promotion->getTag();
        if (! empty($this->tag)) {
            $this->tag = $this->tag
                ->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag();
    }
}

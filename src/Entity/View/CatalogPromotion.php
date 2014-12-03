<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CatalogPromotion extends Promotion
{
    public $code;

    /* @var Tag */
    public $tag;

    public function __construct(Entity\CatalogPromotion $catalogPromotion)
    {
        parent::__construct($catalogPromotion);

        $this->code = $catalogPromotion->getCode();
    }

    public static function factory(Entity\CatalogPromotion $catalogPromotion)
    {
        return new static($catalogPromotion);
    }

    public function withTag()
    {
        $this->tag = $this->promotion->getTag();
        if (! empty($this->tag)) {
            $this->tag = Tag::factory($this->tag)
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

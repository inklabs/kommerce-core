<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CatalogPromotion extends AbstractPromotion
{
    public $code;

    /** @var Tag */
    public $tag;

    public function __construct(Entity\CatalogPromotion $catalogPromotion)
    {
        parent::__construct($catalogPromotion);

        $this->code = $catalogPromotion->getCode();
    }

    public function withTag()
    {
        $this->tag = $this->promotion->getTag();
        if (! empty($this->tag)) {
            $this->tag = $this->tag->getView()
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

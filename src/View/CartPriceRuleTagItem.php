<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class CartPriceRuleTagItem extends AbstractCartPriceRuleItem
{
    /** @var View\Tag */
    public $tag;

    public function __construct(Entity\AbstractCartPriceRuleItem $item)
    {
        parent::__construct($item);
    }

    public function withTag()
    {
        $tag = $this->item->getTag();
        if (! empty($tag)) {
            $this->tag = $tag->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag()
            ->export();
    }
}

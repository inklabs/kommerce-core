<?php
namespace inklabs\kommerce\Entity\View\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;

class Tag extends Item
{
    /** @var View\Tag */
    public $tag;

    public function __construct(Entity\CartPriceRuleItem\Item $item)
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

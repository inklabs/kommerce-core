<?php
namespace inklabs\kommerce\View\CartPriceRuleItem;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Tag extends AbstractItem
{
    /** @var View\Tag */
    public $tag;

    public function __construct(Entity\CartPriceRuleItem\AbstractItem $item)
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

<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Option
{
    public $id;
    public $name;
    public $type;
    public $description;
    public $sortOrder;

    /* @var Product[] */
    public $products;

    public function __construct(Entity\Option $option)
    {
        $this->option = $option;

        $this->id          = $option->getId();
        $this->name        = $option->getName();
        $this->type        = $option->getType();
        $this->description = $option->getDescription();
        $this->sortOrder   = $option->getSortOrder();
    }

    public function export()
    {
        unset($this->option);
        return $this;
    }

    public function withProducts()
    {
        foreach ($this->option->getProducts() as $product) {
            $this->products[] = $product->getView()->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProducts();
    }
}

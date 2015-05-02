<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class TextOption
{
    /** @var int */
    public $id;

    /** @var string */
    public $encodedId;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var int */
    public $sortOrder;

    /** @var int */
    public $type;

    /** @var Tag[] */
    public $tags = [];

    public $created;
    public $updated;

    public function __construct(Entity\TextOption $textOption)
    {
        $this->textOption = $textOption;

        $this->id          = $textOption->getId();
        $this->encodedId   = Lib\BaseConvert::encode($textOption->getId());
        $this->name        = $textOption->getname();
        $this->description = $textOption->getDescription();
        $this->sortOrder   = $textOption->getSortOrder();
        $this->type        = $textOption->getType();
        $this->created     = $textOption->getCreated();
        $this->updated     = $textOption->getUpdated();
    }

    public function export()
    {
        unset($this->textOption);
        return $this;
    }

    public function withTags()
    {
        foreach ($this->textOption->getTags() as $tag) {
            $this->tags[] = $tag->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTags();
    }
}

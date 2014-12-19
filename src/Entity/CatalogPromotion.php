<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
{
    protected $code;

    /* @var Tag */
    protected $tag;

    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    public function isValid(\DateTime $date, Product $product)
    {
        return $this->isValidPromotion($date)
            and $this->isTagValid($product);
    }

    public function isTagValid(Product $product)
    {
        if ($this->tag === null) {
            return true;
        }

        foreach ($product->getTags() as $tag) {
            if (($tag->getId() !== null) and ($tag->getId() == $this->tag->getId())) {
                return true;
            }
        }

        return false;
    }

    public function getView()
    {
        return new View\CatalogPromotion($this);
    }
}

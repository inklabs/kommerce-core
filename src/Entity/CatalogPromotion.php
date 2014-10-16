<?php
namespace inklabs\kommerce\Entity;

/**
 * @Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 * @Table(name="catalog_promotion")
 **/
class CatalogPromotion extends Promotion
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $name;

    /** @Column(type="string", name="discount_type") **/
    protected $discountType;

    /** @Column(type="integer", name="discount_value") **/
    protected $value;

    /** @Column(type="boolean", name="free_shipping") **/
    protected $flagFreeShipping;

    /** @Column(type="integer") **/
    protected $redemptions;

    /** @Column(type="integer", name="max_redemptions") **/
    protected $maxRedemptions;

    /** @Column(type="date") **/
    protected $start;

    /** @Column(type="date") **/
    protected $end;

    /** @Column(type="integer") **/
    protected $created;

    /** @Column(type="integer") **/
    protected $updated;

    protected $code;

    /**
     * @ManyToOne(targetEntity="Tag", fetch="EAGER")
    **/
    protected $tag;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setFlagFreeShipping($flagFreeShipping)
    {
        $this->flagFreeShipping = $flagFreeShipping;
    }

    public function getFlagFreeShipping()
    {
        return $this->flagFreeShipping;
    }

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

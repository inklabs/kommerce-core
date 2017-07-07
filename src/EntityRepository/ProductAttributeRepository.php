<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Lib\UuidInterface;

class ProductAttributeRepository extends AbstractRepository implements ProductAttributeRepositoryInterface
{
    public function getByAttributeValue(UuidInterface $attributeValueId, Pagination & $pagination = null)
    {
        $productAttributes = $this->getQueryBuilder()
            ->select('ProductAttribute')
            ->addSelect('Product')
            ->addSelect('Attribute')
            ->addSelect('AttributeValue')
            ->from(ProductAttribute::class, 'ProductAttribute')
            ->innerJoin('ProductAttribute.product', 'Product')
            ->innerJoin('ProductAttribute.attribute', 'Attribute')
            ->innerJoin('ProductAttribute.attributeValue', 'AttributeValue')
            ->where('ProductAttribute.attributeValue = :attributeValueId')
            ->setIdParameter('attributeValueId', $attributeValueId)
            ->productActiveAndVisible()
            ->productAvailable()
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        $this->loadProductTagsFromProductAttributes($productAttributes);

        return $productAttributes;
    }

    /**
     * @param ProductAttribute[] $productAttributes
     */
    public function loadProductTagsFromProductAttributes(array & $productAttributes)
    {
        $this->getQueryBuilder()
            ->select('Product')
            ->from(Product::class, 'Product')
            ->innerJoin(
                ProductAttribute::class,
                'ProductAttribute',
                'WITH',
                'ProductAttribute.product = Product.id'
            )
            ->where('ProductAttribute.id IN (:productAttributeIds)')
            ->addSelect('tag2')
            ->leftJoin('Product.tags', 'tag2')
            ->setEntityParameter('productAttributeIds', $productAttributes)
            ->getQuery()
            ->getResult();
    }
}

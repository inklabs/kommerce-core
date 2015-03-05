<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Product extends Lib\ServiceManager
{
    /* @var Pricing */
    private $pricing;

    /* @var EntityRepository\Product */
    private $productRepository;

    public function __construct(EntityManager $entityManager, Pricing $pricing)
    {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
        $this->productRepository = $entityManager->getRepository('kommerce:Product');
    }

    /**
     * @return Entity\View\Product|null
     */
    public function find($id)
    {
        $entityProduct = $this->productRepository->find($id);

        if ($entityProduct === null) {
            return null;
        }

        return $entityProduct->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @throws ValidatorException
     */
    public function edit($id, Entity\View\Product $newProduct)
    {
        /* @var Entity\Product $product */
        $product = $this->productRepository->find($id);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        $product->setName($newProduct->name);
        $product->setUnitPrice($newProduct->unitPrice);
        $product->setQuantity($newProduct->quantity);
        $product->setIsInventoryRequired($newProduct->isInventoryRequired);
        $product->setIsPriceVisible($newProduct->isPriceVisible);
        $product->setIsActive($newProduct->isActive);
        $product->setIsVisible($newProduct->isVisible);
        $product->setIsTaxable($newProduct->isTaxable);
        $product->setIsShippable($newProduct->isShippable);
        $product->setSku($newProduct->sku);
        $product->setShippingWeight($newProduct->shippingWeight);
        $product->setDescription($newProduct->description);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            $exception = new ValidatorException;
            $exception->errors = $errors;
            throw $exception;
        }

        $this->entityManager->flush();
    }

    public function getAllProducts($queryString = null, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getAllProducts($queryString, $pagination);

        return $this->getViewProducts($products);
    }

    public function getRelatedProducts($products, $limit = 12)
    {
        if (! is_array($products)) {
            $products = [$products];
        }

        $productIds = [];
        $tagIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
            foreach ($product->tags as $tag) {
                $tagIds[] = $tag->id;
            }
        }

        $products = $this->productRepository
            ->getRelatedProductsByIds($productIds, $tagIds, $limit);

        return $this->getViewProductsWithPrice($products);
    }

    public function getProductsByTag(Entity\View\Tag $tag, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getProductsByTagId($tag->id);

        return $this->getViewProductsWithPrice($products);
    }

    public function getProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getProductsByIds($productIds);

        return $this->getViewProductsWithPrice($products);
    }

    public function getAllProductsByIds($productIds, Entity\Pagination & $pagination = null)
    {
        $products = $this->productRepository
            ->getAllProductsByIds($productIds);

        return $this->getViewProductsWithPrice($products);
    }

    public function getRandomProducts($limit)
    {
        $products = $this->productRepository
            ->getRandomProducts($limit);

        return $this->getViewProductsWithPrice($products);
    }

    /**
     * @param Entity\Product[] $products
     * @return Entity\View\Product[]
     */
    private function getViewProductsWithPrice($products)
    {
        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = $product->getView()
                ->withPrice($this->pricing)
                ->export();
        }

        return $viewProducts;
    }

    /**
     * @param Entity\Product[] $products
     * @return Entity\View\Product[]
     */
    private function getViewProducts($products)
    {
        $viewProducts = [];
        foreach ($products as $product) {
            $viewProducts[] = $product->getView()
                ->export();
        }

        return $viewProducts;
    }
}

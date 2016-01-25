# Strategy Design Pattern

This design pattern allows algorithms to evolve independently from clients that apply them.

In this project we have a
[PricingInterface](../../../src/Lib/PricingInterface.php)
to support any pricing strategy algorithm. The
[PricingCalculator](../../../src/Lib/PricingCalculator.php)
algorithm currently takes into account
[CatalogPromotions](../../../src/Entity/CatalogPromotion.php)
and
[ProductQuantityDiscounts](../../../src/Entity/ProductQuantityDiscount.php)
in the strategy for retrieving a product price.

## Also Known As

* Policy Design Pattern

## Example

### Product Entity

```php
class Product
{
    public function getPrice(PricingInterface $pricing, int $quantity = 1)
    {
        return $pricing->getPrice(
            $this,
            $quantity
        );
    }
```

### PricingInterface

```php
interface PricingInterface
{
    public function getPrice(Product $product, int $quantity);
}

```

### Pricing Implementation

```php
class Pricing implements PricingInterface
{
    public function getPrice(Product $product, int $quantity)
    {
        $pricingCalculator = new PricingCalculator($this);
        return $pricingCalculator->getPrice($product, $quantity);
    }
}

```

### Pricing Calculator Strategy with Catalog Promotions and Product Quantity Discounts

```php
<?php
class PricingCalculator
{
    public function getPrice(Product $product, int $quantity)
    {
        $this->initializePrice();
        $this->calculateProductQuantityDiscounts();
        $this->calculateCatalogPromotions();
        $this->calculateQuantityPrice();

        return $this->price;
    }
}
```

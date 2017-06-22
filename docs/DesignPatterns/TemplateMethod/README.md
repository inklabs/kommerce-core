# Template Method Design Pattern

The **template method design pattern** outlines the skeleton of an operation to be overridden at
compile-time via subclassing. This is different from the [Strategy Pattern](../Strategy) which
defines alternate algorithms at run-time.

## Example

In this project we use a
[ProductRepositoryDecorator](../../../src/EntityRepository/ProductRepositoryDecorator.php) [deprecated]
template which is extended by decorating classes. Below, an audit logging decorator
extends the ProductRepositoryDecorator template and overrides any methods that need logging.
With this strategy, we avoid needing to implement every method from the
[ProductRepositoryInterface](../../../src/EntityRepository/ProductRepositoryInterface.php)
just to log when a product is updated.

```php
class LoggingProductRepository extends ProductRepositoryDecorator
{
    public function update(EntityInterface & $entity): void
    {
        $result = parent::update($entity);
        $this->log('Product Updated: ' . $entity->getId());
        return $result;
    }
}
```

# Decorator Design Pattern

The decorator pattern is used to attach additional responsibilities to an object
dynamically at run time. This is opposed to sub-classing or inheritance which is restricted
to static or compile-time construction.

## Also Known As

* Wrapper Design Pattern

## Example

We use the **decorator design pattern** inside the
[ServiceFactory](../../../src/Service/ServiceFactory.php) and
[RepositoryFactory](../../../src/EntityRepository/RepositoryFactory.php) classes. This allows for
a single location where these service and repository objects are constructed. With this
structure, we can compose additional responsibilities without changing existing code.
This is a primary principle of object-oriented design which **favors object composition over class inheritance**.

### Repository Factory

```php
class RepositoryFactory
{
    public function getProductRepository()
    {
        $productRepository =
            new LoggingProductRepository(
                new CachingProductRepository(
                    $this->entityManager->getRepository('kommerce:Product')
                )
            )
        );
    }

    // ...
}
```

### Query

```php
    $productRepository = $this->repositoryFactory->getProductRepository();
    $product = $productRepository->findOneById(1);
```

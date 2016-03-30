# Abstract Factory Design Pattern

The abstract factory pattern is used to create objects without specifying their concrete classes.

## Also Known As

* Kit Design Pattern

## Example

In this project, we use the **abstract factory pattern** to construct our Services and Repositories
via the [ServiceFactory](../../../src/Service/ServiceFactory.php) and
[RepositoryFactory](../../../src/EntityRepository/RepositoryFactory.php). This allows us to assemble
dependencies for our services and repositories while preferring object composition over inheritance.
We are using this pattern as a tool for **Dependency Injection**. This also allows us to implement
the [Decorator](../Decorator) Pattern.

### Service Factory

```php
class ServiceFactory
{
    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }

    public function getProductService()
    {
        return new ProductService(
            $this->repositoryFactory->getProductRepository(),
        );
    }

    // ...
}
```

### Repository Factory

```php
class RepositoryFactory
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getProductRepository()
    {
        return $this->entityManager->getRepository(Product::class);
    }

    // ...
}
```

### Main Application - Controller

```php
class ProductController extends ApplicationController
{
    public function action_view()
    {
        $productId = $this->request->param('id');

        $productService = $this->serviceFactory->getProductService();
        $product = $productService->findOneById($productId);

        // ...
    }
}
```

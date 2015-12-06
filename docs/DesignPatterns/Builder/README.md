# Builder Design Pattern

The builder design pattern is used to construct complex objects that would otherwise be monotonous to assemble.

In this project, we prefer to avoid exposing objects with behavior to the frontend UI. We use the **builder pattern**
in this **PHP project** to convert the domain Entities into Data Transfer Objects. These DTOs are
simple anemic objects containing no business logic. Perfect for use inside templates within the view layer.

## Example

In this example, we would like to view a single product with all of the associated images and tags.
Below is how your code would be organized after retrieving a [Product](../../src/Entity/Product.php) Entity.
We use the [ProductDTOBuilder](../../src/EntityDTO/Builder/ProductDTOBuilder.php) class to construct
a [ProductDTO](../../src/EntityDTO/ProductDTO.php).

### Query

```php
    $product = $productRepository->findOneById(1);

    $productDTO = $product->getDTOBuilder()
        ->withImages()
        ->withTags()
        ->build;
```

### View

```php
    <h1>$productDTO->name</h1>

    <h2>Images:</h2>
    <?php foreach ($productDTO->images as $imageDTO) { ?>
        <img src="<?=$imageDTO->path?>" />
    <?php } ?>


    <h2>Tags:</h2>
    <?php foreach ($productDTO->tags as $tagDTO) { ?>
        <h3><?=$tagDTO->name?></h3>
    <?php } ?>
```

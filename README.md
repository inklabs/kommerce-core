Zen Kommerce Core
=================
[![Test Coverage](http://img.shields.io/badge/coverage-100%25-brightgreen.svg)](https://codeclimate.com/github/inklabs/kommerce-core)
[![Build Status](https://travis-ci.org/inklabs/kommerce-core.svg?branch=master)](https://travis-ci.org/inklabs/kommerce-core)
[![Downloads](https://img.shields.io/packagist/dt/inklabs/kommerce-core.svg)](https://packagist.org/packages/inklabs/kommerce-core)
[![Apache License 2.0](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg)](https://github.com/inklabs/kommerce-core/blob/master/LICENSE.txt)

## Introduction

Zen Kommerce is a PHP shopping cart system written with SOLID design principles.
It is PSR compatible, dependency free, and contains 100% code coverage using TDD practices.

All code (including tests) conform to the PSR-2 coding standards. The namespace and autoloader
are using the PSR-4 standard.

## Description

This project is over 25,000 lines of code. Unit tests account for 30-40% of that total. There are four
main modules in this project:

* Entities (src/Entity)
    - These are plain old PHP objects. You will not find any ORM code or external dependencies here. This is where
      object relationships are constructed.

      ```php
      $product = new Entity\Product;
      $product->setName('Test Product');
      $product->setUnitPrice(500);
      $product->addTag(new Tag);
      ```

* Libraries (src/Lib)
    - This is where you will find a variety of utility code including the Payment Gateway (src/Lib/PaymentGateway).

      ```php
      $creditCard = new Entity\CreditCard;
      $creditCard->setName('John Doe');
      $creditCard->setZip5('90210');
      $creditCard->setNumber('4242424242424242');
      $creditCard->setCvc('123');
      $creditCard->setExpirationMonth('1');
      $creditCard->setExpirationYear('2020');

      $chargeRequest = new Lib\PaymentGateway\ChargeRequest;
      $chargeRequest->setCreditCard($creditCard);
      $chargeRequest->setAmount(2000);
      $chargeRequest->setCurrency('usd');
      $chargeRequest->setDescription('test@example.com');

      $stripe = new Lib\PaymentGateway\StripeFake;
      $charge = $stripe->getCharge($chargeRequest);
      ```

* Services (src/Service)
    - These are the interactors that manage the choreography between entities and the database via
      an EntityRepository. There is heavy dependency injection into the constructors in this layer.
      Services know about Entities and always return a View object.

      ```php
      $productService = new Service\Product(
          $this->productRepository,
          $this->tagRepository
      );

      $productId = 1;
      $viewProduct = $productService->find($productId);
      $viewProduct->sku = 'NEW-SKU';

      $productService->edit($productId, $viewProduct);
      ```

* Views (src/View)
    - Often you want to use your entities as plain value objects in your main application, typically in your view
      templates. These classes act as a decorator to Entities. They format the entities as simple objects with public
      class member variables. The complete network relationship graph are also available if you request them
      (e.g., withAllData()).

      ```php
      $product = new Entity\Product;
      $product->addTag(new Entity\Tag);

      $viewProduct = new View\Product($product)
        ->withAllData(new Lib\Pricing)
        ->export();

      echo $viewProduct->sku;
      echo $viewProduct->price->unitPrice;
      echo $viewProduct->tags[0]->name;
      ```

## Installation

Add the following lines to your ``composer.json`` file.

```JSON
{
    "require": {
        "inklabs/kommerce-core": "dev-master"
    }
}
```

```
   composer install
```

## Unit Tests:

<pre>
    vendor/bin/phpunit
</pre>

### With Code Coverage:

<pre>
    vendor/bin/phpunit --coverage-text --coverage-html coverage_report
</pre>

## Run Coding Standards Test:

<pre>
    vendor/bin/phpcs --standard=PSR2 src/ tests/
</pre>

## Count Lines of Code:

<pre>
    vendor/bin/phploc src/ tests/ --names="*.php,*.xml"
</pre>

## Export SQL

<pre>
    vendor/bin/doctrine orm:schema-tool:create --dump-sql
</pre>


## License

```
Copyright 2014 Jamie Isaacs pdt256@gmail.com

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

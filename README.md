Zen Kommerce Core
=================
[![Test Coverage](https://codeclimate.com/github/inklabs/kommerce-core/badges/coverage.svg)](https://codeclimate.com/github/inklabs/kommerce-core)
[![Apache License 2.0](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg)](https://github.com/inklabs/kommerce-core/blob/master/LICENSE.txt)
[![Downloads](https://img.shields.io/packagist/dt/inklabs/kommerce-core.svg)](https://packagist.org/packages/inklabs/kommerce-core)

## Introduction

Zen Kommerce is a PHP shopping cart system written with SOLID design principles.
It is PSR compatible, dependency free, and contains 100% code coverage using TDD practices.

All code (including tests) conform to the PSR-2 coding standards. The namespace and autoloader
are using the PSR-4 standard.

## Description

This project is over 11,000 lines of code. Unit tests are 30-40% of those lines. There are three
main types of modules in this project:

* Entities (src/Entity)
    - These are plain old PHP objects. You will not find any ORM code or external dependencies here. This is where
      object relationships are constructed.

      ```php
      namespace inklabs\kommerce\Entity;
      $product = new Product;
      $product->setName('Test Product');
      $product->setUnitPrice(500);
      $product->addTag(new Tag);
      ...
      ```

* Libraries (src/Lib)
    - This is where you will find a variety of utility code including the Payment Gateway (src/Lib/PaymentGateway).

    ```php
    namespace inklabs\kommerce\Lib\PaymentGateway;
    $chargeRequest = new ChargeRequest(
        new Entity\CreditCard('4242424242424242', 5, 2015),
        2000, 'usd', 'test@example.com'
    );
    $stripe = new StripeStub;
    $charge = $stripe->getCharge($chargeRequest);
    ```

* Services (src/Service)
    - These are the interactors that manage the choreography between entities and the database via
      the Doctrine EntityManager. There is heavy dependency injection into the constructors in this layer.
      Sometimes a SessionManager is used for some types of persistence, such as a cart.

      ```php
      namespace inklabs\kommerce\Service;
      $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
      $cart->setTaxRate(new Entity\TaxRate);
      $cart->setUser(new Entity\User);
      $cart->addItem($viewProduct, 1);
      ...
      ```

* Views (src/Entity/View)
    - Sometimes you want to use your entities as plain objects in your main application, typically in your view
      templates. These classes act as a decorator. They format the entities as simple objects with class member
      variables or "properties" with public access. The complete network relationships of entities are also available
      if you request them.

      ```php
      namespace inklabs\kommerce\Entity\View;
      $product = Product::factory(new Entity\Product)
        ->withAllData(new Service\Pricing)
        ->export();
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

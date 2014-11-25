
## TODO:

### Shopping Cart Price Rules

* All cart price rules can be activated by a coupon code.
* http://www.demacmedia.com/magento-commerce/10-real-world-examples-of-shopping-cart-price-rules/
* http://go.magento.com/support/kb/entry/name/shopping-cart-price-rules/
* http://mikebywaters.wordpress.com/2011/12/18/programmatically-create-shopping-cart-price-rules-with-conditions-and-actions/

<pre>
"Buy X get $Y off Z" also called "Buy X get Y free"
 - buy warmer, get cost of baby bird off any (BPWC{03,06,12})
 -  CW + (WC06) - WC03 = total
 - $20 +    $8  -   $4 =   $24

"Spend $X get $Y off Z shipping"
 - spend $50 get cost of {ground, 2day, 1day} shipping off (selected shipping)
 - subtotal + (2day shipping) - ground shipping = total
 -      $50 +            $15  -              $5 =   $60

"X% off (certain SKUs)"
 - 30% off aroma lamps
 -   AL - 30% AL =  total
 -  $25 -  $7.50 = $17.50

"X% off first order"
 - 20% off first order
 - subtotal - 20% off = total
 -     $100 -     $20 =   $80

"X% off products with certain attribute" or "X% off products of a certain color"
 - 20% off with green attribute
 - WC03CCM - 20% off WC03CCM = total
 -      $4 -           $0.80 = $3.20

"X% off products with certain product option"
 - 20% off shirts that are small
 - No BP example

Buy 2 SKUs get 1 of the SKUs 10% Off
 - Limit to 1 Product Receiving Discount – Specific Customer Segment
</pre>

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
    vendor/bin/phploc src/ tests/
</pre>

## Export SQL

<pre>
    vendor/bin/doctrine orm:schema-tool:create --dump-sql
</pre>

# Facade Design Pattern

A Facade is an outward appearance that conceals a less pleasant reality. In this project we use the
**facade design pattern** to abstract away the inner workings of the
[Shipment Gateway](../../../src/Lib/ShipmentGateway/ShipmentGatewayInterface.php)
 and
[Payment Gateway](../../../src/Lib/PaymentGateway/PaymentGatewayInterface.php). This allows us to hide the
implementation details behind well known endpoints on which our core business logic can depend on. This enables
us to reduced dependencies of outside code, allows more flexibility to switch providers, and reduces our
code exposure to **undesirable design patterns**, such as the **singleton design pattern** extensively used in
these 3rd party PHP libraries:
[EasyPost](../../../src/Lib/ShipmentGateway/EasyPostGateway.php)
and
[Stripe](../../../src/Lib/PaymentGateway/Stripe.php).

## Example

### Stripe Payment Gateway

```php
class Stripe implements PaymentGatewayInterface
{
    public function __construct($apiKey)
    {
        \Stripe\Stripe::setApiKey($apiKey);
    }

    public function createCharge(ChargeRequest $chargeRequest)
    {
        $card = $chargeRequest->getCreditCard();

        return \Stripe\Charge::create([
            'amount' => $chargeRequest->getAmount(),
            'currency' => $chargeRequest->getCurrency(),
            'card' => [
                'name' => $card->getName(),
                'address_zip' => $card->getZip5(),
                'number' => $card->getNumber(),
                'cvc' => $card->getCvc(),
                'exp_month' => $card->getExpirationMonth(),
                'exp_year' => $card->getExpirationYear(),
            ],
            'description' => $chargeRequest->getDescription(),
        ]);
    }
}
```

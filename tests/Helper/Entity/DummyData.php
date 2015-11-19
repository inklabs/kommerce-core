<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use DateTime;
use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentLabel;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Lib\Pricing;

class DummyData
{
    public function getAddress()
    {
        $address = new Address;
        $address->setAttention('John Doe');
        $address->setCompany('Acme Co.');
        $address->setAddress1('123 Any St');
        $address->setAddress2('Ste 3');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setZip4('3274');
        $address->setPoint(new Point(34.010947, -118.490541));

        return $address;
    }

    public function getAttribute()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test Attribute Description');
        $attribute->setSortOrder(0);

        return $attribute;
    }

    public function getAttributeValue()
    {
        $attribute = new AttributeValue;
        $attribute->setSku('TAV');
        $attribute->setName('Test Attribute Value');
        $attribute->setDescription('Test Attribute Value Description');
        $attribute->setSortOrder(0);

        return $attribute;
    }

    /**
     * @param CartItem[] $cartItems
     * @return Cart
     */
    public function getCart(array $cartItems = [])
    {
        $cart = new Cart;
        $cart->setIp4('10.0.0.1');

        foreach ($cartItems as $cartItem) {
            $cart->addCartItem($cartItem);
        }

        return $cart;
    }

    public function getCartItem($product = null)
    {
        if ($product === null) {
            $product = $this->getProduct();
        }

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        return $cartItem;
    }

    public function getCartItemFull()
    {
        $tag = $this->getTag();
        $tag->addImage($this->getImage());

        $product = new Product;
        $product->setSku('P1');
        $product->setUnitPrice(100);
        $product->setShippingWeight(10);
        $product->addTag($tag);
        $product->addProductQuantityDiscount($this->getProductQuantityDiscount());

        $product2 = new Product;
        $product2->setSku('OP1');
        $product2->setUnitPrice(100);
        $product2->setShippingWeight(10);

        $option1 = new Option;
        $option1->setname('Option 1');

        $optionProduct = new OptionProduct;
        $optionProduct->setOption($option1);
        $optionProduct->setProduct($product2);

        $option2 = new Option;
        $option2->setname('Option 2');

        $optionValue = new OptionValue;
        $optionValue->setOption($option2);
        $optionValue->setSku('OV1');
        $optionValue->setUnitPrice(100);
        $optionValue->setShippingWeight(10);

        $textOption = new TextOption;

        $cartItemOptionProduct = new CartItemOptionProduct;
        $cartItemOptionProduct->setOptionProduct($optionProduct);

        $cartItemOptionValue = new CartItemOptionValue;
        $cartItemOptionValue->setOptionValue($optionValue);

        $cartItemTextOptionValue = new CartItemTextOptionValue;
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setTextOptionValue('Happy Birthday');

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);
        $cartItem->setCart(new Cart);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        $cartItem->addCartItemOptionValue($cartItemOptionValue);
        $cartItem->addCartItemTextOptionValue($cartItemTextOptionValue);

        return $cartItem;
    }

    public function getCartPriceRule()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Test Cart Price Rule');
        $cartPriceRule->setType(AbstractPromotion::TYPE_FIXED);
        $cartPriceRule->setValue(0);

        return $cartPriceRule;
    }

    public function getCartTotal()
    {
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1;
        $cartTotal->subtotal = 1;
        $cartTotal->taxSubtotal = 1;
        $cartTotal->discount = 1;
        $cartTotal->shipping = 1;
        $cartTotal->shippingDiscount = 1;
        $cartTotal->tax = 1;
        $cartTotal->total = 1;
        $cartTotal->savings = 1;

        return $cartTotal;
    }

    public function getCashPayment($amount = 100)
    {
        $payment = new CashPayment($amount);
        return $payment;
    }

    public function getCatalogPromotion($num = 1)
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('Test Catalog Promotion #' . $num);
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setValue(20);

        return $catalogPromotion;
    }

    public function getCoupon($num = 1)
    {
        $coupon = new Coupon;
        $coupon->setName('20% OFF Test Coupon #' . $num);
        $coupon->setCode('20PCT' . $num);
        $coupon->setType(AbstractPromotion::TYPE_PERCENT);
        $coupon->setValue(20);

        return $coupon;
    }

    public function getImage()
    {
        $image = new Image;
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);

        return $image;
    }

    public function getInventoryLocation(Warehouse $warehouse = null)
    {
        if ($warehouse === null) {
            $warehouse = $this->getWarehouse();
        }

        $inventoryLocation = new InventoryLocation($warehouse, 'Widget Bin', 'Z1-A13-B37-L5-P3');

        return $inventoryLocation;
    }

    public function getInventoryTransaction(InventoryLocation $inventoryLocation = null, Product $product = null)
    {
        if ($inventoryLocation === null) {
            $inventoryLocation = $this->getInventoryLocation();
        }

        if ($product === null) {
            $product = $this->getProduct();
        }

        $inventoryTransaction = new InventoryTransaction($inventoryLocation);
        $inventoryTransaction->setDebitQuantity(2);
        $inventoryTransaction->setProduct($product);
        $inventoryTransaction->setMemo('Pick 2 Widgets');

        return $inventoryTransaction;
    }

    public function getOption()
    {
        $option = new Option;
        $option->setName('Size');
        $option->setType(Option::TYPE_RADIO);
        $option->setDescription('Shirt Size');
        $option->setSortOrder(0);

        return $option;
    }

    public function getOptionProduct(Option $option = null, Product $product = null)
    {
        if ($option === null) {
            $option = $this->getOption();
        }

        if ($product === null) {
            $product = $this->getProduct();
        }

        $optionProduct = new OptionProduct;
        $optionProduct->setProduct($product);
        $optionProduct->setOption($option);
        $optionProduct->setSortOrder(0);

        return $optionProduct;
    }

    public function getOptionValue(Option $option = null)
    {
        if ($option === null) {
            $option = $this->getOption();
        }

        $optionValue = new OptionValue;
        $optionValue->setName('Option Value Name');
        $optionValue->setSku('OV-SKU');
        $optionValue->setShippingWeight(16);
        $optionValue->setSortOrder(0);
        $optionValue->setUnitPrice(100);
        $optionValue->setOption($option);

        return $optionValue;
    }

    /**
     * @param CartTotal $total
     * @param OrderItem[] $orderItems
     * @return Order
     */
    public function getOrder(CartTotal $total, array $orderItems = null)
    {
        $orderAddress = $this->getOrderAddress();

        $order = new Order;
        $order->setIp4('10.0.0.1');
        $order->setTotal($total);
        $order->setShippingAddress($orderAddress);
        $order->setBillingAddress($orderAddress);

        if ($orderItems !== null) {
            foreach ($orderItems as $orderItem) {
                $order->addOrderItem($orderItem);
            }
        }

        return $order;
    }

    public function getOrderFull()
    {
        $cartTotal = $this->getCartTotal();
        $orderItems = [$this->getOrderItemFull()];
        $order = $this->getOrder($cartTotal, $orderItems);

        return $order;
    }

    public function getOrderAddress()
    {
        $orderAddress = new OrderAddress;
        $orderAddress->firstName = 'John';
        $orderAddress->lastName = 'Doe';
        $orderAddress->company = 'Acme Co.';
        $orderAddress->address1 = '123 Any St';
        $orderAddress->address2 = 'Ste 3';
        $orderAddress->city = 'Santa Monica';
        $orderAddress->state = 'CA';
        $orderAddress->zip5 = '90401';
        $orderAddress->zip4 = '3274';
        $orderAddress->phone = '555-123-4567';
        $orderAddress->email = 'john@example.com';
        $orderAddress->setCountry('US');
        $orderAddress->setIsResidential(true);

        return $orderAddress;
    }

    public function getOrderItem(Product $product, Price $price)
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($price);

        return $orderItem;
    }

    public function getOrderItemFull()
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct($this->getProduct());
        $orderItem->setQuantity(1);
        $orderItem->setPrice($this->getPriceFull());
        $orderItem->addOrderItemOptionProduct($this->getOrderItemOptionProduct());
        $orderItem->addOrderItemOptionValue($this->getOrderItemOptionValue());
        $orderItem->addOrderItemTextOptionValue($this->getOrderItemTextOptionValue());

        return $orderItem;
    }

    /**
     * @param TextOption $textOption
     * @param string $textOptionValue
     * @return OrderItemTextOptionValue
     */
    public function getOrderItemTextOptionValue(TextOption $textOption = null, $textOptionValue = null)
    {
        if ($textOption === null) {
            $textOption = $this->getTextOption();
        }

        if ($textOptionValue === null) {
            $textOptionValue = 'Happy Birthday';
        }

        $orderItemTextOptionValue = new OrderItemTextOptionValue;
        $orderItemTextOptionValue->setTextOption($textOption);
        $orderItemTextOptionValue->setTextOptionValue($textOptionValue);
        return $orderItemTextOptionValue;
    }

    public function getOrderItemOptionProduct(OptionProduct $optionProduct = null)
    {
        if ($optionProduct === null) {
            $optionProduct = $this->getOptionProduct();
        }

        $orderItemOptionProduct = new OrderItemOptionProduct;
        $orderItemOptionProduct->setOptionProduct($optionProduct);
        return $orderItemOptionProduct;
    }

    public function getOrderItemOptionValue(OptionValue $optionValue = null)
    {
        if ($optionValue === null) {
            $optionValue = $this->getOptionValue();
        }

        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        return $orderItemOptionValue;
    }

    public function getParcel()
    {
        $parcel = new Parcel;
        $parcel->setExternalId('prcl_xxxx');
        $parcel->setLength(4.1);
        $parcel->setWidth(6.2);
        $parcel->setHeight(8.3);
        $parcel->setWeight(32);

        return $parcel;
    }

    public function getParcelSmallFlatRateBox()
    {
        $parcel = new Parcel;
        $parcel->setExternalId('prcl_xxxx');
        $parcel->setPredefinedPackage('SmallFlatRateBox');
        $parcel->setWeight(32);

        return $parcel;
    }

    public function getPrice()
    {
        $price = new Price;
        $price->origUnitPrice = 100;
        $price->unitPrice = 100;
        $price->origQuantityPrice = 100;
        $price->quantityPrice = 100;

        return $price;
    }

    public function getPriceFull()
    {
        $price = $this->getPrice();
        $price->addCatalogPromotion($this->getCatalogPromotion());
        $price->addProductQuantityDiscount($this->getProductQuantityDiscount());

        return $price;
    }

    public function getPricing()
    {
        $pricing = new Pricing;
        $pricing->setCatalogPromotions([$this->getCatalogPromotion()]);
        $pricing->setProductQuantityDiscounts([$this->getProductQuantityDiscount()]);

        return $pricing;
    }

    public function getProduct($num = 1)
    {
        $product = new Product;
        $product->setSku($num);
        $product->setName('Test Product #' . $num);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);
        $product->setQuantity(10);
        $product->setUnitPrice(1200);

        return $product;
    }

    public function getProductFull()
    {
        $product = $this->getProduct(1);
        $product->addOptionProduct(
            $this->getOptionProduct(
                $this->getOption(),
                $this->getProduct(2)
            )
        );
        $product->addProductQuantityDiscount($this->getProductQuantityDiscount());
        $product->addImage($this->getImage());
        $product->addProductAttribute($this->getProductAttribute());

        $tag = $this->getTag();
        $tag->addImage($this->getImage());
        $tag->addOption($this->getOption());
        $tag->addTextOption($this->getTextOption());

        $product->addTag($tag);

        return $product;
    }

    public function getProductAttribute()
    {
        $productAttribute = new ProductAttribute;
        $productAttribute->setAttribute($this->getAttribute());
        $productAttribute->setAttributeValue($this->getAttributeValue());

        return $productAttribute;
    }

    public function getProductQuantityDiscount()
    {
        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setQuantity(1);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(true);

        return $productQuantityDiscount;
    }

    /**
     * TODO: PHP7 - bin2hex(random_bytes($n))
     * @param int $bitLength
     * @return string
     */
    public static function getRandomToken($bitLength = 10)
    {
        return bin2hex(openssl_random_pseudo_bytes($bitLength));
    }

    public function getShipment()
    {
        $shipment = new Shipment;
        return $shipment;
    }

    public function getShipmentLabel()
    {
        $shipmentLabel = new ShipmentLabel;
        $shipmentLabel->setExternalId('pl_' . $this->getRandomToken());
        $shipmentLabel->setResolution(300);
        $shipmentLabel->setSize('4x6');
        $shipmentLabel->setType('default');
        $shipmentLabel->setFileType('image/png');
        $shipmentLabel->setUrl('http://assets.geteasypost.com/postage_labels/labels/0jvZJy.png');

        return $shipmentLabel;
    }

    public function getShipmentRate($amount)
    {
        $shipmentRate = new ShipmentRate(new Money($amount, 'USD'));
        $shipmentRate->setExternalId('rate_' . $this->getRandomToken());
        $shipmentRate->setCarrier('UPS');
        $shipmentRate->setService('Ground');
        $shipmentRate->setListRate(new Money($amount * 1.05, 'USD'));
        $shipmentRate->setRetailRate(new Money($amount * 1.15, 'USD'));

        return $shipmentRate;
    }

    public function getShipmentTracker()
    {
        $shipmentTracker = new ShipmentTracker(
            ShipmentTracker::CARRIER_UPS,
            '1Z9999999999999999'
        );
        $shipmentTracker->setExternalId('trk_' . $this->getRandomToken());
        $shipmentTracker->setShipmentRate($this->getShipmentRate(595));
        $shipmentTracker->setShipmentLabel($this->getShipmentLabel());

        return $shipmentTracker;
    }

    public function getTag($num = 1)
    {
        $tag = new Tag;
        $tag->setName('Test Tag #' . $num);
        $tag->setCode('TT' . $num);
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsActive(true);
        $tag->setIsVisible(true);

        return $tag;
    }

    public function getTaxRate()
    {
        $taxRate = new TaxRate;
        $taxRate->setState('CA');
        $taxRate->setZip5(90403);
        $taxRate->setRate(7.5);
        $taxRate->setApplyToShipping(true);

        return $taxRate;
    }

    public function getTextOption()
    {
        $textOption = new TextOption;
        $textOption->setName('Size');
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setDescription('Shirt Size');
        $textOption->setSortOrder(0);

        return $textOption;
    }

    public function getUser($num = 1)
    {
        $user = new User;
        $user->setExternalId($num);
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setEmail('test' . $num . '@example.com');
        $user->setPassword('password1');
        $user->setFirstName('John');
        $user->setLastName('Doe');

        return $user;
    }

    public function getUserLogin()
    {
        $userLogin = new UserLogin;
        $userLogin->setEmail('john@example.com');
        $userLogin->setIp4('8.8.8.8');
        $userLogin->setResult(UserLogin::RESULT_SUCCESS);

        return $userLogin;
    }

    public function getUserRole()
    {
        $userRole = new UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account. Access to everything');

        return $userRole;
    }

    public function getUserToken()
    {
        $userToken = new UserToken;
        $userToken->setUserAgent('SampleBot/1.1');
        $userToken->setToken('xxxx');
        $userToken->setIp4('8.8.8.8');
        $userToken->setexpires(new DateTime);
        $userToken->setType(UserToken::TYPE_FACEBOOK);

        return $userToken;
    }

    public function getWarehouse($num = 1)
    {
        $warehouse = new Warehouse;
        $warehouse->setName('Test Warehouse #' . $num);
        $warehouse->setAddress($this->getAddress());

        return $warehouse;
    }
}

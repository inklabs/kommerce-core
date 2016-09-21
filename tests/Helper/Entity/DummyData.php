<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use DateTime;
use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\CreditCard;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Entity\DeliveryMethodType;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Parcel;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Entity\RemoteManagedFile;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentCarrierType;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentLabel;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\TextOptionType;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserLoginResultType;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Uuid;

class DummyData
{
    const USER_TOKEN_STRING = 'tokenstringxxx';
    const IP4 = '127.0.0.1';
    const USER_AGENT = 'DummyData/1.1';

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
        $address->setPoint($this->getPoint());

        return $address;
    }

    public function getAttachment()
    {
        $attachment = new Attachment('img/example.png');
        return $attachment;
    }

    public function getAttribute()
    {
        $attribute = new Attribute;
        $attribute->setName('Test Attribute');
        $attribute->setDescription('Test Attribute Description');
        $attribute->setSortOrder(0);

        return $attribute;
    }

    public function getAttributeValue(Attribute $attribute = null)
    {
        if ($attribute === null) {
            $attribute = $this->getAttribute();
        }

        $attributeValue = new AttributeValue($attribute);
        $attributeValue->setSku('TAV');
        $attributeValue->setName('Test Attribute Value');
        $attributeValue->setDescription('Test Attribute Value Description');
        $attributeValue->setSortOrder(0);

        return $attributeValue;
    }

    /**
     * @param CartItem[] $cartItems
     * @return Cart
     */
    public function getCart(array $cartItems = [])
    {
        $cart = new Cart;
        $cart->setIp4('10.0.0.1');
        $cart->setShippingAddress($this->getOrderAddress());

        foreach ($cartItems as $cartItem) {
            $cart->addCartItem($cartItem);
        }

        return $cart;
    }

    public function getCartFull()
    {
        $cart = $this->getCart();
        $cart->addCartItem($this->getCartItem());
        $cart->addCoupon($this->getCoupon());
        $cart->setShipmentRate($this->getShipmentRate());
        $cart->setTaxRate($this->getTaxRate());
        $cart->setUser($this->getUser());

        return $cart;
    }

    public function getCartCalculator(Pricing $pricing = null)
    {
        if ($pricing === null) {
            $pricing = $this->getPricing();
        }

        return new CartCalculator($pricing);
    }

    public function getCartItem($product = null, $quantity = 2)
    {
        if ($product === null) {
            $product = $this->getProduct();
        }

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity($quantity);

        return $cartItem;
    }

    public function getCartItemFull()
    {
        $tag = $this->getTag();
        $tag->addImage($this->getImage());

        $product = $this->getProduct();
        $product->setSku('P1');
        $product->setUnitPrice(100);
        $product->setShippingWeight(10);
        $product->addTag($tag);
        $product->addProductQuantityDiscount($this->getProductQuantityDiscount());

        $product2 = $this->getProduct();
        $product2->setSku('OP1');
        $product2->setUnitPrice(100);
        $product2->setShippingWeight(10);

        $option1 = $this->getOption();
        $option1->setName('Option 1');

        $optionProduct = $this->getOptionProduct($option1, $product2);

        $option2 = $this->getOption();
        $option2->setName('Option 2');

        $optionValue = $this->getOptionValue($option2);
        $optionValue->setSku('OV1');
        $optionValue->setUnitPrice(100);
        $optionValue->setShippingWeight(10);

        $textOption = $this->getTextOption();

        $cartItemOptionProduct = $this->getCartItemOptionProduct($optionProduct);

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

    public function getCartItemOptionProduct(OptionProduct $optionProduct = null)
    {
        if ($optionProduct === null) {
            $optionProduct = $this->getOptionProduct();
        }

        $cartItemOptionProduct = new CartItemOptionProduct;
        $cartItemOptionProduct->setOptionProduct($optionProduct);

        return $cartItemOptionProduct;
    }

    public function getCartItemOptionValue(OptionValue $optionValue = null)
    {
        if ($optionValue === null) {
            $optionValue = $this->getOptionValue();
        }

        $cartItemOptionValue = new CartItemOptionValue;
        $cartItemOptionValue->setOptionValue($optionValue);

        return $cartItemOptionValue;
    }

    public function getCartItemTextOptionValue(TextOption $textOption = null)
    {
        if ($textOption === null) {
            $textOption = $this->getTextOption();
        }

        $cartItemTextOptionValue = new CartItemTextOptionValue;
        $cartItemTextOptionValue->setTextOption($textOption);
        $cartItemTextOptionValue->setTextOptionValue('Happy Birthday');

        return $cartItemTextOptionValue;
    }

    public function getCartPriceRule()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Test Cart Price Rule');

        return $cartPriceRule;
    }

    public function getCartPriceRuleDiscount(Product $product = null, $quantity = 1)
    {
        if ($product === null) {
            $product = $this->getProduct();
        }

        return new CartPriceRuleDiscount($product, $quantity);
    }

    public function getCartPriceRuleProductItem(Product $product = null, $quantity = 1)
    {
        if ($product === null) {
            $product = $this->getProduct();
        }

        $productItem = new CartPriceRuleProductItem($product, $quantity);
        $productItem->setUpdated();

        return $productItem;
    }

    public function getCartPriceRuleTagItem(Tag $tag = null, $quantity = 1)
    {
        if ($tag === null) {
            $tag = $this->getTag();
        }

        $tagItem = new CartPriceRuleTagItem($tag, $quantity);
        $tagItem->setUpdated();

        return $tagItem;
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

    public function getCatalogPromotion()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('Test Catalog Promotion');
        $catalogPromotion->setCode('20PCTOFF');
        $catalogPromotion->setValue(20);

        return $catalogPromotion;
    }

    public function getChargeResponse()
    {
        $chargeResponse = new ChargeResponse;
        $chargeResponse->setExternalId('ch_xxxxxxxxxxxxxx');
        $chargeResponse->setAmount(2000);
        $chargeResponse->setLast4('4242');
        $chargeResponse->setBrand('Visa');
        $chargeResponse->setCurrency('usd');
        $chargeResponse->setDescription('test@example.com');
        $chargeResponse->setCreated(1420656887);

        return $chargeResponse;
    }

    public function getCheckPayment($amount = 100)
    {
        return new CheckPayment(
            $amount,
            '0001234',
            new DateTime('4/13/2016'),
            'memo area'
        );
    }

    public function getCoupon($code = null)
    {
        if ($code === null) {
            $code = uniqid();
        }

        $coupon = new Coupon($code);
        $coupon->setName('20% OFF Test Coupon');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue(20);
        $coupon->setStart(new DateTime('-1 Day'));
        $coupon->setEnd(new DateTime('+1 Day'));

        return $coupon;
    }

    public function getCreditCard()
    {
        $creditCard = new CreditCard;
        $creditCard->setName('John Doe');
        $creditCard->setZip5('90210');
        $creditCard->setNumber('4242424242424242');
        $creditCard->setCvc('123');
        $creditCard->setExpirationMonth('1');
        $creditCard->setExpirationYear('2020');

        return $creditCard;
    }

    public function getCreditPayment()
    {
        return new CreditPayment($this->getChargeResponse());
    }

    public function getDeliveryMethodType()
    {
        return DeliveryMethodType::twoDay();
    }

    public function getId()
    {
        return Uuid::uuid4();
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

    public function getCustomerHoldInventoryLocation(Warehouse $warehouse = null)
    {
        if ($warehouse === null) {
            $warehouse = $this->getWarehouse();
        }

        $inventoryLocation = new InventoryLocation($warehouse, 'Hold For Customer Order', 'CUSTOMER-HOLD');

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
        $inventoryTransaction->setCreditQuantity(2);
        $inventoryTransaction->setProduct($product);
        $inventoryTransaction->setMemo('Initial Inventory');

        return $inventoryTransaction;
    }

    public function getInventoryTransactionType()
    {
        return InventoryTransactionType::hold();
    }

    /**
     * @param int $amount
     * @param string $currency
     * @return Money
     */
    public function getMoney($amount, $currency = 'USD')
    {
        return new Money((int) $amount, $currency);
    }

    public function getOption()
    {
        $option = new Option;
        $option->setName('Size');
        $option->setType($this->getOptionType());
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

        $optionProduct = new OptionProduct($option, $product);
        $optionProduct->setSortOrder(0);

        return $optionProduct;
    }

    public function getOptionType()
    {
        return OptionType::select();
    }

    public function getOptionValue(Option $option = null)
    {
        if ($option === null) {
            $option = $this->getOption();
        }

        $optionValue = new OptionValue($option);
        $optionValue->setName('Option Value Name');
        $optionValue->setSku('OV-SKU');
        $optionValue->setShippingWeight(16);
        $optionValue->setSortOrder(0);
        $optionValue->setUnitPrice(100);

        return $optionValue;
    }

    /**
     * @param CartTotal $cartTotal
     * @return Order
     */
    public function getOrder(CartTotal $cartTotal = null)
    {
        if ($cartTotal === null) {
            $cartTotal = $this->getCartTotal();
        }

        $orderAddress = $this->getOrderAddress();

        $order = new Order;
        $order->setIp4('10.0.0.1');
        $order->setTotal($cartTotal);
        $order->setShippingAddress($orderAddress);
        $order->setBillingAddress($orderAddress);

        return $order;
    }

    public function getOrderFull()
    {
        $order = $this->getOrderFullWithoutShipments();
        $order->addShipment($this->getShipment());

        return $order;
    }

    public function getOrderFullWithoutShipments()
    {
        $cartTotal = $this->getCartTotal();
        $order = $this->getOrder($cartTotal);
        $order->setUser($this->getUser());
        $order->addCoupon($this->getCoupon());
        $order->addPayment($this->getCashPayment());
        $order->setShipmentRate($this->getShipmentRate());
        $order->setTaxRate($this->getTaxRate());

        $this->getOrderItemFull($order);

        return $order;
    }

    public function getOrderAddress()
    {
        $orderAddress = new OrderAddress;
        $orderAddress->setFirstName('John');
        $orderAddress->setLastName('Doe');
        $orderAddress->setCompany('Acme Co.');
        $orderAddress->setAddress1('123 Any St');
        $orderAddress->setAddress2('Ste 3');
        $orderAddress->setCity('Santa Monica');
        $orderAddress->setState('CA');
        $orderAddress->setZip5('90401');
        $orderAddress->setZip4('3274');
        $orderAddress->setPhone('555-123-4567');
        $orderAddress->setEmail('john@example.com');
        $orderAddress->setCountry('US');
        $orderAddress->setIsResidential(true);

        return $orderAddress;
    }

    public function getOrderItem(Order $order = null, Product $product = null, Price $price = null)
    {
        if ($order === null) {
            $order = $this->getOrder();
        }

        if ($product === null) {
            $product = $this->getProduct();
        }

        if ($price === null) {
            $price = $this->getPrice();
        }

        $orderItem = new OrderItem($order);
        $orderItem->setProduct($product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($price);

        return $orderItem;
    }

    public function getOrderItemWithoutProduct(Order $order = null, Price $price = null)
    {
        if ($order === null) {
            $order = $this->getOrder();
        }

        if ($price === null) {
            $price = $this->getPrice();
        }

        $orderItem = new OrderItem($order);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($price);

        return $orderItem;
    }

    public function getOrderItemFull(Order $order)
    {
        if ($order === null) {
            $order = $this->getOrder();
        }

        $product = $this->getProduct();
        $product->enableAttachments();

        $orderItem = new OrderItem($order);
        $orderItem->setProduct($product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($this->getPriceFull());
        $orderItem->addOrderItemOptionProduct($this->getOrderItemOptionProduct());
        $orderItem->addOrderItemOptionValue($this->getOrderItemOptionValue());
        $orderItem->addOrderItemTextOptionValue($this->getOrderItemTextOptionValue());
        $orderItem->addAttachment($this->getAttachment());

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

    public function getOrderStatusType()
    {
        return OrderStatusType::pending();
    }

    public function getPagination()
    {
        return new Pagination;
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

    public function getPoint()
    {
        return new Point(34.052234, -118.243685);
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

    /**
     * @param CatalogPromotion[]|null $catalogPromotions
     * @param ProductQuantityDiscount[]|null $productQuantityDiscounts
     * @return Pricing
     */
    public function getPricing(array $catalogPromotions = null, array $productQuantityDiscounts = null)
    {
        if ($catalogPromotions === null) {
            $catalogPromotions = [$this->getCatalogPromotion()];
        }

        if ($productQuantityDiscounts === null) {
            $productQuantityDiscounts = [$this->getProductQuantityDiscount()];
        }

        $pricing = new Pricing;
        $pricing->setCatalogPromotions($catalogPromotions);
        $pricing->setProductQuantityDiscounts($productQuantityDiscounts);

        return $pricing;
    }

    public function getProduct($sku = null)
    {
        if ($sku === null) {
            $sku = uniqid();
        }

        $product = new Product;
        $product->setSku($sku);
        $product->setName('Test Product');
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
        $product = $this->getProduct();
        $product->addOptionProduct(
            $this->getOptionProduct(
                $this->getOption(),
                $this->getProduct()
            )
        );
        $product->addProductQuantityDiscount($this->getProductQuantityDiscount());
        $product->addImage($this->getImage());

        $productAttribute = $this->getProductAttribute($product);

        $tag = $this->getTag();
        $tag->addImage($this->getImage());
        $tag->addOption($this->getOption());
        $tag->addTextOption($this->getTextOption());

        $product->addTag($tag);

        return $product;
    }

    public function getProductAttribute(
        Product $product = null,
        Attribute $attribute = null,
        AttributeValue $attributeValue = null
    ) {
        if ($product === null) {
            $product = $this->getProduct();
        }

        if ($attribute === null) {
            $attribute = $this->getAttribute();
        }

        if ($attributeValue === null) {
            $attributeValue = $this->getAttributeValue();
        }

        return new ProductAttribute(
            $product,
            $attribute,
            $attributeValue
        );
    }

    public function getProductQuantityDiscount(Product $product = null)
    {
        if ($product === null) {
            $product = $this->getProduct();
        }

        $productQuantityDiscount = new ProductQuantityDiscount($product);
        $productQuantityDiscount->setType(PromotionType::percent());
        $productQuantityDiscount->setQuantity(6);
        $productQuantityDiscount->setValue(5);
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setQuantity(1);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(true);

        return $productQuantityDiscount;
    }

    public function getPromotionType()
    {
        return PromotionType::exact();
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

    public function getRemoteManagedFile()
    {
        return new RemoteManagedFile(
            'http://lorempixel.com/400/200/',
            IMAGETYPE_JPEG,
            'image/jpeg'
        );
    }

    public function getShipment()
    {
        $shipment = new Shipment();
        return $shipment;
    }

    public function getShipmentCarrierType()
    {
        return ShipmentCarrierType::ups();
    }

    public function getShipmentComment(Shipment $shipment = null)
    {
        if ($shipment === null) {
            $shipment = $this->getShipment();
        }

        return new ShipmentComment($shipment, 'A shipment comment');
    }

    public function getShipmentItem(Shipment $shipment = null, OrderItem $orderItem = null, $quantityToShip = 1)
    {
        if ($shipment === null) {
            $shipment = $this->getShipment();
        }

        if ($orderItem === null) {
            $orderItem = $this->getOrderItem();
        }

        $shipmentItem = new ShipmentItem($shipment, $orderItem, $quantityToShip);

        return $shipmentItem;
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

    /**
     * @param int $amount
     * @param string $currency
     * @return ShipmentRate
     */
    public function getShipmentRate($amount = 500, $currency = 'USD')
    {
        $shipmentRate = new ShipmentRate(new Money($amount, $currency));
        $shipmentRate->setExternalId('rate_' . $this->getRandomToken());
        $shipmentRate->setCarrier('UPS');
        $shipmentRate->setService('Ground');
        $shipmentRate->setListRate(new Money($amount * 1.05, $currency));
        $shipmentRate->setRetailRate(new Money($amount * 1.15, $currency));
        $shipmentRate->setDeliveryDate(new DateTime());

        return $shipmentRate;
    }

    public function getShipmentTracker()
    {
        $shipmentTracker = new ShipmentTracker(
            $this->getShipmentCarrierType(),
            '1Z9999999999999999'
        );
        $shipmentTracker->setExternalId('trk_' . $this->getRandomToken());
        $shipmentTracker->setShipmentRate($this->getShipmentRate(595));
        $shipmentTracker->setShipmentLabel($this->getShipmentLabel());

        return $shipmentTracker;
    }

    public function getTag()
    {
        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setCode('TT' . uniqid());
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
        $textOption->setType($this->getTextOptionType());
        $textOption->setDescription('Shirt Size');
        $textOption->setSortOrder(0);

        return $textOption;
    }

    public function getTextOptionType()
    {
        return TextOptionType::textarea();
    }

    public function getUploadFileDTO()
    {
        return new UploadFileDTO(
            '42-348301152.jpg',
            'image/jpeg',
            '/tmp/phpupuP2I',
            236390
        );
    }

    public function getUser($externalId = null)
    {
        $user = new User;
        $user->setExternalId($externalId);
        $user->setEmail('test' . $externalId . '@example.com');
        $user->setPassword('password1');
        $user->setFirstName('John');
        $user->setLastName('Doe');

        return $user;
    }

    public function getUserLogin(User $user = null, UserToken $userToken = null)
    {
        return new UserLogin(
            $this->getUserLoginResultType(),
            'john@example.com',
            '127.0.0.1',
            $user,
            $userToken
        );
    }

    public function getUserLoginResultType()
    {
        return UserLoginResultType::success();
    }

    public function getUserRole()
    {
        $userRole = new UserRole;
        $userRole->setName('Administrator');
        $userRole->setDescription('Admin account. Access to everything');

        return $userRole;
    }

    public function getUserStatusType()
    {
        return UserStatusType::inactive();
    }

    public function getUserToken(User $user = null, DateTime $expires = null)
    {
        if ($user === null) {
            $user = $this->getUser();
        }

        if ($expires === null) {
            $expires = new DateTime('+1 hour');
        }

        return new UserToken(
            $user,
            UserTokenType::internal(),
            self::USER_TOKEN_STRING,
            self::USER_AGENT,
            self::IP4,
            $expires
        );
    }

    public function getUserTokenType()
    {
        return UserTokenType::internal();
    }

    public function getWarehouse($num = 1)
    {
        $warehouse = new Warehouse;
        $warehouse->setName('Test Warehouse #' . $num);
        $warehouse->setAddress($this->getAddress());

        return $warehouse;
    }
}

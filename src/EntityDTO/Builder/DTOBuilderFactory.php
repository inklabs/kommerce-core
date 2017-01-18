<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\AbstractPayment;
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
use inklabs\kommerce\Entity\UserRoleType;
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\DTOBuilderException;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

class DTOBuilderFactory implements DTOBuilderFactoryInterface
{
    public function getAddressDTOBuilder(Address $address)
    {
        return new AddressDTOBuilder($address, $this);
    }

    public function getAttachmentDTOBuilder(Attachment $attachment)
    {
        return new AttachmentDTOBuilder($attachment, $this);
    }

    public function getAttributeDTOBuilder(Attribute $attribute)
    {
        return new AttributeDTOBuilder($attribute, $this);
    }

    public function getAttributeValueDTOBuilder(AttributeValue $attributeValue)
    {
        return new AttributeValueDTOBuilder($attributeValue, $this);
    }

    public function getCartDTOBuilder(Cart $cart)
    {
        return new CartDTOBuilder($cart, $this);
    }

    public function getCartItemDTOBuilder(CartItem $cartItem)
    {
        return new CartItemDTOBuilder($cartItem, $this);
    }

    public function getCartItemOptionProductDTOBuilder(CartItemOptionProduct $cartItemOptionProduct)
    {
        return new CartItemOptionProductDTOBuilder($cartItemOptionProduct, $this);
    }

    public function getCartItemOptionValueDTOBuilder(CartItemOptionValue $cartItemOptionValue)
    {
        return new CartItemOptionValueDTOBuilder($cartItemOptionValue, $this);
    }

    public function getCartItemTextOptionValueDTOBuilder(CartItemTextOptionValue $cartItemTextOptionValue)
    {
        return new CartItemTextOptionValueDTOBuilder($cartItemTextOptionValue, $this);
    }

    public function getCartPriceRuleDTOBuilder(CartPriceRule $cartPriceRule)
    {
        return new CartPriceRuleDTOBuilder($cartPriceRule, $this);
    }

    public function getCartPriceRuleDiscountDTOBuilder(CartPriceRuleDiscount $cartPriceRuleDiscount)
    {
        return new CartPriceRuleDiscountDTOBuilder($cartPriceRuleDiscount, $this);
    }

    public function getCartPriceRuleItemDTOBuilder(AbstractCartPriceRuleItem $cartPriceRuleItem)
    {
        switch (true) {
            case $cartPriceRuleItem instanceof CartPriceRuleTagItem:
                return $this->getCartPriceRuleTagItemDTOBuilder($cartPriceRuleItem);
                break;

            case $cartPriceRuleItem instanceof CartPriceRuleProductItem:
                return $this->getCartPriceRuleProductItemDTOBuilder($cartPriceRuleItem);
                break;
        }

        throw DTOBuilderException::invalidCartPriceRuleItem();
    }

    public function getCartPriceRuleProductItemDTOBuilder(CartPriceRuleProductItem $cartPriceRuleProductItem)
    {
        return new CartPriceRuleProductItemDTOBuilder($cartPriceRuleProductItem, $this);
    }

    public function getCartPriceRuleTagItemDTOBuilder(CartPriceRuleTagItem $cartPriceRuleTagItem)
    {
        return new CartPriceRuleTagItemDTOBuilder($cartPriceRuleTagItem, $this);
    }

    public function getCartTotalDTOBuilder(CartTotal $cartTotal)
    {
        return new CartTotalDTOBuilder($cartTotal, $this);
    }

    public function getCashPaymentDTOBuilder(CashPayment $cashPayment)
    {
        return new CashPaymentDTOBuilder($cashPayment);
    }

    public function getCatalogPromotionDTOBuilder(CatalogPromotion $catalogPromotion)
    {
        return new CatalogPromotionDTOBuilder($catalogPromotion, $this);
    }

    public function getChargeResponseDTOBuilder(ChargeResponse $chargeResponse)
    {
        return new ChargeResponseDTOBuilder($chargeResponse);
    }

    public function getCheckPaymentDTOBuilder(CheckPayment $checkPayment)
    {
        return new CheckPaymentDTOBuilder($checkPayment);
    }

    public function getCouponDTOBuilder(Coupon $coupon)
    {
        return new CouponDTOBuilder($coupon, $this);
    }

    public function getCreditCardDTOBuilder(CreditCard $creditCard)
    {
        return new CreditCardDTOBuilder($creditCard);
    }

    public function getCreditPaymentDTOBuilder(CreditPayment $creditPayment)
    {
        return new CreditPaymentDTOBuilder($creditPayment, $this);
    }

    public function getDeliveryMethodTypeDTOBuilder(DeliveryMethodType $deliveryMethodType)
    {
        return new DeliveryMethodTypeDTOBuilder($deliveryMethodType);
    }

    public function getImageDTOBuilder(Image $image)
    {
        return new ImageDTOBuilder($image, $this);
    }

    public function getInventoryLocationDTOBuilder(InventoryLocation $inventoryLocation)
    {
        return new InventoryLocationDTOBuilder($inventoryLocation, $this);
    }

    public function getInventoryTransactionDTOBuilder(InventoryTransaction $inventoryTransaction)
    {
        return new InventoryTransactionDTOBuilder($inventoryTransaction, $this);
    }

    public function getInventoryTransactionTypeDTOBuilder(InventoryTransactionType $inventoryTransactionType)
    {
        return new InventoryTransactionTypeDTOBuilder($inventoryTransactionType);
    }

    public function getMoneyDTOBuilder(Money $money)
    {
        return new MoneyDTOBuilder($money);
    }

    public function getOptionDTOBuilder(Option $option)
    {
        return new OptionDTOBuilder($option, $this);
    }

    public function getOrderDTOBuilder(Order $order)
    {
        return new OrderDTOBuilder($order, $this);
    }

    public function getOrderAddressDTOBuilder(OrderAddress $orderAddress)
    {
        return new OrderAddressDTOBuilder($orderAddress, $this);
    }

    public function getOptionProductDTOBuilder(OptionProduct $optionProduct)
    {
        return new OptionProductDTOBuilder($optionProduct, $this);
    }

    public function getOptionTypeDTOBuilder(OptionType $optionType)
    {
        return new OptionTypeDTOBuilder($optionType);
    }

    public function getOptionValueDTOBuilder(OptionValue $optionValue)
    {
        return new OptionValueDTOBuilder($optionValue, $this);
    }

    public function getOrderItemDTOBuilder(OrderItem $orderItem)
    {
        return new OrderItemDTOBuilder($orderItem, $this);
    }

    public function getOrderItemOptionProductDTOBuilder(OrderItemOptionProduct $orderItemOptionProduct)
    {
        return new OrderItemOptionProductDTOBuilder($orderItemOptionProduct, $this);
    }

    public function getOrderItemOptionValueDTOBuilder(OrderItemOptionValue $orderItemOptionValue)
    {
        return new OrderItemOptionValueDTOBuilder($orderItemOptionValue, $this);
    }

    public function getOrderItemTextOptionValueDTOBuilder(OrderItemTextOptionValue $orderItemTextOptionValue)
    {
        return new OrderItemTextOptionValueDTOBuilder($orderItemTextOptionValue, $this);
    }

    public function getOrderStatusTypeDTOBuilder(OrderStatusType $orderStatusType)
    {
        return new OrderStatusTypeDTOBuilder($orderStatusType);
    }

    public function getPaginationDTOBuilder(Pagination $pagination)
    {
        return new PaginationDTOBuilder($pagination, $this);
    }

    public function getParcelDTOBuilder(Parcel $parcel)
    {
        return new ParcelDTOBuilder($parcel, $this);
    }

    public function getPaymentDTOBuilder(AbstractPayment $payment)
    {
        switch (true) {
            case $payment instanceof CashPayment:
                return $this->getCashPaymentDTOBuilder($payment);
                break;

            case $payment instanceof CreditPayment:
                return $this->getCreditPaymentDTOBuilder($payment);
                break;

            case $payment instanceof CheckPayment:
                return $this->getCheckPaymentDTOBuilder($payment);
                break;
        }

        throw DTOBuilderException::invalidPayment();
    }

    public function getPointDTOBuilder(Point $point)
    {
        return new PointDTOBuilder($point);
    }

    public function getPriceDTOBuilder(Price $price)
    {
        return new PriceDTOBuilder($price, $this);
    }

    public function getPromotionTypeDTOBuilder(PromotionType $promotionType)
    {
        return new PromotionTypeDTOBuilder($promotionType);
    }

    public function getProductDTOBuilder(Product $product)
    {
        return new ProductDTOBuilder($product, $this);
    }

    public function getProductAttributeDTOBuilder(ProductAttribute $productAttribute)
    {
        return new ProductAttributeDTOBuilder($productAttribute, $this);
    }

    public function getProductQuantityDiscountDTOBuilder(ProductQuantityDiscount $productQuantityDiscount)
    {
        return new ProductQuantityDiscountDTOBuilder($productQuantityDiscount, $this);
    }

    public function getShipmentDTOBuilder(Shipment $shipment)
    {
        return new ShipmentDTOBuilder($shipment, $this);
    }

    public function getShipmentCarrierTypeDTOBuilder(ShipmentCarrierType $shipmentCarrierType)
    {
        return new ShipmentCarrierTypeDTOBuilder($shipmentCarrierType);
    }

    public function getShipmentCommentDTOBuilder(ShipmentComment $shipmentComment)
    {
        return new ShipmentCommentDTOBuilder($shipmentComment);
    }

    public function getShipmentItemDTOBuilder(ShipmentItem $shipmentItem)
    {
        return new ShipmentItemDTOBuilder($shipmentItem, $this);
    }

    public function getShipmentLabelDTOBuilder(ShipmentLabel $shipmentLabel)
    {
        return new ShipmentLabelDTOBuilder($shipmentLabel);
    }

    public function getShipmentRateDTOBuilder(ShipmentRate $shipmentRate)
    {
        return new ShipmentRateDTOBuilder($shipmentRate, $this);
    }

    public function getShipmentTrackerDTOBuilder(ShipmentTracker $shipmentTracker)
    {
        return new ShipmentTrackerDTOBuilder($shipmentTracker, $this);
    }

    public function getTagDTOBuilder(Tag $tag)
    {
        return new TagDTOBuilder($tag, $this);
    }

    public function getTaxRateDTOBuilder(TaxRate $taxRate)
    {
        return new TaxRateDTOBuilder($taxRate);
    }

    public function getTextOptionDTOBuilder(TextOption $textOption)
    {
        return new TextOptionDTOBuilder($textOption, $this);
    }

    public function getTextOptionTypeDTOBuilder(TextOptionType $textOptionType)
    {
        return new TextOptionTypeDTOBuilder($textOptionType);
    }

    public function getUserDTOBuilder(User $user)
    {
        return new UserDTOBuilder($user, $this);
    }

    public function getUserLoginDTOBuilder(UserLogin $userLogin)
    {
        return new UserLoginDTOBuilder($userLogin, $this);
    }

    public function getUserLoginResultTypeDTOBuilder(UserLoginResultType $userLoginResultType)
    {
        return new UserLoginResultTypeDTOBuilder($userLoginResultType);
    }

    public function getUserRoleDTOBuilder(UserRole $userRole)
    {
        return new UserRoleDTOBuilder($userRole, $this);
    }

    public function getUserRoleTypeDTOBuilder(UserRoleType $userRoleType)
    {
        return new UserRoleTypeDTOBuilder($userRoleType, $this);
    }

    public function getUserStatusTypeDTOBuilder(UserStatusType $userStatusType)
    {
        return new UserStatusTypeDTOBuilder($userStatusType);
    }

    public function getUserTokenDTOBuilder(UserToken $userToken)
    {
        return new UserTokenDTOBuilder($userToken, $this);
    }

    public function getUserTokenTypeDTOBuilder(UserTokenType $userTokenType)
    {
        return new UserTokenTypeDTOBuilder($userTokenType);
    }

    public function getWarehouseDTOBuilder(Warehouse $warehouse)
    {
        return new WarehouseDTOBuilder($warehouse, $this);
    }
}

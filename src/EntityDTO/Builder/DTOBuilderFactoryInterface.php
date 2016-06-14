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
use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Lib\PaymentGateway\ChargeResponse;

interface DTOBuilderFactoryInterface
{
    /**
     * @param Address $address
     * @return AddressDTOBuilder
     */
    public function getAddressDTOBuilder(Address $address);

    /**
     * @param Attachment $attachment
     * @return AttachmentDTOBuilder
     */
    public function getAttachmentDTOBuilder(Attachment $attachment);

    /**
     * @param Attribute $attribute
     * @return AttributeDTOBuilder
     */
    public function getAttributeDTOBuilder(Attribute $attribute);

    /**
     * @param AttributeValue $attributeValue
     * @return AttributeValueDTOBuilder
     */
    public function getAttributeValueDTOBuilder(AttributeValue $attributeValue);

    /**
     * @param Cart $cart
     * @return CartDTOBuilder
     */
    public function getCartDTOBuilder(Cart $cart);

    /**
     * @param CartItem $cartItem
     * @return CartItemDTOBuilder
     */
    public function getCartItemDTOBuilder(CartItem $cartItem);

    /**
     * @param CartItemOptionProduct $cartItemOptionProduct
     * @return CartItemOptionProductDTOBuilder
     */
    public function getCartItemOptionProductDTOBuilder(CartItemOptionProduct $cartItemOptionProduct);

    /**
     * @param CartItemOptionValue $cartItemOptionValue
     * @return CartItemOptionValueDTOBuilder
     */
    public function getCartItemOptionValueDTOBuilder(CartItemOptionValue $cartItemOptionValue);

    /**
     * @param CartItemTextOptionValue $cartItemTextOptionValue
     * @return CartItemTextOptionValueDTOBuilder
     */
    public function getCartItemTextOptionValueDTOBuilder(CartItemTextOptionValue $cartItemTextOptionValue);

    /**
     * @param CartPriceRule $cartPriceRule
     * @return CartPriceRuleDTOBuilder
     */
    public function getCartPriceRuleDTOBuilder(CartPriceRule $cartPriceRule);

    /**
     * @param CartPriceRuleDiscount $cartPriceRuleDiscount
     * @return CartPriceRuleDiscountDTOBuilder
     */
    public function getCartPriceRuleDiscountDTOBuilder(CartPriceRuleDiscount $cartPriceRuleDiscount);

    /**
     * @param AbstractCartPriceRuleItem $cartPriceRuleItem
     * @return AbstractCartPriceRuleItemDTOBuilder
     */
    public function getCartPriceRuleItemDTOBuilder(AbstractCartPriceRuleItem $cartPriceRuleItem);

    /**
     * @param CartPriceRuleProductItem $cartPriceRuleProductItem
     * @return CartPriceRuleProductItemDTOBuilder
     */
    public function getCartPriceRuleProductItemDTOBuilder(CartPriceRuleProductItem $cartPriceRuleProductItem);

    /**
     * @param CartPriceRuleTagItem $cartPriceRuleTagItem
     * @return CartPriceRuleTagItemDTOBuilder
     */
    public function getCartPriceRuleTagItemDTOBuilder(CartPriceRuleTagItem $cartPriceRuleTagItem);

    /**
     * @param CartTotal $cartTotal
     * @return CartTotalDTOBuilder
     */
    public function getCartTotalDTOBuilder(CartTotal $cartTotal);

    /**
     * @param CashPayment $cashPayment
     * @return CashPaymentDTOBuilder
     */
    public function getCashPaymentDTOBuilder(CashPayment $cashPayment);

    /**
     * @param CatalogPromotion $catalogPromotion
     * @return CatalogPromotionDTOBuilder
     */
    public function getCatalogPromotionDTOBuilder(CatalogPromotion $catalogPromotion);

    /**
     * @param ChargeResponse $chargeResponse
     * @return ChargeResponseDTOBuilder
     */
    public function getChargeResponseDTOBuilder(ChargeResponse $chargeResponse);

    /**
     * @param CheckPayment $checkPayment
     * @return CheckPaymentDTOBuilder
     */
    public function getCheckPaymentDTOBuilder(CheckPayment $checkPayment);

    /**
     * @param Coupon $coupon
     * @return CouponDTOBuilder
     */
    public function getCouponDTOBuilder(Coupon $coupon);

    /**
     * @param CreditCard $creditCard
     * @return CreditCardDTOBuilder
     */
    public function getCreditCardDTOBuilder(CreditCard $creditCard);

    /**
     * @param CreditPayment $creditPayment
     * @return CreditPaymentDTOBuilder
     */
    public function getCreditPaymentDTOBuilder(CreditPayment $creditPayment);

    /**
     * @param DeliveryMethodType $deliveryMethodType
     * @return DeliveryMethodTypeDTOBuilder
     */
    public function getDeliveryMethodTypeDTOBuilder(DeliveryMethodType $deliveryMethodType);

    /**
     * @param InventoryLocation $inventoryLocation
     * @return InventoryLocationDTOBuilder
     */
    public function getInventoryLocationDTOBuilder(InventoryLocation $inventoryLocation);

    /**
     * @param InventoryTransaction $inventoryTransaction
     * @return InventoryTransactionDTOBuilder
     */
    public function getInventoryTransactionDTOBuilder(InventoryTransaction $inventoryTransaction);

    /**
     * @param InventoryTransactionType $inventoryTransactionType
     * @return InventoryTransactionTypeDTOBuilder
     */
    public function getInventoryTransactionTypeDTOBuilder(InventoryTransactionType $inventoryTransactionType);

    /**
     * @param Image $image
     * @return ImageDTOBuilder
     */
    public function getImageDTOBuilder(Image $image);

    /**
     * @param Money $money
     * @return MoneyDTOBuilder
     */
    public function getMoneyDTOBuilder(Money $money);

    /**
     * @param Option $option
     * @return OptionDTOBuilder
     */
    public function getOptionDTOBuilder(Option $option);

    /**
     * @param Order $order
     * @return OrderDTOBuilder
     */
    public function getOrderDTOBuilder(Order $order);

    /**
     * @param OrderAddress $orderAddress
     * @return OrderAddressDTOBuilder
     */
    public function getOrderAddressDTOBuilder(OrderAddress $orderAddress);

    /**
     * @param OptionProduct $optionProduct
     * @return OptionProductDTOBuilder
     */
    public function getOptionProductDTOBuilder(OptionProduct $optionProduct);

    /**
     * @param OptionType $optionType
     * @return OptionTypeDTOBuilder
     */
    public function getOptionTypeDTOBuilder(OptionType $optionType);

    /**
     * @param OptionValue $optionValue
     * @return OptionValueDTOBuilder
     */
    public function getOptionValueDTOBuilder(OptionValue $optionValue);

    /**
     * @param OrderItem $orderItem
     * @return OrderItemDTOBuilder
     */
    public function getOrderItemDTOBuilder(OrderItem $orderItem);

    /**
     * @param OrderItemOptionProduct $orderItemOptionProduct
     * @return OrderItemOptionProductDTOBuilder
     */
    public function getOrderItemOptionProductDTOBuilder(OrderItemOptionProduct $orderItemOptionProduct);

    /**
     * @param OrderItemOptionValue $orderItemOptionValue
     * @return OrderItemOptionValueDTOBuilder
     */
    public function getOrderItemOptionValueDTOBuilder(OrderItemOptionValue $orderItemOptionValue);

    /**
     * @param OrderItemTextOptionValue $orderItemTextOptionValue
     * @return OrderItemTextOptionValueDTOBuilder
     */
    public function getOrderItemTextOptionValueDTOBuilder(OrderItemTextOptionValue $orderItemTextOptionValue);

    /**
     * @param OrderStatusType $orderStatusType
     * @return OrderStatusTypeDTOBuilder
     */
    public function getOrderStatusTypeDTOBuilder(OrderStatusType $orderStatusType);

    /**
     * @param Pagination $pagination
     * @return PaginationDTOBuilder
     */
    public function getPaginationDTOBuilder(Pagination $pagination);

    /**
     * @param Parcel $parcel
     * @return PaginationDTOBuilder
     */
    public function getParcelDTOBuilder(Parcel $parcel);

    /**
     * @param AbstractPayment $payment
     * @return AbstractPaymentDTOBuilder
     */
    public function getPaymentDTOBuilder(AbstractPayment $payment);

    /**
     * @param Point $point
     * @return PointDTOBuilder
     */
    public function getPointDTOBuilder(Point $point);

    /**
     * @param Price $price
     * @return PriceDTOBuilder
     */
    public function getPriceDTOBuilder(Price $price);

    /**
     * @param PromotionType $promotionType
     * @return PromotionTypeDTOBuilder
     */
    public function getPromotionTypeDTOBuilder(PromotionType $promotionType);

    /**
     * @param Product $product
     * @return ProductDTOBuilder
     */
    public function getProductDTOBuilder(Product $product);

    /**
     * @param ProductAttribute $productAttribute
     * @return ProductAttributeDTOBuilder
     */
    public function getProductAttributeDTOBuilder(ProductAttribute $productAttribute);

    /**
     * @param ProductQuantityDiscount $productQuantityDiscount
     * @return ProductQuantityDiscountDTOBuilder
     */
    public function getProductQuantityDiscountDTOBuilder(ProductQuantityDiscount $productQuantityDiscount);

    /**
     * @param Shipment $shipment
     * @return ShipmentDTOBuilder
     */
    public function getShipmentDTOBuilder(Shipment $shipment);

    /**
     * @param ShipmentCarrierType $shipmentCarrierType
     * @return ShipmentCarrierTypeDTOBuilder
     */
    public function getShipmentCarrierTypeDTOBuilder(ShipmentCarrierType $shipmentCarrierType);

    /**
     * @param ShipmentComment $shipmentComment
     * @return ShipmentCommentDTOBuilder
     */
    public function getShipmentCommentDTOBuilder(ShipmentComment $shipmentComment);

    /**
     * @param ShipmentItem $shipmentItem
     * @return ShipmentItemDTOBuilder
     */
    public function getShipmentItemDTOBuilder(ShipmentItem $shipmentItem);

    /**
     * @param ShipmentLabel $shipmentLabel
     * @return ShipmentLabelDTOBuilder
     */
    public function getShipmentLabelDTOBuilder(ShipmentLabel $shipmentLabel);

    /**
     * @param ShipmentRate $shipmentRate
     * @return ShipmentRateDTOBuilder
     */
    public function getShipmentRateDTOBuilder(ShipmentRate $shipmentRate);

    /**
     * @param ShipmentTracker $shipmentTracker
     * @return ShipmentTrackerDTOBuilder
     */
    public function getShipmentTrackerDTOBuilder(ShipmentTracker $shipmentTracker);

    /**
     * @param Tag $tag
     * @return TagDTOBuilder
     */
    public function getTagDTOBuilder(Tag $tag);

    /**
     * @param TaxRate $taxRate
     * @return TaxRateDTOBuilder
     */
    public function getTaxRateDTOBuilder(TaxRate $taxRate);

    /**
     * @param TextOption $textOption
     * @return TextOptionDTOBuilder
     */
    public function getTextOptionDTOBuilder(TextOption $textOption);

    /**
     * @param TextOptionType $textOptionType
     * @return TextOptionTypeDTOBuilder
     */
    public function getTextOptionTypeDTOBuilder(TextOptionType $textOptionType);

    /**
     * @param User $user
     * @return UserDTOBuilder
     */
    public function getUserDTOBuilder(User $user);

    /**
     * @param UserLogin $userLogin
     * @return UserLoginDTOBuilder
     */
    public function getUserLoginDTOBuilder(UserLogin $userLogin);

    /**
     * @param UserLoginResultType $userLoginResultType
     * @return UserLoginResultTypeDTOBuilder
     */
    public function getUserLoginResultTypeDTOBuilder(UserLoginResultType $userLoginResultType);

    /**
     * @param UserRole $userRole
     * @return UserRoleDTOBuilder
     */
    public function getUserRoleDTOBuilder(UserRole $userRole);

    /**
     * @param UserStatusType $userStatusType
     * @return UserStatusTypeDTOBuilder
     */
    public function getUserStatusTypeDTOBuilder(UserStatusType $userStatusType);

    /**
     * @param UserToken $userToken
     * @return UserTokenDTOBuilder
     */
    public function getUserTokenDTOBuilder(UserToken $userToken);

    /**
     * @param UserTokenType $userTokenType
     * @return UserTokenTypeDTOBuilder
     */
    public function getUserTokenTypeDTOBuilder(UserTokenType $userTokenType);

    /**
     * @param Warehouse $warehouse
     * @return WarehouseDTOBuilder
     */
    public function getWarehouseDTOBuilder(Warehouse $warehouse);
}

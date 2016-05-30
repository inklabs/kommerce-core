<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\CreateOrderFromCartQuery;
use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartRequest;
use inklabs\kommerce\Action\Order\Query\CreateOrderFromCartResponse;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOrderFromCartHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        Product::class,
        Option::class,
        OptionProduct::class,
        Tag::class,
        Image::class,
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        AbstractPayment::class,
        InventoryLocation::class,
        InventoryTransaction::class,
        Warehouse::class,
        TaxRate::class,
    ];

    public function testHandleWithFullIntegration()
    {
        $cart = $this->setupDBCart();

        $creditCardDTO = $this->dummyData->getCreditCard()->getDTOBuilder()->build();
        $shippingAddressDTO = $this->dummyData->getOrderAddress()->getDTOBuilder()->build();
        $billingAddressDTO = $this->dummyData->getOrderAddress()->getDTOBuilder()->build();

        $request = new CreateOrderFromCartRequest(
            $cart->getId(),
            '10.0.0.1',
            $creditCardDTO,
            $shippingAddressDTO,
            $billingAddressDTO
        );
        $response = new CreateOrderFromCartResponse;

        $serviceFactory = $this->getServiceFactory();
        $handler = new CreateOrderFromCartHandler(
            $serviceFactory->getCart(),
            $serviceFactory->getCartCalculator(),
            $serviceFactory->getOrder(),
            $this->getPaymentGateway()
        );
        $handler->handle(new CreateOrderFromCartQuery($request, $response));

        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneById(1);
        $this->assertTrue($order instanceof Order);
        $this->assertTrue($order->getPayments()[0] instanceof AbstractPayment);
        $this->assertTrue($response->getOrderDTO() instanceof OrderDTO);

        $this->setExpectedException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
    }

    protected function setupDBCart()
    {
        $user = $this->dummyData->getUser();
        $product = $this->dummyData->getProduct();
        $option = $this->dummyData->getOption();
        $product2 = $this->dummyData->getProduct();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct($optionProduct);
        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);

        $cart = $this->dummyData->getCart();
        $cart->setUser($user);
        $cart->addCartItem($cartItem);

        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $holdLocation = $this->dummyData->getInventoryLocation($warehouse);
        $holdLocation->setName('Customer hold Location');

        $inventoryTransaction1 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $inventoryTransaction2 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product2);

        $this->entityManager->persist($user);
        $this->entityManager->persist($product);
        $this->entityManager->persist($option);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($optionProduct);
        $this->entityManager->persist($cart);
        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($holdLocation);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($inventoryTransaction1);
        $this->entityManager->persist($inventoryTransaction2);
        $this->entityManager->flush($product);

        return $cart;
    }
}

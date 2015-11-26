<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Order\CreateOrderFromCartRequest;
use inklabs\kommerce\Action\Order\Handler\CreateOrderFromCartHandler;
use inklabs\kommerce\Action\Order\Response\CreateOrderFromCartResponse;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreateOrderFromCartHandlerTest extends DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:Product',
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:Tag',
        'kommerce:Image',
        'kommerce:Cart',
        'kommerce:CartItem',
        'kommerce:CartItemOptionProduct',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionProduct',
        'kommerce:AbstractPayment',
        'kommerce:InventoryLocation',
        'kommerce:InventoryTransaction',
        'kommerce:Warehouse',
        'kommerce:TaxRate',
    ];

    public function testHandleWithFullIntegration()
    {
        $serviceFactory = $this->getServiceFactory();
        $handler = new CreateOrderFromCartHandler(
            $serviceFactory->getCart(),
            $serviceFactory->getCartCalculator(),
            $serviceFactory->getOrder(),
            $this->getPaymentGateway()
        );

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
        $handler->handle($request, $response);

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
        $product = $this->dummyData->getProduct(1);
        $option = $this->dummyData->getOption();
        $product2 = $this->dummyData->getProduct(2);
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct($optionProduct);
        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);

        $cart = $this->dummyData->getCart();
        $cart->setUser($user);
        $cart->addCartItem($cartItem);

        $warehouse = $this->dummyData->getWarehouse(1);
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

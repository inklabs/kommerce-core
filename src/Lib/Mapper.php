<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\RequestInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\CouponServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\Service\UserServiceInterface;
use ReflectionClass;

class Mapper implements MapperInterface
{
    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var Pricing */
    private $pricing;

    public function __construct(ServiceFactory $serviceFactory, Pricing $pricing)
    {
        $this->serviceFactory = $serviceFactory;
        $this->pricing = $pricing;
    }

    public function getCommandHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getHandlerClassName($command);
        return $this->getHandler($handlerClassName);
    }

    public function getQueryHandler(RequestInterface $request)
    {
        $handlerClassName = $this->getHandlerClassName($request);
        return $this->getHandler($handlerClassName);
    }

    /**
     * @param string $handlerClassName
     * @return null|object
     */
    public function getHandler($handlerClassName)
    {
        $reflection = new ReflectionClass($handlerClassName);

        $constructorParameters = [];
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $parameter) {
                $parameterClassName = $parameter->getClass()->getName();
                if ($parameterClassName === TagServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getTagService();
                } elseif ($parameterClassName === InventoryServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getInventoryService();
                } elseif ($parameterClassName === ImageServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImageService();
                } elseif ($parameterClassName === CartCalculatorInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCartCalculator();
                } elseif ($parameterClassName === CartServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCart();
                } elseif ($parameterClassName === CouponServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCoupon();
                } elseif ($parameterClassName === OrderServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getOrder();
                } elseif ($parameterClassName === Pricing::class) {
                    $constructorParameters[] = $this->pricing;
                } elseif ($parameterClassName === ProductServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getProduct();
                } elseif ($parameterClassName === ShipmentGatewayInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getShipmentGateway();
                } elseif ($parameterClassName === UserServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getUser();
                }
            }
        }

        $handler = null;

        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        } else {
            $handler = $reflection->newInstance();
        }

        return $handler;
    }

    /**
     * @param CommandInterface | RequestInterface $command
     * @return string
     */
    private function getHandlerClassName($command)
    {
        $className = get_class($command);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = substr($baseName, 0, -7) . 'Handler';

        $pieces[] = 'Handler';
        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }
}

<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\RequestInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
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
    private function getHandler($handlerClassName)
    {
        $reflection = new ReflectionClass($handlerClassName);

        $constructorParameters = [];
        foreach ($reflection->getConstructor()->getParameters() as $parameter) {
            $parameterClassName = $parameter->getClass()->getName();
            if ($parameterClassName === TagServiceInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getTagService();
            } elseif ($parameterClassName === ImageServiceInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getImageService();
            } elseif ($parameterClassName === CartServiceInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getCart();
            } elseif ($parameterClassName === OrderServiceInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getOrder();
            } elseif ($parameterClassName === Pricing::class) {
                $constructorParameters[] = $this->pricing;
            } elseif ($parameterClassName === ShipmentGatewayInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getShipmentGateway();
            } elseif ($parameterClassName === UserServiceInterface::class) {
                $constructorParameters[] = $this->serviceFactory->getUser();
            }
        }

        $handler = null;
        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        }

        return $handler;
    }

    /**
     * @param CommandInterface|RequestInterface $command
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

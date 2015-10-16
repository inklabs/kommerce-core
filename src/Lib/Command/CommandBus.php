<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Service\ServiceFactory;
use ReflectionClass;

class CommandBus implements CommandBusInterface
{
    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var CommandHandlerInterface */
    private $handler;

    public function __construct(ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
    }

    public function execute(CommandInterface $command)
    {
        $this->handler = $this->getHandler($command);
        $this->handler->handle($command);
    }

    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     */
    private function getHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getHandlerClassName($command);

        $constructorParameters = [];
        if (is_subclass_of($handlerClassName, TagServiceAwareInterface::class, true)) {
            $constructorParameters[] = $this->serviceFactory->getTagService();
        }

        if (is_subclass_of($handlerClassName, ImageServiceAwareInterface::class, true)) {
            $constructorParameters[] = $this->serviceFactory->getImageService();
        }

        $reflection = new ReflectionClass($handlerClassName);
        $handler = null;
        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        }

        return $handler;
    }

    /**
     * @param CommandInterface $command
     * @return string
     */
    private function getHandlerClassName(CommandInterface $command)
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

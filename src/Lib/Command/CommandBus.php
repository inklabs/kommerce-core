<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Service\ServiceFactory;

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

    /**
     * @param ServiceFactory $serviceFactory
     * @return CommandBus
     */
    public static function getInstance(ServiceFactory $serviceFactory)
    {
        static $commandBus = null;

        if ($commandBus === null) {
            $commandBus = new static($serviceFactory);
        }

        return $commandBus;
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

        if (is_subclass_of($handlerClassName, TagServiceAwareInterface::class, true)) {
            $handler = new $handlerClassName($this->serviceFactory->getTagService());
        } else {
            $handler = new $handlerClassName;
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

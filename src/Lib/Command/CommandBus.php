<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Service\ServiceFactory;

class CommandBus implements CommandBusInterface
{
    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var HandlerInterface */
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
     * @return HandlerInterface
     */
    private function getHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getHandlerClassName($command);

        if (is_subclass_of($handlerClassName, 'inklabs\kommerce\Lib\Command\TagServiceAwareInterface', true)) {
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
        $baseClassName = substr($className, 0, -7);
        return $baseClassName . 'Handler';
    }
}

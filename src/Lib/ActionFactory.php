<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Action\CommandInterface;
use inklabs\kommerce\Action\Tag\CreateTag;
use inklabs\kommerce\Action\Tag\DeleteTag;
use inklabs\kommerce\Action\Tag\EditTag;

class ActionFactory
{
    /** @var FactoryService */
    private $factoryService;

    public function __construct(FactoryService $factoryService)
    {
        $this->factoryService = $factoryService;
    }

    /**
     * @param FactoryService $factoryService
     * @return ActionFactory
     */
    public static function getInstance(FactoryService $factoryService)
    {
        static $actionFactory = null;

        if ($actionFactory === null) {
            $actionFactory = new static($factoryService);
        }

        return $actionFactory;
    }

    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command)
    {
        $actionName = 'get' . $this->getActionName($command);
        $this->$actionName()->execute($command);
    }

    private function getActionName(CommandInterface $command)
    {
        $pieces = explode('\\', str_replace('Command', '', get_class($command)));
        return end($pieces);
    }

    /**
     * @return EditTag
     */
    public function getEditTag()
    {
        return new EditTag($this->factoryService->getTagService());
    }

    /**
     * @return CreateTag
     */
    public function getCreateTag()
    {
        return new CreateTag($this->factoryService->getTagService());
    }

    /**
     * @return DeleteTag
     */
    public function getDeleteTag()
    {
        return new DeleteTag($this->factoryService->getTagService());
    }
}

<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Action\CommandInterface;
use inklabs\kommerce\Action\Tag\CreateTag;
use inklabs\kommerce\Action\Tag\DeleteTag;
use inklabs\kommerce\Action\Tag\EditTag;
use inklabs\kommerce\Action\Tag\GetTag;

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
     */
    public function execute(CommandInterface $command)
    {
        $actionName = 'get' . $this->getActionName($command);
        return $this->$actionName()->execute($command);
    }

    private function getActionName(CommandInterface $command)
    {
        $pieces = explode('\\', str_replace('Command', '', get_class($command)));
        return end($pieces);
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

    /**
     * @return EditTag
     */
    public function getEditTag()
    {
        return new EditTag($this->factoryService->getTagService());
    }

    /**
     * @return GetTag
     */
    public function getGetTag()
    {
        return new GetTag($this->factoryService->getTagService());
    }
}

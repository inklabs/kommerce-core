<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Action\CommandInterface;
use inklabs\kommerce\Action\Tag\CreateTag;
use inklabs\kommerce\Action\Tag\DeleteTag;
use inklabs\kommerce\Action\Tag\EditTag;

class ActionFactory
{
    /** @var CartCalculatorInterface */
    protected $cartCalculator;

    /** @var FactoryRepository */
    protected $factoryRepository;

    public function __construct(
        FactoryRepository $factoryRepository,
        CartCalculatorInterface $cartCalculator
    ) {
        $this->cartCalculator = $cartCalculator;
        $this->factoryRepository = $factoryRepository;
    }

    /**
     * @param FactoryRepository $factoryRepository
     * @param CartCalculatorInterface $cartCalculator
     * @return ActionFactory
     */
    public static function getInstance(
        FactoryRepository $factoryRepository,
        CartCalculatorInterface $cartCalculator
    ) {
        static $actionFactory = null;

        if ($actionFactory === null) {
            $actionFactory = new static($factoryRepository, $cartCalculator);
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
        return new EditTag($this->factoryRepository->getTagRepository());
    }

    /**
     * @return CreateTag
     */
    public function getCreateTag()
    {
        return new CreateTag($this->factoryRepository->getTagRepository());
    }

    /**
     * @return DeleteTag
     */
    public function getDeleteTag()
    {
        return new DeleteTag($this->factoryRepository->getTagRepository());
    }
}

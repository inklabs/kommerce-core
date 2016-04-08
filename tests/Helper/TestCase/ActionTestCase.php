<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\Lib\Command\CommandBus;
use inklabs\kommerce\Lib\Mapper;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Query\QueryBus;
use inklabs\kommerce\Service\ServiceFactory;

abstract class ActionTestCase extends ServiceTestCase
{
    protected function getCommandBus()
    {
        return new CommandBus($this->getMapper());
    }

    protected function getQueryBus()
    {
        return new QueryBus($this->getMapper());
    }

    protected function getMapper(ServiceFactory $serviceFactory = null, Pricing $pricing = null)
    {
        if ($serviceFactory === null) {
            $serviceFactory = $this->getServiceFactory();
        }

        if ($pricing === null) {
            $pricing = new Pricing;
        }

        return new Mapper($serviceFactory, $pricing);
    }
}

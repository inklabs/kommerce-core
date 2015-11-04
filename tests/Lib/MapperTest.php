<?php
namespace inklabs\kommerce\tests\Lib;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\Lib\FakeCommand;
use inklabs\kommerce\tests\Helper\Lib\FakeRequest;

class MapperTest extends DoctrineTestCase
{
    protected $metaDataClassNames = [];

    public function testCreate()
    {
        $mapper = $this->getMapper();
        $mapper->getCommandHandler(new FakeCommand);
        $mapper->getQueryHandler(new FakeRequest);
    }
}

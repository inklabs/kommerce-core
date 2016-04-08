<?php
namespace inklabs\kommerce\tests\Lib;

use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;
use inklabs\kommerce\tests\Helper\Lib\FakeCommand;
use inklabs\kommerce\tests\Helper\Lib\FakeRequest;

class MapperTest extends ActionTestCase
{
    protected $metaDataClassNames = [];

    public function testCreate()
    {
        $mapper = $this->getMapper();
        $mapper->getCommandHandler(new FakeCommand);
        $mapper->getQueryHandler(new FakeRequest);
    }
}

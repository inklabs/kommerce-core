<?php
namespace inklabs\kommerce\tests\Lib;

use inklabs\kommerce\Lib\Mapper;
use inklabs\kommerce\tests\Helper\Lib\Handler\FakeHandler;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;
use inklabs\kommerce\tests\Helper\Lib\FakeCommand;
use inklabs\kommerce\tests\Helper\Lib\FakeRequest;
use Mockery;

class MapperTest extends ActionTestCase
{
    protected $metaDataClassNames = [];

    /** @var Mapper  */
    protected $mapper;

    public function setUp()
    {
        parent::setUp();
        $this->mapper = $this->getMapper();
    }

    public function testGetCommandHandler()
    {
        $commandHandler = $this->mapper->getCommandHandler(new FakeCommand);
        $this->assertTrue($commandHandler instanceof FakeHandler);
    }

    public function testGetQueryHandler()
    {
        $requestHandler = $this->mapper->getQueryHandler(new FakeRequest);
        $this->assertTrue($requestHandler instanceof FakeHandler);
    }
}

<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Helper\Action\FakeCommand;
use inklabs\kommerce\tests\Helper\Action\FakeQuery;
use inklabs\kommerce\tests\Helper\Action\Query\FakeRequest;
use inklabs\kommerce\tests\Helper\Action\Query\FakeResponse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

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
        $this->mapper->getCommandHandler(new FakeCommand());
    }

    public function testGetQueryHandler()
    {
        $request = new FakeRequest();
        $response = new FakeResponse();
        $query = new FakeQuery($request, $response);
        $this->mapper->getQueryHandler($query);
    }

    public function testGetHandlerOnAllHandlers()
    {
        $files = glob(__DIR__ . '/../../src/ActionHandler/*/*Handler.php', GLOB_BRACE);

        foreach ($files as $file) {
            $handlerClassName = $this->getClassNameFromFile($file);
            $this->mapper->getHandler($handlerClassName);
        }
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getClassNameFromFile($fileName)
    {
        $class = '';
        $namespace = '';
        $contents = file_get_contents($fileName);
        $lastTokenWasNamespace = false;
        $lastTokenWasClass = false;
        foreach (token_get_all($contents) as $token) {
            $tokenIndex = $token[0];
            if ($tokenIndex === T_NAMESPACE) {
                $lastTokenWasNamespace = true;
            }

            if ($tokenIndex === T_CLASS) {
                $lastTokenWasClass = true;
            }

            if ($lastTokenWasNamespace) {
                if (in_array($tokenIndex, [T_STRING, T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } elseif ($token === ';') {
                    $lastTokenWasNamespace = false;
                }
            }

            if ($lastTokenWasClass) {
                if ($tokenIndex == T_STRING) {
                    $class = $token[1];
                    break;
                }
            }
        }

        return $namespace . '\\' . $class;
    }
}

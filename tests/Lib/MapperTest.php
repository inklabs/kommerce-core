<?php
namespace inklabs\kommerce\tests\Lib;

use inklabs\kommerce\Lib\Mapper;
use inklabs\kommerce\tests\Helper\Lib\FakeCommand;
use inklabs\kommerce\tests\Helper\Lib\FakeRequest;
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
        $this->mapper->getQueryHandler(new FakeRequest());
    }

    public function testGetHandlerOnAllHandlers()
    {
        $files = glob('../../src/ActionHandler/*/*Handler.php', GLOB_BRACE);

        foreach ($files as $file) {
            error_log($file);
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

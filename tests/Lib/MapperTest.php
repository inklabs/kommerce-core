<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;
use ReflectionException;

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

    public function testGetHandlerOnAllHandlers()
    {
        $files = glob(realpath(__DIR__ . '/../..') . '/src/ActionHandler/*/*Handler.php');

        foreach ($files as $file) {
            if (! strpos($file, '/Abstract')) {
                $handlerClassName = $this->getClassNameFromFile($file);

                try {
                    $actionClassName = $this->getCommandClassNameFromHandler($handlerClassName);
                    $reflection = new \ReflectionClass($actionClassName);
                } catch (ReflectionException $e) {
                    $actionClassName = $this->getQueryClassNameFromHandler($handlerClassName);
                    $reflection = new \ReflectionClass($actionClassName);
                }

                $action = $reflection->newInstanceWithoutConstructor();

                $handler = $this->mapper->getHandler($handlerClassName, $action);
                $this->assertTrue($handler instanceof HandlerInterface);
            }
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

    private function getCommandClassNameFromHandler($handlerClassName)
    {
        $actionClassName = str_replace('ActionHandler', 'Action', $handlerClassName);
        $actionClassName = str_replace('Handler', 'Command', $actionClassName);
        return $actionClassName;
    }

    private function getQueryClassNameFromHandler($handlerClassName)
    {
        $actionClassName = str_replace('ActionHandler', 'Action', $handlerClassName);
        $actionClassName = str_replace('Handler', 'Query', $actionClassName);
        return $actionClassName;
    }
}

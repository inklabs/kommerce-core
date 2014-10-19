<?php
namespace inklabs\kommerce;

use ReflectionClass;

class J
{
    private $output;
    private $level = 0;
    private $limit = 2;

    public static $localPath;

    public function __construct()
    {
        $this->output = $this->getJsAndCss();
    }

    public static function factory()
    {
        static $object = null;
        if ($object === null) {
            $object = new self;
        }
        return $object;
    }

    public static function debug($var, $limit = 2, $return = false)
    {
        $j = self::factory();
        $j->var = $var;
        $j->limit = $limit * 2;
        $j->level = 0;

        $j->process($j->var);

        if ($return) {
            $output = $j->output;
            $j->output = '';
            return $j->output;
        } else {
            echo $j->output;
            $j->output = '';
        }
    }

    private function process($var, $title = null)
    {
        if ($this->level > $this->limit) {
            return;
        }

        $this->level++;

        if (is_object($var)) {
            if (in_array('Doctrine\Common\Collections\Collection', class_implements($var))) {
                $var = $var->toArray();
            } elseif ($var instanceof \DateTime) {
                $var = [
                    '__CLASS__' => '\DateTime',
                    'date' => $var->format('c'),
                    'timezone' => $var->getTimeZone()->getName(),
                ];
            }
        }


        switch (gettype($var)) {
            case 'array':
                $this->processArray($var, $title);
                break;

            case 'boolean':
                $this->processBool($var);
                break;

            case 'NULL':
                $this->output .= 'NULL';
                break;

            case 'object':
                $this->processObject($var);
                break;

            case 'unknown':
                $this->output .= '[not supported]';
                break;

            case 'integer':
            case 'string':
            default:
                $this->processString($var);
                break;
        }
        $this->level--;
    }

    private function processBool($var)
    {
        if ($var === true) {
            $this->output .= 'TRUE';
        } else {
            $this->output .= 'FALSE';
        }
    }

    private function processString($var)
    {
        if ($var === '') {
            $this->output .= '[empty string]';
        } else {
            $this->output .= $var;
        }
    }

    private function processArray($var, $title = 'Array')
    {
        if (empty($var)) {
            $this->output .= '[empty array]';
            return;
        }

        $this->output .= '<table class="jdebug jdebug-array">';

        $toggle = 'onclick="jdebugToggleTbody(this)"';
        $this->output .= '<thead><tr><th colspan="100%" ' . $toggle . '>' . $title . '</th></tr></thead>';

        $this->output .= '<tbody>';
        foreach ($var as $k => $v) {
            $type = gettype($v);
            if ($type == 'string') {
                $type .= ' (' . strlen($v) . ')';
            }

            $toggle = 'onclick="jdebugToggleRow(this)"';

            $this->output .= '<tr><td ' . $toggle . '>' . $k . '</td><td>' . $type . '</td><td>';
            $this->output .= $this->process($v);
            $this->output .= '</td></tr>';
        }
        $this->output .= '</tbody></table>';
    }

    private function processObject($var)
    {
        $reflector = new ReflectionClass($var);

        $name = $this->getName($var);

        $this->output .= '<table class="jdebug jdebug-object">';

        $this->output .= '<thead><tr><th colspan="100%" ' .
            'onclick="jdebugToggleTbody(this)"' . '>' .
            $name . '</th></tr></thead>';

        $local_file = str_replace('/vagrant', self::$localPath, $reflector->getFileName());
        $this->output .= '<tbody style="display: none;"><tr><td>' .
            'Location: ' . $reflector->getFileName() . ':' . $reflector->getStartLine().
            ' (<a href="txmt://open/?url=file://' . $local_file . '">txmt</a>)';

        $methods = [
            'public' => [],
            'private' => [],
            'protected' => [],
        ];

        foreach ($reflector->getMethods() as $method) {
            if ($method->isPrivate()) {
                $access = 'private';
            } elseif ($method->isProtected()) {
                $access = 'protected';
            } else {
                $access = 'public';
            }
            $methods[$access][$method->getName()] = $method;
        }

        foreach ($methods as $access => $accessMethods) {
            ksort($methods[$access]);
        }

        foreach ($methods as $access => $accessMethods) {
            if (empty($accessMethods)) {
                continue;
            }

            $this->output .= '<a class="jdebug-link" href="javascript:void(0)" ' .
                'onclick="jdebugToggleNext(this);">' .
                ucwords($access) . ' Methods</a>' .
                '<div class="jdebug-container" style="display: none;">';

            foreach ($accessMethods as $method) {

                $params = [];
                foreach ($method->getParameters() as $param) {
                    $params[] = '<span class="jdebug-method-param">$' . $param->getName() . '</span>';

                }

                if ($method->isAbstract()) {
                    $method_type = 'abstract';
                } elseif ($method->isFinal()) {
                    $method_type = 'final';
                } elseif ($method->isStatic()) {
                    $method_type = 'static';
                } else {
                    $method_type = '';
                }

                if ($method_type !== '') {
                    $this->output .= '<span class="jdebug-method-type">' . $method_type . '</span>&nbsp;';
                }

                $this->output .= '<span class="jdebug-method-name">' . $method->getName() . '</span>' .
                    '(' . implode(', ', $params) . ')</span><br>';
            }
            $this->output .= '</div>';
        }

        // print_r
        // $this->output .= '<a class="jdebug-link" href="javascript:void(0)" ' .
        //     'onclick="jdebugToggleNext(this);">' .
        //     'Contents</a>' .
        //     '<div class="jdebug-container" style="display: none;">'.
        //     htmlentities(print_r($var, true)).
        //     '</div>';

        // __toString
        if (method_exists($var, '__toString')) {
            $this->output .= '<a class="jdebug-link" href="javascript:void(0)" ' .
                'onclick="jdebugToggleNext(this);">' .
                '__toString()</a>' .
                '<div class="jdebug-container" style="display: none;">'.
                htmlentities($var->__toString()).
                '</div>';
        }

        // __getData
        if (method_exists($var, '__getData')) {
            $this->process($var->__getData());
        }

        $this->processVarProperties($var);
        $this->processPublicProperties($var);
        $this->processProtectedProperties($var);
        $this->processPrivateProperties($var);
        // $this->processGetters($var);

        // __dbResult
        if (method_exists($var, '__dbResult')) {
            $this->process($var->__dbResult());
        }

        if (method_exists($var, 'getRelated')) {
            $this->processRelated($var);
        }

        $this->output .= '</td></tr></tbody></table>';
    }

    private function processVarProperties($var)
    {
        $output = [];
        $properties = get_object_vars($var);
        ksort($properties);
        foreach ($properties as $name => $value) {
            $output['$' . $name] = $value;
        }

        if (! empty($output)) {
            $this->processArray($output, 'Var Properties');
        }
    }

    private function processPublicProperties($var)
    {
        $output = [];
        $reflector = new ReflectionClass($var);
        $properties = [];
        foreach ($reflector->getProperties() as $property) {
            $properties[$property->name] = $property;
        }
        ksort($properties);
        foreach ($properties as $property) {
            if (! $property->isPublic()) {
                continue;
            } elseif ($property->isStatic()) {
                $output['static $' . $property->name] = $reflector->getStaticPropertyValue($property->name);
            } else {
                $output['$' . $property->name] = $var->{$property->name};
            }
        }

        if (! empty($output)) {
            $this->processArray($output, 'Public Properties');
        }
    }

    private function processProtectedProperties($var)
    {
        $output = [];
        $reflector = new ReflectionClass($var);
        $properties = [];
        foreach ($reflector->getProperties() as $property) {
            $properties[$property->name] = $property;
        }
        ksort($properties);
        foreach ($properties as $property) {
            if (! $property->isProtected()) {
                continue;
            } elseif ($property->isStatic()) {
                $output['static $' . $property->name] = $reflector->getStaticPropertyValue($property->name);
            } else {
                $property->setAccessible(true);

                $value = $property->getValue($var);

                $output['$' . $property->name] = $value;
            }
        }

        if (! empty($output)) {
            $this->processArray($output, 'Protected Properties');
        }
    }

    private function processPrivateProperties($var)
    {
        $output = [];
        $reflector = new ReflectionClass($var);
        $properties = [];
        foreach ($reflector->getProperties() as $property) {
            $properties[$property->name] = $property;
        }
        ksort($properties);
        foreach ($properties as $property) {
            if (! $property->isPrivate()) {
                continue;
            } elseif ($property->isStatic()) {
                $output['static $' . $property->name] = $reflector->getStaticPropertyValue($property->name);
            } else {
                $property->setAccessible(true);
                $output['$' . $property->name] = $property->getValue($var);
            }
        }

        if (! empty($output)) {
            $this->processArray($output, 'Private Properties');
        }
    }

    private function processGetters($var)
    {
        $output = [];
        $reflector = new ReflectionClass($var);
        $methods = [];
        foreach ($reflector->getMethods() as $method) {
            $methods[$method->name] = $method;
        }
        ksort($methods);
        foreach ($methods as $method) {
            if (preg_match('/^get[A-Z]/', $method->name)) {
                if (! $method->isPublic() or (count($method->getParameters()) > 0)) {
                    continue;
                }

                $value = $var->{$method->name}();

                $output[$method->name . '()'] = $value;
            }
        }

        if (! empty($output)) {
            $this->processArray($output, 'Public Getters');
        }
    }

    private function processRelated($var, $level = 1, $parent = '')
    {
        if ($parent !== '') {
            $parent .= ' -> ';
        }

        foreach ($var->getRelated() as $related) {
            $reflector = new ReflectionClass($var->$related);
            $name = $reflector->getName();

            $this->output .= '<div style="margin-left: ' . ($level * 20) . 'px; margin-top: 5px;">';
            $this->process($var->$related->__getData(), $parent . $name);
            $this->output .= '</div>';

            if (method_exists($var->$related, 'getRelated')) {
                $this->processRelated($var->$related, $level + 1, $name);
            }
        }
    }

    private function getName($var, $level = 0)
    {
        $output = '';

        if ($level == 0) {
            $reflector = new ReflectionClass($var);
            $name = $reflector->getName();
            $output .= $name;

            if (method_exists($var, 'pk')) {
                $output .= '(' . $var->pk() . ')';
            } elseif (method_exists($var, 'getId')) {
                $output .= '(' . $var->getId() . ')';
            }
        }

        if (method_exists($var, 'getDefaultImage') and ! empty($img = $var->getDefaultImage())) {
            $output .= '<img src="/data/image/' . $img . '" />';
        }

        if (method_exists($var, 'getRelated')) {
            foreach ($var->getRelated() as $related) {
                $reflector = new ReflectionClass($related_property);
                $name = $reflector->getName();

                $output .= ' -> ' . $name . '(' . $var->$related->pk() . ')';

                if (method_exists($var->$related, 'getRelated')) {
                    $output .= $this->getName($var->$related, $level + 1);
                }
            }
        }

        return $output;
    }

    private function getJsAndCss()
    {
        return '
            <script>
                function jdebugToggleRow(source) {
                    var target = source.parentNode.lastChild;
                    toggleState(target);
                };

                function jdebugToggleTbody(source) {
                    var target = source.parentNode.parentNode.parentNode.tBodies[0];
                    toggleState(target);
                };

                function jdebugToggleNext(source) {
                    var target = source.nextSibling;
                    toggleState(target);
                };

                function toggleState(target)
                {
                    if (target.style.display == "none") {
                        target.style.display = "";
                    } else {
                        target.style.display = "none";
                    }
                };
            </script>
            <style>
                .jdebug {
                    font-family:Verdana, Arial, Helvetica, sans-serif; color:#000000; font-size:12px;
                    text-decoration: none;
                }
                .jdebug h2 {
                    color: #0000A2;
                    font-weight: bold;
                }
                .jdebug-object>thead>tr>th>img {
                    max-height: 50px;
                }
                .jdebug-object>tbody>tr>td>img {
                    max-width: 200px;
                    max-height: 200px;
                    float: right;
                }
                .jdebug-array { background-color: #060; border-collapse: collapse;
                    border: 1px solid #CCC; border-radius: 4px; margin-bottom: 10px; }
                .jdebug-array thead th { background-color: #090; color: #fff; cursor: pointer; }
                .jdebug-array>tbody>tr>td { background-color: #fff; padding: 1px 2px; vertical-align: top; }
                .jdebug-array>tbody>tr>td:nth-child(1) { background-color: #CFC; cursor: pointer; }
                .jdebug-array>tbody>tr>td:nth-child(2) { font-size: .75em; }
                .jdebug-array>tbody>tr>td:nth-child(3) { max-width: 500px; }

                .jdebug-object { border-collapse: collapse;
                    border: 1px solid #000; border-radius: 4px; }
                .jdebug-object>thead>tr>th { background-color: #090; color: #0000A2;
                    background: #DDD; padding: 3px 5px; cursor: pointer; }
                .jdebug-object>tbody>tr>td { background-color: #fff; padding: 5px; }
                .jdebug-link { color: #0000A2; font-weight: bold; margin-bottom: 5px;
                    display:block }

                .jdebug-method-name { color: #9D6F38; }
                .jdebug-method-type { font-weight: bold; }
                .jdebug-container {
                    padding: 10px;
                    margin-bottom: 5px;
                    font-size: 13px;
                    line-height: 1.5;
                    color: #333;
                    word-break: break-all;
                    word-wrap: break-word;
                    white-space: pre;
                    background-color: #F5F5F5;
                    border: 1px solid #CCC;
                    border-radius: 4px;
                    font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
                }
            </style>';
    }
}

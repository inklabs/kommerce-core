<?php
namespace inklabs\kommerce\Lib;

class XMLSerializer
{
    /**
     * @param mixed $object
     * @return string
     */
    public function getXml($object)
    {
        $xml = '<?xml encoding="UTF-8" ?>';
        $xml .= $this->getXmlFromMixed($object);

        return $xml;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function getXmlFromMixed($object)
    {
        $xml = '';
        if (is_object($object)) {
            $xml .= $this->getXmlFromObject($object);
        } else {
            $xml .= $object;
        }

        return $xml;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function getXmlFromObject($object)
    {
        $xml = '';

        $entity = new \ReflectionClass($object);
        $entityName = $entity->getShortName();
        $xml .= '<' . $entityName . '>';
        $xml .= $this->getXmlFromObjectVarsByProperties($object);
        $xml .= '</' . $entityName . '>';

        return $xml;
    }

    /**
     * @param mixed $object
     * @return string
     */
    private function getXmlFromObjectVarsByProperties($object)
    {
        $entity = new \ReflectionClass($object);
        $properties = $entity->getProperties();

        $xml = '';
        foreach ($properties as $property) {
            $name = $property->getName();

            $getter = 'get' . ucfirst($name);
            $value = $object->$getter();

            $xml .= '<' . $name . '>';
            $xml .= $this->getXmlFromMixed($value);
            $xml .= '</' . $name . '>';
        }

        return $xml;
    }
//    /**
//     * @param mixed $object
//     * @return string
//     */
//    private function getXmlFromObjectVarsByMethods($object)
//    {
//        $entity = new \ReflectionClass($object);
//        $methods = $entity->getMethods(\ReflectionMethod::IS_PUBLIC);
//
//        $xml = '';
//        foreach ($methods as $method) {
//            if (strpos($method->name, 'get') === false) {
//                continue;
//            }
//
//            $name = $method->name;
//            $value = $method->invoke($object);
//
//            $xml .= '<' . $name . '>';
//            $xml .= $this->getXmlFromMixed($value);
//            $xml .= '</' . $name . '>';
//        }
//
//        return $xml;
//    }
}

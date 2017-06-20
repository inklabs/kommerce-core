<?php
namespace inklabs\kommerce\Lib;

class XMLSerializer
{
    /**
     * @param mixed $object
     * @return string
     */
    public function getXml($object): string
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= $this->getXmlFromMixed($object);

        return $xml;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function getXmlFromMixed($object): string
    {
        $xml = '';
        if (is_object($object)) {
            $xml .= $this->getXmlFromObject($object);
        } elseif (is_array($object)) {
            $xml .= $this->getXmlFromArray($object);
        } else {
            $xml .= $object;
        }

        return $xml;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function getXmlFromObject($object): string
    {
        $xml = '';

        $entity = new \ReflectionClass($object);
        $entityName = $entity->getShortName();
        $xml .= '<' . $entityName . '>';
        $xml .= $this->getXmlFromObjectVarsByPublicProperties($object);
        $xml .= '</' . $entityName . '>';

        return $xml;
    }

    /**
     * @param array $object
     * @return string
     */
    public function getXmlFromArray(array $object): string
    {
        $xml = '';

        foreach ($object as $item) {
            $xml .= $this->getXmlFromMixed($item);
        }

        return $xml;
    }


    /**
     * @param mixed $object
     * @return string
     */
    private function getXmlFromObjectVarsByPublicProperties($object): string
    {
        $properties = get_object_vars($object);

        $xml = '';
        foreach ($properties as $name => $value) {
            $xml .= '<' . $name . '>';
            $xml .= $this->getXmlFromMixed($value);
            $xml .= '</' . $name . '>';
        }

        return $xml;
    }
}

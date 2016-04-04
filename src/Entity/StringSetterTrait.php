<?php
namespace inklabs\kommerce\Entity;

trait StringSetterTrait
{
    /**
     * @param string $destinationValue
     * @param string $value
     */
    private function setStringOrNull(& $destinationValue, $value)
    {
        if (trim($value) === '') {
            $destinationValue = null;
        } else {
            $destinationValue = (string) $value;
        }
    }
}

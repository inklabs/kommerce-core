<?php
namespace inklabs\kommerce\Entity;

trait StringSetterTrait
{
    private function setStringOrNull(?string & $destinationValue, ?string $value)
    {
        if (trim($value) === '') {
            $destinationValue = null;
        } else {
            $destinationValue = $value;
        }
    }
}

<?php
namespace inklabs\kommerce\Entity;

abstract class Payment
{
    abstract public function __construct($amount);
}

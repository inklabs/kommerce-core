<?php
namespace inklabs\kommerce\EntityDTO;

class ConfigurationDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $key;

    /** @var string */
    public $name;

    /** @var string */
    public $value;
}

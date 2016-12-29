<?php
namespace inklabs\kommerce\EntityDTO;

abstract class AbstractIntegerTypeDTO
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $slug;

    /** @var string[] */
    public $nameMap;
}

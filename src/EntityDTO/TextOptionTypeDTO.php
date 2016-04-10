<?php
namespace inklabs\kommerce\EntityDTO;

class TextOptionTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isText;

    /** @var bool */
    public $isTextarea;

    /** @var bool */
    public $isFile;

    /** @var bool */
    public $isDate;

    /** @var bool */
    public $isTime;

    /** @var bool */
    public $isDateTime;
}

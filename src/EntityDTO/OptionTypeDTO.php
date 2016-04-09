<?php
namespace inklabs\kommerce\EntityDTO;

class OptionTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isSelect;

    /** @var bool */
    public $isRadio;

    /** @var bool */
    public $isCheckbox;
}

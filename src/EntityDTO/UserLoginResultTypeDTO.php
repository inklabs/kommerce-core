<?php
namespace inklabs\kommerce\EntityDTO;

class UserLoginResultTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isFail;

    /** @var bool */
    public $isSuccess;
}

<?php
namespace inklabs\kommerce\EntityDTO;

class UserTokenTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isInternal;

    /** @var bool */
    public $isGoogle;

    /** @var bool */
    public $isFacebook;

    /** @var bool */
    public $isTwitter;

    /** @var bool */
    public $isYahoo;
}

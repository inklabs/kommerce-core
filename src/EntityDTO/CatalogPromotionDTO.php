<?php
namespace inklabs\kommerce\EntityDTO;

class CatalogPromotionDTO extends AbstractPromotionDTO
{
    /**
     * @var string
     * @deprecated
     */
    public $code;

    /** @var TagDTO */
    public $tag;
}

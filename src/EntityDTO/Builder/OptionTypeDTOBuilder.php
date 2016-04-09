<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;
use inklabs\kommerce\EntityDTO\OptionTypeDTO;

/**
 * @method OptionTypeDTO build()
 */
class OptionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var OptionType */
    protected $type;

    /** @var OptionTypeDTO */
    protected $typeDTO;

    /**
     * @return AbstractIntegerTypeDTO
     */
    protected function getTypeDTO()
    {
        return new OptionTypeDTO;
    }

    public function __construct(OptionType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isSelect = $this->type->isSelect();
        $this->typeDTO->isRadio = $this->type->isRadio();
        $this->typeDTO->isCheckbox = $this->type->isCheckbox();
    }
}

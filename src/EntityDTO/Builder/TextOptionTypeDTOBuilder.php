<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TextOptionType;
use inklabs\kommerce\EntityDTO\TextOptionTypeDTO;

/**
 * @method TextOptionTypeDTO build()
 */
class TextOptionTypeDTOBuilder extends AbstractIntegerTypeDTOBuilder
{
    /** @var TextOptionType */
    protected $type;

    /** @var TextOptionTypeDTO */
    protected $typeDTO;

    protected function getTypeDTO()
    {
        return new TextOptionTypeDTO;
    }

    public function __construct(TextOptionType $type)
    {
        parent::__construct($type);

        $this->typeDTO->isText     = $this->type->isText();
        $this->typeDTO->isTextarea = $this->type->isTextarea();
        $this->typeDTO->isFile     = $this->type->isFile();
        $this->typeDTO->isDate     = $this->type->isDate();
        $this->typeDTO->isTime     = $this->type->isTime();
        $this->typeDTO->isDateTime = $this->type->isDateTime();
    }
}

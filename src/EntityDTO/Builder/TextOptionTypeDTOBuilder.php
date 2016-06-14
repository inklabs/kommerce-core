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
    protected $entity;

    /** @var TextOptionTypeDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new TextOptionTypeDTO;
    }

    public function __construct(TextOptionType $type)
    {
        parent::__construct($type);

        $this->entityDTO->isText     = $this->entity->isText();
        $this->entityDTO->isTextarea = $this->entity->isTextarea();
        $this->entityDTO->isFile     = $this->entity->isFile();
        $this->entityDTO->isDate     = $this->entity->isDate();
        $this->entityDTO->isTime     = $this->entity->isTime();
        $this->entityDTO->isDateTime = $this->entity->isDateTime();
    }
}

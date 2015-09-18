<?php
namespace inklabs\kommerce\EntityDTO\Builder;

interface DTOBuilderInterface
{
    public function build();

    /**
     * @return DTOBuilderInterface
     */
    public function withAllData();
}

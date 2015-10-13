<?php
namespace inklabs\kommerce\Lib\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $request);
}

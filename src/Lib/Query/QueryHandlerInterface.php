<?php
namespace inklabs\kommerce\Lib\Query;

interface QueryHandlerInterface
{
    /**
     * @param QueryInterface $query
     * @return void
     */
    public function handle(QueryInterface $query);
}

<?php
namespace inklabs\kommerce\Lib\Query;

interface QueryHandlerInterface
{
    /**
     * @param QueryInterface $request
     * @return mixed
     */
    public function handle(QueryInterface $request);
}

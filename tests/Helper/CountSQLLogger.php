<?php
namespace inklabs\kommerce\tests\Helper;

use Doctrine\DBAL\Logging\SQLLogger;

/**
 * A SQL logger that counts the total number of queries.
 */
class CountSQLLogger implements SQLLogger
{
    /* @var int */
    protected $totalQueries;

    public function getTotalQueries()
    {
        return $this->totalQueries;
    }

    public function __construct()
    {
        $this->totalQueries = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        //echo $sql . PHP_EOL;
        $this->totalQueries++;
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
    }
}

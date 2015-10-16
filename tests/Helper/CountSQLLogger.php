<?php
namespace inklabs\kommerce\tests\Helper;

use Doctrine\DBAL\Logging\SQLLogger;

/**
 * A SQL logger that counts the total number of queries.
 */
class CountSQLLogger implements SQLLogger
{
    /** @var int */
    protected $totalQueries;

    /** @var bool */
    private $enableDisplay;

    public function getTotalQueries()
    {
        return $this->totalQueries;
    }

    public function __construct($enableDisplay = false)
    {
        $this->totalQueries = 0;
        $this->enableDisplay = $enableDisplay;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if ($this->enableDisplay) {
            $this->displaySql($sql, $params);
        }

        $this->totalQueries++;
    }

    private function displaySql($sql, $params = null)
    {
        $values = '';
        if (is_array($params)) {
            $values = json_encode(array_values($params));
        }

        echo $sql . ' ' . $values . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
    }
}

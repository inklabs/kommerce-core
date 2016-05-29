<?php
namespace inklabs\kommerce\tests\Helper;

use Doctrine\DBAL\Logging\SQLLogger;
use Ramsey\Uuid\Uuid;

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
            $values = json_encode($this->getSafeParamValues($params));
        }

        echo $sql . ' ' . $values . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
    }

    /**
     * @param $params
     * @return array
     */
    private function getSafeParamValues($params)
    {
        $safeValues = [];
        foreach (array_values($params) as $value) {
            if (is_array($value)) {
                $safeValues[] = $this->getSafeParamValues($value);
            } else {
                if ($this->isBinary($value)) {
                    $value = Uuid::fromBytes($value)->toString();
                }
                $safeValues[] = $value;
            }
        }
        return $safeValues;
    }

    private function isBinary($value)
    {
        return is_string($value) && preg_match('~[^\x20-\x7E\t\r\n]~', $value) > 0;
    }
}

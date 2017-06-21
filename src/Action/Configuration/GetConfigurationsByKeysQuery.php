<?php
namespace inklabs\kommerce\Action\Configuration;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetConfigurationsByKeysQuery implements QueryInterface
{
    /** @var string[] */
    private $keys;

    /**
     * @param string[] $keys
     */
    public function __construct(array $keys)
    {
        $this->keys = [];
        foreach ($keys as $key) {
            $this->addKey($key);
        }
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    private function addKey(string $key): void
    {
        $this->keys[] = $key;
    }
}

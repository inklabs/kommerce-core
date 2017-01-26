<?php
namespace inklabs\kommerce\Action\Configuration\Query;

final class GetConfigurationsByKeysRequest
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
            $this->keys[] = (string) $key;
        }
    }

    /**
     * @return string[]
     */
    public function getKeys()
    {
        return $this->keys;
    }
}

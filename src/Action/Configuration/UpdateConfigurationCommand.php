<?php
namespace inklabs\kommerce\Action\Configuration;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class UpdateConfigurationCommand implements CommandInterface
{
    /** @var string */
    private $key;

    /** @var string */
    private $value;

    /**
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}

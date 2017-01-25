<?php
namespace inklabs\kommerce\Action\Configuration;

use inklabs\kommerce\Lib\Command\CommandInterface;

class UpdateConfigurationCommand implements CommandInterface
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
}

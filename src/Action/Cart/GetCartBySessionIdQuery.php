<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetCartBySessionIdQuery implements QueryInterface
{
    /** @var string */
    private $sessionId;

    /**
     * @param string $sessionId
     */
    public function __construct($sessionId)
    {
        $this->sessionId = (string) $sessionId;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }
}

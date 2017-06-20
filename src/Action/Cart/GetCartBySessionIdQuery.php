<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetCartBySessionIdQuery implements QueryInterface
{
    /** @var string */
    private $sessionId;

    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }
}

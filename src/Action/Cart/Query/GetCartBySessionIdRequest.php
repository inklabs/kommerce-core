<?php
namespace inklabs\kommerce\Action\Cart\Query;

final class GetCartBySessionIdRequest
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

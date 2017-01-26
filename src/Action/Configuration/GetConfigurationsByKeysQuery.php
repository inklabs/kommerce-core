<?php
namespace inklabs\kommerce\Action\Configuration;

use inklabs\kommerce\Action\Configuration\Query\GetConfigurationsByKeysRequest;
use inklabs\kommerce\Action\Configuration\Query\GetConfigurationsByKeysResponseInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetConfigurationsByKeysQuery implements QueryInterface
{
    /** @var GetConfigurationsByKeysRequest */
    private $request;

    /** @var GetConfigurationsByKeysResponseInterface */
    private $response;

    public function __construct(
        GetConfigurationsByKeysRequest $request,
        GetConfigurationsByKeysResponseInterface & $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return GetConfigurationsByKeysRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return GetConfigurationsByKeysResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}

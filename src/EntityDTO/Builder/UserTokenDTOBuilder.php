<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityDTO\UserTokenDTO;
use inklabs\kommerce\Lib\BaseConvert;

class UserTokenDTOBuilder
{
    /** @var UserToken */
    protected $userToken;

    /** @var UserTokenDTO */
    protected $userTokenDTO;

    public function __construct(UserToken $userToken)
    {
        $this->userToken = $userToken;

        $this->userTokenDTO = new UserTokenDTO;
        $this->userTokenDTO->id        = $this->userToken->getId();
        $this->userTokenDTO->encodedId = BaseConvert::encode($this->userToken->getId());
        $this->userTokenDTO->userAgent = $this->userToken->getUserAgent();
        $this->userTokenDTO->token     = $this->userToken->getToken();
        $this->userTokenDTO->expires   = $this->userToken->getExpires();
        $this->userTokenDTO->type      = $this->userToken->getType();
        $this->userTokenDTO->created   = $this->userToken->getCreated();
        $this->userTokenDTO->updated   = $this->userToken->getUpdated();
    }

    public function withUser()
    {
        $user = $this->userToken->getUser();
        if ($user !== null) {
            $this->userTokenDTO->user = $user->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser();
    }

    public function build()
    {
        return $this->userTokenDTO;
    }
}

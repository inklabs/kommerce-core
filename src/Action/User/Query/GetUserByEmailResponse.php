<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

class GetUserByEmailResponse implements GetUserByEmailResponseInterface
{
    /** @var UserDTOBuilder */
    private $productDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $productDTOBuilder)
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getUserDTO()
    {
        return $this->productDTOBuilder
            ->build();
    }
}

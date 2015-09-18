<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityDTO\UserLoginDTO;

class UserLoginDTOBuilder extends AbstractDTOBuilder
{
    /** @var UserLogin */
    protected $entity;

    /** @var UserLoginDTO */
    protected $entityDTO;

    public function __construct(UserLogin $userLogin)
    {
        $this->entity = $userLogin;

        $this->entityDTO = new UserLoginDTO;
        $this->entityDTO->email      = $userLogin->getEmail();
        $this->entityDTO->ip4        = $userLogin->getIp4();
        $this->entityDTO->result     = $userLogin->getResult();
        $this->entityDTO->resultText = $userLogin->getResultText();

        $this->setId();
        $this->setCreated();
    }

    public function withUser()
    {
        $user = $this->entity->getUser();
        if ($user !== null) {
            $this->entityDTO->user = $user->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser();
    }
}

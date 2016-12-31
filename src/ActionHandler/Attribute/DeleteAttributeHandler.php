<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\DeleteAttributeCommand;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

final class DeleteAttributeHandler
{
    /** @var AttributeRepositoryInterface */
    protected $couponRepository;

    public function __construct(AttributeRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function handle(DeleteAttributeCommand $command)
    {
        $coupon = $this->couponRepository->findOneById($command->getAttributeId());
        $this->couponRepository->delete($coupon);
    }
}

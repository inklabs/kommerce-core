<?php
namespace inklabs\kommerce\Service\Import;

use DateTime;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Service\EntityValidationTrait;
use Iterator;

class ImportOrderService implements ImportOrderServiceInterface
{
    use EntityValidationTrait;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function import(Iterator $iterator): ImportResult
    {
        $importResult = new ImportResult;
        foreach ($iterator as $key => $row) {
            if ($key < 2 && $row[0] === 'order_ref') {
                continue;
            }

            $externalId = $row[0];
            $date = $row[1];
            $userExternalId = $row[2];
            $subtotal = $this->convertDollarToCents($row[3]);
            $tax = $this->convertDollarToCents($row[4]);
            $total = $this->convertDollarToCents($row[5]);

            $cartTotal = new CartTotal;
            $cartTotal->subtotal = $subtotal;
            $cartTotal->tax = $tax;
            $cartTotal->total = $total;

            $order = new Order();
            $order->setIp4('0.0.0.0');
            $order->setExternalId($externalId);
            $order->setTotal($cartTotal);
            $order->setCreated(new DateTime($date));

            if ($userExternalId !== null) {
                $user = $this->userRepository->findOneByExternalId($userExternalId);
                if ($user !== null) {
                    $order->setUser($user);
                }
            }

            try {
                $this->orderRepository->create($order);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        return $importResult;
    }

    private function convertDollarToCents(float $dollarValue): int
    {
        return (int) round($dollarValue * 100);
    }
}

<?php
namespace inklabs\kommerce\Service\Import;

use DateTime;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Exception\Kommerce400Exception;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Service\EntityValidationTrait;
use Iterator;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class ImportOrderService
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

    /**
     * @param Iterator $iterator
     * @return ImportResult
     */
    public function import(Iterator $iterator)
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

            $order = new Order;
            $order->setIp4(null);
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
                $this->throwValidationErrors($order);

                $this->orderRepository->create($order);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        return $importResult;
    }

    /**
     * @param float $dollarValue
     * @return int
     */
    private function convertDollarToCents($dollarValue)
    {
        return (int) round($dollarValue * 100);
    }
}

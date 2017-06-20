<?php
namespace inklabs\kommerce\Service\Import;

use DateTime;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\PaymentRepositoryInterface;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Service\EntityValidationTrait;
use Iterator;

class ImportPaymentService implements ImportPaymentServiceInterface
{
    use EntityValidationTrait;

    /** @var PaymentRepositoryInterface */
    private $paymentRepository;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        PaymentRepositoryInterface $paymentRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function import(Iterator $iterator): ImportResult
    {
        $importResult = new ImportResult;
        foreach ($iterator as $key => $row) {
            if ($key < 2 && $row[0] === 'order_ref') {
                continue;
            }

            $orderExternalId = $row[0];
            $invoiceExternalId = $row[1];
            $amount = $this->convertDollarToCents($row[2]);
            $checkNumber = $row[3];
            $date = $row[4];

            $order = $this->orderRepository->findOneByExternalId($orderExternalId);

            try {
                if (! empty($checkNumber)) {
                    $payment = new CheckPayment($amount, $checkNumber, new DateTime($date));
                } else {
                    $payment = new CashPayment($amount);
                }

                $payment->setCreated(new DateTime($date));
                $payment->setOrder($order);

                $this->paymentRepository->persist($payment);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        $this->paymentRepository->flush();

        return $importResult;
    }

    private function convertDollarToCents(float $dollarValue): int
    {
        return (int) round($dollarValue * 100);
    }
}

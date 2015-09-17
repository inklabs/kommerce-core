<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\Payment\PaymentRepositoryInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class Payment
{
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

    /**
     * @param \Iterator $iterator
     * @return ImportResult
     */
    public function import(\Iterator $iterator)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

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

            $order = $this->orderRepository->findOneBy(['externalId' => $orderExternalId]);

            try {
                // TODO: Handle checkNumber
                $payment = new Entity\Payment\Cash($amount);
                $payment->setCreated(new \DateTime($date));
                $payment->setOrder($order);

                $errors = $validator->validate($payment);
                if ($errors->count() > 0) {
                    throw new ValidatorException('Invalid Payment ' . $errors);
                }

                $this->paymentRepository->persist($payment);
                $importResult->incrementSuccess();
            } catch (\Exception $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        $this->paymentRepository->flush();

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

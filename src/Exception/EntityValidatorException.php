<?php
namespace inklabs\kommerce\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class EntityValidatorException extends Kommerce400Exception
{
    /** @var ConstraintViolationListInterface */
    private $errors;

    public function __construct(
        string $message,
        int $code = 400,
        Exception $previous = null,
        ConstraintViolationList $errors = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @param string $message
     * @param ConstraintViolationList $errors
     * @return static
     */
    public static function withErrors(string $message, ConstraintViolationList $errors)
    {
        return new self($message, 400, null, $errors);
    }

    /**
     * @return ConstraintViolationListInterface|ConstraintViolationInterface[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}

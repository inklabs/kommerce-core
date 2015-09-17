<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class User
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
            if ($key < 2 && $row[0] === 'id') {
                continue;
            }

            $externalId = $this->extractNull($row[0]);
            $name = $this->extractNull($row[1]);
            $address = $this->extractNull($row[2]);
            $zip5 = $this->extractNull($row[3]);
            $city = $this->extractNull($row[4]);
            $phone = $this->extractNull($row[5]);
            $fax = $this->extractNull($row[6]);
            $url = $this->extractNull($row[7]);
            $email = $this->extractNull($row[8]);

            $firstName = $this->parseFirstName($name);
            $lastName = $this->parseLastName($name);

            $user = new Entity\User;
            $user->setExternalId($externalId);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            if (! empty($email)) {
                $user->setEmail($email);
            }

            try {
                $errors = $validator->validate($user);
                if ($errors->count() > 0) {
                    throw new ValidatorException('Invalid User' . $errors);
                }

                $this->userRepository->create($user);
                $importResult->incrementSuccess();
            } catch (\Exception $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        return $importResult;
    }

    /**
     * @param string $variable
     * @return string
     */
    private function extractNull($variable)
    {
        if ($variable === 'NULL') {
            $variable = null;
        }
        return $variable;
    }

    /**
     * @param string $name
     * @return string
     */
    private function parseFirstName($name)
    {
        $firstName = '';

        $namePieces = explode(' ', $name);
        if (! empty($namePieces)) {
            $firstName = $namePieces[0];
        }

        return $firstName;
    }

    /**
     * @param string $name
     * @return string
     */
    private function parseLastName($name)
    {
        $lastName = '';

        $namePieces = explode(' ', $name);
        if (count($namePieces) > 1) {
            array_shift($namePieces);
            $lastName = implode(' ', $namePieces);
        }

        return $lastName;
    }
}

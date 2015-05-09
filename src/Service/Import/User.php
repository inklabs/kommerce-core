<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class User
{
    /** @var EntityRepository\UserInterface */
    private $userRepository;

    public function __construct(EntityRepository\UserInterface $userRepository)
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

            $externalId = $row[0];
            $name = $row[1];
            $address = $row[2];
            $zip5 = $row[3];
            $city = $row[4];
            $phone = $row[5];
            $fax = $row[6];
            $url = $row[7];
            $email = $row[8];

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
                    throw new ValidatorException('Invalid Order Item' . $errors);
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

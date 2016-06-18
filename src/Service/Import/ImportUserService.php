<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Exception\KommerceException;
use inklabs\kommerce\Service\EntityValidationTrait;
use Iterator;

class ImportUserService implements ImportUserServiceInterface
{
    use EntityValidationTrait;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
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

            $user = new User;
            $user->setExternalId($externalId);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            if (! empty($email)) {
                $user->setEmail($email);
            }

            try {
                $this->throwValidationErrors($user);

                $this->userRepository->create($user);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
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

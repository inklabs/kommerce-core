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

    public function import(Iterator $iterator): ImportResult
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
                $this->userRepository->create($user);
                $importResult->incrementSuccess();
            } catch (KommerceException $e) {
                $importResult->addFailedRow($row);
                $importResult->addErrorMessage($e->getMessage());
            }
        }

        return $importResult;
    }

    private function extractNull(string $variable): ?string
    {
        if ($variable === 'NULL') {
            $variable = null;
        }
        return $variable;
    }

    private function parseFirstName(string $name): string
    {
        $firstName = '';

        $namePieces = explode(' ', $name);
        if (! empty($namePieces)) {
            $firstName = $namePieces[0];
        }

        return $firstName;
    }

    private function parseLastName(string $name): string
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

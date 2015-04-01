<?php
namespace inklabs\kommerce\Service\Import;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Lib as Lib;

class User extends Lib\ServiceManager
{
    /** @var EntityRepository\User */
    private $userRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->userRepository = $entityManager->getRepository('kommerce:User');
    }

    /**
     * @param \Iterator $iterator
     * @return int
     */
    public function import(\Iterator $iterator)
    {
        $importedCount = 0;
        foreach ($iterator as $key => $row) {
            if ($key < 2 && $row[0] === 'id') {
                continue;
            }

            $id = $row[0];
            $name = $row[1];
            $address = $row[2];
            $zip5 = $row[3];
            $city = $row[4];
            $phone = $row[5];
            $fax = $row[6];
            $url = $row[7];
            $email = $row[8];

            $user = new Entity\User;

            $namePieces = explode(' ', $name);
            if (isset($namePieces[0])) {
                $user->setFirstName($namePieces[0]);
            }
            if (isset($namePieces[1])) {
                $user->setLastName($namePieces[1]);
            }

            if (!empty($email)) {
                $user->setEmail($email);
            }

            $this->entityManager->persist($user);
            $importedCount++;
        }

        $this->entityManager->flush();

        return $importedCount;
    }
}

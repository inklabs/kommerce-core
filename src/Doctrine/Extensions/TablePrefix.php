<?php
namespace inklabs\kommerce\Doctrine\Extensions;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefix implements EventSubscriber
{
    protected $prefix = '';

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();

        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            return;
        }

        if (false !== strpos($classMetadata->namespace, 'Entity')) {
            $classMetadata->setPrimaryTable(['name' => $this->prefix . $classMetadata->getTableName()]);

            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
                if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY
                    && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name'])
                ) {
                    $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] =
                        $this->prefix . $mappedTableName;
                }
            }
        }
    }
}

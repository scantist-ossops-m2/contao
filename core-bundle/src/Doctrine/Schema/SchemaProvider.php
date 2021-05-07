<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao\CoreBundle\Doctrine\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;

class SchemaProvider
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Creates a schema from entity metadata.
     */
    public function createSchema(): Schema
    {
        $schemaTool = new SchemaTool($this->entityManager);

        /** @var array<ClassMetadata> $metadata */
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        // Triggers the contao.listener.doctrine_schema listener that appends the DCA definitions
        return $schemaTool->getSchemaFromMetadata($metadata);
    }
}

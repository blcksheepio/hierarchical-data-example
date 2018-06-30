<?php

namespace App\Manager;

use GraphAware\Neo4j\OGM\EntityManagerInterface;

/**
 * Class OrganizationManager
 *
 * @author blcksheep
 */
class OrganizationManager
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * OrganizationManager constructor.
     * @param string $class
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(string $class, EntityManagerInterface $entityManager)
    {
        $this->class = $class;
        $this->entityManager = $entityManager;
    }

    public function new()
    {
        return new $this->class;
    }

    public function persistMultiple($collection = [])
    {
        if ($collection) {
            $total = count($collection);
            for ($i = 0; $i < $total; $i++) {

            }
        }
    }

    public function truncate()
    {
        $this->manager->createQuery('MATCH(n) DETACH DELETE n')->execute();
    }
}

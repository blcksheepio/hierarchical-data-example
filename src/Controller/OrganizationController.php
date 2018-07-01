<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrganizationController
 *
 * @author blcksheep
 *
 * @Route("/organization")
 */
class OrganizationController extends FOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * OrganizationController constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}

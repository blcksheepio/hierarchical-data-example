<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @Route("/organization", name="organization")
     */
    public function index()
    {

        $true = 1;

        $view = $this->view([], 200);

        return $this->handleView($view);
    }

    public function post()
    {

    }
}

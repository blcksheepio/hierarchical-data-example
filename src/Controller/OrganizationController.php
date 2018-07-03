<?php

namespace App\Controller;

use App\Entity\Organization;
use FOS\RestBundle\Controller\FOSRestController;
use GraphAware\Neo4j\OGM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Class OrganizationController
 *
 * @author blcksheep
 *
 * @Rest\Route("/organization")
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

    /**
     * Retrieves a single Organization entity.
     *
     * @Rest\Get(
     *     "/{id}",
     *     name="get_organization",
     *     requirements={"id"="\d+"}
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Returns if request is successful",
     *     @Model(type=Organization::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_NOT_FOUND,
     *     description="Returned if a matching organization cannot be found"
     * )
     */
    public function getAction($id)
    {
        $view = $this->view([], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Retrieves a single entity's relations,
     *
     * @Rest\Get(
     *     "/{org_name}/relations",
     *     name="get_organization_relations",
     *     requirements={"org_name"="\w+"}
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Returns if request is successful"
     * )
     * @SWG\Response(
     *     response=Response::HTTP_NOT_FOUND,
     *     description="Returned if a matching organization with relations cannot be found"
     * )
     * @SWG\Parameter(
     *     name="org_name",
     *     description="The name of the organization to search for",
     *     in="path",
     *     type="string",
     *     pattern="\w+",
     *     required=true,
     * )
     */
    public function getRelationsAction(Request $request)
    {
        $view = $this->view([], Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Stores a new Organization along with it's
     * hierarchy of parents, sisters and daughters.
     *
     * @Rest\Post(
     *     "",
     *     name="post_organization"
     * )
     * @SWG\Response(
     *     response=Response::HTTP_CREATED,
     *     description="Returns if request is successful"
     * )
     * @SWG\Response(
     *     response=Response::HTTP_UNPROCESSABLE_ENTITY,
     *     description="Validation failure"
     * )
     */
    public function postAction(Request $request)
    {
        $view = $this->view([], Response::HTTP_CREATED);

        return $this->handleView($view);
    }
}

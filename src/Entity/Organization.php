<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * Class Organization
 *
 * @author blcksheep
 */
class Organization
{
    /**
     * @var int
     *
     * @OGM\GraphId()
     */
    protected $id;

    /**
     * @var string
     *
     * @OGM\Property(type="string")
     */
    protected $name;

    /**
     * @var Organization[] | Collection
     */
    protected $parents;

    /**
     * @var Organization[] | Collection
     */
    protected $children;

    /**
     * @var Organization[] | Collection
     */
    protected $sisters;
}

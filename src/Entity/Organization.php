<?php

namespace App\Entity;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * Class Organization
 *
 * @author blcksheep
 *
 * @OGM\Node(label="Organization")
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
     * @OGM\Relationship(
     *     type="PARENT",
     *     direction="INCOMING",
     *     collection=true,
     *     mappedBy="daughters",
     *     targetEntity="Organization"
     * )
     */
    protected $parents;

    /**
     * @var Organization[] | Collection
     * @OGM\Relationship(
     *     type="DAUGHTER",
     *     direction="INCOMING",
     *     collection=true,
     *     mappedBy="parents",
     *     targetEntity="Organization"
     * )
     */
    protected $daughters;

    /**
     * @var Organization[] | Collection
     * @OGM\Relationship(
     *     type="SISTER",
     *     direction="BOTH",
     *     collection=true,
     *     mappedBy="sisters",
     *     targetEntity="Organization"
     * )
     */
    protected $sisters;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Organization
     */
    public function setName(string $name): Organization
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Organization[]|Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param Organization[]|Collection $parents
     * @return Organization
     */
    public function setParents($parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @return Organization[]|Collection
     */
    public function getDaughters()
    {
        return $this->daughters;
    }

    /**
     * @param Organization[]|Collection $daughters
     * @return Organization
     */
    public function setDaughters($daughters)
    {
        $this->daughters = $daughters;

        return $this;
    }

    /**
     * @return Organization[]|Collection
     */
    public function getSisters()
    {
        return $this->sisters;
    }

    /**
     * @param Organization[]|Collection $sisters
     * @return Organization
     */
    public function setSisters($sisters)
    {
        $this->sisters = $sisters;

        return $this;
    }
}

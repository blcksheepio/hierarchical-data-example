<?php

namespace App\Command;

use GraphAware\Neo4j\OGM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class AppNeo4jTruncateCommand
 *
 * @author blcksheep
 */
class AppNeo4jTruncateCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:neo4j:truncate';

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     * @param EntityManager $manager
     *
     * @throws LogicException When the command name is empty
     */
    public function __construct(?string $name = null, EntityManager $manager)
    {
        parent::__construct($name);

        $this->manager = $manager;
    }

    /**
     * Configures the Symfony command.
     *
     * Currently sets only the command description.
     */
    protected function configure()
    {
        $this->setDescription('Simulates the complete truncation of the existing database.');
    }

    /**
     * Executes the Symfony command.
     *
     * Neo4j recommends not simply executing "MATCH (n) DETACH DELETE n" due to performance reasons.
     * The two recommended approaches are:
     *
     *  - Deleting the database and restarting the service. This will perform a "true" truncate
     *    and reset all internal ids. Unfortuantely of course, this also results in ALL data being lost.
     *  - Batch deleting until the total number of records is 0.
     *
     * TODO: Investigate the possibility of optimizing this further.
     *
     * @see https://neo4j.com/developer/kb/large-delete-transaction-best-practices-in-neo4j/
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->deleteItems();
        $io->success('Neo4J database successfully truncated!');
    }

    protected function deleteItems()
    {
        $query = $this->manager->createQuery("MATCH (o:Organization) WITH o LIMIT 1000 DETACH DELETE o RETURN count(*) AS total;");
        $response = $query->execute();

        if (is_array($response) && is_array($response[0]) && array_key_exists('total', $response[0]) && ($response[0]['total'])) {
            $this->deleteItems($response);
        }
    }
}

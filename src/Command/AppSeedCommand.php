<?php

namespace App\Command;

use App\Entity\Organization;
use GraphAware\Neo4j\OGM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppSeedCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:seed';

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * AppSeedCommand constructor.
     *
     * @param null|string $name
     * @param $manager
     */
    public function __construct(?string $name = null, $manager)
    {
        $this->manager = $manager;

        parent::__construct($name);
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setDescription('Seeds the Neo4J database with data')
            ->addOption('flush', null, InputOption::VALUE_OPTIONAL, 'Flush existing entities before-hand?', true)
            ->addOption('min', null, InputOption::VALUE_OPTIONAL, 'The minimum number of items allowed to add', 1)
            ->addOption('max', null, InputOption::VALUE_OPTIONAL, 'The maximum number of items allowed to add', 5);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $flush = $input->getOption('flush');

//        if ($flush) {
//            $this->manager->createQuery('MATCH(n) DETACH DELETE n')->execute();
//        }
//
//        $data = $this->manager->getClassMetadata(Organization::class)->getLabel();
//
//        $min = $input->getOption('min');
//        $max = $input->getOption('max');
//
//        $this->generateEntities($min, $max);
//
//        $this->manager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }

    /**
     * @param $min
     * @param $max
     * @param null $entity
     * @throws \Exception
     */
    private function generateEntities($min, $max, $entity = null)
    {
        $total = mt_rand($min, $max);

        for ($i = 0; $i < $total; $i++) {
            $organization = new Organization();
            $organization->setName('Organization '.$i);

            if ($entity) {
                $entity->setDaughters([$organization]);
                $this->manager->detach($entity);
                $this->manager->persist($entity);
            }
            $this->manager->persist($organization);
            $this->generateEntities($min, $max, $organization);
        }
    }
}

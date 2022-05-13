<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Port;

#[AsCommand(
    name: 'port:create',
    description: 'Create a harbort and insert it in db',
)]
class PortCreateCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('harborName', null, InputOption::VALUE_REQUIRED, 'Name of the Harbor')
            ->addOption('cityName', null, InputOption::VALUE_REQUIRED, 'Name of the city')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $harborName = $input->getOption('harborName');
        $cityName = $input->getOption('cityName');

        $io->writeln("Le nom du port est ".$harborName) ;
        $io->writeln("Il se situe dans la ville de ".$cityName);

        $harbor = new Port();
        $harbor->setName($harborName);
        $harbor->setCity($cityName);

        $this->entityManager->persist($harbor);
        $this->entityManager->flush();
        $io->success('A new harbort has been added ! ');

        return Command::SUCCESS;
    }
}

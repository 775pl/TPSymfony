<?php

namespace App\Command;

use App\Entity\Gate;
use App\Repository\GateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'gate:create',
    description: 'Create a gate and insert it in db',
)]
class GateCreateCommand extends Command
{
    private $entityManager;
    private $gateRepository;
    public function __construct(EntityManagerInterface $entityManager, GateRepository $gateRepository){
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->gateRepository = $gateRepository;
    }

    protected function configure(): void
    {
        $this
            ->addOption('number', null, InputOption::VALUE_REQUIRED, 'Number of the gate')
            ->addOption('fk_port', null, InputOption::VALUE_REQUIRED, 'Port de rattachement')
            ->addOption('port', null, InputOption::VALUE_REQUIRED, 'Port de rattachement')
            ->addOption('place', null, InputOption::VALUE_REQUIRED, 'Places rattachées')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $gateNumber = $input->getOption('number');
        $gatePort = $input->getOption('port');
        $fk_port = $input->getOption('fk_port');
        $gatePlace = $input->getOption('place');


        $gate = new Gate();
        $gate->setNumber($gateNumber);

        $gateRepository = $this->gateRepository;
        $a = $gateRepository->find($fk_port);
        $gate->setFkPortId($a);
        $b = $gateRepository->find($gatePort);
        $gate->setPort($b);
        $c = $gateRepository->find($gatePlace);
        $gate->setPlace($c);

        $this->entityManager->persist($gate);
        $this->entityManager->flush();
        $io->success('A new gate has been added ! ');

        return Command::SUCCESS;
    }
}

<?php

namespace App\Command;

use App\Repository\GateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'gate:edit',
    description: 'To edit a gate with his id',
)]
class GateEditCommand extends Command
{

    private $gateRepository;
    private $entityManager;

    public function __construct(GateRepository $gateRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->gateRepository = $gateRepository;
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this
            ->addOption('gateId', null, InputOption::VALUE_REQUIRED, 'id du port à modifier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $gateRepo = $this->gateRepository;

        $gateId = $input->getOption('gateId');
        $gate = $gateRepo->find($gateId);

        if($gate){
            $newNumber = $io->ask("New number :", $gate->getNumber());
            $gate->setNumber($newNumber);

            $newFk = $io->ask("New fk", $gate->getFkPortId());
            $gate->setFkPortId($newFk);

            $newPort = $io->ask("New port :", $gate->getPort());
            $gate->setPort($newPort);

            $newPlace = $io->ask("New place :", $gate->getPlace());
            $gate->setPlace($newPlace);

            $this->entityManager->flush();

        }else{
            $io->error("No gate");
        }

        $io->success('The gate has been successfully edited');
        return Command::SUCCESS;

    }
}

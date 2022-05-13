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
    name: 'gate:remove',
    description: 'To delete a gate with his id',
)]
class GateRemoveCommand extends Command
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
            ->addOption('gateId', null, InputOption::VALUE_REQUIRED, 'id du gate à modifier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $gateRepo = $this->gateRepository;

        $gateId = $input->getOption('gateId');
        $gate = $gateRepo->find($gateId);

        if($gate){
            $this->entityManager->remove($gate);

            $this->entityManager->flush();

        }else{
            $io->error("No gate");
        }

        $io->success('The gate has been successfully deleted.');
        return Command::SUCCESS;

    }
}

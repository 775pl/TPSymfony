<?php

namespace App\Command;

use App\Repository\PortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'port:edit',
    description: 'To edit a harbor with his id',
)]
class PortEditCommand extends Command
{

    private $harborRepository;
    private $entityManager;

    public function __construct(PortRepository $harborRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->harborRepository = $harborRepository;
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this
            ->addOption('harborId', null, InputOption::VALUE_REQUIRED, 'id du port à modifier')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $harborRepo = $this->harborRepository;

        $harborId = $input->getOption('harborId');
        $harbor = $harborRepo->find($harborId);

        if($harbor){
            $newName = $io->ask("New name :", $harbor->getName());
            $harbor->setName($newName);

            $newCity = $io->ask("New city", $harbor->getCity());
            $harbor->setCity($newCity);

            $this->entityManager->flush();

        }else{
            $io->error("No harbor");
        }

        $io->success('The port has been successfully edited');
        return Command::SUCCESS;

    }
}

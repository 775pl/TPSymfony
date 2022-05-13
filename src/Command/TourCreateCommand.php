<?php

namespace App\Command;

use App\Entity\Tour;
use App\Repository\TourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tour:create',
    description: 'Add a short description for your command',
)]
class TourCreateCommand extends Command
{
    private $entityManager;
    private $tourRepository;

    public function __construct(EntityManagerInterface $entityManager, TourRepository $tourRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->tourRepository = $tourRepository;
    }

    protected function configure(): void
    {
        $this
            ->addOption('mainEvent', null, InputOption::VALUE_REQUIRED, 'Mainvent of the Tours')
            ->addOption('capacity', null, InputOption::VALUE_REQUIRED, 'Capacity of the tours')
            ->addOption('price', null, InputOption::VALUE_REQUIRED, 'Price of the tours')
            ->addOption('startDate', null, InputOption::VALUE_REQUIRED, 'Start date of the tours')
            ->addOption('stopDate', null, InputOption::VALUE_REQUIRED, 'Stop date of the tours')
            ->addOption('company', null, InputOption::VALUE_REQUIRED, 'Company of the tours')
            ->addOption('stop', null, InputOption::VALUE_REQUIRED, 'Stop of the tours');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyMainEvent = $input->getOption('mainEvent');
        $companyCapacity = $input->getOption('capacity');
        $companyPrice = $input->getOption('price');
        $companyStartDate = $input->getOption('price'); //getdate();
        $companyStopDate = $input->getOption('price'); //getdate();
        $companyCompany = $input->getOption('company');
        $companyStop = $input->getOption('stop');

        $tour = new Tour();
        $tour->setMainEvent($companyMainEvent);
        $tour->setCapacity($companyCapacity);
        $tour->setPrice($companyPrice);
        $tour->setStartDate($companyStartDate);
        $tour->setStopDate($companyStopDate);

        $tourRepository = $this->tourRepository;


        $a = $tourRepository->find($companyCompany);
        $tour->setCompany($a);

        $b = $tourRepository->find($companyStop);
        $tour->setStop($b);

        $this->entityManager->persist($tour);
        $this->entityManager->flush();
        $io->success('A new Tour has been added ! ');

        return Command::SUCCESS;
    }
}
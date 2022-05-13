<?php

namespace App\Command;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'company:create',
    description: 'Add a short description for your command',
)]
class CompanyCreateCommand extends Command
{
    private $entityManager;
    private $companyRepository;
    public function __construct(EntityManagerInterface $entityManager, CompanyRepository $companyRepository){
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->companyRepository = $companyRepository;
    }

    protected function configure(): void
    {
        $this
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Name of the company')
            ->addOption('nationality', null, InputOption::VALUE_REQUIRED, 'Nationality of the company')
            ->addOption('tour', null, InputOption::VALUE_REQUIRED, 'Tours attached to the company')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $companyName = $input->getOption('name');
        $companyNationality = $input->getOption('nationality');
        $companyTour = $input->getOption('tour');

        $company = new Company();
        $company->setName($companyName);

        $company->setNationality($companyNationality);
        $companyRepository = $this->companyRepository;

        $b = $companyRepository->find($companyTour);
        $company->setTour($b);

        $this->entityManager->persist($company);
        $this->entityManager->flush();
        $io->success('A new company has been added ! ');

        return Command::SUCCESS;
    }
}
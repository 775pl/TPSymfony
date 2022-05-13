<?php

namespace App\Command;

use App\Repository\TourRepository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'tour:list',
    description: 'Display the tour s table',
)]
class TourListCommand extends Command
{

    private $tourRepository;

    public function __construct(TourRepository $tourRepository)
    {
        parent::__construct();
        $this->tourRepository = $tourRepository;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        #$io = new SymfonyStyle($input, $output);

        $tourRepository = $this->tourRepository;
        $tours = $tourRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['id', 'mainEvent', 'capacity', 'price', 'startDate', 'stopDate', 'company', 'stop']);

        // format('Y-m-d')?
        foreach ($tours as $tour){
            $table->addRow([$tour->getId(), $tour->getMainEvent(), $tour->getCapacity(), $tour->getPrice(), $tour->getStartDate(), $tour->getStopDate(), $tour->getCompany(), $tour->getStop()] );
        }
        $table->render();
        #$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

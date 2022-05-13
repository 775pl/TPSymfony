<?php

namespace App\Command;

use App\Entity\Port;
use App\Repository\PortRepository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'port:display',
    description: 'Display the harbor s table',
)]
class PortDisplayCommand extends Command
{

    private $harborRepository;

    public function __construct(PortRepository $harborRepository)
    {
        parent::__construct();
        $this->harborRepository = $harborRepository;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        #$io = new SymfonyStyle($input, $output);

        $harborRepository = $this->harborRepository;
        $harbors = $harborRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['id', 'name', 'city']);

        foreach ($harbors as $harbor){
            $table->addRow([$harbor->getId(), $harbor->getName(), $harbor->getCity()]);
        }
        $table->render();
        #$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

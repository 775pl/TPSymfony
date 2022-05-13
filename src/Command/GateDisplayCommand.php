<?php

namespace App\Command;

use App\Entity\Gate;
use App\Repository\GateRepository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'gate:display',
    description: 'Display the gate s table',
)]
class GateDisplayCommand extends Command
{

    private $gateRepository;

    public function __construct(GateRepository $gateRepository)
    {
        parent::__construct();
        $this->gateRepository = $gateRepository;
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        #$io = new SymfonyStyle($input, $output);

        $gateRepository = $this->gateRepository;
        $gates = $gateRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['id', 'fk_port_id_id', 'port_id', 'place_id', 'number']);

        foreach ($gates as $gate){
            $table->addRow([$gate->getId(), $gate->getFkPortId(), $gate->getPort(), $gate->getPlace(), $gate->getNumber()]);
        }
        $table->render();
        #$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

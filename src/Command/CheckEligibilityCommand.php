<?php

namespace App\Command;

use App\Entity\Flight;
use App\Repository\FlightRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckEligibilityCommand extends Command
{
    /**
     * @var FlightRepository
     */
    private $repository;

    /**
     * @var string
     */
    protected static $defaultName = 'check:csv';

    /**
     * CheckEligibilityCommand constructor.
     * @param FlightRepository $repository
     */
    public function __construct(FlightRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Checks if the flights are eligible for compensation')
            ->addArgument('flights csv file', InputArgument::REQUIRED);
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filepath = $input->getArgument('flights csv file');
        $flights = $this->repository->getAllFlights($filepath);

        foreach ($flights as $flight) {

            if ($this->check($flight) == 1) {
                $this->outputLine($output, $flight);

                $output->writeln('Y');
            }
            else {
                $this->outputLine($output, $flight);

                $output->writeln('N');
            }
        }
    }

    /**
     * @param OutputInterface $output
     * @param Flight $flight
     */
    private function outputLine(OutputInterface $output, Flight $flight)
    {
        $country = $flight->getCountry();
        $status = $flight->getStatus();
        $details = $flight->getDetails();

        $output->write($country .'|'. $status .'|'. $details .'|');
    }

    /**
     * @param Flight $flight
     * @return bool
     */
    public function check(Flight $flight)
    {
        if ($flight->getStatus() === 'Cancel' && $flight->getDetails() > 14) {
            return false;
        }

        if ($flight->getStatus() === 'Delay' && $flight->getDetails() < 3) {
            return false;
        }

        if ($flight->getCountry() === 'RU') {
            return false;
        }

        return true;
    }

}

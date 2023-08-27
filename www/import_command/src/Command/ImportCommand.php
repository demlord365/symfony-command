<?php

namespace App\Command;

use App\Database\DatabaseClientInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use App\Database\DatabaseClientFactory;

class ImportCommand extends Command
{
    protected static $defaultName = 'import';


    protected function configure()
    {
        $this
            ->setDescription('Import data from a file to a specified database')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the CSV file')
            ->addOption('to', null, InputOption::VALUE_REQUIRED, 'Target database (redis, postgres, mysql)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('file');
        $targetDatabase = $input->getOption('to');

        if (!file_exists($fileName)) {
            $output->writeln('File not found!');
            return Command::FAILURE;
        }

        $bufferSize = 1000; // Number of lines to buffer
        $buffer = [];

        $fileHandle = fopen($fileName, 'r');

        while (($line = fgets($fileHandle)) !== false) {
            //Clean the line from double quotes
            $pieces = str_getcsv($line, ',');
            $cleanedLine = str_replace('"', '', $pieces[0]);
            $buffer[] = $cleanedLine;

            if (count($buffer) >= $bufferSize) {
                $this->processBuffer($buffer, $targetDatabase);
                $buffer = [];
            }
        }

        if (!empty($buffer)) {
            $this->processBuffer($buffer, $targetDatabase);
        }

        fclose($fileHandle);

        $output->writeln('Data imported successfully!');

        return Command::SUCCESS;
    }

    protected function processBuffer(array $buffer, $targetDatabase): void
    {
        $databaseClient = $this->getDatabaseClient($targetDatabase);
        $databaseClient->importData($buffer);
    }

    protected function getDatabaseClient(string $targetDatabase): DatabaseClientInterface
    {
        return DatabaseClientFactory::createClient($targetDatabase);
    }
}
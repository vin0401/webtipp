<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 07.05.2017
 * Time: 22:53
 */

namespace WebtippBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class SyncDatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:sync-database')

            // the short description shown while running "php bin/console list"
            ->setDescription('Synchronizes database with OpenLigaDB API.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to synchronize the data stored in the database with OpenLigaDB\'s API')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Synchronizing data:');


        $db = $this->getContainer()->get('open-liga-databridge');
        $db->syncAll();

        $output->writeln('DONE!');
    }
}

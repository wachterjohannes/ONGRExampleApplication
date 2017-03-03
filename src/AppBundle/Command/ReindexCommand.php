<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReindexCommand extends ContainerAwareCommand
{
    const PAGE_SIZE = 10;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:reindex');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $indexer = $this->getContainer()->get('app.item_indexer');
        $repository = $this->getContainer()->get('app.item_repository');
        $count = $repository->count();

        $progressBar = new ProgressBar($output, $count);
        $progressBar->start();

        for ($page = 1; $page <= ceil($count / self::PAGE_SIZE); $page++) {
            foreach ($repository->findItems($page, self::PAGE_SIZE) as $item) {
                $indexer->index($item);
                $progressBar->advance();
            }

            $indexer->flush();
        }

        $progressBar->finish();
    }
}

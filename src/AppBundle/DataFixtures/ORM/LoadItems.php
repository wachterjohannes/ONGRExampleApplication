<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Item;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadItems implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $handle = fopen(__DIR__ . '/../items.txt', 'r');
        while (($line = fgets($handle)) !== false) {
            if (substr($line, 0, 1) !== '*') {
                continue;
            }

            $line = preg_replace('/(.*)"(.*)"(.*)/', '$2', $line);
            $line = trim($line);

            $line = preg_replace('/\[\[[^|\]]*\|([^\]]*)?\]\]/', '$1', $line);
            $line = preg_replace('/\[\[([^\]]*)\]\]/', '$1', $line);

            if (0 === strlen($line)) {
                continue;
            }

            $item = new Item();
            $item->setTitle($line);
            $item->setCreatedAt(new \DateTime());
            $manager->persist($item);
        }
        fclose($handle);

        $manager->flush();
    }
}

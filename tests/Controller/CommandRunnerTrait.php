<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

trait CommandRunnerTrait
{
    protected $application;

    protected function getApplication()
    {
        if (null === $this->application) {
            $client = $this->client;

            $this->application = new Application($client->getKernel());
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }

    public function setUp()
    {
        $this->setUpCommands();
    }

    public function setUpCommands()
    {
        $this->runCommand('doctrine:database:drop --force -e test');
        $this->runCommand('doctrine:database:create -e test');
        $this->runCommand('doctrine:schema:update --force -e test');
        $this->runCommand('doctrine:fixtures:load -e test');
    }

    protected function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }
}

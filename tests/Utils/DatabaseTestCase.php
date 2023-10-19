<?php

namespace App\Tests\Utils;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

class DatabaseTestCase extends WebTestCase
{
    protected static $application;

    protected KernelBrowser $client;

    protected EntityManager $entityManager;

    public function setUp(): void
    {
        $this->runCommand('doctrine:database:drop --force');
        $this->runCommand('doctrine:database:create');
        $this->runCommand('doctrine:schema:create');
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function runCommand($command): int
    {
        $command = sprintf('%s --quiet', $command);
        return $this->getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    public function createUser(): User
    {
        // User Object
        $user = new User();
        $user->setEmail("somesh.jagarapu@gmail.com");
        $user->setRoles(['ROLE_ADMIN']);

        $user->setPassword('$2y$13$XF.OzXXLJ0mpsXS0M/Y1vu8ZYhY3.NuD///UDlxFseRJT209nW5/e'); //encoded value of Somesh@123

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}

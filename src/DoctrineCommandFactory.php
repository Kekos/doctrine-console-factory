<?php declare(strict_types=1);

namespace Kekos\DoctrineConsoleFactory;

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationLoader;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Kekos\DoctrineConsoleFactory\Discovery\MigrationsDiscovery;
use RuntimeException;
use Symfony\Component\Console\Application;

use function class_exists;
use function sprintf;

final class DoctrineCommandFactory
{
    /** @var EntityManager */
    private $entity_manager;
    /** @var ConfigurationLoader|null */
    private $configuration_loader;

    public function __construct(EntityManager $entity_manager, ?ConfigurationLoader $configuration_loader)
    {
        $this->entity_manager = $entity_manager;
        $this->configuration_loader = $configuration_loader;
    }

    public function addCommands(Application $application): void
    {
        $this->addOrmCommands($application);
        $this->addMigrationsCommands($application);
    }

    private function addOrmCommands(Application $application): void
    {
        if (!class_exists(ConsoleRunner::class)) {
            return;
        }

        ConsoleRunner::addCommands($application, new SingleManagerProvider($this->entity_manager));
    }

    private function addMigrationsCommands(Application $application): void
    {
        $command_classes = MigrationsDiscovery::getCommandClasses();

        if (empty($command_classes)) {
            return;
        }

        if ($this->configuration_loader === null) {
            throw new RuntimeException(
                sprintf(
                    'The Doctrine Migrations commands requires you to pass an instance of %s.',
                    ConfigurationLoader::class
                )
            );
        }

        $migrations_dependency_factory = DependencyFactory::fromEntityManager(
            $this->configuration_loader,
            new ExistingEntityManager($this->entity_manager)
        );

        foreach ($command_classes as $command_class) {
            $application->add(new $command_class($migrations_dependency_factory));
        }
    }
}

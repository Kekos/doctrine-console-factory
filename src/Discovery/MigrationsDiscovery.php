<?php declare(strict_types=1);

namespace Kekos\DoctrineConsoleFactory\Discovery;

use Doctrine\Migrations\Tools\Console\Command as MigrationsConsole;

use function class_exists;

final class MigrationsDiscovery implements PackageDiscoveryInterface
{
    private static array $class_names = [
        MigrationsConsole\CurrentCommand::class,
        MigrationsConsole\DumpSchemaCommand::class,
        MigrationsConsole\ExecuteCommand::class,
        MigrationsConsole\GenerateCommand::class,
        MigrationsConsole\LatestCommand::class,
        MigrationsConsole\MigrateCommand::class,
        MigrationsConsole\RollupCommand::class,
        MigrationsConsole\StatusCommand::class,
        MigrationsConsole\VersionCommand::class,
        MigrationsConsole\UpToDateCommand::class,
        MigrationsConsole\SyncMetadataCommand::class,
        MigrationsConsole\ListCommand::class,
        MigrationsConsole\DiffCommand::class,
    ];

    public static function getCommandClasses(): array
    {
        if (!class_exists(MigrationsConsole\MigrateCommand::class)) {
            return [];
        }

        return self::$class_names;
    }
}

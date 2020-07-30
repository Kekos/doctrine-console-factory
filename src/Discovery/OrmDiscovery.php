<?php declare(strict_types=1);

namespace Kekos\DoctrineConsoleFactory\Discovery;

use Doctrine\DBAL\Tools\Console as DBALConsole;
use Doctrine\ORM\Tools\Console as ORMConsole;

use function class_exists;

final class OrmDiscovery implements PackageDiscoveryInterface
{
    private static $class_names = [
        DBALConsole\Command\ReservedWordsCommand::class,
        DBALConsole\Command\RunSqlCommand::class,
        ORMConsole\Command\ClearCache\CollectionRegionCommand::class,
        ORMConsole\Command\ClearCache\EntityRegionCommand::class,
        ORMConsole\Command\ClearCache\MetadataCommand::class,
        ORMConsole\Command\ClearCache\QueryCommand::class,
        ORMConsole\Command\ClearCache\QueryRegionCommand::class,
        ORMConsole\Command\ClearCache\ResultCommand::class,
        ORMConsole\Command\SchemaTool\CreateCommand::class,
        ORMConsole\Command\SchemaTool\UpdateCommand::class,
        ORMConsole\Command\SchemaTool\DropCommand::class,
        ORMConsole\Command\EnsureProductionSettingsCommand::class,
        ORMConsole\Command\GenerateProxiesCommand::class,
        ORMConsole\Command\ConvertMappingCommand::class,
        ORMConsole\Command\RunDqlCommand::class,
        ORMConsole\Command\ValidateSchemaCommand::class,
        ORMConsole\Command\InfoCommand::class,
        ORMConsole\Command\MappingDescribeCommand::class,
    ];

    public static function getCommandClasses(): array
    {
        if (!class_exists(ORMConsole\Command\ValidateSchemaCommand::class)) {
            return [];
        }

        return self::$class_names;
    }
}

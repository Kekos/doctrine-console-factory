<?php declare(strict_types=1);

namespace Kekos\DoctrineConsoleFactory;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\Exception\UnknownConfigurationValue;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray as DoctrineConfigurationArray;
use Doctrine\Migrations\Configuration\Migration\ConfigurationLoader;
use RuntimeException;

use function sprintf;

final class MigrationsConfigurationLoader implements ConfigurationLoader
{
    private const ALLOWED_CONFIGURATION_KEYS = [
        'table_storage' => false,
        'migrations_paths' => true,
        'all_or_nothing' => false,
        'check_database_platform' => false,
        'custom_template' => false,
    ];

    public function __construct(
        private readonly array $settings,
    ) {
        foreach ($settings as $setting => $value) {
            if (!isset(self::ALLOWED_CONFIGURATION_KEYS[$setting])) {
                throw UnknownConfigurationValue::new($setting, $value);
            }
        }

        foreach (self::ALLOWED_CONFIGURATION_KEYS as $setting => $required) {
            if ($required && !isset($settings[$setting])) {
                throw new RuntimeException(
                    sprintf(
                        'Missing Doctrine Migrations configuration setting "%s"',
                        $setting
                    )
                );
            }
        }
    }

    public function getConfiguration(): Configuration
    {
        return (new DoctrineConfigurationArray($this->settings))->getConfiguration();
    }
}

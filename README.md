# Doctrine console factory

Helper for adding Doctrine ORM and Migrations console commands to your own Symfony Console application.

## Install

You can install this package via [Composer](http://getcomposer.org/):

```
composer require kekos/doctrine-console-factory
```

## Documentation

### Configuration

If you have the Doctrine Migrations package installed, a `ConfigurationLoader`
must be given to the `DoctrineCommandFactory`. This package ships a
`MigrationsConfigurationLoader` which eliminates the `cli-config.php` file
in your root directory and can easily be created in your DI container.

```php
<?php
// Pseudo container
$container->set('doctrine.migrations', [
    'migrations_paths' => [
        'App\\Migrations' => __DIR__ . '/src/Migrations',
    ],
]);

$container->set(
    Doctrine\Migrations\Configuration\Migration\ConfigurationLoader::class,
    function($container) {
        $settings = $container->get('doctrine.migrations');

        return new Kekos\DoctrineConsoleFactory\MigrationsConfigurationLoader($settings);
    }
);
```

### Usage

Create an instance of `DoctrineCommandFactory` and call the `addCommands()`
and the available Doctrine ORM or Migrations commands will be added to your
Symfony Console application.

```php
<?php
$console_app = new Symfony\Component\Console\Application('App', '1.0.0');

// Please let your DI container create the command factory instead!
$doctrine_command_factory = new Kekos\DoctrineConsoleFactory\DoctrineCommandFactory(
    $entity_manager,
    $configuration_loader
);
$doctrine_command_factory->addCommands($console_app);

$console_app->run();
```

## Bugs and improvements

Report bugs in GitHub issues or feel free to make a pull request :-)

## License

MIT

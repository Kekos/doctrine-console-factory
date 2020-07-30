<?php declare(strict_types=1);

namespace Kekos\DoctrineConsoleFactory\Discovery;

interface PackageDiscoveryInterface
{
    /**
     * @return string[]
     */
    public static function getCommandClasses(): array;
}

<?php

declare(strict_types=1);

namespace Doctrine\DBAL\Migrations\Tests\Configuration;

use Doctrine\DBAL\Migrations\Configuration\AbstractFileConfiguration;
use Doctrine\DBAL\Migrations\Configuration\JsonConfiguration;
use Doctrine\DBAL\Migrations\Finder\MigrationFinder;
use Doctrine\DBAL\Migrations\OutputWriter;
use InvalidArgumentException;
use const DIRECTORY_SEPARATOR;

class JsonConfigurationTest extends AbstractConfigurationTest
{
    public function loadConfiguration(
        string $configFileSuffix = '',
        ?OutputWriter $outputWriter = null,
        ?MigrationFinder $migrationFinder = null
    ) : AbstractFileConfiguration {
        $configFile = 'config.json';

        if ($configFileSuffix !== '') {
            $configFile = 'config_' . $configFileSuffix . '.json';
        }

        $config = new JsonConfiguration($this->getSqliteConnection(), $outputWriter, $migrationFinder);
        $config->load(__DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . $configFile);

        return $config;
    }

    /**
     * Test that config file not exists exception
     */
    public function testThrowExceptionIfFileNotExist() : void
    {
        $config = new JsonConfiguration($this->getSqliteConnection());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Given config file does not exist');

        $config->load(__DIR__ . '/_files/none.json');
    }
}

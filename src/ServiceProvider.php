<?php
namespace DreamFactory\Core\MySqlDb;

use DreamFactory\Core\MySqlDb\Models\MySqlDbConfig;
use DreamFactory\Core\MySqlDb\Services\MySqlDb;
use DreamFactory\Core\Components\DbSchemaExtensions;
use DreamFactory\Core\Enums\LicenseLevel;
use DreamFactory\Core\Services\ServiceManager;
use DreamFactory\Core\Services\ServiceType;
use DreamFactory\Core\Enums\ServiceTypeGroups;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        // Add our service types.
        $this->app->resolving('df.service', function (ServiceManager $df) {
            $df->addType(
                new ServiceType([
                    'name'                  => 'mysql',
                    'label'                 => 'MySQL',
                    'description'           => 'Database service supporting MySQL connections.',
                    'group'                 => ServiceTypeGroups::DATABASE,
                    'subscription_required' => LicenseLevel::SILVER,
                    'config_handler'        => MySqlDbConfig::class,
                    'factory'               => function ($config) {
                        return new MySqlDb($config);
                    },
                ])
            );
            $df->addType(
                new ServiceType([
                    'name'                  => 'mariadb',
                    'label'                 => 'MariaDB',
                    'description'           => 'Database service supporting MariaDB connections.',
                    'group'                 => ServiceTypeGroups::DATABASE,
                    'subscription_required' => LicenseLevel::SILVER,
                    'config_handler'        => MySqlDbConfig::class,
                    'factory'               => function ($config) {
                        return new MySqlDb($config);
                    },
                ])
            );
        });
    }

    public function boot()
    {
        // add migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}

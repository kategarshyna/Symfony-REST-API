<?php

echo 'Data Base init process started!' . PHP_EOL;

function execFunc($cmd, $successMsg = '', $failMsg = '')
{
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null ", $output, $return);

        if (!$return) {
            echo $successMsg . PHP_EOL;
        } else {
            echo $failMsg . PHP_EOL;
        }
    }
}

execFunc('php app/console doctrine:database:drop --force', 'DB deleted successfully.', 'Delete DB failed.');
execFunc('php app/console doctrine:database:create', 'DB created successfully.', 'Create DB failed.');
execFunc('php app/console doctrine:schema:create', 'Entities loaded successfully.', 'Failed to load Entities.');
execFunc('php app/console doctrine:database:import src/AppBundle/DataFixtures/SQL/companies.sql', 'Companies Data Fixture imported.', 'Failed to import Companies.');
execFunc('php app/console doctrine:database:import src/AppBundle/DataFixtures/SQL/clients.sql', 'Clients Data Fixture imported.', 'Failed to import Clients.');
execFunc('php app/console doctrine:database:import src/AppBundle/DataFixtures/SQL/users.sql', 'Users Data Fixture imported.', 'Failed to import Users.');
execFunc('php app/console doctrine:database:import src/AppBundle/DataFixtures/SQL/user_client.sql', 'User Client Data Fixture imported.', 'Failed to import User Client.');

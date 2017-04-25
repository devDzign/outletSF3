<?php
namespace Deployer;
require 'recipe/symfony3.php';

// Configuration

set('ssh_type', 'native');
set('ssh_multiplexing', true);

set('repository', 'https://github.com/devDzign/outletSF3.git');

add('shared_files', []);
add('shared_dirs', []);

add('writable_dirs', []);

// Servers

server('deployersf', 'ssh-deployersf.alwaysdata.net')
    ->user('deployersf')
    ->password('mourad__2008')
    ->set('deploy_path', '/var/www/outletSF3')
    ->pty(true);


// Tasks

desc('Restart PHP-FPM service');
task(
    'php-fpm:restart',
    function () {
        // The user must have rights for restart service
        // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
        run('sudo systemctl restart php-fpm.service');
    }
);
after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

# Local Development

## Requirements

- [Docker](https://ddev.readthedocs.io/en/stable/users/install/docker-installation/)
- [DDev](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/)

## Set-Up

1. Clone the repository
2. Download database from production or create database and .env file from [.env.example](.env.example) and insert APP_KEY
3. Run docker desktop
4. Create and start containers: `ddev start`
5. `ddev composer install` where you have to insert the path to the database
6. `ddev launch`

### Other Useful Commands

- Stop container (current state will be saved): `ddev stop`
- Enable debugging: `ddev xdebug on`

## Drupal Settings & Modules

- Please Note: `settings.php` is already configured correctly when using ddev. If you're using a custom db setup, you have to create an additional `settings.local.php` (that's how it's done in the production environment as well) because the default settigns file is in git.
- Dependencies are being managed by composer and are therefore not in git, i.e. always run `composer install` after pulling
- Configuration can be found [/config/sync](./config/sync) and will be pushed via git.
- Config Split is currently not installed. Please manage development-only modules by adding them to the ignore variable in settings.php and configure them on your own. Additionally, consider using composer require-dev for those modules.

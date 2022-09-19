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

## Starting when already installed

1. Run docker desktop
2. `ddev start`
3. `ddev launch`

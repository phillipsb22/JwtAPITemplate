# Development Notes

## Adding an Entity in a Bundle
Add the mapping for each entity in `config/packages/doctrine.yaml`
```yaml
<name>Bundle:
  is_bundle: true
  type: annotation
```

## Adding a contoller 
Adding a controller directory in a bundle needs to be registered 
`config/routes/annotations.yaml`
```yaml
controllers:
    resource: ../../src/<name>Bundle/Controller/
    type: annotation
```

## Running Database Migrations
This creates the tables and columns that may have been added. <br>
Use this as a reference https://symfony.com/doc/4.4/doctrine.html <br>
Always run this after altering an entity or creating an entity.
NOTE: If you are creating the database you only need to run the migration you don't need to make them
```
$ php bin/console make:migration
```
Then run the migration
```
$ php bin/console doctrine:migrations:migrate
```

## Composer
Make sure your composer file is set to composer.json
you can check and set as below
```
$ echo $COMPOSER
$ export COMPOSER=composer.json
```

## Setting up the testing environment 
Require the fixtures and liip bundle (This has been done already in this project)
```cmd
$ composer require --dev doctrine/doctrine-fixtures-bundle
$ composer require --dev liip/functional-test-bundle:^4.0.0
$ composer require --dev liip/test-fixtures-bundle:^1.0.0
``` 
create a file for the sqlite db in `./var/test.db3`
```yaml
# config/packages/test/doctrine.yaml
doctrine:
    dbal:
        driver: 'pdo_sqlite'
        url: 'sqlite:///%kernel.project_dir%/var/test.db3'
```
Create the database
```cmd 
$ php app/console doctrine:database:create --env=test
```

When doing API endpoint tests `use Liip\FunctionalTestBundle\Test\WebTestCase;`

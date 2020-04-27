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
```
$ php bin/console make:migration
```
The run the migration
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

role_hierarchy:
        - ROLE_SUPER_ADMIN:
              - ROLE_DISTRIBUTOR_USER
              - ROLE_USER_BASIC
        - ROLE_DISTRIBUTOR_USER:
              - ROLE_DISTRIBUTOR_USER
              - ROLE_DISTRIBUTOR_MENU_USER
              - ROLE_BASIC_USER
        - ROLE_DISTRIBUTOR_MENU_USER:
              - ROLE_DISTRIBUTOR_MENU_USER
              - ROLE_BASIC_USER
        - ROLE_BASIC_USER:
              - ROLE_BASIC_USER
# JwtAPITemplate
Symfony 4 API with JWT auth built in

This is still a Work in Progress

## Setup
This is found in the Documents Foler in the project

## Authentication 
Authentication is setup to use JWT and does not implement a revoke token strategy - this will need to be implemented using your own implementation method or simply ignored.
Remember to generate the public and private keys for your token and also we recommend storing sensitive information in symfony secrets

## Authorisation 
Authorisation is not included however for basic user authorisation create a role hierarchy in `config/packages/security.yaml`
```yaml
  role_hierarchy:
        ROLE_USER:             [ROLE_USER]
```
then add the following to the User Entity.

```php
    /**
     * @var $role string
     * @ORM\Column(name="role", type="string", length=100)
     */
    private $role;
    
    public function setRoles(string $role)
    {
      $this->role = $role;
    }
    
    public function getRoles()
    {
      return $this->role;
    }
```
This only allows one role to be set per user for more advanced roles refer to the symfony security documentation

# Iterator Design Pattern

This pattern encapsulates  access to sequential elements within an object. Our project supports importing Entities,
such as
[Users](../../../src/Service/Import/ImportUserService.php)
and
[Orders](../../../src/Service/Import/ImportOrderService.php)
via a CSV file. The **Iterator design pattern** is an excellent method to separate the business logic to perform
the import conversion from the logic to read a CSV file. This strategy places calls to the PHP filesystem methods
behind an
[Iterator Interface](http://php.net/manual/en/class.iterator.php)
in [CSVIterator](../../../src/Lib/CSVIterator.php). In the future, supporting import via XML, JSON,
or consuming a REST API would be seamless.


## Also Known As

* Cursor

## Example

### Import Users

```php
$this->userService->import(new CSVIterator('Users.csv'));

```

```php
class ImportUserService
{
    public function import(Iterator $iterator)
    {
        foreach ($iterator as $row) {
            $externalId = $row[0];
            $firstName = $row[1];
            $email = $row[2];

            $user = new User;
            $user->setExternalId($externalId);
            $user->setFirstName($firstName);
            $user->setEmail($email);

            $this->userRepository->create($user);
        }
    }
}
```

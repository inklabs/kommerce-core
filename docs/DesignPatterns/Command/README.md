# Command Design Pattern

The **command design pattern** is used to encapsulate the parameters of a request. Only scalar types
(int, string, etc.) and DTO's are passed to the constructor of this simple data transfer object.

Below we use the
[ChangePasswordCommand](../../../src/Action/User/ChangePasswordCommand.php)
and
[ChangePasswordHandler](../../../src/Action/User/Handler/ChangePasswordHandler.php)
to facilitate the call to the
[UserService](../../../src/Service/UserService.php) changePassword() method. This enables
us to later use the [Decorator](../Decorator) pattern on the
[CommandBusInterface](../../../src/Lib/Command/CommandBusInterface.php) to add behavior for
audit logging, throttling actions, etc.


## Also Known As

* Action Design Pattern
* Transaction Design Pattern

## Example

### Command:

```php
final class ChangePasswordCommand implements CommandInterface
{
    public function __construct($userId, $password)
    {
        $this->userId = (int) $userId;
        $this->password = (string) $password;
    }
}
```

### Handler:

```php
final class ChangePasswordHandler
{
    public function handle(ChangePasswordCommand $command)
    {
        $this->userService->changePassword(
            $command->getUserId(),
            $command->getPassword()
        );
    }
}
```

### Executing the command:

```php
$userId = 1;
$newPassword = 'newpassword123';
$this->dispatch(new ChangePasswordCommand($userId, $newPassword));
```

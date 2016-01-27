# Domain Event Design Pattern

A **domain event** defines something important that happens in your domain model.
These are domain specific events encapsulated as a simple data transfer object similar to the
[Command Design Pattern](../Command).

Events in this project are raised in the Entities or Service layer. Below is an example of the
[PasswordChangedEvent](../../../src/Event/PasswordChangedEvent.php)
being raised in the Entity layer, and dispatched in the Service layer. This event is
raised when the users password changes through the
[User Entity](../../../src/Entity/User.php) setPassword() method. The
[User Service](../../../src/Service/UserService.php) releases and dispatches events when
the update method is called.

## Example

### User Entity

```php
    public function setPassword($password)
    {
        $this->passwordHash = password_hash((string) $password, PASSWORD_BCRYPT);

        if ($this->id !== null) {
            $this->raise(
                new PasswordChangedEvent(
                    $this->id,
                    $this->email,
                    $this->getFullName()
                )
            );
        }
    }
```

### User Service

```php
    public function changePassword(int $userId, string $password)
    {
        $user = $this->userRepository->findOneById($userId);
        $user->setPassword($password);
        $this->update($user);
    }

    public function update(User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->update($user);
        $this->eventDispatcher->dispatch($user->releaseEvents());
    }
```

### Main Application

```php
$eventDispatcher = new EventDispatcher;
$eventDispatcher->addSubscriber(new EmailSubscriber));
$serviceFactory = new ServiceFactory(
    $this->getRepositoryFactory(),
    $eventDispatcher
);
```

### Email Event Subscriber

```php
class EmailSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents()
    {
        return [
            PasswordChangedEvent::class => 'onPasswordChanged',
        ];
    }

    public function onPasswordChanged(PasswordChangedEvent $event)
    {
        $message = 'Dear ' . $event->getFullName() . "\n" .
            'Per your request, we have successfully changed your password.';

        $this->sendEmail('Revision to Your Account', $event->getEmail(), $message);
    }
}
```

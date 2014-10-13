<?php
namespace inklabs\kommerce\Entity;

class UserLogin
{
    use Accessors;

    public $id;
    public $username;
    public $user_id;
    public $ip4;
    public $result; // success, fail, failock
    public $created;
}

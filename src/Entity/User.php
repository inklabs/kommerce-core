<?php
namespace inklabs\kommerce\Entity;

class User
{
	use Accessors;

	public $id;
	public $email;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $logins;
	public $last_login;
	public $created;
	public $updated;
}

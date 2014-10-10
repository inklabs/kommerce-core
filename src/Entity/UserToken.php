<?php
namespace inklabs\kommerce\Entity;

class UserToken
{
	use Accessors;

	public $id;
	public $user_agent;
	public $token;
	public $type;
	public $created;
	public $expires;
}

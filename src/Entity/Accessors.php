<?php
namespace inklabs\kommerce\Entity;

trait Accessors
{
	/**
	* calls Class::$name()
	*
	* @param string $name the name of a requested property
	* @return mixed the result
	*/
	public function __get($name)
	{
		return $this->__call($name);
	}

	/**
	* checks wether a get method get<$Name>() exists and calls it
	*
	* @param string $name
	* @param array $args optional
	* @return mixed
	*/
	public function __call($name, $args = [])
	{
		if (method_exists($this, $method = 'get' . ucfirst($name))) {
			return $this->{$method}($args);
		} else {
			throw new \Exception('Method or property does not exists');
		}
	}

	/**
	* @param string $name property name
	* @param mixed $value the value
	*/
	public function __set($name, $value)
	{
		if (method_exists($this, $method = 'set' . ucfirst($name))) {
			$this->{$method}($value);
		} else {
			throw new \Exception('Private or protected properties are not accessible');
		}
	}
}

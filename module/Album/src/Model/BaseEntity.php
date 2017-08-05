<?php
namespace Album\Model;

/**
 * Class BaseEntity
 * @package Album\Model
 */
class BaseEntity
{
    /**
     * Magic getter to expose protected properties.
     *
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new \Exception('Getting write-only property: ' . get_class($this) . '::' . $name);
        }
        throw new \Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new \Exception('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new \Exception('Setting unknown property: ' . get_class($this) . '::' . $name);
        }

    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
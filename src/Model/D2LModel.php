<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model;

use ReflectionProperty;

/**
 * @package GAState\Tools\D2L\Model
 * @access protected
 */
abstract class D2LModel
{
    /**
     * @param object|null $values
     */
    public function __construct(?object $values = null)
    {
        if ($values !== null) {
            $this->setValues(values: $values);
        }
    }

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        $vals = get_object_vars($values);
        foreach ($vals as $name => $value) {
            if (property_exists($this, $name)) {
                (new ReflectionProperty($this, $name))->setValue($this, $value);
            }
        }
    }
}

<?php
namespace app\Http\Actions;

class baseAction 
{

    public function returnContract()
    {
        $reflect = new \ReflectionClass($this);
        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_PRIVATE);

        $properties = [];
        
        foreach ($props as $p) {
            $properties[$p->getName()] = $p->getType()->getName();
        }

        return $properties;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
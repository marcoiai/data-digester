<?php
namespace app\Http\Actions;

class baseAction 
{

    public function getInstance($fields) {
        if ($fields === null)
            return false;

        $extra_fields = array_diff($fields, array_keys($this->returnContract()));

        if (!empty($extra_fields)) {
            throw new \Exception("There are too many fields here.", 400);
        }
    }

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

    public function generatePayload($input) {
        $dataContract = $this->returnContract();

        $values = [];

        foreach ($dataContract as $property => $type) {
            
            if (isset($input[$property]) && !empty($input[$property])) {
                settype($input[$property], $type);

                $values[$property] = $input[$property];
            }
        }

        return $values;
    }
}
<?php
namespace app\Callable;

class JSONCallable extends baseCallable
{

    public mixed $decoded;

    public function __construct(mixed $source)
    {
        parent::call($source);
    }
    
    public function getAll():mixed
    {
        die($this->resultCall);
        $this->decoded = json_decode($this->resultCall, true);

        return $this->decoded;
    }

    public function getOne():mixed {
        return $this->decoded[0];
    }
}
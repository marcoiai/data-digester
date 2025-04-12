<?php
namespace app\interfaces;

interface InterfaceDataObject
{
    
    public function __construct(mixed $value);
    
    public function __toString();
}

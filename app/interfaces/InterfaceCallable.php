<?php
namespace app\interfaces;

interface InterfaceCallable {
    public function call(mixed $source);
    
    public function getAll();
    
    public function getOne();

    public function count();
}

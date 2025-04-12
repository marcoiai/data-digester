<?php
namespace app\interfaces;

interface InterfaceData 
{

    public function __construct(
        $name,
        $client,
        $price,
        $sales
    );
}

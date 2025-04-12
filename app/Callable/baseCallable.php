<?php
namespace app\Callable;

use app\interfaces\InterfaceCallable;

class baseCallable implements InterfaceCallable 
{

    public String $resultCall;

    public function call(mixed $source) {
        String:$result = '';

        if ($source instanceof \SplFileObject) {
            while (!$source->eof()) {
                $result += $source->fgets();
            }
        } else if (gettype($source) === 'string') {
            //$result = json_decode($source, true);

            $handle = curl_init($source);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, []);
            //curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
            
            $result = curl_exec($handle);

            echo "baseCallable\n";
            die(__FILE__);
            
            if ($error = curl_errno($handle)) {
                throw new \Exception($error);
                
                curl_close($handle);
            }

            curl_close($handle);
        }

        $this->resultCall = $result;
    }

    public function getAll() {}

    public function getOne() {}

    public function count() {}
}
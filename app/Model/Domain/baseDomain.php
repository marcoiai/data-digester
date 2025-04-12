<?php
namespace app\Model\Domain;

class baseDomain {
    public function call($url) {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, []);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        
        $result = curl_exec($handle);
        
        if (curl_errno($handle)) {
            $result = curl_error($handle);
        }

        curl_close($handle);

        return $result;
    }
}
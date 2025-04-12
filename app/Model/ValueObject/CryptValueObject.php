<?php
namespace app\Model\ValueObject;

use app\interfaces\InterfaceDataObject;

class CryptValueObject implements InterfaceDataObject {
    	
	private $cipher = 'aes-256-ctr';
	private $digest = 'sha512';
	private $key;

    protected $encrpyted;
    protected $decrypted;
	
	public function __construct($key) {
		$this->key = $key;
	}

	public function encrypt(mixed $value) {
		$key       = openssl_digest($this->key, $this->digest, true);
		$iv_length = openssl_cipher_iv_length($this->cipher);
		$iv        = openssl_random_pseudo_bytes($iv_length);
		
        $this->encrpyted = base64_encode($iv . openssl_encrypt($value, $this->cipher, $key, OPENSSL_RAW_DATA, $iv));
        
        return $this->encrpyted;
	}
	
	public function decrypt($value) {
		$key       = openssl_digest($this->key, $this->digest, true);
		$iv_length = openssl_cipher_iv_length($this->cipher);
		$value     = base64_decode($value);
		$iv        = substr($value, 0, $iv_length);
		$value     = substr($value, $iv_length);
		
        $this->decrypted = openssl_decrypt($value, $this->cipher, $key, OPENSSL_RAW_DATA, $iv);
        
        return  $this->decrypted;
	}

    public function __toString()
    {
        return $this->encrpyted;
    }
}
<?php
namespace app\Model\ValueObject;

use app\interfaces\InterfaceDataObject;

class CPFValueObject implements InterfaceDataObject {

    protected string $cleaned;
    protected string $formatted;
    
    public function __construct($cpfNumber) {
        $inputRight = preg_match("/(\d{3})[\.](\d{3})[\.](\d{3})[-](\d{2})/i", $cpfNumber, $matches);
        
        if ($inputRight !== 1) {
            throw new \Exception('O formato não é válido');
        }
        
        $this->cleaned = preg_replace("/\D+/i", "", $cpfNumber);
    }
    
    protected function validate($valid = true) {
        // Aqui vai a validação do digito verificador, ou se veio todos números iguas, etc.
        // Mas o correto é outra classe fazer essa funçao devido Single Responsibility
        if (!$valid) {
            throw new \Exception("O número de CPF não é válido.");
        }
    }
    
    public function __toString() {
        $this->formatted = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/i", "$1.$2.$3-$4", $this->cleaned);

        return $this->formatted;
    }
}
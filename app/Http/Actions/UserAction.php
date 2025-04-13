<?php
namespace app\Http\Actions;

use app\Callable\DataBaseCallable;
use app\Http\Actions\baseAction;
use app\Model\ValueObject\CPFValueObject;
use PDO;
use PDOStatement;

class UserAction extends baseAction
{

    protected int $customer_id;
    protected int $store_id;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected int $address_id;
    protected bool $active;
    protected string $create_date;
    protected string $last_update;
    protected CPFValueObject $cpf;

    public function getInstance($fields = ['email', 'first_name']) {
        $output = '';

        if (in_array(array_keys($this->returnContract()), $fields)) {
            die('in_array');
        }

        var_dump($fields);

        echo '<br><br>';

        var_dump(array_keys($this->returnContract()));

        echo '<br><br>';

        var_dump(array_diff(array_values($this->returnContract()), array_values($fields)));

        echo '<br><br>';

        foreach (array_keys($this->returnContract()) as $field) {
            $output .= "{$field} = :{$field}, ";
        }
        print_r($output);
        die(__FILE__ . ": " . __LINE__);

        $callable = new DataBaseCallable("SELECT * FROM customer where email = :email", ['email' => 'MARSHALL.THORN@sakilacustomer.org']);
        
        return $callable->call();
    }

    public function atomicUpdate()
    {
        $callable = new DataBaseCallable("UPDATE customer SET where email = :email", ['email' => 'MARSHALL.THORN@sakilacustomer.org']);
        
        return $callable->call();
    }
}


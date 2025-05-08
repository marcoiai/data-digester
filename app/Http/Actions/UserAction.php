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

    public function getInstance($fields = ['email' => 'marco.a.simao@gmail.com', 'first_name' => 'Marco', 'customer_id' => 2]) { //, 'teste' => 23423432]) {
        $output = '';

        print_r($fields);

        //var_dump($fields);

        echo '<br><br>';

        //var_dump(array_keys($this->returnContract()));

        echo '<br><br>';

        $extra_fields = array_diff(array_keys($fields), array_keys($this->returnContract()));

        if (!empty($extra_fields)) {
            throw new \Exception("There are fields that doesn't belong here.", 400);
        }

        echo '<br><br>';

        foreach (array_keys($this->returnContract()) as $field) {
            $output .= "{$field} = :{$field}, ";
        }
        //print_r($output);
        die(__FILE__ . ": " . __LINE__);

        $callable = new DataBaseCallable("SELECT * FROM customer where email = :email", ['email' => 'MARSHALL.THORN@sakilacustomer.org']);
        
        return $callable->call();
    }

    public function updateMany(Array $columnsAndValues, Array $where = ['customer_id' => 2])
    {
        implode(', ', $columnsAndValues);
        $callable = new DataBaseCallable("UPDATE customer SET {$column} = {$value} WHERE {$where[0]} = :customer_id", $where[1]);
        
        return $callable->call();
    }

    public function updateOne($column, $value, $where = ['customer_id' => 2])
    {
        $callable = new DataBaseCallable("UPDATE customer SET {$column} = {$value} WHERE {$where[0]} = :customer_id", $where[1]);
        
        return $callable->call();
    }
}


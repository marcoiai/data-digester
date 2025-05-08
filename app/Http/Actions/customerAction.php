<?php
namespace app\Http\Actions;

use app\Callable\DataBaseCallable;
use app\Http\Actions\baseAction;
use app\Model\ValueObject\CPFValueObject;

class customerAction extends baseAction
{

    protected int $customer_id;
    /** @var int $store_id */
    protected int $store_id;
    /** @var string $first_name */
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected int $address_id;
    protected bool $active;
    protected string $create_date;
    protected string $last_update;
    //protected CPFValueObject $cpf;

    /** @var int $customer_id */
    public function __construct()
    {
    }

    public function doInsert($fields = []) {
        $fieldsToInsert = '';

        //print_r($fields);

        if (!empty($fields)) {
            parent::getInstance(array_keys($fields));

            $fieldsToInsert = implode(', ', array_keys($fields));
        } else {
            $fieldsToInsert = implode(', ', array_keys($this->returnContract()));
        }

        $_values = [];

        $bindings = implode(', :', array_keys($fields));

        foreach ($fields as $field => $value) {
            //$bindings .= ":{$field},";
            $_values[$field] = $value;
        }

        $callable = new DataBaseCallable("INSERT INTO customer($fieldsToInsert) VALUES(:$bindings)", $_values);
        
        $called = $callable->call();

        return $callable->count();

    }

    public function insertMany()
    {
        $data = [
            ['John','Doe', 22],
            ['Jane','Roe', 19],
        ];
        $stmt = $this->pdo->prepare("INSERT INTO users (name, surname, age) VALUES (?,?,?)");
        try {
            $this->pdo->beginTransaction();
            foreach ($data as $row)
            {
                $stmt->execute($row);
            }
            $this->pdo->commit();
        }catch (\Exception $e){
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function findAll($fields = [], $where = []) {
        parent::getInstance($fields);

        if (!empty($fields)) {
            $selectFields = implode(', ', $fields);
        } else {
            $selectFields = implode(', ', array_keys($this->returnContract()));
        }

        $_where = '';

        foreach ($where as $field => $value) {
            $_where .= "{$field} = :{$field} AND ";
        }

        if (!empty($_where)) {
            $_where = " WHERE " . substr($_where, 0, -4);
        }
    
        $callable = new DataBaseCallable("SELECT {$selectFields} FROM customer {$_where}", $where);
        
        $callable->call();

        return $callable->getAll();
    }

    public function update(Array $columnsAndValues, Array $where = [])
    {
        if (empty($where) && empty($where[0])) {
            throw new \Exception("Can't update whithout ");
        }

        $values = [];
        $columns = '';
        $_where = '';

        foreach ($columnsAndValues as $column => $value ) {
            $columns .= " {$column} = :{$column}, ";
            $values[$column] = $value;
        }

        $columns = substr($columns, 0, strlen($columns) - 2);

        foreach ($where as $column => $value ) {
            $_where .= " {$column} = :{$column} AND";

            //$where[$column] = "w$column";
        }

        $_where = substr($_where, 0, strlen($_where) - 3);

        

        $callable = new DataBaseCallable("UPDATE customer SET {$columns} WHERE $_where", $values + $where);
        
        return $callable->call();
    }

    /**
     *  Take it's type from reflection (we have at returnContract)
     */
    public function updateOne($column, $value, $where = ['customer_id' => 2])
    {
        $callable = new DataBaseCallable("UPDATE customer SET {$column} = {$value} WHERE {$where[0]} = :customer_id", $where[1]);
        
        return $callable->call();
    }
}


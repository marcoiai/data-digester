<?php
namespace app\Callable;

use app\Model\PDOTest;
use PDOStatement;

class DataBaseCallable extends baseCallable
{

    public String $statement;
    public Array $params;
    public PDOStatement $resultCallStatement;
    public String $resultCall;

    public function __construct($statement, $params)
    {
        $this->statement = $statement;
        $this->params = $params;
    }

    public function call(mixed $source = '') 
    {
        $pdo = new PDOTest();
        $stmt = $pdo->prepare($this->statement);
        $stmt->execute($this->params);

        $this->resultCallStatement = $stmt;
    }

    public function getAll() {
        return $this->resultCallStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOne() {
        return $this->resultCallStatement->fetch(\PDO::FETCH_ASSOC);
    }

    public function count() {
        return count ($this->getAll());
    }
}
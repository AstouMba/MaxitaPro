<?php
namespace App\Repository;
use App\Core\Database;
use App\Core\App;
use PDO;
class TransactionRepository
{
    private Database $database;
    private static ?TransactionRepository $instance = null;

    public function __construct()
    {

        $this->database = App::getDependencies('database');
    }
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function selectLastTenTransactions(int $id): ?array
    {
        $sql = "SELECT * FROM transaction where compteid = :id ";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $transactions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
     
            return $transactions;

    }


}
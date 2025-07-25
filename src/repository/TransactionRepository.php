<?php
namespace App\Repository;
use App\Core\abstract\AbstractRepository;

use PDO;
class TransactionRepository extends AbstractRepository
{
    private static ?TransactionRepository $instance = null;

    public function __construct()
    {

        parent::__construct();
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
        $sql = "SELECT * FROM transaction where compteid = :id  ORDER BY date DESC LIMIT 10";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $transactions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }

        return $transactions;

    }
public function selectAllTransactions(int $id): ?array
{
    $sql = "SELECT * FROM transaction WHERE compteid = :id ORDER BY date DESC LIMIT 10";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([':id' => $id]);

    $alltransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $alltransactions ?: [];
}







}
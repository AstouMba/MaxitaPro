<?php


namespace App\Entity;

use App\Entity\CompteEnum;
use DateTime;

class Compte
{
    private ?int $id = null;
    private string $numero;
    private DateTime $datecreation;
    private float $solde;
    private string $numerotel;
    private CompteEnum $CompteEnum;
    private int $userId;
    private Utilisateurs $utilisateurs;
    private array $transactions = [];

    public function __construct(
        string $numero,
        DateTime $datecreation,
        float $solde,
        string $numerotel,
       CompteEnum $typeCompte,
        int $userId,
        Utilisateurs $utilisateurs
    ) {
        $this->numero = $numero;
        $this->datecreation = $datecreation;
        $this->solde = $solde;
        $this->numerotel = $numerotel;
        $this->CompteEnum = $typeCompte;
        $this->userId = $userId;
        $this->utilisateurs = $utilisateurs;
        $this->transactions = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNumero(): string
    {
        return $this->numero;
    }
    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }
    public function getUtilisateurs(): Utilisateurs
    {
        return $this->utilisateurs;
    }

    public function setUtilisateurs(Utilisateurs $utilisateurs): void
    {
        $this->utilisateurs = $utilisateurs;
        $this->userId = $utilisateurs->getId();
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
    public function addTransaction(array $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    public function getDatecreation(): DateTime
    {
        return $this->datecreation;
    }
    public function setDatecreation(DateTime $datecreation): void
    {
        $this->datecreation = $datecreation;
    }

    public function getSolde(): float
    {
        return $this->solde;
    }
    public function setSolde(float $solde): void
    {
        $this->solde = $solde;
    }

    public function getNumerotel(): string
    {
        return $this->numerotel;
    }
    public function setNumeroTel(string $numerotel): void
    {
        $this->numerotel = $numerotel;
    }

    public function getCompteEnum(): CompteEnum
    {
        return $this->CompteEnum;
    }
    public function setTypeCompte(CompteEnum $typeCompte): void
    {
        $this->typeCompte = $typeCompte;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'datecreation' => $this->datecreation->format('Y-m-d H:i:s'),
            'solde' => $this->solde,
            'numerotel' => $this->numerotel,
            'typecompte' => $this->CompteEnum->value,
            'userid' => $this->userId,
        ];
    }

    public static function toObject(array $data): self
    {
        $userData = $data['user'] ?? null;

        $user = $userData ? Utilisateurs::toObject($userData) : new Utilisateurs(
            '',
            '',
            '',
            '',
            '',
            '',
            TypeUserEnum::from('client')
        );

        $compte = new self(
            $data['numero'] ?? '',
            new DateTime($data['datecreation'] ?? 'now'),
            (float)($data['solde'] ?? 0),
            $data['numerotel'] ?? '',
            CompteEnum::from($data['typecompte'] ?? 'principal'),
            (int)($data['userid'] ?? 0),
            $user
        );

        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($compte, (int)$data['id']);
        }

        return $compte;
    }


  
}
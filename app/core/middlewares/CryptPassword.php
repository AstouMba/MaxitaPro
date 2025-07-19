<?php
namespace App\Core\Middlewares;

class CryptPassword
{
    public function __invoke(array &$data): void
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
    }
        public static function verifyPassword(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }

}

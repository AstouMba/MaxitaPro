<?php

namespace App\Core;


class Validator
{
    private static array $errors = [];
    private static ?self $instance = null;
    private static array $rules = [];

    private function __construct()
    {
        self::$errors = [];

        self::$rules = [
            "required" => function ($key, $value, $message = MessageEnumFr::REQUIRED->value) {
                if (empty($value)) {
                    self::addError($key, $message);
                }
            },
            "requiredLogin" => function ($key, $value, $message = MessageEnumFr::REQUIREDLOGIN->value) {
                if (empty($value)) {
                    self::addError($key, $message);
                }
            },
            "requiredPassword" => function ($key, $value, $message = MessageEnumFr::REQUIREDPASSWORD->value) {
                if (empty($value)) {
                    self::addError($key, $message);
                }
            },
            "minLength" => function ($key, $value, $minLength, $message = MessageEnumFr::MINLENGTH->value) {
                if (strlen($value) < $minLength) {
                    self::addError($key, $message);
                }
            },
            "isMail" => function ($key, $value, $message = MessageEnumFr::ISEMAIL->value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    self::addError($key, $message);
                }
            },
            "isPassword" => function ($key, $value, $message = MessageEnumFr::ISPASSWORD->value) {
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $value)) {
                    self::addError($key, $message);
                }
            },
            "isSenegalPhone" => function ($key, $value, $message = MessageEnumFr::ISSENEGALPHONE->value) {
                $value = preg_replace('/\D/', '', $value);
                $prefixes = ['70', '75', '76', '77', '78'];
                if (!(strlen($value) === 9 && in_array(substr($value, 0, 2), $prefixes))) {
                    self::addError($key, $message);
                }
            },
            "isCNI" => function ($key, $value, $message = MessageEnumFr::ISCNI->value) {
                $value = preg_replace('/\D/', '', $value);
                if (!preg_match('/^1\d{12}$/', $value)) {
                    self::addError($key, $message);
                }
            },
        ];
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function validate(array $data, array $rules): bool
    {
        self::$errors = []; // Reset à chaque validation

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                if (is_string($rule)) {
                    $callback = self::$rules[$rule] ?? null;
                    if ($callback) {
                        $callback($field, $value);
                    }
                } elseif (is_array($rule)) {
                    $ruleName = $rule[0];
                    $params = array_slice($rule, 1);
                    $callback = self::$rules[$ruleName] ?? null;
                    if ($callback) {
                        $callback($field, $value, ...$params);
                    }
                }
            }
        }

        return empty(self::$errors);
    }

    private static function addError(string $field, string $message): void
    {
        // Ne remplace pas si une erreur existe déjà sur le champ
        if (!isset(self::$errors[$field])) {
            self::$errors[$field] = $message;
        }
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }
}

<?php
namespace App\Config\ErrorsEnum;

class ErrorsEnumFr
{
    public const REQUIRED = "Le champ :field est obligatoire.";
    public const PASSWORD_REQUIRED = "Le mot de passe est obligatoire.";
    public const PASSWORD_MIN_LENGTH = "Le mot de passe doit contenir au moins 6 caractères.";
    public const INVALID_PHONE = "Numéro de téléphone invalide.";
    public const DUPLICATE_PHONE = "Ce numéro est déjà utilisé.";
    public const INVALID_CNI = "Numéro CNI invalide.";
    public const DUPLICATE_CNI = "Cette CNI est déjà utilisée.";
    public const PHOTO_REQUIS = "La photo :type est requise et doit être une image JPEG ou PNG.";
    public static function format(string $message, array $params = []): string
{
    foreach ($params as $key => $value) {
        $message = str_replace(":$key", $value, $message);
    }
    return $message;
}

}
// $lang = 'fr'; // ou 'en'
// $translator = $lang === 'fr' ? ErrorsEnumFr::class : ErrorsEnumEn::class;
// $errors['nom'] = $translator::format($translator::REQUIRED, ['field' => 'Nom']);

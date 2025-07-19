<?php

namespace App\Core;

enum MessageEnumFr: string
{
    case REQUIRED = 'Champ obligatoire';
    case REQUIREDLOGIN = 'Le login est obligatoire';
    case REQUIREDPASSWORD = 'Le password est obligatoire';
    case MINLENGTH = 'Trop court';
    case ISEMAIL = 'Email invalide';
    case ISPASSWORD = 'Mot de passe invalide';
    case ISSENEGALPHONE = 'Numéro de téléphone invalide';
    case ISCNI = 'Numéro de CNI invalide';
}

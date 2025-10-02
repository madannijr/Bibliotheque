<?php
// src/Enum/StatutLivreType.php

namespace App\Enum;
use App\Entity\Livre;

class StatutLivreType
{
const EMPRUNTE = 'emprunté';
const DISPONIBLE = 'disponible';
const RESERVE = 'réservé';

public static function getChoices(): array
{
return [
self::EMPRUNTE => 'Emprunté',
self::DISPONIBLE => 'Disponible',
self::RESERVE => 'Réservé',
];
}
}

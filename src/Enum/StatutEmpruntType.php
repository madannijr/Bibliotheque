<?php
// src/Enum/StatutEmpruntType.php

namespace App\Enum;

class StatutEmpruntType
{
const EN_COURS = 'en cours';
const TERMINE = 'terminé';
const RETARDE = 'retardé';

public static function getChoices(): array
{
return [
self::EN_COURS => 'En cours',
self::TERMINE => 'Terminé',
self::RETARDE => 'Retardé',
];
}
}

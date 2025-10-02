<?php
// src/Enum/StatutReservationType.php

namespace App\Enum;

class StatutReservationType
{
const EN_ATTENTE = 'en attente';
const CONFIRME = 'confirmé';
const ANNULE = 'annulé';

public static function getChoices(): array
{
return [
self::EN_ATTENTE => 'En attente',
self::CONFIRME => 'Confirmé',
self::ANNULE => 'Annulé',
];
}
}

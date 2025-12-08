<?php

namespace App\Enums;

enum PaiementStatut: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED  = 'failed';
}

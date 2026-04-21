<?php
namespace App\Enums;

enum AccountStatus: string
{
    case Available = 'available';
    case Reserved  = 'reserved';
    case Sold      = 'sold';
}
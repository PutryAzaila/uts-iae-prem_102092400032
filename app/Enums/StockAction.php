<?php
namespace App\Enums;

enum StockAction: string
{
    case Added    = 'added';
    case Reserved = 'reserved';
    case Sold     = 'sold';
    case Released = 'released';
    case Deleted  = 'deleted';
}
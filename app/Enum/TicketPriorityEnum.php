<?php

namespace App\Enum;

enum TicketPriorityEnum:int
{
    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;
    
    public static function values()
	{
		return array_map(fn($item) => $item->value, self::cases());
	}
}

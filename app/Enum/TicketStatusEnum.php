<?php

namespace App\Enum;

enum TicketStatusEnum:int
{
    case PENDING = 0;
    case IN_PROGRESS = 1;
    case RESOLVED = 2;
    case CLOSED = 3;

    public static function values()
	{
		return array_map(fn($item) => $item->value, self::cases());
	}
}

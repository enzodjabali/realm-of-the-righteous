<?php
declare(strict_types = 1);

namespace App\classes;

/**
 * Enumeration of the database tables
 */
enum DbTable: string
{
	case TABLE_PLAYER = "player";
	case TABLE_MAPS = "maps";
	case TABLE_GAME = "game";
	case TABLE_GAME_EVENT = "game_event";
}

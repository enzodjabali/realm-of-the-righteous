<?php
declare(strict_types = 1);

namespace App\classes;

/**
 * Enumeration of the database tables
 */
enum DbTable: string
{
	case TABLE_PLAYER = "player";
	case TABLE_GAME = "game";
    case TABLE_GAME_LOG = "game_log";
    case TABLE_CHAT = "chat";
    case TABLE_PRIVATE_CHAT = "private_chat";
    case TABLE_VERIFICATION_LINK = "verification_link";
    case TABLE_RESET_PASSWORD_LINK = "reset_password_link";
}

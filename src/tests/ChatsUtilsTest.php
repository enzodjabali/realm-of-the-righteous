<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\ChatUtils;
use Exception;
use PHPUnit\Framework\TestCase;

final class ChatsUtilsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testInsertNewMessage(): void
    {
        $isMessageInserted = ChatUtils::insertMessage(1, "test message from PHPUnit");
        $this->assertTrue($isMessageInserted);
    }

    /**
     * @throws Exception
     */
    public function testGetAllMessages(): void
    {
        $findAllMessages = ChatUtils::findAllMessages(1);
        $this->assertGreaterThan(0, count($findAllMessages));
    }
}

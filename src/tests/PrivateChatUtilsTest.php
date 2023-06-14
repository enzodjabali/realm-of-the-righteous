<?php
declare(strict_types = 1);

namespace App\tests;

use App\classes\PrivateChatUtils;
use Exception;
use PHPUnit\Framework\TestCase;

final class PrivateChatUtilsTest extends TestCase
{
    public function testInsertNewPrivateMessage(): void
    {
        $isPrivateMessageInserted = PrivateChatUtils::insertPrivateMessage(1, 1, "test private message from PHPUnit");
        $this->assertTrue($isPrivateMessageInserted);
    }

    /**
     * @throws Exception
     */
    public function testGetAllPrivateMessages(): void
    {
        $findAllPrivateMessages = PrivateChatUtils::findAllPrivateMessages(1, 1);
        $this->assertGreaterThan(0, count($findAllPrivateMessages));
    }
}

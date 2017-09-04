<?php

namespace MessageApi\Domain\Message\Entity;

use MessageApi\Domain\Message\Entity\MessageEntity;

class MessageEntityCollection extends \ArrayObject implements \JsonSerializable
{
    /**
     * @param MessageEntity $message
     *
     * @return void
     */
    public function set(MessageEntity $message)
    {
        $this[] = $message;
    }

    /**
     * @param void
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $messageArray = $this->getArrayCopy();

        $rawMessageArray = [];
        foreach($messageArray as $message) {
            $rawMessageArray[] = $message->jsonSerialize();
        }

        return $rawMessageArray;
    }
}

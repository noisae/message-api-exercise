<?

namespace MessageApi\Infra\Repository\Parser;

use MessageApi\Infra\Repository\Parser\ParserInterface;
use MessageApi\Domain\Message\Entity\MessageEntity;
use MessageApi\Domain\Message\Entity\MessageEntityCollection;

class MessageEntityParser implements ParserInterface {

    /**
     * @param array $raw
     *
     * @return MessageEntity
     */
    public function parseItem(array $raw) : MessageEntity {

        $uid = $raw['uid'] ?? null;
        $sender = $raw['sender'] ?? null;
        $subject = $raw['subject'] ?? null;
        $message = $raw['message'] ?? null;
        $time_sent = $raw['time_sent'] ?? null;
        $isRead = !!$raw['isRead'] ?? false;
        $isArchived = !!$raw['isArchived'] ?? false;

        return new MessageEntity($uid, $sender, $subject, $message, $time_sent, $isRead, $isArchived);
    }

    /**
     * @param array $rawCollection
     *
     * @return MessageEntityCollection
     */
    public function parseCollection(array $rawCollection) : MessageEntityCollection {
        $collection = new MessageEntityCollection();
        foreach($rawCollection as $raw) {
            $collection->set($this->parseItem($raw));
        }

        return $collection;
    }

}

<?php

namespace MessageApi\Domain\Message\Entity;

use MessageApi\Domain\Message\Entity\AbstractEntity;

class EmptyEntity extends AbstractEntity {
    /**
     * @return stdClass
     */
    public function jsonSerialize() : \stdClass {
        return new \stdClass();
    }
}

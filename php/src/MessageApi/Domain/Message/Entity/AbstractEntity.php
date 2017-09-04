<?php

namespace MessageApi\Domain\Message\Entity;

abstract class AbstractEntity implements \JsonSerializable {
    /**
     * @return mixed
     */
    abstract public function jsonSerialize();
}

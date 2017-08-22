<?php
namespace MessageApi\Features\Store;

use League\FactoryMuffin\Stores\AbstractStore;
use League\FactoryMuffin\Stores\StoreInterface;

class Mock extends AbstractStore implements StoreInterface
{
    protected function save($model)
    {
        return true;
    }

    protected function delete($model)
    {
        return true;
    }
}

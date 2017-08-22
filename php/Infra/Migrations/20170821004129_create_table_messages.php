<?php

use Phinx\Migration\AbstractMigration;

class CreateTableMessages extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('messages', array('id' => 'uid'));
        $table
            ->addColumn('sender', 'string')
            ->addColumn('subject', 'string')
            ->addColumn('message', 'text')
            ->addColumn('time_sent', 'integer')
            ->addColumn('isRead', 'boolean', array("default" => false))
            ->addColumn('isArchived', 'boolean', array("default" => false))
            ->create();
    }
}

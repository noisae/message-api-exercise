<?php

use Phinx\Seed\AbstractSeed;

class SeedMessages extends AbstractSeed
{
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/messages_sample.json'), true);

        $messages = $this->table('messages');
        $messages
            ->insert($data['messages'])
            ->save();
    }
}

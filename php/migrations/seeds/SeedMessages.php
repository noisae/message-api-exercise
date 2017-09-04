<?php

use Phinx\Seed\AbstractSeed;

class SeedMessages extends AbstractSeed
{
    public function run()
    {
        $jsonToSeed = file_get_contents(__DIR__ . '/messages_sample.json');
        $data = json_decode($jsonToSeed, true);

        if ($data['messages']) {
            $messages = $this->table('messages');
            $messages->truncate();
            $messages->insert($data['messages'])->save();
        }
    }
}

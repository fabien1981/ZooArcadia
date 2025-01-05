<?php

namespace App\Controller;

class TestController
{
    public function testMongoDB()
    {
        echo \App\Database\DbConnectionNoSQL::testMongoConnection();
    }
}

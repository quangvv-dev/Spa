<?php

namespace App\Services;

use Exception;
use Kreait\Firebase\Factory;
//use Kreait\Firebase\Contract\Database;

// use
//use  Kreait\Firebase\Database;
class FirebaseService
{
    protected $database;
    protected $factory;
    public function __construct()
    {
        $this->factory = (new Factory)
            ->withServiceAccount(public_path('assets/gtg-beauty-93a302ab660e.json'))
            ->withDatabaseUri('https://gtg-beauty-default-rtdb.asia-southeast1.firebasedatabase.app');
        $this->database = $this->factory->createDatabase();
    }

    public function setupReference($url = "notification/1", $data = ['user_id' => 2, 'name' => 'quang'])
    {
        $reference = $this->database->getReference($url);
        $reference->push($data);
        return $reference->getSnapshot()->getValue();
    }

    public function removeChildren($url="notification/1")
    {
        $this->database->getReference($url)->remove();
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Repository;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        touch('database/database.sqlite');

        $this->repository = new Repository();
    //    $token = bcrypt(Str::random(16));
        $this->repository->createDatabase();
        // $this->repository->addUser('bi', 'BONANE', 'Inoussa', 'bonanedjimba@gmail.com', 'Meine1001', $token);
        $this->repository->addUser('kj', 'KONE', 'Jean', 'jeankone@gmail.com', 'Meine0110', bcrypt(Str::random(16)));
        
        // $this->repository->addArticle("Article", 15.99, 1);
        // $this->repository->addArticle("PC", 1515.16, 2);
        // $this->repository->addArticle("Montre", 105, 2);
        // $this->repository->addArticle("Voiture", 251515.33, 2);
    }
}

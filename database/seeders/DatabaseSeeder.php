<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\Repository;

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

        $this->repository->createDatabase();
        $this->repository->addUser('BONANE', 'Inoussa', 'bonanedjimba@gmail.com', 'Meine1001');
        $this->repository->addUser('KONE', 'Jean', 'jeankone@gmail.com', 'Meine0110');
        
        $this->repository->addArticle("Article", 15.99, 1);
        $this->repository->addArticle("PC", 1515.16, 2);
        $this->repository->addArticle("Montre", 105, 2);
        $this->repository->addArticle("Voiture", 251515.33, 2);
    }
}

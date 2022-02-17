<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Repository 
{
    function createDatabase(): void 
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    //Create User

    function addUser(string $lastname, string $firstname, string $email, string $password): int
    {
        $passwordHash = Hash::make($password);

        return DB::table('Users')
                        ->insertGetId(['lastname'=>$lastname, 
                                       'firstname'=>$firstname,
                                       'email'=>$email,
                                       'passwordHash'=>$passwordHash]);
    }

    function getUser(string $email, string $password): array
    {
        $rows = DB::table('users')
                        ->where('email', $email)
                        ->get();

        if(count($rows)==0){
            throw new Exception('utilisateur inconnu');
        }

        $rowUser = $rows[0];

        if(!(Hash::check($password, $rowUser->passwordHash))){
            throw new Exception('utilisateur inconnu');
        }

        return ['id'=>$rowUser->id, 'email'=>$rowUser->email];
    }


    //Create Articles User

    function addArticle(string $name, float $price, int $id_user): int
    {

        return DB::table('Articles')
                        ->insertGetId(['name'=>$name, 'price'=>$price, 'id_user'=>$id_user]);   
    }

    function getArticles(): array
    {
        return DB::table('Articles')
                        ->orderBy('id')
                        ->get()
                        ->toArray();   
    }

    function getArticleById($id): array
    {       
        return DB::table('Articles')
                        ->where('id', $id)
                        ->get()
                        ->toArray();
    }

    function getArticlesUser($id_user): array
    {       
        return DB::table('Articles')
                        ->where('id_user', $id_user)
                        ->get()
                        ->toArray();
    }

    function update($id, $name, $price, $id_user): void 
    {
        DB::table('Articles')
                        ->where('id', $id)
                        ->where('id_user', $id_user)
                        ->update(['name'=>$name, 'price'=>$price]);
    }

    function searchArticles(string $query): array
    {
        return DB::table('Articles')
                        ->where('name', 'LIKE', '%'.$query.'%') 
                        ->orWhere('price', 'LIKE', '%'.$query.'%')
                        ->get()
                        ->toArray();
    }

    function removeArticles($id, $id_user): void
    {
        DB::table('Articles')
                        ->where('id', $id) 
                        ->where('id_user', $id_user)
                        ->delete();
    }

    //Create User
}

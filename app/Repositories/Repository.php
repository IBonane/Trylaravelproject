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

    function addUser(string $pseudo, string $lastname, string $firstname, string $email, string $password, string $token): int
    {
        $passwordHash = Hash::make($password);

        return DB::table('Users')
                        ->insertGetId(['pseudo'=>$pseudo,
                                       'lastname'=>$lastname, 
                                       'firstname'=>$firstname,
                                       'email'=>$email,
                                       'passwordHash'=>$passwordHash,
                                        'token'=>$token]);
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

    function confirmationUser($email, $password, $token)
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

        if($token != $rowUser->token){
            throw new Exception('token invalide');
        }

        DB::table('users')
                    ->where('email', $email)
                    ->update(['token'=>'null']);

        return ['id'=>$rowUser->id, 'email'=>$rowUser->email];
    }

    //Article categories
    function getArticleCategories(): array
    {
       return DB::table('categories')
                    ->get()
                    ->toArray();
    }

    //Create Articles User

    function addArticle(string $name, float $price, string $id_cat, int $id_user, string $etape_desc, string $path_image): int
    {

        return DB::table('Articles')
                        ->insertGetId(['name'=>$name, 
                                        'price'=>$price, 
                                        'id_cat'=>$id_cat,
                                        'id_user'=>$id_user, 
                                        'etape_desc'=>$etape_desc,
                                        'path_image'=>$path_image]);   
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

    function update($id, $name, $price, $id_cat, $id_user, $path_image): void 
    {
        DB::table('Articles')
                        ->where('id', $id)
                        ->where('id_user', $id_user)
                        ->update(['name'=>$name, 'price'=>$price, 'id_cat'=>$id_cat, 'path_image'=>$path_image]);
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

    //Create articles description 
    // function addEtape(int $id_article, array $etape_desc): int
    // {

    //     return DB::table('Etapes')
    //                     ->insertGetId(['id_article'=>$id_article, 
    //                                     'etape_desc'=>$etape_desc]);   
    // }

    // function getEtapesById($id_article): array
    // {
    //     return DB::table('Etapes')
    //                     ->where('id_article', $id_article) 
    //                     ->orderBy('id')
    //                     ->get()
    //                     ->toArray();   
    // }    

    // function updateEtapes($id, $id_article, $etape_desc): void 
    // {
    //     DB::table('Etapes')
    //                     ->where('id', $id)
    //                     ->where('id_article', $id_article)
    //                     ->update(['name'=>$name, 'price'=>$price, 'id_cat'=>$id_cat, 'path_image'=>$path_image]);
    // }                                                                                                                       
 
}

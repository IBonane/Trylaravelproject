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

    function getUserById(int $id): array
    {
        return DB::table('users')
                        ->where('id', $id)
                        ->get()
                        ->toArray();
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

    function update($id, $name, $price, $id_cat, $id_user, $etape_desc, $path_image): void 
    {
        DB::table('Articles')
                        ->where('id', $id)
                        ->where('id_user', $id_user)
                        ->update(['name'=>$name, 'price'=>$price, 'id_cat'=>$id_cat, 'etape_desc'=>$etape_desc, 'path_image'=>$path_image]);
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

    //Article categories
    function getPagesType(): array
    {
        return DB::table('Type_pages')
                    ->get()
                    ->toArray();
    }

    //Create articles pages
    function addPage($namePage, $id_type): int 
    {
        return DB::table('Pages')
                        ->insertGetId(['namePage'=>$namePage,
                                       'id_type'=>$id_type]);
    }  
    
    function addArticlePage($id_page, $id_article): void
    {
        DB::table('Articles_pages')
                        ->insert(['id_page'=>$id_page, 'id_article'=>$id_article]);
    }

    function getArticleAndPagesById($id): array
    {       
        return DB::table('Pages')
                        ->join('Articles_pages', 'Pages.id', 'id_page')
                        ->join('Articles', 'id_article', 'Articles.id')
                        ->where('Pages.id', $id)
                        ->get('Pages.*')
                        ->toArray();
    }

    //likes
    function likes($id_user_f, $id_article_f): void 
    {
        DB::table('Favoris')
            ->insert(['id_user_f'=>$id_user_f, 'id_article_f'=>$id_article_f]);
    }

    //likes
    function getLikes($id_user_f): array 
    {
       return DB::table('Favoris')
            ->where('id_user_f', $id_user_f)
            ->join('Articles', 'id_article_f', 'Articles.id')
            ->select('Articles.name','Articles.price')
            ->get()
            ->toArray();
    }

    function removeLikes($id_user_f, $id_article_f): void 
    {
        DB::table('Favoris')
            ->where('id_user_f', $id_user_f) 
            ->where('id_user_f', $id_article_f)
            ->delete();
    }
 
}

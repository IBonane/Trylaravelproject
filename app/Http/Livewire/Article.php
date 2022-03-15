<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
/*---------------
pour liker sans erreur, dans : vendor/livewire/livewire/src/HydrationMiddleware/HydratePublicProperties.php 
mettre la ligne 134 en commentaire (tout le 'else')
--------------*/
class Article extends Component
{   
    public array $article;
    public string $isliked = 'false';
    public array $rows = [];

    public function ajoutFavoris()
    {
        $this->repository = new Repository(); 

        $user = request()->session()->get('user');
        $articlelike = $this->article['id'];
        
        try{
        $rows = DB::table('Favoris')
                        ->where('id_user_f', $user['id'])
                        ->where('id_article_f', $articlelike)
                        ->get();}
        catch (Exception $e) { $rows=[];}

        $this->rows =  json_decode(json_encode($rows), true);


        if(count($rows)==0){
            $this->repository->likes($user['id'], $articlelike);
            $this->isliked = 'true';
        }
       //add like
       else 
       {
        $this->repository->removeLikes($user['id'], $articlelike);
        $this->isliked  = 'false';
       }  
    }

    public function render()
    {   
        $this->repository = new Repository(); 
        $likes = $this->repository->getLikes(request()->session()->get('user'));
 
        return view('livewire.article', ['isliked'=>$this->isliked, 'rows'=>$this->rows, 'likes'=>$likes]);
    }
}

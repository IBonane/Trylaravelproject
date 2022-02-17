<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\Repository;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function home()
    {
        $articles = $this->repository->getArticles();
        
       return view('home', ['articles'=>$articles]);
    }

    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ];

        $messages = [
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            $user = $this->repository->getUser($validatedData['email'], $validatedData['password']);
            $request->session()->put('user', $user);
        } 
        
        catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        request()->session()->forget('user');

        return redirect()->route('home');
    }

    public function dashboardUser($id)
    {
        if (!request()->session()->has('user') || $id != session()->get('user')['id']) 
        {
            return redirect()->route('login');
        }

        $articlesUser = $this->repository->getArticlesUser($id);
        
        return view('user_dashboard', ['articlesUser'=>$articlesUser]);
        
    }

    public function search()
    {
        $inputValue = request()->input('search');

        try {
            $queries = $this->repository->searchArticles($inputValue);

            return view('search')->with('queries', $queries);
        }

        catch (Exception $exception) {
            return redirect()->route('search.page')->withErrors("Aucun Articles trouvé !");
        }
    }

    public function detailArticle($id)
    {
        $article = $this->repository->getArticleById($id);

        return view('detail_article')->with('article', $article);
    }

    public function createview()
    {
        return view('create');
    }

    public function create()
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

        $id_user = session()->get('user')['id'];
        $name = request()->input('name');
        $price = request()->input('price');

        $this->repository->addArticle($name, $price, $id_user);
        
        return redirect("/dashboard/$id_user");
    }

    public function showUpdate($id)
    {
        $articleFind = $this->repository->getArticleById($id);

        return view('update')->with('articleFind', $articleFind);
    }

    public function update($id)
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

        $id_user = session()->get('user')['id'];
        $name = request()->input('name');
        $price = request()->input('price');

        $this->repository->update($id, $name, $price, $id_user);

        return redirect("/dashboard/$id_user");
    }

    public function remove($id)
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

        $id_user = session()->get('user')['id'];
        $this->repository->removeArticles($id, $id_user);

        return redirect("/dashboard/$id_user");
    }
}
  
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\Repository;
use Illuminate\Support\Str;

use Mail;


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

    public function showCreateUser()
    {
        
        return view('user_create');
    }

    public function showConfirmation()
    {
        return view('confirmation_code');
    }

    // public function html_email($data) {
        
    //     Mail::send('mail', $data, function($message) {
    //        $message->to($email, 'code de confirmation')->subject
    //           ('Laravel HTML Testing Mail');
    //        $message->from('elsimple229@gmail.com','site cuisine');
    //     });
    //     echo "Mail envoyé !";
    // }

    public function CreateUser()
    {
        $rules = [
            'pseudo' =>['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password']
        ];
        
        $messages = [
            'pseudo.required' => 'Vous devez saisir un pseudo',
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.unique' => "Cet utilisateur existe déjà.",
            'password.required' => "Vous devez saisir un mot de passe.",
            'password_confirm.same' => "Vous devez saisir à nouveau le même mot de passe.",
            'password_confirm.required' => "Vous devez saisir à nouveau le même mot de passe."
        ];

        $lastname = request()->input('lastname');
        $firstname = request()->input('firstname');

        $validatedData = request()->validate($rules, $messages);

        $token = bcrypt(Str::random(16));
        
       // $this->html_email([$token], $validatedData['email']);

        try {
            
            if(request()->input('lastname')==null)
                $lastname = '';

            if(request()->input('firstname')==null)
                $firstname = '';

           $this->repository->addUser($validatedData['pseudo'], $lastname, $firstname, $validatedData['email'], $validatedData['password'], $token);
        } 
        
        catch (Exception $e) {
   
            return redirect()->route('home');
        }

        return redirect()->route('confirmation')->with('success', $token);

    }

    public function confirmationCode()
    {
        $rules = [
            'token'=>['required', 'exists:users,token'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ];
        
        $messages = [
            'token.required' => 'Vous devez saisir un token.',
            'token.exists' => "Cet token est invalide.",
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];

        $validatedData = request()->validate($rules, $messages);

        try {
            $user = $this->repository->confirmationUser($validatedData['email'], $validatedData['password'], $validatedData['token']);
            request()->session()->put('user', $user);
        } 
        
        catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }

        return redirect()->route('home');

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

    public function showRemove($id)
    {
        $articleRemove = $this->repository->getArticleById($id);
        return view('remove')->with('articleRemove', $articleRemove);
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

    public function noRemove()
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

        $id_user = session()->get('user')['id'];
        
        return redirect("/dashboard/$id_user");
    }
}
  
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

use App\Mail\ConfirmationMail;
use Illuminate\Support\Facades\Mail;

use Dompdf\Dompdf;
use Dompdf\Options;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*----------------------Error d'affichage d'une seule valeur des input c'est : 
    dans views on doit mettre : <input type="text" name="row[]"/> et dans controller : request()->input('row')--------------------------------------------------------*/

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function home()
    {
        $articles = $this->repository->getArticles();
        $categories = $this->repository->getArticleCategories();
        
       return view('home', ['articles'=>$articles])->with('categories', $categories);
    }

    public function showCreateUser()
    {
        
        return view('user_create');
    }

    public function showConfirmation()
    {
        return view('confirmation_code');
    }

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
        
        Mail::to($validatedData['email'])->send(new ConfirmationMail([$token]));

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

        return redirect()->route('confirmation');

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
        $etapes = explode( '|', $article[0]->etape_desc);

        //dd($article[0]->etape_desc);

        return view('detail_article', ['etapes'=>$etapes])->with('article', $article);
    }

    public function downloadArticle($id)
    { 
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $articles = $this->repository->getArticles();

        $article = $this->repository->getArticleById($id);
        $dompdf->loadHtml(view('topdf', compact('article')));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('recette.pdf');
    }

    public function createview()
    {
        $categories = $this->repository->getArticleCategories();
        return view('create')->with('categories', $categories);
    }

    public function create()
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

        // dd(request()->all());
        //    $array = request()->input('row');
        //    dd(count($array));
        //images
        //create unique filename image
        $filename = time().'.'.request()->image_article->extension();
        //put image into storage folder and get path
        $path_image = request()->file('image_article')->storeAs('articlesImages', $filename, 'public');
        
        $id_user = session()->get('user')['id'];
        $name = request()->input('name');
        $price = request()->input('price');
        $array = request()->input('row');

        //dd($array);

        $categorieValue = request()->input('categorie');
        // explode( ',', $array )
        $this->repository->addArticle($name, $price, $categorieValue, $id_user, implode("|", $array), $path_image);
        
        return redirect("/dashboard/$id_user");
    }

    public function showUpdate($id)
    {
        $articleFind = $this->repository->getArticleById($id);

        $etapes = explode( ',', $articleFind[0]->etape_desc);
        
        $categories = $this->repository->getArticleCategories();

        return view('update', ['categories'=>$categories, 'etapes'=>$etapes])->with('articleFind', $articleFind);
    }

    public function update($id)
    {
        if (!request()->session()->has('user')) 
        {
            return redirect()->route('login');
        }

          //images
        //create unique filename image
        $filename = time().'.'.request()->image_article->extension();
        //put image into storage folder and get path
        $path_image = request()->file('image_article')->storeAs('articlesImages', $filename, 'public');

        $id_user = session()->get('user')['id'];
        $name = request()->input('name');
        $price = request()->input('price');
        $categorieValue = request()->input('categorie');
        $array = request()->input('row');
        //dd($array);
        
        $this->repository->update($id, $name, $price, $categorieValue, $id_user, implode("|", $array), $path_image);

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
  
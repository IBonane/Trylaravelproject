<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recette PDF</title>
</head>
<body style="text-align: center">
    <h1 >Article</h1>
    <div >
        <h3>
            {{ $article[0]->id }}- {{ $article[0]->name }} :  {{ $article[0]->price }} $            
        </h3>
        <img style="height: 180px; width: 180px" src="{{ public_path('storage/'.$article[0]->path_image) }}" alt="image article">
    </div>
</body>
</html>


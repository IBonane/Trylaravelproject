<div>
    <div>
        <div style="border: 1px solid grey; display: flex; width:50%; margin-bottom:50px; margin-left:5px">
            <h3 style="width: 50%">{{ $article['id'] }}- {{ $article['name'] }} :  {{ $article['price'] }} $ </h3>
            <h3><a href = '/article/{{$article['id']}}' style="color:orange">Detail</a></h3>
            @if (session()->has('user'))
                <button style="height: 30px; width: 30px; position:relative; top:15px; left:25%; border:none; background:transparent; cursor:pointer " wire:click="ajoutFavoris">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2} @if($isliked == 'true') fill='green' @else fill="none" @endif>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>  
                </button>    
            @endif                             
        </div>  
        @if ($isliked == 'true')
            <h3 style="color: blue">
                liké -> oui
            </h3>
            @foreach ($likes[0] as $like)
                <h5>{{$like}}</h5>
            @endforeach
        @else
        <h3 style="color: red"> liké -> non</h3>
        @endif
    </div>
</div>

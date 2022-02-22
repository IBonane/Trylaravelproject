@component('mail::message')
# Code de confirmation d'email

Ceci est un message de confirmation de votre adresse mail saisie lors de votre inscription sur <em>FoodWorld.</em><br>
Veuillez trouvez ci-dessous un code de validation de votre inscription.
<br><br>

Code Token : <span style="color: blue">{{$data[0]}}</span> 


Bienvenu dans la communauté !<br>
@endcomponent

require('./bootstrap');
let addInput = document.querySelector('#plus');
let delInput = document.querySelector('#moins');
delInput.hidden = true;

let addInputInDiv = document.getElementById('ajout');
let idName = 1;

addInput.addEventListener("click", plus);
delInput.addEventListener("click", moins);

function plus(){
    idName++;

    if(idName>1)
        delInput.hidden = false;

    let divAdd = '<div id="'+idName+'"><label for="name">Nom '+idName+'</label>\
                    <input type="text" name="row['+(idName-1)+']"></div>';

    addInputInDiv.innerHTML += divAdd;
    
}

function moins(){
    
    if(idName<=1){
        delInput.hidden = true; 
        return false;
    }  
    document.getElementById(idName).remove();
    idName--;
    return true;
            
}

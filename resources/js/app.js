require('./bootstrap');

let addInput = document.querySelector('#plus');
let delInput = document.querySelector('#moins');
delInput.hidden = true;
let addInputInDiv = document.querySelector('#ajout');
let divAdd ="";
// let idName = addInputInDiv.children.length;
// if(idName > 1){
//     idName = addInputInDiv.getElementsByTagName('div').length;
// }
let idName = addInputInDiv.getElementsByTagName('div').length;


addInput.addEventListener("click", plus);
delInput.addEventListener("click", moins);
// console.log(idName);
function plus(){
    idName++;
    // console.log(idName);
    if(idName>1)
        delInput.hidden = false;

    divAdd = '<div id="'+idName+'"><label for="row['+idName+']">Nom '+idName+'</label>\
                    <input type="text" name="row['+idName+']"></div><br>';

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
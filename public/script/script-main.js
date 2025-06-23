function showElement(elementhidden, type = ""){
    var element = document.getElementById(elementhidden);
    if(type != ""){
        if(type === "moa"){
            var required = document.getElementById("moa_souscripteur_form_raison_sociale");
        }else{
             var required = document.getElementById(type+"_entreprise_raison_sociale");
        }
       
        // ✅ Set required attribute
        required.setAttribute('required', '');
    }    
    element.classList.remove('hidden');
}

function hideElement(elementvisible, type){
    var element = document.getElementById(elementvisible);
        element.classList.add('hidden');
    if(type != ""){
        console.log(type);
        if(type === "moa"){
            var required = document.getElementById("moa_souscripteur_form_raison_sociale");
            console.log(required);
        }else{
            var required = document.getElementById(type+"_entreprise_raison_sociale");
            // ✅ Remove required attribute
            required.removeAttribute('required');            
        }
    }          
}

function buttonActivate(elementdisabled, checkboxhome){
    var element = document.getElementById(elementdisabled);
    var checkbox = document.getElementById(checkboxhome);
    if (checkbox.checked == true){
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}

function addRemoveRequired(elementname){
    var element = document.getElementsByName(elementname);
    if(element.required = true){
        element.required = false;
    }else{
        element.required = true;
    }
}

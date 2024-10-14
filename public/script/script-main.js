function alert(message){
    alert(message);
}

function showElement(elementhidden){
    var element = document.getElementById(elementhidden);
    element.classList.remove('hidden');
}

function hideElement(elementvisible){
    var element = document.getElementById(elementvisible);
        element.classList.add('hidden');
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

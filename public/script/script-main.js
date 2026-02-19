function showElement(elementhidden, type = ""){
    var element = document.getElementById(elementhidden);
    if(type != ""){
        var required = null;
        if(type === "moa"){
            required = document.getElementById("moa_souscripteur_form_raison_sociale");
        }else{
            required = document.getElementById(type+"_entreprise_raison_sociale");
        }
        if(required){
            required.setAttribute('required', '');
        }
    }
    if(element && element.classList){
        element.classList.remove('hidden');
    }
}

function hideElement(elementvisible, type){
    var element = document.getElementById(elementvisible);
    if(element && element.classList){
        element.classList.add('hidden');
    }
    if(type != ""){
        var required = null;
        if(type === "moa"){
            required = document.getElementById("moa_souscripteur_form_raison_sociale");
        }else{
            required = document.getElementById(type+"_entreprise_raison_sociale");
        }
        if(required && typeof required.removeAttribute === 'function'){
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
    var elements = document.getElementsByName(elementname);
    if(!elements || elements.length === 0) return;
    for(var i=0;i<elements.length;i++){
        var el = elements[i];
        if(el.hasAttribute('required')){
            el.removeAttribute('required');
        }else{
            el.setAttribute('required','');
        }
    }
}

/* Dark mode utilities: toggles `class="dark"` on <html> and persists preference */
function applyDarkClass(enabled){
    if(enabled){
        document.documentElement.classList.add('dark');
    }else{
        document.documentElement.classList.remove('dark');
    }
    // update icons
    var moon = document.getElementById('icon-moon');
    var sun = document.getElementById('icon-sun');
    if(moon && sun){
        if(enabled){
            moon.classList.add('hidden');
            sun.classList.remove('hidden');
        }else{
            moon.classList.remove('hidden');
            sun.classList.add('hidden');
        }
    }
}

function initDarkMode(){
    try{
        var stored = localStorage.getItem('theme');
        if(stored === 'dark'){
            applyDarkClass(true);
        }else if(stored === 'light'){
            applyDarkClass(false);
        }else{
            // respect system preference
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyDarkClass(prefersDark);
        }
    }catch(e){
        // ignore
    }

    var btn = document.getElementById('dark-mode-toggle');
    if(btn){
        btn.addEventListener('click', function(){
            var isDark = document.documentElement.classList.contains('dark');
            var enable = !isDark;
            applyDarkClass(enable);
            try{ localStorage.setItem('theme', enable ? 'dark' : 'light'); }catch(e){}
        });
    }
}

// init on DOMContentLoaded to ensure button exists
document.addEventListener('DOMContentLoaded', function(){
    initDarkMode();
    initFontSize();
    // attach font widget buttons if present
    var inc = document.getElementById('font-increase');
    var dec = document.getElementById('font-decrease');
    var rst = document.getElementById('font-reset');
    if(inc) inc.addEventListener('click', increaseFont);
    if(dec) dec.addEventListener('click', decreaseFont);
    if(rst) rst.addEventListener('click', resetFont);
    // mark required labels with a red asterisk
    markRequiredLabels();
});

/* Font size controls */
function applyFontSize(px){
    if(!px) return;
    document.documentElement.style.setProperty('--root-font-size', px + 'px');
}

function increaseFont(){
    var current = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--root-font-size')) || 16;
    var next = Math.min(24, Math.round(current + 1));
    applyFontSize(next);
    try{ localStorage.setItem('fontSize', next); }catch(e){}
}

function decreaseFont(){
    var current = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--root-font-size')) || 16;
    var next = Math.max(12, Math.round(current - 1));
    applyFontSize(next);
    try{ localStorage.setItem('fontSize', next); }catch(e){}
}

function resetFont(){
    applyFontSize(16);
    try{ localStorage.removeItem('fontSize'); }catch(e){}
}

function initFontSize(){
    try{
        var stored = localStorage.getItem('fontSize');
        if(stored){
            var n = parseFloat(stored);
            if(!isNaN(n)) applyFontSize(n);
        }
    }catch(e){ }
    // keyboard shortcuts: +/- to change font
    document.addEventListener('keydown', function(e){
        if(e.key === '+' || e.key === '='){
            increaseFont();
        }else if(e.key === '-'){
            decreaseFont();
        }
    });
}

/* Mark labels associated with required inputs with an asterisk */
function markRequiredLabels(){
    try{
        var inputs = document.querySelectorAll('[required]');
        inputs.forEach(function(inp){
            var id = inp.id;
            var label = null;
            if(id){
                label = document.querySelector('label[for="'+id+'"]');
            }
            if(!label){
                label = inp.closest('label');
            }
            if(label){
                // avoid duplicate
                if(!label.querySelector('.required-asterisk')){
                    var span = document.createElement('span');
                    span.className = 'required-asterisk';
                    span.textContent = '*';
                    label.appendChild(span);
                }
            }
        });
    }catch(e){ }
}


function handleToggleYN(checkbox, radioOuiId, radioNonId, spanValueId) {
    const radioOui = document.getElementById(radioOuiId);
    const radioNon = document.getElementById(radioNonId);
    const spanValue = document.getElementById(spanValueId);
    if (checkbox.checked) {
        if (radioOui) radioOui.checked = true;
        if (spanValue) spanValue.textContent = 'Oui';
    } else {
        if (radioNon) radioNon.checked = true;
        if (spanValue) spanValue.textContent = 'Non';
    }
}

<?php
    
    
    if(!empty($_GET['page']) && substr($_GET['page'], 0, 4) === "step"):
    if($currentstep != 'rcd'):
    $home='';
    if($currentstep=="home"){ 
        $home = 'border-blue-500 bg-blue-50';
    }else{  
        // Stepper Flowbite style
        echo '<section id="stepper" class="flex flex-col items-center justify-center mb-24 m-8 mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">';
        echo '<div class="flex flex-col w-full max-w-4xl">';
        $steps = [
            ["step1", "Coordonnées souscripteur", "Step 1 : coordonnées", '<svg class="w-5 h-5 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>'],
            ["step2", "Maitre d'Ouvrage", "Step 2 : maître d'ouvrage", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/></svg>'],
            ["step3", "Opération de construction", "Nature et type de l'ouvrage", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["step4", "Opération de construction", "Situation de l'ouvrage et Travaux annexes", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["step4bis", "Opération de construction", "Travaux annexes", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["step5", "Maîtrise d'oeuvre et Garanties demandées", "Garanties demandées", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["validation", "Validation", "Validation finale", '<svg class="w-5 h-5 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>']
        ];
        $currentIndex = 0;
        foreach ($steps as $i => $step) {
            if ($step[0] == $currentstep) $currentIndex = $i;
        }
        // Première ligne : étapes 1 à 3
        echo '<ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse justify-center">';
        for ($i = 0; $i < 3; $i++) {
            $isActive = ($i == $currentIndex);
            $isDone = ($i < $currentIndex);
            $liClass = $isActive ? 'text-blue-700 space-x-3 rtl:space-x-reverse font-bold' : ($isDone ? 'text-fg-brand space-x-3 rtl:space-x-reverse' : 'text-body space-x-3 rtl:space-x-reverse');
            $spanClass = $isActive ? 'flex items-center justify-center w-10 h-10 bg-blue-200 rounded-full lg:h-12 lg:w-12 shrink-0 border-2 border-blue-700' : 'flex items-center justify-center w-10 h-10 bg-neutral-tertiary rounded-full lg:h-12 lg:w-12 shrink-0';
            echo '<li class="flex items-center '.$liClass.'">';
            if (defined('DEBUG') && DEBUG && !$isActive) {
                $url = 'index.php?page='.$steps[$i][0];
                if ($i >= 1) { $url .= '&doid=163'; }
                echo '<a href="'.$url.'" class="flex items-center">';
            }
            echo '<span class="'.$spanClass.'">';
            if ($isDone) {
                echo $steps[0][3]; // check icon
            } else {
                echo $steps[$i][3];
            }
            echo '</span>';
            echo '<span>';
            echo '<h3 class="font-medium leading-tight text-base">'.$steps[$i][1].'</h3>';
            echo '<p class="text-xs">'.$steps[$i][2].'</p>';
            echo '</span>';
            if (defined('DEBUG') && DEBUG && !$isActive) {
                echo '</a>';
            }
            echo '</li>';
        }
        echo '</ol>';
        // Deuxième ligne : étapes 4 à fin
        echo '<ol class="items-center w-full mt-4 space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse justify-center">';
        for ($i = 3; $i < count($steps); $i++) {
            $isActive = ($i == $currentIndex);
            $isDone = ($i < $currentIndex);
            $liClass = $isActive ? 'text-fg-brand space-x-3 rtl:space-x-reverse font-bold' : ($isDone ? 'text-fg-brand space-x-3 rtl:space-x-reverse' : 'text-body space-x-3 rtl:space-x-reverse');
            $spanClass = $isActive ? 'flex items-center justify-center w-10 h-10 bg-brand-softer rounded-full lg:h-12 lg:w-12 shrink-0' : 'flex items-center justify-center w-10 h-10 bg-neutral-tertiary rounded-full lg:h-12 lg:w-12 shrink-0';
            echo '<li class="flex items-center '.$liClass.'">';
            if (defined('DEBUG') && DEBUG && !$isActive) {
                $url = 'index.php?page='.$steps[$i][0];
                if ($i >= 1) { $url .= '&doid=163'; }
                echo '<a href="'.$url.'" class="flex items-center">';
            }
            
            echo '<span class="'.$spanClass.'">';
            if ($isDone) {
                echo $steps[0][3]; // check icon
            } else {
                echo $steps[$i][3];
            }
            echo '</span>';
            echo '<span>';
            echo '<h3 class="font-medium leading-tight">'.$steps[$i][1].'</h3>';
            echo '<p class="text-sm">'.$steps[$i][2].'</p>';
            echo '</span>';
            if (defined('DEBUG') && DEBUG && !$isActive) {
                echo '</a>';
            }
            echo '</li>';
        }
        echo '</ol>';
        echo '</div></section>';
    }
    endif;
    endif;
<?php
    
    
    if(!empty($_GET['page']) && substr($_GET['page'], 0, 4) === "step"):
    if($currentstep != 'rcd'):
    $home='';
    if($currentstep=="home"){ 
        $home = 'border-blue-500 bg-blue-50';
    }else{  
        // Stepper Flowbite style
            echo '<section id="stepper" class="flex flex-row items-center justify-center mb-4 m-2 p-2 border-l-4 border-blue-500 bg-blue-50">';
            echo '<div class="flex flex-row w-full max-w-3xl">';
        $steps = [
            ["step1", "Souscripteur", "Coordonnées", '<svg class="w-5 h-5 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>'],
            ["step2", "Maitre d'Ouvrage", "Informations", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/></svg>'],
            ["step3", "Opération de construction", 
                "<div class=\"flex flex-col gap-0 hover:underline text-blue-700 text-[11px] \">
                    <a href='index.php?page=step3' >> Nature et type de l'ouvrage</a>
                    <a href='index.php?page=step4' >> Situation de l'ouvrage</a>
                    <a href='index.php?page=step4bis' >> Travaux annexes</a>
                    </div>", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["step5", "Garanties demandées", "Maîtrise d'oeuvre et Garanties", '<svg class="w-5 h-5 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z"/></svg>'],
            ["validation", "Validation", "Validation finale", '<svg class="w-5 h-5 text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>']
        ];
        $currentIndex = 0;
        foreach ($steps as $i => $step) {
            if ($step[0] == $currentstep) $currentIndex = $i;
        }
        // Stepper horizontal desktop, vertical mobile
        echo '<ol class="items-center w-full flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 justify-center overflow-x-auto">';
        for ($i = 0; $i < count($steps); $i++) {
            $isActive = ($i == $currentIndex);
            $isDone = ($i < $currentIndex);
            $liClass = $isActive ? 'text-blue-700 space-x-2 rtl:space-x-reverse font-bold' : ($isDone ? 'text-fg-brand space-x-2 rtl:space-x-reverse' : 'text-body space-x-2 rtl:space-x-reverse');
            $spanClass = $isActive ? 'flex items-center justify-center w-7 h-7 bg-blue-200 rounded-full border-2 border-blue-700' : 'flex items-center justify-center w-7 h-7 bg-neutral-tertiary rounded-full';
            if ($i >= 3 && $isActive) { 
                $spanClass =         'flex items-center justify-center w-7 h-7 bg-brand-softer rounded-full border-2 border-blue-700'; 
            }
            // Ajout d'un séparateur vertical desktop, horizontal mobile (sauf dernier)
            $isLast = ($i === count($steps) - 1);
            echo '<li class="flex items-center '.$liClass.'">';

            echo '<span class="'.$spanClass.'">';
                if ($isDone) {
                    echo str_replace('w-5 h-5','w-4 h-4',$steps[0][3]);
                } else {
                    echo str_replace('w-5 h-5','w-4 h-4',$steps[$i][3]);
                }
            echo '</span>';
            echo '<span>';
            if (defined('DEBUG') && DEBUG && !$isActive) {
                $url = 'index.php?page='.$steps[$i][0];
                if ($i >= 1) { $url .= '&doid=163'; }
                echo '<a href="'.$url.'">';
            }            
            echo '<h3 class="font-medium leading-tight text-sm">'.$steps[$i][1].'</h3>';
            // Séparateur mobile (ligne horizontale) entre les étapes sauf la dernière
            if (!$isLast) {
                echo '<span class="block sm:hidden w-full h-px bg-gray-300 my-2"></span>';
            }
            if (defined('DEBUG') && DEBUG && !$isActive) {
                echo '</a>';
            }
            echo '<p class="text-[11px]">'.$steps[$i][2].'</p>';
            echo '</span>';
            // Séparateur desktop (trait vertical) entre les étapes sauf la dernière
            if (!$isLast) {
                echo '<span class="hidden sm:block h-8 border-r border-gray-300 mx-2"></span>';
            }

            echo '</li>';
        }
        echo '</ol>';
        echo '</div></section>';
    }
    endif;
    endif;
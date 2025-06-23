<?php

    
    if(substr($_GET['page'], 0, 4) === "step"):
    if($currentstep != 'rcd'):
    $home='';
    $currentstep1 = "text-gray-500 dark:text-gray-400";
    $currentstep1circle = "border-gray-500 dark:border-gray-400";
    $currentstep2 = $currentstep1;
    $currentstep2circle = $currentstep1circle;
    $currentstep3 = $currentstep1;
    $currentstep3circle = $currentstep1circle;
    $currentstep4 = $currentstep1;
    $currentstep4circle = $currentstep1circle;
    $currentstep4bis = $currentstep1;
    $currentstep4biscircle = $currentstep1circle;
    $currentstep5 = $currentstep1;
    $currentstep5circle = $currentstep1circle;
    $validation = $currentstep1;
    $validationcircle = $currentstep1circle;
 
    $currentrcd = $currentstep1;
    $currentrcdcircle = $currentstep1circle;
    switch ($currentstep){
        case'home':
            $home = 'hidden';
            break;
        case'step0':
            break;            
        case'step1':
            $currentstep1 = "text-blue-600 dark:text-blue-500 font-bold";
            $currentstep1circle = "border-blue-600 border-2";
            break;
        case'step2':
            $currentstep2 = "text-blue-600 dark:text-blue-500 font-bold";
            $currentstep2circle = "border-blue-600 border-2";
            break;
        case'step3':
            $currentstep3 = "text-blue-600 dark:text-blue-500 font-bold";
            $currentstep3circle = "border-blue-600 border-2";
            break;
        case'step4':
            case'step4bis':
            $currentstep4 = "text-blue-600 dark:text-blue-500 font-bold";
            $currentstep4circle = "border-blue-600 border-2";
            break;
        case'step5':
            $currentstep5 = "text-blue-600 dark:text-blue-500 font-bold";
            $currentstep5circle = "border-blue-600 border-2";
            break;
        case'rcd':
            $currentrcd = "text-blue-600 dark:text-blue-500 font-bold";
            $currentrcdcircle = "border-blue-600 border-2";
            break;            
        case 'validation':
            $validation = "text-blue-600 dark:text-blue-500 font-bold";
            $validationcircle = "border-blue-600 border-2";
            break;
        default:
            throw new Exception ('Paramètre invalide !');
            break;
    }
    
        if(DEBUG==true){
            echo '<section id="stepper" class="flex justify-center mb-24 m-8 '.$home.'">
                    <div class="flex justify-center mt-16">   
                        <ol class="flex flex-wrap items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0">
                            <li id="step1" class="flex items-center space-x-2.5 '.$currentstep1.'">
                                <a href="index.php?page=step1" class="flex flex-row">
                                    <span id="step1-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep1circle.'">
                                        1
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Coordonnées souscripteur</h3>
                                    </span>
                                </a>
                            </li>
                            <li id="step2" class="flex items-center space-x-2.5 '.$currentstep2.'">
                                <a href="index.php?page=step2" class="flex flex-row">
                                    <span id="step2-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep2circle.'">
                                        2
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Maitre d\'Ouvrage</h3>
                                    </span>
                                </a>
                            </li>
                            <li id="step3" class="flex items-center space-x-2.5 '.$currentstep3.'">
                                <a href="index.php?page=step3" class="flex flex-row">
                                    <span id="step3-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep3circle.'">
                                        3
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Opération de construction</h3>
                                        <p id="step3-p" class="text-xs font-normal ml-2 $currentstep3">Nature et type de l\'ouvrage</p>
                                    </span>
                                </a>
                            </li>
                            <li id="step4" class="flex items-center space-x-2.5 '.$currentstep4.'">
                                <a href="index.php?page=step4" class="flex flex-row">
                                    <span id="step4-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep4circle.'">
                                        4
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Opération de construction</h3>
                                        <p id="step4-p" class="text-xs font-normal ml-2 $currentstep4">Situation de l\'ouvrage et Travaux annexes</p>
                                    </span>
                                </a>
                            </li>
                            <li id="step4bis" class="hidden flex items-center space-x-2.5 '.$currentstep4bis.'">
                                <a href="index.php?page=step4bis" class="flex flex-row">
                                    <span id="step4bis-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep4biscircle.'">
                                        4b
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Oopération de construction</h3>
                                        <p id="step4bis-p" class="text-xs font-normal ml-2 $currentstep4bis">Travaux annexes</p>
                                    </span>
                                </a>
                            </li>
                            <li id="step5" class="flex items-center space-x-2.5 '.$currentstep5.'">
                                <a href="index.php?page=step5" class="flex flex-row">
                                    <span id="step5-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep5circle.'">
                                        5
                                    </span>
                                    <span>
                                        <h3 class="ml-2">Maîtrise d\'oeuvre et Garanties demandées</h3>
                                    </span>
                                </a>
                            </li>
                            <li id="validation" class="flex items-center space-x-2.5 '.$validation.'">
                                <a href="index.php?page=validation" class="flex flex-row">
                                    <span id="validation-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$validationcircle.'">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>

                                    </span>
                                    <span>
                                        <h3 class="ml-2">Validation</h3>
                                    </span>
                                </a>
                            </li>
                        </ol>
                    </div>
                </section>';
        }else{
        echo '<section id="stepper" class="flex justify-center mb-24 m-8 '.$home.'">
        <div class="flex justify-center mt-16">   
            <ol class="flex flex-wrap items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0">
                <li id="step1" class="flex items-center space-x-2.5 '.$currentstep1.'">
                        <span id="step1-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep1circle.'">
                            1
                        </span>
                        <span>
                            <h3 class="ml-2">Coordonnées souscripteur</h3>
                        </span>
                </li>
                <li id="step2" class="flex items-center space-x-2.5 '.$currentstep2.'">
                        <span id="step2-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep2circle.'">
                            2
                        </span>
                        <span>
                            <h3 class="ml-2">Maitre d\'Ouvrage</h3>
                        </span>
                </li>
                <li id="step3" class="flex items-center space-x-2.5 '.$currentstep3.'">
                        <span id="step3-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep3circle.'">
                            3
                        </span>
                        <span>
                            <h3 class="ml-2">Opération de construction</h3>
                            <p id="step3-p" class="text-xs font-normal ml-2 $currentstep3">Nature et type de l\'ouvrage</p>
                        </span>
                </li>
                <li id="step4" class="flex items-center space-x-2.5 '.$currentstep4.'">
                        <span id="step4-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep4circle.'">
                            4
                        </span>
                        <span>
                            <h3 class="ml-2">Opération de construction</h3>
                            <p id="step4-p" class="text-xs font-normal ml-2 $currentstep4">Situation de l\'ouvrage et Travaux annexes</p>
                        </span>
                </li>
                <li id="step4bis" class=" hidden flex items-center space-x-2.5 '.$currentstep4bis.'">
                        <span id="step4bis-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep4biscircle.'">
                            4b
                        </span>
                        <span>
                            <h3 class="ml-2">Opération de construction</h3>
                            <p id="step4bis-p" class="text-xs font-normal ml-2 $currentstep4bis">Travaux annexes</p>
                        </span>
                </li>
                <li id="step5" class="flex items-center space-x-2.5 '.$currentstep5.'">
                        <span id="step5-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$currentstep5circle.'">
                            5
                        </span>
                        <span>
                            <h3 class="ml-2">Maîtrise d\'oeuvre et Garanties demandées</h3>
                        </span>
                </li>
                <li id="validation" class="flex items-center space-x-2.5 '.$validation.'">
                    <span id="validation-circle" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 '.$validationcircle.'">
                        Val
                    </span>
                    <span>
                        <h3 class="ml-2">Validation</h3>
                    </span>
                </li>
            </ol>
        </div>
    </section>';
        }
    endif;
    endif;
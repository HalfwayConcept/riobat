<?php
    session_start();

    //session_destroy();
    $_SESSION['env'] = getenv('APP_ENV') ?: 'prod';

    include_once("inc/settings.php");
    require 'controllers/page-erreur.controller.php';
    require 'controllers/user.controller.php';
    if(empty($_SESSION['user_id'])){
        $_SESSION['user_id']=null;
    }

    // Charger le rôle en session s'il n'y est pas encore (sessions existantes avant migration)
    if (!empty($_SESSION['user_id']) && empty($_SESSION['user_role'])) {
        $u = get_infos($_SESSION['user_id']);
        $_SESSION['user_role'] = $u['role'] ?? 'user';
    }
    
    // Vide la superglobale $_SESSION
    // $_SESSION = [];
    if (isset($_GET['page'])){
        $currentstep = $_GET['page'];
        $_SESSION['action'] = $currentstep;

        // Route publique : upload RCD via token (pas d'auth requise)
        if ($_GET['page'] === 'upload_rcd') {
            require 'controllers/upload_rcd.controller.php';
            publicUploadRcd();
            exit;
        }

        switch($_GET['page']){
            case 'home':
                require 'controllers/home.controller.php';
                homeDisplay($currentstep);
                break;
            case 'step0':
                require 'controllers/do.controller.php'; 
                clearSessionDO();
                stepDisplay($currentstep);
                break;
            case 'step1':
            case 'step2':
            case 'step3':
            case 'step4':
            case 'step4bis':
            case 'step5':   
                require 'controllers/do.controller.php';    
                stepDisplay($currentstep);
                break;      
            case 'fiche':
                require 'controllers/validation.controller.php';
                validDisplay('fiche');
                break;                           
            case 'validation':
                require 'controllers/validation.controller.php';
                validDisplay($currentstep);
                break;
            case 'final_step':
                require 'controllers/validation.controller.php';
                finalDisplay($currentstep);
                break;                
            case 'rcd':
                require 'controllers/rcd.controller.php';
                rcdDisplay($currentstep);
                break;                 
            case 'admin':
                require 'controllers/admin.controller.php';
                adminDisplay();
                break;
            case 'admin_settings':
                require 'controllers/admin.controller.php';
                adminSettingsDisplay();
                break;
            case 'admin_users':
                require 'controllers/admin.controller.php';
                adminUsersDisplay();
                break;
            case 'admin_assurances':
                require 'controllers/admin.controller.php';
                adminAssurancesDisplay();
                break;
            case 'admin_emails':
                require 'controllers/admin.controller.php';
                adminEmailsDisplay();
                break;
            case 'admin_tickets':
                require 'controllers/ticket.controller.php';
                adminTicketsDisplay();
                break;
            case 'faq':
                require 'controllers/faq.controller.php';
                faqDisplay();
                break;
            case 'admin_faq':
                require 'controllers/faq.controller.php';
                adminFaqDisplay();
                break;
            case 'ticket_create':
                require 'controllers/ticket.controller.php';
                ticketCreate();
                break;
            case 'logs':
                require 'controllers/LogController.php';
                $filters = [];
                if (!empty($_GET['DOID'])) $filters['DOID'] = $_GET['DOID'];
                if (!empty($_GET['user_id'])) $filters['user_id'] = $_GET['user_id'];
                if (!empty($_GET['date'])) $filters['date'] = $_GET['date'];
                if (!empty($_GET['table'])) $filters['table'] = $_GET['table'];
                $logs_per_page = 50;
                $current_page = max(1, (int)($_GET['p'] ?? 1));
                $logs_offset = ($current_page - 1) * $logs_per_page;
                $logs_total = countLogs($filters);
                $logs_total_pages = max(1, (int)ceil($logs_total / $logs_per_page));
                $logs = getLogs($filters, 'date_exec_log DESC, DOID DESC', $logs_per_page, $logs_offset);
                $title = 'Logs des échanges BDD';
                require 'views/header.view.php';
                require 'views/admin/admin_logs.view.php';
                require 'views/footer.view.php';
                break;

            case 'edit':
                require 'controllers/admin.controller.php';
                editDo($_GET['doid']);
                break;  
                

            /* USER Action */
            case 'login':
                login();
                break; 
            case 'logout':
                logout();
                break;                 
            case 'register':
                stepRegister();
                break;                 
            case 'passwordReminder':
                passwordReminder();
                break;                     
            case 'dashboard':
                if(empty($_SESSION['user_id'])){
                    login();
                }else{
                    displayDashboard();
                }                
                break;    
            case 'profil':
                displayProfil();
                break; 
            case 'do_historique':
                require_once 'models/do.model.php';
                header('Content-Type: application/json');
                if (!empty($_GET['doid']) && !empty($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin') {
                    $doid = (int)$_GET['doid'];
                    echo json_encode(getDoHistorique($doid));
                } else {
                    echo json_encode(['error' => 'Accès refusé']);
                }
                exit;

            case 'rcd_status':
                require_once 'models/rcd.model.php';
                header('Content-Type: application/json');
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin') {
                    $input = json_decode(file_get_contents('php://input'), true);
                    $rcd_id = (int)($input['rcd_id'] ?? 0);
                    $field = $input['field'] ?? '';
                    $status = (int)($input['status'] ?? -1);
                    $doid = (int)($input['doid'] ?? 0);
                    if ($rcd_id > 0 && $doid > 0 && updateRcdFileStatus($rcd_id, $field, $status, $doid)) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Paramètres invalides']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Accès refusé']);
                }
                exit;

            case 'rcd_status_bulk':
                require_once 'models/rcd.model.php';
                header('Content-Type: application/json');
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin') {
                    $input = json_decode(file_get_contents('php://input'), true);
                    $changes = $input['changes'] ?? [];
                    if (!is_array($changes) || empty($changes)) {
                        echo json_encode(['success' => false, 'error' => 'Aucun changement']);
                        exit;
                    }
                    $ok = 0;
                    foreach ($changes as $c) {
                        $rcd_id = (int)($c['rcd_id'] ?? 0);
                        $field = $c['field'] ?? '';
                        $status = (int)($c['status'] ?? -1);
                        $doid = (int)($c['doid'] ?? 0);
                        if ($rcd_id > 0 && $doid > 0 && updateRcdFileStatus($rcd_id, $field, $status, $doid)) {
                            $ok++;
                        }
                    }
                    echo json_encode(['success' => true, 'updated' => $ok]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Accès refusé']);
                }
                exit;

            case 'rcd_token':
                require_once 'models/rcd_token.model.php';
                header('Content-Type: application/json');
                if (!empty($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'admin') {
                    $doid = (int)($_GET['doid'] ?? 0);
                    if ($doid <= 0) {
                        echo json_encode(['success' => false, 'error' => 'DOID invalide']);
                        exit;
                    }
                    // Réutiliser un token actif ou en créer un nouveau
                    $existing = getActiveTokenForDoid($doid);
                    if ($existing) {
                        $token = $existing['token'];
                        $expires = $existing['expires_at'];
                    } else {
                        $token = createRcdUploadToken($doid, $_SESSION['user_id']);
                        $expires = date('Y-m-d H:i:s', strtotime('+7 days'));
                    }
                    if ($token) {
                        $url = buildUploadUrl($token);
                        echo json_encode(['success' => true, 'url' => $url, 'expires' => $expires]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Erreur lors de la génération']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Accès refusé']);
                }
                exit;

            default:
                throw new Exception ('Paramètre invalide !');
                break;
        }
    }else{
        //errorDisplay();
        require 'controllers/home.controller.php';
        homeDisplay('home');
    }

?>
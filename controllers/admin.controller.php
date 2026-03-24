<?php
    require "models/admin.model.php";
    require_once "models/do.model.php";
    require_once "models/user.model.php";
    require_once "models/entreprise.model.php";
    function infoAlerts($message, $type){

        switch ($type) {
            case 'error':
                $rtn = '<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">'.$message.'</span></div>';
                break;

            case 'success':
            default:
                $rtn = '<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">'.$message.'</span></div>';
                break;
        }
        return $rtn;
    }

    

    function adminDisplay(){
        $title = "Administration des demandes Dommage Ouvrage";
        $user_role = $_SESSION['user_role'] ?? 'user';

        // Traitements POST avec redirect (avant tout output HTML)
        if ($user_role === 'admin') {
            if (isset($_POST['update_do_status']) && isset($_POST['do_status_doid']) && isset($_POST['do_status_value'])) {
                $doid = (int)$_POST['do_status_doid'];
                $status = (int)$_POST['do_status_value'];
                updateDoStatus($doid, $status);
                $status_labels = [0 => 'En cours de création', 1 => 'En attente des documents', 2 => 'Validé (offre transmise)', 3 => 'Clôturé'];
                addDoHistorique($doid, 'Changement statut → ' . ($status_labels[$status] ?? $status), $_SESSION['user_id'] ?? null);
                header('Location: index.php?page=admin');
                exit;
            }

            if (isset($_POST['update_do_assurance']) && isset($_POST['do_assurance_doid'])) {
                $doid = (int)$_POST['do_assurance_doid'];
                $assurance_id = $_POST['do_assurance_value'] ?? null;
                updateDoAssurance($doid, $assurance_id);
                addDoHistorique($doid, 'Assurance mise à jour', $_SESSION['user_id'] ?? null);
                header('Location: index.php?page=admin');
                exit;
            }
        }

        require 'views/header.view.php';
        $dos = getListDO();
        require_once 'models/rcd.model.php';
        $rcd_stats = getRcdStatsAllDo();
        $assurances = getListAssurances();
        if($user_role === 'admin'){
            if(isset($_GET['deletedo'])){
                $infodelete = infoAlerts('suppression réalisée avec succès', 'success');
                deleteDo($_GET['deletedo']);
            }

            // Suppression de toutes les DO de test
            if (isset($_POST['delete_test_dos'])) {
                $nbDeleted = deleteAllTestDos();
                $infodelete = infoAlerts("$nbDeleted DO de test supprimée(s) avec succès", 'success');
            }

            // Gestion du lancement des tests automatiques
            if (isset($_GET['page']) && $_GET['page'] === 'admin' && isset($_GET['run_tests'])) {
                require 'views/admin/test_runner.view.php';
            } else {
                require 'views/admin/admin.view.php';
            }
        }else{
            require 'views/page-erreur.view.php';
        }
        require 'views/footer.view.php';
    }


    
    function editDo($doid){
        $title = "Edition de la demande Dommage Ouvrage n° ".$doid;
        loadDo($doid);

        ob_start();
        require 'views/admin/edit.view.php';
        //header("Location: index.php?page=step1&doid=".$_GET['doid']);

         
        $content = ob_get_clean();
        require("views/base.view.php");
    }

    function adminLogsDisplay() {
        require_once 'controllers/LogController.php';
        $logController = new LogController();
        $filters = [];
        if (!empty($_GET['DOID'])) $filters['DOID'] = $_GET['DOID'];
        if (!empty($_GET['user_id'])) $filters['user_id'] = $_GET['user_id'];
        if (!empty($_GET['date'])) $filters['date'] = $_GET['date'];
        if (!empty($_GET['table'])) $filters['table'] = $_GET['table'];
        $logs = $logController->getLogs($filters);
        $title = 'Logs des échanges BDD';
        require 'views/header.view.php';
        require 'views/admin/admin_logs.view.php';
        require 'views/footer.view.php';
    }

    function adminSettingsDisplay(){
        $title = "Administration — Paramètres";
        require 'views/header.view.php';
        $user_role = $_SESSION['user_role'] ?? 'user';
        if($user_role !== 'admin'){
            require 'views/page-erreur.view.php';
            require 'views/footer.view.php';
            return;
        }

        $settings_message = '';

        // Vider toutes les tables DO
        if (isset($_POST['truncate_form_tables'])) {
            if (truncateFormTables()) {
                $settings_message = infoAlerts('Toutes les tables DO ont été vidées avec succès.', 'success');
            } else {
                $settings_message = infoAlerts('Erreur lors du nettoyage des tables.', 'error');
            }
        }

        // Supprimer les DO de test
        if (isset($_POST['delete_test_dos'])) {
            $nbDeleted = deleteAllTestDos();
            $settings_message = infoAlerts("$nbDeleted DO de test supprimée(s) avec succès.", 'success');
        }

        require 'views/admin/admin_settings.view.php';
        require 'views/footer.view.php';
    }

    function adminUsersDisplay(){
        $title = "Administration — Utilisateurs";
        require 'views/header.view.php';
        $user_role = $_SESSION['user_role'] ?? 'user';
        if($user_role !== 'admin'){
            require 'views/page-erreur.view.php';
            require 'views/footer.view.php';
            return;
        }

        $users_message = '';

        // Ajouter un utilisateur
        if (isset($_POST['add_user'])) {
            $nom = trim($_POST['add_nom'] ?? '');
            $prenom = trim($_POST['add_prenom'] ?? '');
            $email = trim($_POST['add_email'] ?? '');
            $password = $_POST['add_password'] ?? '';
            $role = $_POST['add_role'] ?? 'user';
            if (!in_array($role, ['admin', 'collab', 'user'])) $role = 'user';
            $result = adminCreateUser($nom, $prenom, $email, $password, $role);
            if (is_int($result)) {
                $users_message = infoAlerts("Utilisateur créé avec succès (ID: $result).", 'success');
            } else {
                $users_message = infoAlerts($result, 'error');
            }
        }

        // Modifier un utilisateur
        if (isset($_POST['edit_user'])) {
            $uid = (int)($_POST['edit_user_id'] ?? 0);
            $nom = trim($_POST['edit_nom'] ?? '');
            $prenom = trim($_POST['edit_prenom'] ?? '');
            $email = trim($_POST['edit_email'] ?? '');
            $role = $_POST['edit_role'] ?? 'user';
            if (!in_array($role, ['admin', 'collab', 'user'])) $role = 'user';
            if ($uid > 0 && adminUpdateUser($uid, $nom, $prenom, $email, $role)) {
                $users_message = infoAlerts('Utilisateur modifié avec succès.', 'success');
            } else {
                $users_message = infoAlerts('Erreur lors de la modification.', 'error');
            }
        }

        // Réinitialiser mot de passe
        if (isset($_POST['reset_password_submit'])) {
            $uid = (int)($_POST['reset_user_id'] ?? 0);
            $pwd = $_POST['reset_password'] ?? '';
            $pwd_confirm = $_POST['reset_password_confirm'] ?? '';
            if ($pwd !== $pwd_confirm) {
                $users_message = infoAlerts('Les mots de passe ne correspondent pas.', 'error');
            } elseif (strlen($pwd) < 6) {
                $users_message = infoAlerts('Le mot de passe doit contenir au moins 6 caractères.', 'error');
            } elseif ($uid > 0 && adminResetPassword($uid, $pwd)) {
                $users_message = infoAlerts('Mot de passe réinitialisé avec succès.', 'success');
            } else {
                $users_message = infoAlerts('Erreur lors de la réinitialisation.', 'error');
            }
        }

        // Supprimer un utilisateur
        if (isset($_POST['delete_user_id'])) {
            $uid = (int)$_POST['delete_user_id'];
            if ($uid == $_SESSION['user_id']) {
                $users_message = infoAlerts('Vous ne pouvez pas supprimer votre propre compte.', 'error');
            } elseif ($uid > 0 && adminDeleteUser($uid)) {
                $users_message = infoAlerts('Utilisateur supprimé.', 'success');
            } else {
                $users_message = infoAlerts('Erreur lors de la suppression.', 'error');
            }
        }

        $users = getAllUsers();
        require 'views/admin/admin_users.view.php';
        require 'views/footer.view.php';
    }

    function adminAssurancesDisplay(){
        $title = "Administration — Compagnies d'assurance";
        $user_role = $_SESSION['user_role'] ?? 'user';
        if($user_role !== 'admin'){
            require 'views/header.view.php';
            require 'views/page-erreur.view.php';
            require 'views/footer.view.php';
            return;
        }

        $assurance_message = '';

        // Ajouter
        if (isset($_POST['add_assurance'])) {
            $nom = trim($_POST['add_nom'] ?? '');
            $logo = trim($_POST['add_logo'] ?? '');
            $active = isset($_POST['add_active']) ? 1 : 0;
            if ($nom === '') {
                $assurance_message = infoAlerts('Le nom est obligatoire.', 'error');
            } else {
                if (insertAssurance($nom, $logo, $active)) {
                    header('Location: index.php?page=admin_assurances&msg=added');
                    exit;
                } else {
                    $assurance_message = infoAlerts('Erreur lors de l\'ajout.', 'error');
                }
            }
        }

        // Modifier
        if (isset($_POST['edit_assurance'])) {
            $id = (int)($_POST['edit_id'] ?? 0);
            $nom = trim($_POST['edit_nom'] ?? '');
            $logo = trim($_POST['edit_logo'] ?? '');
            $active = isset($_POST['edit_active']) ? 1 : 0;
            if ($id > 0 && $nom !== '' && updateAssurance($id, $nom, $logo, $active)) {
                header('Location: index.php?page=admin_assurances&msg=updated');
                exit;
            } else {
                $assurance_message = infoAlerts('Erreur lors de la modification.', 'error');
            }
        }

        // Supprimer
        if (isset($_POST['delete_assurance_id'])) {
            $id = (int)$_POST['delete_assurance_id'];
            $result = deleteAssurance($id);
            if ($result === 'used') {
                $assurance_message = infoAlerts('Impossible de supprimer : cette assurance est utilisée par un ou plusieurs dossiers DO.', 'error');
            } elseif ($result) {
                header('Location: index.php?page=admin_assurances&msg=deleted');
                exit;
            } else {
                $assurance_message = infoAlerts('Erreur lors de la suppression.', 'error');
            }
        }

        // Messages flash via query string
        if (isset($_GET['msg'])) {
            $flashMsgs = ['added' => 'Assurance ajoutée avec succès.', 'updated' => 'Assurance modifiée avec succès.', 'deleted' => 'Assurance supprimée avec succès.'];
            if (isset($flashMsgs[$_GET['msg']])) $assurance_message = infoAlerts($flashMsgs[$_GET['msg']], 'success');
        }

        require 'views/header.view.php';
        $assurances = getAllAssurances();
        require 'views/admin/admin_assurances.view.php';
        require 'views/footer.view.php';
    }

    // ============================================================
    // GESTION DES EMAILS
    // ============================================================
    function adminEmailsDisplay(){
        require_once 'models/email.model.php';

        $user_role = $_SESSION['user_role'] ?? 'user';
        if($user_role !== 'admin'){
            $title = 'Accès refusé';
            require 'views/header.view.php';
            require 'views/page-erreur.view.php';
            require 'views/footer.view.php';
            return;
        }

        $email_message = '';

        // ---- Sauvegarder les paramètres email ----
        if (isset($_POST['save_email_settings'])) {
            saveEmailSettings($_POST);
            header('Location: index.php?page=admin_emails&msg=settings_saved');
            exit;
        }

        // ---- Ajouter un template ----
        if (isset($_POST['add_template'])) {
            $slug  = trim($_POST['add_slug'] ?? '');
            $nom   = trim($_POST['add_nom'] ?? '');
            $sujet = trim($_POST['add_sujet'] ?? '');
            $corps = $_POST['add_corps'] ?? '';
            $active = isset($_POST['add_active']) ? 1 : 0;
            if ($slug === '' || $nom === '' || $sujet === '') {
                $email_message = infoAlerts('Le slug, le nom et le sujet sont obligatoires.', 'error');
            } else {
                if (insertEmailTemplate($slug, $nom, $sujet, $corps, $active)) {
                    header('Location: index.php?page=admin_emails&msg=added');
                    exit;
                } else {
                    $email_message = infoAlerts('Erreur lors de l\'ajout (slug déjà existant ?).', 'error');
                }
            }
        }

        // ---- Modifier un template ----
        if (isset($_POST['edit_template'])) {
            $id    = (int)($_POST['edit_id'] ?? 0);
            $nom   = trim($_POST['edit_nom'] ?? '');
            $sujet = trim($_POST['edit_sujet'] ?? '');
            $corps = $_POST['edit_corps'] ?? '';
            $active = isset($_POST['edit_active']) ? 1 : 0;
            if ($id > 0 && $nom !== '' && $sujet !== '' && updateEmailTemplate($id, $nom, $sujet, $corps, $active)) {
                header('Location: index.php?page=admin_emails&msg=updated');
                exit;
            } else {
                $email_message = infoAlerts('Erreur lors de la modification.', 'error');
            }
        }

        // ---- Supprimer un template ----
        if (isset($_POST['delete_template_id'])) {
            $id = (int)$_POST['delete_template_id'];
            if (deleteEmailTemplate($id)) {
                header('Location: index.php?page=admin_emails&msg=deleted');
                exit;
            } else {
                $email_message = infoAlerts('Erreur lors de la suppression.', 'error');
            }
        }

        // Messages flash
        if (isset($_GET['msg'])) {
            $flashMsgs = [
                'settings_saved' => 'Paramètres email enregistrés avec succès.',
                'added'          => 'Template ajouté avec succès.',
                'updated'        => 'Template modifié avec succès.',
                'deleted'        => 'Template supprimé avec succès.',
            ];
            if (isset($flashMsgs[$_GET['msg']])) {
                $email_message = infoAlerts($flashMsgs[$_GET['msg']], 'success');
            }
        }

        $title = 'Administration — Gestion des emails';
        require 'views/header.view.php';
        $emailSettings = getEmailSettings();
        $emailTemplates = getAllEmailTemplates();
        require 'views/admin/admin_emails.view.php';
        require 'views/footer.view.php';
    }
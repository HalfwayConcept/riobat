<?php
require_once __DIR__ . '/connect.db.php';

// ============================================================
// EMAIL SETTINGS (clé/valeur)
// ============================================================

function getEmailSettings() {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM email_settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

function getEmailSetting($key) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("SELECT setting_value FROM email_settings WHERE setting_key = :k");
    $stmt->execute([':k' => $key]);
    $row = $stmt->fetch();
    return $row ? $row['setting_value'] : null;
}

function upsertEmailSetting($key, $value) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("INSERT INTO email_settings (setting_key, setting_value) VALUES (:k, :v)
                            ON DUPLICATE KEY UPDATE setting_value = :v2");
    return $stmt->execute([':k' => $key, ':v' => $value, ':v2' => $value]);
}

function saveEmailSettings($data) {
    $keys = ['from_name', 'from_email', 'reply_to', 'signature'];
    foreach ($keys as $k) {
        if (isset($data[$k])) {
            upsertEmailSetting($k, $data[$k]);
        }
    }
    return true;
}

// ============================================================
// EMAIL TEMPLATES (CRUD)
// ============================================================

function getAllEmailTemplates() {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->query("SELECT * FROM email_templates ORDER BY template_id ASC");
    return $stmt->fetchAll();
}

function getEmailTemplate($id) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE template_id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function getEmailTemplateBySlug($slug) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("SELECT * FROM email_templates WHERE slug = :slug");
    $stmt->execute([':slug' => $slug]);
    return $stmt->fetch();
}

function insertEmailTemplate($slug, $nom, $sujet, $corps, $active = 1) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("INSERT INTO email_templates (slug, nom, sujet, corps, active) VALUES (:slug, :nom, :sujet, :corps, :active)");
    return $stmt->execute([':slug' => $slug, ':nom' => $nom, ':sujet' => $sujet, ':corps' => $corps, ':active' => $active]);
}

function updateEmailTemplate($id, $nom, $sujet, $corps, $active) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("UPDATE email_templates SET nom = :nom, sujet = :sujet, corps = :corps, active = :active WHERE template_id = :id");
    return $stmt->execute([':nom' => $nom, ':sujet' => $sujet, ':corps' => $corps, ':active' => $active, ':id' => $id]);
}

function deleteEmailTemplate($id) {
    $pdo = $GLOBALS['pdo'];
    $stmt = $pdo->prepare("DELETE FROM email_templates WHERE template_id = :id");
    return $stmt->execute([':id' => $id]);
}

/**
 * Notifie les administrateurs et collaborateurs lorsqu'un dossier est validé.
 */
function sendDossierValidationAlert(int $doid, bool $isUpdate): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || $doid <= 0) {
        error_log("[riobat] Notification de validation impossible : DOID invalide.");
        return false;
    }

    $stmt = $pdo->query("SELECT email FROM utilisateur
                         WHERE role IN ('admin', 'collab')
                           AND email IS NOT NULL
                           AND email <> ''");
    $recipients = array_values(array_unique(array_filter(
        $stmt->fetchAll(PDO::FETCH_COLUMN),
        static function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
    )));
    if (empty($recipients)) {
        error_log("[riobat] Aucun destinataire admin/collab pour la validation du dossier $doid.");
        return false;
    }

    $settings = getEmailSettings();
    $fromName = trim((string)($settings['from_name'] ?? 'RIOBAT'));
    $fromEmail = trim((string)($settings['from_email'] ?? ''));
    $replyTo = trim((string)($settings['reply_to'] ?? ''));
    if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
        error_log("[riobat] Notification de validation non envoyée : adresse expéditeur invalide.");
        return false;
    }

    $action = $isUpdate ? 'mis à jour' : 'créé';
    $subject = "[RIOBAT] Dossier n°{$doid} {$action} et validé";
    $safeAction = htmlspecialchars($action, ENT_QUOTES, 'UTF-8');
    $safeDoid = htmlspecialchars((string)$doid, ENT_QUOTES, 'UTF-8');
    $signature = (string)($settings['signature'] ?? '');
    $message = "<html><body>"
        . "<p>Bonjour,</p>"
        . "<p>Le dossier <strong>n°{$safeDoid}</strong> vient d'être {$safeAction} lors de l'étape de validation.</p>"
        . "<p><a href=\"index.php?page=admin\">Accéder à l'administration</a></p>"
        . $signature
        . "</body></html>";

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . ($fromName !== '' ? '"' . addcslashes($fromName, '"\\') . '" ' : '') . '<' . $fromEmail . '>',
    ];
    if (filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }

    $allSent = true;
    foreach ($recipients as $recipient) {
        if (!mail($recipient, $subject, $message, implode("\r\n", $headers))) {
            error_log("[riobat] Échec d'envoi de la notification de validation du dossier $doid à $recipient.");
            $allSent = false;
        }
    }

    return $allSent;
}

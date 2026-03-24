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

<?php
require_once __DIR__ . '/connect.db.php';

/**
 * Génère un token d'upload RCD sécurisé (7 jours de validité).
 * Retourne le token brut (hex 64 chars).
 */
function createRcdUploadToken($doid, $created_by = null) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !$doid) return false;

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+7 days'));

    $stmt = $pdo->prepare('INSERT INTO rcd_upload_token (token, DOID, created_by, expires_at) VALUES (:token, :doid, :uid, :expires)');
    $stmt->execute([
        ':token' => $token,
        ':doid' => $doid,
        ':uid' => $created_by,
        ':expires' => $expires,
    ]);

    return $token;
}

/**
 * Valide un token : retourne les données (DOID, etc.) si valide, false sinon.
 */
function validateRcdUploadToken($token) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || empty($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) return false;

    $stmt = $pdo->prepare('SELECT * FROM rcd_upload_token WHERE token = :token AND expires_at > NOW() LIMIT 1');
    $stmt->execute([':token' => $token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: false;
}

/**
 * Marque le token comme utilisé (optionnel, pour tracking).
 */
function markTokenUsed($token) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $stmt = $pdo->prepare('UPDATE rcd_upload_token SET used_at = NOW() WHERE token = :token');
    return $stmt->execute([':token' => $token]);
}

/**
 * Récupère le token actif (non expiré) pour un DOID, ou null.
 */
function getActiveTokenForDoid($doid) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !$doid) return null;

    $stmt = $pdo->prepare('SELECT token, expires_at FROM rcd_upload_token WHERE DOID = :doid AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1');
    $stmt->execute([':doid' => $doid]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/**
 * Construit l'URL d'upload publique à partir d'un token.
 */
function buildUploadUrl($token) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $protocol . '://' . $host . $basePath . '/index.php?page=upload_rcd&token=' . $token;
}

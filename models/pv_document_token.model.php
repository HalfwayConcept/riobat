<?php
require_once __DIR__ . '/connect.db.php';

function createPvDocumentUploadToken(int $doid, ?int $createdBy = null): string|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || $doid <= 0) return false;

    $token = bin2hex(random_bytes(32));
    $stmt = $pdo->prepare('INSERT INTO pv_document_upload_token (token, DOID, created_by, expires_at) VALUES (:token, :doid, :created_by, DATE_ADD(NOW(), INTERVAL 7 DAY))');
    return $stmt->execute([':token' => $token, ':doid' => $doid, ':created_by' => $createdBy]) ? $token : false;
}

function validatePvDocumentUploadToken(string $token): array|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !preg_match('/^[a-f0-9]{64}$/', $token)) return false;

    $stmt = $pdo->prepare('SELECT * FROM pv_document_upload_token WHERE token = :token AND expires_at > NOW() LIMIT 1');
    $stmt->execute([':token' => $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

function markPvDocumentUploadTokenUsed(string $token): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    return $pdo->prepare('UPDATE pv_document_upload_token SET used_at = NOW() WHERE token = :token')->execute([':token' => $token]);
}

function buildPvDocumentUploadUrl(string $token): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $protocol . '://' . $host . $basePath . '/index.php?page=upload_pv_documents&token=' . $token;
}

<?php
// models/moa_qualite.model.php
require_once 'connect.db.php';

function getAllMoaQualites() {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) {
        $sql = "SELECT * FROM moa_qualite ORDER BY label";
        $res = mysqli_query($GLOBALS['conn'], $sql);
        $result = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $result[] = $row;
        }
        return $result;
    }
    $sql = "SELECT * FROM moa_qualite ORDER BY label";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $homersekletertek = trim($_POST['homersekletertek']);
    $datum = trim($_POST['datum']);
    $varosid = (int)$_POST['varosid'];

    if (empty($homersekletertek) || empty($datum) || $varosid <= 0 || !is_numeric($homersekletertek)) {
        die("Hiba történt: érvénytelen adat.");
    }

    if ($homersekletertek < -10 || $homersekletertek > 50) {
        die("Hiba történt: a hőmérséklet kívül esik a megengedett tartományon (-10°C - 50°C).");
    }

    $db = getDb();
    $stmt = $db->prepare("SELECT id FROM varos WHERE id = :varosid");
    $stmt->execute(['varosid' => $varosid]);

    if ($stmt->rowCount() === 0) {
        die("A város nem létezik.");
    }

    $stmt = $db->prepare("INSERT INTO homerseklet (datum, homersekletertek, varosid) VALUES (:datum, :homersekletertek, :varosid)");
    $stmt->execute([
        'varosid' => $varosid,
        'datum' => $datum,
        'homersekletertek' => $homersekletertek
    ]);

    header("Location: index.php");
    exit;
}
?>

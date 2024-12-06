<?php
    require 'db.php';
    session_start();
    $db = getDb();
    $result = $db->query("SELECT
    varos.id AS varos_id,
    varos.nev,
    varos.lakossag,
    varos.atlaghomerseklet
    FROM varos
    LEFT JOIN homerseklet ON varos.id = homerseklet.varosid
    GROUP BY varos.id, varos.nev, varos.lakossag, varos.atlaghomerseklet
    ");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Időjárás</title>
</head>
<body>
    <h id = "cim">Időjárás</h>
    <p id = "neptun">Séra Dávid, U7JZ93</p>
    <div id ="tartalom">
        <table id = "table">
            <tr id="fejlec">
                <td>Név</td>
                <td>Lakosság</td>
                <td>Átlaghőmérséklet</td>
            </tr>
            <?php while($row=$result->fetchObject()):?>
            <tr>
                <td><?=$row->nev?></td>
                <td><?=$row->lakossag?>millió fő</td>
                <td><?=$row->atlaghomerseklet?>°C</td>
            </tr>
            <tr>
                <td colspan="3">
                    <ul>
                        <?php $datapont = $db->query("SELECT
                        datum,
                        homersekletertek
                        FROM homerseklet
                        WHERE varosid = {$row->varos_id}
                        ");
                        $data_count = $datapont->rowCount();?>
                        <?php if($data_count==0):?>
                            <p id="datamissing" colspan="3">Nincs adat</p>
                        <?php else:?>
                            <?php while($data=$datapont->fetchObject()):?>
                                    <li><?=$data->datum?>: <?=$data->homersekletertek?>°C</li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <div id = "naplo">
            <p id="naplocim">Hőmérséklet naplózása</p>
            <div class="search-bar">
                <div id="varoskeres">
                    <lable for="varos" id ="varoslable">Város:</lable>
                    <select id="varos" name="varos">
                        <option value="london">London</option>
                        <option value="parizs">Párizs</option>
                        <option value="budapest">Budapest</option>
                    </select>
                </div>
                <div id="datumkeres">
                <lable for="datum" id ="datumlable">Dátum:</lable>
                <input type="date" id="datum">
                </div>
                <div id="homersekletkeres">
                <lable for="homerseklet" id ="homersekletlable">Hőmérséklet:</lable>
                <input type="text" id="homerseklet">
                <div><button onclick="">Küldés</button></div>
                </div>
            </div>
        </div>
    </div>
</body>
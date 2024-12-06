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
    ORDER BY varos.lakossag DESC
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
                <?php if($row->lakossag > 1):?>
                <tr>
                    <td><?=$row->nev?></td>
                    <td><?=$row->lakossag?>millió fő</td>
                    <?php $average = $db->query("SELECT IFNULL(AVG(homersekletertek), 0.00) AS atlag FROM homerseklet WHERE varosid = {$row->varos_id}");
                    $average_data = $average->fetch(PDO::FETCH_ASSOC);?>
                    <td><?=number_format($average_data['atlag'], 2)?>°C</td>
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
                <?php endif;?>
            <?php endwhile; ?>
        </table>
        <div id="naplo">
            <p id="naplocim">Hőmérséklet naplózása</p>
            <form method="POST" action="log.php">
                <div class="search-bar">
                    <div id="varoskeres">
                        <label for="varos" id="varoslable">Város:</label>
                        <select id="varos" name="varosid" required>
                            <?php
                                $varos = $db->query("SELECT id, nev FROM varos");
                                while ($varosoption = $varos->fetchObject()):
                            ?>
                                <option value="<?= $varosoption->id ?>"><?= $varosoption->nev ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div id="datumkeres">
                        <label for="datum" id="datumlable">Dátum:</label>
                        <input type="date" id="datum" name="datum" required>
                    </div>
                    <div id="homersekletkeres">
                        <label for="homerseklet" id="homersekletlable">Hőmérséklet:</label>
                        <input type="number" id="homerseklet" name="homersekletertek" required>
                    </div>
                    <div>
                        <button type="submit">Küldés</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
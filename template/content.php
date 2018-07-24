<?php

if (isset($_POST['bsearch']))
{
    $words = $_POST['words'];
    $results = search($words);
}
elseif(isset($_POST['bfilter']))
{
    $filter['words'] = $_POST['words'];
    $words = $filter['words'];
    $filter['resourses'] = $_POST['resourses'];
    $resours_id = $filter['resourses'];
    $filter['regions'] = $_POST['regions'];
    $region_id = $filter['regions'];
    $filter['sities'] = $_POST['sities'];
    $sities_id = $filter['sities'];
    $filter['stat_res'] = $_POST['stat_res'];
    $status_id = $filter['stat_res'];
    $filter['quality'] = $_POST['quality'];
    $quality_id = $filter['quality'];
    $results = filter($filter);
}
$resours = $Db->get_select('resourses');
$regions = $Db->get_select('regions');
$sities = $Db->get_select('sities');
$stat_res = $Db->get_select('status_resources');
$quality = $Db->get_select('quality');

?>
    <div class="sidebar">
        <form name="search" action="" method="post" >
         <div class="d3">
             <input type="text" name="words" value="<?=(!empty($words) ? $words : '')?>" placeholder="Поиск по базе..." />
             <button type="submit" name="bsearch" />
         </div>
         <div class="filter-list">
             </select>
             <div class="form-row">
                 <div class="form-group col-md-2">
             <label for="regions">Регион</label>
             <select name="regions" id="regions">
                 <option value=""></option>
                 <?php foreach ($regions as $val)
                 {
                     ?>
                     <option value="<?=$val['region_id']?>"<?=($region_id == $val['region_id'] ? 'selected': '')?>><?=$val['region_name']?></option>
                     <?php
                 }
                 ?>
             </select>
            <label for="sities">Город</label>
            <select name="sities" id="sities">
                <option value=""></option>
                <?php foreach ($sities as $val)
                {
                    ?>
                    <option value="<?=$val['sities_id']?>" <?=($sities_id == $val['sities_id'] ? 'selected': '')?>><?=$val['sities_name']?></option>
                    <?php
                }
                ?>
            </select>
                <label for="stat_res">Статус ресурса</label>
                <select name="stat_res" id="stat_res">
                    <option value=""></option>
                    <?php foreach ($stat_res as $val)
                    {
                        ?>
                        <option value="<?=$val['status_id']?>" <?=($status_id == $val['status_id'] ? 'selected': '')?>><?=$val['status_name']?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="quality">Качество</label>
                <select name="quality" id="quality">
                    <option value=""></option>
                    <?php foreach ($quality as $val)
                    {
                        ?>
                        <option value="<?=$val['quality_id']?>"<?=($quality_id == $val['quality_id'] ? 'selected': '')?>><?=$val['quality_type']?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="resours">Ресурс</label>
                <select name="resours" id="resours">
                    <option value=""></option>
                    <?php foreach ($resours as $val)
                     {
                         ?>
                         <option value="<?=$val['region_id']?>"<?=($resours_id == $val['resours_id'] ? 'selected': '')?>><?=$val['resourses_name']?></option>
                         <?php
                     }
                     ?>
                </select>
                </div>
                </div>
                <button type="button" name="reset_filter">сбросить фильтр</button>
                <button type="submit" name="bfilter">фильтровать</button>
                </div>
            </form>
        </div>

<?php
if (isset($results) && count($results) > 0)
{
    ?>
    <h1>Результаты поиска</h1>
    <?php
if ($results === false)
    {
        ?>
        Задан пустой запрос
        <?php
    }
if (count($results) == 0)
    {
        ?>
        Поиск не дал результатов
        <?php
    }
    else
    {
        ?>
        <table border='1'>
                <tr>
                    <th></th>
                    <th>Реcурс</th>
                    <th>Город</th>
                    <th>Регион</th>
                    <th>Статус</th>
                    <th>Качество</th>
                    <th>Количество</th>
                </tr>
            <?php
        for ($i = 0; $i < count($results); $i++)
        {
            ?>
                <tr>
                    <td><img src="<?=$results[$i]["them_img"]?>"/></td>
                    <td><a href=/?r=resourses&id=<?=$results[$i]["id"]?>><?=$results[$i]["resourses_name"]?></td>
                    <td><?=$results[$i]["sities_name"]?></td>
                    <td><?=$results[$i]["region_name"]?></td>
                    <td><?=$results[$i]["status_name"]?></td>
                    <td><?=$results[$i]["quality_type"]?></td>
                    <td><?=$results[$i]["items"]?>
                </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }
}
?>


<?php
    /*$res = getQuery("SELECT r.resourses_name, s.sities_name, re.region_name, q.quality_type, sr.status_name, er.`items`, u.counts
                        FROM `existence_resources` as er
                        join quality as q on q.quality_id = er.`quality_id`
                        join resourses as r on r.resours_id = er.`resourses_id`
                        JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
                        JOIN sities as s on s.sities_id = er.`sities_id`
                        JOIN regions as re on re.region_id = s.region_id
                        JOIN units as u on u.units_id = er.units_id ");
    ?>
    <table border='1'>
        <tr>
            <th>Реcурс</th>
            <th>Город</th>
            <th>Регион</th>
            <th>Статус</th>
            <th>Качество</th>
            <th>Количество</th>
        </tr>
    <?php
    foreach ($res as $val)
    {
    ?>
        <tr>
            <td><?=$val['resourses_name']?></td>
            <td><?=$val['sities_name']?></td>
            <td><?=$val['region_name']?></td>
            <td><?=$val['status_name']?></td>
            <td><?=$val['quality_type']?></td>
            <td><?=$val['counts']?></td>
        </tr>
    <?php
    }
    ?>
    </table>

<?php


    /*$mysqli = new mysqli("localhost", "root", "", "mytest");

    $mysqli->query("INSERT INTO `test` (`id`, `name`, `age`, `sex`) VALUES (NULL, 'Семен', '40', 'муж');");
    $mysqli->close();


    $hostname = 'localhost';
    $username = 'root';
    $passwordname = '';
    $basename = 'task';
    $conn = new mysqli($hostname, $username, $passwordname, $basename) or die       ('Невозможно открыть базу');
    $sql = "SELECT * FROM `locations`";
    $result = $conn->query($sql);

    echo "person_location_id " . "   " . " location";
    while ($row = $result->fetch_assoc())
    {
        echo "<br/>".$row['person_location_id'];
        echo "    " . $row['name'];
    }*/
/*

$query = 'SELECT * FROM `sities`, where `sities_name` LIKE "%' . $words . '%"';

    $mysqli = new mysqli('127.0.0.1', 'root', '', 'mytest');

    // О нет!! переменная connect_errno существует, а это значит, что соединение не было успешным!
    if ($mysqli->connect_errno) {
        echo "Извините, возникла проблема на сайте";
        echo "Ошибка: Не удалсь создать соединение с базой MySQL и вот почему: \n";
        echo "Номер_ошибки: " . $mysqli->connect_errno . "\n";
        echo "Ошибка: " . $mysqli->connect_error . "\n";
        exit;
    }

    $sql = "SELECT * FROM test";
    if (!$result = $mysqli->query($sql)) {
        echo "Извините, возникла проблема в работе сайта.";
        echo "Ошибка: Наш запрос не удался и вот почему: \n";
        echo "Запрос: " . $sql . "\n";
        echo "Номер_ошибки: " . $mysqli->errno . "\n";
        echo "Ошибка: " . $mysqli->error . "\n";
        exit;
    }

    if ($result->num_rows === 0) {
        echo "Мы не смогли найти совпадение для $aid, простите. Пожалуйста, попробуйте еще раз.";
        exit;
    }

    echo "<table>\n";
    while ($actor = $result->fetch_assoc()) {
        echo "\t<tr>\n";
        foreach ($actor as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
    }
    echo "</table>\n";

    $result->free();
    $mysqli->close();

    foreach (glob("inc/*.php") as $filename) {
        echo "$filename размер " . filesize($filename) . "<br>";
    }


    $lines = file('G:\Programs\Open_Server\OSPanel\domains\mysite\css\style.css');
    foreach ($lines as $line_num => $line) {
        echo "Строка #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
    }*/
    ?>

<?php

    $res = $Db->getQuery("SELECT r.resourses_name, s.sities_name, re.region_name, q.quality_type, sr.status_name, er.`items`, u.counts, r.them_img 
                        FROM `existence_resources` as er
                        JOIN quality as q on q.quality_id = er.`quality_id`
                        JOIN resourses as r on r.resours_id = er.`resourses_id`
                        JOIN resourses_pict as rp on rp.existence_resources_id = er.`id`
                        JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
                        JOIN sities as s on s.sities_id = er.`sities_id`
                        JOIN regions as re on re.region_id = s.region_id
                        JOIN units as u on u.units_id = er.units_id");
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
            <th>Измерение</th>
        </tr>
        <?php
        foreach ($res as $val)
        {
            ?>
            <tr>
                <td><img src="<?=$val['them_img']?>"/></td>
                <td><?=$val['resourses_name']?></td>
                <td><?=$val['sities_name']?></td>
                <td><?=$val['region_name']?></td>
                <td><?=$val['status_name']?></td>
                <td><?=$val['quality_type']?></td>
                <td><?=$val['items']?></td>
                <td><?=$val['counts']?></td>
            </tr>
            <?php
        }
        ?>
    </table>

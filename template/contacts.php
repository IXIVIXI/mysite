
<div class="contacts">
    <div class="gazprom">
        <h1>Газпром</h1>
        <p>телефон: 333-33-33</p>
    </div>
    <div class="rosneft">
        <h2>Роснефть</h2>
        <p>телефон: 444-44-44</p>
    </div>
    <div class="almaz">
        <h3>Росс-Алмаз</h3>
        <p>телефон: 555-55-55</p>
    </div>
</div>

<?php

$s = 'SELECT * FROM `existence_resources` AS er 
              JOIN quality as q on q.quality_id = er.`quality_id`
              JOIN resourses as r on r.resours_id = er.`resourses_id`
              JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
              JOIN sities as s on s.sities_id = er.`sities_id`
              JOIN regions as re on re.region_id = s.region_id
              JOIN units as u on u.units_id = er.units_id
              where 1 = 1';
$res = $Db->getQuery($s);
$res = $Db->getQuery($s);
var_dump($res);


?>
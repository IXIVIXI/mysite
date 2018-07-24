<?php


function getConf($name)
{
    return include '/config/'.$name.'.php';
}


function search($words)
{
    $words = htmlspecialchars($words);
    $query = 'SELECT * FROM `existence_resources` AS er 
              JOIN quality as q on q.quality_id = er.`quality_id`
              JOIN resourses as r on r.resours_id = er.`resourses_id`
              JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
              JOIN sities as s on s.sities_id = er.`sities_id`
              JOIN regions as re on re.region_id = s.region_id
              JOIN units as u on u.units_id = er.units_id
              where 1 = 1 ';
    if(!empty($words))
    {
        $query .= ' and r.`resourses_name` LIKE "%' . $words . '%"';
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli("localhost", "root", "", "russian_resourses");
    if ($mysqli->connect_errno)
    {
        echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
    }
    $result_set = $mysqli->query($query);
    $i = 0;
    while ($row = $result_set->fetch_assoc())
    {
        $results[$i] = $row;
        $i++;
    }
    $mysqli->close();
    return $results;
}

function filter($filter)
{
    $words = htmlspecialchars($filter['words']);
    $query = 'SELECT * FROM `existence_resources` AS er 
              JOIN quality as q on q.quality_id = er.`quality_id`
              JOIN resourses as r on r.resours_id = er.`resourses_id`
              JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
              JOIN sities as s on s.sities_id = er.`sities_id`
              JOIN regions as re on re.region_id = s.region_id
              JOIN units as u on u.units_id = er.units_id
              where 1 = 1 ';
    if(!empty($filter['regions']))
    {
        $query .= ' and s.`region_id` = "' . $filter['regions'] . '"';
    }
    if(!empty($filter['sities']))
    {
        $query .= ' and s.`sities_id` = "' . $filter['sities'] . '"';
    }
    if(!empty($filter['stat_res']))
    {
        $query .= ' and sr.`status_id` = "' . $filter['stat_res'] . '"';
    }
    if(!empty($filter['quality']))
    {
        $query .= ' and q.`quality_id` = "' . $filter['quality'] . '"';
    }
    if(!empty($words))
    {
        $query .= ' and r.`resourses_name` LIKE "%' . $words . '%"';
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli("localhost", "root", "", "russian_resourses");
    if ($mysqli->connect_errno)
    {
        echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
    }
    $result_set = $mysqli->query($query);
    $i = 0;
    while ($row = $result_set->fetch_assoc())
    {
        $results[$i] = $row;
        $i++;
    }
    $mysqli->close();
    return $results;
}


    function test_res($test, $new_res)
    {
        $res = false;
        foreach ($test as $val)
        {
            /*
            foreach ($val as $value)
            {
                if($new_res == $value)
                {
                    echo "<br/>Запись не возможна - Ресурс уже существует<br/>";
                    $res = true;
                    break;
                }
            }
            */
            if (in_array($new_res, $val))
            {
                //var_dump($val);
                echo "<br/>Запись не возможна - Ресурс уже существует<br/>";
                $res = true;
                break;
            }
        }
        return $res;
    }
?>



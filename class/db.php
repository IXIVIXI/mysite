<?php

Class Db
{
    private $instans;

    public function __construct()//Отлажено
    {
        $db = include '/config/db.php';
        $this->instans = new mysqli($db['host'], $db['user'], $db['password'], $db['dbname']);
    }

    public function __destruct()//Отлажено
    {
        $this->instans->close();
    }

    public function getQuery($sql)//Отлажено
    {
        $resutl = array();
        $res = $this->instans->query($sql);
        if($res) {
            while ($row = $res->fetch_assoc()) {
                $resutl[] = $row;
            }
        }
        return $resutl;
    }

    public function getQueryOne($sql)//Отлажено
    {
        $result  = array();
        $res = $this->instans->query($sql);
        if ($res && $row = $res->fetch_assoc())
        {
            $result = $row;
        }
        return $result;
    }

    public function get_content($id)//Отлажено
    {
        $result = array();
        $query = 'SELECT * FROM `existence_resources` AS er 
              JOIN quality as q on q.quality_id = er.`quality_id`
              JOIN resourses as r on r.resours_id = er.`resourses_id`
              JOIN resurs_description as rd on rd.description_id = r.`resours_description_id`
              JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
              JOIN sities as s on s.sities_id = er.`sities_id`
              JOIN regions as re on re.region_id = s.region_id
              JOIN units as u on u.units_id = er.units_id
              where er.id = '.(int)$id;
        if ($row = $this->getQueryOne($query))
        {
            $result['data'] = $row;
            $query_img = 'SELECT * FROM `resourses_pict` where existence_resources_id = '.(int)$id;
            if($row_img = $this->getQuery($query_img))
            {
                $result['img'] = $row_img;
            }
        }
        return $result;
    }

    public function get_select($table)//Отлажено
    {
        $results = array();
        $query = 'SELECT * FROM '.$table;
        $mysqli = $this->instans;
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
        return $results;
    }

    public function img_add_func($img_url, $pict_id)//Отлажено
    {
        $res = false;
        if($img_url != "")
        {
            $mysqli = $this->instans;
            if (!$mysqli->connect_errno)
            {
                $res = $mysqli->query("INSERT INTO resourses_pict ( pict_url, existence_resources_id) VALUES (('" . $img_url . "'),('" . $pict_id. "'))");
            }
        }
        return $res;
    }

    public function add_info_table($table_name, $arr_res)//Отлажено
    { //global $res_ex_id;

        $fields = array_keys($arr_res);
        $values = array_values($arr_res);
        echo "INSERT INTO ".$table_name." ( ".implode(',', $fields)." ) VALUES (" .implode(',', $values). ");";
        $res = $this->instans->query("INSERT INTO ".$table_name." ( ".implode(',', $fields)." ) VALUES (" .implode(',', $values). ");");
        $res_ex_id = ($this->instans->insert_id);

        return array(
            'res' => $res,
            'ex_id' => $res_ex_id
        );
    }

    public function get_info_res($new_res)//Отлажено
    {
        $res = false;
        $mysqli = $this->instans;
        if (!$mysqli->connect_errno)
        {
            $res = $mysqli->query("INSERT INTO resourses (resourses_name) VALUES ('" . $new_res . "')");
            if(!$res)
            {
                if($mysqli->errno == 1062) {
                    throw new Exception("Произошла ошибка, запись существует");
                }
                else{
                    throw new Exception("Произошла ошибка");
                }
            }
        }
        return $res;
    }
}

$Db = new Db();

?>
<?php
$res = $Db->getQuery("SELECT r.resourses_name, s.sities_name, re.region_name, q.quality_type, sr.status_name, er.`items`, u.counts 
                        FROM `existence_resources` as er
                        JOIN quality as q on q.quality_id = er.`quality_id`
                        JOIN resourses as r on r.resours_id = er.`resourses_id`
                        JOIN status_resources as sr on sr.status_id = er.`status_resourses_id`
                        JOIN sities as s on s.sities_id = er.`sities_id`
                        JOIN regions as re on re.region_id = s.region_id
                        JOIN units as u on u.units_id = er.units_id ");

    $res_resourses = $Db->getQuery("SELECT * FROM resourses order by resours_id");
    $res_sities = $Db->getQuery("SELECT * FROM sities order by sities_id");
    $res_region_name = $Db->getQuery("SELECT * FROM regions order by region_id");
    $res_status_name = $Db->getQuery( "SELECT * FROM status_resources order by status_id");
    $res_quality_name = $Db->getQuery( "SELECT * FROM quality order by quality_id");
    $res_units = $Db->getQuery( "SELECT * FROM units order by units_id");
    ?>
<form enctype="multipart/form-data" method="post" name="forma" class="forma_add_resourses">
    <fieldset>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="resourses_name">Ресурс:</label>
                <select class="form-control" name="resourses_name" id="resourses_name">
                    <?php if(isset($res_resourses)){ ?>
                        <?php foreach ($res_resourses as $val){ ?>
                            <option value="<?=$val['resours_id']?>"><?=$val['resourses_name']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="sities_name">Город:</label>
                <select class="form-control" name="sities_name" id="sities_name">
                    <?php if(isset($res_sities)){ ?>
                        <?php foreach ($res_sities as $val){ ?>
                            <option value="<?=$val['sities_id']?>"><?=$val['sities_name']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="region_name">Регион:</label>
                <select class="form-control" name="region_name" id="region_name">
                    <?php if(isset($res_region_name)){ ?>
                        <?php foreach ($res_region_name as $val){ ?>
                            <option value="<?=$val['region_id']?>"><?=$val['region_name']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="status_name">Статус:</label>
                <select class="form-control" name="status_name" id="status_name">
                    <?php if(isset($res_status_name)){ ?>
                        <?php foreach ($res_status_name as $val){ ?>
                            <option value="<?=$val['status_id']?>"><?=$val['status_name']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="quality_type">Качество:</label>
                <select class="form-control" name="quality_type" id="quality_type">
                    <?php if(isset($res_quality_name)){ ?>
                        <?php foreach ($res_quality_name as $val){ ?>
                            <option value="<?=$val['quality_id']?>"><?=$val['quality_type']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <label for="counts">Количество</label>
            <input name="counts" type="text">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="units">Измерение:</label>
                <select class="form-control" name="units" id="units">
                    <?php if(isset($res_units)){ ?>
                        <?php foreach ($res_units as $val){ ?>
                            <option value="<?=$val['units_id']?>"><?=$val['counts']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label for="resourses_pict">Загрузка фото</label>
        <input type="file" name="res_pict" accept="image/*">

        <input type="hidden" name="act" value="add_resours"/>
        <fieldset>
            <input id="submit" type="submit" class="btn" value="Отправить данные">
        </fieldset>
    </fieldset>
</form>

<?php
//var_dump($_FILES['res_pict']['tmp_name']);

$path = 'img/img_for_resurs/';
$tmp_path = 'tmp/';
$size = 1024000;


if(isset($_POST['act'])) {
    $post = $_POST;
    $Files = $_FILES;
    $action = new Action($Db);
    $act = $post['act'];
    echo $action->$act('existence_resources', $post, $Files);
}


/*
if(isset($_POST['act'])) {
    if ($_POST['act'] == 'add') {
        try
        {
            $res_ex_id = $Db->add_info_table(array
            (
                "res" => (int)$_POST['resourses_name'],
                "siti" => (int)$_POST['sities_name'],
                "stat" => (int)$_POST['status_name'],
                "qual" => (int)$_POST['quality_type'],
                "count" => (float)$_POST['counts'],
                "unit" => (int)$_POST['units']
            ));
            //var_dump( $mysqli->insert_id);
            //var_dump(['ex_id']);
            //var_dump($res_ex_id);
            if($res)
            {
                if (isset($_FILES['res_pict']))
                {
                    if((int)$_FILES['res_pict']['size'] < $size)
                    {
                        if (move_uploaded_file($_FILES['res_pict']['tmp_name'], $path . $_FILES['res_pict']['name']))
                        {
                            $res = $Db->img_add_func($path . $_FILES['res_pict']['name'], $res_ex_id['ex_id']);
                            if($res)
                            {
                                $msg = '<span class="success-msg">запись добавлена</span>';
                            }
                            else
                            {
                                throw new Exception('запись добавлена, но картинки не загружены - ошибка добавления в базу');
                            }
                        }
                        else
                        {
                            throw new Exception('запись добавлена, но картинки не загружены - не удалось скопировать фаил');
                        }
                    }
                    else
                    {
                        throw new Exception('запись добавлена, но картинки не загружены - большой файл');
                    }
                }
                else
                {
                    throw new Exception('запись добавлена, но картинки не загружены');
                }
            }
            else
            {
                throw new Exception('запись не добавлена');
            }
        }
        catch (Exception $e)
        {
            $msg = '<span class="error-msg">'.($e->getMessage()).'</span>';
        }
    }
    elseif ($_POST['act'] == 'edit') {

    }
}

?>
<?php if(isset($msg)) {?>
    <p><?=$msg?></p>
<?php }
*/

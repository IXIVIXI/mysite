<?php

$results = $Db->get_content($id);

//$imgs = get_img($id);


if (count($results) == 0 || count($results['data']) == 0)
{
    ?>
    Страница с ресурсом не найдена
    <?php
}
else
{
    var_dump($results['img']);
    ?>
    <div><img src="<?=$results['data']["them_img"]?>"/></div>
    <div><?=$results['data']["resourses_name"]?></div>
    <div><img src="<?=$results['data']["pict_url"]?>"/></div>
    <div><?=$results['data']["description_text"]?></div>
    <?php
}
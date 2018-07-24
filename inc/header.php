<?php
$menu = getConf('menu');

$cur_url = $_SERVER['REQUEST_URI']; //Содержит адрес директории
$urls = explode('/', $cur_url); //разбивает строку на части по индефикатору '/' записывает в массив
$crumbs = array();//создаем пустой массив

if(!empty($urls) && $cur_url != '/')//если $urls не пустой и $curl_url не равен '/'
{
    foreach($urls as $key => $value)//перебераем массива
    {
        $prev_urls = array();//создаем пустой массив
        for ($i = 0; $i <= $key; $i++) //цикл столько раз сколько у нас ключей
        {
            $prev_urls[] = $urls[$i];//заполняем новый массив разбитым на части запросом
        }
        if ($key == count($urls) -1)//если это последний элемент массива
        {
            $crumbs[$key]['url'] = '';//последний элемент помещаем в массив $crambs, забиваем пустым значением
        }
        elseif (!empty($prev_urls))//если свежесозданный массив не пустой
        {
            $crumbs[$key]['url'] = count($prev_urls) >1 ? explode('/', $prev_urls) : '/';
        }
        switch($value)//цикл для подбора совпадения
        {
            case 'contacts' : $crumbs[$key]['text'] = 'Контакты';
                break;
            case '?r=add_info_mysql' : $crumbs[$key]['text'] = 'Добавить';
                break;
            case '?r=table_resurs' : $crumbs[$key]['text'] = 'Таблица';
                break;
            case '?r=contacts' : $crumbs[$key]['text'] = 'Контакты';
                break;
            case '?r=resourses&id=92' : $crumbs[$key]['text'] = 'Ресурс';
                break;
            case '?r=info_resours' : $crumbs[$key]['text'] = 'Ресурс инфо';
                break;
            default : $crumbs[$key]['text'] = 'Главная страница'; //если не найдено совпадений
                break;
        }
    }
}
?>
    <img class="logo" src="/img/logo13.png">
<header class="container">
    <nav class="top-menu">
            <ul class="menu-main">
                <?php foreach ($menu as $val)
                {
                ?>
                    <li><a class="aa" href="<?=$val['link']?>"><?=$val['title']?></a></li>
                <?php
                }?>
        </ul>
    </nav>
</header>

<?php if (!empty($crumbs)) { ?>
        <ul class="breadcrumb">
            <?php foreach ($crumbs as $item) { ?>
                <?php if (isset($item)) { ?>
                    <li>
                        <?php if (!empty($item['url'])) { ?>
                            <a href="<?php echo $item['url'] ?>"><?php echo $item['text'] ?></a>
                        <?php } else { ?>
                            <?php echo $item['text'] ?>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
<?php } ?>



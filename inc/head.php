<?php
$main = getConf('main');
?>
<head>
    <link rel="stylesheet" href="css\font-awesome\css\font-awesome.min.css">
    <meta http-equiv="content-type" content="text/html; <?=$main['charset']?>">
    <meta name="keywords" content=<?=$main['title_site']?>>
    <meta name="title" content="Мой сайт">
    <meta name="description" content="">
    <title><?=$main['title_site']?></title>
    <?php
    if(isset($main['js']) && is_array($main['js']))
    {
        foreach ($main['js'] as $val)
        {
            ?>
            <script src="<?=$val?>"></script>
            <?php
        }
    }

    if(isset($main['css']) && is_array($main['css']))
    {
        foreach ($main['css'] as $val)
        {
            ?>
            <link rel="stylesheet" href="<?=$val?>">
            <?php
        }
    }
    ?>

</head>
<div class="container main">
    <?php
    $main = getConf('main');
    $route = isset($_GET['r']) ? $_GET['r'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    if(empty($route))
    {
        $route = 'content';
    }
    elseif(!in_array($route, $main['route'])) {
       $route = '404';
    }
    include_once '/template/' . $route . '.php';
    ?>
</div>

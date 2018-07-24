

<form enctype="multipart/form-data" method="post" name="forma" class="form_add_res">
    <label for="counts">Название ресурса</label>
    <input name="name_res" type="text">
    <input type="hidden" name="act2" value="add_name_res"/>
    <fieldset>
        <input id="submit" type="submit" class="btn" value="Отправить данные">
    </fieldset>
</form>
<?php

if (isset($_POST['name_res']))
{
    $post = $_POST['name_res'];
    $db = $Db;
    $name_res = new resur_new;
    $name_res->add_res($post, $db);
}
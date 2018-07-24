<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25.04.2018
 * Time: 0:34
 */

class resur_new
{
    public function add_res($post, $db)
    {
        try
        {
            if (empty($post))
            {
                throw new Exception("Вы не ввели данные");
            }
            else
            {
                $res = $db->get_info_res($post);
                if ($res == false)
                {
                    throw new Exception("Произошла ошибка, запись не добавлена");
                }
                else
                {
                    echo"Новый ресурс добавлен успешно<br/>";
                }
            }
        }
        catch (Exception $e)
        {
            echo "Ошибка:".$e->getMessage();
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.04.2018
 * Time: 19:40
 */

class Action
{
    private $db = null;
    private $main = null;
    private $post_data = array();
    private $fields = array(
        'existence_resources' => array('items', 'quality_id', 'resourses_id', 'sities_id', 'status_resourses_id', 'units_id')
    );

    public function __construct($Db )
    {
        $this->db = $Db;
        $this->main = getConf('main');
    }

    public function add_resours($type_fields, $post, $files)
    {
        try {
            $fields = $this->fields[$type_fields];
            foreach ($fields as $val) {
                if (isset($post[$val]) && !empty($post[$val])) {
                    $this->post_data[$val] = $post[$val];
                }
            }
            $res_ex_id = $this->db->add_info_table($type_fields, $this->post_data);
            if (!empty($res_ex_id["ex_id"])) {
                if (isset($files['res_pict'])) {
                    if ((int)$files['res_pict']['size'] < $this->main['img_size']) {
                        if (move_uploaded_file($files['res_pict']['tmp_name'], $this->main['path_img'] . $files['res_pict']['name'])) {
                            $res = $this->db->img_add_func($this->main['path_img'] . $files['res_pict']['name'], $res_ex_id['ex_id']);
                            if ($res) {
                                //$msg = '<span class="success-msg">запись добавлена</span>';
                                $msg = "запись добавлена";
                            } else {
                                throw new Exception('запись добавлена, но картинки не загружены - ошибка добавления в базу');
                                //echo "запись добавлена, но картинки не загружены - ошибка добавления в базу";
                            }
                        } else {
                            throw new Exception('запись добавлена, но картинки не загружены - не удалось скопировать фаил');
                            //echo "запись добавлена, но картинки не загружены - не удалось скопировать фаил";
                        }
                    } else {
                        throw new Exception('запись добавлена, но картинки не загружены - большой файл');
                        //echo "запись добавлена, но картинки не загружены - большой файл";
                    }
                } else {
                    throw new Exception('запись добавлена, но картинки не загружены');
                    //echo "запись добавлена, но картинки не загружены";
                }
            } else {
                throw new Exception('запись не добавлена');
                //echo "запись не добавлена";
            }
        }
        catch (Exception $e)
        {
            $msg = '<span class="error-msg">' . ($e->getMessage()) . '</span>';
        }
        return $msg;
    }

    public function __call($name, $arguments)
    {
        echo "'$name' данный метод не доступен";
    }
}
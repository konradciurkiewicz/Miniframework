<?php
/**
 * Created by PhpStorm.
 * User: konrad
 * Date: 2017-08-07
 * Time: 09:27
 */

namespace Framework;


class MyPDO extends \PDO
{

    function __construct()
    {
        $file='../config/database.ini';
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];

        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}
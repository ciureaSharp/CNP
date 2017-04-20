<?php
/**
 * Created by PhpStorm.
 * User: Advisor2
 * Date: 20.04.2017
 * Time: 20:40
 */

if ($_POST['payload']) {
    exec('git pull -u origin master 2>&1', $output);
    print_r($output);
}
//hopa hopam
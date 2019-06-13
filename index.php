<?php
/**
 * FileName: index.php
 * Created by Munna Khan.
 * Email: <engrmunnakhan@gmail.com>
 * Date: 6/13/19
 * Time: 8:21 PM
 */

include "SqlParser.php";

$sql=new SqlParser('all_databases.sql');

$sql->Prepare()->Generate();


<?php
/**
 * FileName: process.php
 * Created by Munna Khan.
 * Email: <engrmunnakhan@gmail.com>
 * Date: 6/13/19
 * Time: 8:21 PM
 */

include "SqlParser.php";

$val = getopt("f:");


if(count($val)>0){

	$file=$val['f'];

	if(file_exists($file)){
		$sql=new SqlParser($file);

		$sql->Prepare()->Generate();
	}else{
		echo "File does not exists.\n";
	}
}else{
	echo "-f missing, -f then file name to start\n";
}






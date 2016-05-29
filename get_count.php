<?php
$cnt = 0;
$h = opendir('./cat_data/'); //Open the current directory
    while (false !== ($entry = readdir($h))) {
        if($entry != '.' && $entry != '..') { //Skips over . and ..
            $fileName = 'cat_data/'.$entry; //Do whatever you need to do with the file
            $fileData = json_decode(file_get_contents($fileName),true);
            $cnt += count($fileData);
            
        }
    }
    

  
    


echo $cnt;
?>
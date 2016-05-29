<?php

function getNextFile($folderName){
    $h = opendir('./'.$folderName.'/'); //Open the current directory
    while (false !== ($entry = readdir($h))) {
        if($entry != '.' && $entry != '..') { //Skips over . and ..
            $fileName = $entry; //Do whatever you need to do with the file
            break; //Exit the loop so no more files are read
        }
    }
    return $folderName.'/'.$fileName;
}
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'readTempFile'){
    $fp = json_decode(file_get_contents('tempJson.json'), true);
    $addrInfo = $fp['addrInfo'];
    unlink('tempJson.json');
    echo json_encode($addrInfo);
    exit();
}
if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'read_next_cat'){
    
    $fileName = getNextFile('combination');
    $fileData = json_decode(file_get_contents($fileName),true);
    
    $resAry = $fileData[max(array_keys($fileData))];
    unset($fileData[max(array_keys($fileData))]);

    unlink($fileName);
    if(count($fileData) > 0){
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($fileData));
        fclose($fp);
    }

    echo json_encode($resAry);

    exit();
    
}
$fileName = getNextFile('cat_data');
$fileData = json_decode(file_get_contents($fileName),true);
if(count($fileData) == 0){
    
    unlink($fileName);
    $fileName = getNextFile('cat_data');
    $fileData = json_decode(file_get_contents($fileName),true);

    
}
$resAry = $fileData[max(array_keys($fileData))];
unset($fileData[max(array_keys($fileData))]);

unlink($fileName);

$fp = fopen($fileName, 'w');
fwrite($fp, json_encode($fileData));
fclose($fp);


//place in temp file
@unlink('tempJson.json');
$fp = fopen('tempJson.json', 'w');
fwrite($fp, json_encode($resAry));
fclose($fp);



echo json_encode($resAry);
?>
<?php
//session_start();



require_once 'connect.db.php';


define('UPLOAD_FOLDER', "/public/uploads" );

const ALLOWED_FILES = [
    'image/png' => 'png',
    'image/jpeg' => 'jpg',
    'application/pdf' => 'pdf',
];

const MAX_SIZE = 20  * 1024 * 1024; //  20MB

const UPLOAD_DIR = ROOT_PATH . UPLOAD_FOLDER;

$is_post_request = strtolower($_SERVER['REQUEST_METHOD']) === 'post';
$has_files = isset($_FILES['files']);

if (!$is_post_request || !$has_files) {
    //redirect_with_message('Opération de téléchargement de fichier invalide', "error");
}

$files = $_FILES['file_rcd'];
$file_count = count($files['name']);
// validation
$errors = [];
for ($i = 0; $i < $file_count; $i++) {

    $filename = $files['name'][$i];
    if(!empty($filename)){

        // get the uploaded file info
        $status = $files['error'][$i];
        
        $tmp = $files['tmp_name'][$i];

        // an error occurs
        if ($status !== UPLOAD_ERR_OK) {
            $errors[$filename][] = "Erreur lors du téléchargement du fichier";
            continue;
        }
        // validate the file size
        $filesize = filesize($tmp);

        if ($filesize > MAX_SIZE) {
            // construct an error message
            $message = sprintf("Le fichier %s est %s qui est supérieur à la taille autorisée %s",
                $filename,
                format_filesize($filesize),
                format_filesize(MAX_SIZE));

            $errors[$filename][] = $message;
            continue;
        }

        // validate the file type
        if (!in_array(get_mime_type($tmp), array_keys(ALLOWED_FILES))) {
            $errors[$filename][] = "le fichier $filename est autorisé à être téléchargé";
        }
    }
}

if ($errors) {
    //redirect_with_message("L'erreur suivante s'est produite","Error");
}

$files_number= $_POST['file_number'];
// move the files
for($i = 0; $i < $file_count; $i++) {
    $filename = $files['name'][$i];

    $array_file_number = explode('-', $files_number[$i]);
    if($array_file_number[0] == 'new'){
        
    }elseif($array_file_number[0] == 'rcd'){

    }

    if(!empty($filename)){
        $tmp = $files['tmp_name'][$i];
        $mime_type = get_mime_type($tmp);
    
        // set the filename as the basename + extension
        $uploaded_file = pathinfo($filename, PATHINFO_FILENAME) . '.' . ALLOWED_FILES[$mime_type];
        // new filepath
        if (!file_exists(UPLOAD_DIR . '/'. $folder)) {
            mkdir(UPLOAD_DIR . '/'. $folder, 0755, true);
        }        
        $filepath = UPLOAD_DIR . '/'. $folder ."/" .$uploaded_file;
    
        // move the file to the upload dir
        $success = move_uploaded_file($tmp, $filepath);
        if(!$success) {
            $files_ok[$i] = $filepath;
        }
    }
}

function get_mime_type(string $filename)
{
    $info = finfo_open(FILEINFO_MIME_TYPE);
    if (!$info) {
        return false;
    }

    $mime_type = finfo_file($info, $filename);
    finfo_close($info);

    return $mime_type;
}



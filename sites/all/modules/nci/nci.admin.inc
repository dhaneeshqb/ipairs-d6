<?php

//define("FTP_SERVER", "192.168.1.105");
//define("FTP_USER", "williamwolfrath");
//define("FTP_PASS", "ge5ne27ric75");
//define("FTP_DIR", "/Applications/MAMP/htdocs");

define("FTP_SERVER", "cipsftp.nci.nih.gov");
define("FTP_USER", "nyumedct");
define("FTP_PASS", "b1_eBcUA");
define("FTP_DIR", "/full/"); 


function nci_admin_settings() {
    $form['#attributes']['enctype'] = 'multipart/form-data';
    $current_term_xsl_file = variable_get('nci_term_xslt_file', '');
    $current_glossary_xsl_file = variable_get('nci_glossary_xslt_file', '');
    $current_summary_xsl_file = variable_get('nci_summary_xslt_file', '');

    $form['nci_term_xslt_file'] = array(
        '#type' => 'file',
        '#title' => t('Term XSLT File'),
        '#description' => 'Currently: ' . $current_term_xsl_file->filepath,
        '#size' => 48,
        '#default_value' => variable_get('nci_term_xslt_file', drupal_get_path('module', 'nci') . '/nci.xsl'),
    );
    
     $form['nci_summary_xslt_file'] = array(
        '#type' => 'file',
        '#title' => t('Summary XSLT File'),
        '#description' => 'Currently: ' . $current_summary_xsl_file->filepath,
        '#size' => 48,
        '#default_value' => variable_get('nci_summary_xslt_file', drupal_get_path('module', 'nci') . '/nci_glossary.xsl'),
    );
    
    $form['nci_glossary_xslt_file'] = array(
        '#type' => 'file',
        '#title' => t('Glossary Term XSLT File'),
        '#description' => 'Currently: ' . $current_glossary_xsl_file->filepath,
        '#size' => 48,
        '#default_value' => variable_get('nci_glossary_xslt_file', drupal_get_path('module', 'nci') . '/nci_summary.xsl'),
    );
    
    //$form['nci_use_template'] = array(
    //    '#type' => 'checkbox',
    //    '#title' => t('Use template for theming?'),
    //    '#description' => '',
    //    '#default_value' => variable_get('nci_use_template', ''),
    //);
    
    $form['#submit'][] = nci_admin_settings_submit;
    
    $default = variable_get('nci_xslt_file', '');
    //dd($default);
    
    return system_settings_form($form);
    
}



function nci_cache_settings() {
    
    $form['nci_cache_time'] = array(
        '#type' => 'textfield',
        '#title' => t('Cache Time(in days)'),
        '#description' => t(''),
        '#default_value' => variable_get('nci_cache_time', ''),
        '#size' => 3,
    );
    
    
    $form['buttons']['clearcache'] = array(
        '#type' => 'submit',
        '#value' => 'Clear cache',
        '#submit' => array('nci_cache_clear_submit'),
        '#weight' => 10,
    ); 
    
    return system_settings_form($form);
    //return confirm_form(NULL, 'Clear cache?', 'admin/settings/ebsco/cache', 'This will wipe out the cache.', 'Clear', 'Cancel');
}


function nci_cache_clear_confirm() {
    return confirm_form(NULL, 'Clear cache?', 'admin/settings/ebsco/cache', 'This will empty the cache. It cannot be undone.', 'Clear', 'Cancel');
}



function nci_cache_clear_confirm_submit($form, &$form_state) {
    // delete everything from the ebsco cache table
    cache_clear_all('*', 'cache_nci', TRUE);
    drupal_set_message('EBSCO cache cleared.');
    drupal_goto('admin/settings/ebsco/cache');
}



// returns the current file as defined in the vars table
// as long as it exists in the specified directory on the file system
// if it's missing, returns nothing...
function _get_current_xsl_file() {
    $current_xsl_file = variable_get('nci_xslt_file', '');
    
}





function nci_admin() {
    //dd('nci admin');
    $uploads_path = file_create_path(file_directory_path() . '/nci');
    if (!file_check_directory($uploads_path)) {
        //dd('creating nci dir...');
        $uploads_path = file_directory_path() . '/nci';
        file_check_directory($uploads_path, FILE_CREATE_DIRECTORY);
        //dd('after check dir');
    }
    return drupal_get_form('nci_admin_settings');
}


function nci_cache_admin() {
    return drupal_get_form('nci_cache_settings');
}


function nci_default_main_page() {
    $chunkiid = variable_get('nci_default_chunkiid', '33341');
    //content?ChunkIID=33341
    drupal_goto("content", "ChunkIID=$chunkiid");
}




function nci_admin_main() {
    return "XSL Processor Settings Main.";
}


function nci_sync_form() {

	
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Click to download NCI XML files'),
    );
    return $form;
}



// a helper object of sorts, just keeps all FTP details together
function nci_ftp_object($server, $port=21, $user, $pass, $dir=NULL) {
  $ftp = new stdClass();

  $ftp->__server = $server;
  $ftp->__port = $port;
  $ftp->__user = $user;
  $ftp->__password = $pass;
  $ftp->__directory = $dir;

  return $ftp;
}


function nci_add_terminology_data($xmlfile) {
  $attrs = $xmlfile->attributes();
  $term_id = $attrs['id'];
  $term_name = $xmlfile->PreferredName;
  $definition = $xmlfile->Definition->DefinitionText;
  //print "TermID: " . $term_id . "\n";
  //print "Name: " . $term_name . "\n";
  //print "Definition: " . $definition . "\n\n";
  
  $termdata = new stdClass();
  $termdata->termid = $term_id;
  $termdata->term = $term_name;
  $termdata->description = $definition;
  $termdata->created = time();
  drupal_write_record('nci_terminology', $termdata);
  //print "Terminology written to database.\n";
}


function nci_add_summary_data($xmlfile) {
  $attrs = $xmlfile->attributes();
  $summary_id = $attrs['id'];
  $summary_title = $xmlfile->SummaryTitle;
  $summarydata = new stdClass();
  $summarydata->summaryid = $summary_id;
  $summarydata->title = $summary_title;
  $summarydata->create = time();
  drupal_write_record('nci_summary', $summarydata);
}



function nci_parse_terms() {
    //dd('parsing terms...');
    $xml_dir = file_directory_path() . '/nci/Terminology';
    $xmlfiles = file_scan_directory($xml_dir, '.xml');
    //dd('xmldir: ' . $xml_dir);
    
    ksort($xmlfiles);  // sort files by filename (key)
    //print_r($xmlfiles);
    $limit = 0;
    nci_reset_term_table();
    foreach ($xmlfiles as $xmlfile) {
        //dd( "Processing file: " . $xmlfile->filename );
        $xmlfile = simplexml_load_file($xmlfile->filename);
        //print_r($xmlfile);
    
        nci_add_terminology_data($xmlfile);
    
        $limit++;
        // if ($limit > 10) { break; }
    
    }

}


function nci_parse_summaries() {
  $xml_dir = file_directory_path() . '/nci/Summary';
  $xmlfiles = file_scan_directory($xml_dir, '.xml');
  ksort($xmlfiles);  // sort files by filename (key)
  //print_r($xmlfiles);
  $limit = 0;
  nci_reset_summary_table();
  foreach ($xmlfiles as $xmlfile) {
    //dd( "Processing file: " . $xmlfile->filename );
    $xmlfile = simplexml_load_file($xmlfile->filename);
    //print_r($xmlfile);
    
    nci_add_summary_data($xmlfile);
    
    $limit++;
    //if ($limit > 1) { break; }
    
  }

}



function nci_reset_term_table() {
  db_query("TRUNCATE TABLE {nci_terminology}");
}


function nci_reset_summary_table() {
  db_query("TRUNCATE TABLE {nci_summary}");
}





function nci_sync_form_submit($form, &$form_state) {
    
    drupal_set_message("Syncing terms...");
    //dd("Syncing terms..");
    $files_dir = file_directory_path();
    drupal_set_message( "File destination: ");
    drupal_set_message( $files_dir . '/nci/Terminology.tar.gz' );
    drupal_set_message( $files_dir . '/nci/Summary.tar.gz' );
    $ftp = nci_ftp_object(FTP_SERVER, 21, FTP_USER, FTP_PASS, FTP_DIR);
    $ftp->__conn = ftp_connect($ftp->__server, $ftp->__port);
    if (!$ftp) {
        drupal_set_message('Could not connect to ftp server ' . FTP_SERVER, 'error');
        return;
    }
    //drupal_set_message( $ftp->__conn . "\n";
    $ftp->__login = @ftp_login($ftp->__conn, $ftp->__user, $ftp->__password);
    ftp_pasv($ftp->__conn, true);  // turn this on or the connection doesn't work right for multiple files. don't ask me...
  
    $chdir = @ftp_chdir($ftp->__conn, $ftp->__directory);
    if (!$chdir) {
        drupal_set_message('Could not change to the ftp directory' . FTP_DIR, 'error');
        return;
    }
    //dd('grabbing files..');
    $termfile = $files_dir . '/nci/Terminology.tar.gz';
    $summaryfile = $files_dir . '/nci/Summary.tar.gz';
    $glossaryfile = $files_dir . '/nci/GlossaryTerm.tar.gz';
    $mediafile = $files_dir . '/nci/Media.tar.gz';
    $termfp = fopen($termfile, 'wb');
    $summaryfp = fopen($summaryfile, 'wb');
    $glossaryfp = fopen($glossaryfile, 'wb');
    $mediafp = fopen($mediafile, 'wb');
    ftp_fget ($ftp->__conn, $termfp , 'Terminology.tar.gz' , FTP_BINARY);
    fclose($termfp);
    ftp_fget ($ftp->__conn, $summaryfp , 'Summary.tar.gz' , FTP_BINARY);
    fclose($summaryfp);
    ftp_fget ($ftp->__conn, $glossaryfp , 'GlossaryTerm.tar.gz' , FTP_BINARY);
    fclose($glossaryfp);
    ftp_fget ($ftp->__conn, $mediafp , 'Media.tar.gz' , FTP_BINARY);
    fclose($mediafp);
    drupal_set_message( "FTP download finished. Extracting....");
  
    //dd('trying to extract...');
    $pwd = exec("pwd");
    //dd('current dir: ' . $pwd);
    //exec("tar -zxvf " . $files_dir . "/nci/Terminology.tar.gz -C " . $files_dir . "/nci 2> " . $files_dir . "/sync.log");
    //$result = exec("gunzip " . $files_dir . "/nci/Terminology.tar.gz  2> " . $files_dir . "/gunzip.log");
    //$result2 = exec("tar -xvf " . $files_dir . "/nci/Terminology.tar -C " . $files_dir . "/nci 2> " . $files_dir . "/sync.log");
  
    //chdir("/var/www/drupal-6.20/sites/default/files/nci");
    //chdir("/cube/sites/htdocs/wolfrath/testing/sites/default/files/nci");
    chdir($files_dir . '/nci');
    exec("rm Terminology.tar");
    exec("rm Summary.tar");
    exec("rm GlossaryTerm.tar");
    exec("rm Media.tar");
    exec("gunzip Terminology.tar.gz");
    exec("tar -xvf Terminology.tar");
    exec("gunzip Summary.tar.gz");
    exec("tar -xvf Summary.tar");
    exec("gunzip GlossaryTerm.tar.gz");
    exec("tar -xvf GlossaryTerm.tar");
    exec("gunzip Media.tar.gz");
    exec("tar -xvf Media.tar");
    chdir($pwd);  // must change back to previous directory for other functions to work.
  
    drupal_set_message("Parsing files and syncing to database...");
    //dd('parsing terms...');
    nci_parse_terms();
    //dd('parsing summaries..');
    nci_parse_summaries();
    drupal_set_message( "done!");
	
	//perform image compression... 
	nci_compressMedia();
}




function nci_admin_sync() {
	
	drupal_set_message("<span style='color:red;'>Please note that using this feature can generate huge disk usage and should only be used if you are the NYUCI webmaster</span>");

	$files_dir = file_directory_path();
    $output = '';
    $output .= drupal_get_form('nci_sync_form');
    $output .= 'The files will be downloaded to the current file system path: ' . $files_dir;
    return $output;
}




function nci_import_articles() {
    $xmldir = '/Applications/MAMP/htdocs/healthwise/xml';
    $output = '';
    
    $xmlfiles = file_scan_directory($xmldir, '.*.xml');

    return drupal_get_form('_nci_dynamic_article_form', $xmlfiles);
}




function nci_load_article() {
    $xmldir = '/Applications/MAMP/htdocs/healthwise/xml';
    
}

function nci_admin_settings_validate($form, &$form_state) {
    //dd('validate');
    //dd($form);
    //dd('***************');
    //dd($form_state);
    //dd($_FILES);
    $validations = array();
    //$uploads_path = file_directory_path() . '/nci';
    //dd($uploads_path);
    //$uploads_path = file_create_path(drupal_get_path('module', 'nci'));
    $uploads_path = drupal_get_path('module', 'nci');
    //dd('my uploads path:');
    //dd($uploads_path);
    $saved_term_file = nci_file_save_upload('nci_term_xslt_file', $validations, $uploads_path, FILE_EXISTS_REPLACE);  // drupal api says last param is boolean but it's really not..
    $saved_summary_file = nci_file_save_upload('nci_summary_xslt_file', $validations, $uploads_path, FILE_EXISTS_REPLACE);
    $saved_glossary_file = nci_file_save_upload('nci_glossary_xslt_file', $validations, $uploads_path, FILE_EXISTS_REPLACE); 
    //$saved_file = file_save_upload('nci_xslt_file', $validations, file_create_path('/Users/williamwolfrath/junk'), FILE_EXISTS_REPLACE); 
    //dd($saved_file);
    if ($saved_term_file != NULL) {  // NULL means that no file was attempted to be uploaded. ignore.
        if(!$saved_term_file){
            drupal_set_message(t('The uploaded file was unable to be saved.'), 'error');
            form_set_error($file_name, 'Error uploading file.');
        }
        else {
            //dd('moving file..');
            //$move = file_move($saved_file->filepath, '/Users/williamwolfrath/junk', FILE_EXISTS_REPLACE);
            //dd($move);
            drupal_set_message('The uploaded file was saved to ' . $uploads_path . '.', 'status');
            $form_state['values']['nci_term_xslt_file'] = $saved_term_file;
            // set the status - otherwise Drupal considers the file temporary and will delete on the next cron run
            $result = file_set_status($saved_term_file, 1);
            //dd($saved_file);
        }
    }
    
 if ($saved_summary_file != NULL) {  // NULL means that no file was attempted to be uploaded. ignore.
        if(!$saved_summary_file){
            drupal_set_message(t('The uploaded file was unable to be saved.'), 'error');
            form_set_error($file_name, 'Error uploading file.');
        }
        else {
            //dd('moving file..');
            //$move = file_move($saved_file->filepath, '/Users/williamwolfrath/junk', FILE_EXISTS_REPLACE);
            //dd($move);
            drupal_set_message('The uploaded file was saved to ' . $uploads_path . '.', 'status');
            $form_state['values']['nci_summary_xslt_file'] = $saved_summary_file;
            // set the status - otherwise Drupal considers the file temporary and will delete on the next cron run
            $result = file_set_status($saved_summary_file, 1);
            //dd($saved_file);
        }
    }
    if ($saved_glossary_file != NULL) {  // NULL means that no file was attempted to be uploaded. ignore.
        if(!$saved_glossary_file){
            drupal_set_message(t('The uploaded file was unable to be saved.'), 'error');
            form_set_error($file_name, 'Error uploading file.');
        }
        else {
            //dd('moving file..');
            //$move = file_move($saved_file->filepath, '/Users/williamwolfrath/junk', FILE_EXISTS_REPLACE);
            //dd($move);
            drupal_set_message('The uploaded file was saved to ' . $uploads_path . '.', 'status');
            $form_state['values']['nci_glossary_xslt_file'] = $saved_glossary_file;
            // set the status - otherwise Drupal considers the file temporary and will delete on the next cron run
            $result = file_set_status($saved_glossary_file, 1);
            //dd($saved_file);
        }
    }
}



function nci_cache_clear() {
    return drupal_get_form('nci_cache_clear_confirm');
}


function nci_cache_clear_submit($form, &$form_state) {
    //dd('this is cache clear submit');
    drupal_goto('admin/settings/ebsco/cache-clear-confirm');
    //dd($form_state);
}



// in D6, you cannot use file_save_upload to save a file to a directory outside of the 'files' directory
// because of a call in the function to 'file_create_path'
// a way around this, since we need to save the xslt file to the module directory,
// is to replicate the function here but slightly alter it. Not much else can be done, according to my research... bw
function nci_file_save_upload($source, $validators = array(), $dest = FALSE, $replace = FILE_EXISTS_RENAME) {
  global $user;
  static $upload_cache;

  // Add in our check of the the file name length.
  $validators['file_validate_name_length'] = array();

  // Return cached objects without processing since the file will have
  // already been processed and the paths in _FILES will be invalid.
  if (isset($upload_cache[$source])) {
    return $upload_cache[$source];
  }

  // If a file was uploaded, process it.
  if (isset($_FILES['files']) && $_FILES['files']['name'][$source] && is_uploaded_file($_FILES['files']['tmp_name'][$source])) {
    // Check for file upload errors and return FALSE if a
    // lower level system error occurred.
    switch ($_FILES['files']['error'][$source]) {
      // @see http://php.net/manual/en/features.file-upload.errors.php
      case UPLOAD_ERR_OK:
        break;

      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        drupal_set_message(t('The file %file could not be saved, because it exceeds %maxsize, the maximum allowed size for uploads.', array('%file' => $source, '%maxsize' => format_size(file_upload_max_size()))), 'error');
        return 0;

      case UPLOAD_ERR_PARTIAL:
      case UPLOAD_ERR_NO_FILE:
        drupal_set_message(t('The file %file could not be saved, because the upload did not complete.', array('%file' => $source)), 'error');
        return 0;

        // Unknown error
      default:
        drupal_set_message(t('The file %file could not be saved. An unknown error has occurred.', array('%file' => $source)), 'error');
        return 0;
    }

    // Build the list of non-munged extensions.
    // @todo: this should not be here. we need to figure out the right place.
    $extensions = '';
    foreach ($user->roles as $rid => $name) {
      $extensions .= ' '. variable_get("upload_extensions_$rid",
      variable_get('upload_extensions_default', 'jpg jpeg gif png txt html doc xls pdf ppt pps odt ods odp'));
    }

    // Begin building file object.
    $file = new stdClass();
    $file->filename = file_munge_filename(trim(basename($_FILES['files']['name'][$source]), '.'), $extensions);
    $file->filepath = $_FILES['files']['tmp_name'][$source];
    $file->filemime = file_get_mimetype($file->filename);

    // If the destination is not provided, or is not writable, then use the
    // temporary directory.
    //if (empty($dest) || file_check_path($dest) === FALSE) {
    //  $dest = file_directory_temp();
    //}

    $file->source = $source;
    $file->destination = file_destination($dest .'/'. $file->filename, $replace);
    $file->filesize = $_FILES['files']['size'][$source];

    // Call the validation functions.
    $errors = array();
    foreach ($validators as $function => $args) {
      array_unshift($args, $file);
      // Make sure $file is passed around by reference.
      $args[0] = &$file;
      $errors = array_merge($errors, call_user_func_array($function, $args));
    }

    // Rename potentially executable files, to help prevent exploits.
    if (preg_match('/\.(php|pl|py|cgi|asp|js)$/i', $file->filename) && (substr($file->filename, -4) != '.txt')) {
      $file->filemime = 'text/plain';
      $file->filepath .= '.txt';
      $file->filename .= '.txt';
      // As the file may be named example.php.txt, we need to munge again to
      // convert to example.php_.txt, then create the correct destination.
      $file->filename = file_munge_filename($file->filename, $extensions);
      $file->destination = file_destination($dest .'/'. $file->filename, $replace);
    }


    // Check for validation errors.
    if (!empty($errors)) {
      $message = t('The selected file %name could not be uploaded.', array('%name' => $file->filename));
      if (count($errors) > 1) {
        $message .= '<ul><li>'. implode('</li><li>', $errors) .'</li></ul>';
      }
      else {
        $message .= ' '. array_pop($errors);
      }
      form_set_error($source, $message);
      return 0;
    }

    // Move uploaded files from PHP's upload_tmp_dir to Drupal's temporary directory.
    // This overcomes open_basedir restrictions for future file operations.
    $file->filepath = $file->destination;
    if (!move_uploaded_file($_FILES['files']['tmp_name'][$source], $file->filepath)) {
      form_set_error($source, t('File upload error. Could not move uploaded file.'));
      watchdog('file', 'Upload error. Could not move uploaded file %file to destination %destination.', array('%file' => $file->filename, '%destination' => $file->filepath));
      return 0;
    }

    // If we made it this far it's safe to record this file in the database.
    $file->uid = $user->uid;
    $file->status = FILE_STATUS_TEMPORARY;
    $file->timestamp = time();
    drupal_write_record('files', $file);

    // Add file to the cache.
    $upload_cache[$source] = $file;
    return $file;
  }
  return 0;
}


function nci_compressMedia()
{
	$image_dir = file_directory_path() . '/nci/Media';
	$imagefiles = file_scan_directory($image_dir, '.jpg');
    //dd('xmldir: ' . $xml_dir);
    
	print "Processed image directory";
	
    $limit = 0;
	
    foreach ($imagefiles as $imagefileD) {
		$imagefile = $imagefileD->filename;
		list($width, $height) = getimagesize($imagefile);

		//resize the image;
		$newImage = resize_image($imagefile,$width*.3, $height*.3);
		
        $limit++;

		//save the image to file
		imagejpeg($newImage,$imagefileD->filename);
    
    }
	
}

/**
*  Function for resize image with image GD.
*
*/
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*($r-$w/$h)));
        } else {
            $height = ceil($height-($height*($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

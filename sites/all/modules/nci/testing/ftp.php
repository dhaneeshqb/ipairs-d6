<?php

//define("FTP_SERVER", "192.168.1.105");
//define("FTP_USER", "williamwolfrath");
//define("FTP_PASS", "ge5ne27ric75");
//define("FTP_DIR", "/Applications/MAMP/htdocs");

define("FTP_SERVER", "cipsftp.nci.nih.gov");
define("FTP_USER", "nyumedct");
define("FTP_PASS", "b1_eBcUA");
define("FTP_DIR", "/full/"); 

function drupal_ftp_ftp_object($server, $port=21, $user, $pass, $dir=NULL) {
  $ftp = new stdClass();

  $ftp->__server = $server;
  $ftp->__port = $port;
  $ftp->__user = $user;
  $ftp->__password = $pass;
  $ftp->__directory = $dir;

  return $ftp;
}


function processSummary($filename) {
  $xmlfile = simplexml_load_file('/var/www/drupal-6.20/sites/all/modules/custom/nci/testing/Summary/' . $filename);
  print_r($xmlfile);
}


function processXML() {
    $xmlfile = simplexml_load_file('/var/www/drupal-6.20/full/DrugInfoSummary/CDR681926.xml');
    $refid = NULL;
    foreach($xmlfile->DrugInfoMetaData[0]->TerminologyLink->attributes() as $a => $b) {
        if ($a == 'ref') {
            $refid = $b;
        }
    }
    if (!$refid) {
        return;
    }
    print "The ref id is $refid \n";
    $refarray = str_split($refid);
    $termfile = '';
    foreach ($refarray as $i=>$char) {
        if ($i<7 && $char=='0') {  // leave leading zeroes out
            continue;
        }
        else {
            $termfile .= $char;
        }
    }
    $termfile .= '.xml';
    print $termfile;
}


function nci_get_file_name($refid) {
  $refarray = str_split($refid);
    $termfile = '';
    foreach ($refarray as $i=>$char) {
        if ($i<8 && $char=='0') {  // leave leading zeroes out
            continue;
        }
        else {
            $termfile .= $char;
        }
    }
    $termfile .= '.xml';
    print $termfile;
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


function nci_sync_terms() {

  print "Syncing terms...\n";  
  $files_dir = file_directory_path();
  print "File destination: \n";
  print $files_dir . "\n";
  $ftp = nci_ftp_object(FTP_SERVER, 21, FTP_USER, FTP_PASS, FTP_DIR);
  $ftp->__conn = ftp_connect($ftp->__server, $ftp->__port);
  if (!$ftp) {
      drupal_set_message('Could not connect to ftp server ' . FTP_SERVER, 'error');
      return;
  }
  //print $ftp->__conn . "\n";
  $ftp->__login = @ftp_login($ftp->__conn, $ftp->__user, $ftp->__password);
  ftp_pasv($ftp->__conn, true);  // turn this on or the connection doesn't work right for multiple files. don't ask me...
  
  $chdir = @ftp_chdir($ftp->__conn, $ftp->__directory);
  if (!$chdir) {
      drupal_set_message('Could not change to the ftp directory' . FTP_DIR, 'error');
      return;
  }
    
  //$contents = ftp_nlist($ftp->__conn, ".");
  //print_r($contents);
  //$limit = 0;
  //foreach ($contents as $key=>$termfile) {
  //  $localfile = $files_dir . '/nci/' . $termfile;
  //  ftp_get ($ftp->__conn,  $localfile, $termfile , FTP_ASCII);
    //print "Got file $localfile \n";
    //$limit++;
    //if ($limit > 10) {
    //  break;
    //}
  //}

  //ftp_close($ftp->__conn);
  
  $file = $files_dir . '/nci/Terminology.tar.gz';
  $fp = fopen($file, 'wb');
  ftp_fget ($ftp->__conn, $fp , 'Terminology.tar.gz' , FTP_BINARY);
  fclose($fp);
  print "FTP download finished. Extracting....\n";
  
  $result = system("tar -zxvf " . $files_dir . "/nci/Terminology.tar.gz -C " . $files_dir . "/nci > " . $files_dir . "/sync.log");
  
  print "done!\n";
  //drupal_set_message("Successfully download latest files. " . $result);
  

}



function parseme() {
  $xml_dir = file_directory_path() . '/nci/Terminology';
  $xmlfiles = file_scan_directory($xml_dir, '.xml');
  ksort($xmlfiles);  // sort files by filename (key)
  //print_r($xmlfiles);
  $limit = 0;
  nci_reset_term_table();
  foreach ($xmlfiles as $xmlfile) {
    print "Processing file: " . $xmlfile->filename . "\n";
    $xmlfile = simplexml_load_file($xmlfile->filename);
    //print_r($xmlfile);
    
    nci_add_terminology_data($xmlfile);
    
    $limit++;
   // if ($limit > 10) { break; }
    
  }

}


function parseSummaries() {
  $xml_dir = file_directory_path() . '/nci/Summary';
  $xmlfiles = file_scan_directory($xml_dir, '.xml');
  ksort($xmlfiles);  // sort files by filename (key)
  //print_r($xmlfiles);
  $limit = 0;
  nci_reset_summary_table();
  foreach ($xmlfiles as $xmlfile) {
    print "Processing file: " . $xmlfile->filename . "\n";
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


function nci_parse_xml($xmldir) {
  
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


//system("tar -zxvf /tmp/my.tar.gz");
//print 'unzipped';
//processXML();
//nci_sync_terms();
//parseme();
//nci_get_term_info();
//nci_get_file_name('CDR0000039039');
//processSummary('CDR256491.xml');
parseSummaries();
print "\n";

?>
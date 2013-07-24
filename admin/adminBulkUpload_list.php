<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
 /******************************************************************************
 * Import data access component for library bibliographies
 *
 *                  CHANGE HISTORY
 *     #C3 - Its a feature for bulkupload of titles and copies of an items in admin section 
 *     @author Kiran Kumar Reddy and Saiteja Bogade
 *
 ******************************************************************************
 */
 
  require_once("../shared/common.php");
  require_once("../classes/Form.php");
  require_once("../classes/CircQuery.php");
  require_once("../classes/Localize.php");
  require_once("../classes/ImportQuery.php");
  require_once("../classes/DmQuery.php");

  require_once("../classes/Date.php");  $tab = 'admin';
  $nav = "Bulkupload";

  $focus_form_name = "bulk_upload";
  $focus_form_field = "date";

  require_once("../shared/logincheck.php"); 
 
  $loc = new Localize(OBIB_LOCALE,$tab);
 
  function run_batch($lines, $date)	{
  	 $rowcount = 0;
	 $b = array();
     while(count($lines)) {
     	
      $columns = str_getcsv(array_shift($lines), ",", "\"");
      
  		/* Column 0 is for the serial number  */
	  if ($columns[0]=='S No') {
			continue;
	  }
	  $rowcount++;
	  
	  if (strlen(trim($columns[0]))==0) {
		  	//add title to an array
			$b[$rowcount]="Record " . $rowcount . " Barcode/Serial No not entered.";
			continue;
	  }
	  
	  /*column 1 is for the title*/
	  if (strlen(trim($columns[1]))==0) {
			$b[$rowcount]="Record " . $rowcount . " Title not entered.";
			continue;
	  } else {
	  	 $columns[1] = str_replace("'","\'",$columns[1]);
	  }
	  
	  /*column 2 is for the author*/
	  $columns[2] = str_replace("'","\'",$columns[2]);
	  
	  $import = new ImportQuery();
	  $dmQ = new DmQuery();
	  $collectionDesc = $dmQ->getAssoc("collection_dm","description");
	  $materials=$dmQ->getAssoc("material_type_dm","description");
	  $statuses=$dmQ->getAssoc("biblio_status_dm","description");
	  
	  /*column 3 is for the circulation status(in- active,ina- inactive,lst-damaged)*/
	  $status_found=false;
	  foreach ($statuses as $code=>$status)
	  {
	  	if(strcmp($columns[3], $status)==0)
	  	{
	  		$columns[3]=$code;
	  		$status_found=true;
	  	}
	  }
	   
	  if ((strlen(trim($columns[3]))==0) || (status_found==false)) {
	  		$columns[3] = "in";
 	  }
 	   	  
 	  /*column 4 is for Category , column 5 is for Type*/
	  foreach ($collectionDesc as $code=>$collection)
	  {
	  	if(strcmp($columns[4]." ".$columns[5], $collection)==0)
	  	{
	  		$columns[4]=$code;
	  	}
	  }
	  if (strlen(trim($columns[4]))==0) {
	  	$columns[4] = '1';
	  }
	  	
	  /*column 6 is for Medium(book,video/dvd,magazine)*/
	  	foreach ($materials as $code=>$collection)
	  	{
	  		if(strcmp($columns[6], $collection)==0)
	  		{
	  			$columns[6]=$code;
	  		}
	  	}
	  
	  if (strlen(trim($columns[6]))==0) {
	  	$columns[6] = '2';
	  }
	   
	  /*column 7 is for comments*/
	  if (strlen(trim($columns[7]))==0) {
	  	$columns[7] = ' ';
	  }
	  
	  /*column 8 is for location id*/
	  if (strlen ( (trim($columns[8]))==0)|| (!is_numeric($columns[8]))) {
	  	$columns[8] = null;
	  }
	   
	   
	  $bibid = $import->alreadyInDB($columns[1]);
	  if ($bibid==0) {
 		  $lastinsertid = $import->insertBiblio($columns);
		  if ($lastinsertid==0) {
		  	//add title to an array
			$b[$rowcount]="Record " . $rowcount . " Unknown error.";
			continue;
		  }
		  $import->insertBiblioCopy($columns,$lastinsertid);
	  } else{
	  	  $import->insertBiblioCopy($columns,$bibid);
	  }		  
    }
	return $b;
  }
 
    
  function layout_links() {
    global $loc;
    echo '<a href="../layouts/default/bulkuploadtitles.xlsx?name=upload_format">'.$loc->getText('adminBulkUpload_list_format_of_file_to_be_uploaded').'</a>';
  }

  $form = array(
    'title'=>$loc->getText("adminBulkUpload_list_Bulk_upload_of_new_bibliographies"),
    'name'=>'bulk_upload',
    'action'=>'../admin/adminBulkUpload_list.php',
    'enctype'=>'multipart/form-data',
    'submit'=>$loc->getText('Upload'),
    'fields'=>array(
      array('name'=>'date', 'title'=>$loc->getText('Date:'), 'type'=>'date', 'default'=>'today'),
      array('name'=>'Excel_file', 'title'=>$loc->getText('adminBulkUpload_list_file'), 'type'=>'file', 'required'=>1),
    ),
  );
  list($values, $errs) = Form::getCgi_el($form['fields']);
  if(!$values['_posted'] or $errs){
    include_once("../shared/header.php");
    if (isset($_REQUEST['msg'])) {
      echo '<font class="error">'.H($_REQUEST['msg']).'</font>';
    }
    $form['values'] = $values;
    $form['errors'] = $errs;
    Form::display($form);
    layout_links();
    include_once("../shared/footer.php");
    exit();
  }
  
  $lines = file($values['Excel_file']['tmp_name']);
  if($lines === false)
    $errors = array("Couldn't read file: ".$values['Excel_file']['tmp_name']);
  else
    $errors = run_batch($lines, $values['date']);
  if($errors) {
    include_once("../shared/header.php");
    echo '<font class="error">'.$loc->getText("Actions which did not produce an error have completed. Think carefully before uploading the same file again, or some circulations may be recorded twice.").'</font>';
    echo '<div class="errorbox">';
    echo '<span class="errorhdr">'.$loc->getText('Errors').'</span>';
    echo '<ul>';
    foreach ($errors as $e) {
      echo '<li>'.H($e).'</li>';
    }
    echo '</ul></div>';
    Form::display($form);
    layout_links();
    include_once("../shared/footer.php");
    exit();
  } else
    header("Location: ../admin/adminBulkUpload_list.php?msg=".U($loc->getText("adminBulkUpload_succesful")));
?>
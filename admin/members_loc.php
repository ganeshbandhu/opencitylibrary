<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "admin";
  $restrictToMbrAuth = TRUE;
  $nav = "MembersOfLocation";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/Location.php");
  require_once("../classes/MemberQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../admin/locationMembers.php");
    exit();
  }

  #****************************************************************************
  #*  Validate data
  #****************************************************************************
  $location = $_POST["locationid"];
  $memQ = new MemberQuery();
  $memQ ->connect();
  $members=$memQ ->getMembersList($location);

	$my_file = '../layouts/default/MembersLocationFile.csv';
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	foreach($members as $member)
	{
		$line=array($member['first_name'],$member['last_name'],$member['barcode_nmbr'],$member['work_phone'],$member['email']);
		fputcsv($handle, $line);
	}

		header('Content-Description: File Transfer'); 
        header('Content-Type: application/octet-stream'); 
        header('Content-Length: ' . filesize($my_file)); 
        header('Content-Disposition: attachment; filename="' . 'MembersLocationFile.csv' . '"'); 
        readfile($my_file);
  
/**
* 
* Retrieval and downloading of books need to be done here
* 
*/  
  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  //$msg = $loc->getText("locNewSuccess");
 // header("Location: ../admin/index.php");
  exit();
?>

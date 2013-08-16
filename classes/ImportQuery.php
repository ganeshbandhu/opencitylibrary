<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Localize.php");
require_once("../classes/BiblioCopyQuery.php");

/******************************************************************************
 * Import data access component for library bibliographies
 *
 * @author Kiran Kumar Reddy and Saiteja Bogade
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class ImportQuery extends Query {

//constructor
function import()	{
	$this->Query();	
}

function insertBiblio($data) {
 
 	$sql  = "INSERT INTO biblio(create_dt, last_change_dt, last_change_userid, collection_cd, material_cd, title, author) ";
	$sql .= " VALUES ('" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s")  . "','" . 995 .  "','"  . $data[4] .  "','" .  $data[5] .  "','" . $data[1] .  "','" . $data[2] . "')";
   	$qShowStatusResult = $this->_act($sql);
	if ($qShowStatusResult==true)
	{
		$insertid=$this->getInsertID();
		$sql="INSERT INTO biblio_field(bibid,fieldid,tag,ind1_cd,ind2_cd,subfield_cd,field_data)";
		$sql.=" VALUES ('".$insertid."','"."  ', '260', 'N', 'N', 'b', '".$data[8]."')";
		$qShowStatusResult=$this->_act($sql);
		if($qShowStatusResult==true)
			return $insertid;
		return 0;
	}
	return 0;
}
/**
 * Inserts data into the biblio table
 * @param $data
 * @return int last insterted id if succesefull
 */
function alreadyInDB($title) {
 	$sql  = "select bibid from biblio where strcmp(title,'" .$title . "')=0";
 	$qShowStatusResult = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($qShowStatusResult);
	if ($row == 0)
		return 0;
	else				  
		return $row["bibid"];
}

/**
 * Inserts data into the biblio_field table
 * @param $data
 * @param $lastInsertID the last inserted id from the biblio table
 * @return nothing
 */

/**
 * inserts data into the biblio_copy table
 * and create barcodes for the insterted titles
 * barcode is a 12 char code based on the book id
 * @param $data
 * @param $lastInsertID the last inserted id from the biblio table
 * @return nothing
 */
function insertBiblioCopy($data, $lastInsertID) {
	$bibQ=new BiblioCopyQuery();
	$barcodenumber=$bibQ->getBarcodeNumber();
	$sql  = "INSERT INTO biblio_copy (create_dt, bibid, barcode_nmbr, status_cd, status_begin_dt, copy_desc , locationid) VALUES ( ";
	$sql .= "'" . date("Y-m-d H:i:s") . "','" . $lastInsertID .  "','" . $barcodenumber . "','" . $data[3] . "','" . date("Y-m-d H:i:s") . "','";
	$sql .= $data[6]. "','".$data[7]."' ) " ;
  	$r = $this->_act($sql);
 	return $r;
}

}
?>
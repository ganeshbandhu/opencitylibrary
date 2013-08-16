<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "deletedone";
  $restrictInDemo = true;
  require_once("../shared/logincheck.php");
  require_once("../classes/LocationQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $locationid = $_GET["locationid"];
  $locationName = $_GET["name"];

  #**************************************************************************
  #*  Delete location
  #**************************************************************************
  $locationQ = new LocationQuery();
  $locationQ->connect();
  $locationQ->delete($locationid);
  $locationQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
  echo $loc->getText("locDelSuccess",array("name"=>$locationName));
  
?>
<br><br>
<a href="../circ/loc_index.php"><?php echo $loc->getText("locDelReturn");?></a>
<?php require_once("../shared/footer.php"); ?>

<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "locedit";
  $focus_form_name = "editLocform";
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");

  require_once("../classes/Location.php");
  require_once("../classes/LocationQuery.php");

  if (isset($_GET["locationid"])){
    $locationid = $_GET["locationid"];
  } else {
    require("../shared/get_form_vars.php");
    $locationid = $postVars["locationid"];
  }
  $locQ = new LocationQuery();
  $locQ->connect();
  $location = $locQ->get($locationid);
  $locQ->close();
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  $headerWording = $loc->getText("locEditForm");

  $cancelLocation = "../circ/loc_view.php?locationid=".$locationid."&reset=Y";
?>

<form name="editLocform" method="POST" action="../circ/loc_edit.php">
<input type="hidden" name="locationid" value="<?php echo H($locationid);?>">
<?php include("../circ/loc_fields.php"); ?>
<?php include("../shared/footer.php"); ?>

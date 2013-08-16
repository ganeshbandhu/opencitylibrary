<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $restrictToMbrAuth = TRUE;
  $nav = "locdelete";
  require_once("../shared/logincheck.php");
  require_once("../classes/Location.php");
  require_once("../classes/LocationQuery.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  $locationid = $_GET["locationid"];

  #****************************************************************************
  #*  Getting Location name
  #****************************************************************************
  $locQ = new LocationQuery();
  $locQ->connect();
  $location = $locQ->get($locationid);
  $locQ->close();
  $locationName = $location->getAddressOne()." ".$location->getAddressTwo();

  #****************************************************************************
  #*  Check to see if there are any books checked out
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->checkoutLocationQuery($locationid)) {
    $biblioQ->close();
    $checkoutCount = 5;
  }

  
  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
  if ($checkoutCount > 0) {
  	?>
  <center>
    <?php echo $loc->getText("locDelConfirmWarn",array("name"=>$locationName)); ?>
    <br><br>
    <a href="../circ/loc_view.php?locationid=<?php echo HURL($locationid);?>&amp;reset=Y"><?php echo $loc->getText("locDelConfirmReturn"); ?></a>
  </center>
  
  <?php
    } else {
  ?>
    

<center>
<form name="delLocationform" method="POST" action="../circ/loc_view.php?locationid=<?php echo HURL($locationid);?>&amp;reset=Y">
<?php echo $loc->getText("locDelConfirmMsg",array("name"=>$locationName)); ?>
<br><br>
      <input type="button" onClick="self.location='../circ/loc_del.php?locationid=<?php echo H(addslashes(U($locationid)));?>&amp;name=<?php echo H(addslashes(U($locationName)));?>'" value="<?php echo $loc->getText("circDelete"); ?>" class="button">
      <input type="submit" value="<?php echo $loc->getText("circCancel"); ?>" class="button">
</form>
</center>
<?php 
}
  include("../shared/footer.php");
?>
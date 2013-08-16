<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  require_once("../functions/inputFuncs.php");
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  
  $staffQ = new StaffQuery();
  $staffQ->connect();
  $all_staff=$staffQ->getAllStaff();
  $staffnames=$staffQ->getAssoc($all_staff);
  $staffQ->close();
  
    
  $fields = array(
    "locFldsAddr1" => inputField('text', "location", $location->getAddressOne()),
    "locFldsAddr2" => inputField('text', "address", $location->getAddressTwo()),
  	"locstaffid" =>inputField('select', 'staffid', $location->getStaffid(),NULL,$staffnames),	
    "locFldsCity" => inputField('text', "city", $location->getCity()),  		
    "locFldsPincode" => inputField('text', "pincode", $location->getPincode()),
    "locFldsState" => inputField('text', "state", $location->getState()),
  	"locFldsDays" => inputField('text', "days", $location->getDays()),
  	"locFldsTime" => inputField('text', "time", $location->getTime()),
  	"locFldsLatitude" => inputField('text', "latitude", $location->getLatitude()),
  	"locFldsLongitude" => inputField('text', "longitude", $location->getLongitude()),
  		
  		
  );

?>


<table class="primary">
  <tr>
    <th colspan="2" valign="top" nowrap="yes" align="left">
      <?php echo H($headerWording);?> <?php echo $loc->getText("locFldsHeader"); ?>
    </td>
  </tr>
<?php
  foreach ($fields as $title => $html) {
?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText($title); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $html; ?>
    </td>
  </tr>
<?php
  }
?>
  <tr>
    <td align="center" colspan="2" class="primary">
      <input type="submit" value="<?php echo $loc->getText("locFldsSubmit"); ?>" class="button">
      <input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="<?php echo $loc->getText("locFldsCancel"); ?>" class="button">
    </td>
  </tr>

</table>

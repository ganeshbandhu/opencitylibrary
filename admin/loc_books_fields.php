<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

  require_once("../functions/inputFuncs.php");
  require_once("../classes/Location.php");
  require_once("../classes/LocationQuery.php");
  
  $locQ = new LocationQuery();
  $locQ->connect();
  $locations=$locQ->getLocations();
  $allLocations=$locQ->getAssoc($locations);
  $locQ->close();
  
    
  $fields = array(
  	"location" =>inputField('select', 'locationid', $location->getLocationid(),NULL,$allLocations),	
  );

?>


<table class="primary">
  <tr>
    <th colspan="2" valign="top" nowrap="yes" align="left">
      <?php echo H($headerWording);?> 
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
      <input type="submit" value="<?php echo $loc->getText("adminSubmit"); ?>" class="button">
      <input type="button" onClick="self.location='<?php echo H(addslashes($cancelLocation));?>'" value="<?php echo $loc->getText("adminCancel"); ?>" class="button">
    </td>
  </tr>

</table>

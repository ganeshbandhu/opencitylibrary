<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  $tab = "circulation";
  $nav = "locview";
  $helpPage = "memberView";

  require_once("../functions/inputFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Location.php");
  require_once("../classes/LocationQuery.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  require_once("../classes/Staff.php");
  require_once("../classes/StaffQuery.php");
  
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../circ/loc_index.php");
    exit();
  }

  
  
  #****************************************************************************
  #*  Retrieving get location id
  #****************************************************************************
  $locationid = $_GET["locationid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".H($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Search database for location
  #****************************************************************************
  $lotQ = new LocationQuery();
  $lotQ->connect();
  $lot = $lotQ->get($locationid);
  $lotQ->close();

  
  $staffQ=new StaffQuery();
  $staffQ->connect();
  $staff = $staffQ->getFirstNameLastName($lot->getStaffid());
  $staffQ->close();
  #**************************************************************************
  #*  Show location information
  #**************************************************************************
  require_once("../shared/header.php");
?>

<?php echo $msg ?>

<table class="primary">
  <tr>
    <th align="left" colspan="2" nowrap="yes">
      <?php echo $loc->getText("locViewHead1"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("locViewAddrOne"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getAddressOne());?>
    </td>
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo $loc->getText("locViewAddrTwo"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getAddressTwo());?>
    </td>
  </tr>
  
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewCity"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getCity());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewState"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getState());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewPincode"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getPincode());?>
    </td>
  </tr>

    <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewDays"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getDays());?>
    </td>
  </tr>
  
    <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewTime"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getTime());?>
    </td>
  </tr>
  
    <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locStaff"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($staff);?>
    </td>
  </tr>
  
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewLatitude"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getLatitude());?>
    </td>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php echo $loc->getText("locViewLongitude"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo H($lot->getLongitude());?>
    </td>
  </tr>
</table>
<?php require_once("../shared/footer.php"); ?>

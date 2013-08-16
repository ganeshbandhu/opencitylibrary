<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "circulation";
  $nav = "search";
  require_once("../shared/logincheck.php");
  require_once("../classes/Location.php");
  require_once("../classes/LocationQuery.php");
  require_once("../functions/searchFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Function declaration only used on this page.
  #****************************************************************************
  function printResultPages($currPage, $pageCount) {
    global $loc;
    $maxPg = 21;
    if ($currPage > 1) {
      echo "<a href=\"javascript:changePage(".H(addslashes($currPage-1)).")\">&laquo;".$loc->getText("locsearchprev")."</a> ";
    }
    for ($i = 1; $i <= $pageCount; $i++) {
      if ($i < $maxPg) {
        if ($i == $currPage) {
          echo "<b>".H($i)."</b> ";
        } else {
          echo "<a href=\"javascript:changePage(".H(addslashes($i)).")\">".H($i)."</a> ";
        }
      } elseif ($i == $maxPg) {
        echo "... ";
      }
    }
    if ($currPage < $pageCount) {
      echo "<a href=\"javascript:changePage(".($currPage+1).")\">".$loc->getText("locsearchnext")."&raquo;</a> ";
    }
  }

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_POST) == 0) {
    header("Location: ../circ/loc_index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving post vars and scrubbing the data
  #****************************************************************************
  if (isset($_POST["page"])) {
    $currentPageNmbr = $_POST["page"];
  } else {
    $currentPageNmbr = 1;
  }
  $searchType = $_POST["searchType"];
  $searchText = trim($_POST["searchText"]);
  # remove redundant whitespace
  $searchText = preg_replace('/\s+/', " ", $searchText);

  if ($searchType == "location") {
    $sType = OBIB_SEARCH_LOCATION;
  } 

  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $lotQ = new LocationQuery();
  $lotQ->setItemsPerPage(OBIB_ITEMS_PER_PAGE);
  $lotQ->connect();
  $lotQ->execSearch($sType,$searchText,$currentPageNmbr);

  #**************************************************************************
  #*  Show location view screen if only one result from location search query
  #**************************************************************************
  if (($sType == OBIB_SEARCH_LOCATION) && ($lotQ->getRowCount() == 1)) {
    $lot = $lotQ->fetchLocation();
    $lotQ->close();
    header("Location: ../circ/loc_view.php?locationid=".U($lot->getLocationid())."&reset=Y");
    exit();
  }

  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  require_once("../shared/header.php");

  # Display no results message if no results returned from search.
  if ($lotQ->getRowCount() == 0) {
    $lotQ->close();
    echo $loc->getText("locsearchNoResults");
    require_once("../shared/footer.php");
    exit();
  }
?>

<!--**************************************************************************
    *  Javascript to post back to this page
    ************************************************************************** -->
<script language="JavaScript" type="text/javascript">
<!--
function changePage(page)
{
  document.changePageForm.page.value = page;
  document.changePageForm.submit();
}
-->
</script>


<!--**************************************************************************
    *  Form used by javascript to post back to this page
    ************************************************************************** -->
<form name="changeLocPageForm" method="POST" action="../circ/loc_search.php">
  <input type="hidden" name="searchType" value="<?php echo H($_POST["searchType"]);?>">
  <input type="hidden" name="searchText" value="<?php echo H($_POST["searchText"]);?>">
  <input type="hidden" name="page" value="1">
</form>

<!--**************************************************************************
    *  Printing result stats and page nav
    ************************************************************************** -->
<?php echo H($lotQ->getRowCount()); echo $loc->getText("locsearchFoundResults");?><br>
<?php printResultPages($currentPageNmbr, $lotQ->getPageCount()); ?><br>
<br>

<!--**************************************************************************
    *  Printing result table
    ************************************************************************** -->
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left" colspan="2">
      <?php echo $loc->getText("locsearchSearchResults");?>
    </th>
  </tr>
  <?php
    while ($location = $lotQ->fetchLocation()) {
  ?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php echo H($lotQ->getCurrentRowNmbr());?>.
    </td>
    <td nowrap="true" class="primary">
      <a href="../circ/loc_view.php?locationid=<?php echo HURL($location->getLocationid());?>&amp;reset=Y"><?php echo H($location->getAddressOne());?></a><br>
      <?php
        if ($location->getAddressTwo() != "")
          echo str_replace("\n", "<br />", H($location->getAddressTwo())).'<br />';
      ?>
      <b><?php echo $loc->getText("locsearchCity");?></b> <?php echo H($location->getCity());?>
      <b><?php echo $loc->getText("locsearchState");?></b> <?php echo H($location->getState());?>
    </td>
  </tr>


  <?php
    }
    $lotQ->close();
  ?>
  </table><br>
<?php printResultPages($currentPageNmbr, $lotQ->getPageCount()); ?><br>
<?php require_once("../shared/footer.php"); ?>

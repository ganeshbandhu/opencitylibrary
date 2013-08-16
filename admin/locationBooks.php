<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");
  session_cache_limiter(null);

  $tab = "admin";
  $restrictToMbrAuth = TRUE;
  $nav = "BooksForLocation";
  $cancelLocation = "../admin/index.php"; 
  $focus_form_name = "newlocform";

  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../shared/get_form_vars.php");
  require_once("../shared/header.php");
  require_once("../classes/Location.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  $headerWording = $loc->getText("BooksForLocation");
  $location = new Location();
?>
<form name="bookslocform" method="POST" action="../admin/books_loc.php">
<?php include("../admin/loc_books_fields.php"); ?>
<?php include("../shared/footer.php"); ?>

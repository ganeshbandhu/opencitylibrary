<?php
	require_once("../shared/common.php");
	$tab = "admin";
	$restrictToMbrAuth = TRUE;
	$nav = "BooksForLocation";
	$restrictInDemo = true;
	require_once("../shared/logincheck.php");
	require_once("../classes/Location.php");
	require_once("../classes/BiblioCopyQuery.php");
	require_once("../functions/errorFuncs.php");
	require_once("../classes/Localize.php");
	$loc = new Localize(OBIB_LOCALE,$tab);
	
	
?>
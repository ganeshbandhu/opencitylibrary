<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../classes/Localize.php");
  $navloc = new Localize(OBIB_LOCALE,"navbars");
 
?>
<input type="button" onClick="self.location='../shared/logout.php'" value="<?php echo $navloc->getText("Logout"); ?>" class="navbutton"><br />
<br />

<?php if ($nav == "searchform") { ?>
 &raquo; <?php echo $navloc->getText("memberSearch"); ?><br>
<?php } else { ?>
 <a href="../circ/index.php" class="alt1"><?php echo $navloc->getText("memberSearch"); ?></a><br>
<?php } ?>

<?php if ($nav == "search") { ?>
 &nbsp; &raquo; <?php echo $navloc->getText("catalogResults"); ?><br>
<?php } ?>

<?php if ($nav == "view") { ?>
 &nbsp; &raquo; <?php echo $navloc->getText("memberInfo"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "edit") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("editInfo"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "delete") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("catalogDelete"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "hist") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_account.php?mbrid=<?php echo HURL($mbrid);?>&amp;reset=Y" class="alt1"><?php echo $navloc->getText("account"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("checkoutHistory"); ?><br>
<?php } ?>

<?php if ($nav == "account") { ?>
 &nbsp; <a href="../circ/mbr_view.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("memberInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_edit_form.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("editInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/mbr_del_confirm.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("catalogDelete"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("account"); ?><br>
 &nbsp; &nbsp; <a href="../circ/mbr_history.php?mbrid=<?php echo HURL($mbrid);?>" class="alt1"><?php echo $navloc->getText("checkoutHistory"); ?></a><br>
<?php } ?>

<?php if ($nav == "new") { ?>
 &raquo; <?php echo $navloc->getText("newMember"); ?><br>
<?php } else { ?>
 <a href="../circ/mbr_new_form.php?reset=Y" class="alt1"><?php echo $navloc->getText("newMember"); ?></a><br>
<?php } ?>

<?php if ($nav == "checkin") { ?>
 &raquo; <?php echo $navloc->getText("checkIn"); ?><br>
<?php } else { ?>
 <a href="../circ/checkin_form.php?reset=Y" class="alt1"><?php echo $navloc->getText("checkIn"); ?></a><br>
<?php } ?>
<!--  #C1 - Adding location tab to add/edit/view location details -->

<?php if ($nav == "locsearchform") { ?>
 &raquo; <?php echo $navloc->getText("locationSearch"); ?><br>
<?php } else { ?>
 <a href="../circ/loc_index.php?reset=Y" class="alt1"><?php echo $navloc->getText("locationSearch"); ?></a><br>
<?php } ?>
<?php if ($nav == "locview") { ?>
 &nbsp; &raquo; <?php echo $navloc->getText("locationInfo"); ?><br>
 &nbsp; &nbsp; <a href="../circ/loc_edit_form.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationeditInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/loc_del_confirm.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationDelete"); ?></a><br>
<?php } ?>

<?php if ($nav == "locedit") { ?>
 &nbsp; &nbsp; <a href="../circ/loc_view.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("editInfo"); ?><br>
 &nbsp; &nbsp; <a href="../circ/loc_del_confirm.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationDelete"); ?></a><br>
<?php } ?>

<?php if ($nav == "locdelete") { ?>
 &nbsp; &nbsp; <a href="../circ/loc_view.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationInfo"); ?></a><br>
 &nbsp; &nbsp; <a href="../circ/loc_edit_form.php?locationid=<?php echo HURL($locationid);?>" class="alt1"><?php echo $navloc->getText("locationeditInfo"); ?></a><br>
 &nbsp; &nbsp; &raquo; <?php echo $navloc->getText("locDelete"); ?><br>
<?php } ?>


<?php if ($nav == "newLocation") { ?>
 &raquo; <?php echo $navloc->getText("newLocation"); ?><br>
<?php } else { ?>
 <a href="../circ/loc_new_form.php?reset=Y" class="alt1"><?php echo $navloc->getText("newLocation"); ?></a><br>
<?php } ?>


<?php if ($nav == "offline") { ?>
 &raquo; <?php echo $navloc->getText("Offline Circulation"); ?><br>
<?php } else { ?>
 <a href="../circ/offline.php" class="alt1"><?php echo $navloc->getText("Offline Circulation"); ?></a><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".H(addslashes(U($helpPage))); ?>')"><?php echo $navloc->getText("help"); ?></a>

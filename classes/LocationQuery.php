<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
*/

require_once("../shared/global_constants.php");
require_once("../classes/Location.php");
require_once("../classes/Query.php");

/******************************************************************************
 * MemberQuery data access component for library members
*
* @author David Stevens <dave@stevens.name>;
* @version 1.0
* @access public
******************************************************************************
*/
class LocationQuery extends Query {
	var $_itemsPerPage = 1;
	var $_rowNmbr = 0;
	var $_currentRowNmbr = 0;
	var $_currentPageNmbr = 0;
	var $_rowCount = 0;
	var $_pageCount = 0;

  function setItemsPerPage($value) {
    $this->_itemsPerPage = $value;
  }
  function getCurrentRowNmbr() {
    return $this->_currentRowNmbr;
  }
  function getRowCount() {
    return $this->_rowCount;
  }
  function getPageCount() {
    return $this->_pageCount;
  }
  
  	function getLocations(){
		$sql = $this->mkSQL("select locationid, loc_address_one, loc_address_two from biblio_location ");
		return array_map(array($this, '_mkObj'), $this->exec($sql));
	}
	function getAssoc($allLocations)
	{
		$assoc = array();
  		foreach ($allLocations as $location) {
  			$assoc[$location->getLocationid()] = $location->getAddressOne()."-".$location->getAddressTwo();
  		}
  		return $assoc;
	}
	
  /* * Used to select the distinct locations from the database
   * *
   * */
	function getLocationsForCity($city){
		$sql = $this->mkSQL("select locationid, loc_address_one, loc_address_two, loc_latitude, loc_longitude ,staffid 
					 from biblio_location where loc_city = %Q ", $city);
		return array_map(array($this, '_mkObj'), $this->exec($sql));
	}
	function getLocationsInTheSameCityAs($locationid){
		$sql = $this->mkSQL("select locationid, loc_address_one, loc_address_two, loc_latitude, loc_longitude ,staffid 
					 from biblio_location where loc_city = (select loc_city from biblio_location where locationid = %N) ", $locationid);
		return array_map(array($this, '_mkObj'), $this->exec($sql));
	}


// Newely added function on 15-aug-2013	
	function getStaffOfLocation($locid)
	{
	  	$sql = $this->mkSQL("SELECT staffid as staff FROM biblio_location where locationid=%N",$locid);
	  	$result=$this->exec($sql);
	  	$staffid=$result[0]['staff'];
	  	return $staffid;	

	}

	/****************************************************************************
	 * Executes a query
	* @param string $type one of the global constants
	*               OBIB_SEARCH_BARCODE or OBIB_SEARCH_NAME
	* @param string $word String to search for
	* @param integer $page What page should be returned if results are more than one page
	* @access public
	****************************************************************************
	*/
	function execSearch($type, $word, $page) {
		# reset stats
		$this->_rowNmbr = 0;
		$this->_currentRowNmbr = 0;
		$this->_currentPageNmbr = $page;
		$this->_rowCount = 0;
		$this->_pageCount = 0;

		# Building sql statements
		if ($type == OBIB_SEARCH_LOCATION) {
			$col = "loc_address_two";
		}

		# Building sql statements
		$sql = $this->mkSQL("from biblio_location where %C like %Q ", $col, $word."%");
		$sqlcount = "select count(*) as rowcount ".$sql;
		$sql = "select * ".$sql;
		$sql .= " order by loc_address_one, loc_address_two";
		# setting limit so we can page through the results
		$offset = ($page - 1) * $this->_itemsPerPage;
		$limit = $this->_itemsPerPage;
		$sql .= $this->mkSQL(" limit %N, %N ", $offset, $limit);
		#echo "sql=[".$sql."]<br>\n";

		# Running row count sql statement
		$rows = $this->exec($sqlcount);
		if (count($rows) != 1) {
			Fatal::internalError("Wrong number of count rows");
		}
		# Calculate stats based on row count
		$this->_rowCount = $rows[0]["rowcount"];
		$this->_pageCount = ceil($this->_rowCount / $this->_itemsPerPage);

		# Running search sql statement
		$this->_exec($sql);
	}


	/****************************************************************************
	 * Executes a query
	* @param string $locid Location id of library to select
	* @return boolean returns false, if error occurs
	* @access public
	****************************************************************************
	*/
	function get($locationid) {
		$sql = $this->mkSQL("select location.* from biblio_location location"
				. " where locationid=%N ", $locationid);
		$rows = $this->exec($sql);
		if (count($rows) != 1) {
			Fatal::internalError("Bad Location Id");
		}
		return $this->_mkObj($rows[0]);
	}
	
	
  /*Used to get the location of a particular book given the location id*/
  function getForBiblioCopy($locationid) {
  	$sql = $this->mkSQL("select location.* from biblio_location location"
  			. " where locationid=%N ", $locationid);
  	$rows = $this->exec($sql);
  	if (count($rows) == 0) {
  		return null;
  	}
  	$location= $this->_mkObj($rows[0]);
  	return $location->getAddressOne()."-".$location->getAddressTwo();
  }


	/****************************************************************************
	 * Fetches a row from the query result and populates the Location object.
	* @return Location returns library location or false if no more locations to fetch
	* @access public
	****************************************************************************
	*/
	function fetchLocation() {
		$array = $this->_conn->fetchRow();
		if ($array == false) {
			return false;
		}
		# increment rowNmbr
		$this->_rowNmbr = $this->_rowNmbr + 1;
		$this->_currentRowNmbr = $this->_rowNmbr + (($this->_currentPageNmbr - 1) * $this->_itemsPerPage);
		return $this->_mkObj($array);
	}

	function _mkObj($array) {
		$location = new Location();
		$location->setLocationid($array["locationid"]);
		$location->setAddressOne($array["loc_address_one"]);
		$location->setAddressTwo($array["loc_address_two"]);
		$location->setLastChangeDt($array["last_change_dt"]);
		$location->setStaffid($array["staffid"]);
		$location->setLastChangeUserid($array["last_change_userid"]);
		if (isset($array["username"])) {
			$location->setLastChangeUsername($array["username"]);
		}
		$location->setPincode($array["loc_pincode"]);
		$location->setCity($array["loc_city"]);
		$location->setState($array["loc_state"]);
		$location->setDays($array["loc_days"]);
		$location->setTime($array["loc_time"]);
		$location->setLatitude($array["loc_latitude"]);
		$location->setLongitude($array["loc_longitude"]);


		return $location;
	}

	/****************************************************************************
	 * Inserts a new library location into the member table.
	* @param Member $mbr library member to insert
	* @return integer the id number of the newly inserted member
	* @access public
	****************************************************************************
	*/
	function insert($location) {
		$sql = $this->mkSQL("insert into biblio_location "
				. "(locationid, create_dt, last_change_dt, "
				. " last_change_userid, staffid, loc_address_one, loc_address_two, "
				. " loc_city, loc_state, loc_pincode,loc_latitude, loc_longitude, loc_days, loc_time ) "
				. "values (null, sysdate(), sysdate(), %N, %N ,"
				. " %Q, %Q, %Q, %Q, %Q, %Q, %Q, %Q, %Q) ",
				$location->getLastChangeUserid(), $location->getStaffid(),
				$location->getAddressOne(), $location->getAddressTwo(),
				$location->getCity(),
				$location->getState(), $location->getPincode(),$location->getLatitude(),
				$location->getLongitude(), $location->getDays(), $location->getTime());

		$this->exec($sql);
		$locationid = $this->_conn->getInsertId();
		return $locationid;

	}

	/****************************************************************************
	 * Update a library member in the member table.
	* @param Member $mbr library member to update
	* @access public
	****************************************************************************
	*/
	function update($location) {
		$sql = $this->mkSQL("update biblio_location set "
				. " last_change_dt = sysdate(), last_change_userid=%N, staffid=%N ,"
				. " loc_address_one=%Q,  loc_address_two=%Q, "
				. " loc_city=%Q, loc_state=%Q, "
				. " loc_pincode=%Q, "
				. " loc_latitude=%Q, loc_longitude=%Q, loc_days=%Q, loc_time=%Q"
				. " where locationid=%N",
				$location->getLastChangeUserid(), $location->getStaffid(),
				$location->getAddressOne(), $location->getAddressTwo(),
				$location->getCity(),
				$location->getState(), $location->getPincode(),$location->getLatitude(), $location->getLongitude(),
				$location->getDays(),$location->getTime(),
				$location->getLocationid());

		$this->exec($sql);
		//$this->setCustomFields($mbr->getMbrid(), $mbr->_custom);
	}

	/****************************************************************************
	 * Deletes a library location from the member table.
	* @param string $mbrid Member id of library member to delete
	* @access public
	****************************************************************************
	*/

	function delete($locid) {
		$sql = $this->mkSQL("delete from biblio_location where locationid = %N ", $locid);
		$this->exec($sql);
	}

}


?>

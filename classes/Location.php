<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
*/

require_once("../functions/formatFuncs.php");

/****************************************************************************
 * Location represents a library location.  Contains business rules for
* location data validation.
*
* @author Ganesh Margabandhu <dave@stevens.name>;
* @version 1.0
* @access public
******************************************************************************
*/
class Location {
	var $_addr1 = 0;
	var $_addr1Error = 0;
	var $_addr2 = 0;
	var $_addr2Error = 0;
	var $_createDt = "";
	var $_lastChangeDt = "";
	var $_staffid;
	var $_lastChangeUserid = "";
	var $_locationid = "";
	var $_pincode = "";
	var $_pincodeError = "";
	var $_state = "";
	var $_city = "";
	var $_days= "";
	var $_time= "";
	var $_latitude="";
	var $_longitude="";

	/****************************************************************************
	 * @return boolean true if data is valid, otherwise false.
	* @access public
	****************************************************************************
	*/
	function validateData() {
		$valid = true;
		if ($this->_addr1== "") {
			$valid = false;
			$this->_addr1Error  = "Location Address Line 1 is required.";
		}
		if ($this->_addr2 == "") {
			$valid = false;
			$this->_addr2Error = "Location Address Line 2 is required.";
		}
		if ($this->_pincode == "") {
			$valid = false;
			$this->_pincodeError = "Pincode is required.";
		}

		return $valid;
	}


	/****************************************************************************
	 * Getter methods for all fields
	* @return string
	* @access public
	****************************************************************************
	*/
	function getAddressOne() {
		return $this->_addr1;
	}
	function getAddressTwo() { 
		return $this->_addr2;
	}
	function getAddress1Error() {
		return $this->__addr1Error;
	}
	function getAddress2Error() {
		return $this->__addr2Error;
	}
	function getStaffid(){
		return $this->_staffid;
	}
	function getCreateDt() {
		return $this->_createDt;
	}
	function getLastChangeDt() {
		return $this->_lastChangeDt;
	}
	function getLastChangeUserid() {
		return $this->_lastChangeUserid;
	}
	function getLocationid() {
		return $this->_locationid;
	}
	function getPincode() {
		return $this->_pincode;
	}
	function getPincodeError() {
		return $this->_pincodeError;
	}
	function getState() {
		return $this->_state;
	}
	function getCity() {
		return $this->_city;
	}
	function getLatitude(){
		return $this->_latitude;
	}
	function getLongitude()
	{
		return $this->_longitude;
	}
	function getDays()
	{
		return $this->_days;
	}
	function getTime()
	{
		return $this->_time;
	}


	/****************************************************************************
	 * Setter methods for all fields
	* @param string $value new value to set
	* @return void
	* @access public
	****************************************************************************
	*/
	function setAddressOne($value) {
		$this->_addr1 = trim($value);
	}
	function setAddressOneError($value) {
		$this->_addr1Error = trim($value);
	}
	function setAddressTwo($value) {
		$this->_addr2 = trim($value);
	}
	function setAddressTwoError($value) {
		$this->_addr2Error = trim($value);
	}
	function setCreateDt($value) {
		$this->_createDt = trim($value);
	}
	function setLastChangeDt($value) {
		$this->_lastChangeDt = trim($value);
	}
	function setLastChangeUserid($value) {
		$this->_lastChangeUserid = trim($value);
	}
	function setStaffid($staffid){
		$this->_staffid = trim($staffid);
	}
	function setLocationid($value) {
		$this->_locationid = trim($value);
	}
	function setPincode($value) {
		$this->_pincode = trim($value);
	}
	function setPincodeError($value) {
		$this->_pincodeError = trim($value);
	}
	function setCity($value) {
		$this->_city = trim($value);
	}
	function setState($value) {
		$this->_state = trim($value);
	}
	function setLatitude($value){
		$this->_latitude = trim($value);
	}
	function setLongitude($value){
		$this->_longitude = trim($value);
	}
	function setDays($value)
	{
		$this->_days=trim($value);
	}
	function setTime($value)
	{
		$this->_time=trim($value);
	}
}

?>
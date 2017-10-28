<?php

// Global variable for table object
$hotel_booking = NULL;

//
// Table class for hotel_booking
//
class chotel_booking extends cTable {
	var $booking_id;
	var $hroom_id;
	var $customer_id;
	var $hotel_id;
	var $room_type;
	var $max_adult;
	var $max_child;
	var $cus_email;
	var $cus_passport;
	var $cus_pickup;
	var $check_in;
	var $check_out;
	var $max_day_stay;
	var $total_amount;
	var $booking_status;
	var $notes;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotel_booking';
		$this->TableName = 'hotel_booking';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotel_booking`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// booking_id
		$this->booking_id = new cField('hotel_booking', 'hotel_booking', 'x_booking_id', 'booking_id', '`booking_id`', '`booking_id`', 20, -1, FALSE, '`booking_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->booking_id->Sortable = TRUE; // Allow sort
		$this->booking_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['booking_id'] = &$this->booking_id;

		// hroom_id
		$this->hroom_id = new cField('hotel_booking', 'hotel_booking', 'x_hroom_id', 'hroom_id', '`hroom_id`', '`hroom_id`', 20, -1, FALSE, '`hroom_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hroom_id->Sortable = TRUE; // Allow sort
		$this->hroom_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hroom_id'] = &$this->hroom_id;

		// customer_id
		$this->customer_id = new cField('hotel_booking', 'hotel_booking', 'x_customer_id', 'customer_id', '`customer_id`', '`customer_id`', 20, -1, FALSE, '`customer_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->customer_id->Sortable = TRUE; // Allow sort
		$this->customer_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['customer_id'] = &$this->customer_id;

		// hotel_id
		$this->hotel_id = new cField('hotel_booking', 'hotel_booking', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// room_type
		$this->room_type = new cField('hotel_booking', 'hotel_booking', 'x_room_type', 'room_type', '`room_type`', '`room_type`', 200, -1, FALSE, '`room_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->room_type->Sortable = TRUE; // Allow sort
		$this->fields['room_type'] = &$this->room_type;

		// max_adult
		$this->max_adult = new cField('hotel_booking', 'hotel_booking', 'x_max_adult', 'max_adult', '`max_adult`', '`max_adult`', 3, -1, FALSE, '`max_adult`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->max_adult->Sortable = TRUE; // Allow sort
		$this->max_adult->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['max_adult'] = &$this->max_adult;

		// max_child
		$this->max_child = new cField('hotel_booking', 'hotel_booking', 'x_max_child', 'max_child', '`max_child`', '`max_child`', 3, -1, FALSE, '`max_child`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->max_child->Sortable = TRUE; // Allow sort
		$this->max_child->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['max_child'] = &$this->max_child;

		// cus_email
		$this->cus_email = new cField('hotel_booking', 'hotel_booking', 'x_cus_email', 'cus_email', '`cus_email`', '`cus_email`', 200, -1, FALSE, '`cus_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_email->Sortable = TRUE; // Allow sort
		$this->fields['cus_email'] = &$this->cus_email;

		// cus_passport
		$this->cus_passport = new cField('hotel_booking', 'hotel_booking', 'x_cus_passport', 'cus_passport', '`cus_passport`', '`cus_passport`', 200, -1, FALSE, '`cus_passport`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_passport->Sortable = TRUE; // Allow sort
		$this->fields['cus_passport'] = &$this->cus_passport;

		// cus_pickup
		$this->cus_pickup = new cField('hotel_booking', 'hotel_booking', 'x_cus_pickup', 'cus_pickup', '`cus_pickup`', '`cus_pickup`', 200, -1, FALSE, '`cus_pickup`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_pickup->Sortable = TRUE; // Allow sort
		$this->fields['cus_pickup'] = &$this->cus_pickup;

		// check_in
		$this->check_in = new cField('hotel_booking', 'hotel_booking', 'x_check_in', 'check_in', '`check_in`', ew_CastDateFieldForLike('`check_in`', 0, "DB"), 135, 0, FALSE, '`check_in`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->check_in->Sortable = TRUE; // Allow sort
		$this->check_in->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['check_in'] = &$this->check_in;

		// check_out
		$this->check_out = new cField('hotel_booking', 'hotel_booking', 'x_check_out', 'check_out', '`check_out`', ew_CastDateFieldForLike('`check_out`', 0, "DB"), 135, 0, FALSE, '`check_out`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->check_out->Sortable = TRUE; // Allow sort
		$this->check_out->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['check_out'] = &$this->check_out;

		// max_day_stay
		$this->max_day_stay = new cField('hotel_booking', 'hotel_booking', 'x_max_day_stay', 'max_day_stay', '`max_day_stay`', '`max_day_stay`', 3, -1, FALSE, '`max_day_stay`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->max_day_stay->Sortable = TRUE; // Allow sort
		$this->max_day_stay->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['max_day_stay'] = &$this->max_day_stay;

		// total_amount
		$this->total_amount = new cField('hotel_booking', 'hotel_booking', 'x_total_amount', 'total_amount', '`total_amount`', '`total_amount`', 131, -1, FALSE, '`total_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_amount->Sortable = TRUE; // Allow sort
		$this->total_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_amount'] = &$this->total_amount;

		// booking_status
		$this->booking_status = new cField('hotel_booking', 'hotel_booking', 'x_booking_status', 'booking_status', '`booking_status`', '`booking_status`', 3, -1, FALSE, '`booking_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->booking_status->Sortable = TRUE; // Allow sort
		$this->booking_status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['booking_status'] = &$this->booking_status;

		// notes
		$this->notes = new cField('hotel_booking', 'hotel_booking', 'x_notes', 'notes', '`notes`', '`notes`', 201, -1, FALSE, '`notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->notes->Sortable = TRUE; // Allow sort
		$this->fields['notes'] = &$this->notes;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotel_booking`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->booking_id->setDbValue($conn->Insert_ID());
			$rs['booking_id'] = $this->booking_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('booking_id', $rs))
				ew_AddFilter($where, ew_QuotedName('booking_id', $this->DBID) . '=' . ew_QuotedValue($rs['booking_id'], $this->booking_id->FldDataType, $this->DBID));
			if (array_key_exists('hroom_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hroom_id', $this->DBID) . '=' . ew_QuotedValue($rs['hroom_id'], $this->hroom_id->FldDataType, $this->DBID));
			if (array_key_exists('customer_id', $rs))
				ew_AddFilter($where, ew_QuotedName('customer_id', $this->DBID) . '=' . ew_QuotedValue($rs['customer_id'], $this->customer_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`booking_id` = @booking_id@ AND `hroom_id` = @hroom_id@ AND `customer_id` = @customer_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->booking_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@booking_id@", ew_AdjustSql($this->booking_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->hroom_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hroom_id@", ew_AdjustSql($this->hroom_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->customer_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@customer_id@", ew_AdjustSql($this->customer_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "hotel_bookinglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotel_bookinglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotel_bookingview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotel_bookingview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotel_bookingadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotel_bookingadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotel_bookingedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotel_bookingadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotel_bookingdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "booking_id:" . ew_VarToJson($this->booking_id->CurrentValue, "number", "'");
		$json .= ",hroom_id:" . ew_VarToJson($this->hroom_id->CurrentValue, "number", "'");
		$json .= ",customer_id:" . ew_VarToJson($this->customer_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->booking_id->CurrentValue)) {
			$sUrl .= "booking_id=" . urlencode($this->booking_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->hroom_id->CurrentValue)) {
			$sUrl .= "&hroom_id=" . urlencode($this->hroom_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->customer_id->CurrentValue)) {
			$sUrl .= "&customer_id=" . urlencode($this->customer_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["booking_id"]))
				$arKey[] = ew_StripSlashes($_POST["booking_id"]);
			elseif (isset($_GET["booking_id"]))
				$arKey[] = ew_StripSlashes($_GET["booking_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["hroom_id"]))
				$arKey[] = ew_StripSlashes($_POST["hroom_id"]);
			elseif (isset($_GET["hroom_id"]))
				$arKey[] = ew_StripSlashes($_GET["hroom_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["customer_id"]))
				$arKey[] = ew_StripSlashes($_POST["customer_id"]);
			elseif (isset($_GET["customer_id"]))
				$arKey[] = ew_StripSlashes($_GET["customer_id"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 3)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // booking_id
					continue;
				if (!is_numeric($key[1])) // hroom_id
					continue;
				if (!is_numeric($key[2])) // customer_id
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->booking_id->CurrentValue = $key[0];
			$this->hroom_id->CurrentValue = $key[1];
			$this->customer_id->CurrentValue = $key[2];
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->booking_id->setDbValue($rs->fields('booking_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->room_type->setDbValue($rs->fields('room_type'));
		$this->max_adult->setDbValue($rs->fields('max_adult'));
		$this->max_child->setDbValue($rs->fields('max_child'));
		$this->cus_email->setDbValue($rs->fields('cus_email'));
		$this->cus_passport->setDbValue($rs->fields('cus_passport'));
		$this->cus_pickup->setDbValue($rs->fields('cus_pickup'));
		$this->check_in->setDbValue($rs->fields('check_in'));
		$this->check_out->setDbValue($rs->fields('check_out'));
		$this->max_day_stay->setDbValue($rs->fields('max_day_stay'));
		$this->total_amount->setDbValue($rs->fields('total_amount'));
		$this->booking_status->setDbValue($rs->fields('booking_status'));
		$this->notes->setDbValue($rs->fields('notes'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// booking_id
		// hroom_id
		// customer_id
		// hotel_id
		// room_type
		// max_adult
		// max_child
		// cus_email
		// cus_passport
		// cus_pickup
		// check_in
		// check_out
		// max_day_stay
		// total_amount
		// booking_status
		// notes
		// booking_id

		$this->booking_id->ViewValue = $this->booking_id->CurrentValue;
		$this->booking_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// room_type
		$this->room_type->ViewValue = $this->room_type->CurrentValue;
		$this->room_type->ViewCustomAttributes = "";

		// max_adult
		$this->max_adult->ViewValue = $this->max_adult->CurrentValue;
		$this->max_adult->ViewCustomAttributes = "";

		// max_child
		$this->max_child->ViewValue = $this->max_child->CurrentValue;
		$this->max_child->ViewCustomAttributes = "";

		// cus_email
		$this->cus_email->ViewValue = $this->cus_email->CurrentValue;
		$this->cus_email->ViewCustomAttributes = "";

		// cus_passport
		$this->cus_passport->ViewValue = $this->cus_passport->CurrentValue;
		$this->cus_passport->ViewCustomAttributes = "";

		// cus_pickup
		$this->cus_pickup->ViewValue = $this->cus_pickup->CurrentValue;
		$this->cus_pickup->ViewCustomAttributes = "";

		// check_in
		$this->check_in->ViewValue = $this->check_in->CurrentValue;
		$this->check_in->ViewValue = ew_FormatDateTime($this->check_in->ViewValue, 0);
		$this->check_in->ViewCustomAttributes = "";

		// check_out
		$this->check_out->ViewValue = $this->check_out->CurrentValue;
		$this->check_out->ViewValue = ew_FormatDateTime($this->check_out->ViewValue, 0);
		$this->check_out->ViewCustomAttributes = "";

		// max_day_stay
		$this->max_day_stay->ViewValue = $this->max_day_stay->CurrentValue;
		$this->max_day_stay->ViewCustomAttributes = "";

		// total_amount
		$this->total_amount->ViewValue = $this->total_amount->CurrentValue;
		$this->total_amount->ViewCustomAttributes = "";

		// booking_status
		$this->booking_status->ViewValue = $this->booking_status->CurrentValue;
		$this->booking_status->ViewCustomAttributes = "";

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

		// booking_id
		$this->booking_id->LinkCustomAttributes = "";
		$this->booking_id->HrefValue = "";
		$this->booking_id->TooltipValue = "";

		// hroom_id
		$this->hroom_id->LinkCustomAttributes = "";
		$this->hroom_id->HrefValue = "";
		$this->hroom_id->TooltipValue = "";

		// customer_id
		$this->customer_id->LinkCustomAttributes = "";
		$this->customer_id->HrefValue = "";
		$this->customer_id->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// room_type
		$this->room_type->LinkCustomAttributes = "";
		$this->room_type->HrefValue = "";
		$this->room_type->TooltipValue = "";

		// max_adult
		$this->max_adult->LinkCustomAttributes = "";
		$this->max_adult->HrefValue = "";
		$this->max_adult->TooltipValue = "";

		// max_child
		$this->max_child->LinkCustomAttributes = "";
		$this->max_child->HrefValue = "";
		$this->max_child->TooltipValue = "";

		// cus_email
		$this->cus_email->LinkCustomAttributes = "";
		$this->cus_email->HrefValue = "";
		$this->cus_email->TooltipValue = "";

		// cus_passport
		$this->cus_passport->LinkCustomAttributes = "";
		$this->cus_passport->HrefValue = "";
		$this->cus_passport->TooltipValue = "";

		// cus_pickup
		$this->cus_pickup->LinkCustomAttributes = "";
		$this->cus_pickup->HrefValue = "";
		$this->cus_pickup->TooltipValue = "";

		// check_in
		$this->check_in->LinkCustomAttributes = "";
		$this->check_in->HrefValue = "";
		$this->check_in->TooltipValue = "";

		// check_out
		$this->check_out->LinkCustomAttributes = "";
		$this->check_out->HrefValue = "";
		$this->check_out->TooltipValue = "";

		// max_day_stay
		$this->max_day_stay->LinkCustomAttributes = "";
		$this->max_day_stay->HrefValue = "";
		$this->max_day_stay->TooltipValue = "";

		// total_amount
		$this->total_amount->LinkCustomAttributes = "";
		$this->total_amount->HrefValue = "";
		$this->total_amount->TooltipValue = "";

		// booking_status
		$this->booking_status->LinkCustomAttributes = "";
		$this->booking_status->HrefValue = "";
		$this->booking_status->TooltipValue = "";

		// notes
		$this->notes->LinkCustomAttributes = "";
		$this->notes->HrefValue = "";
		$this->notes->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// booking_id
		$this->booking_id->EditAttrs["class"] = "form-control";
		$this->booking_id->EditCustomAttributes = "";
		$this->booking_id->EditValue = $this->booking_id->CurrentValue;
		$this->booking_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->EditAttrs["class"] = "form-control";
		$this->hroom_id->EditCustomAttributes = "";
		$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->EditAttrs["class"] = "form-control";
		$this->customer_id->EditCustomAttributes = "";
		$this->customer_id->EditValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

		// room_type
		$this->room_type->EditAttrs["class"] = "form-control";
		$this->room_type->EditCustomAttributes = "";
		$this->room_type->EditValue = $this->room_type->CurrentValue;
		$this->room_type->PlaceHolder = ew_RemoveHtml($this->room_type->FldCaption());

		// max_adult
		$this->max_adult->EditAttrs["class"] = "form-control";
		$this->max_adult->EditCustomAttributes = "";
		$this->max_adult->EditValue = $this->max_adult->CurrentValue;
		$this->max_adult->PlaceHolder = ew_RemoveHtml($this->max_adult->FldCaption());

		// max_child
		$this->max_child->EditAttrs["class"] = "form-control";
		$this->max_child->EditCustomAttributes = "";
		$this->max_child->EditValue = $this->max_child->CurrentValue;
		$this->max_child->PlaceHolder = ew_RemoveHtml($this->max_child->FldCaption());

		// cus_email
		$this->cus_email->EditAttrs["class"] = "form-control";
		$this->cus_email->EditCustomAttributes = "";
		$this->cus_email->EditValue = $this->cus_email->CurrentValue;
		$this->cus_email->PlaceHolder = ew_RemoveHtml($this->cus_email->FldCaption());

		// cus_passport
		$this->cus_passport->EditAttrs["class"] = "form-control";
		$this->cus_passport->EditCustomAttributes = "";
		$this->cus_passport->EditValue = $this->cus_passport->CurrentValue;
		$this->cus_passport->PlaceHolder = ew_RemoveHtml($this->cus_passport->FldCaption());

		// cus_pickup
		$this->cus_pickup->EditAttrs["class"] = "form-control";
		$this->cus_pickup->EditCustomAttributes = "";
		$this->cus_pickup->EditValue = $this->cus_pickup->CurrentValue;
		$this->cus_pickup->PlaceHolder = ew_RemoveHtml($this->cus_pickup->FldCaption());

		// check_in
		$this->check_in->EditAttrs["class"] = "form-control";
		$this->check_in->EditCustomAttributes = "";
		$this->check_in->EditValue = ew_FormatDateTime($this->check_in->CurrentValue, 8);
		$this->check_in->PlaceHolder = ew_RemoveHtml($this->check_in->FldCaption());

		// check_out
		$this->check_out->EditAttrs["class"] = "form-control";
		$this->check_out->EditCustomAttributes = "";
		$this->check_out->EditValue = ew_FormatDateTime($this->check_out->CurrentValue, 8);
		$this->check_out->PlaceHolder = ew_RemoveHtml($this->check_out->FldCaption());

		// max_day_stay
		$this->max_day_stay->EditAttrs["class"] = "form-control";
		$this->max_day_stay->EditCustomAttributes = "";
		$this->max_day_stay->EditValue = $this->max_day_stay->CurrentValue;
		$this->max_day_stay->PlaceHolder = ew_RemoveHtml($this->max_day_stay->FldCaption());

		// total_amount
		$this->total_amount->EditAttrs["class"] = "form-control";
		$this->total_amount->EditCustomAttributes = "";
		$this->total_amount->EditValue = $this->total_amount->CurrentValue;
		$this->total_amount->PlaceHolder = ew_RemoveHtml($this->total_amount->FldCaption());
		if (strval($this->total_amount->EditValue) <> "" && is_numeric($this->total_amount->EditValue)) $this->total_amount->EditValue = ew_FormatNumber($this->total_amount->EditValue, -2, -1, -2, 0);

		// booking_status
		$this->booking_status->EditAttrs["class"] = "form-control";
		$this->booking_status->EditCustomAttributes = "";
		$this->booking_status->EditValue = $this->booking_status->CurrentValue;
		$this->booking_status->PlaceHolder = ew_RemoveHtml($this->booking_status->FldCaption());

		// notes
		$this->notes->EditAttrs["class"] = "form-control";
		$this->notes->EditCustomAttributes = "";
		$this->notes->EditValue = $this->notes->CurrentValue;
		$this->notes->PlaceHolder = ew_RemoveHtml($this->notes->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->booking_id->Exportable) $Doc->ExportCaption($this->booking_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->room_type->Exportable) $Doc->ExportCaption($this->room_type);
					if ($this->max_adult->Exportable) $Doc->ExportCaption($this->max_adult);
					if ($this->max_child->Exportable) $Doc->ExportCaption($this->max_child);
					if ($this->cus_email->Exportable) $Doc->ExportCaption($this->cus_email);
					if ($this->cus_passport->Exportable) $Doc->ExportCaption($this->cus_passport);
					if ($this->cus_pickup->Exportable) $Doc->ExportCaption($this->cus_pickup);
					if ($this->check_in->Exportable) $Doc->ExportCaption($this->check_in);
					if ($this->check_out->Exportable) $Doc->ExportCaption($this->check_out);
					if ($this->max_day_stay->Exportable) $Doc->ExportCaption($this->max_day_stay);
					if ($this->total_amount->Exportable) $Doc->ExportCaption($this->total_amount);
					if ($this->booking_status->Exportable) $Doc->ExportCaption($this->booking_status);
					if ($this->notes->Exportable) $Doc->ExportCaption($this->notes);
				} else {
					if ($this->booking_id->Exportable) $Doc->ExportCaption($this->booking_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->room_type->Exportable) $Doc->ExportCaption($this->room_type);
					if ($this->max_adult->Exportable) $Doc->ExportCaption($this->max_adult);
					if ($this->max_child->Exportable) $Doc->ExportCaption($this->max_child);
					if ($this->cus_email->Exportable) $Doc->ExportCaption($this->cus_email);
					if ($this->cus_passport->Exportable) $Doc->ExportCaption($this->cus_passport);
					if ($this->cus_pickup->Exportable) $Doc->ExportCaption($this->cus_pickup);
					if ($this->check_in->Exportable) $Doc->ExportCaption($this->check_in);
					if ($this->check_out->Exportable) $Doc->ExportCaption($this->check_out);
					if ($this->max_day_stay->Exportable) $Doc->ExportCaption($this->max_day_stay);
					if ($this->total_amount->Exportable) $Doc->ExportCaption($this->total_amount);
					if ($this->booking_status->Exportable) $Doc->ExportCaption($this->booking_status);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->booking_id->Exportable) $Doc->ExportField($this->booking_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->room_type->Exportable) $Doc->ExportField($this->room_type);
						if ($this->max_adult->Exportable) $Doc->ExportField($this->max_adult);
						if ($this->max_child->Exportable) $Doc->ExportField($this->max_child);
						if ($this->cus_email->Exportable) $Doc->ExportField($this->cus_email);
						if ($this->cus_passport->Exportable) $Doc->ExportField($this->cus_passport);
						if ($this->cus_pickup->Exportable) $Doc->ExportField($this->cus_pickup);
						if ($this->check_in->Exportable) $Doc->ExportField($this->check_in);
						if ($this->check_out->Exportable) $Doc->ExportField($this->check_out);
						if ($this->max_day_stay->Exportable) $Doc->ExportField($this->max_day_stay);
						if ($this->total_amount->Exportable) $Doc->ExportField($this->total_amount);
						if ($this->booking_status->Exportable) $Doc->ExportField($this->booking_status);
						if ($this->notes->Exportable) $Doc->ExportField($this->notes);
					} else {
						if ($this->booking_id->Exportable) $Doc->ExportField($this->booking_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->room_type->Exportable) $Doc->ExportField($this->room_type);
						if ($this->max_adult->Exportable) $Doc->ExportField($this->max_adult);
						if ($this->max_child->Exportable) $Doc->ExportField($this->max_child);
						if ($this->cus_email->Exportable) $Doc->ExportField($this->cus_email);
						if ($this->cus_passport->Exportable) $Doc->ExportField($this->cus_passport);
						if ($this->cus_pickup->Exportable) $Doc->ExportField($this->cus_pickup);
						if ($this->check_in->Exportable) $Doc->ExportField($this->check_in);
						if ($this->check_out->Exportable) $Doc->ExportField($this->check_out);
						if ($this->max_day_stay->Exportable) $Doc->ExportField($this->max_day_stay);
						if ($this->total_amount->Exportable) $Doc->ExportField($this->total_amount);
						if ($this->booking_status->Exportable) $Doc->ExportField($this->booking_status);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>

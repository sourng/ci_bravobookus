<?php

// Global variable for table object
$selling_rooms = NULL;

//
// Table class for selling_rooms
//
class cselling_rooms extends cTable {
	var $sell_room_id;
	var $hroom_id;
	var $hotel_id;
	var $rt_id;
	var $sell_date;
	var $day;
	var $month;
	var $year;
	var $max_people;
	var $base_rate;
	var $discount;
	var $room_sell;
	var $room_sold;
	var $room_closed;
	var $room_status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'selling_rooms';
		$this->TableName = 'selling_rooms';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`selling_rooms`";
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

		// sell_room_id
		$this->sell_room_id = new cField('selling_rooms', 'selling_rooms', 'x_sell_room_id', 'sell_room_id', '`sell_room_id`', '`sell_room_id`', 20, -1, FALSE, '`sell_room_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->sell_room_id->Sortable = TRUE; // Allow sort
		$this->sell_room_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sell_room_id'] = &$this->sell_room_id;

		// hroom_id
		$this->hroom_id = new cField('selling_rooms', 'selling_rooms', 'x_hroom_id', 'hroom_id', '`hroom_id`', '`hroom_id`', 20, -1, FALSE, '`hroom_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hroom_id->Sortable = TRUE; // Allow sort
		$this->hroom_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hroom_id'] = &$this->hroom_id;

		// hotel_id
		$this->hotel_id = new cField('selling_rooms', 'selling_rooms', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// rt_id
		$this->rt_id = new cField('selling_rooms', 'selling_rooms', 'x_rt_id', 'rt_id', '`rt_id`', '`rt_id`', 20, -1, FALSE, '`rt_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rt_id->Sortable = TRUE; // Allow sort
		$this->rt_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['rt_id'] = &$this->rt_id;

		// sell_date
		$this->sell_date = new cField('selling_rooms', 'selling_rooms', 'x_sell_date', 'sell_date', '`sell_date`', ew_CastDateFieldForLike('`sell_date`', 0, "DB"), 135, 0, FALSE, '`sell_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sell_date->Sortable = TRUE; // Allow sort
		$this->sell_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['sell_date'] = &$this->sell_date;

		// day
		$this->day = new cField('selling_rooms', 'selling_rooms', 'x_day', 'day', '`day`', '`day`', 200, -1, FALSE, '`day`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->day->Sortable = TRUE; // Allow sort
		$this->fields['day'] = &$this->day;

		// month
		$this->month = new cField('selling_rooms', 'selling_rooms', 'x_month', 'month', '`month`', '`month`', 200, -1, FALSE, '`month`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->month->Sortable = TRUE; // Allow sort
		$this->fields['month'] = &$this->month;

		// year
		$this->year = new cField('selling_rooms', 'selling_rooms', 'x_year', 'year', '`year`', '`year`', 200, -1, FALSE, '`year`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->year->Sortable = TRUE; // Allow sort
		$this->fields['year'] = &$this->year;

		// max_people
		$this->max_people = new cField('selling_rooms', 'selling_rooms', 'x_max_people', 'max_people', '`max_people`', '`max_people`', 3, -1, FALSE, '`max_people`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->max_people->Sortable = TRUE; // Allow sort
		$this->max_people->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['max_people'] = &$this->max_people;

		// base_rate
		$this->base_rate = new cField('selling_rooms', 'selling_rooms', 'x_base_rate', 'base_rate', '`base_rate`', '`base_rate`', 131, -1, FALSE, '`base_rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->base_rate->Sortable = TRUE; // Allow sort
		$this->base_rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['base_rate'] = &$this->base_rate;

		// discount
		$this->discount = new cField('selling_rooms', 'selling_rooms', 'x_discount', 'discount', '`discount`', '`discount`', 3, -1, FALSE, '`discount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->discount->Sortable = TRUE; // Allow sort
		$this->discount->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['discount'] = &$this->discount;

		// room_sell
		$this->room_sell = new cField('selling_rooms', 'selling_rooms', 'x_room_sell', 'room_sell', '`room_sell`', '`room_sell`', 3, -1, FALSE, '`room_sell`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->room_sell->Sortable = TRUE; // Allow sort
		$this->room_sell->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['room_sell'] = &$this->room_sell;

		// room_sold
		$this->room_sold = new cField('selling_rooms', 'selling_rooms', 'x_room_sold', 'room_sold', '`room_sold`', '`room_sold`', 202, -1, FALSE, '`room_sold`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->room_sold->Sortable = TRUE; // Allow sort
		$this->room_sold->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->room_sold->TrueValue = 'Y';
		$this->room_sold->FalseValue = 'N';
		$this->room_sold->OptionCount = 2;
		$this->fields['room_sold'] = &$this->room_sold;

		// room_closed
		$this->room_closed = new cField('selling_rooms', 'selling_rooms', 'x_room_closed', 'room_closed', '`room_closed`', '`room_closed`', 202, -1, FALSE, '`room_closed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->room_closed->Sortable = TRUE; // Allow sort
		$this->room_closed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->room_closed->TrueValue = 'Y';
		$this->room_closed->FalseValue = 'N';
		$this->room_closed->OptionCount = 2;
		$this->fields['room_closed'] = &$this->room_closed;

		// room_status
		$this->room_status = new cField('selling_rooms', 'selling_rooms', 'x_room_status', 'room_status', '`room_status`', '`room_status`', 202, -1, FALSE, '`room_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->room_status->Sortable = TRUE; // Allow sort
		$this->room_status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->room_status->TrueValue = 'Y';
		$this->room_status->FalseValue = 'N';
		$this->room_status->OptionCount = 2;
		$this->fields['room_status'] = &$this->room_status;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`selling_rooms`";
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
			$this->sell_room_id->setDbValue($conn->Insert_ID());
			$rs['sell_room_id'] = $this->sell_room_id->DbValue;
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
			if (array_key_exists('sell_room_id', $rs))
				ew_AddFilter($where, ew_QuotedName('sell_room_id', $this->DBID) . '=' . ew_QuotedValue($rs['sell_room_id'], $this->sell_room_id->FldDataType, $this->DBID));
			if (array_key_exists('hroom_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hroom_id', $this->DBID) . '=' . ew_QuotedValue($rs['hroom_id'], $this->hroom_id->FldDataType, $this->DBID));
			if (array_key_exists('hotel_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hotel_id', $this->DBID) . '=' . ew_QuotedValue($rs['hotel_id'], $this->hotel_id->FldDataType, $this->DBID));
			if (array_key_exists('rt_id', $rs))
				ew_AddFilter($where, ew_QuotedName('rt_id', $this->DBID) . '=' . ew_QuotedValue($rs['rt_id'], $this->rt_id->FldDataType, $this->DBID));
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
		return "`sell_room_id` = @sell_room_id@ AND `hroom_id` = @hroom_id@ AND `hotel_id` = @hotel_id@ AND `rt_id` = @rt_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->sell_room_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@sell_room_id@", ew_AdjustSql($this->sell_room_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->hroom_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hroom_id@", ew_AdjustSql($this->hroom_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->hotel_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hotel_id@", ew_AdjustSql($this->hotel_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->rt_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@rt_id@", ew_AdjustSql($this->rt_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "selling_roomslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "selling_roomslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("selling_roomsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("selling_roomsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "selling_roomsadd.php?" . $this->UrlParm($parm);
		else
			$url = "selling_roomsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("selling_roomsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("selling_roomsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("selling_roomsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "sell_room_id:" . ew_VarToJson($this->sell_room_id->CurrentValue, "number", "'");
		$json .= ",hroom_id:" . ew_VarToJson($this->hroom_id->CurrentValue, "number", "'");
		$json .= ",hotel_id:" . ew_VarToJson($this->hotel_id->CurrentValue, "number", "'");
		$json .= ",rt_id:" . ew_VarToJson($this->rt_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->sell_room_id->CurrentValue)) {
			$sUrl .= "sell_room_id=" . urlencode($this->sell_room_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->hroom_id->CurrentValue)) {
			$sUrl .= "&hroom_id=" . urlencode($this->hroom_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->hotel_id->CurrentValue)) {
			$sUrl .= "&hotel_id=" . urlencode($this->hotel_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->rt_id->CurrentValue)) {
			$sUrl .= "&rt_id=" . urlencode($this->rt_id->CurrentValue);
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
			if ($isPost && isset($_POST["sell_room_id"]))
				$arKey[] = ew_StripSlashes($_POST["sell_room_id"]);
			elseif (isset($_GET["sell_room_id"]))
				$arKey[] = ew_StripSlashes($_GET["sell_room_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["hroom_id"]))
				$arKey[] = ew_StripSlashes($_POST["hroom_id"]);
			elseif (isset($_GET["hroom_id"]))
				$arKey[] = ew_StripSlashes($_GET["hroom_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["hotel_id"]))
				$arKey[] = ew_StripSlashes($_POST["hotel_id"]);
			elseif (isset($_GET["hotel_id"]))
				$arKey[] = ew_StripSlashes($_GET["hotel_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["rt_id"]))
				$arKey[] = ew_StripSlashes($_POST["rt_id"]);
			elseif (isset($_GET["rt_id"]))
				$arKey[] = ew_StripSlashes($_GET["rt_id"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 4)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // sell_room_id
					continue;
				if (!is_numeric($key[1])) // hroom_id
					continue;
				if (!is_numeric($key[2])) // hotel_id
					continue;
				if (!is_numeric($key[3])) // rt_id
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
			$this->sell_room_id->CurrentValue = $key[0];
			$this->hroom_id->CurrentValue = $key[1];
			$this->hotel_id->CurrentValue = $key[2];
			$this->rt_id->CurrentValue = $key[3];
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
		$this->sell_room_id->setDbValue($rs->fields('sell_room_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->sell_date->setDbValue($rs->fields('sell_date'));
		$this->day->setDbValue($rs->fields('day'));
		$this->month->setDbValue($rs->fields('month'));
		$this->year->setDbValue($rs->fields('year'));
		$this->max_people->setDbValue($rs->fields('max_people'));
		$this->base_rate->setDbValue($rs->fields('base_rate'));
		$this->discount->setDbValue($rs->fields('discount'));
		$this->room_sell->setDbValue($rs->fields('room_sell'));
		$this->room_sold->setDbValue($rs->fields('room_sold'));
		$this->room_closed->setDbValue($rs->fields('room_closed'));
		$this->room_status->setDbValue($rs->fields('room_status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// sell_room_id
		// hroom_id
		// hotel_id
		// rt_id
		// sell_date
		// day
		// month
		// year
		// max_people
		// base_rate
		// discount
		// room_sell
		// room_sold
		// room_closed
		// room_status
		// sell_room_id

		$this->sell_room_id->ViewValue = $this->sell_room_id->CurrentValue;
		$this->sell_room_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// sell_date
		$this->sell_date->ViewValue = $this->sell_date->CurrentValue;
		$this->sell_date->ViewValue = ew_FormatDateTime($this->sell_date->ViewValue, 0);
		$this->sell_date->ViewCustomAttributes = "";

		// day
		$this->day->ViewValue = $this->day->CurrentValue;
		$this->day->ViewCustomAttributes = "";

		// month
		$this->month->ViewValue = $this->month->CurrentValue;
		$this->month->ViewCustomAttributes = "";

		// year
		$this->year->ViewValue = $this->year->CurrentValue;
		$this->year->ViewCustomAttributes = "";

		// max_people
		$this->max_people->ViewValue = $this->max_people->CurrentValue;
		$this->max_people->ViewCustomAttributes = "";

		// base_rate
		$this->base_rate->ViewValue = $this->base_rate->CurrentValue;
		$this->base_rate->ViewCustomAttributes = "";

		// discount
		$this->discount->ViewValue = $this->discount->CurrentValue;
		$this->discount->ViewCustomAttributes = "";

		// room_sell
		$this->room_sell->ViewValue = $this->room_sell->CurrentValue;
		$this->room_sell->ViewCustomAttributes = "";

		// room_sold
		if (ew_ConvertToBool($this->room_sold->CurrentValue)) {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(1) <> "" ? $this->room_sold->FldTagCaption(1) : "Y";
		} else {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(2) <> "" ? $this->room_sold->FldTagCaption(2) : "N";
		}
		$this->room_sold->ViewCustomAttributes = "";

		// room_closed
		if (ew_ConvertToBool($this->room_closed->CurrentValue)) {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(1) <> "" ? $this->room_closed->FldTagCaption(1) : "Y";
		} else {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(2) <> "" ? $this->room_closed->FldTagCaption(2) : "N";
		}
		$this->room_closed->ViewCustomAttributes = "";

		// room_status
		if (ew_ConvertToBool($this->room_status->CurrentValue)) {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(1) <> "" ? $this->room_status->FldTagCaption(1) : "Y";
		} else {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(2) <> "" ? $this->room_status->FldTagCaption(2) : "N";
		}
		$this->room_status->ViewCustomAttributes = "";

		// sell_room_id
		$this->sell_room_id->LinkCustomAttributes = "";
		$this->sell_room_id->HrefValue = "";
		$this->sell_room_id->TooltipValue = "";

		// hroom_id
		$this->hroom_id->LinkCustomAttributes = "";
		$this->hroom_id->HrefValue = "";
		$this->hroom_id->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// rt_id
		$this->rt_id->LinkCustomAttributes = "";
		$this->rt_id->HrefValue = "";
		$this->rt_id->TooltipValue = "";

		// sell_date
		$this->sell_date->LinkCustomAttributes = "";
		$this->sell_date->HrefValue = "";
		$this->sell_date->TooltipValue = "";

		// day
		$this->day->LinkCustomAttributes = "";
		$this->day->HrefValue = "";
		$this->day->TooltipValue = "";

		// month
		$this->month->LinkCustomAttributes = "";
		$this->month->HrefValue = "";
		$this->month->TooltipValue = "";

		// year
		$this->year->LinkCustomAttributes = "";
		$this->year->HrefValue = "";
		$this->year->TooltipValue = "";

		// max_people
		$this->max_people->LinkCustomAttributes = "";
		$this->max_people->HrefValue = "";
		$this->max_people->TooltipValue = "";

		// base_rate
		$this->base_rate->LinkCustomAttributes = "";
		$this->base_rate->HrefValue = "";
		$this->base_rate->TooltipValue = "";

		// discount
		$this->discount->LinkCustomAttributes = "";
		$this->discount->HrefValue = "";
		$this->discount->TooltipValue = "";

		// room_sell
		$this->room_sell->LinkCustomAttributes = "";
		$this->room_sell->HrefValue = "";
		$this->room_sell->TooltipValue = "";

		// room_sold
		$this->room_sold->LinkCustomAttributes = "";
		$this->room_sold->HrefValue = "";
		$this->room_sold->TooltipValue = "";

		// room_closed
		$this->room_closed->LinkCustomAttributes = "";
		$this->room_closed->HrefValue = "";
		$this->room_closed->TooltipValue = "";

		// room_status
		$this->room_status->LinkCustomAttributes = "";
		$this->room_status->HrefValue = "";
		$this->room_status->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// sell_room_id
		$this->sell_room_id->EditAttrs["class"] = "form-control";
		$this->sell_room_id->EditCustomAttributes = "";
		$this->sell_room_id->EditValue = $this->sell_room_id->CurrentValue;
		$this->sell_room_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->EditAttrs["class"] = "form-control";
		$this->hroom_id->EditCustomAttributes = "";
		$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->EditAttrs["class"] = "form-control";
		$this->rt_id->EditCustomAttributes = "";
		$this->rt_id->EditValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// sell_date
		$this->sell_date->EditAttrs["class"] = "form-control";
		$this->sell_date->EditCustomAttributes = "";
		$this->sell_date->EditValue = ew_FormatDateTime($this->sell_date->CurrentValue, 8);
		$this->sell_date->PlaceHolder = ew_RemoveHtml($this->sell_date->FldCaption());

		// day
		$this->day->EditAttrs["class"] = "form-control";
		$this->day->EditCustomAttributes = "";
		$this->day->EditValue = $this->day->CurrentValue;
		$this->day->PlaceHolder = ew_RemoveHtml($this->day->FldCaption());

		// month
		$this->month->EditAttrs["class"] = "form-control";
		$this->month->EditCustomAttributes = "";
		$this->month->EditValue = $this->month->CurrentValue;
		$this->month->PlaceHolder = ew_RemoveHtml($this->month->FldCaption());

		// year
		$this->year->EditAttrs["class"] = "form-control";
		$this->year->EditCustomAttributes = "";
		$this->year->EditValue = $this->year->CurrentValue;
		$this->year->PlaceHolder = ew_RemoveHtml($this->year->FldCaption());

		// max_people
		$this->max_people->EditAttrs["class"] = "form-control";
		$this->max_people->EditCustomAttributes = "";
		$this->max_people->EditValue = $this->max_people->CurrentValue;
		$this->max_people->PlaceHolder = ew_RemoveHtml($this->max_people->FldCaption());

		// base_rate
		$this->base_rate->EditAttrs["class"] = "form-control";
		$this->base_rate->EditCustomAttributes = "";
		$this->base_rate->EditValue = $this->base_rate->CurrentValue;
		$this->base_rate->PlaceHolder = ew_RemoveHtml($this->base_rate->FldCaption());
		if (strval($this->base_rate->EditValue) <> "" && is_numeric($this->base_rate->EditValue)) $this->base_rate->EditValue = ew_FormatNumber($this->base_rate->EditValue, -2, -1, -2, 0);

		// discount
		$this->discount->EditAttrs["class"] = "form-control";
		$this->discount->EditCustomAttributes = "";
		$this->discount->EditValue = $this->discount->CurrentValue;
		$this->discount->PlaceHolder = ew_RemoveHtml($this->discount->FldCaption());

		// room_sell
		$this->room_sell->EditAttrs["class"] = "form-control";
		$this->room_sell->EditCustomAttributes = "";
		$this->room_sell->EditValue = $this->room_sell->CurrentValue;
		$this->room_sell->PlaceHolder = ew_RemoveHtml($this->room_sell->FldCaption());

		// room_sold
		$this->room_sold->EditCustomAttributes = "";
		$this->room_sold->EditValue = $this->room_sold->Options(FALSE);

		// room_closed
		$this->room_closed->EditCustomAttributes = "";
		$this->room_closed->EditValue = $this->room_closed->Options(FALSE);

		// room_status
		$this->room_status->EditCustomAttributes = "";
		$this->room_status->EditValue = $this->room_status->Options(FALSE);

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
					if ($this->sell_room_id->Exportable) $Doc->ExportCaption($this->sell_room_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->rt_id->Exportable) $Doc->ExportCaption($this->rt_id);
					if ($this->sell_date->Exportable) $Doc->ExportCaption($this->sell_date);
					if ($this->day->Exportable) $Doc->ExportCaption($this->day);
					if ($this->month->Exportable) $Doc->ExportCaption($this->month);
					if ($this->year->Exportable) $Doc->ExportCaption($this->year);
					if ($this->max_people->Exportable) $Doc->ExportCaption($this->max_people);
					if ($this->base_rate->Exportable) $Doc->ExportCaption($this->base_rate);
					if ($this->discount->Exportable) $Doc->ExportCaption($this->discount);
					if ($this->room_sell->Exportable) $Doc->ExportCaption($this->room_sell);
					if ($this->room_sold->Exportable) $Doc->ExportCaption($this->room_sold);
					if ($this->room_closed->Exportable) $Doc->ExportCaption($this->room_closed);
					if ($this->room_status->Exportable) $Doc->ExportCaption($this->room_status);
				} else {
					if ($this->sell_room_id->Exportable) $Doc->ExportCaption($this->sell_room_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->rt_id->Exportable) $Doc->ExportCaption($this->rt_id);
					if ($this->sell_date->Exportable) $Doc->ExportCaption($this->sell_date);
					if ($this->day->Exportable) $Doc->ExportCaption($this->day);
					if ($this->month->Exportable) $Doc->ExportCaption($this->month);
					if ($this->year->Exportable) $Doc->ExportCaption($this->year);
					if ($this->max_people->Exportable) $Doc->ExportCaption($this->max_people);
					if ($this->base_rate->Exportable) $Doc->ExportCaption($this->base_rate);
					if ($this->discount->Exportable) $Doc->ExportCaption($this->discount);
					if ($this->room_sell->Exportable) $Doc->ExportCaption($this->room_sell);
					if ($this->room_sold->Exportable) $Doc->ExportCaption($this->room_sold);
					if ($this->room_closed->Exportable) $Doc->ExportCaption($this->room_closed);
					if ($this->room_status->Exportable) $Doc->ExportCaption($this->room_status);
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
						if ($this->sell_room_id->Exportable) $Doc->ExportField($this->sell_room_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->rt_id->Exportable) $Doc->ExportField($this->rt_id);
						if ($this->sell_date->Exportable) $Doc->ExportField($this->sell_date);
						if ($this->day->Exportable) $Doc->ExportField($this->day);
						if ($this->month->Exportable) $Doc->ExportField($this->month);
						if ($this->year->Exportable) $Doc->ExportField($this->year);
						if ($this->max_people->Exportable) $Doc->ExportField($this->max_people);
						if ($this->base_rate->Exportable) $Doc->ExportField($this->base_rate);
						if ($this->discount->Exportable) $Doc->ExportField($this->discount);
						if ($this->room_sell->Exportable) $Doc->ExportField($this->room_sell);
						if ($this->room_sold->Exportable) $Doc->ExportField($this->room_sold);
						if ($this->room_closed->Exportable) $Doc->ExportField($this->room_closed);
						if ($this->room_status->Exportable) $Doc->ExportField($this->room_status);
					} else {
						if ($this->sell_room_id->Exportable) $Doc->ExportField($this->sell_room_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->rt_id->Exportable) $Doc->ExportField($this->rt_id);
						if ($this->sell_date->Exportable) $Doc->ExportField($this->sell_date);
						if ($this->day->Exportable) $Doc->ExportField($this->day);
						if ($this->month->Exportable) $Doc->ExportField($this->month);
						if ($this->year->Exportable) $Doc->ExportField($this->year);
						if ($this->max_people->Exportable) $Doc->ExportField($this->max_people);
						if ($this->base_rate->Exportable) $Doc->ExportField($this->base_rate);
						if ($this->discount->Exportable) $Doc->ExportField($this->discount);
						if ($this->room_sell->Exportable) $Doc->ExportField($this->room_sell);
						if ($this->room_sold->Exportable) $Doc->ExportField($this->room_sold);
						if ($this->room_closed->Exportable) $Doc->ExportField($this->room_closed);
						if ($this->room_status->Exportable) $Doc->ExportField($this->room_status);
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

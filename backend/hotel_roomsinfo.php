<?php

// Global variable for table object
$hotel_rooms = NULL;

//
// Table class for hotel_rooms
//
class chotel_rooms extends cTable {
	var $hroom_id;
	var $hotel_id;
	var $rt_id;
	var $hr_name;
	var $hr_image;
	var $hr_description;
	var $amenities;
	var $hr_max;
	var $hr_base_rate;
	var $hr_status;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotel_rooms';
		$this->TableName = 'hotel_rooms';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotel_rooms`";
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

		// hroom_id
		$this->hroom_id = new cField('hotel_rooms', 'hotel_rooms', 'x_hroom_id', 'hroom_id', '`hroom_id`', '`hroom_id`', 20, -1, FALSE, '`hroom_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->hroom_id->Sortable = TRUE; // Allow sort
		$this->hroom_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hroom_id'] = &$this->hroom_id;

		// hotel_id
		$this->hotel_id = new cField('hotel_rooms', 'hotel_rooms', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// rt_id
		$this->rt_id = new cField('hotel_rooms', 'hotel_rooms', 'x_rt_id', 'rt_id', '`rt_id`', '`rt_id`', 20, -1, FALSE, '`rt_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rt_id->Sortable = TRUE; // Allow sort
		$this->rt_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['rt_id'] = &$this->rt_id;

		// hr_name
		$this->hr_name = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_name', 'hr_name', '`hr_name`', '`hr_name`', 200, -1, FALSE, '`hr_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_name->Sortable = TRUE; // Allow sort
		$this->fields['hr_name'] = &$this->hr_name;

		// hr_image
		$this->hr_image = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_image', 'hr_image', '`hr_image`', '`hr_image`', 200, -1, FALSE, '`hr_image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_image->Sortable = TRUE; // Allow sort
		$this->fields['hr_image'] = &$this->hr_image;

		// hr_description
		$this->hr_description = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_description', 'hr_description', '`hr_description`', '`hr_description`', 201, -1, FALSE, '`hr_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->hr_description->Sortable = TRUE; // Allow sort
		$this->fields['hr_description'] = &$this->hr_description;

		// amenities
		$this->amenities = new cField('hotel_rooms', 'hotel_rooms', 'x_amenities', 'amenities', '`amenities`', '`amenities`', 201, -1, FALSE, '`amenities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->amenities->Sortable = TRUE; // Allow sort
		$this->fields['amenities'] = &$this->amenities;

		// hr_max
		$this->hr_max = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_max', 'hr_max', '`hr_max`', '`hr_max`', 3, -1, FALSE, '`hr_max`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_max->Sortable = TRUE; // Allow sort
		$this->hr_max->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hr_max'] = &$this->hr_max;

		// hr_base_rate
		$this->hr_base_rate = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_base_rate', 'hr_base_rate', '`hr_base_rate`', '`hr_base_rate`', 131, -1, FALSE, '`hr_base_rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_base_rate->Sortable = TRUE; // Allow sort
		$this->hr_base_rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['hr_base_rate'] = &$this->hr_base_rate;

		// hr_status
		$this->hr_status = new cField('hotel_rooms', 'hotel_rooms', 'x_hr_status', 'hr_status', '`hr_status`', '`hr_status`', 202, -1, FALSE, '`hr_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->hr_status->Sortable = TRUE; // Allow sort
		$this->hr_status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->hr_status->TrueValue = 'Y';
		$this->hr_status->FalseValue = 'N';
		$this->hr_status->OptionCount = 2;
		$this->fields['hr_status'] = &$this->hr_status;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotel_rooms`";
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
			$this->hroom_id->setDbValue($conn->Insert_ID());
			$rs['hroom_id'] = $this->hroom_id->DbValue;
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
		return "`hroom_id` = @hroom_id@ AND `hotel_id` = @hotel_id@ AND `rt_id` = @rt_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "hotel_roomslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotel_roomslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotel_roomsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotel_roomsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotel_roomsadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotel_roomsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotel_roomsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotel_roomsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotel_roomsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "hroom_id:" . ew_VarToJson($this->hroom_id->CurrentValue, "number", "'");
		$json .= ",hotel_id:" . ew_VarToJson($this->hotel_id->CurrentValue, "number", "'");
		$json .= ",rt_id:" . ew_VarToJson($this->rt_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->hroom_id->CurrentValue)) {
			$sUrl .= "hroom_id=" . urlencode($this->hroom_id->CurrentValue);
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
				if (!is_array($key) || count($key) <> 3)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // hroom_id
					continue;
				if (!is_numeric($key[1])) // hotel_id
					continue;
				if (!is_numeric($key[2])) // rt_id
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
			$this->hroom_id->CurrentValue = $key[0];
			$this->hotel_id->CurrentValue = $key[1];
			$this->rt_id->CurrentValue = $key[2];
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
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->hr_name->setDbValue($rs->fields('hr_name'));
		$this->hr_image->setDbValue($rs->fields('hr_image'));
		$this->hr_description->setDbValue($rs->fields('hr_description'));
		$this->amenities->setDbValue($rs->fields('amenities'));
		$this->hr_max->setDbValue($rs->fields('hr_max'));
		$this->hr_base_rate->setDbValue($rs->fields('hr_base_rate'));
		$this->hr_status->setDbValue($rs->fields('hr_status'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// hroom_id
		// hotel_id
		// rt_id
		// hr_name
		// hr_image
		// hr_description
		// amenities
		// hr_max
		// hr_base_rate
		// hr_status
		// hroom_id

		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// hr_name
		$this->hr_name->ViewValue = $this->hr_name->CurrentValue;
		$this->hr_name->ViewCustomAttributes = "";

		// hr_image
		$this->hr_image->ViewValue = $this->hr_image->CurrentValue;
		$this->hr_image->ViewCustomAttributes = "";

		// hr_description
		$this->hr_description->ViewValue = $this->hr_description->CurrentValue;
		$this->hr_description->ViewCustomAttributes = "";

		// amenities
		$this->amenities->ViewValue = $this->amenities->CurrentValue;
		$this->amenities->ViewCustomAttributes = "";

		// hr_max
		$this->hr_max->ViewValue = $this->hr_max->CurrentValue;
		$this->hr_max->ViewCustomAttributes = "";

		// hr_base_rate
		$this->hr_base_rate->ViewValue = $this->hr_base_rate->CurrentValue;
		$this->hr_base_rate->ViewCustomAttributes = "";

		// hr_status
		if (ew_ConvertToBool($this->hr_status->CurrentValue)) {
			$this->hr_status->ViewValue = $this->hr_status->FldTagCaption(1) <> "" ? $this->hr_status->FldTagCaption(1) : "Y";
		} else {
			$this->hr_status->ViewValue = $this->hr_status->FldTagCaption(2) <> "" ? $this->hr_status->FldTagCaption(2) : "N";
		}
		$this->hr_status->ViewCustomAttributes = "";

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

		// hr_name
		$this->hr_name->LinkCustomAttributes = "";
		$this->hr_name->HrefValue = "";
		$this->hr_name->TooltipValue = "";

		// hr_image
		$this->hr_image->LinkCustomAttributes = "";
		$this->hr_image->HrefValue = "";
		$this->hr_image->TooltipValue = "";

		// hr_description
		$this->hr_description->LinkCustomAttributes = "";
		$this->hr_description->HrefValue = "";
		$this->hr_description->TooltipValue = "";

		// amenities
		$this->amenities->LinkCustomAttributes = "";
		$this->amenities->HrefValue = "";
		$this->amenities->TooltipValue = "";

		// hr_max
		$this->hr_max->LinkCustomAttributes = "";
		$this->hr_max->HrefValue = "";
		$this->hr_max->TooltipValue = "";

		// hr_base_rate
		$this->hr_base_rate->LinkCustomAttributes = "";
		$this->hr_base_rate->HrefValue = "";
		$this->hr_base_rate->TooltipValue = "";

		// hr_status
		$this->hr_status->LinkCustomAttributes = "";
		$this->hr_status->HrefValue = "";
		$this->hr_status->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

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

		// hr_name
		$this->hr_name->EditAttrs["class"] = "form-control";
		$this->hr_name->EditCustomAttributes = "";
		$this->hr_name->EditValue = $this->hr_name->CurrentValue;
		$this->hr_name->PlaceHolder = ew_RemoveHtml($this->hr_name->FldCaption());

		// hr_image
		$this->hr_image->EditAttrs["class"] = "form-control";
		$this->hr_image->EditCustomAttributes = "";
		$this->hr_image->EditValue = $this->hr_image->CurrentValue;
		$this->hr_image->PlaceHolder = ew_RemoveHtml($this->hr_image->FldCaption());

		// hr_description
		$this->hr_description->EditAttrs["class"] = "form-control";
		$this->hr_description->EditCustomAttributes = "";
		$this->hr_description->EditValue = $this->hr_description->CurrentValue;
		$this->hr_description->PlaceHolder = ew_RemoveHtml($this->hr_description->FldCaption());

		// amenities
		$this->amenities->EditAttrs["class"] = "form-control";
		$this->amenities->EditCustomAttributes = "";
		$this->amenities->EditValue = $this->amenities->CurrentValue;
		$this->amenities->PlaceHolder = ew_RemoveHtml($this->amenities->FldCaption());

		// hr_max
		$this->hr_max->EditAttrs["class"] = "form-control";
		$this->hr_max->EditCustomAttributes = "";
		$this->hr_max->EditValue = $this->hr_max->CurrentValue;
		$this->hr_max->PlaceHolder = ew_RemoveHtml($this->hr_max->FldCaption());

		// hr_base_rate
		$this->hr_base_rate->EditAttrs["class"] = "form-control";
		$this->hr_base_rate->EditCustomAttributes = "";
		$this->hr_base_rate->EditValue = $this->hr_base_rate->CurrentValue;
		$this->hr_base_rate->PlaceHolder = ew_RemoveHtml($this->hr_base_rate->FldCaption());
		if (strval($this->hr_base_rate->EditValue) <> "" && is_numeric($this->hr_base_rate->EditValue)) $this->hr_base_rate->EditValue = ew_FormatNumber($this->hr_base_rate->EditValue, -2, -1, -2, 0);

		// hr_status
		$this->hr_status->EditCustomAttributes = "";
		$this->hr_status->EditValue = $this->hr_status->Options(FALSE);

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
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->rt_id->Exportable) $Doc->ExportCaption($this->rt_id);
					if ($this->hr_name->Exportable) $Doc->ExportCaption($this->hr_name);
					if ($this->hr_image->Exportable) $Doc->ExportCaption($this->hr_image);
					if ($this->hr_description->Exportable) $Doc->ExportCaption($this->hr_description);
					if ($this->amenities->Exportable) $Doc->ExportCaption($this->amenities);
					if ($this->hr_max->Exportable) $Doc->ExportCaption($this->hr_max);
					if ($this->hr_base_rate->Exportable) $Doc->ExportCaption($this->hr_base_rate);
					if ($this->hr_status->Exportable) $Doc->ExportCaption($this->hr_status);
				} else {
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->rt_id->Exportable) $Doc->ExportCaption($this->rt_id);
					if ($this->hr_name->Exportable) $Doc->ExportCaption($this->hr_name);
					if ($this->hr_image->Exportable) $Doc->ExportCaption($this->hr_image);
					if ($this->hr_max->Exportable) $Doc->ExportCaption($this->hr_max);
					if ($this->hr_base_rate->Exportable) $Doc->ExportCaption($this->hr_base_rate);
					if ($this->hr_status->Exportable) $Doc->ExportCaption($this->hr_status);
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
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->rt_id->Exportable) $Doc->ExportField($this->rt_id);
						if ($this->hr_name->Exportable) $Doc->ExportField($this->hr_name);
						if ($this->hr_image->Exportable) $Doc->ExportField($this->hr_image);
						if ($this->hr_description->Exportable) $Doc->ExportField($this->hr_description);
						if ($this->amenities->Exportable) $Doc->ExportField($this->amenities);
						if ($this->hr_max->Exportable) $Doc->ExportField($this->hr_max);
						if ($this->hr_base_rate->Exportable) $Doc->ExportField($this->hr_base_rate);
						if ($this->hr_status->Exportable) $Doc->ExportField($this->hr_status);
					} else {
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->rt_id->Exportable) $Doc->ExportField($this->rt_id);
						if ($this->hr_name->Exportable) $Doc->ExportField($this->hr_name);
						if ($this->hr_image->Exportable) $Doc->ExportField($this->hr_image);
						if ($this->hr_max->Exportable) $Doc->ExportField($this->hr_max);
						if ($this->hr_base_rate->Exportable) $Doc->ExportField($this->hr_base_rate);
						if ($this->hr_status->Exportable) $Doc->ExportField($this->hr_status);
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

<?php

// Global variable for table object
$hotel_facilities = NULL;

//
// Table class for hotel_facilities
//
class chotel_facilities extends cTable {
	var $hfacility_id;
	var $hotel_id;
	var $hf_name;
	var $hf_image;
	var $hf_icons;
	var $status;
	var $hot_facilities;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotel_facilities';
		$this->TableName = 'hotel_facilities';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotel_facilities`";
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

		// hfacility_id
		$this->hfacility_id = new cField('hotel_facilities', 'hotel_facilities', 'x_hfacility_id', 'hfacility_id', '`hfacility_id`', '`hfacility_id`', 20, -1, FALSE, '`hfacility_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->hfacility_id->Sortable = TRUE; // Allow sort
		$this->hfacility_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hfacility_id'] = &$this->hfacility_id;

		// hotel_id
		$this->hotel_id = new cField('hotel_facilities', 'hotel_facilities', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// hf_name
		$this->hf_name = new cField('hotel_facilities', 'hotel_facilities', 'x_hf_name', 'hf_name', '`hf_name`', '`hf_name`', 200, -1, FALSE, '`hf_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hf_name->Sortable = TRUE; // Allow sort
		$this->fields['hf_name'] = &$this->hf_name;

		// hf_image
		$this->hf_image = new cField('hotel_facilities', 'hotel_facilities', 'x_hf_image', 'hf_image', '`hf_image`', '`hf_image`', 200, -1, FALSE, '`hf_image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hf_image->Sortable = TRUE; // Allow sort
		$this->fields['hf_image'] = &$this->hf_image;

		// hf_icons
		$this->hf_icons = new cField('hotel_facilities', 'hotel_facilities', 'x_hf_icons', 'hf_icons', '`hf_icons`', '`hf_icons`', 200, -1, FALSE, '`hf_icons`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hf_icons->Sortable = TRUE; // Allow sort
		$this->fields['hf_icons'] = &$this->hf_icons;

		// status
		$this->status = new cField('hotel_facilities', 'hotel_facilities', 'x_status', 'status', '`status`', '`status`', 202, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->status->TrueValue = 'Y';
		$this->status->FalseValue = 'N';
		$this->status->OptionCount = 2;
		$this->fields['status'] = &$this->status;

		// hot_facilities
		$this->hot_facilities = new cField('hotel_facilities', 'hotel_facilities', 'x_hot_facilities', 'hot_facilities', '`hot_facilities`', '`hot_facilities`', 202, -1, FALSE, '`hot_facilities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->hot_facilities->Sortable = TRUE; // Allow sort
		$this->hot_facilities->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->hot_facilities->TrueValue = 'Y';
		$this->hot_facilities->FalseValue = 'N';
		$this->hot_facilities->OptionCount = 2;
		$this->fields['hot_facilities'] = &$this->hot_facilities;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotel_facilities`";
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
			$this->hfacility_id->setDbValue($conn->Insert_ID());
			$rs['hfacility_id'] = $this->hfacility_id->DbValue;
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
			if (array_key_exists('hfacility_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hfacility_id', $this->DBID) . '=' . ew_QuotedValue($rs['hfacility_id'], $this->hfacility_id->FldDataType, $this->DBID));
			if (array_key_exists('hotel_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hotel_id', $this->DBID) . '=' . ew_QuotedValue($rs['hotel_id'], $this->hotel_id->FldDataType, $this->DBID));
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
		return "`hfacility_id` = @hfacility_id@ AND `hotel_id` = @hotel_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->hfacility_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hfacility_id@", ew_AdjustSql($this->hfacility_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->hotel_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hotel_id@", ew_AdjustSql($this->hotel_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "hotel_facilitieslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotel_facilitieslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotel_facilitiesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotel_facilitiesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotel_facilitiesadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotel_facilitiesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotel_facilitiesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotel_facilitiesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotel_facilitiesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "hfacility_id:" . ew_VarToJson($this->hfacility_id->CurrentValue, "number", "'");
		$json .= ",hotel_id:" . ew_VarToJson($this->hotel_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->hfacility_id->CurrentValue)) {
			$sUrl .= "hfacility_id=" . urlencode($this->hfacility_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->hotel_id->CurrentValue)) {
			$sUrl .= "&hotel_id=" . urlencode($this->hotel_id->CurrentValue);
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
			if ($isPost && isset($_POST["hfacility_id"]))
				$arKey[] = ew_StripSlashes($_POST["hfacility_id"]);
			elseif (isset($_GET["hfacility_id"]))
				$arKey[] = ew_StripSlashes($_GET["hfacility_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["hotel_id"]))
				$arKey[] = ew_StripSlashes($_POST["hotel_id"]);
			elseif (isset($_GET["hotel_id"]))
				$arKey[] = ew_StripSlashes($_GET["hotel_id"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // hfacility_id
					continue;
				if (!is_numeric($key[1])) // hotel_id
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
			$this->hfacility_id->CurrentValue = $key[0];
			$this->hotel_id->CurrentValue = $key[1];
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
		$this->hfacility_id->setDbValue($rs->fields('hfacility_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->hf_name->setDbValue($rs->fields('hf_name'));
		$this->hf_image->setDbValue($rs->fields('hf_image'));
		$this->hf_icons->setDbValue($rs->fields('hf_icons'));
		$this->status->setDbValue($rs->fields('status'));
		$this->hot_facilities->setDbValue($rs->fields('hot_facilities'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// hfacility_id
		// hotel_id
		// hf_name
		// hf_image
		// hf_icons
		// status
		// hot_facilities
		// hfacility_id

		$this->hfacility_id->ViewValue = $this->hfacility_id->CurrentValue;
		$this->hfacility_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hf_name
		$this->hf_name->ViewValue = $this->hf_name->CurrentValue;
		$this->hf_name->ViewCustomAttributes = "";

		// hf_image
		$this->hf_image->ViewValue = $this->hf_image->CurrentValue;
		$this->hf_image->ViewCustomAttributes = "";

		// hf_icons
		$this->hf_icons->ViewValue = $this->hf_icons->CurrentValue;
		$this->hf_icons->ViewCustomAttributes = "";

		// status
		if (ew_ConvertToBool($this->status->CurrentValue)) {
			$this->status->ViewValue = $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : "Y";
		} else {
			$this->status->ViewValue = $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : "N";
		}
		$this->status->ViewCustomAttributes = "";

		// hot_facilities
		if (ew_ConvertToBool($this->hot_facilities->CurrentValue)) {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(1) <> "" ? $this->hot_facilities->FldTagCaption(1) : "Y";
		} else {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(2) <> "" ? $this->hot_facilities->FldTagCaption(2) : "N";
		}
		$this->hot_facilities->ViewCustomAttributes = "";

		// hfacility_id
		$this->hfacility_id->LinkCustomAttributes = "";
		$this->hfacility_id->HrefValue = "";
		$this->hfacility_id->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// hf_name
		$this->hf_name->LinkCustomAttributes = "";
		$this->hf_name->HrefValue = "";
		$this->hf_name->TooltipValue = "";

		// hf_image
		$this->hf_image->LinkCustomAttributes = "";
		$this->hf_image->HrefValue = "";
		$this->hf_image->TooltipValue = "";

		// hf_icons
		$this->hf_icons->LinkCustomAttributes = "";
		$this->hf_icons->HrefValue = "";
		$this->hf_icons->TooltipValue = "";

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// hot_facilities
		$this->hot_facilities->LinkCustomAttributes = "";
		$this->hot_facilities->HrefValue = "";
		$this->hot_facilities->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// hfacility_id
		$this->hfacility_id->EditAttrs["class"] = "form-control";
		$this->hfacility_id->EditCustomAttributes = "";
		$this->hfacility_id->EditValue = $this->hfacility_id->CurrentValue;
		$this->hfacility_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hf_name
		$this->hf_name->EditAttrs["class"] = "form-control";
		$this->hf_name->EditCustomAttributes = "";
		$this->hf_name->EditValue = $this->hf_name->CurrentValue;
		$this->hf_name->PlaceHolder = ew_RemoveHtml($this->hf_name->FldCaption());

		// hf_image
		$this->hf_image->EditAttrs["class"] = "form-control";
		$this->hf_image->EditCustomAttributes = "";
		$this->hf_image->EditValue = $this->hf_image->CurrentValue;
		$this->hf_image->PlaceHolder = ew_RemoveHtml($this->hf_image->FldCaption());

		// hf_icons
		$this->hf_icons->EditAttrs["class"] = "form-control";
		$this->hf_icons->EditCustomAttributes = "";
		$this->hf_icons->EditValue = $this->hf_icons->CurrentValue;
		$this->hf_icons->PlaceHolder = ew_RemoveHtml($this->hf_icons->FldCaption());

		// status
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(FALSE);

		// hot_facilities
		$this->hot_facilities->EditCustomAttributes = "";
		$this->hot_facilities->EditValue = $this->hot_facilities->Options(FALSE);

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
					if ($this->hfacility_id->Exportable) $Doc->ExportCaption($this->hfacility_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->hf_name->Exportable) $Doc->ExportCaption($this->hf_name);
					if ($this->hf_image->Exportable) $Doc->ExportCaption($this->hf_image);
					if ($this->hf_icons->Exportable) $Doc->ExportCaption($this->hf_icons);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->hot_facilities->Exportable) $Doc->ExportCaption($this->hot_facilities);
				} else {
					if ($this->hfacility_id->Exportable) $Doc->ExportCaption($this->hfacility_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->hf_name->Exportable) $Doc->ExportCaption($this->hf_name);
					if ($this->hf_image->Exportable) $Doc->ExportCaption($this->hf_image);
					if ($this->hf_icons->Exportable) $Doc->ExportCaption($this->hf_icons);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->hot_facilities->Exportable) $Doc->ExportCaption($this->hot_facilities);
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
						if ($this->hfacility_id->Exportable) $Doc->ExportField($this->hfacility_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->hf_name->Exportable) $Doc->ExportField($this->hf_name);
						if ($this->hf_image->Exportable) $Doc->ExportField($this->hf_image);
						if ($this->hf_icons->Exportable) $Doc->ExportField($this->hf_icons);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->hot_facilities->Exportable) $Doc->ExportField($this->hot_facilities);
					} else {
						if ($this->hfacility_id->Exportable) $Doc->ExportField($this->hfacility_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->hf_name->Exportable) $Doc->ExportField($this->hf_name);
						if ($this->hf_image->Exportable) $Doc->ExportField($this->hf_image);
						if ($this->hf_icons->Exportable) $Doc->ExportField($this->hf_icons);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->hot_facilities->Exportable) $Doc->ExportField($this->hot_facilities);
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

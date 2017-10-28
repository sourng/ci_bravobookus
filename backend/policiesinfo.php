<?php

// Global variable for table object
$policies = NULL;

//
// Table class for policies
//
class cpolicies extends cTable {
	var $policy_id;
	var $hotel_id;
	var $policy_code;
	var $policy_name;
	var $policy_detail;
	var $policy_note;
	var $policy_for;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'policies';
		$this->TableName = 'policies';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`policies`";
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

		// policy_id
		$this->policy_id = new cField('policies', 'policies', 'x_policy_id', 'policy_id', '`policy_id`', '`policy_id`', 3, -1, FALSE, '`policy_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->policy_id->Sortable = TRUE; // Allow sort
		$this->policy_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['policy_id'] = &$this->policy_id;

		// hotel_id
		$this->hotel_id = new cField('policies', 'policies', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 3, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// policy_code
		$this->policy_code = new cField('policies', 'policies', 'x_policy_code', 'policy_code', '`policy_code`', '`policy_code`', 200, -1, FALSE, '`policy_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->policy_code->Sortable = TRUE; // Allow sort
		$this->fields['policy_code'] = &$this->policy_code;

		// policy_name
		$this->policy_name = new cField('policies', 'policies', 'x_policy_name', 'policy_name', '`policy_name`', '`policy_name`', 200, -1, FALSE, '`policy_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->policy_name->Sortable = TRUE; // Allow sort
		$this->fields['policy_name'] = &$this->policy_name;

		// policy_detail
		$this->policy_detail = new cField('policies', 'policies', 'x_policy_detail', 'policy_detail', '`policy_detail`', '`policy_detail`', 201, -1, FALSE, '`policy_detail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->policy_detail->Sortable = TRUE; // Allow sort
		$this->fields['policy_detail'] = &$this->policy_detail;

		// policy_note
		$this->policy_note = new cField('policies', 'policies', 'x_policy_note', 'policy_note', '`policy_note`', '`policy_note`', 201, -1, FALSE, '`policy_note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->policy_note->Sortable = TRUE; // Allow sort
		$this->fields['policy_note'] = &$this->policy_note;

		// policy_for
		$this->policy_for = new cField('policies', 'policies', 'x_policy_for', 'policy_for', '`policy_for`', '`policy_for`', 200, -1, FALSE, '`policy_for`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->policy_for->Sortable = TRUE; // Allow sort
		$this->fields['policy_for'] = &$this->policy_for;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`policies`";
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
			$this->policy_id->setDbValue($conn->Insert_ID());
			$rs['policy_id'] = $this->policy_id->DbValue;
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
			if (array_key_exists('policy_id', $rs))
				ew_AddFilter($where, ew_QuotedName('policy_id', $this->DBID) . '=' . ew_QuotedValue($rs['policy_id'], $this->policy_id->FldDataType, $this->DBID));
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
		return "`policy_id` = @policy_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->policy_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@policy_id@", ew_AdjustSql($this->policy_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "policieslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "policieslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("policiesview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("policiesview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "policiesadd.php?" . $this->UrlParm($parm);
		else
			$url = "policiesadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("policiesedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("policiesadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("policiesdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "policy_id:" . ew_VarToJson($this->policy_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->policy_id->CurrentValue)) {
			$sUrl .= "policy_id=" . urlencode($this->policy_id->CurrentValue);
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
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["policy_id"]))
				$arKeys[] = ew_StripSlashes($_POST["policy_id"]);
			elseif (isset($_GET["policy_id"]))
				$arKeys[] = ew_StripSlashes($_GET["policy_id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
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
			$this->policy_id->CurrentValue = $key;
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
		$this->policy_id->setDbValue($rs->fields('policy_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->policy_code->setDbValue($rs->fields('policy_code'));
		$this->policy_name->setDbValue($rs->fields('policy_name'));
		$this->policy_detail->setDbValue($rs->fields('policy_detail'));
		$this->policy_note->setDbValue($rs->fields('policy_note'));
		$this->policy_for->setDbValue($rs->fields('policy_for'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// policy_id
		// hotel_id
		// policy_code
		// policy_name
		// policy_detail
		// policy_note
		// policy_for
		// policy_id

		$this->policy_id->ViewValue = $this->policy_id->CurrentValue;
		$this->policy_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// policy_code
		$this->policy_code->ViewValue = $this->policy_code->CurrentValue;
		$this->policy_code->ViewCustomAttributes = "";

		// policy_name
		$this->policy_name->ViewValue = $this->policy_name->CurrentValue;
		$this->policy_name->ViewCustomAttributes = "";

		// policy_detail
		$this->policy_detail->ViewValue = $this->policy_detail->CurrentValue;
		$this->policy_detail->ViewCustomAttributes = "";

		// policy_note
		$this->policy_note->ViewValue = $this->policy_note->CurrentValue;
		$this->policy_note->ViewCustomAttributes = "";

		// policy_for
		$this->policy_for->ViewValue = $this->policy_for->CurrentValue;
		$this->policy_for->ViewCustomAttributes = "";

		// policy_id
		$this->policy_id->LinkCustomAttributes = "";
		$this->policy_id->HrefValue = "";
		$this->policy_id->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// policy_code
		$this->policy_code->LinkCustomAttributes = "";
		$this->policy_code->HrefValue = "";
		$this->policy_code->TooltipValue = "";

		// policy_name
		$this->policy_name->LinkCustomAttributes = "";
		$this->policy_name->HrefValue = "";
		$this->policy_name->TooltipValue = "";

		// policy_detail
		$this->policy_detail->LinkCustomAttributes = "";
		$this->policy_detail->HrefValue = "";
		$this->policy_detail->TooltipValue = "";

		// policy_note
		$this->policy_note->LinkCustomAttributes = "";
		$this->policy_note->HrefValue = "";
		$this->policy_note->TooltipValue = "";

		// policy_for
		$this->policy_for->LinkCustomAttributes = "";
		$this->policy_for->HrefValue = "";
		$this->policy_for->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// policy_id
		$this->policy_id->EditAttrs["class"] = "form-control";
		$this->policy_id->EditCustomAttributes = "";
		$this->policy_id->EditValue = $this->policy_id->CurrentValue;
		$this->policy_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

		// policy_code
		$this->policy_code->EditAttrs["class"] = "form-control";
		$this->policy_code->EditCustomAttributes = "";
		$this->policy_code->EditValue = $this->policy_code->CurrentValue;
		$this->policy_code->PlaceHolder = ew_RemoveHtml($this->policy_code->FldCaption());

		// policy_name
		$this->policy_name->EditAttrs["class"] = "form-control";
		$this->policy_name->EditCustomAttributes = "";
		$this->policy_name->EditValue = $this->policy_name->CurrentValue;
		$this->policy_name->PlaceHolder = ew_RemoveHtml($this->policy_name->FldCaption());

		// policy_detail
		$this->policy_detail->EditAttrs["class"] = "form-control";
		$this->policy_detail->EditCustomAttributes = "";
		$this->policy_detail->EditValue = $this->policy_detail->CurrentValue;
		$this->policy_detail->PlaceHolder = ew_RemoveHtml($this->policy_detail->FldCaption());

		// policy_note
		$this->policy_note->EditAttrs["class"] = "form-control";
		$this->policy_note->EditCustomAttributes = "";
		$this->policy_note->EditValue = $this->policy_note->CurrentValue;
		$this->policy_note->PlaceHolder = ew_RemoveHtml($this->policy_note->FldCaption());

		// policy_for
		$this->policy_for->EditAttrs["class"] = "form-control";
		$this->policy_for->EditCustomAttributes = "";
		$this->policy_for->EditValue = $this->policy_for->CurrentValue;
		$this->policy_for->PlaceHolder = ew_RemoveHtml($this->policy_for->FldCaption());

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
					if ($this->policy_id->Exportable) $Doc->ExportCaption($this->policy_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->policy_code->Exportable) $Doc->ExportCaption($this->policy_code);
					if ($this->policy_name->Exportable) $Doc->ExportCaption($this->policy_name);
					if ($this->policy_detail->Exportable) $Doc->ExportCaption($this->policy_detail);
					if ($this->policy_note->Exportable) $Doc->ExportCaption($this->policy_note);
					if ($this->policy_for->Exportable) $Doc->ExportCaption($this->policy_for);
				} else {
					if ($this->policy_id->Exportable) $Doc->ExportCaption($this->policy_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->policy_code->Exportable) $Doc->ExportCaption($this->policy_code);
					if ($this->policy_name->Exportable) $Doc->ExportCaption($this->policy_name);
					if ($this->policy_for->Exportable) $Doc->ExportCaption($this->policy_for);
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
						if ($this->policy_id->Exportable) $Doc->ExportField($this->policy_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->policy_code->Exportable) $Doc->ExportField($this->policy_code);
						if ($this->policy_name->Exportable) $Doc->ExportField($this->policy_name);
						if ($this->policy_detail->Exportable) $Doc->ExportField($this->policy_detail);
						if ($this->policy_note->Exportable) $Doc->ExportField($this->policy_note);
						if ($this->policy_for->Exportable) $Doc->ExportField($this->policy_for);
					} else {
						if ($this->policy_id->Exportable) $Doc->ExportField($this->policy_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->policy_code->Exportable) $Doc->ExportField($this->policy_code);
						if ($this->policy_name->Exportable) $Doc->ExportField($this->policy_name);
						if ($this->policy_for->Exportable) $Doc->ExportField($this->policy_for);
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

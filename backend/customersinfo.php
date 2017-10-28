<?php

// Global variable for table object
$customers = NULL;

//
// Table class for customers
//
class ccustomers extends cTable {
	var $customer_id;
	var $cus_fname;
	var $cus_lname;
	var $cus_gender;
	var $cus_address;
	var $cus_country;
	var $cus_email;
	var $cus_pass;
	var $cus_picutre;
	var $cus_note;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'customers';
		$this->TableName = 'customers';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`customers`";
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

		// customer_id
		$this->customer_id = new cField('customers', 'customers', 'x_customer_id', 'customer_id', '`customer_id`', '`customer_id`', 20, -1, FALSE, '`customer_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->customer_id->Sortable = TRUE; // Allow sort
		$this->customer_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['customer_id'] = &$this->customer_id;

		// cus_fname
		$this->cus_fname = new cField('customers', 'customers', 'x_cus_fname', 'cus_fname', '`cus_fname`', '`cus_fname`', 200, -1, FALSE, '`cus_fname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_fname->Sortable = TRUE; // Allow sort
		$this->fields['cus_fname'] = &$this->cus_fname;

		// cus_lname
		$this->cus_lname = new cField('customers', 'customers', 'x_cus_lname', 'cus_lname', '`cus_lname`', '`cus_lname`', 200, -1, FALSE, '`cus_lname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_lname->Sortable = TRUE; // Allow sort
		$this->fields['cus_lname'] = &$this->cus_lname;

		// cus_gender
		$this->cus_gender = new cField('customers', 'customers', 'x_cus_gender', 'cus_gender', '`cus_gender`', '`cus_gender`', 200, -1, FALSE, '`cus_gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_gender->Sortable = TRUE; // Allow sort
		$this->fields['cus_gender'] = &$this->cus_gender;

		// cus_address
		$this->cus_address = new cField('customers', 'customers', 'x_cus_address', 'cus_address', '`cus_address`', '`cus_address`', 200, -1, FALSE, '`cus_address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_address->Sortable = TRUE; // Allow sort
		$this->fields['cus_address'] = &$this->cus_address;

		// cus_country
		$this->cus_country = new cField('customers', 'customers', 'x_cus_country', 'cus_country', '`cus_country`', '`cus_country`', 200, -1, FALSE, '`cus_country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_country->Sortable = TRUE; // Allow sort
		$this->fields['cus_country'] = &$this->cus_country;

		// cus_email
		$this->cus_email = new cField('customers', 'customers', 'x_cus_email', 'cus_email', '`cus_email`', '`cus_email`', 200, -1, FALSE, '`cus_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_email->Sortable = TRUE; // Allow sort
		$this->fields['cus_email'] = &$this->cus_email;

		// cus_pass
		$this->cus_pass = new cField('customers', 'customers', 'x_cus_pass', 'cus_pass', '`cus_pass`', '`cus_pass`', 200, -1, FALSE, '`cus_pass`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_pass->Sortable = TRUE; // Allow sort
		$this->fields['cus_pass'] = &$this->cus_pass;

		// cus_picutre
		$this->cus_picutre = new cField('customers', 'customers', 'x_cus_picutre', 'cus_picutre', '`cus_picutre`', '`cus_picutre`', 200, -1, FALSE, '`cus_picutre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_picutre->Sortable = TRUE; // Allow sort
		$this->fields['cus_picutre'] = &$this->cus_picutre;

		// cus_note
		$this->cus_note = new cField('customers', 'customers', 'x_cus_note', 'cus_note', '`cus_note`', '`cus_note`', 200, -1, FALSE, '`cus_note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cus_note->Sortable = TRUE; // Allow sort
		$this->fields['cus_note'] = &$this->cus_note;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`customers`";
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
			$this->customer_id->setDbValue($conn->Insert_ID());
			$rs['customer_id'] = $this->customer_id->DbValue;
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
		return "`customer_id` = @customer_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "customerslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "customerslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("customersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("customersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "customersadd.php?" . $this->UrlParm($parm);
		else
			$url = "customersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("customersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("customersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("customersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "customer_id:" . ew_VarToJson($this->customer_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->customer_id->CurrentValue)) {
			$sUrl .= "customer_id=" . urlencode($this->customer_id->CurrentValue);
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
			if ($isPost && isset($_POST["customer_id"]))
				$arKeys[] = ew_StripSlashes($_POST["customer_id"]);
			elseif (isset($_GET["customer_id"]))
				$arKeys[] = ew_StripSlashes($_GET["customer_id"]);
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
			$this->customer_id->CurrentValue = $key;
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
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->cus_fname->setDbValue($rs->fields('cus_fname'));
		$this->cus_lname->setDbValue($rs->fields('cus_lname'));
		$this->cus_gender->setDbValue($rs->fields('cus_gender'));
		$this->cus_address->setDbValue($rs->fields('cus_address'));
		$this->cus_country->setDbValue($rs->fields('cus_country'));
		$this->cus_email->setDbValue($rs->fields('cus_email'));
		$this->cus_pass->setDbValue($rs->fields('cus_pass'));
		$this->cus_picutre->setDbValue($rs->fields('cus_picutre'));
		$this->cus_note->setDbValue($rs->fields('cus_note'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// customer_id
		// cus_fname
		// cus_lname
		// cus_gender
		// cus_address
		// cus_country
		// cus_email
		// cus_pass
		// cus_picutre
		// cus_note
		// customer_id

		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// cus_fname
		$this->cus_fname->ViewValue = $this->cus_fname->CurrentValue;
		$this->cus_fname->ViewCustomAttributes = "";

		// cus_lname
		$this->cus_lname->ViewValue = $this->cus_lname->CurrentValue;
		$this->cus_lname->ViewCustomAttributes = "";

		// cus_gender
		$this->cus_gender->ViewValue = $this->cus_gender->CurrentValue;
		$this->cus_gender->ViewCustomAttributes = "";

		// cus_address
		$this->cus_address->ViewValue = $this->cus_address->CurrentValue;
		$this->cus_address->ViewCustomAttributes = "";

		// cus_country
		$this->cus_country->ViewValue = $this->cus_country->CurrentValue;
		$this->cus_country->ViewCustomAttributes = "";

		// cus_email
		$this->cus_email->ViewValue = $this->cus_email->CurrentValue;
		$this->cus_email->ViewCustomAttributes = "";

		// cus_pass
		$this->cus_pass->ViewValue = $this->cus_pass->CurrentValue;
		$this->cus_pass->ViewCustomAttributes = "";

		// cus_picutre
		$this->cus_picutre->ViewValue = $this->cus_picutre->CurrentValue;
		$this->cus_picutre->ViewCustomAttributes = "";

		// cus_note
		$this->cus_note->ViewValue = $this->cus_note->CurrentValue;
		$this->cus_note->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->LinkCustomAttributes = "";
		$this->customer_id->HrefValue = "";
		$this->customer_id->TooltipValue = "";

		// cus_fname
		$this->cus_fname->LinkCustomAttributes = "";
		$this->cus_fname->HrefValue = "";
		$this->cus_fname->TooltipValue = "";

		// cus_lname
		$this->cus_lname->LinkCustomAttributes = "";
		$this->cus_lname->HrefValue = "";
		$this->cus_lname->TooltipValue = "";

		// cus_gender
		$this->cus_gender->LinkCustomAttributes = "";
		$this->cus_gender->HrefValue = "";
		$this->cus_gender->TooltipValue = "";

		// cus_address
		$this->cus_address->LinkCustomAttributes = "";
		$this->cus_address->HrefValue = "";
		$this->cus_address->TooltipValue = "";

		// cus_country
		$this->cus_country->LinkCustomAttributes = "";
		$this->cus_country->HrefValue = "";
		$this->cus_country->TooltipValue = "";

		// cus_email
		$this->cus_email->LinkCustomAttributes = "";
		$this->cus_email->HrefValue = "";
		$this->cus_email->TooltipValue = "";

		// cus_pass
		$this->cus_pass->LinkCustomAttributes = "";
		$this->cus_pass->HrefValue = "";
		$this->cus_pass->TooltipValue = "";

		// cus_picutre
		$this->cus_picutre->LinkCustomAttributes = "";
		$this->cus_picutre->HrefValue = "";
		$this->cus_picutre->TooltipValue = "";

		// cus_note
		$this->cus_note->LinkCustomAttributes = "";
		$this->cus_note->HrefValue = "";
		$this->cus_note->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// customer_id
		$this->customer_id->EditAttrs["class"] = "form-control";
		$this->customer_id->EditCustomAttributes = "";
		$this->customer_id->EditValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// cus_fname
		$this->cus_fname->EditAttrs["class"] = "form-control";
		$this->cus_fname->EditCustomAttributes = "";
		$this->cus_fname->EditValue = $this->cus_fname->CurrentValue;
		$this->cus_fname->PlaceHolder = ew_RemoveHtml($this->cus_fname->FldCaption());

		// cus_lname
		$this->cus_lname->EditAttrs["class"] = "form-control";
		$this->cus_lname->EditCustomAttributes = "";
		$this->cus_lname->EditValue = $this->cus_lname->CurrentValue;
		$this->cus_lname->PlaceHolder = ew_RemoveHtml($this->cus_lname->FldCaption());

		// cus_gender
		$this->cus_gender->EditAttrs["class"] = "form-control";
		$this->cus_gender->EditCustomAttributes = "";
		$this->cus_gender->EditValue = $this->cus_gender->CurrentValue;
		$this->cus_gender->PlaceHolder = ew_RemoveHtml($this->cus_gender->FldCaption());

		// cus_address
		$this->cus_address->EditAttrs["class"] = "form-control";
		$this->cus_address->EditCustomAttributes = "";
		$this->cus_address->EditValue = $this->cus_address->CurrentValue;
		$this->cus_address->PlaceHolder = ew_RemoveHtml($this->cus_address->FldCaption());

		// cus_country
		$this->cus_country->EditAttrs["class"] = "form-control";
		$this->cus_country->EditCustomAttributes = "";
		$this->cus_country->EditValue = $this->cus_country->CurrentValue;
		$this->cus_country->PlaceHolder = ew_RemoveHtml($this->cus_country->FldCaption());

		// cus_email
		$this->cus_email->EditAttrs["class"] = "form-control";
		$this->cus_email->EditCustomAttributes = "";
		$this->cus_email->EditValue = $this->cus_email->CurrentValue;
		$this->cus_email->PlaceHolder = ew_RemoveHtml($this->cus_email->FldCaption());

		// cus_pass
		$this->cus_pass->EditAttrs["class"] = "form-control";
		$this->cus_pass->EditCustomAttributes = "";
		$this->cus_pass->EditValue = $this->cus_pass->CurrentValue;
		$this->cus_pass->PlaceHolder = ew_RemoveHtml($this->cus_pass->FldCaption());

		// cus_picutre
		$this->cus_picutre->EditAttrs["class"] = "form-control";
		$this->cus_picutre->EditCustomAttributes = "";
		$this->cus_picutre->EditValue = $this->cus_picutre->CurrentValue;
		$this->cus_picutre->PlaceHolder = ew_RemoveHtml($this->cus_picutre->FldCaption());

		// cus_note
		$this->cus_note->EditAttrs["class"] = "form-control";
		$this->cus_note->EditCustomAttributes = "";
		$this->cus_note->EditValue = $this->cus_note->CurrentValue;
		$this->cus_note->PlaceHolder = ew_RemoveHtml($this->cus_note->FldCaption());

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
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->cus_fname->Exportable) $Doc->ExportCaption($this->cus_fname);
					if ($this->cus_lname->Exportable) $Doc->ExportCaption($this->cus_lname);
					if ($this->cus_gender->Exportable) $Doc->ExportCaption($this->cus_gender);
					if ($this->cus_address->Exportable) $Doc->ExportCaption($this->cus_address);
					if ($this->cus_country->Exportable) $Doc->ExportCaption($this->cus_country);
					if ($this->cus_email->Exportable) $Doc->ExportCaption($this->cus_email);
					if ($this->cus_pass->Exportable) $Doc->ExportCaption($this->cus_pass);
					if ($this->cus_picutre->Exportable) $Doc->ExportCaption($this->cus_picutre);
					if ($this->cus_note->Exportable) $Doc->ExportCaption($this->cus_note);
				} else {
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->cus_fname->Exportable) $Doc->ExportCaption($this->cus_fname);
					if ($this->cus_lname->Exportable) $Doc->ExportCaption($this->cus_lname);
					if ($this->cus_gender->Exportable) $Doc->ExportCaption($this->cus_gender);
					if ($this->cus_address->Exportable) $Doc->ExportCaption($this->cus_address);
					if ($this->cus_country->Exportable) $Doc->ExportCaption($this->cus_country);
					if ($this->cus_email->Exportable) $Doc->ExportCaption($this->cus_email);
					if ($this->cus_pass->Exportable) $Doc->ExportCaption($this->cus_pass);
					if ($this->cus_picutre->Exportable) $Doc->ExportCaption($this->cus_picutre);
					if ($this->cus_note->Exportable) $Doc->ExportCaption($this->cus_note);
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
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->cus_fname->Exportable) $Doc->ExportField($this->cus_fname);
						if ($this->cus_lname->Exportable) $Doc->ExportField($this->cus_lname);
						if ($this->cus_gender->Exportable) $Doc->ExportField($this->cus_gender);
						if ($this->cus_address->Exportable) $Doc->ExportField($this->cus_address);
						if ($this->cus_country->Exportable) $Doc->ExportField($this->cus_country);
						if ($this->cus_email->Exportable) $Doc->ExportField($this->cus_email);
						if ($this->cus_pass->Exportable) $Doc->ExportField($this->cus_pass);
						if ($this->cus_picutre->Exportable) $Doc->ExportField($this->cus_picutre);
						if ($this->cus_note->Exportable) $Doc->ExportField($this->cus_note);
					} else {
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->cus_fname->Exportable) $Doc->ExportField($this->cus_fname);
						if ($this->cus_lname->Exportable) $Doc->ExportField($this->cus_lname);
						if ($this->cus_gender->Exportable) $Doc->ExportField($this->cus_gender);
						if ($this->cus_address->Exportable) $Doc->ExportField($this->cus_address);
						if ($this->cus_country->Exportable) $Doc->ExportField($this->cus_country);
						if ($this->cus_email->Exportable) $Doc->ExportField($this->cus_email);
						if ($this->cus_pass->Exportable) $Doc->ExportField($this->cus_pass);
						if ($this->cus_picutre->Exportable) $Doc->ExportField($this->cus_picutre);
						if ($this->cus_note->Exportable) $Doc->ExportField($this->cus_note);
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

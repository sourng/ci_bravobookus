<?php

// Global variable for table object
$destinations = NULL;

//
// Table class for destinations
//
class cdestinations extends cTable {
	var $dest_id;
	var $destinations;
	var $dest_landmark;
	var $dest_description;
	var $dest_interest;
	var $thing_todo;
	var $country;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'destinations';
		$this->TableName = 'destinations';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`destinations`";
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

		// dest_id
		$this->dest_id = new cField('destinations', 'destinations', 'x_dest_id', 'dest_id', '`dest_id`', '`dest_id`', 20, -1, FALSE, '`dest_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->dest_id->Sortable = TRUE; // Allow sort
		$this->dest_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dest_id'] = &$this->dest_id;

		// destinations
		$this->destinations = new cField('destinations', 'destinations', 'x_destinations', 'destinations', '`destinations`', '`destinations`', 200, -1, FALSE, '`destinations`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->destinations->Sortable = TRUE; // Allow sort
		$this->fields['destinations'] = &$this->destinations;

		// dest_landmark
		$this->dest_landmark = new cField('destinations', 'destinations', 'x_dest_landmark', 'dest_landmark', '`dest_landmark`', '`dest_landmark`', 200, -1, TRUE, '`dest_landmark`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->dest_landmark->Sortable = TRUE; // Allow sort
		$this->fields['dest_landmark'] = &$this->dest_landmark;

		// dest_description
		$this->dest_description = new cField('destinations', 'destinations', 'x_dest_description', 'dest_description', '`dest_description`', '`dest_description`', 200, -1, FALSE, '`dest_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dest_description->Sortable = TRUE; // Allow sort
		$this->fields['dest_description'] = &$this->dest_description;

		// dest_interest
		$this->dest_interest = new cField('destinations', 'destinations', 'x_dest_interest', 'dest_interest', '`dest_interest`', '`dest_interest`', 201, -1, FALSE, '`dest_interest`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->dest_interest->Sortable = TRUE; // Allow sort
		$this->fields['dest_interest'] = &$this->dest_interest;

		// thing_todo
		$this->thing_todo = new cField('destinations', 'destinations', 'x_thing_todo', 'thing_todo', '`thing_todo`', '`thing_todo`', 201, -1, FALSE, '`thing_todo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->thing_todo->Sortable = TRUE; // Allow sort
		$this->fields['thing_todo'] = &$this->thing_todo;

		// country
		$this->country = new cField('destinations', 'destinations', 'x_country', 'country', '`country`', '`country`', 200, -1, FALSE, '`country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->country->Sortable = TRUE; // Allow sort
		$this->fields['country'] = &$this->country;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`destinations`";
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
			$this->dest_id->setDbValue($conn->Insert_ID());
			$rs['dest_id'] = $this->dest_id->DbValue;
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
			if (array_key_exists('dest_id', $rs))
				ew_AddFilter($where, ew_QuotedName('dest_id', $this->DBID) . '=' . ew_QuotedValue($rs['dest_id'], $this->dest_id->FldDataType, $this->DBID));
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
		return "`dest_id` = @dest_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->dest_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@dest_id@", ew_AdjustSql($this->dest_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "destinationslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "destinationslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("destinationsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("destinationsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "destinationsadd.php?" . $this->UrlParm($parm);
		else
			$url = "destinationsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("destinationsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("destinationsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("destinationsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "dest_id:" . ew_VarToJson($this->dest_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->dest_id->CurrentValue)) {
			$sUrl .= "dest_id=" . urlencode($this->dest_id->CurrentValue);
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
			if ($isPost && isset($_POST["dest_id"]))
				$arKeys[] = ew_StripSlashes($_POST["dest_id"]);
			elseif (isset($_GET["dest_id"]))
				$arKeys[] = ew_StripSlashes($_GET["dest_id"]);
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
			$this->dest_id->CurrentValue = $key;
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
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->destinations->setDbValue($rs->fields('destinations'));
		$this->dest_landmark->Upload->DbValue = $rs->fields('dest_landmark');
		$this->dest_description->setDbValue($rs->fields('dest_description'));
		$this->dest_interest->setDbValue($rs->fields('dest_interest'));
		$this->thing_todo->setDbValue($rs->fields('thing_todo'));
		$this->country->setDbValue($rs->fields('country'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// dest_id
		// destinations
		// dest_landmark
		// dest_description
		// dest_interest
		// thing_todo
		// country
		// dest_id

		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// destinations
		$this->destinations->ViewValue = $this->destinations->CurrentValue;
		$this->destinations->ViewCustomAttributes = "";

		// dest_landmark
		$this->dest_landmark->UploadPath = "../uploads/destinations";
		if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
			$this->dest_landmark->ImageAlt = $this->dest_landmark->FldAlt();
			$this->dest_landmark->ViewValue = $this->dest_landmark->Upload->DbValue;
		} else {
			$this->dest_landmark->ViewValue = "";
		}
		$this->dest_landmark->ViewCustomAttributes = "";

		// dest_description
		$this->dest_description->ViewValue = $this->dest_description->CurrentValue;
		$this->dest_description->ViewCustomAttributes = "";

		// dest_interest
		$this->dest_interest->ViewValue = $this->dest_interest->CurrentValue;
		$this->dest_interest->ViewCustomAttributes = "";

		// thing_todo
		$this->thing_todo->ViewValue = $this->thing_todo->CurrentValue;
		$this->thing_todo->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// dest_id
		$this->dest_id->LinkCustomAttributes = "";
		$this->dest_id->HrefValue = "";
		$this->dest_id->TooltipValue = "";

		// destinations
		$this->destinations->LinkCustomAttributes = "";
		$this->destinations->HrefValue = "";
		$this->destinations->TooltipValue = "";

		// dest_landmark
		$this->dest_landmark->LinkCustomAttributes = "";
		$this->dest_landmark->UploadPath = "../uploads/destinations";
		if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
			$this->dest_landmark->HrefValue = ew_GetFileUploadUrl($this->dest_landmark, $this->dest_landmark->Upload->DbValue); // Add prefix/suffix
			$this->dest_landmark->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->dest_landmark->HrefValue = ew_ConvertFullUrl($this->dest_landmark->HrefValue);
		} else {
			$this->dest_landmark->HrefValue = "";
		}
		$this->dest_landmark->HrefValue2 = $this->dest_landmark->UploadPath . $this->dest_landmark->Upload->DbValue;
		$this->dest_landmark->TooltipValue = "";
		if ($this->dest_landmark->UseColorbox) {
			if (ew_Empty($this->dest_landmark->TooltipValue))
				$this->dest_landmark->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->dest_landmark->LinkAttrs["data-rel"] = "destinations_x_dest_landmark";
			ew_AppendClass($this->dest_landmark->LinkAttrs["class"], "ewLightbox");
		}

		// dest_description
		$this->dest_description->LinkCustomAttributes = "";
		$this->dest_description->HrefValue = "";
		$this->dest_description->TooltipValue = "";

		// dest_interest
		$this->dest_interest->LinkCustomAttributes = "";
		$this->dest_interest->HrefValue = "";
		$this->dest_interest->TooltipValue = "";

		// thing_todo
		$this->thing_todo->LinkCustomAttributes = "";
		$this->thing_todo->HrefValue = "";
		$this->thing_todo->TooltipValue = "";

		// country
		$this->country->LinkCustomAttributes = "";
		$this->country->HrefValue = "";
		$this->country->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// dest_id
		$this->dest_id->EditAttrs["class"] = "form-control";
		$this->dest_id->EditCustomAttributes = "";
		$this->dest_id->EditValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// destinations
		$this->destinations->EditAttrs["class"] = "form-control";
		$this->destinations->EditCustomAttributes = "";
		$this->destinations->EditValue = $this->destinations->CurrentValue;
		$this->destinations->PlaceHolder = ew_RemoveHtml($this->destinations->FldCaption());

		// dest_landmark
		$this->dest_landmark->EditAttrs["class"] = "form-control";
		$this->dest_landmark->EditCustomAttributes = "";
		$this->dest_landmark->UploadPath = "../uploads/destinations";
		if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
			$this->dest_landmark->ImageAlt = $this->dest_landmark->FldAlt();
			$this->dest_landmark->EditValue = $this->dest_landmark->Upload->DbValue;
		} else {
			$this->dest_landmark->EditValue = "";
		}
		if (!ew_Empty($this->dest_landmark->CurrentValue))
			$this->dest_landmark->Upload->FileName = $this->dest_landmark->CurrentValue;

		// dest_description
		$this->dest_description->EditAttrs["class"] = "form-control";
		$this->dest_description->EditCustomAttributes = "";
		$this->dest_description->EditValue = $this->dest_description->CurrentValue;
		$this->dest_description->PlaceHolder = ew_RemoveHtml($this->dest_description->FldCaption());

		// dest_interest
		$this->dest_interest->EditAttrs["class"] = "form-control";
		$this->dest_interest->EditCustomAttributes = "";
		$this->dest_interest->EditValue = $this->dest_interest->CurrentValue;
		$this->dest_interest->PlaceHolder = ew_RemoveHtml($this->dest_interest->FldCaption());

		// thing_todo
		$this->thing_todo->EditAttrs["class"] = "form-control";
		$this->thing_todo->EditCustomAttributes = "";
		$this->thing_todo->EditValue = $this->thing_todo->CurrentValue;
		$this->thing_todo->PlaceHolder = ew_RemoveHtml($this->thing_todo->FldCaption());

		// country
		$this->country->EditAttrs["class"] = "form-control";
		$this->country->EditCustomAttributes = "";
		$this->country->EditValue = $this->country->CurrentValue;
		$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

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
					if ($this->dest_id->Exportable) $Doc->ExportCaption($this->dest_id);
					if ($this->destinations->Exportable) $Doc->ExportCaption($this->destinations);
					if ($this->dest_landmark->Exportable) $Doc->ExportCaption($this->dest_landmark);
					if ($this->dest_description->Exportable) $Doc->ExportCaption($this->dest_description);
					if ($this->dest_interest->Exportable) $Doc->ExportCaption($this->dest_interest);
					if ($this->thing_todo->Exportable) $Doc->ExportCaption($this->thing_todo);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
				} else {
					if ($this->dest_id->Exportable) $Doc->ExportCaption($this->dest_id);
					if ($this->destinations->Exportable) $Doc->ExportCaption($this->destinations);
					if ($this->dest_landmark->Exportable) $Doc->ExportCaption($this->dest_landmark);
					if ($this->dest_description->Exportable) $Doc->ExportCaption($this->dest_description);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
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
						if ($this->dest_id->Exportable) $Doc->ExportField($this->dest_id);
						if ($this->destinations->Exportable) $Doc->ExportField($this->destinations);
						if ($this->dest_landmark->Exportable) $Doc->ExportField($this->dest_landmark);
						if ($this->dest_description->Exportable) $Doc->ExportField($this->dest_description);
						if ($this->dest_interest->Exportable) $Doc->ExportField($this->dest_interest);
						if ($this->thing_todo->Exportable) $Doc->ExportField($this->thing_todo);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
					} else {
						if ($this->dest_id->Exportable) $Doc->ExportField($this->dest_id);
						if ($this->destinations->Exportable) $Doc->ExportField($this->destinations);
						if ($this->dest_landmark->Exportable) $Doc->ExportField($this->dest_landmark);
						if ($this->dest_description->Exportable) $Doc->ExportField($this->dest_description);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
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

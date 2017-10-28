<?php

// Global variable for table object
$v_last_minute_deals = NULL;

//
// Table class for v_last_minute_deals
//
class cv_last_minute_deals extends cTable {
	var $dest_id;
	var $destinations;
	var $dest_landmark;
	var $country;
	var $hotel_id;
	var $h_name;
	var $h_slug;
	var $h_feature_image;
	var $h_description;
	var $h_address;
	var $star_rating;
	var $hroom_id;
	var $hr_name;
	var $hr_image;
	var $hr_max;
	var $min28hr_hr_base_rate29;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_last_minute_deals';
		$this->TableName = 'v_last_minute_deals';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v_last_minute_deals`";
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
		$this->dest_id = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_dest_id', 'dest_id', '`dest_id`', '`dest_id`', 20, -1, FALSE, '`dest_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dest_id->Sortable = TRUE; // Allow sort
		$this->dest_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dest_id'] = &$this->dest_id;

		// destinations
		$this->destinations = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_destinations', 'destinations', '`destinations`', '`destinations`', 200, -1, FALSE, '`destinations`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->destinations->Sortable = TRUE; // Allow sort
		$this->fields['destinations'] = &$this->destinations;

		// dest_landmark
		$this->dest_landmark = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_dest_landmark', 'dest_landmark', '`dest_landmark`', '`dest_landmark`', 200, -1, FALSE, '`dest_landmark`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dest_landmark->Sortable = TRUE; // Allow sort
		$this->fields['dest_landmark'] = &$this->dest_landmark;

		// country
		$this->country = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_country', 'country', '`country`', '`country`', 200, -1, FALSE, '`country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->country->Sortable = TRUE; // Allow sort
		$this->fields['country'] = &$this->country;

		// hotel_id
		$this->hotel_id = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// h_name
		$this->h_name = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_h_name', 'h_name', '`h_name`', '`h_name`', 200, -1, FALSE, '`h_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_name->Sortable = TRUE; // Allow sort
		$this->fields['h_name'] = &$this->h_name;

		// h_slug
		$this->h_slug = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_h_slug', 'h_slug', '`h_slug`', '`h_slug`', 200, -1, FALSE, '`h_slug`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_slug->Sortable = TRUE; // Allow sort
		$this->fields['h_slug'] = &$this->h_slug;

		// h_feature_image
		$this->h_feature_image = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_h_feature_image', 'h_feature_image', '`h_feature_image`', '`h_feature_image`', 200, -1, FALSE, '`h_feature_image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_feature_image->Sortable = TRUE; // Allow sort
		$this->fields['h_feature_image'] = &$this->h_feature_image;

		// h_description
		$this->h_description = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_h_description', 'h_description', '`h_description`', '`h_description`', 201, -1, FALSE, '`h_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->h_description->Sortable = TRUE; // Allow sort
		$this->fields['h_description'] = &$this->h_description;

		// h_address
		$this->h_address = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_h_address', 'h_address', '`h_address`', '`h_address`', 200, -1, FALSE, '`h_address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_address->Sortable = TRUE; // Allow sort
		$this->fields['h_address'] = &$this->h_address;

		// star_rating
		$this->star_rating = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_star_rating', 'star_rating', '`star_rating`', '`star_rating`', 200, -1, FALSE, '`star_rating`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->star_rating->Sortable = TRUE; // Allow sort
		$this->fields['star_rating'] = &$this->star_rating;

		// hroom_id
		$this->hroom_id = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_hroom_id', 'hroom_id', '`hroom_id`', '`hroom_id`', 20, -1, FALSE, '`hroom_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hroom_id->Sortable = TRUE; // Allow sort
		$this->hroom_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hroom_id'] = &$this->hroom_id;

		// hr_name
		$this->hr_name = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_hr_name', 'hr_name', '`hr_name`', '`hr_name`', 200, -1, FALSE, '`hr_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_name->Sortable = TRUE; // Allow sort
		$this->fields['hr_name'] = &$this->hr_name;

		// hr_image
		$this->hr_image = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_hr_image', 'hr_image', '`hr_image`', '`hr_image`', 200, -1, FALSE, '`hr_image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_image->Sortable = TRUE; // Allow sort
		$this->fields['hr_image'] = &$this->hr_image;

		// hr_max
		$this->hr_max = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_hr_max', 'hr_max', '`hr_max`', '`hr_max`', 3, -1, FALSE, '`hr_max`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hr_max->Sortable = TRUE; // Allow sort
		$this->hr_max->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hr_max'] = &$this->hr_max;

		// min(hr.hr_base_rate)
		$this->min28hr_hr_base_rate29 = new cField('v_last_minute_deals', 'v_last_minute_deals', 'x_min28hr_hr_base_rate29', 'min(hr.hr_base_rate)', '`min(hr.hr_base_rate)`', '`min(hr.hr_base_rate)`', 131, -1, FALSE, '`min(hr.hr_base_rate)`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->min28hr_hr_base_rate29->Sortable = TRUE; // Allow sort
		$this->min28hr_hr_base_rate29->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['min(hr.hr_base_rate)'] = &$this->min28hr_hr_base_rate29;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v_last_minute_deals`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "v_last_minute_dealslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "v_last_minute_dealslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_last_minute_dealsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_last_minute_dealsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_last_minute_dealsadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_last_minute_dealsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v_last_minute_dealsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v_last_minute_dealsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_last_minute_dealsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->dest_landmark->setDbValue($rs->fields('dest_landmark'));
		$this->country->setDbValue($rs->fields('country'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->h_name->setDbValue($rs->fields('h_name'));
		$this->h_slug->setDbValue($rs->fields('h_slug'));
		$this->h_feature_image->setDbValue($rs->fields('h_feature_image'));
		$this->h_description->setDbValue($rs->fields('h_description'));
		$this->h_address->setDbValue($rs->fields('h_address'));
		$this->star_rating->setDbValue($rs->fields('star_rating'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hr_name->setDbValue($rs->fields('hr_name'));
		$this->hr_image->setDbValue($rs->fields('hr_image'));
		$this->hr_max->setDbValue($rs->fields('hr_max'));
		$this->min28hr_hr_base_rate29->setDbValue($rs->fields('min(hr.hr_base_rate)'));
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
		// country
		// hotel_id
		// h_name
		// h_slug
		// h_feature_image
		// h_description
		// h_address
		// star_rating
		// hroom_id
		// hr_name
		// hr_image
		// hr_max
		// min(hr.hr_base_rate)
		// dest_id

		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// destinations
		$this->destinations->ViewValue = $this->destinations->CurrentValue;
		$this->destinations->ViewCustomAttributes = "";

		// dest_landmark
		$this->dest_landmark->ViewValue = $this->dest_landmark->CurrentValue;
		$this->dest_landmark->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// h_name
		$this->h_name->ViewValue = $this->h_name->CurrentValue;
		$this->h_name->ViewCustomAttributes = "";

		// h_slug
		$this->h_slug->ViewValue = $this->h_slug->CurrentValue;
		$this->h_slug->ViewCustomAttributes = "";

		// h_feature_image
		$this->h_feature_image->ViewValue = $this->h_feature_image->CurrentValue;
		$this->h_feature_image->ViewCustomAttributes = "";

		// h_description
		$this->h_description->ViewValue = $this->h_description->CurrentValue;
		$this->h_description->ViewCustomAttributes = "";

		// h_address
		$this->h_address->ViewValue = $this->h_address->CurrentValue;
		$this->h_address->ViewCustomAttributes = "";

		// star_rating
		$this->star_rating->ViewValue = $this->star_rating->CurrentValue;
		$this->star_rating->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hr_name
		$this->hr_name->ViewValue = $this->hr_name->CurrentValue;
		$this->hr_name->ViewCustomAttributes = "";

		// hr_image
		$this->hr_image->ViewValue = $this->hr_image->CurrentValue;
		$this->hr_image->ViewCustomAttributes = "";

		// hr_max
		$this->hr_max->ViewValue = $this->hr_max->CurrentValue;
		$this->hr_max->ViewCustomAttributes = "";

		// min(hr.hr_base_rate)
		$this->min28hr_hr_base_rate29->ViewValue = $this->min28hr_hr_base_rate29->CurrentValue;
		$this->min28hr_hr_base_rate29->ViewCustomAttributes = "";

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
		$this->dest_landmark->HrefValue = "";
		$this->dest_landmark->TooltipValue = "";

		// country
		$this->country->LinkCustomAttributes = "";
		$this->country->HrefValue = "";
		$this->country->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// h_name
		$this->h_name->LinkCustomAttributes = "";
		$this->h_name->HrefValue = "";
		$this->h_name->TooltipValue = "";

		// h_slug
		$this->h_slug->LinkCustomAttributes = "";
		$this->h_slug->HrefValue = "";
		$this->h_slug->TooltipValue = "";

		// h_feature_image
		$this->h_feature_image->LinkCustomAttributes = "";
		$this->h_feature_image->HrefValue = "";
		$this->h_feature_image->TooltipValue = "";

		// h_description
		$this->h_description->LinkCustomAttributes = "";
		$this->h_description->HrefValue = "";
		$this->h_description->TooltipValue = "";

		// h_address
		$this->h_address->LinkCustomAttributes = "";
		$this->h_address->HrefValue = "";
		$this->h_address->TooltipValue = "";

		// star_rating
		$this->star_rating->LinkCustomAttributes = "";
		$this->star_rating->HrefValue = "";
		$this->star_rating->TooltipValue = "";

		// hroom_id
		$this->hroom_id->LinkCustomAttributes = "";
		$this->hroom_id->HrefValue = "";
		$this->hroom_id->TooltipValue = "";

		// hr_name
		$this->hr_name->LinkCustomAttributes = "";
		$this->hr_name->HrefValue = "";
		$this->hr_name->TooltipValue = "";

		// hr_image
		$this->hr_image->LinkCustomAttributes = "";
		$this->hr_image->HrefValue = "";
		$this->hr_image->TooltipValue = "";

		// hr_max
		$this->hr_max->LinkCustomAttributes = "";
		$this->hr_max->HrefValue = "";
		$this->hr_max->TooltipValue = "";

		// min(hr.hr_base_rate)
		$this->min28hr_hr_base_rate29->LinkCustomAttributes = "";
		$this->min28hr_hr_base_rate29->HrefValue = "";
		$this->min28hr_hr_base_rate29->TooltipValue = "";

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
		$this->dest_id->PlaceHolder = ew_RemoveHtml($this->dest_id->FldCaption());

		// destinations
		$this->destinations->EditAttrs["class"] = "form-control";
		$this->destinations->EditCustomAttributes = "";
		$this->destinations->EditValue = $this->destinations->CurrentValue;
		$this->destinations->PlaceHolder = ew_RemoveHtml($this->destinations->FldCaption());

		// dest_landmark
		$this->dest_landmark->EditAttrs["class"] = "form-control";
		$this->dest_landmark->EditCustomAttributes = "";
		$this->dest_landmark->EditValue = $this->dest_landmark->CurrentValue;
		$this->dest_landmark->PlaceHolder = ew_RemoveHtml($this->dest_landmark->FldCaption());

		// country
		$this->country->EditAttrs["class"] = "form-control";
		$this->country->EditCustomAttributes = "";
		$this->country->EditValue = $this->country->CurrentValue;
		$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

		// h_name
		$this->h_name->EditAttrs["class"] = "form-control";
		$this->h_name->EditCustomAttributes = "";
		$this->h_name->EditValue = $this->h_name->CurrentValue;
		$this->h_name->PlaceHolder = ew_RemoveHtml($this->h_name->FldCaption());

		// h_slug
		$this->h_slug->EditAttrs["class"] = "form-control";
		$this->h_slug->EditCustomAttributes = "";
		$this->h_slug->EditValue = $this->h_slug->CurrentValue;
		$this->h_slug->PlaceHolder = ew_RemoveHtml($this->h_slug->FldCaption());

		// h_feature_image
		$this->h_feature_image->EditAttrs["class"] = "form-control";
		$this->h_feature_image->EditCustomAttributes = "";
		$this->h_feature_image->EditValue = $this->h_feature_image->CurrentValue;
		$this->h_feature_image->PlaceHolder = ew_RemoveHtml($this->h_feature_image->FldCaption());

		// h_description
		$this->h_description->EditAttrs["class"] = "form-control";
		$this->h_description->EditCustomAttributes = "";
		$this->h_description->EditValue = $this->h_description->CurrentValue;
		$this->h_description->PlaceHolder = ew_RemoveHtml($this->h_description->FldCaption());

		// h_address
		$this->h_address->EditAttrs["class"] = "form-control";
		$this->h_address->EditCustomAttributes = "";
		$this->h_address->EditValue = $this->h_address->CurrentValue;
		$this->h_address->PlaceHolder = ew_RemoveHtml($this->h_address->FldCaption());

		// star_rating
		$this->star_rating->EditAttrs["class"] = "form-control";
		$this->star_rating->EditCustomAttributes = "";
		$this->star_rating->EditValue = $this->star_rating->CurrentValue;
		$this->star_rating->PlaceHolder = ew_RemoveHtml($this->star_rating->FldCaption());

		// hroom_id
		$this->hroom_id->EditAttrs["class"] = "form-control";
		$this->hroom_id->EditCustomAttributes = "";
		$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->PlaceHolder = ew_RemoveHtml($this->hroom_id->FldCaption());

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

		// hr_max
		$this->hr_max->EditAttrs["class"] = "form-control";
		$this->hr_max->EditCustomAttributes = "";
		$this->hr_max->EditValue = $this->hr_max->CurrentValue;
		$this->hr_max->PlaceHolder = ew_RemoveHtml($this->hr_max->FldCaption());

		// min(hr.hr_base_rate)
		$this->min28hr_hr_base_rate29->EditAttrs["class"] = "form-control";
		$this->min28hr_hr_base_rate29->EditCustomAttributes = "";
		$this->min28hr_hr_base_rate29->EditValue = $this->min28hr_hr_base_rate29->CurrentValue;
		$this->min28hr_hr_base_rate29->PlaceHolder = ew_RemoveHtml($this->min28hr_hr_base_rate29->FldCaption());
		if (strval($this->min28hr_hr_base_rate29->EditValue) <> "" && is_numeric($this->min28hr_hr_base_rate29->EditValue)) $this->min28hr_hr_base_rate29->EditValue = ew_FormatNumber($this->min28hr_hr_base_rate29->EditValue, -2, -1, -2, 0);

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
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->h_name->Exportable) $Doc->ExportCaption($this->h_name);
					if ($this->h_slug->Exportable) $Doc->ExportCaption($this->h_slug);
					if ($this->h_feature_image->Exportable) $Doc->ExportCaption($this->h_feature_image);
					if ($this->h_description->Exportable) $Doc->ExportCaption($this->h_description);
					if ($this->h_address->Exportable) $Doc->ExportCaption($this->h_address);
					if ($this->star_rating->Exportable) $Doc->ExportCaption($this->star_rating);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hr_name->Exportable) $Doc->ExportCaption($this->hr_name);
					if ($this->hr_image->Exportable) $Doc->ExportCaption($this->hr_image);
					if ($this->hr_max->Exportable) $Doc->ExportCaption($this->hr_max);
					if ($this->min28hr_hr_base_rate29->Exportable) $Doc->ExportCaption($this->min28hr_hr_base_rate29);
				} else {
					if ($this->dest_id->Exportable) $Doc->ExportCaption($this->dest_id);
					if ($this->destinations->Exportable) $Doc->ExportCaption($this->destinations);
					if ($this->dest_landmark->Exportable) $Doc->ExportCaption($this->dest_landmark);
					if ($this->country->Exportable) $Doc->ExportCaption($this->country);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->h_name->Exportable) $Doc->ExportCaption($this->h_name);
					if ($this->h_slug->Exportable) $Doc->ExportCaption($this->h_slug);
					if ($this->h_feature_image->Exportable) $Doc->ExportCaption($this->h_feature_image);
					if ($this->h_address->Exportable) $Doc->ExportCaption($this->h_address);
					if ($this->star_rating->Exportable) $Doc->ExportCaption($this->star_rating);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hr_name->Exportable) $Doc->ExportCaption($this->hr_name);
					if ($this->hr_image->Exportable) $Doc->ExportCaption($this->hr_image);
					if ($this->hr_max->Exportable) $Doc->ExportCaption($this->hr_max);
					if ($this->min28hr_hr_base_rate29->Exportable) $Doc->ExportCaption($this->min28hr_hr_base_rate29);
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
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->h_name->Exportable) $Doc->ExportField($this->h_name);
						if ($this->h_slug->Exportable) $Doc->ExportField($this->h_slug);
						if ($this->h_feature_image->Exportable) $Doc->ExportField($this->h_feature_image);
						if ($this->h_description->Exportable) $Doc->ExportField($this->h_description);
						if ($this->h_address->Exportable) $Doc->ExportField($this->h_address);
						if ($this->star_rating->Exportable) $Doc->ExportField($this->star_rating);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hr_name->Exportable) $Doc->ExportField($this->hr_name);
						if ($this->hr_image->Exportable) $Doc->ExportField($this->hr_image);
						if ($this->hr_max->Exportable) $Doc->ExportField($this->hr_max);
						if ($this->min28hr_hr_base_rate29->Exportable) $Doc->ExportField($this->min28hr_hr_base_rate29);
					} else {
						if ($this->dest_id->Exportable) $Doc->ExportField($this->dest_id);
						if ($this->destinations->Exportable) $Doc->ExportField($this->destinations);
						if ($this->dest_landmark->Exportable) $Doc->ExportField($this->dest_landmark);
						if ($this->country->Exportable) $Doc->ExportField($this->country);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->h_name->Exportable) $Doc->ExportField($this->h_name);
						if ($this->h_slug->Exportable) $Doc->ExportField($this->h_slug);
						if ($this->h_feature_image->Exportable) $Doc->ExportField($this->h_feature_image);
						if ($this->h_address->Exportable) $Doc->ExportField($this->h_address);
						if ($this->star_rating->Exportable) $Doc->ExportField($this->star_rating);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hr_name->Exportable) $Doc->ExportField($this->hr_name);
						if ($this->hr_image->Exportable) $Doc->ExportField($this->hr_image);
						if ($this->hr_max->Exportable) $Doc->ExportField($this->hr_max);
						if ($this->min28hr_hr_base_rate29->Exportable) $Doc->ExportField($this->min28hr_hr_base_rate29);
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

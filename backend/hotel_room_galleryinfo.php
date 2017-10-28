<?php

// Global variable for table object
$hotel_room_gallery = NULL;

//
// Table class for hotel_room_gallery
//
class chotel_room_gallery extends cTable {
	var $hrgallery_id;
	var $hroom_id;
	var $hrg_image1;
	var $hrg_image2;
	var $hrg_image3;
	var $hrg_image4;
	var $hrg_image5;
	var $hrg_image6;
	var $hrg_image7;
	var $hrg_image8;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotel_room_gallery';
		$this->TableName = 'hotel_room_gallery';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotel_room_gallery`";
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

		// hrgallery_id
		$this->hrgallery_id = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrgallery_id', 'hrgallery_id', '`hrgallery_id`', '`hrgallery_id`', 20, -1, FALSE, '`hrgallery_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->hrgallery_id->Sortable = TRUE; // Allow sort
		$this->hrgallery_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hrgallery_id'] = &$this->hrgallery_id;

		// hroom_id
		$this->hroom_id = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hroom_id', 'hroom_id', '`hroom_id`', '`hroom_id`', 20, -1, FALSE, '`hroom_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hroom_id->Sortable = TRUE; // Allow sort
		$this->hroom_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hroom_id'] = &$this->hroom_id;

		// hrg_image1
		$this->hrg_image1 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image1', 'hrg_image1', '`hrg_image1`', '`hrg_image1`', 200, -1, FALSE, '`hrg_image1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image1->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image1'] = &$this->hrg_image1;

		// hrg_image2
		$this->hrg_image2 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image2', 'hrg_image2', '`hrg_image2`', '`hrg_image2`', 200, -1, FALSE, '`hrg_image2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image2->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image2'] = &$this->hrg_image2;

		// hrg_image3
		$this->hrg_image3 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image3', 'hrg_image3', '`hrg_image3`', '`hrg_image3`', 200, -1, FALSE, '`hrg_image3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image3->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image3'] = &$this->hrg_image3;

		// hrg_image4
		$this->hrg_image4 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image4', 'hrg_image4', '`hrg_image4`', '`hrg_image4`', 200, -1, FALSE, '`hrg_image4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image4->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image4'] = &$this->hrg_image4;

		// hrg_image5
		$this->hrg_image5 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image5', 'hrg_image5', '`hrg_image5`', '`hrg_image5`', 200, -1, FALSE, '`hrg_image5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image5->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image5'] = &$this->hrg_image5;

		// hrg_image6
		$this->hrg_image6 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image6', 'hrg_image6', '`hrg_image6`', '`hrg_image6`', 200, -1, FALSE, '`hrg_image6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image6->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image6'] = &$this->hrg_image6;

		// hrg_image7
		$this->hrg_image7 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image7', 'hrg_image7', '`hrg_image7`', '`hrg_image7`', 200, -1, FALSE, '`hrg_image7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image7->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image7'] = &$this->hrg_image7;

		// hrg_image8
		$this->hrg_image8 = new cField('hotel_room_gallery', 'hotel_room_gallery', 'x_hrg_image8', 'hrg_image8', '`hrg_image8`', '`hrg_image8`', 200, -1, FALSE, '`hrg_image8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hrg_image8->Sortable = TRUE; // Allow sort
		$this->fields['hrg_image8'] = &$this->hrg_image8;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotel_room_gallery`";
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
			$this->hrgallery_id->setDbValue($conn->Insert_ID());
			$rs['hrgallery_id'] = $this->hrgallery_id->DbValue;
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
			if (array_key_exists('hrgallery_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hrgallery_id', $this->DBID) . '=' . ew_QuotedValue($rs['hrgallery_id'], $this->hrgallery_id->FldDataType, $this->DBID));
			if (array_key_exists('hroom_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hroom_id', $this->DBID) . '=' . ew_QuotedValue($rs['hroom_id'], $this->hroom_id->FldDataType, $this->DBID));
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
		return "`hrgallery_id` = @hrgallery_id@ AND `hroom_id` = @hroom_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->hrgallery_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hrgallery_id@", ew_AdjustSql($this->hrgallery_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->hroom_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hroom_id@", ew_AdjustSql($this->hroom_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "hotel_room_gallerylist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotel_room_gallerylist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotel_room_galleryview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotel_room_galleryview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotel_room_galleryadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotel_room_galleryadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotel_room_galleryedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotel_room_galleryadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotel_room_gallerydelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "hrgallery_id:" . ew_VarToJson($this->hrgallery_id->CurrentValue, "number", "'");
		$json .= ",hroom_id:" . ew_VarToJson($this->hroom_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->hrgallery_id->CurrentValue)) {
			$sUrl .= "hrgallery_id=" . urlencode($this->hrgallery_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->hroom_id->CurrentValue)) {
			$sUrl .= "&hroom_id=" . urlencode($this->hroom_id->CurrentValue);
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
			if ($isPost && isset($_POST["hrgallery_id"]))
				$arKey[] = ew_StripSlashes($_POST["hrgallery_id"]);
			elseif (isset($_GET["hrgallery_id"]))
				$arKey[] = ew_StripSlashes($_GET["hrgallery_id"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["hroom_id"]))
				$arKey[] = ew_StripSlashes($_POST["hroom_id"]);
			elseif (isset($_GET["hroom_id"]))
				$arKey[] = ew_StripSlashes($_GET["hroom_id"]);
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
				if (!is_numeric($key[0])) // hrgallery_id
					continue;
				if (!is_numeric($key[1])) // hroom_id
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
			$this->hrgallery_id->CurrentValue = $key[0];
			$this->hroom_id->CurrentValue = $key[1];
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
		$this->hrgallery_id->setDbValue($rs->fields('hrgallery_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hrg_image1->setDbValue($rs->fields('hrg_image1'));
		$this->hrg_image2->setDbValue($rs->fields('hrg_image2'));
		$this->hrg_image3->setDbValue($rs->fields('hrg_image3'));
		$this->hrg_image4->setDbValue($rs->fields('hrg_image4'));
		$this->hrg_image5->setDbValue($rs->fields('hrg_image5'));
		$this->hrg_image6->setDbValue($rs->fields('hrg_image6'));
		$this->hrg_image7->setDbValue($rs->fields('hrg_image7'));
		$this->hrg_image8->setDbValue($rs->fields('hrg_image8'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// hrgallery_id
		// hroom_id
		// hrg_image1
		// hrg_image2
		// hrg_image3
		// hrg_image4
		// hrg_image5
		// hrg_image6
		// hrg_image7
		// hrg_image8
		// hrgallery_id

		$this->hrgallery_id->ViewValue = $this->hrgallery_id->CurrentValue;
		$this->hrgallery_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hrg_image1
		$this->hrg_image1->ViewValue = $this->hrg_image1->CurrentValue;
		$this->hrg_image1->ViewCustomAttributes = "";

		// hrg_image2
		$this->hrg_image2->ViewValue = $this->hrg_image2->CurrentValue;
		$this->hrg_image2->ViewCustomAttributes = "";

		// hrg_image3
		$this->hrg_image3->ViewValue = $this->hrg_image3->CurrentValue;
		$this->hrg_image3->ViewCustomAttributes = "";

		// hrg_image4
		$this->hrg_image4->ViewValue = $this->hrg_image4->CurrentValue;
		$this->hrg_image4->ViewCustomAttributes = "";

		// hrg_image5
		$this->hrg_image5->ViewValue = $this->hrg_image5->CurrentValue;
		$this->hrg_image5->ViewCustomAttributes = "";

		// hrg_image6
		$this->hrg_image6->ViewValue = $this->hrg_image6->CurrentValue;
		$this->hrg_image6->ViewCustomAttributes = "";

		// hrg_image7
		$this->hrg_image7->ViewValue = $this->hrg_image7->CurrentValue;
		$this->hrg_image7->ViewCustomAttributes = "";

		// hrg_image8
		$this->hrg_image8->ViewValue = $this->hrg_image8->CurrentValue;
		$this->hrg_image8->ViewCustomAttributes = "";

		// hrgallery_id
		$this->hrgallery_id->LinkCustomAttributes = "";
		$this->hrgallery_id->HrefValue = "";
		$this->hrgallery_id->TooltipValue = "";

		// hroom_id
		$this->hroom_id->LinkCustomAttributes = "";
		$this->hroom_id->HrefValue = "";
		$this->hroom_id->TooltipValue = "";

		// hrg_image1
		$this->hrg_image1->LinkCustomAttributes = "";
		$this->hrg_image1->HrefValue = "";
		$this->hrg_image1->TooltipValue = "";

		// hrg_image2
		$this->hrg_image2->LinkCustomAttributes = "";
		$this->hrg_image2->HrefValue = "";
		$this->hrg_image2->TooltipValue = "";

		// hrg_image3
		$this->hrg_image3->LinkCustomAttributes = "";
		$this->hrg_image3->HrefValue = "";
		$this->hrg_image3->TooltipValue = "";

		// hrg_image4
		$this->hrg_image4->LinkCustomAttributes = "";
		$this->hrg_image4->HrefValue = "";
		$this->hrg_image4->TooltipValue = "";

		// hrg_image5
		$this->hrg_image5->LinkCustomAttributes = "";
		$this->hrg_image5->HrefValue = "";
		$this->hrg_image5->TooltipValue = "";

		// hrg_image6
		$this->hrg_image6->LinkCustomAttributes = "";
		$this->hrg_image6->HrefValue = "";
		$this->hrg_image6->TooltipValue = "";

		// hrg_image7
		$this->hrg_image7->LinkCustomAttributes = "";
		$this->hrg_image7->HrefValue = "";
		$this->hrg_image7->TooltipValue = "";

		// hrg_image8
		$this->hrg_image8->LinkCustomAttributes = "";
		$this->hrg_image8->HrefValue = "";
		$this->hrg_image8->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// hrgallery_id
		$this->hrgallery_id->EditAttrs["class"] = "form-control";
		$this->hrgallery_id->EditCustomAttributes = "";
		$this->hrgallery_id->EditValue = $this->hrgallery_id->CurrentValue;
		$this->hrgallery_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->EditAttrs["class"] = "form-control";
		$this->hroom_id->EditCustomAttributes = "";
		$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hrg_image1
		$this->hrg_image1->EditAttrs["class"] = "form-control";
		$this->hrg_image1->EditCustomAttributes = "";
		$this->hrg_image1->EditValue = $this->hrg_image1->CurrentValue;
		$this->hrg_image1->PlaceHolder = ew_RemoveHtml($this->hrg_image1->FldCaption());

		// hrg_image2
		$this->hrg_image2->EditAttrs["class"] = "form-control";
		$this->hrg_image2->EditCustomAttributes = "";
		$this->hrg_image2->EditValue = $this->hrg_image2->CurrentValue;
		$this->hrg_image2->PlaceHolder = ew_RemoveHtml($this->hrg_image2->FldCaption());

		// hrg_image3
		$this->hrg_image3->EditAttrs["class"] = "form-control";
		$this->hrg_image3->EditCustomAttributes = "";
		$this->hrg_image3->EditValue = $this->hrg_image3->CurrentValue;
		$this->hrg_image3->PlaceHolder = ew_RemoveHtml($this->hrg_image3->FldCaption());

		// hrg_image4
		$this->hrg_image4->EditAttrs["class"] = "form-control";
		$this->hrg_image4->EditCustomAttributes = "";
		$this->hrg_image4->EditValue = $this->hrg_image4->CurrentValue;
		$this->hrg_image4->PlaceHolder = ew_RemoveHtml($this->hrg_image4->FldCaption());

		// hrg_image5
		$this->hrg_image5->EditAttrs["class"] = "form-control";
		$this->hrg_image5->EditCustomAttributes = "";
		$this->hrg_image5->EditValue = $this->hrg_image5->CurrentValue;
		$this->hrg_image5->PlaceHolder = ew_RemoveHtml($this->hrg_image5->FldCaption());

		// hrg_image6
		$this->hrg_image6->EditAttrs["class"] = "form-control";
		$this->hrg_image6->EditCustomAttributes = "";
		$this->hrg_image6->EditValue = $this->hrg_image6->CurrentValue;
		$this->hrg_image6->PlaceHolder = ew_RemoveHtml($this->hrg_image6->FldCaption());

		// hrg_image7
		$this->hrg_image7->EditAttrs["class"] = "form-control";
		$this->hrg_image7->EditCustomAttributes = "";
		$this->hrg_image7->EditValue = $this->hrg_image7->CurrentValue;
		$this->hrg_image7->PlaceHolder = ew_RemoveHtml($this->hrg_image7->FldCaption());

		// hrg_image8
		$this->hrg_image8->EditAttrs["class"] = "form-control";
		$this->hrg_image8->EditCustomAttributes = "";
		$this->hrg_image8->EditValue = $this->hrg_image8->CurrentValue;
		$this->hrg_image8->PlaceHolder = ew_RemoveHtml($this->hrg_image8->FldCaption());

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
					if ($this->hrgallery_id->Exportable) $Doc->ExportCaption($this->hrgallery_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hrg_image1->Exportable) $Doc->ExportCaption($this->hrg_image1);
					if ($this->hrg_image2->Exportable) $Doc->ExportCaption($this->hrg_image2);
					if ($this->hrg_image3->Exportable) $Doc->ExportCaption($this->hrg_image3);
					if ($this->hrg_image4->Exportable) $Doc->ExportCaption($this->hrg_image4);
					if ($this->hrg_image5->Exportable) $Doc->ExportCaption($this->hrg_image5);
					if ($this->hrg_image6->Exportable) $Doc->ExportCaption($this->hrg_image6);
					if ($this->hrg_image7->Exportable) $Doc->ExportCaption($this->hrg_image7);
					if ($this->hrg_image8->Exportable) $Doc->ExportCaption($this->hrg_image8);
				} else {
					if ($this->hrgallery_id->Exportable) $Doc->ExportCaption($this->hrgallery_id);
					if ($this->hroom_id->Exportable) $Doc->ExportCaption($this->hroom_id);
					if ($this->hrg_image1->Exportable) $Doc->ExportCaption($this->hrg_image1);
					if ($this->hrg_image2->Exportable) $Doc->ExportCaption($this->hrg_image2);
					if ($this->hrg_image3->Exportable) $Doc->ExportCaption($this->hrg_image3);
					if ($this->hrg_image4->Exportable) $Doc->ExportCaption($this->hrg_image4);
					if ($this->hrg_image5->Exportable) $Doc->ExportCaption($this->hrg_image5);
					if ($this->hrg_image6->Exportable) $Doc->ExportCaption($this->hrg_image6);
					if ($this->hrg_image7->Exportable) $Doc->ExportCaption($this->hrg_image7);
					if ($this->hrg_image8->Exportable) $Doc->ExportCaption($this->hrg_image8);
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
						if ($this->hrgallery_id->Exportable) $Doc->ExportField($this->hrgallery_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hrg_image1->Exportable) $Doc->ExportField($this->hrg_image1);
						if ($this->hrg_image2->Exportable) $Doc->ExportField($this->hrg_image2);
						if ($this->hrg_image3->Exportable) $Doc->ExportField($this->hrg_image3);
						if ($this->hrg_image4->Exportable) $Doc->ExportField($this->hrg_image4);
						if ($this->hrg_image5->Exportable) $Doc->ExportField($this->hrg_image5);
						if ($this->hrg_image6->Exportable) $Doc->ExportField($this->hrg_image6);
						if ($this->hrg_image7->Exportable) $Doc->ExportField($this->hrg_image7);
						if ($this->hrg_image8->Exportable) $Doc->ExportField($this->hrg_image8);
					} else {
						if ($this->hrgallery_id->Exportable) $Doc->ExportField($this->hrgallery_id);
						if ($this->hroom_id->Exportable) $Doc->ExportField($this->hroom_id);
						if ($this->hrg_image1->Exportable) $Doc->ExportField($this->hrg_image1);
						if ($this->hrg_image2->Exportable) $Doc->ExportField($this->hrg_image2);
						if ($this->hrg_image3->Exportable) $Doc->ExportField($this->hrg_image3);
						if ($this->hrg_image4->Exportable) $Doc->ExportField($this->hrg_image4);
						if ($this->hrg_image5->Exportable) $Doc->ExportField($this->hrg_image5);
						if ($this->hrg_image6->Exportable) $Doc->ExportField($this->hrg_image6);
						if ($this->hrg_image7->Exportable) $Doc->ExportField($this->hrg_image7);
						if ($this->hrg_image8->Exportable) $Doc->ExportField($this->hrg_image8);
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

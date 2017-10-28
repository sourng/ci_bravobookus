<?php

// Global variable for table object
$users = NULL;

//
// Table class for users
//
class cusers extends cTable {
	var $uid;
	var $gro_id;
	var $unique_id;
	var $name;
	var $_email;
	var $user_name;
	var $encrypted_password;
	var $salt;
	var $note;
	var $user_create;
	var $created_date;
	var $user_update;
	var $updated_date;
	var $image;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'users';
		$this->TableName = 'users';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`users`";
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

		// uid
		$this->uid = new cField('users', 'users', 'x_uid', 'uid', '`uid`', '`uid`', 20, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->uid->Sortable = TRUE; // Allow sort
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// gro_id
		$this->gro_id = new cField('users', 'users', 'x_gro_id', 'gro_id', '`gro_id`', '`gro_id`', 3, -1, FALSE, '`gro_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gro_id->Sortable = TRUE; // Allow sort
		$this->gro_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['gro_id'] = &$this->gro_id;

		// unique_id
		$this->unique_id = new cField('users', 'users', 'x_unique_id', 'unique_id', '`unique_id`', '`unique_id`', 200, -1, FALSE, '`unique_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->unique_id->Sortable = TRUE; // Allow sort
		$this->fields['unique_id'] = &$this->unique_id;

		// name
		$this->name = new cField('users', 'users', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->name->Sortable = TRUE; // Allow sort
		$this->fields['name'] = &$this->name;

		// email
		$this->_email = new cField('users', 'users', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// user_name
		$this->user_name = new cField('users', 'users', 'x_user_name', 'user_name', '`user_name`', '`user_name`', 200, -1, FALSE, '`user_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_name->Sortable = TRUE; // Allow sort
		$this->fields['user_name'] = &$this->user_name;

		// encrypted_password
		$this->encrypted_password = new cField('users', 'users', 'x_encrypted_password', 'encrypted_password', '`encrypted_password`', '`encrypted_password`', 200, -1, FALSE, '`encrypted_password`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->encrypted_password->Sortable = TRUE; // Allow sort
		$this->fields['encrypted_password'] = &$this->encrypted_password;

		// salt
		$this->salt = new cField('users', 'users', 'x_salt', 'salt', '`salt`', '`salt`', 200, -1, FALSE, '`salt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->salt->Sortable = TRUE; // Allow sort
		$this->fields['salt'] = &$this->salt;

		// note
		$this->note = new cField('users', 'users', 'x_note', 'note', '`note`', '`note`', 201, -1, FALSE, '`note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->note->Sortable = TRUE; // Allow sort
		$this->fields['note'] = &$this->note;

		// user_create
		$this->user_create = new cField('users', 'users', 'x_user_create', 'user_create', '`user_create`', '`user_create`', 3, -1, FALSE, '`user_create`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_create->Sortable = TRUE; // Allow sort
		$this->user_create->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_create'] = &$this->user_create;

		// created_date
		$this->created_date = new cField('users', 'users', 'x_created_date', 'created_date', '`created_date`', ew_CastDateFieldForLike('`created_date`', 0, "DB"), 135, 0, FALSE, '`created_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->created_date->Sortable = TRUE; // Allow sort
		$this->created_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['created_date'] = &$this->created_date;

		// user_update
		$this->user_update = new cField('users', 'users', 'x_user_update', 'user_update', '`user_update`', '`user_update`', 200, -1, FALSE, '`user_update`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_update->Sortable = TRUE; // Allow sort
		$this->fields['user_update'] = &$this->user_update;

		// updated_date
		$this->updated_date = new cField('users', 'users', 'x_updated_date', 'updated_date', '`updated_date`', ew_CastDateFieldForLike('`updated_date`', 0, "DB"), 135, 0, FALSE, '`updated_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->updated_date->Sortable = TRUE; // Allow sort
		$this->updated_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['updated_date'] = &$this->updated_date;

		// image
		$this->image = new cField('users', 'users', 'x_image', 'image', '`image`', '`image`', 200, -1, FALSE, '`image`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->image->Sortable = TRUE; // Allow sort
		$this->fields['image'] = &$this->image;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`users`";
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
			$this->uid->setDbValue($conn->Insert_ID());
			$rs['uid'] = $this->uid->DbValue;
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
			if (array_key_exists('uid', $rs))
				ew_AddFilter($where, ew_QuotedName('uid', $this->DBID) . '=' . ew_QuotedValue($rs['uid'], $this->uid->FldDataType, $this->DBID));
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
		return "`uid` = @uid@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->uid->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@uid@", ew_AdjustSql($this->uid->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "userslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "userslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("usersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("usersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "usersadd.php?" . $this->UrlParm($parm);
		else
			$url = "usersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("usersedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("usersadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("usersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "uid:" . ew_VarToJson($this->uid->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->uid->CurrentValue)) {
			$sUrl .= "uid=" . urlencode($this->uid->CurrentValue);
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
			if ($isPost && isset($_POST["uid"]))
				$arKeys[] = ew_StripSlashes($_POST["uid"]);
			elseif (isset($_GET["uid"]))
				$arKeys[] = ew_StripSlashes($_GET["uid"]);
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
			$this->uid->CurrentValue = $key;
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
		$this->uid->setDbValue($rs->fields('uid'));
		$this->gro_id->setDbValue($rs->fields('gro_id'));
		$this->unique_id->setDbValue($rs->fields('unique_id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->user_name->setDbValue($rs->fields('user_name'));
		$this->encrypted_password->setDbValue($rs->fields('encrypted_password'));
		$this->salt->setDbValue($rs->fields('salt'));
		$this->note->setDbValue($rs->fields('note'));
		$this->user_create->setDbValue($rs->fields('user_create'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->user_update->setDbValue($rs->fields('user_update'));
		$this->updated_date->setDbValue($rs->fields('updated_date'));
		$this->image->setDbValue($rs->fields('image'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// uid
		// gro_id
		// unique_id
		// name
		// email
		// user_name
		// encrypted_password
		// salt
		// note
		// user_create
		// created_date
		// user_update
		// updated_date
		// image
		// uid

		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// gro_id
		$this->gro_id->ViewValue = $this->gro_id->CurrentValue;
		$this->gro_id->ViewCustomAttributes = "";

		// unique_id
		$this->unique_id->ViewValue = $this->unique_id->CurrentValue;
		$this->unique_id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// user_name
		$this->user_name->ViewValue = $this->user_name->CurrentValue;
		$this->user_name->ViewCustomAttributes = "";

		// encrypted_password
		$this->encrypted_password->ViewValue = $this->encrypted_password->CurrentValue;
		$this->encrypted_password->ViewCustomAttributes = "";

		// salt
		$this->salt->ViewValue = $this->salt->CurrentValue;
		$this->salt->ViewCustomAttributes = "";

		// note
		$this->note->ViewValue = $this->note->CurrentValue;
		$this->note->ViewCustomAttributes = "";

		// user_create
		$this->user_create->ViewValue = $this->user_create->CurrentValue;
		$this->user_create->ViewCustomAttributes = "";

		// created_date
		$this->created_date->ViewValue = $this->created_date->CurrentValue;
		$this->created_date->ViewValue = ew_FormatDateTime($this->created_date->ViewValue, 0);
		$this->created_date->ViewCustomAttributes = "";

		// user_update
		$this->user_update->ViewValue = $this->user_update->CurrentValue;
		$this->user_update->ViewCustomAttributes = "";

		// updated_date
		$this->updated_date->ViewValue = $this->updated_date->CurrentValue;
		$this->updated_date->ViewValue = ew_FormatDateTime($this->updated_date->ViewValue, 0);
		$this->updated_date->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// gro_id
		$this->gro_id->LinkCustomAttributes = "";
		$this->gro_id->HrefValue = "";
		$this->gro_id->TooltipValue = "";

		// unique_id
		$this->unique_id->LinkCustomAttributes = "";
		$this->unique_id->HrefValue = "";
		$this->unique_id->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// user_name
		$this->user_name->LinkCustomAttributes = "";
		$this->user_name->HrefValue = "";
		$this->user_name->TooltipValue = "";

		// encrypted_password
		$this->encrypted_password->LinkCustomAttributes = "";
		$this->encrypted_password->HrefValue = "";
		$this->encrypted_password->TooltipValue = "";

		// salt
		$this->salt->LinkCustomAttributes = "";
		$this->salt->HrefValue = "";
		$this->salt->TooltipValue = "";

		// note
		$this->note->LinkCustomAttributes = "";
		$this->note->HrefValue = "";
		$this->note->TooltipValue = "";

		// user_create
		$this->user_create->LinkCustomAttributes = "";
		$this->user_create->HrefValue = "";
		$this->user_create->TooltipValue = "";

		// created_date
		$this->created_date->LinkCustomAttributes = "";
		$this->created_date->HrefValue = "";
		$this->created_date->TooltipValue = "";

		// user_update
		$this->user_update->LinkCustomAttributes = "";
		$this->user_update->HrefValue = "";
		$this->user_update->TooltipValue = "";

		// updated_date
		$this->updated_date->LinkCustomAttributes = "";
		$this->updated_date->HrefValue = "";
		$this->updated_date->TooltipValue = "";

		// image
		$this->image->LinkCustomAttributes = "";
		$this->image->HrefValue = "";
		$this->image->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// uid
		$this->uid->EditAttrs["class"] = "form-control";
		$this->uid->EditCustomAttributes = "";
		$this->uid->EditValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// gro_id
		$this->gro_id->EditAttrs["class"] = "form-control";
		$this->gro_id->EditCustomAttributes = "";
		$this->gro_id->EditValue = $this->gro_id->CurrentValue;
		$this->gro_id->PlaceHolder = ew_RemoveHtml($this->gro_id->FldCaption());

		// unique_id
		$this->unique_id->EditAttrs["class"] = "form-control";
		$this->unique_id->EditCustomAttributes = "";
		$this->unique_id->EditValue = $this->unique_id->CurrentValue;
		$this->unique_id->PlaceHolder = ew_RemoveHtml($this->unique_id->FldCaption());

		// name
		$this->name->EditAttrs["class"] = "form-control";
		$this->name->EditCustomAttributes = "";
		$this->name->EditValue = $this->name->CurrentValue;
		$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// user_name
		$this->user_name->EditAttrs["class"] = "form-control";
		$this->user_name->EditCustomAttributes = "";
		$this->user_name->EditValue = $this->user_name->CurrentValue;
		$this->user_name->PlaceHolder = ew_RemoveHtml($this->user_name->FldCaption());

		// encrypted_password
		$this->encrypted_password->EditAttrs["class"] = "form-control";
		$this->encrypted_password->EditCustomAttributes = "";
		$this->encrypted_password->EditValue = $this->encrypted_password->CurrentValue;
		$this->encrypted_password->PlaceHolder = ew_RemoveHtml($this->encrypted_password->FldCaption());

		// salt
		$this->salt->EditAttrs["class"] = "form-control";
		$this->salt->EditCustomAttributes = "";
		$this->salt->EditValue = $this->salt->CurrentValue;
		$this->salt->PlaceHolder = ew_RemoveHtml($this->salt->FldCaption());

		// note
		$this->note->EditAttrs["class"] = "form-control";
		$this->note->EditCustomAttributes = "";
		$this->note->EditValue = $this->note->CurrentValue;
		$this->note->PlaceHolder = ew_RemoveHtml($this->note->FldCaption());

		// user_create
		$this->user_create->EditAttrs["class"] = "form-control";
		$this->user_create->EditCustomAttributes = "";
		$this->user_create->EditValue = $this->user_create->CurrentValue;
		$this->user_create->PlaceHolder = ew_RemoveHtml($this->user_create->FldCaption());

		// created_date
		$this->created_date->EditAttrs["class"] = "form-control";
		$this->created_date->EditCustomAttributes = "";
		$this->created_date->EditValue = ew_FormatDateTime($this->created_date->CurrentValue, 8);
		$this->created_date->PlaceHolder = ew_RemoveHtml($this->created_date->FldCaption());

		// user_update
		$this->user_update->EditAttrs["class"] = "form-control";
		$this->user_update->EditCustomAttributes = "";
		$this->user_update->EditValue = $this->user_update->CurrentValue;
		$this->user_update->PlaceHolder = ew_RemoveHtml($this->user_update->FldCaption());

		// updated_date
		$this->updated_date->EditAttrs["class"] = "form-control";
		$this->updated_date->EditCustomAttributes = "";
		$this->updated_date->EditValue = ew_FormatDateTime($this->updated_date->CurrentValue, 8);
		$this->updated_date->PlaceHolder = ew_RemoveHtml($this->updated_date->FldCaption());

		// image
		$this->image->EditAttrs["class"] = "form-control";
		$this->image->EditCustomAttributes = "";
		$this->image->EditValue = $this->image->CurrentValue;
		$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

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
					if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
					if ($this->gro_id->Exportable) $Doc->ExportCaption($this->gro_id);
					if ($this->unique_id->Exportable) $Doc->ExportCaption($this->unique_id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->user_name->Exportable) $Doc->ExportCaption($this->user_name);
					if ($this->encrypted_password->Exportable) $Doc->ExportCaption($this->encrypted_password);
					if ($this->salt->Exportable) $Doc->ExportCaption($this->salt);
					if ($this->note->Exportable) $Doc->ExportCaption($this->note);
					if ($this->user_create->Exportable) $Doc->ExportCaption($this->user_create);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->user_update->Exportable) $Doc->ExportCaption($this->user_update);
					if ($this->updated_date->Exportable) $Doc->ExportCaption($this->updated_date);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
				} else {
					if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
					if ($this->gro_id->Exportable) $Doc->ExportCaption($this->gro_id);
					if ($this->unique_id->Exportable) $Doc->ExportCaption($this->unique_id);
					if ($this->name->Exportable) $Doc->ExportCaption($this->name);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->user_name->Exportable) $Doc->ExportCaption($this->user_name);
					if ($this->encrypted_password->Exportable) $Doc->ExportCaption($this->encrypted_password);
					if ($this->salt->Exportable) $Doc->ExportCaption($this->salt);
					if ($this->user_create->Exportable) $Doc->ExportCaption($this->user_create);
					if ($this->created_date->Exportable) $Doc->ExportCaption($this->created_date);
					if ($this->user_update->Exportable) $Doc->ExportCaption($this->user_update);
					if ($this->updated_date->Exportable) $Doc->ExportCaption($this->updated_date);
					if ($this->image->Exportable) $Doc->ExportCaption($this->image);
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
						if ($this->uid->Exportable) $Doc->ExportField($this->uid);
						if ($this->gro_id->Exportable) $Doc->ExportField($this->gro_id);
						if ($this->unique_id->Exportable) $Doc->ExportField($this->unique_id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->user_name->Exportable) $Doc->ExportField($this->user_name);
						if ($this->encrypted_password->Exportable) $Doc->ExportField($this->encrypted_password);
						if ($this->salt->Exportable) $Doc->ExportField($this->salt);
						if ($this->note->Exportable) $Doc->ExportField($this->note);
						if ($this->user_create->Exportable) $Doc->ExportField($this->user_create);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->user_update->Exportable) $Doc->ExportField($this->user_update);
						if ($this->updated_date->Exportable) $Doc->ExportField($this->updated_date);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
					} else {
						if ($this->uid->Exportable) $Doc->ExportField($this->uid);
						if ($this->gro_id->Exportable) $Doc->ExportField($this->gro_id);
						if ($this->unique_id->Exportable) $Doc->ExportField($this->unique_id);
						if ($this->name->Exportable) $Doc->ExportField($this->name);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->user_name->Exportable) $Doc->ExportField($this->user_name);
						if ($this->encrypted_password->Exportable) $Doc->ExportField($this->encrypted_password);
						if ($this->salt->Exportable) $Doc->ExportField($this->salt);
						if ($this->user_create->Exportable) $Doc->ExportField($this->user_create);
						if ($this->created_date->Exportable) $Doc->ExportField($this->created_date);
						if ($this->user_update->Exportable) $Doc->ExportField($this->user_update);
						if ($this->updated_date->Exportable) $Doc->ExportField($this->updated_date);
						if ($this->image->Exportable) $Doc->ExportField($this->image);
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

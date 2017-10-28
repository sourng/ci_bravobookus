<?php

// Global variable for table object
$hotels = NULL;

//
// Table class for hotels
//
class chotels extends cTable {
	var $hotel_id;
	var $h_name;
	var $h_slug;
	var $h_feature_image;
	var $h_description;
	var $h_meta_key;
	var $h_deatail;
	var $h_facilities;
	var $h_address;
	var $h_create;
	var $dest_id;
	var $province;
	var $whylike;
	var $lang_spoken;
	var $map;
	var $what_todo;
	var $h_id_cod;
	var $h_email;
	var $h_contact_name;
	var $h_pass;
	var $h_contact_phone;
	var $h_site;
	var $contact_fax;
	var $star_rating;
	var $create_date;
	var $update_date;
	var $h_online_status;
	var $hotel_blocked;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotels';
		$this->TableName = 'hotels';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotels`";
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

		// hotel_id
		$this->hotel_id = new cField('hotels', 'hotels', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// h_name
		$this->h_name = new cField('hotels', 'hotels', 'x_h_name', 'h_name', '`h_name`', '`h_name`', 200, -1, FALSE, '`h_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_name->Sortable = TRUE; // Allow sort
		$this->fields['h_name'] = &$this->h_name;

		// h_slug
		$this->h_slug = new cField('hotels', 'hotels', 'x_h_slug', 'h_slug', '`h_slug`', '`h_slug`', 200, -1, FALSE, '`h_slug`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_slug->Sortable = TRUE; // Allow sort
		$this->fields['h_slug'] = &$this->h_slug;

		// h_feature_image
		$this->h_feature_image = new cField('hotels', 'hotels', 'x_h_feature_image', 'h_feature_image', '`h_feature_image`', '`h_feature_image`', 200, -1, TRUE, '`h_feature_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->h_feature_image->Sortable = TRUE; // Allow sort
		$this->fields['h_feature_image'] = &$this->h_feature_image;

		// h_description
		$this->h_description = new cField('hotels', 'hotels', 'x_h_description', 'h_description', '`h_description`', '`h_description`', 201, -1, FALSE, '`h_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->h_description->Sortable = TRUE; // Allow sort
		$this->fields['h_description'] = &$this->h_description;

		// h_meta_key
		$this->h_meta_key = new cField('hotels', 'hotels', 'x_h_meta_key', 'h_meta_key', '`h_meta_key`', '`h_meta_key`', 201, -1, FALSE, '`h_meta_key`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->h_meta_key->Sortable = TRUE; // Allow sort
		$this->fields['h_meta_key'] = &$this->h_meta_key;

		// h_deatail
		$this->h_deatail = new cField('hotels', 'hotels', 'x_h_deatail', 'h_deatail', '`h_deatail`', '`h_deatail`', 201, -1, FALSE, '`h_deatail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->h_deatail->Sortable = TRUE; // Allow sort
		$this->fields['h_deatail'] = &$this->h_deatail;

		// h_facilities
		$this->h_facilities = new cField('hotels', 'hotels', 'x_h_facilities', 'h_facilities', '`h_facilities`', '`h_facilities`', 201, -1, FALSE, '`h_facilities`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->h_facilities->Sortable = TRUE; // Allow sort
		$this->fields['h_facilities'] = &$this->h_facilities;

		// h_address
		$this->h_address = new cField('hotels', 'hotels', 'x_h_address', 'h_address', '`h_address`', '`h_address`', 200, -1, FALSE, '`h_address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_address->Sortable = TRUE; // Allow sort
		$this->fields['h_address'] = &$this->h_address;

		// h_create
		$this->h_create = new cField('hotels', 'hotels', 'x_h_create', 'h_create', '`h_create`', ew_CastDateFieldForLike('`h_create`', 0, "DB"), 135, 0, FALSE, '`h_create`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_create->Sortable = TRUE; // Allow sort
		$this->h_create->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['h_create'] = &$this->h_create;

		// dest_id
		$this->dest_id = new cField('hotels', 'hotels', 'x_dest_id', 'dest_id', '`dest_id`', '`dest_id`', 20, -1, FALSE, '`dest_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dest_id->Sortable = TRUE; // Allow sort
		$this->dest_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dest_id'] = &$this->dest_id;

		// province
		$this->province = new cField('hotels', 'hotels', 'x_province', 'province', '`province`', '`province`', 200, -1, FALSE, '`province`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->province->Sortable = TRUE; // Allow sort
		$this->fields['province'] = &$this->province;

		// whylike
		$this->whylike = new cField('hotels', 'hotels', 'x_whylike', 'whylike', '`whylike`', '`whylike`', 201, -1, FALSE, '`whylike`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->whylike->Sortable = TRUE; // Allow sort
		$this->fields['whylike'] = &$this->whylike;

		// lang_spoken
		$this->lang_spoken = new cField('hotels', 'hotels', 'x_lang_spoken', 'lang_spoken', '`lang_spoken`', '`lang_spoken`', 201, -1, FALSE, '`lang_spoken`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->lang_spoken->Sortable = TRUE; // Allow sort
		$this->fields['lang_spoken'] = &$this->lang_spoken;

		// map
		$this->map = new cField('hotels', 'hotels', 'x_map', 'map', '`map`', '`map`', 201, -1, FALSE, '`map`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->map->Sortable = TRUE; // Allow sort
		$this->fields['map'] = &$this->map;

		// what_todo
		$this->what_todo = new cField('hotels', 'hotels', 'x_what_todo', 'what_todo', '`what_todo`', '`what_todo`', 201, -1, FALSE, '`what_todo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->what_todo->Sortable = TRUE; // Allow sort
		$this->fields['what_todo'] = &$this->what_todo;

		// h_id_cod
		$this->h_id_cod = new cField('hotels', 'hotels', 'x_h_id_cod', 'h_id_cod', '`h_id_cod`', '`h_id_cod`', 200, -1, FALSE, '`h_id_cod`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_id_cod->Sortable = TRUE; // Allow sort
		$this->fields['h_id_cod'] = &$this->h_id_cod;

		// h_email
		$this->h_email = new cField('hotels', 'hotels', 'x_h_email', 'h_email', '`h_email`', '`h_email`', 200, -1, FALSE, '`h_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_email->Sortable = TRUE; // Allow sort
		$this->fields['h_email'] = &$this->h_email;

		// h_contact_name
		$this->h_contact_name = new cField('hotels', 'hotels', 'x_h_contact_name', 'h_contact_name', '`h_contact_name`', '`h_contact_name`', 200, -1, FALSE, '`h_contact_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_contact_name->Sortable = TRUE; // Allow sort
		$this->fields['h_contact_name'] = &$this->h_contact_name;

		// h_pass
		$this->h_pass = new cField('hotels', 'hotels', 'x_h_pass', 'h_pass', '`h_pass`', '`h_pass`', 200, -1, FALSE, '`h_pass`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_pass->Sortable = TRUE; // Allow sort
		$this->fields['h_pass'] = &$this->h_pass;

		// h_contact_phone
		$this->h_contact_phone = new cField('hotels', 'hotels', 'x_h_contact_phone', 'h_contact_phone', '`h_contact_phone`', '`h_contact_phone`', 200, -1, FALSE, '`h_contact_phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_contact_phone->Sortable = TRUE; // Allow sort
		$this->fields['h_contact_phone'] = &$this->h_contact_phone;

		// h_site
		$this->h_site = new cField('hotels', 'hotels', 'x_h_site', 'h_site', '`h_site`', '`h_site`', 200, -1, FALSE, '`h_site`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->h_site->Sortable = TRUE; // Allow sort
		$this->fields['h_site'] = &$this->h_site;

		// contact_fax
		$this->contact_fax = new cField('hotels', 'hotels', 'x_contact_fax', 'contact_fax', '`contact_fax`', '`contact_fax`', 200, -1, FALSE, '`contact_fax`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->contact_fax->Sortable = TRUE; // Allow sort
		$this->fields['contact_fax'] = &$this->contact_fax;

		// star_rating
		$this->star_rating = new cField('hotels', 'hotels', 'x_star_rating', 'star_rating', '`star_rating`', '`star_rating`', 200, -1, FALSE, '`star_rating`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->star_rating->Sortable = TRUE; // Allow sort
		$this->fields['star_rating'] = &$this->star_rating;

		// create_date
		$this->create_date = new cField('hotels', 'hotels', 'x_create_date', 'create_date', '`create_date`', ew_CastDateFieldForLike('`create_date`', 1, "DB"), 135, 1, FALSE, '`create_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->create_date->Sortable = TRUE; // Allow sort
		$this->create_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['create_date'] = &$this->create_date;

		// update_date
		$this->update_date = new cField('hotels', 'hotels', 'x_update_date', 'update_date', '`update_date`', ew_CastDateFieldForLike('`update_date`', 2, "DB"), 135, 2, FALSE, '`update_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->update_date->Sortable = TRUE; // Allow sort
		$this->update_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['update_date'] = &$this->update_date;

		// h_online_status
		$this->h_online_status = new cField('hotels', 'hotels', 'x_h_online_status', 'h_online_status', '`h_online_status`', '`h_online_status`', 202, -1, FALSE, '`h_online_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->h_online_status->Sortable = TRUE; // Allow sort
		$this->h_online_status->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->h_online_status->TrueValue = 'Y';
		$this->h_online_status->FalseValue = 'N';
		$this->h_online_status->OptionCount = 2;
		$this->fields['h_online_status'] = &$this->h_online_status;

		// hotel_blocked
		$this->hotel_blocked = new cField('hotels', 'hotels', 'x_hotel_blocked', 'hotel_blocked', '`hotel_blocked`', '`hotel_blocked`', 202, -1, FALSE, '`hotel_blocked`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->hotel_blocked->Sortable = TRUE; // Allow sort
		$this->hotel_blocked->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->hotel_blocked->TrueValue = 'Y';
		$this->hotel_blocked->FalseValue = 'N';
		$this->hotel_blocked->OptionCount = 2;
		$this->fields['hotel_blocked'] = &$this->hotel_blocked;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotels`";
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
			$this->hotel_id->setDbValue($conn->Insert_ID());
			$rs['hotel_id'] = $this->hotel_id->DbValue;
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
		return "`hotel_id` = @hotel_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "hotelslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotelslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotelsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotelsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotelsadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotelsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotelsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotelsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotelsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "hotel_id:" . ew_VarToJson($this->hotel_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->hotel_id->CurrentValue)) {
			$sUrl .= "hotel_id=" . urlencode($this->hotel_id->CurrentValue);
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
			if ($isPost && isset($_POST["hotel_id"]))
				$arKeys[] = ew_StripSlashes($_POST["hotel_id"]);
			elseif (isset($_GET["hotel_id"]))
				$arKeys[] = ew_StripSlashes($_GET["hotel_id"]);
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
			$this->hotel_id->CurrentValue = $key;
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
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->h_name->setDbValue($rs->fields('h_name'));
		$this->h_slug->setDbValue($rs->fields('h_slug'));
		$this->h_feature_image->Upload->DbValue = $rs->fields('h_feature_image');
		$this->h_description->setDbValue($rs->fields('h_description'));
		$this->h_meta_key->setDbValue($rs->fields('h_meta_key'));
		$this->h_deatail->setDbValue($rs->fields('h_deatail'));
		$this->h_facilities->setDbValue($rs->fields('h_facilities'));
		$this->h_address->setDbValue($rs->fields('h_address'));
		$this->h_create->setDbValue($rs->fields('h_create'));
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->province->setDbValue($rs->fields('province'));
		$this->whylike->setDbValue($rs->fields('whylike'));
		$this->lang_spoken->setDbValue($rs->fields('lang_spoken'));
		$this->map->setDbValue($rs->fields('map'));
		$this->what_todo->setDbValue($rs->fields('what_todo'));
		$this->h_id_cod->setDbValue($rs->fields('h_id_cod'));
		$this->h_email->setDbValue($rs->fields('h_email'));
		$this->h_contact_name->setDbValue($rs->fields('h_contact_name'));
		$this->h_pass->setDbValue($rs->fields('h_pass'));
		$this->h_contact_phone->setDbValue($rs->fields('h_contact_phone'));
		$this->h_site->setDbValue($rs->fields('h_site'));
		$this->contact_fax->setDbValue($rs->fields('contact_fax'));
		$this->star_rating->setDbValue($rs->fields('star_rating'));
		$this->create_date->setDbValue($rs->fields('create_date'));
		$this->update_date->setDbValue($rs->fields('update_date'));
		$this->h_online_status->setDbValue($rs->fields('h_online_status'));
		$this->hotel_blocked->setDbValue($rs->fields('hotel_blocked'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// hotel_id
		// h_name
		// h_slug
		// h_feature_image
		// h_description
		// h_meta_key
		// h_deatail
		// h_facilities
		// h_address
		// h_create
		// dest_id
		// province
		// whylike
		// lang_spoken
		// map
		// what_todo
		// h_id_cod
		// h_email
		// h_contact_name
		// h_pass
		// h_contact_phone
		// h_site
		// contact_fax
		// star_rating
		// create_date
		// update_date
		// h_online_status
		// hotel_blocked
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
		$this->h_feature_image->UploadPath = "../uploads/hotels";
		if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
			$this->h_feature_image->ImageAlt = $this->h_feature_image->FldAlt();
			$this->h_feature_image->ViewValue = $this->h_feature_image->Upload->DbValue;
		} else {
			$this->h_feature_image->ViewValue = "";
		}
		$this->h_feature_image->ViewCustomAttributes = "";

		// h_description
		$this->h_description->ViewValue = $this->h_description->CurrentValue;
		$this->h_description->ViewCustomAttributes = "";

		// h_meta_key
		$this->h_meta_key->ViewValue = $this->h_meta_key->CurrentValue;
		$this->h_meta_key->ViewCustomAttributes = "";

		// h_deatail
		$this->h_deatail->ViewValue = $this->h_deatail->CurrentValue;
		$this->h_deatail->ViewCustomAttributes = "";

		// h_facilities
		$this->h_facilities->ViewValue = $this->h_facilities->CurrentValue;
		$this->h_facilities->ViewCustomAttributes = "";

		// h_address
		$this->h_address->ViewValue = $this->h_address->CurrentValue;
		$this->h_address->ViewCustomAttributes = "";

		// h_create
		$this->h_create->ViewValue = $this->h_create->CurrentValue;
		$this->h_create->ViewValue = ew_FormatDateTime($this->h_create->ViewValue, 0);
		$this->h_create->ViewCustomAttributes = "";

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// province
		$this->province->ViewValue = $this->province->CurrentValue;
		$this->province->ViewCustomAttributes = "";

		// whylike
		$this->whylike->ViewValue = $this->whylike->CurrentValue;
		$this->whylike->ViewCustomAttributes = "";

		// lang_spoken
		$this->lang_spoken->ViewValue = $this->lang_spoken->CurrentValue;
		$this->lang_spoken->ViewCustomAttributes = "";

		// map
		$this->map->ViewValue = $this->map->CurrentValue;
		$this->map->ViewCustomAttributes = "";

		// what_todo
		$this->what_todo->ViewValue = $this->what_todo->CurrentValue;
		$this->what_todo->ViewCustomAttributes = "";

		// h_id_cod
		$this->h_id_cod->ViewValue = $this->h_id_cod->CurrentValue;
		$this->h_id_cod->ViewCustomAttributes = "";

		// h_email
		$this->h_email->ViewValue = $this->h_email->CurrentValue;
		$this->h_email->ViewCustomAttributes = "";

		// h_contact_name
		$this->h_contact_name->ViewValue = $this->h_contact_name->CurrentValue;
		$this->h_contact_name->ViewCustomAttributes = "";

		// h_pass
		$this->h_pass->ViewValue = $this->h_pass->CurrentValue;
		$this->h_pass->ViewCustomAttributes = "";

		// h_contact_phone
		$this->h_contact_phone->ViewValue = $this->h_contact_phone->CurrentValue;
		$this->h_contact_phone->ViewCustomAttributes = "";

		// h_site
		$this->h_site->ViewValue = $this->h_site->CurrentValue;
		$this->h_site->ViewCustomAttributes = "";

		// contact_fax
		$this->contact_fax->ViewValue = $this->contact_fax->CurrentValue;
		$this->contact_fax->ViewCustomAttributes = "";

		// star_rating
		$this->star_rating->ViewValue = $this->star_rating->CurrentValue;
		$this->star_rating->ViewCustomAttributes = "";

		// create_date
		$this->create_date->ViewValue = $this->create_date->CurrentValue;
		$this->create_date->ViewValue = ew_FormatDateTime($this->create_date->ViewValue, 1);
		$this->create_date->ViewCustomAttributes = "";

		// update_date
		$this->update_date->ViewValue = $this->update_date->CurrentValue;
		$this->update_date->ViewValue = ew_FormatDateTime($this->update_date->ViewValue, 2);
		$this->update_date->ViewCustomAttributes = "";

		// h_online_status
		if (ew_ConvertToBool($this->h_online_status->CurrentValue)) {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(1) <> "" ? $this->h_online_status->FldTagCaption(1) : "Yes";
		} else {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(2) <> "" ? $this->h_online_status->FldTagCaption(2) : "No";
		}
		$this->h_online_status->ViewCustomAttributes = "";

		// hotel_blocked
		if (ew_ConvertToBool($this->hotel_blocked->CurrentValue)) {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(1) <> "" ? $this->hotel_blocked->FldTagCaption(1) : "Yes";
		} else {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(2) <> "" ? $this->hotel_blocked->FldTagCaption(2) : "No";
		}
		$this->hotel_blocked->ViewCustomAttributes = "";

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
		$this->h_feature_image->UploadPath = "../uploads/hotels";
		if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
			$this->h_feature_image->HrefValue = ew_GetFileUploadUrl($this->h_feature_image, $this->h_feature_image->Upload->DbValue); // Add prefix/suffix
			$this->h_feature_image->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->h_feature_image->HrefValue = ew_ConvertFullUrl($this->h_feature_image->HrefValue);
		} else {
			$this->h_feature_image->HrefValue = "";
		}
		$this->h_feature_image->HrefValue2 = $this->h_feature_image->UploadPath . $this->h_feature_image->Upload->DbValue;
		$this->h_feature_image->TooltipValue = "";
		if ($this->h_feature_image->UseColorbox) {
			if (ew_Empty($this->h_feature_image->TooltipValue))
				$this->h_feature_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->h_feature_image->LinkAttrs["data-rel"] = "hotels_x_h_feature_image";
			ew_AppendClass($this->h_feature_image->LinkAttrs["class"], "ewLightbox");
		}

		// h_description
		$this->h_description->LinkCustomAttributes = "";
		$this->h_description->HrefValue = "";
		$this->h_description->TooltipValue = "";

		// h_meta_key
		$this->h_meta_key->LinkCustomAttributes = "";
		$this->h_meta_key->HrefValue = "";
		$this->h_meta_key->TooltipValue = "";

		// h_deatail
		$this->h_deatail->LinkCustomAttributes = "";
		$this->h_deatail->HrefValue = "";
		$this->h_deatail->TooltipValue = "";

		// h_facilities
		$this->h_facilities->LinkCustomAttributes = "";
		$this->h_facilities->HrefValue = "";
		$this->h_facilities->TooltipValue = "";

		// h_address
		$this->h_address->LinkCustomAttributes = "";
		$this->h_address->HrefValue = "";
		$this->h_address->TooltipValue = "";

		// h_create
		$this->h_create->LinkCustomAttributes = "";
		$this->h_create->HrefValue = "";
		$this->h_create->TooltipValue = "";

		// dest_id
		$this->dest_id->LinkCustomAttributes = "";
		$this->dest_id->HrefValue = "";
		$this->dest_id->TooltipValue = "";

		// province
		$this->province->LinkCustomAttributes = "";
		$this->province->HrefValue = "";
		$this->province->TooltipValue = "";

		// whylike
		$this->whylike->LinkCustomAttributes = "";
		$this->whylike->HrefValue = "";
		$this->whylike->TooltipValue = "";

		// lang_spoken
		$this->lang_spoken->LinkCustomAttributes = "";
		$this->lang_spoken->HrefValue = "";
		$this->lang_spoken->TooltipValue = "";

		// map
		$this->map->LinkCustomAttributes = "";
		$this->map->HrefValue = "";
		$this->map->TooltipValue = "";

		// what_todo
		$this->what_todo->LinkCustomAttributes = "";
		$this->what_todo->HrefValue = "";
		$this->what_todo->TooltipValue = "";

		// h_id_cod
		$this->h_id_cod->LinkCustomAttributes = "";
		$this->h_id_cod->HrefValue = "";
		$this->h_id_cod->TooltipValue = "";

		// h_email
		$this->h_email->LinkCustomAttributes = "";
		$this->h_email->HrefValue = "";
		$this->h_email->TooltipValue = "";

		// h_contact_name
		$this->h_contact_name->LinkCustomAttributes = "";
		$this->h_contact_name->HrefValue = "";
		$this->h_contact_name->TooltipValue = "";

		// h_pass
		$this->h_pass->LinkCustomAttributes = "";
		$this->h_pass->HrefValue = "";
		$this->h_pass->TooltipValue = "";

		// h_contact_phone
		$this->h_contact_phone->LinkCustomAttributes = "";
		$this->h_contact_phone->HrefValue = "";
		$this->h_contact_phone->TooltipValue = "";

		// h_site
		$this->h_site->LinkCustomAttributes = "";
		$this->h_site->HrefValue = "";
		$this->h_site->TooltipValue = "";

		// contact_fax
		$this->contact_fax->LinkCustomAttributes = "";
		$this->contact_fax->HrefValue = "";
		$this->contact_fax->TooltipValue = "";

		// star_rating
		$this->star_rating->LinkCustomAttributes = "";
		$this->star_rating->HrefValue = "";
		$this->star_rating->TooltipValue = "";

		// create_date
		$this->create_date->LinkCustomAttributes = "";
		$this->create_date->HrefValue = "";
		$this->create_date->TooltipValue = "";

		// update_date
		$this->update_date->LinkCustomAttributes = "";
		$this->update_date->HrefValue = "";
		$this->update_date->TooltipValue = "";

		// h_online_status
		$this->h_online_status->LinkCustomAttributes = "";
		$this->h_online_status->HrefValue = "";
		$this->h_online_status->TooltipValue = "";

		// hotel_blocked
		$this->hotel_blocked->LinkCustomAttributes = "";
		$this->hotel_blocked->HrefValue = "";
		$this->hotel_blocked->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

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
		$this->h_feature_image->UploadPath = "../uploads/hotels";
		if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
			$this->h_feature_image->ImageAlt = $this->h_feature_image->FldAlt();
			$this->h_feature_image->EditValue = $this->h_feature_image->Upload->DbValue;
		} else {
			$this->h_feature_image->EditValue = "";
		}
		if (!ew_Empty($this->h_feature_image->CurrentValue))
			$this->h_feature_image->Upload->FileName = $this->h_feature_image->CurrentValue;

		// h_description
		$this->h_description->EditAttrs["class"] = "form-control";
		$this->h_description->EditCustomAttributes = "";
		$this->h_description->EditValue = $this->h_description->CurrentValue;
		$this->h_description->PlaceHolder = ew_RemoveHtml($this->h_description->FldCaption());

		// h_meta_key
		$this->h_meta_key->EditAttrs["class"] = "form-control";
		$this->h_meta_key->EditCustomAttributes = "";
		$this->h_meta_key->EditValue = $this->h_meta_key->CurrentValue;
		$this->h_meta_key->PlaceHolder = ew_RemoveHtml($this->h_meta_key->FldCaption());

		// h_deatail
		$this->h_deatail->EditAttrs["class"] = "form-control";
		$this->h_deatail->EditCustomAttributes = "";
		$this->h_deatail->EditValue = $this->h_deatail->CurrentValue;
		$this->h_deatail->PlaceHolder = ew_RemoveHtml($this->h_deatail->FldCaption());

		// h_facilities
		$this->h_facilities->EditAttrs["class"] = "form-control";
		$this->h_facilities->EditCustomAttributes = "";
		$this->h_facilities->EditValue = $this->h_facilities->CurrentValue;
		$this->h_facilities->PlaceHolder = ew_RemoveHtml($this->h_facilities->FldCaption());

		// h_address
		$this->h_address->EditAttrs["class"] = "form-control";
		$this->h_address->EditCustomAttributes = "";
		$this->h_address->EditValue = $this->h_address->CurrentValue;
		$this->h_address->PlaceHolder = ew_RemoveHtml($this->h_address->FldCaption());

		// h_create
		$this->h_create->EditAttrs["class"] = "form-control";
		$this->h_create->EditCustomAttributes = "";
		$this->h_create->EditValue = ew_FormatDateTime($this->h_create->CurrentValue, 8);
		$this->h_create->PlaceHolder = ew_RemoveHtml($this->h_create->FldCaption());

		// dest_id
		$this->dest_id->EditAttrs["class"] = "form-control";
		$this->dest_id->EditCustomAttributes = "";
		$this->dest_id->EditValue = $this->dest_id->CurrentValue;
		$this->dest_id->PlaceHolder = ew_RemoveHtml($this->dest_id->FldCaption());

		// province
		$this->province->EditAttrs["class"] = "form-control";
		$this->province->EditCustomAttributes = "";
		$this->province->EditValue = $this->province->CurrentValue;
		$this->province->PlaceHolder = ew_RemoveHtml($this->province->FldCaption());

		// whylike
		$this->whylike->EditAttrs["class"] = "form-control";
		$this->whylike->EditCustomAttributes = "";
		$this->whylike->EditValue = $this->whylike->CurrentValue;
		$this->whylike->PlaceHolder = ew_RemoveHtml($this->whylike->FldCaption());

		// lang_spoken
		$this->lang_spoken->EditAttrs["class"] = "form-control";
		$this->lang_spoken->EditCustomAttributes = "";
		$this->lang_spoken->EditValue = $this->lang_spoken->CurrentValue;
		$this->lang_spoken->PlaceHolder = ew_RemoveHtml($this->lang_spoken->FldCaption());

		// map
		$this->map->EditAttrs["class"] = "form-control";
		$this->map->EditCustomAttributes = "";
		$this->map->EditValue = $this->map->CurrentValue;
		$this->map->PlaceHolder = ew_RemoveHtml($this->map->FldCaption());

		// what_todo
		$this->what_todo->EditAttrs["class"] = "form-control";
		$this->what_todo->EditCustomAttributes = "";
		$this->what_todo->EditValue = $this->what_todo->CurrentValue;
		$this->what_todo->PlaceHolder = ew_RemoveHtml($this->what_todo->FldCaption());

		// h_id_cod
		$this->h_id_cod->EditAttrs["class"] = "form-control";
		$this->h_id_cod->EditCustomAttributes = "";
		$this->h_id_cod->EditValue = $this->h_id_cod->CurrentValue;
		$this->h_id_cod->PlaceHolder = ew_RemoveHtml($this->h_id_cod->FldCaption());

		// h_email
		$this->h_email->EditAttrs["class"] = "form-control";
		$this->h_email->EditCustomAttributes = "";
		$this->h_email->EditValue = $this->h_email->CurrentValue;
		$this->h_email->PlaceHolder = ew_RemoveHtml($this->h_email->FldCaption());

		// h_contact_name
		$this->h_contact_name->EditAttrs["class"] = "form-control";
		$this->h_contact_name->EditCustomAttributes = "";
		$this->h_contact_name->EditValue = $this->h_contact_name->CurrentValue;
		$this->h_contact_name->PlaceHolder = ew_RemoveHtml($this->h_contact_name->FldCaption());

		// h_pass
		$this->h_pass->EditAttrs["class"] = "form-control";
		$this->h_pass->EditCustomAttributes = "";
		$this->h_pass->EditValue = $this->h_pass->CurrentValue;
		$this->h_pass->PlaceHolder = ew_RemoveHtml($this->h_pass->FldCaption());

		// h_contact_phone
		$this->h_contact_phone->EditAttrs["class"] = "form-control";
		$this->h_contact_phone->EditCustomAttributes = "";
		$this->h_contact_phone->EditValue = $this->h_contact_phone->CurrentValue;
		$this->h_contact_phone->PlaceHolder = ew_RemoveHtml($this->h_contact_phone->FldCaption());

		// h_site
		$this->h_site->EditAttrs["class"] = "form-control";
		$this->h_site->EditCustomAttributes = "";
		$this->h_site->EditValue = $this->h_site->CurrentValue;
		$this->h_site->PlaceHolder = ew_RemoveHtml($this->h_site->FldCaption());

		// contact_fax
		$this->contact_fax->EditAttrs["class"] = "form-control";
		$this->contact_fax->EditCustomAttributes = "";
		$this->contact_fax->EditValue = $this->contact_fax->CurrentValue;
		$this->contact_fax->PlaceHolder = ew_RemoveHtml($this->contact_fax->FldCaption());

		// star_rating
		$this->star_rating->EditAttrs["class"] = "form-control";
		$this->star_rating->EditCustomAttributes = "";
		$this->star_rating->EditValue = $this->star_rating->CurrentValue;
		$this->star_rating->PlaceHolder = ew_RemoveHtml($this->star_rating->FldCaption());

		// create_date
		$this->create_date->EditAttrs["class"] = "form-control";
		$this->create_date->EditCustomAttributes = "";
		$this->create_date->EditValue = ew_FormatDateTime($this->create_date->CurrentValue, 8);
		$this->create_date->PlaceHolder = ew_RemoveHtml($this->create_date->FldCaption());

		// update_date
		$this->update_date->EditAttrs["class"] = "form-control";
		$this->update_date->EditCustomAttributes = "";
		$this->update_date->EditValue = ew_FormatDateTime($this->update_date->CurrentValue, 2);
		$this->update_date->PlaceHolder = ew_RemoveHtml($this->update_date->FldCaption());

		// h_online_status
		$this->h_online_status->EditCustomAttributes = "";
		$this->h_online_status->EditValue = $this->h_online_status->Options(FALSE);

		// hotel_blocked
		$this->hotel_blocked->EditCustomAttributes = "";
		$this->hotel_blocked->EditValue = $this->hotel_blocked->Options(FALSE);

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
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->h_name->Exportable) $Doc->ExportCaption($this->h_name);
					if ($this->h_slug->Exportable) $Doc->ExportCaption($this->h_slug);
					if ($this->h_feature_image->Exportable) $Doc->ExportCaption($this->h_feature_image);
					if ($this->h_description->Exportable) $Doc->ExportCaption($this->h_description);
					if ($this->h_meta_key->Exportable) $Doc->ExportCaption($this->h_meta_key);
					if ($this->h_deatail->Exportable) $Doc->ExportCaption($this->h_deatail);
					if ($this->h_facilities->Exportable) $Doc->ExportCaption($this->h_facilities);
					if ($this->h_address->Exportable) $Doc->ExportCaption($this->h_address);
					if ($this->h_create->Exportable) $Doc->ExportCaption($this->h_create);
					if ($this->dest_id->Exportable) $Doc->ExportCaption($this->dest_id);
					if ($this->province->Exportable) $Doc->ExportCaption($this->province);
					if ($this->whylike->Exportable) $Doc->ExportCaption($this->whylike);
					if ($this->lang_spoken->Exportable) $Doc->ExportCaption($this->lang_spoken);
					if ($this->map->Exportable) $Doc->ExportCaption($this->map);
					if ($this->what_todo->Exportable) $Doc->ExportCaption($this->what_todo);
					if ($this->h_id_cod->Exportable) $Doc->ExportCaption($this->h_id_cod);
					if ($this->h_email->Exportable) $Doc->ExportCaption($this->h_email);
					if ($this->h_contact_name->Exportable) $Doc->ExportCaption($this->h_contact_name);
					if ($this->h_pass->Exportable) $Doc->ExportCaption($this->h_pass);
					if ($this->h_contact_phone->Exportable) $Doc->ExportCaption($this->h_contact_phone);
					if ($this->h_site->Exportable) $Doc->ExportCaption($this->h_site);
					if ($this->contact_fax->Exportable) $Doc->ExportCaption($this->contact_fax);
					if ($this->star_rating->Exportable) $Doc->ExportCaption($this->star_rating);
					if ($this->create_date->Exportable) $Doc->ExportCaption($this->create_date);
					if ($this->update_date->Exportable) $Doc->ExportCaption($this->update_date);
					if ($this->h_online_status->Exportable) $Doc->ExportCaption($this->h_online_status);
					if ($this->hotel_blocked->Exportable) $Doc->ExportCaption($this->hotel_blocked);
				} else {
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->h_name->Exportable) $Doc->ExportCaption($this->h_name);
					if ($this->h_slug->Exportable) $Doc->ExportCaption($this->h_slug);
					if ($this->h_feature_image->Exportable) $Doc->ExportCaption($this->h_feature_image);
					if ($this->h_address->Exportable) $Doc->ExportCaption($this->h_address);
					if ($this->h_create->Exportable) $Doc->ExportCaption($this->h_create);
					if ($this->dest_id->Exportable) $Doc->ExportCaption($this->dest_id);
					if ($this->province->Exportable) $Doc->ExportCaption($this->province);
					if ($this->h_id_cod->Exportable) $Doc->ExportCaption($this->h_id_cod);
					if ($this->h_email->Exportable) $Doc->ExportCaption($this->h_email);
					if ($this->h_contact_name->Exportable) $Doc->ExportCaption($this->h_contact_name);
					if ($this->h_pass->Exportable) $Doc->ExportCaption($this->h_pass);
					if ($this->h_contact_phone->Exportable) $Doc->ExportCaption($this->h_contact_phone);
					if ($this->h_site->Exportable) $Doc->ExportCaption($this->h_site);
					if ($this->contact_fax->Exportable) $Doc->ExportCaption($this->contact_fax);
					if ($this->star_rating->Exportable) $Doc->ExportCaption($this->star_rating);
					if ($this->create_date->Exportable) $Doc->ExportCaption($this->create_date);
					if ($this->update_date->Exportable) $Doc->ExportCaption($this->update_date);
					if ($this->h_online_status->Exportable) $Doc->ExportCaption($this->h_online_status);
					if ($this->hotel_blocked->Exportable) $Doc->ExportCaption($this->hotel_blocked);
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
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->h_name->Exportable) $Doc->ExportField($this->h_name);
						if ($this->h_slug->Exportable) $Doc->ExportField($this->h_slug);
						if ($this->h_feature_image->Exportable) $Doc->ExportField($this->h_feature_image);
						if ($this->h_description->Exportable) $Doc->ExportField($this->h_description);
						if ($this->h_meta_key->Exportable) $Doc->ExportField($this->h_meta_key);
						if ($this->h_deatail->Exportable) $Doc->ExportField($this->h_deatail);
						if ($this->h_facilities->Exportable) $Doc->ExportField($this->h_facilities);
						if ($this->h_address->Exportable) $Doc->ExportField($this->h_address);
						if ($this->h_create->Exportable) $Doc->ExportField($this->h_create);
						if ($this->dest_id->Exportable) $Doc->ExportField($this->dest_id);
						if ($this->province->Exportable) $Doc->ExportField($this->province);
						if ($this->whylike->Exportable) $Doc->ExportField($this->whylike);
						if ($this->lang_spoken->Exportable) $Doc->ExportField($this->lang_spoken);
						if ($this->map->Exportable) $Doc->ExportField($this->map);
						if ($this->what_todo->Exportable) $Doc->ExportField($this->what_todo);
						if ($this->h_id_cod->Exportable) $Doc->ExportField($this->h_id_cod);
						if ($this->h_email->Exportable) $Doc->ExportField($this->h_email);
						if ($this->h_contact_name->Exportable) $Doc->ExportField($this->h_contact_name);
						if ($this->h_pass->Exportable) $Doc->ExportField($this->h_pass);
						if ($this->h_contact_phone->Exportable) $Doc->ExportField($this->h_contact_phone);
						if ($this->h_site->Exportable) $Doc->ExportField($this->h_site);
						if ($this->contact_fax->Exportable) $Doc->ExportField($this->contact_fax);
						if ($this->star_rating->Exportable) $Doc->ExportField($this->star_rating);
						if ($this->create_date->Exportable) $Doc->ExportField($this->create_date);
						if ($this->update_date->Exportable) $Doc->ExportField($this->update_date);
						if ($this->h_online_status->Exportable) $Doc->ExportField($this->h_online_status);
						if ($this->hotel_blocked->Exportable) $Doc->ExportField($this->hotel_blocked);
					} else {
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->h_name->Exportable) $Doc->ExportField($this->h_name);
						if ($this->h_slug->Exportable) $Doc->ExportField($this->h_slug);
						if ($this->h_feature_image->Exportable) $Doc->ExportField($this->h_feature_image);
						if ($this->h_address->Exportable) $Doc->ExportField($this->h_address);
						if ($this->h_create->Exportable) $Doc->ExportField($this->h_create);
						if ($this->dest_id->Exportable) $Doc->ExportField($this->dest_id);
						if ($this->province->Exportable) $Doc->ExportField($this->province);
						if ($this->h_id_cod->Exportable) $Doc->ExportField($this->h_id_cod);
						if ($this->h_email->Exportable) $Doc->ExportField($this->h_email);
						if ($this->h_contact_name->Exportable) $Doc->ExportField($this->h_contact_name);
						if ($this->h_pass->Exportable) $Doc->ExportField($this->h_pass);
						if ($this->h_contact_phone->Exportable) $Doc->ExportField($this->h_contact_phone);
						if ($this->h_site->Exportable) $Doc->ExportField($this->h_site);
						if ($this->contact_fax->Exportable) $Doc->ExportField($this->contact_fax);
						if ($this->star_rating->Exportable) $Doc->ExportField($this->star_rating);
						if ($this->create_date->Exportable) $Doc->ExportField($this->create_date);
						if ($this->update_date->Exportable) $Doc->ExportField($this->update_date);
						if ($this->h_online_status->Exportable) $Doc->ExportField($this->h_online_status);
						if ($this->hotel_blocked->Exportable) $Doc->ExportField($this->hotel_blocked);
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

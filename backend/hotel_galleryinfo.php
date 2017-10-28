<?php

// Global variable for table object
$hotel_gallery = NULL;

//
// Table class for hotel_gallery
//
class chotel_gallery extends cTable {
	var $hgallery_id;
	var $hotel_id;
	var $hg_img1;
	var $hg_img2;
	var $hg_img3;
	var $hg_img4;
	var $hg_img5;
	var $hg_img6;
	var $hg_img7;
	var $hg_img8;
	var $hg_img9;
	var $hg_img10;
	var $hg_img11;
	var $hg_img12;
	var $hg_img13;
	var $hg_img14;
	var $hg_img15;
	var $hg_img16;
	var $hg_img17;
	var $hg_img18;
	var $hg_img19;
	var $hg_img20;
	var $hg_img21;
	var $hg_img22;
	var $hg_img23;
	var $hg_img24;
	var $last_update;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'hotel_gallery';
		$this->TableName = 'hotel_gallery';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`hotel_gallery`";
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

		// hgallery_id
		$this->hgallery_id = new cField('hotel_gallery', 'hotel_gallery', 'x_hgallery_id', 'hgallery_id', '`hgallery_id`', '`hgallery_id`', 20, -1, FALSE, '`hgallery_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->hgallery_id->Sortable = TRUE; // Allow sort
		$this->hgallery_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hgallery_id'] = &$this->hgallery_id;

		// hotel_id
		$this->hotel_id = new cField('hotel_gallery', 'hotel_gallery', 'x_hotel_id', 'hotel_id', '`hotel_id`', '`hotel_id`', 20, -1, FALSE, '`hotel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hotel_id->Sortable = TRUE; // Allow sort
		$this->hotel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['hotel_id'] = &$this->hotel_id;

		// hg_img1
		$this->hg_img1 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img1', 'hg_img1', '`hg_img1`', '`hg_img1`', 200, -1, FALSE, '`hg_img1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img1->Sortable = TRUE; // Allow sort
		$this->fields['hg_img1'] = &$this->hg_img1;

		// hg_img2
		$this->hg_img2 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img2', 'hg_img2', '`hg_img2`', '`hg_img2`', 200, -1, FALSE, '`hg_img2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img2->Sortable = TRUE; // Allow sort
		$this->fields['hg_img2'] = &$this->hg_img2;

		// hg_img3
		$this->hg_img3 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img3', 'hg_img3', '`hg_img3`', '`hg_img3`', 200, -1, FALSE, '`hg_img3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img3->Sortable = TRUE; // Allow sort
		$this->fields['hg_img3'] = &$this->hg_img3;

		// hg_img4
		$this->hg_img4 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img4', 'hg_img4', '`hg_img4`', '`hg_img4`', 200, -1, FALSE, '`hg_img4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img4->Sortable = TRUE; // Allow sort
		$this->fields['hg_img4'] = &$this->hg_img4;

		// hg_img5
		$this->hg_img5 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img5', 'hg_img5', '`hg_img5`', '`hg_img5`', 200, -1, FALSE, '`hg_img5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img5->Sortable = TRUE; // Allow sort
		$this->fields['hg_img5'] = &$this->hg_img5;

		// hg_img6
		$this->hg_img6 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img6', 'hg_img6', '`hg_img6`', '`hg_img6`', 200, -1, FALSE, '`hg_img6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img6->Sortable = TRUE; // Allow sort
		$this->fields['hg_img6'] = &$this->hg_img6;

		// hg_img7
		$this->hg_img7 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img7', 'hg_img7', '`hg_img7`', '`hg_img7`', 200, -1, FALSE, '`hg_img7`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img7->Sortable = TRUE; // Allow sort
		$this->fields['hg_img7'] = &$this->hg_img7;

		// hg_img8
		$this->hg_img8 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img8', 'hg_img8', '`hg_img8`', '`hg_img8`', 200, -1, FALSE, '`hg_img8`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img8->Sortable = TRUE; // Allow sort
		$this->fields['hg_img8'] = &$this->hg_img8;

		// hg_img9
		$this->hg_img9 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img9', 'hg_img9', '`hg_img9`', '`hg_img9`', 200, -1, FALSE, '`hg_img9`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img9->Sortable = TRUE; // Allow sort
		$this->fields['hg_img9'] = &$this->hg_img9;

		// hg_img10
		$this->hg_img10 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img10', 'hg_img10', '`hg_img10`', '`hg_img10`', 200, -1, FALSE, '`hg_img10`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img10->Sortable = TRUE; // Allow sort
		$this->fields['hg_img10'] = &$this->hg_img10;

		// hg_img11
		$this->hg_img11 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img11', 'hg_img11', '`hg_img11`', '`hg_img11`', 200, -1, FALSE, '`hg_img11`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img11->Sortable = TRUE; // Allow sort
		$this->fields['hg_img11'] = &$this->hg_img11;

		// hg_img12
		$this->hg_img12 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img12', 'hg_img12', '`hg_img12`', '`hg_img12`', 200, -1, FALSE, '`hg_img12`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img12->Sortable = TRUE; // Allow sort
		$this->fields['hg_img12'] = &$this->hg_img12;

		// hg_img13
		$this->hg_img13 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img13', 'hg_img13', '`hg_img13`', '`hg_img13`', 200, -1, FALSE, '`hg_img13`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img13->Sortable = TRUE; // Allow sort
		$this->fields['hg_img13'] = &$this->hg_img13;

		// hg_img14
		$this->hg_img14 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img14', 'hg_img14', '`hg_img14`', '`hg_img14`', 200, -1, FALSE, '`hg_img14`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img14->Sortable = TRUE; // Allow sort
		$this->fields['hg_img14'] = &$this->hg_img14;

		// hg_img15
		$this->hg_img15 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img15', 'hg_img15', '`hg_img15`', '`hg_img15`', 200, -1, FALSE, '`hg_img15`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img15->Sortable = TRUE; // Allow sort
		$this->fields['hg_img15'] = &$this->hg_img15;

		// hg_img16
		$this->hg_img16 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img16', 'hg_img16', '`hg_img16`', '`hg_img16`', 200, -1, FALSE, '`hg_img16`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img16->Sortable = TRUE; // Allow sort
		$this->fields['hg_img16'] = &$this->hg_img16;

		// hg_img17
		$this->hg_img17 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img17', 'hg_img17', '`hg_img17`', '`hg_img17`', 200, -1, FALSE, '`hg_img17`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img17->Sortable = TRUE; // Allow sort
		$this->fields['hg_img17'] = &$this->hg_img17;

		// hg_img18
		$this->hg_img18 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img18', 'hg_img18', '`hg_img18`', '`hg_img18`', 200, -1, FALSE, '`hg_img18`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img18->Sortable = TRUE; // Allow sort
		$this->fields['hg_img18'] = &$this->hg_img18;

		// hg_img19
		$this->hg_img19 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img19', 'hg_img19', '`hg_img19`', '`hg_img19`', 200, -1, FALSE, '`hg_img19`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img19->Sortable = TRUE; // Allow sort
		$this->fields['hg_img19'] = &$this->hg_img19;

		// hg_img20
		$this->hg_img20 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img20', 'hg_img20', '`hg_img20`', '`hg_img20`', 200, -1, FALSE, '`hg_img20`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img20->Sortable = TRUE; // Allow sort
		$this->fields['hg_img20'] = &$this->hg_img20;

		// hg_img21
		$this->hg_img21 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img21', 'hg_img21', '`hg_img21`', '`hg_img21`', 200, -1, FALSE, '`hg_img21`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img21->Sortable = TRUE; // Allow sort
		$this->fields['hg_img21'] = &$this->hg_img21;

		// hg_img22
		$this->hg_img22 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img22', 'hg_img22', '`hg_img22`', '`hg_img22`', 200, -1, FALSE, '`hg_img22`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img22->Sortable = TRUE; // Allow sort
		$this->fields['hg_img22'] = &$this->hg_img22;

		// hg_img23
		$this->hg_img23 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img23', 'hg_img23', '`hg_img23`', '`hg_img23`', 200, -1, FALSE, '`hg_img23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img23->Sortable = TRUE; // Allow sort
		$this->fields['hg_img23'] = &$this->hg_img23;

		// hg_img24
		$this->hg_img24 = new cField('hotel_gallery', 'hotel_gallery', 'x_hg_img24', 'hg_img24', '`hg_img24`', '`hg_img24`', 200, -1, FALSE, '`hg_img24`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->hg_img24->Sortable = TRUE; // Allow sort
		$this->fields['hg_img24'] = &$this->hg_img24;

		// last_update
		$this->last_update = new cField('hotel_gallery', 'hotel_gallery', 'x_last_update', 'last_update', '`last_update`', ew_CastDateFieldForLike('`last_update`', 0, "DB"), 135, 0, FALSE, '`last_update`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update->Sortable = TRUE; // Allow sort
		$this->last_update->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update'] = &$this->last_update;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`hotel_gallery`";
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
			$this->hgallery_id->setDbValue($conn->Insert_ID());
			$rs['hgallery_id'] = $this->hgallery_id->DbValue;
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
			if (array_key_exists('hgallery_id', $rs))
				ew_AddFilter($where, ew_QuotedName('hgallery_id', $this->DBID) . '=' . ew_QuotedValue($rs['hgallery_id'], $this->hgallery_id->FldDataType, $this->DBID));
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
		return "`hgallery_id` = @hgallery_id@ AND `hotel_id` = @hotel_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->hgallery_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@hgallery_id@", ew_AdjustSql($this->hgallery_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "hotel_gallerylist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "hotel_gallerylist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("hotel_galleryview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("hotel_galleryview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "hotel_galleryadd.php?" . $this->UrlParm($parm);
		else
			$url = "hotel_galleryadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("hotel_galleryedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("hotel_galleryadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("hotel_gallerydelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "hgallery_id:" . ew_VarToJson($this->hgallery_id->CurrentValue, "number", "'");
		$json .= ",hotel_id:" . ew_VarToJson($this->hotel_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->hgallery_id->CurrentValue)) {
			$sUrl .= "hgallery_id=" . urlencode($this->hgallery_id->CurrentValue);
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
			if ($isPost && isset($_POST["hgallery_id"]))
				$arKey[] = ew_StripSlashes($_POST["hgallery_id"]);
			elseif (isset($_GET["hgallery_id"]))
				$arKey[] = ew_StripSlashes($_GET["hgallery_id"]);
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
				if (!is_numeric($key[0])) // hgallery_id
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
			$this->hgallery_id->CurrentValue = $key[0];
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
		$this->hgallery_id->setDbValue($rs->fields('hgallery_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->hg_img1->setDbValue($rs->fields('hg_img1'));
		$this->hg_img2->setDbValue($rs->fields('hg_img2'));
		$this->hg_img3->setDbValue($rs->fields('hg_img3'));
		$this->hg_img4->setDbValue($rs->fields('hg_img4'));
		$this->hg_img5->setDbValue($rs->fields('hg_img5'));
		$this->hg_img6->setDbValue($rs->fields('hg_img6'));
		$this->hg_img7->setDbValue($rs->fields('hg_img7'));
		$this->hg_img8->setDbValue($rs->fields('hg_img8'));
		$this->hg_img9->setDbValue($rs->fields('hg_img9'));
		$this->hg_img10->setDbValue($rs->fields('hg_img10'));
		$this->hg_img11->setDbValue($rs->fields('hg_img11'));
		$this->hg_img12->setDbValue($rs->fields('hg_img12'));
		$this->hg_img13->setDbValue($rs->fields('hg_img13'));
		$this->hg_img14->setDbValue($rs->fields('hg_img14'));
		$this->hg_img15->setDbValue($rs->fields('hg_img15'));
		$this->hg_img16->setDbValue($rs->fields('hg_img16'));
		$this->hg_img17->setDbValue($rs->fields('hg_img17'));
		$this->hg_img18->setDbValue($rs->fields('hg_img18'));
		$this->hg_img19->setDbValue($rs->fields('hg_img19'));
		$this->hg_img20->setDbValue($rs->fields('hg_img20'));
		$this->hg_img21->setDbValue($rs->fields('hg_img21'));
		$this->hg_img22->setDbValue($rs->fields('hg_img22'));
		$this->hg_img23->setDbValue($rs->fields('hg_img23'));
		$this->hg_img24->setDbValue($rs->fields('hg_img24'));
		$this->last_update->setDbValue($rs->fields('last_update'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// hgallery_id
		// hotel_id
		// hg_img1
		// hg_img2
		// hg_img3
		// hg_img4
		// hg_img5
		// hg_img6
		// hg_img7
		// hg_img8
		// hg_img9
		// hg_img10
		// hg_img11
		// hg_img12
		// hg_img13
		// hg_img14
		// hg_img15
		// hg_img16
		// hg_img17
		// hg_img18
		// hg_img19
		// hg_img20
		// hg_img21
		// hg_img22
		// hg_img23
		// hg_img24
		// last_update
		// hgallery_id

		$this->hgallery_id->ViewValue = $this->hgallery_id->CurrentValue;
		$this->hgallery_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hg_img1
		$this->hg_img1->ViewValue = $this->hg_img1->CurrentValue;
		$this->hg_img1->ViewCustomAttributes = "";

		// hg_img2
		$this->hg_img2->ViewValue = $this->hg_img2->CurrentValue;
		$this->hg_img2->ViewCustomAttributes = "";

		// hg_img3
		$this->hg_img3->ViewValue = $this->hg_img3->CurrentValue;
		$this->hg_img3->ViewCustomAttributes = "";

		// hg_img4
		$this->hg_img4->ViewValue = $this->hg_img4->CurrentValue;
		$this->hg_img4->ViewCustomAttributes = "";

		// hg_img5
		$this->hg_img5->ViewValue = $this->hg_img5->CurrentValue;
		$this->hg_img5->ViewCustomAttributes = "";

		// hg_img6
		$this->hg_img6->ViewValue = $this->hg_img6->CurrentValue;
		$this->hg_img6->ViewCustomAttributes = "";

		// hg_img7
		$this->hg_img7->ViewValue = $this->hg_img7->CurrentValue;
		$this->hg_img7->ViewCustomAttributes = "";

		// hg_img8
		$this->hg_img8->ViewValue = $this->hg_img8->CurrentValue;
		$this->hg_img8->ViewCustomAttributes = "";

		// hg_img9
		$this->hg_img9->ViewValue = $this->hg_img9->CurrentValue;
		$this->hg_img9->ViewCustomAttributes = "";

		// hg_img10
		$this->hg_img10->ViewValue = $this->hg_img10->CurrentValue;
		$this->hg_img10->ViewCustomAttributes = "";

		// hg_img11
		$this->hg_img11->ViewValue = $this->hg_img11->CurrentValue;
		$this->hg_img11->ViewCustomAttributes = "";

		// hg_img12
		$this->hg_img12->ViewValue = $this->hg_img12->CurrentValue;
		$this->hg_img12->ViewCustomAttributes = "";

		// hg_img13
		$this->hg_img13->ViewValue = $this->hg_img13->CurrentValue;
		$this->hg_img13->ViewCustomAttributes = "";

		// hg_img14
		$this->hg_img14->ViewValue = $this->hg_img14->CurrentValue;
		$this->hg_img14->ViewCustomAttributes = "";

		// hg_img15
		$this->hg_img15->ViewValue = $this->hg_img15->CurrentValue;
		$this->hg_img15->ViewCustomAttributes = "";

		// hg_img16
		$this->hg_img16->ViewValue = $this->hg_img16->CurrentValue;
		$this->hg_img16->ViewCustomAttributes = "";

		// hg_img17
		$this->hg_img17->ViewValue = $this->hg_img17->CurrentValue;
		$this->hg_img17->ViewCustomAttributes = "";

		// hg_img18
		$this->hg_img18->ViewValue = $this->hg_img18->CurrentValue;
		$this->hg_img18->ViewCustomAttributes = "";

		// hg_img19
		$this->hg_img19->ViewValue = $this->hg_img19->CurrentValue;
		$this->hg_img19->ViewCustomAttributes = "";

		// hg_img20
		$this->hg_img20->ViewValue = $this->hg_img20->CurrentValue;
		$this->hg_img20->ViewCustomAttributes = "";

		// hg_img21
		$this->hg_img21->ViewValue = $this->hg_img21->CurrentValue;
		$this->hg_img21->ViewCustomAttributes = "";

		// hg_img22
		$this->hg_img22->ViewValue = $this->hg_img22->CurrentValue;
		$this->hg_img22->ViewCustomAttributes = "";

		// hg_img23
		$this->hg_img23->ViewValue = $this->hg_img23->CurrentValue;
		$this->hg_img23->ViewCustomAttributes = "";

		// hg_img24
		$this->hg_img24->ViewValue = $this->hg_img24->CurrentValue;
		$this->hg_img24->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

		// hgallery_id
		$this->hgallery_id->LinkCustomAttributes = "";
		$this->hgallery_id->HrefValue = "";
		$this->hgallery_id->TooltipValue = "";

		// hotel_id
		$this->hotel_id->LinkCustomAttributes = "";
		$this->hotel_id->HrefValue = "";
		$this->hotel_id->TooltipValue = "";

		// hg_img1
		$this->hg_img1->LinkCustomAttributes = "";
		$this->hg_img1->HrefValue = "";
		$this->hg_img1->TooltipValue = "";

		// hg_img2
		$this->hg_img2->LinkCustomAttributes = "";
		$this->hg_img2->HrefValue = "";
		$this->hg_img2->TooltipValue = "";

		// hg_img3
		$this->hg_img3->LinkCustomAttributes = "";
		$this->hg_img3->HrefValue = "";
		$this->hg_img3->TooltipValue = "";

		// hg_img4
		$this->hg_img4->LinkCustomAttributes = "";
		$this->hg_img4->HrefValue = "";
		$this->hg_img4->TooltipValue = "";

		// hg_img5
		$this->hg_img5->LinkCustomAttributes = "";
		$this->hg_img5->HrefValue = "";
		$this->hg_img5->TooltipValue = "";

		// hg_img6
		$this->hg_img6->LinkCustomAttributes = "";
		$this->hg_img6->HrefValue = "";
		$this->hg_img6->TooltipValue = "";

		// hg_img7
		$this->hg_img7->LinkCustomAttributes = "";
		$this->hg_img7->HrefValue = "";
		$this->hg_img7->TooltipValue = "";

		// hg_img8
		$this->hg_img8->LinkCustomAttributes = "";
		$this->hg_img8->HrefValue = "";
		$this->hg_img8->TooltipValue = "";

		// hg_img9
		$this->hg_img9->LinkCustomAttributes = "";
		$this->hg_img9->HrefValue = "";
		$this->hg_img9->TooltipValue = "";

		// hg_img10
		$this->hg_img10->LinkCustomAttributes = "";
		$this->hg_img10->HrefValue = "";
		$this->hg_img10->TooltipValue = "";

		// hg_img11
		$this->hg_img11->LinkCustomAttributes = "";
		$this->hg_img11->HrefValue = "";
		$this->hg_img11->TooltipValue = "";

		// hg_img12
		$this->hg_img12->LinkCustomAttributes = "";
		$this->hg_img12->HrefValue = "";
		$this->hg_img12->TooltipValue = "";

		// hg_img13
		$this->hg_img13->LinkCustomAttributes = "";
		$this->hg_img13->HrefValue = "";
		$this->hg_img13->TooltipValue = "";

		// hg_img14
		$this->hg_img14->LinkCustomAttributes = "";
		$this->hg_img14->HrefValue = "";
		$this->hg_img14->TooltipValue = "";

		// hg_img15
		$this->hg_img15->LinkCustomAttributes = "";
		$this->hg_img15->HrefValue = "";
		$this->hg_img15->TooltipValue = "";

		// hg_img16
		$this->hg_img16->LinkCustomAttributes = "";
		$this->hg_img16->HrefValue = "";
		$this->hg_img16->TooltipValue = "";

		// hg_img17
		$this->hg_img17->LinkCustomAttributes = "";
		$this->hg_img17->HrefValue = "";
		$this->hg_img17->TooltipValue = "";

		// hg_img18
		$this->hg_img18->LinkCustomAttributes = "";
		$this->hg_img18->HrefValue = "";
		$this->hg_img18->TooltipValue = "";

		// hg_img19
		$this->hg_img19->LinkCustomAttributes = "";
		$this->hg_img19->HrefValue = "";
		$this->hg_img19->TooltipValue = "";

		// hg_img20
		$this->hg_img20->LinkCustomAttributes = "";
		$this->hg_img20->HrefValue = "";
		$this->hg_img20->TooltipValue = "";

		// hg_img21
		$this->hg_img21->LinkCustomAttributes = "";
		$this->hg_img21->HrefValue = "";
		$this->hg_img21->TooltipValue = "";

		// hg_img22
		$this->hg_img22->LinkCustomAttributes = "";
		$this->hg_img22->HrefValue = "";
		$this->hg_img22->TooltipValue = "";

		// hg_img23
		$this->hg_img23->LinkCustomAttributes = "";
		$this->hg_img23->HrefValue = "";
		$this->hg_img23->TooltipValue = "";

		// hg_img24
		$this->hg_img24->LinkCustomAttributes = "";
		$this->hg_img24->HrefValue = "";
		$this->hg_img24->TooltipValue = "";

		// last_update
		$this->last_update->LinkCustomAttributes = "";
		$this->last_update->HrefValue = "";
		$this->last_update->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// hgallery_id
		$this->hgallery_id->EditAttrs["class"] = "form-control";
		$this->hgallery_id->EditCustomAttributes = "";
		$this->hgallery_id->EditValue = $this->hgallery_id->CurrentValue;
		$this->hgallery_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->EditAttrs["class"] = "form-control";
		$this->hotel_id->EditCustomAttributes = "";
		$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hg_img1
		$this->hg_img1->EditAttrs["class"] = "form-control";
		$this->hg_img1->EditCustomAttributes = "";
		$this->hg_img1->EditValue = $this->hg_img1->CurrentValue;
		$this->hg_img1->PlaceHolder = ew_RemoveHtml($this->hg_img1->FldCaption());

		// hg_img2
		$this->hg_img2->EditAttrs["class"] = "form-control";
		$this->hg_img2->EditCustomAttributes = "";
		$this->hg_img2->EditValue = $this->hg_img2->CurrentValue;
		$this->hg_img2->PlaceHolder = ew_RemoveHtml($this->hg_img2->FldCaption());

		// hg_img3
		$this->hg_img3->EditAttrs["class"] = "form-control";
		$this->hg_img3->EditCustomAttributes = "";
		$this->hg_img3->EditValue = $this->hg_img3->CurrentValue;
		$this->hg_img3->PlaceHolder = ew_RemoveHtml($this->hg_img3->FldCaption());

		// hg_img4
		$this->hg_img4->EditAttrs["class"] = "form-control";
		$this->hg_img4->EditCustomAttributes = "";
		$this->hg_img4->EditValue = $this->hg_img4->CurrentValue;
		$this->hg_img4->PlaceHolder = ew_RemoveHtml($this->hg_img4->FldCaption());

		// hg_img5
		$this->hg_img5->EditAttrs["class"] = "form-control";
		$this->hg_img5->EditCustomAttributes = "";
		$this->hg_img5->EditValue = $this->hg_img5->CurrentValue;
		$this->hg_img5->PlaceHolder = ew_RemoveHtml($this->hg_img5->FldCaption());

		// hg_img6
		$this->hg_img6->EditAttrs["class"] = "form-control";
		$this->hg_img6->EditCustomAttributes = "";
		$this->hg_img6->EditValue = $this->hg_img6->CurrentValue;
		$this->hg_img6->PlaceHolder = ew_RemoveHtml($this->hg_img6->FldCaption());

		// hg_img7
		$this->hg_img7->EditAttrs["class"] = "form-control";
		$this->hg_img7->EditCustomAttributes = "";
		$this->hg_img7->EditValue = $this->hg_img7->CurrentValue;
		$this->hg_img7->PlaceHolder = ew_RemoveHtml($this->hg_img7->FldCaption());

		// hg_img8
		$this->hg_img8->EditAttrs["class"] = "form-control";
		$this->hg_img8->EditCustomAttributes = "";
		$this->hg_img8->EditValue = $this->hg_img8->CurrentValue;
		$this->hg_img8->PlaceHolder = ew_RemoveHtml($this->hg_img8->FldCaption());

		// hg_img9
		$this->hg_img9->EditAttrs["class"] = "form-control";
		$this->hg_img9->EditCustomAttributes = "";
		$this->hg_img9->EditValue = $this->hg_img9->CurrentValue;
		$this->hg_img9->PlaceHolder = ew_RemoveHtml($this->hg_img9->FldCaption());

		// hg_img10
		$this->hg_img10->EditAttrs["class"] = "form-control";
		$this->hg_img10->EditCustomAttributes = "";
		$this->hg_img10->EditValue = $this->hg_img10->CurrentValue;
		$this->hg_img10->PlaceHolder = ew_RemoveHtml($this->hg_img10->FldCaption());

		// hg_img11
		$this->hg_img11->EditAttrs["class"] = "form-control";
		$this->hg_img11->EditCustomAttributes = "";
		$this->hg_img11->EditValue = $this->hg_img11->CurrentValue;
		$this->hg_img11->PlaceHolder = ew_RemoveHtml($this->hg_img11->FldCaption());

		// hg_img12
		$this->hg_img12->EditAttrs["class"] = "form-control";
		$this->hg_img12->EditCustomAttributes = "";
		$this->hg_img12->EditValue = $this->hg_img12->CurrentValue;
		$this->hg_img12->PlaceHolder = ew_RemoveHtml($this->hg_img12->FldCaption());

		// hg_img13
		$this->hg_img13->EditAttrs["class"] = "form-control";
		$this->hg_img13->EditCustomAttributes = "";
		$this->hg_img13->EditValue = $this->hg_img13->CurrentValue;
		$this->hg_img13->PlaceHolder = ew_RemoveHtml($this->hg_img13->FldCaption());

		// hg_img14
		$this->hg_img14->EditAttrs["class"] = "form-control";
		$this->hg_img14->EditCustomAttributes = "";
		$this->hg_img14->EditValue = $this->hg_img14->CurrentValue;
		$this->hg_img14->PlaceHolder = ew_RemoveHtml($this->hg_img14->FldCaption());

		// hg_img15
		$this->hg_img15->EditAttrs["class"] = "form-control";
		$this->hg_img15->EditCustomAttributes = "";
		$this->hg_img15->EditValue = $this->hg_img15->CurrentValue;
		$this->hg_img15->PlaceHolder = ew_RemoveHtml($this->hg_img15->FldCaption());

		// hg_img16
		$this->hg_img16->EditAttrs["class"] = "form-control";
		$this->hg_img16->EditCustomAttributes = "";
		$this->hg_img16->EditValue = $this->hg_img16->CurrentValue;
		$this->hg_img16->PlaceHolder = ew_RemoveHtml($this->hg_img16->FldCaption());

		// hg_img17
		$this->hg_img17->EditAttrs["class"] = "form-control";
		$this->hg_img17->EditCustomAttributes = "";
		$this->hg_img17->EditValue = $this->hg_img17->CurrentValue;
		$this->hg_img17->PlaceHolder = ew_RemoveHtml($this->hg_img17->FldCaption());

		// hg_img18
		$this->hg_img18->EditAttrs["class"] = "form-control";
		$this->hg_img18->EditCustomAttributes = "";
		$this->hg_img18->EditValue = $this->hg_img18->CurrentValue;
		$this->hg_img18->PlaceHolder = ew_RemoveHtml($this->hg_img18->FldCaption());

		// hg_img19
		$this->hg_img19->EditAttrs["class"] = "form-control";
		$this->hg_img19->EditCustomAttributes = "";
		$this->hg_img19->EditValue = $this->hg_img19->CurrentValue;
		$this->hg_img19->PlaceHolder = ew_RemoveHtml($this->hg_img19->FldCaption());

		// hg_img20
		$this->hg_img20->EditAttrs["class"] = "form-control";
		$this->hg_img20->EditCustomAttributes = "";
		$this->hg_img20->EditValue = $this->hg_img20->CurrentValue;
		$this->hg_img20->PlaceHolder = ew_RemoveHtml($this->hg_img20->FldCaption());

		// hg_img21
		$this->hg_img21->EditAttrs["class"] = "form-control";
		$this->hg_img21->EditCustomAttributes = "";
		$this->hg_img21->EditValue = $this->hg_img21->CurrentValue;
		$this->hg_img21->PlaceHolder = ew_RemoveHtml($this->hg_img21->FldCaption());

		// hg_img22
		$this->hg_img22->EditAttrs["class"] = "form-control";
		$this->hg_img22->EditCustomAttributes = "";
		$this->hg_img22->EditValue = $this->hg_img22->CurrentValue;
		$this->hg_img22->PlaceHolder = ew_RemoveHtml($this->hg_img22->FldCaption());

		// hg_img23
		$this->hg_img23->EditAttrs["class"] = "form-control";
		$this->hg_img23->EditCustomAttributes = "";
		$this->hg_img23->EditValue = $this->hg_img23->CurrentValue;
		$this->hg_img23->PlaceHolder = ew_RemoveHtml($this->hg_img23->FldCaption());

		// hg_img24
		$this->hg_img24->EditAttrs["class"] = "form-control";
		$this->hg_img24->EditCustomAttributes = "";
		$this->hg_img24->EditValue = $this->hg_img24->CurrentValue;
		$this->hg_img24->PlaceHolder = ew_RemoveHtml($this->hg_img24->FldCaption());

		// last_update
		$this->last_update->EditAttrs["class"] = "form-control";
		$this->last_update->EditCustomAttributes = "";
		$this->last_update->EditValue = ew_FormatDateTime($this->last_update->CurrentValue, 8);
		$this->last_update->PlaceHolder = ew_RemoveHtml($this->last_update->FldCaption());

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
					if ($this->hgallery_id->Exportable) $Doc->ExportCaption($this->hgallery_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->hg_img1->Exportable) $Doc->ExportCaption($this->hg_img1);
					if ($this->hg_img2->Exportable) $Doc->ExportCaption($this->hg_img2);
					if ($this->hg_img3->Exportable) $Doc->ExportCaption($this->hg_img3);
					if ($this->hg_img4->Exportable) $Doc->ExportCaption($this->hg_img4);
					if ($this->hg_img5->Exportable) $Doc->ExportCaption($this->hg_img5);
					if ($this->hg_img6->Exportable) $Doc->ExportCaption($this->hg_img6);
					if ($this->hg_img7->Exportable) $Doc->ExportCaption($this->hg_img7);
					if ($this->hg_img8->Exportable) $Doc->ExportCaption($this->hg_img8);
					if ($this->hg_img9->Exportable) $Doc->ExportCaption($this->hg_img9);
					if ($this->hg_img10->Exportable) $Doc->ExportCaption($this->hg_img10);
					if ($this->hg_img11->Exportable) $Doc->ExportCaption($this->hg_img11);
					if ($this->hg_img12->Exportable) $Doc->ExportCaption($this->hg_img12);
					if ($this->hg_img13->Exportable) $Doc->ExportCaption($this->hg_img13);
					if ($this->hg_img14->Exportable) $Doc->ExportCaption($this->hg_img14);
					if ($this->hg_img15->Exportable) $Doc->ExportCaption($this->hg_img15);
					if ($this->hg_img16->Exportable) $Doc->ExportCaption($this->hg_img16);
					if ($this->hg_img17->Exportable) $Doc->ExportCaption($this->hg_img17);
					if ($this->hg_img18->Exportable) $Doc->ExportCaption($this->hg_img18);
					if ($this->hg_img19->Exportable) $Doc->ExportCaption($this->hg_img19);
					if ($this->hg_img20->Exportable) $Doc->ExportCaption($this->hg_img20);
					if ($this->hg_img21->Exportable) $Doc->ExportCaption($this->hg_img21);
					if ($this->hg_img22->Exportable) $Doc->ExportCaption($this->hg_img22);
					if ($this->hg_img23->Exportable) $Doc->ExportCaption($this->hg_img23);
					if ($this->hg_img24->Exportable) $Doc->ExportCaption($this->hg_img24);
					if ($this->last_update->Exportable) $Doc->ExportCaption($this->last_update);
				} else {
					if ($this->hgallery_id->Exportable) $Doc->ExportCaption($this->hgallery_id);
					if ($this->hotel_id->Exportable) $Doc->ExportCaption($this->hotel_id);
					if ($this->hg_img1->Exportable) $Doc->ExportCaption($this->hg_img1);
					if ($this->hg_img2->Exportable) $Doc->ExportCaption($this->hg_img2);
					if ($this->hg_img3->Exportable) $Doc->ExportCaption($this->hg_img3);
					if ($this->hg_img4->Exportable) $Doc->ExportCaption($this->hg_img4);
					if ($this->hg_img5->Exportable) $Doc->ExportCaption($this->hg_img5);
					if ($this->hg_img6->Exportable) $Doc->ExportCaption($this->hg_img6);
					if ($this->hg_img7->Exportable) $Doc->ExportCaption($this->hg_img7);
					if ($this->hg_img8->Exportable) $Doc->ExportCaption($this->hg_img8);
					if ($this->hg_img9->Exportable) $Doc->ExportCaption($this->hg_img9);
					if ($this->hg_img10->Exportable) $Doc->ExportCaption($this->hg_img10);
					if ($this->hg_img11->Exportable) $Doc->ExportCaption($this->hg_img11);
					if ($this->hg_img12->Exportable) $Doc->ExportCaption($this->hg_img12);
					if ($this->hg_img13->Exportable) $Doc->ExportCaption($this->hg_img13);
					if ($this->hg_img14->Exportable) $Doc->ExportCaption($this->hg_img14);
					if ($this->hg_img15->Exportable) $Doc->ExportCaption($this->hg_img15);
					if ($this->hg_img16->Exportable) $Doc->ExportCaption($this->hg_img16);
					if ($this->hg_img17->Exportable) $Doc->ExportCaption($this->hg_img17);
					if ($this->hg_img18->Exportable) $Doc->ExportCaption($this->hg_img18);
					if ($this->hg_img19->Exportable) $Doc->ExportCaption($this->hg_img19);
					if ($this->hg_img20->Exportable) $Doc->ExportCaption($this->hg_img20);
					if ($this->hg_img21->Exportable) $Doc->ExportCaption($this->hg_img21);
					if ($this->hg_img22->Exportable) $Doc->ExportCaption($this->hg_img22);
					if ($this->hg_img23->Exportable) $Doc->ExportCaption($this->hg_img23);
					if ($this->hg_img24->Exportable) $Doc->ExportCaption($this->hg_img24);
					if ($this->last_update->Exportable) $Doc->ExportCaption($this->last_update);
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
						if ($this->hgallery_id->Exportable) $Doc->ExportField($this->hgallery_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->hg_img1->Exportable) $Doc->ExportField($this->hg_img1);
						if ($this->hg_img2->Exportable) $Doc->ExportField($this->hg_img2);
						if ($this->hg_img3->Exportable) $Doc->ExportField($this->hg_img3);
						if ($this->hg_img4->Exportable) $Doc->ExportField($this->hg_img4);
						if ($this->hg_img5->Exportable) $Doc->ExportField($this->hg_img5);
						if ($this->hg_img6->Exportable) $Doc->ExportField($this->hg_img6);
						if ($this->hg_img7->Exportable) $Doc->ExportField($this->hg_img7);
						if ($this->hg_img8->Exportable) $Doc->ExportField($this->hg_img8);
						if ($this->hg_img9->Exportable) $Doc->ExportField($this->hg_img9);
						if ($this->hg_img10->Exportable) $Doc->ExportField($this->hg_img10);
						if ($this->hg_img11->Exportable) $Doc->ExportField($this->hg_img11);
						if ($this->hg_img12->Exportable) $Doc->ExportField($this->hg_img12);
						if ($this->hg_img13->Exportable) $Doc->ExportField($this->hg_img13);
						if ($this->hg_img14->Exportable) $Doc->ExportField($this->hg_img14);
						if ($this->hg_img15->Exportable) $Doc->ExportField($this->hg_img15);
						if ($this->hg_img16->Exportable) $Doc->ExportField($this->hg_img16);
						if ($this->hg_img17->Exportable) $Doc->ExportField($this->hg_img17);
						if ($this->hg_img18->Exportable) $Doc->ExportField($this->hg_img18);
						if ($this->hg_img19->Exportable) $Doc->ExportField($this->hg_img19);
						if ($this->hg_img20->Exportable) $Doc->ExportField($this->hg_img20);
						if ($this->hg_img21->Exportable) $Doc->ExportField($this->hg_img21);
						if ($this->hg_img22->Exportable) $Doc->ExportField($this->hg_img22);
						if ($this->hg_img23->Exportable) $Doc->ExportField($this->hg_img23);
						if ($this->hg_img24->Exportable) $Doc->ExportField($this->hg_img24);
						if ($this->last_update->Exportable) $Doc->ExportField($this->last_update);
					} else {
						if ($this->hgallery_id->Exportable) $Doc->ExportField($this->hgallery_id);
						if ($this->hotel_id->Exportable) $Doc->ExportField($this->hotel_id);
						if ($this->hg_img1->Exportable) $Doc->ExportField($this->hg_img1);
						if ($this->hg_img2->Exportable) $Doc->ExportField($this->hg_img2);
						if ($this->hg_img3->Exportable) $Doc->ExportField($this->hg_img3);
						if ($this->hg_img4->Exportable) $Doc->ExportField($this->hg_img4);
						if ($this->hg_img5->Exportable) $Doc->ExportField($this->hg_img5);
						if ($this->hg_img6->Exportable) $Doc->ExportField($this->hg_img6);
						if ($this->hg_img7->Exportable) $Doc->ExportField($this->hg_img7);
						if ($this->hg_img8->Exportable) $Doc->ExportField($this->hg_img8);
						if ($this->hg_img9->Exportable) $Doc->ExportField($this->hg_img9);
						if ($this->hg_img10->Exportable) $Doc->ExportField($this->hg_img10);
						if ($this->hg_img11->Exportable) $Doc->ExportField($this->hg_img11);
						if ($this->hg_img12->Exportable) $Doc->ExportField($this->hg_img12);
						if ($this->hg_img13->Exportable) $Doc->ExportField($this->hg_img13);
						if ($this->hg_img14->Exportable) $Doc->ExportField($this->hg_img14);
						if ($this->hg_img15->Exportable) $Doc->ExportField($this->hg_img15);
						if ($this->hg_img16->Exportable) $Doc->ExportField($this->hg_img16);
						if ($this->hg_img17->Exportable) $Doc->ExportField($this->hg_img17);
						if ($this->hg_img18->Exportable) $Doc->ExportField($this->hg_img18);
						if ($this->hg_img19->Exportable) $Doc->ExportField($this->hg_img19);
						if ($this->hg_img20->Exportable) $Doc->ExportField($this->hg_img20);
						if ($this->hg_img21->Exportable) $Doc->ExportField($this->hg_img21);
						if ($this->hg_img22->Exportable) $Doc->ExportField($this->hg_img22);
						if ($this->hg_img23->Exportable) $Doc->ExportField($this->hg_img23);
						if ($this->hg_img24->Exportable) $Doc->ExportField($this->hg_img24);
						if ($this->last_update->Exportable) $Doc->ExportField($this->last_update);
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

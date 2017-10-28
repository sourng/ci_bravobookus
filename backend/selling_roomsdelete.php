<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "selling_roomsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$selling_rooms_delete = NULL; // Initialize page object first

class cselling_rooms_delete extends cselling_rooms {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'selling_rooms';

	// Page object name
	var $PageObjName = 'selling_rooms_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (selling_rooms)
		if (!isset($GLOBALS["selling_rooms"]) || get_class($GLOBALS["selling_rooms"]) == "cselling_rooms") {
			$GLOBALS["selling_rooms"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["selling_rooms"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'selling_rooms', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("selling_roomslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->sell_room_id->SetVisibility();
		$this->sell_room_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hroom_id->SetVisibility();
		$this->hotel_id->SetVisibility();
		$this->rt_id->SetVisibility();
		$this->sell_date->SetVisibility();
		$this->day->SetVisibility();
		$this->month->SetVisibility();
		$this->year->SetVisibility();
		$this->max_people->SetVisibility();
		$this->base_rate->SetVisibility();
		$this->discount->SetVisibility();
		$this->room_sell->SetVisibility();
		$this->room_sold->SetVisibility();
		$this->room_closed->SetVisibility();
		$this->room_status->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $selling_rooms;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($selling_rooms);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("selling_roomslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in selling_rooms class, selling_roomsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("selling_roomslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->sell_room_id->setDbValue($rs->fields('sell_room_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->sell_date->setDbValue($rs->fields('sell_date'));
		$this->day->setDbValue($rs->fields('day'));
		$this->month->setDbValue($rs->fields('month'));
		$this->year->setDbValue($rs->fields('year'));
		$this->max_people->setDbValue($rs->fields('max_people'));
		$this->base_rate->setDbValue($rs->fields('base_rate'));
		$this->discount->setDbValue($rs->fields('discount'));
		$this->room_sell->setDbValue($rs->fields('room_sell'));
		$this->room_sold->setDbValue($rs->fields('room_sold'));
		$this->room_closed->setDbValue($rs->fields('room_closed'));
		$this->room_status->setDbValue($rs->fields('room_status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->sell_room_id->DbValue = $row['sell_room_id'];
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->rt_id->DbValue = $row['rt_id'];
		$this->sell_date->DbValue = $row['sell_date'];
		$this->day->DbValue = $row['day'];
		$this->month->DbValue = $row['month'];
		$this->year->DbValue = $row['year'];
		$this->max_people->DbValue = $row['max_people'];
		$this->base_rate->DbValue = $row['base_rate'];
		$this->discount->DbValue = $row['discount'];
		$this->room_sell->DbValue = $row['room_sell'];
		$this->room_sold->DbValue = $row['room_sold'];
		$this->room_closed->DbValue = $row['room_closed'];
		$this->room_status->DbValue = $row['room_status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->base_rate->FormValue == $this->base_rate->CurrentValue && is_numeric(ew_StrToFloat($this->base_rate->CurrentValue)))
			$this->base_rate->CurrentValue = ew_StrToFloat($this->base_rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// sell_room_id
		// hroom_id
		// hotel_id
		// rt_id
		// sell_date
		// day
		// month
		// year
		// max_people
		// base_rate
		// discount
		// room_sell
		// room_sold
		// room_closed
		// room_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sell_room_id
		$this->sell_room_id->ViewValue = $this->sell_room_id->CurrentValue;
		$this->sell_room_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// sell_date
		$this->sell_date->ViewValue = $this->sell_date->CurrentValue;
		$this->sell_date->ViewValue = ew_FormatDateTime($this->sell_date->ViewValue, 0);
		$this->sell_date->ViewCustomAttributes = "";

		// day
		$this->day->ViewValue = $this->day->CurrentValue;
		$this->day->ViewCustomAttributes = "";

		// month
		$this->month->ViewValue = $this->month->CurrentValue;
		$this->month->ViewCustomAttributes = "";

		// year
		$this->year->ViewValue = $this->year->CurrentValue;
		$this->year->ViewCustomAttributes = "";

		// max_people
		$this->max_people->ViewValue = $this->max_people->CurrentValue;
		$this->max_people->ViewCustomAttributes = "";

		// base_rate
		$this->base_rate->ViewValue = $this->base_rate->CurrentValue;
		$this->base_rate->ViewCustomAttributes = "";

		// discount
		$this->discount->ViewValue = $this->discount->CurrentValue;
		$this->discount->ViewCustomAttributes = "";

		// room_sell
		$this->room_sell->ViewValue = $this->room_sell->CurrentValue;
		$this->room_sell->ViewCustomAttributes = "";

		// room_sold
		if (ew_ConvertToBool($this->room_sold->CurrentValue)) {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(1) <> "" ? $this->room_sold->FldTagCaption(1) : "Y";
		} else {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(2) <> "" ? $this->room_sold->FldTagCaption(2) : "N";
		}
		$this->room_sold->ViewCustomAttributes = "";

		// room_closed
		if (ew_ConvertToBool($this->room_closed->CurrentValue)) {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(1) <> "" ? $this->room_closed->FldTagCaption(1) : "Y";
		} else {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(2) <> "" ? $this->room_closed->FldTagCaption(2) : "N";
		}
		$this->room_closed->ViewCustomAttributes = "";

		// room_status
		if (ew_ConvertToBool($this->room_status->CurrentValue)) {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(1) <> "" ? $this->room_status->FldTagCaption(1) : "Y";
		} else {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(2) <> "" ? $this->room_status->FldTagCaption(2) : "N";
		}
		$this->room_status->ViewCustomAttributes = "";

			// sell_room_id
			$this->sell_room_id->LinkCustomAttributes = "";
			$this->sell_room_id->HrefValue = "";
			$this->sell_room_id->TooltipValue = "";

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

			// sell_date
			$this->sell_date->LinkCustomAttributes = "";
			$this->sell_date->HrefValue = "";
			$this->sell_date->TooltipValue = "";

			// day
			$this->day->LinkCustomAttributes = "";
			$this->day->HrefValue = "";
			$this->day->TooltipValue = "";

			// month
			$this->month->LinkCustomAttributes = "";
			$this->month->HrefValue = "";
			$this->month->TooltipValue = "";

			// year
			$this->year->LinkCustomAttributes = "";
			$this->year->HrefValue = "";
			$this->year->TooltipValue = "";

			// max_people
			$this->max_people->LinkCustomAttributes = "";
			$this->max_people->HrefValue = "";
			$this->max_people->TooltipValue = "";

			// base_rate
			$this->base_rate->LinkCustomAttributes = "";
			$this->base_rate->HrefValue = "";
			$this->base_rate->TooltipValue = "";

			// discount
			$this->discount->LinkCustomAttributes = "";
			$this->discount->HrefValue = "";
			$this->discount->TooltipValue = "";

			// room_sell
			$this->room_sell->LinkCustomAttributes = "";
			$this->room_sell->HrefValue = "";
			$this->room_sell->TooltipValue = "";

			// room_sold
			$this->room_sold->LinkCustomAttributes = "";
			$this->room_sold->HrefValue = "";
			$this->room_sold->TooltipValue = "";

			// room_closed
			$this->room_closed->LinkCustomAttributes = "";
			$this->room_closed->HrefValue = "";
			$this->room_closed->TooltipValue = "";

			// room_status
			$this->room_status->LinkCustomAttributes = "";
			$this->room_status->HrefValue = "";
			$this->room_status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['sell_room_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hroom_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hotel_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['rt_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("selling_roomslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($selling_rooms_delete)) $selling_rooms_delete = new cselling_rooms_delete();

// Page init
$selling_rooms_delete->Page_Init();

// Page main
$selling_rooms_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$selling_rooms_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fselling_roomsdelete = new ew_Form("fselling_roomsdelete", "delete");

// Form_CustomValidate event
fselling_roomsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fselling_roomsdelete.ValidateRequired = true;
<?php } else { ?>
fselling_roomsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fselling_roomsdelete.Lists["x_room_sold[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsdelete.Lists["x_room_sold[]"].Options = <?php echo json_encode($selling_rooms->room_sold->Options()) ?>;
fselling_roomsdelete.Lists["x_room_closed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsdelete.Lists["x_room_closed[]"].Options = <?php echo json_encode($selling_rooms->room_closed->Options()) ?>;
fselling_roomsdelete.Lists["x_room_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsdelete.Lists["x_room_status[]"].Options = <?php echo json_encode($selling_rooms->room_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $selling_rooms_delete->ShowPageHeader(); ?>
<?php
$selling_rooms_delete->ShowMessage();
?>
<form name="fselling_roomsdelete" id="fselling_roomsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($selling_rooms_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $selling_rooms_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="selling_rooms">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($selling_rooms_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $selling_rooms->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($selling_rooms->sell_room_id->Visible) { // sell_room_id ?>
		<th><span id="elh_selling_rooms_sell_room_id" class="selling_rooms_sell_room_id"><?php echo $selling_rooms->sell_room_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->hroom_id->Visible) { // hroom_id ?>
		<th><span id="elh_selling_rooms_hroom_id" class="selling_rooms_hroom_id"><?php echo $selling_rooms->hroom_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->hotel_id->Visible) { // hotel_id ?>
		<th><span id="elh_selling_rooms_hotel_id" class="selling_rooms_hotel_id"><?php echo $selling_rooms->hotel_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->rt_id->Visible) { // rt_id ?>
		<th><span id="elh_selling_rooms_rt_id" class="selling_rooms_rt_id"><?php echo $selling_rooms->rt_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->sell_date->Visible) { // sell_date ?>
		<th><span id="elh_selling_rooms_sell_date" class="selling_rooms_sell_date"><?php echo $selling_rooms->sell_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->day->Visible) { // day ?>
		<th><span id="elh_selling_rooms_day" class="selling_rooms_day"><?php echo $selling_rooms->day->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->month->Visible) { // month ?>
		<th><span id="elh_selling_rooms_month" class="selling_rooms_month"><?php echo $selling_rooms->month->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->year->Visible) { // year ?>
		<th><span id="elh_selling_rooms_year" class="selling_rooms_year"><?php echo $selling_rooms->year->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->max_people->Visible) { // max_people ?>
		<th><span id="elh_selling_rooms_max_people" class="selling_rooms_max_people"><?php echo $selling_rooms->max_people->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->base_rate->Visible) { // base_rate ?>
		<th><span id="elh_selling_rooms_base_rate" class="selling_rooms_base_rate"><?php echo $selling_rooms->base_rate->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->discount->Visible) { // discount ?>
		<th><span id="elh_selling_rooms_discount" class="selling_rooms_discount"><?php echo $selling_rooms->discount->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->room_sell->Visible) { // room_sell ?>
		<th><span id="elh_selling_rooms_room_sell" class="selling_rooms_room_sell"><?php echo $selling_rooms->room_sell->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
		<th><span id="elh_selling_rooms_room_sold" class="selling_rooms_room_sold"><?php echo $selling_rooms->room_sold->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
		<th><span id="elh_selling_rooms_room_closed" class="selling_rooms_room_closed"><?php echo $selling_rooms->room_closed->FldCaption() ?></span></th>
<?php } ?>
<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
		<th><span id="elh_selling_rooms_room_status" class="selling_rooms_room_status"><?php echo $selling_rooms->room_status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$selling_rooms_delete->RecCnt = 0;
$i = 0;
while (!$selling_rooms_delete->Recordset->EOF) {
	$selling_rooms_delete->RecCnt++;
	$selling_rooms_delete->RowCnt++;

	// Set row properties
	$selling_rooms->ResetAttrs();
	$selling_rooms->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$selling_rooms_delete->LoadRowValues($selling_rooms_delete->Recordset);

	// Render row
	$selling_rooms_delete->RenderRow();
?>
	<tr<?php echo $selling_rooms->RowAttributes() ?>>
<?php if ($selling_rooms->sell_room_id->Visible) { // sell_room_id ?>
		<td<?php echo $selling_rooms->sell_room_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_sell_room_id" class="selling_rooms_sell_room_id">
<span<?php echo $selling_rooms->sell_room_id->ViewAttributes() ?>>
<?php echo $selling_rooms->sell_room_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->hroom_id->Visible) { // hroom_id ?>
		<td<?php echo $selling_rooms->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_hroom_id" class="selling_rooms_hroom_id">
<span<?php echo $selling_rooms->hroom_id->ViewAttributes() ?>>
<?php echo $selling_rooms->hroom_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->hotel_id->Visible) { // hotel_id ?>
		<td<?php echo $selling_rooms->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_hotel_id" class="selling_rooms_hotel_id">
<span<?php echo $selling_rooms->hotel_id->ViewAttributes() ?>>
<?php echo $selling_rooms->hotel_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->rt_id->Visible) { // rt_id ?>
		<td<?php echo $selling_rooms->rt_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_rt_id" class="selling_rooms_rt_id">
<span<?php echo $selling_rooms->rt_id->ViewAttributes() ?>>
<?php echo $selling_rooms->rt_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->sell_date->Visible) { // sell_date ?>
		<td<?php echo $selling_rooms->sell_date->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_sell_date" class="selling_rooms_sell_date">
<span<?php echo $selling_rooms->sell_date->ViewAttributes() ?>>
<?php echo $selling_rooms->sell_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->day->Visible) { // day ?>
		<td<?php echo $selling_rooms->day->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_day" class="selling_rooms_day">
<span<?php echo $selling_rooms->day->ViewAttributes() ?>>
<?php echo $selling_rooms->day->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->month->Visible) { // month ?>
		<td<?php echo $selling_rooms->month->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_month" class="selling_rooms_month">
<span<?php echo $selling_rooms->month->ViewAttributes() ?>>
<?php echo $selling_rooms->month->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->year->Visible) { // year ?>
		<td<?php echo $selling_rooms->year->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_year" class="selling_rooms_year">
<span<?php echo $selling_rooms->year->ViewAttributes() ?>>
<?php echo $selling_rooms->year->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->max_people->Visible) { // max_people ?>
		<td<?php echo $selling_rooms->max_people->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_max_people" class="selling_rooms_max_people">
<span<?php echo $selling_rooms->max_people->ViewAttributes() ?>>
<?php echo $selling_rooms->max_people->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->base_rate->Visible) { // base_rate ?>
		<td<?php echo $selling_rooms->base_rate->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_base_rate" class="selling_rooms_base_rate">
<span<?php echo $selling_rooms->base_rate->ViewAttributes() ?>>
<?php echo $selling_rooms->base_rate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->discount->Visible) { // discount ?>
		<td<?php echo $selling_rooms->discount->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_discount" class="selling_rooms_discount">
<span<?php echo $selling_rooms->discount->ViewAttributes() ?>>
<?php echo $selling_rooms->discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->room_sell->Visible) { // room_sell ?>
		<td<?php echo $selling_rooms->room_sell->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_room_sell" class="selling_rooms_room_sell">
<span<?php echo $selling_rooms->room_sell->ViewAttributes() ?>>
<?php echo $selling_rooms->room_sell->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
		<td<?php echo $selling_rooms->room_sold->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_room_sold" class="selling_rooms_room_sold">
<span<?php echo $selling_rooms->room_sold->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_sold->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_sold->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_sold->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
		<td<?php echo $selling_rooms->room_closed->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_room_closed" class="selling_rooms_room_closed">
<span<?php echo $selling_rooms->room_closed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_closed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_closed->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_closed->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
		<td<?php echo $selling_rooms->room_status->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_delete->RowCnt ?>_selling_rooms_room_status" class="selling_rooms_room_status">
<span<?php echo $selling_rooms->room_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$selling_rooms_delete->Recordset->MoveNext();
}
$selling_rooms_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $selling_rooms_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fselling_roomsdelete.Init();
</script>
<?php
$selling_rooms_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$selling_rooms_delete->Page_Terminate();
?>

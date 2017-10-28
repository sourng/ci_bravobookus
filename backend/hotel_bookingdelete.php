<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_bookinginfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_booking_delete = NULL; // Initialize page object first

class chotel_booking_delete extends chotel_booking {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_booking';

	// Page object name
	var $PageObjName = 'hotel_booking_delete';

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

		// Table object (hotel_booking)
		if (!isset($GLOBALS["hotel_booking"]) || get_class($GLOBALS["hotel_booking"]) == "chotel_booking") {
			$GLOBALS["hotel_booking"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_booking"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_booking', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_bookinglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->booking_id->SetVisibility();
		$this->booking_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hroom_id->SetVisibility();
		$this->customer_id->SetVisibility();
		$this->hotel_id->SetVisibility();
		$this->room_type->SetVisibility();
		$this->max_adult->SetVisibility();
		$this->max_child->SetVisibility();
		$this->cus_email->SetVisibility();
		$this->cus_passport->SetVisibility();
		$this->cus_pickup->SetVisibility();
		$this->check_in->SetVisibility();
		$this->check_out->SetVisibility();
		$this->max_day_stay->SetVisibility();
		$this->total_amount->SetVisibility();
		$this->booking_status->SetVisibility();

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
		global $EW_EXPORT, $hotel_booking;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_booking);
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
			$this->Page_Terminate("hotel_bookinglist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hotel_booking class, hotel_bookinginfo.php

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
				$this->Page_Terminate("hotel_bookinglist.php"); // Return to list
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
		$this->booking_id->setDbValue($rs->fields('booking_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->room_type->setDbValue($rs->fields('room_type'));
		$this->max_adult->setDbValue($rs->fields('max_adult'));
		$this->max_child->setDbValue($rs->fields('max_child'));
		$this->cus_email->setDbValue($rs->fields('cus_email'));
		$this->cus_passport->setDbValue($rs->fields('cus_passport'));
		$this->cus_pickup->setDbValue($rs->fields('cus_pickup'));
		$this->check_in->setDbValue($rs->fields('check_in'));
		$this->check_out->setDbValue($rs->fields('check_out'));
		$this->max_day_stay->setDbValue($rs->fields('max_day_stay'));
		$this->total_amount->setDbValue($rs->fields('total_amount'));
		$this->booking_status->setDbValue($rs->fields('booking_status'));
		$this->notes->setDbValue($rs->fields('notes'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->booking_id->DbValue = $row['booking_id'];
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->customer_id->DbValue = $row['customer_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->room_type->DbValue = $row['room_type'];
		$this->max_adult->DbValue = $row['max_adult'];
		$this->max_child->DbValue = $row['max_child'];
		$this->cus_email->DbValue = $row['cus_email'];
		$this->cus_passport->DbValue = $row['cus_passport'];
		$this->cus_pickup->DbValue = $row['cus_pickup'];
		$this->check_in->DbValue = $row['check_in'];
		$this->check_out->DbValue = $row['check_out'];
		$this->max_day_stay->DbValue = $row['max_day_stay'];
		$this->total_amount->DbValue = $row['total_amount'];
		$this->booking_status->DbValue = $row['booking_status'];
		$this->notes->DbValue = $row['notes'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->total_amount->FormValue == $this->total_amount->CurrentValue && is_numeric(ew_StrToFloat($this->total_amount->CurrentValue)))
			$this->total_amount->CurrentValue = ew_StrToFloat($this->total_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// booking_id
		// hroom_id
		// customer_id
		// hotel_id
		// room_type
		// max_adult
		// max_child
		// cus_email
		// cus_passport
		// cus_pickup
		// check_in
		// check_out
		// max_day_stay
		// total_amount
		// booking_status
		// notes

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// booking_id
		$this->booking_id->ViewValue = $this->booking_id->CurrentValue;
		$this->booking_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// room_type
		$this->room_type->ViewValue = $this->room_type->CurrentValue;
		$this->room_type->ViewCustomAttributes = "";

		// max_adult
		$this->max_adult->ViewValue = $this->max_adult->CurrentValue;
		$this->max_adult->ViewCustomAttributes = "";

		// max_child
		$this->max_child->ViewValue = $this->max_child->CurrentValue;
		$this->max_child->ViewCustomAttributes = "";

		// cus_email
		$this->cus_email->ViewValue = $this->cus_email->CurrentValue;
		$this->cus_email->ViewCustomAttributes = "";

		// cus_passport
		$this->cus_passport->ViewValue = $this->cus_passport->CurrentValue;
		$this->cus_passport->ViewCustomAttributes = "";

		// cus_pickup
		$this->cus_pickup->ViewValue = $this->cus_pickup->CurrentValue;
		$this->cus_pickup->ViewCustomAttributes = "";

		// check_in
		$this->check_in->ViewValue = $this->check_in->CurrentValue;
		$this->check_in->ViewValue = ew_FormatDateTime($this->check_in->ViewValue, 0);
		$this->check_in->ViewCustomAttributes = "";

		// check_out
		$this->check_out->ViewValue = $this->check_out->CurrentValue;
		$this->check_out->ViewValue = ew_FormatDateTime($this->check_out->ViewValue, 0);
		$this->check_out->ViewCustomAttributes = "";

		// max_day_stay
		$this->max_day_stay->ViewValue = $this->max_day_stay->CurrentValue;
		$this->max_day_stay->ViewCustomAttributes = "";

		// total_amount
		$this->total_amount->ViewValue = $this->total_amount->CurrentValue;
		$this->total_amount->ViewCustomAttributes = "";

		// booking_status
		$this->booking_status->ViewValue = $this->booking_status->CurrentValue;
		$this->booking_status->ViewCustomAttributes = "";

			// booking_id
			$this->booking_id->LinkCustomAttributes = "";
			$this->booking_id->HrefValue = "";
			$this->booking_id->TooltipValue = "";

			// hroom_id
			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";
			$this->hroom_id->TooltipValue = "";

			// customer_id
			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";
			$this->customer_id->TooltipValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// room_type
			$this->room_type->LinkCustomAttributes = "";
			$this->room_type->HrefValue = "";
			$this->room_type->TooltipValue = "";

			// max_adult
			$this->max_adult->LinkCustomAttributes = "";
			$this->max_adult->HrefValue = "";
			$this->max_adult->TooltipValue = "";

			// max_child
			$this->max_child->LinkCustomAttributes = "";
			$this->max_child->HrefValue = "";
			$this->max_child->TooltipValue = "";

			// cus_email
			$this->cus_email->LinkCustomAttributes = "";
			$this->cus_email->HrefValue = "";
			$this->cus_email->TooltipValue = "";

			// cus_passport
			$this->cus_passport->LinkCustomAttributes = "";
			$this->cus_passport->HrefValue = "";
			$this->cus_passport->TooltipValue = "";

			// cus_pickup
			$this->cus_pickup->LinkCustomAttributes = "";
			$this->cus_pickup->HrefValue = "";
			$this->cus_pickup->TooltipValue = "";

			// check_in
			$this->check_in->LinkCustomAttributes = "";
			$this->check_in->HrefValue = "";
			$this->check_in->TooltipValue = "";

			// check_out
			$this->check_out->LinkCustomAttributes = "";
			$this->check_out->HrefValue = "";
			$this->check_out->TooltipValue = "";

			// max_day_stay
			$this->max_day_stay->LinkCustomAttributes = "";
			$this->max_day_stay->HrefValue = "";
			$this->max_day_stay->TooltipValue = "";

			// total_amount
			$this->total_amount->LinkCustomAttributes = "";
			$this->total_amount->HrefValue = "";
			$this->total_amount->TooltipValue = "";

			// booking_status
			$this->booking_status->LinkCustomAttributes = "";
			$this->booking_status->HrefValue = "";
			$this->booking_status->TooltipValue = "";
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
				$sThisKey .= $row['booking_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hroom_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['customer_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_bookinglist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_booking_delete)) $hotel_booking_delete = new chotel_booking_delete();

// Page init
$hotel_booking_delete->Page_Init();

// Page main
$hotel_booking_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_booking_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhotel_bookingdelete = new ew_Form("fhotel_bookingdelete", "delete");

// Form_CustomValidate event
fhotel_bookingdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_bookingdelete.ValidateRequired = true;
<?php } else { ?>
fhotel_bookingdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $hotel_booking_delete->ShowPageHeader(); ?>
<?php
$hotel_booking_delete->ShowMessage();
?>
<form name="fhotel_bookingdelete" id="fhotel_bookingdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_booking_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_booking_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_booking">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hotel_booking_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $hotel_booking->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($hotel_booking->booking_id->Visible) { // booking_id ?>
		<th><span id="elh_hotel_booking_booking_id" class="hotel_booking_booking_id"><?php echo $hotel_booking->booking_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
		<th><span id="elh_hotel_booking_hroom_id" class="hotel_booking_hroom_id"><?php echo $hotel_booking->hroom_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
		<th><span id="elh_hotel_booking_customer_id" class="hotel_booking_customer_id"><?php echo $hotel_booking->customer_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
		<th><span id="elh_hotel_booking_hotel_id" class="hotel_booking_hotel_id"><?php echo $hotel_booking->hotel_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
		<th><span id="elh_hotel_booking_room_type" class="hotel_booking_room_type"><?php echo $hotel_booking->room_type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
		<th><span id="elh_hotel_booking_max_adult" class="hotel_booking_max_adult"><?php echo $hotel_booking->max_adult->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
		<th><span id="elh_hotel_booking_max_child" class="hotel_booking_max_child"><?php echo $hotel_booking->max_child->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
		<th><span id="elh_hotel_booking_cus_email" class="hotel_booking_cus_email"><?php echo $hotel_booking->cus_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
		<th><span id="elh_hotel_booking_cus_passport" class="hotel_booking_cus_passport"><?php echo $hotel_booking->cus_passport->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
		<th><span id="elh_hotel_booking_cus_pickup" class="hotel_booking_cus_pickup"><?php echo $hotel_booking->cus_pickup->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
		<th><span id="elh_hotel_booking_check_in" class="hotel_booking_check_in"><?php echo $hotel_booking->check_in->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
		<th><span id="elh_hotel_booking_check_out" class="hotel_booking_check_out"><?php echo $hotel_booking->check_out->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
		<th><span id="elh_hotel_booking_max_day_stay" class="hotel_booking_max_day_stay"><?php echo $hotel_booking->max_day_stay->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
		<th><span id="elh_hotel_booking_total_amount" class="hotel_booking_total_amount"><?php echo $hotel_booking->total_amount->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
		<th><span id="elh_hotel_booking_booking_status" class="hotel_booking_booking_status"><?php echo $hotel_booking->booking_status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hotel_booking_delete->RecCnt = 0;
$i = 0;
while (!$hotel_booking_delete->Recordset->EOF) {
	$hotel_booking_delete->RecCnt++;
	$hotel_booking_delete->RowCnt++;

	// Set row properties
	$hotel_booking->ResetAttrs();
	$hotel_booking->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hotel_booking_delete->LoadRowValues($hotel_booking_delete->Recordset);

	// Render row
	$hotel_booking_delete->RenderRow();
?>
	<tr<?php echo $hotel_booking->RowAttributes() ?>>
<?php if ($hotel_booking->booking_id->Visible) { // booking_id ?>
		<td<?php echo $hotel_booking->booking_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_booking_id" class="hotel_booking_booking_id">
<span<?php echo $hotel_booking->booking_id->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
		<td<?php echo $hotel_booking->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_hroom_id" class="hotel_booking_hroom_id">
<span<?php echo $hotel_booking->hroom_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hroom_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
		<td<?php echo $hotel_booking->customer_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_customer_id" class="hotel_booking_customer_id">
<span<?php echo $hotel_booking->customer_id->ViewAttributes() ?>>
<?php echo $hotel_booking->customer_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
		<td<?php echo $hotel_booking->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_hotel_id" class="hotel_booking_hotel_id">
<span<?php echo $hotel_booking->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hotel_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
		<td<?php echo $hotel_booking->room_type->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_room_type" class="hotel_booking_room_type">
<span<?php echo $hotel_booking->room_type->ViewAttributes() ?>>
<?php echo $hotel_booking->room_type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
		<td<?php echo $hotel_booking->max_adult->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_max_adult" class="hotel_booking_max_adult">
<span<?php echo $hotel_booking->max_adult->ViewAttributes() ?>>
<?php echo $hotel_booking->max_adult->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
		<td<?php echo $hotel_booking->max_child->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_max_child" class="hotel_booking_max_child">
<span<?php echo $hotel_booking->max_child->ViewAttributes() ?>>
<?php echo $hotel_booking->max_child->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
		<td<?php echo $hotel_booking->cus_email->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_cus_email" class="hotel_booking_cus_email">
<span<?php echo $hotel_booking->cus_email->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
		<td<?php echo $hotel_booking->cus_passport->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_cus_passport" class="hotel_booking_cus_passport">
<span<?php echo $hotel_booking->cus_passport->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_passport->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
		<td<?php echo $hotel_booking->cus_pickup->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_cus_pickup" class="hotel_booking_cus_pickup">
<span<?php echo $hotel_booking->cus_pickup->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_pickup->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
		<td<?php echo $hotel_booking->check_in->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_check_in" class="hotel_booking_check_in">
<span<?php echo $hotel_booking->check_in->ViewAttributes() ?>>
<?php echo $hotel_booking->check_in->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
		<td<?php echo $hotel_booking->check_out->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_check_out" class="hotel_booking_check_out">
<span<?php echo $hotel_booking->check_out->ViewAttributes() ?>>
<?php echo $hotel_booking->check_out->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
		<td<?php echo $hotel_booking->max_day_stay->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_max_day_stay" class="hotel_booking_max_day_stay">
<span<?php echo $hotel_booking->max_day_stay->ViewAttributes() ?>>
<?php echo $hotel_booking->max_day_stay->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
		<td<?php echo $hotel_booking->total_amount->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_total_amount" class="hotel_booking_total_amount">
<span<?php echo $hotel_booking->total_amount->ViewAttributes() ?>>
<?php echo $hotel_booking->total_amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
		<td<?php echo $hotel_booking->booking_status->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_delete->RowCnt ?>_hotel_booking_booking_status" class="hotel_booking_booking_status">
<span<?php echo $hotel_booking->booking_status->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hotel_booking_delete->Recordset->MoveNext();
}
$hotel_booking_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_booking_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhotel_bookingdelete.Init();
</script>
<?php
$hotel_booking_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_booking_delete->Page_Terminate();
?>

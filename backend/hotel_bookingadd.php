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

$hotel_booking_add = NULL; // Initialize page object first

class chotel_booking_add extends chotel_booking {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_booking';

	// Page object name
	var $PageObjName = 'hotel_booking_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotel_bookinglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
		$this->notes->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["booking_id"] != "") {
				$this->booking_id->setQueryStringValue($_GET["booking_id"]);
				$this->setKey("booking_id", $this->booking_id->CurrentValue); // Set up key
			} else {
				$this->setKey("booking_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["hroom_id"] != "") {
				$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
				$this->setKey("hroom_id", $this->hroom_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hroom_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["customer_id"] != "") {
				$this->customer_id->setQueryStringValue($_GET["customer_id"]);
				$this->setKey("customer_id", $this->customer_id->CurrentValue); // Set up key
			} else {
				$this->setKey("customer_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("hotel_bookinglist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "hotel_bookinglist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "hotel_bookingview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->hroom_id->CurrentValue = NULL;
		$this->hroom_id->OldValue = $this->hroom_id->CurrentValue;
		$this->customer_id->CurrentValue = NULL;
		$this->customer_id->OldValue = $this->customer_id->CurrentValue;
		$this->hotel_id->CurrentValue = NULL;
		$this->hotel_id->OldValue = $this->hotel_id->CurrentValue;
		$this->room_type->CurrentValue = NULL;
		$this->room_type->OldValue = $this->room_type->CurrentValue;
		$this->max_adult->CurrentValue = NULL;
		$this->max_adult->OldValue = $this->max_adult->CurrentValue;
		$this->max_child->CurrentValue = NULL;
		$this->max_child->OldValue = $this->max_child->CurrentValue;
		$this->cus_email->CurrentValue = NULL;
		$this->cus_email->OldValue = $this->cus_email->CurrentValue;
		$this->cus_passport->CurrentValue = NULL;
		$this->cus_passport->OldValue = $this->cus_passport->CurrentValue;
		$this->cus_pickup->CurrentValue = NULL;
		$this->cus_pickup->OldValue = $this->cus_pickup->CurrentValue;
		$this->check_in->CurrentValue = NULL;
		$this->check_in->OldValue = $this->check_in->CurrentValue;
		$this->check_out->CurrentValue = NULL;
		$this->check_out->OldValue = $this->check_out->CurrentValue;
		$this->max_day_stay->CurrentValue = NULL;
		$this->max_day_stay->OldValue = $this->max_day_stay->CurrentValue;
		$this->total_amount->CurrentValue = NULL;
		$this->total_amount->OldValue = $this->total_amount->CurrentValue;
		$this->booking_status->CurrentValue = NULL;
		$this->booking_status->OldValue = $this->booking_status->CurrentValue;
		$this->notes->CurrentValue = NULL;
		$this->notes->OldValue = $this->notes->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->hroom_id->FldIsDetailKey) {
			$this->hroom_id->setFormValue($objForm->GetValue("x_hroom_id"));
		}
		if (!$this->customer_id->FldIsDetailKey) {
			$this->customer_id->setFormValue($objForm->GetValue("x_customer_id"));
		}
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->room_type->FldIsDetailKey) {
			$this->room_type->setFormValue($objForm->GetValue("x_room_type"));
		}
		if (!$this->max_adult->FldIsDetailKey) {
			$this->max_adult->setFormValue($objForm->GetValue("x_max_adult"));
		}
		if (!$this->max_child->FldIsDetailKey) {
			$this->max_child->setFormValue($objForm->GetValue("x_max_child"));
		}
		if (!$this->cus_email->FldIsDetailKey) {
			$this->cus_email->setFormValue($objForm->GetValue("x_cus_email"));
		}
		if (!$this->cus_passport->FldIsDetailKey) {
			$this->cus_passport->setFormValue($objForm->GetValue("x_cus_passport"));
		}
		if (!$this->cus_pickup->FldIsDetailKey) {
			$this->cus_pickup->setFormValue($objForm->GetValue("x_cus_pickup"));
		}
		if (!$this->check_in->FldIsDetailKey) {
			$this->check_in->setFormValue($objForm->GetValue("x_check_in"));
			$this->check_in->CurrentValue = ew_UnFormatDateTime($this->check_in->CurrentValue, 0);
		}
		if (!$this->check_out->FldIsDetailKey) {
			$this->check_out->setFormValue($objForm->GetValue("x_check_out"));
			$this->check_out->CurrentValue = ew_UnFormatDateTime($this->check_out->CurrentValue, 0);
		}
		if (!$this->max_day_stay->FldIsDetailKey) {
			$this->max_day_stay->setFormValue($objForm->GetValue("x_max_day_stay"));
		}
		if (!$this->total_amount->FldIsDetailKey) {
			$this->total_amount->setFormValue($objForm->GetValue("x_total_amount"));
		}
		if (!$this->booking_status->FldIsDetailKey) {
			$this->booking_status->setFormValue($objForm->GetValue("x_booking_status"));
		}
		if (!$this->notes->FldIsDetailKey) {
			$this->notes->setFormValue($objForm->GetValue("x_notes"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->hroom_id->CurrentValue = $this->hroom_id->FormValue;
		$this->customer_id->CurrentValue = $this->customer_id->FormValue;
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->room_type->CurrentValue = $this->room_type->FormValue;
		$this->max_adult->CurrentValue = $this->max_adult->FormValue;
		$this->max_child->CurrentValue = $this->max_child->FormValue;
		$this->cus_email->CurrentValue = $this->cus_email->FormValue;
		$this->cus_passport->CurrentValue = $this->cus_passport->FormValue;
		$this->cus_pickup->CurrentValue = $this->cus_pickup->FormValue;
		$this->check_in->CurrentValue = $this->check_in->FormValue;
		$this->check_in->CurrentValue = ew_UnFormatDateTime($this->check_in->CurrentValue, 0);
		$this->check_out->CurrentValue = $this->check_out->FormValue;
		$this->check_out->CurrentValue = ew_UnFormatDateTime($this->check_out->CurrentValue, 0);
		$this->max_day_stay->CurrentValue = $this->max_day_stay->FormValue;
		$this->total_amount->CurrentValue = $this->total_amount->FormValue;
		$this->booking_status->CurrentValue = $this->booking_status->FormValue;
		$this->notes->CurrentValue = $this->notes->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("booking_id")) <> "")
			$this->booking_id->CurrentValue = $this->getKey("booking_id"); // booking_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hroom_id")) <> "")
			$this->hroom_id->CurrentValue = $this->getKey("hroom_id"); // hroom_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("customer_id")) <> "")
			$this->customer_id->CurrentValue = $this->getKey("customer_id"); // customer_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

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

			// notes
			$this->notes->LinkCustomAttributes = "";
			$this->notes->HrefValue = "";
			$this->notes->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = ew_HtmlEncode($this->hroom_id->CurrentValue);
			$this->hroom_id->PlaceHolder = ew_RemoveHtml($this->hroom_id->FldCaption());

			// customer_id
			$this->customer_id->EditAttrs["class"] = "form-control";
			$this->customer_id->EditCustomAttributes = "";
			$this->customer_id->EditValue = ew_HtmlEncode($this->customer_id->CurrentValue);
			$this->customer_id->PlaceHolder = ew_RemoveHtml($this->customer_id->FldCaption());

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->CurrentValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// room_type
			$this->room_type->EditAttrs["class"] = "form-control";
			$this->room_type->EditCustomAttributes = "";
			$this->room_type->EditValue = ew_HtmlEncode($this->room_type->CurrentValue);
			$this->room_type->PlaceHolder = ew_RemoveHtml($this->room_type->FldCaption());

			// max_adult
			$this->max_adult->EditAttrs["class"] = "form-control";
			$this->max_adult->EditCustomAttributes = "";
			$this->max_adult->EditValue = ew_HtmlEncode($this->max_adult->CurrentValue);
			$this->max_adult->PlaceHolder = ew_RemoveHtml($this->max_adult->FldCaption());

			// max_child
			$this->max_child->EditAttrs["class"] = "form-control";
			$this->max_child->EditCustomAttributes = "";
			$this->max_child->EditValue = ew_HtmlEncode($this->max_child->CurrentValue);
			$this->max_child->PlaceHolder = ew_RemoveHtml($this->max_child->FldCaption());

			// cus_email
			$this->cus_email->EditAttrs["class"] = "form-control";
			$this->cus_email->EditCustomAttributes = "";
			$this->cus_email->EditValue = ew_HtmlEncode($this->cus_email->CurrentValue);
			$this->cus_email->PlaceHolder = ew_RemoveHtml($this->cus_email->FldCaption());

			// cus_passport
			$this->cus_passport->EditAttrs["class"] = "form-control";
			$this->cus_passport->EditCustomAttributes = "";
			$this->cus_passport->EditValue = ew_HtmlEncode($this->cus_passport->CurrentValue);
			$this->cus_passport->PlaceHolder = ew_RemoveHtml($this->cus_passport->FldCaption());

			// cus_pickup
			$this->cus_pickup->EditAttrs["class"] = "form-control";
			$this->cus_pickup->EditCustomAttributes = "";
			$this->cus_pickup->EditValue = ew_HtmlEncode($this->cus_pickup->CurrentValue);
			$this->cus_pickup->PlaceHolder = ew_RemoveHtml($this->cus_pickup->FldCaption());

			// check_in
			$this->check_in->EditAttrs["class"] = "form-control";
			$this->check_in->EditCustomAttributes = "";
			$this->check_in->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->check_in->CurrentValue, 8));
			$this->check_in->PlaceHolder = ew_RemoveHtml($this->check_in->FldCaption());

			// check_out
			$this->check_out->EditAttrs["class"] = "form-control";
			$this->check_out->EditCustomAttributes = "";
			$this->check_out->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->check_out->CurrentValue, 8));
			$this->check_out->PlaceHolder = ew_RemoveHtml($this->check_out->FldCaption());

			// max_day_stay
			$this->max_day_stay->EditAttrs["class"] = "form-control";
			$this->max_day_stay->EditCustomAttributes = "";
			$this->max_day_stay->EditValue = ew_HtmlEncode($this->max_day_stay->CurrentValue);
			$this->max_day_stay->PlaceHolder = ew_RemoveHtml($this->max_day_stay->FldCaption());

			// total_amount
			$this->total_amount->EditAttrs["class"] = "form-control";
			$this->total_amount->EditCustomAttributes = "";
			$this->total_amount->EditValue = ew_HtmlEncode($this->total_amount->CurrentValue);
			$this->total_amount->PlaceHolder = ew_RemoveHtml($this->total_amount->FldCaption());
			if (strval($this->total_amount->EditValue) <> "" && is_numeric($this->total_amount->EditValue)) $this->total_amount->EditValue = ew_FormatNumber($this->total_amount->EditValue, -2, -1, -2, 0);

			// booking_status
			$this->booking_status->EditAttrs["class"] = "form-control";
			$this->booking_status->EditCustomAttributes = "";
			$this->booking_status->EditValue = ew_HtmlEncode($this->booking_status->CurrentValue);
			$this->booking_status->PlaceHolder = ew_RemoveHtml($this->booking_status->FldCaption());

			// notes
			$this->notes->EditAttrs["class"] = "form-control";
			$this->notes->EditCustomAttributes = "";
			$this->notes->EditValue = ew_HtmlEncode($this->notes->CurrentValue);
			$this->notes->PlaceHolder = ew_RemoveHtml($this->notes->FldCaption());

			// Add refer script
			// hroom_id

			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";

			// customer_id
			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// room_type
			$this->room_type->LinkCustomAttributes = "";
			$this->room_type->HrefValue = "";

			// max_adult
			$this->max_adult->LinkCustomAttributes = "";
			$this->max_adult->HrefValue = "";

			// max_child
			$this->max_child->LinkCustomAttributes = "";
			$this->max_child->HrefValue = "";

			// cus_email
			$this->cus_email->LinkCustomAttributes = "";
			$this->cus_email->HrefValue = "";

			// cus_passport
			$this->cus_passport->LinkCustomAttributes = "";
			$this->cus_passport->HrefValue = "";

			// cus_pickup
			$this->cus_pickup->LinkCustomAttributes = "";
			$this->cus_pickup->HrefValue = "";

			// check_in
			$this->check_in->LinkCustomAttributes = "";
			$this->check_in->HrefValue = "";

			// check_out
			$this->check_out->LinkCustomAttributes = "";
			$this->check_out->HrefValue = "";

			// max_day_stay
			$this->max_day_stay->LinkCustomAttributes = "";
			$this->max_day_stay->HrefValue = "";

			// total_amount
			$this->total_amount->LinkCustomAttributes = "";
			$this->total_amount->HrefValue = "";

			// booking_status
			$this->booking_status->LinkCustomAttributes = "";
			$this->booking_status->HrefValue = "";

			// notes
			$this->notes->LinkCustomAttributes = "";
			$this->notes->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->hroom_id->FldIsDetailKey && !is_null($this->hroom_id->FormValue) && $this->hroom_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hroom_id->FldCaption(), $this->hroom_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hroom_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hroom_id->FldErrMsg());
		}
		if (!$this->customer_id->FldIsDetailKey && !is_null($this->customer_id->FormValue) && $this->customer_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->customer_id->FldCaption(), $this->customer_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->customer_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->customer_id->FldErrMsg());
		}
		if (!$this->hotel_id->FldIsDetailKey && !is_null($this->hotel_id->FormValue) && $this->hotel_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hotel_id->FldCaption(), $this->hotel_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hotel_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hotel_id->FldErrMsg());
		}
		if (!$this->room_type->FldIsDetailKey && !is_null($this->room_type->FormValue) && $this->room_type->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->room_type->FldCaption(), $this->room_type->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->max_adult->FormValue)) {
			ew_AddMessage($gsFormError, $this->max_adult->FldErrMsg());
		}
		if (!ew_CheckInteger($this->max_child->FormValue)) {
			ew_AddMessage($gsFormError, $this->max_child->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->check_in->FormValue)) {
			ew_AddMessage($gsFormError, $this->check_in->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->check_out->FormValue)) {
			ew_AddMessage($gsFormError, $this->check_out->FldErrMsg());
		}
		if (!ew_CheckInteger($this->max_day_stay->FormValue)) {
			ew_AddMessage($gsFormError, $this->max_day_stay->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_amount->FldErrMsg());
		}
		if (!ew_CheckInteger($this->booking_status->FormValue)) {
			ew_AddMessage($gsFormError, $this->booking_status->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// hroom_id
		$this->hroom_id->SetDbValueDef($rsnew, $this->hroom_id->CurrentValue, 0, FALSE);

		// customer_id
		$this->customer_id->SetDbValueDef($rsnew, $this->customer_id->CurrentValue, 0, FALSE);

		// hotel_id
		$this->hotel_id->SetDbValueDef($rsnew, $this->hotel_id->CurrentValue, 0, FALSE);

		// room_type
		$this->room_type->SetDbValueDef($rsnew, $this->room_type->CurrentValue, "", FALSE);

		// max_adult
		$this->max_adult->SetDbValueDef($rsnew, $this->max_adult->CurrentValue, NULL, FALSE);

		// max_child
		$this->max_child->SetDbValueDef($rsnew, $this->max_child->CurrentValue, NULL, FALSE);

		// cus_email
		$this->cus_email->SetDbValueDef($rsnew, $this->cus_email->CurrentValue, NULL, FALSE);

		// cus_passport
		$this->cus_passport->SetDbValueDef($rsnew, $this->cus_passport->CurrentValue, NULL, FALSE);

		// cus_pickup
		$this->cus_pickup->SetDbValueDef($rsnew, $this->cus_pickup->CurrentValue, NULL, FALSE);

		// check_in
		$this->check_in->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->check_in->CurrentValue, 0), NULL, FALSE);

		// check_out
		$this->check_out->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->check_out->CurrentValue, 0), NULL, FALSE);

		// max_day_stay
		$this->max_day_stay->SetDbValueDef($rsnew, $this->max_day_stay->CurrentValue, NULL, FALSE);

		// total_amount
		$this->total_amount->SetDbValueDef($rsnew, $this->total_amount->CurrentValue, NULL, FALSE);

		// booking_status
		$this->booking_status->SetDbValueDef($rsnew, $this->booking_status->CurrentValue, NULL, FALSE);

		// notes
		$this->notes->SetDbValueDef($rsnew, $this->notes->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hroom_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['customer_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_bookinglist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($hotel_booking_add)) $hotel_booking_add = new chotel_booking_add();

// Page init
$hotel_booking_add->Page_Init();

// Page main
$hotel_booking_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_booking_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhotel_bookingadd = new ew_Form("fhotel_bookingadd", "add");

// Validate form
fhotel_bookingadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_hroom_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_booking->hroom_id->FldCaption(), $hotel_booking->hroom_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hroom_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->hroom_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_customer_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_booking->customer_id->FldCaption(), $hotel_booking->customer_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_customer_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->customer_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_booking->hotel_id->FldCaption(), $hotel_booking->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->hotel_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_room_type");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_booking->room_type->FldCaption(), $hotel_booking->room_type->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_max_adult");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->max_adult->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_max_child");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->max_child->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_check_in");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->check_in->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_check_out");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->check_out->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_max_day_stay");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->max_day_stay->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->total_amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_booking_status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_booking->booking_status->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fhotel_bookingadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_bookingadd.ValidateRequired = true;
<?php } else { ?>
fhotel_bookingadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_booking_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_booking_add->ShowPageHeader(); ?>
<?php
$hotel_booking_add->ShowMessage();
?>
<form name="fhotel_bookingadd" id="fhotel_bookingadd" class="<?php echo $hotel_booking_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_booking_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_booking_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_booking">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($hotel_booking_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
	<div id="r_hroom_id" class="form-group">
		<label id="elh_hotel_booking_hroom_id" for="x_hroom_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->hroom_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->hroom_id->CellAttributes() ?>>
<span id="el_hotel_booking_hroom_id">
<input type="text" data-table="hotel_booking" data-field="x_hroom_id" name="x_hroom_id" id="x_hroom_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->hroom_id->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->hroom_id->EditValue ?>"<?php echo $hotel_booking->hroom_id->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->hroom_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
	<div id="r_customer_id" class="form-group">
		<label id="elh_hotel_booking_customer_id" for="x_customer_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->customer_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->customer_id->CellAttributes() ?>>
<span id="el_hotel_booking_customer_id">
<input type="text" data-table="hotel_booking" data-field="x_customer_id" name="x_customer_id" id="x_customer_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->customer_id->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->customer_id->EditValue ?>"<?php echo $hotel_booking->customer_id->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->customer_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_hotel_booking_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->hotel_id->CellAttributes() ?>>
<span id="el_hotel_booking_hotel_id">
<input type="text" data-table="hotel_booking" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->hotel_id->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->hotel_id->EditValue ?>"<?php echo $hotel_booking->hotel_id->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
	<div id="r_room_type" class="form-group">
		<label id="elh_hotel_booking_room_type" for="x_room_type" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->room_type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->room_type->CellAttributes() ?>>
<span id="el_hotel_booking_room_type">
<input type="text" data-table="hotel_booking" data-field="x_room_type" name="x_room_type" id="x_room_type" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_booking->room_type->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->room_type->EditValue ?>"<?php echo $hotel_booking->room_type->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->room_type->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
	<div id="r_max_adult" class="form-group">
		<label id="elh_hotel_booking_max_adult" for="x_max_adult" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->max_adult->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->max_adult->CellAttributes() ?>>
<span id="el_hotel_booking_max_adult">
<input type="text" data-table="hotel_booking" data-field="x_max_adult" name="x_max_adult" id="x_max_adult" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->max_adult->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->max_adult->EditValue ?>"<?php echo $hotel_booking->max_adult->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->max_adult->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
	<div id="r_max_child" class="form-group">
		<label id="elh_hotel_booking_max_child" for="x_max_child" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->max_child->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->max_child->CellAttributes() ?>>
<span id="el_hotel_booking_max_child">
<input type="text" data-table="hotel_booking" data-field="x_max_child" name="x_max_child" id="x_max_child" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->max_child->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->max_child->EditValue ?>"<?php echo $hotel_booking->max_child->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->max_child->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
	<div id="r_cus_email" class="form-group">
		<label id="elh_hotel_booking_cus_email" for="x_cus_email" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->cus_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->cus_email->CellAttributes() ?>>
<span id="el_hotel_booking_cus_email">
<input type="text" data-table="hotel_booking" data-field="x_cus_email" name="x_cus_email" id="x_cus_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_booking->cus_email->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->cus_email->EditValue ?>"<?php echo $hotel_booking->cus_email->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->cus_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
	<div id="r_cus_passport" class="form-group">
		<label id="elh_hotel_booking_cus_passport" for="x_cus_passport" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->cus_passport->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->cus_passport->CellAttributes() ?>>
<span id="el_hotel_booking_cus_passport">
<input type="text" data-table="hotel_booking" data-field="x_cus_passport" name="x_cus_passport" id="x_cus_passport" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_booking->cus_passport->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->cus_passport->EditValue ?>"<?php echo $hotel_booking->cus_passport->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->cus_passport->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
	<div id="r_cus_pickup" class="form-group">
		<label id="elh_hotel_booking_cus_pickup" for="x_cus_pickup" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->cus_pickup->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->cus_pickup->CellAttributes() ?>>
<span id="el_hotel_booking_cus_pickup">
<input type="text" data-table="hotel_booking" data-field="x_cus_pickup" name="x_cus_pickup" id="x_cus_pickup" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_booking->cus_pickup->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->cus_pickup->EditValue ?>"<?php echo $hotel_booking->cus_pickup->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->cus_pickup->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
	<div id="r_check_in" class="form-group">
		<label id="elh_hotel_booking_check_in" for="x_check_in" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->check_in->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->check_in->CellAttributes() ?>>
<span id="el_hotel_booking_check_in">
<input type="text" data-table="hotel_booking" data-field="x_check_in" name="x_check_in" id="x_check_in" placeholder="<?php echo ew_HtmlEncode($hotel_booking->check_in->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->check_in->EditValue ?>"<?php echo $hotel_booking->check_in->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->check_in->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
	<div id="r_check_out" class="form-group">
		<label id="elh_hotel_booking_check_out" for="x_check_out" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->check_out->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->check_out->CellAttributes() ?>>
<span id="el_hotel_booking_check_out">
<input type="text" data-table="hotel_booking" data-field="x_check_out" name="x_check_out" id="x_check_out" placeholder="<?php echo ew_HtmlEncode($hotel_booking->check_out->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->check_out->EditValue ?>"<?php echo $hotel_booking->check_out->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->check_out->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
	<div id="r_max_day_stay" class="form-group">
		<label id="elh_hotel_booking_max_day_stay" for="x_max_day_stay" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->max_day_stay->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->max_day_stay->CellAttributes() ?>>
<span id="el_hotel_booking_max_day_stay">
<input type="text" data-table="hotel_booking" data-field="x_max_day_stay" name="x_max_day_stay" id="x_max_day_stay" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->max_day_stay->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->max_day_stay->EditValue ?>"<?php echo $hotel_booking->max_day_stay->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->max_day_stay->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
	<div id="r_total_amount" class="form-group">
		<label id="elh_hotel_booking_total_amount" for="x_total_amount" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->total_amount->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->total_amount->CellAttributes() ?>>
<span id="el_hotel_booking_total_amount">
<input type="text" data-table="hotel_booking" data-field="x_total_amount" name="x_total_amount" id="x_total_amount" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->total_amount->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->total_amount->EditValue ?>"<?php echo $hotel_booking->total_amount->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->total_amount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
	<div id="r_booking_status" class="form-group">
		<label id="elh_hotel_booking_booking_status" for="x_booking_status" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->booking_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->booking_status->CellAttributes() ?>>
<span id="el_hotel_booking_booking_status">
<input type="text" data-table="hotel_booking" data-field="x_booking_status" name="x_booking_status" id="x_booking_status" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_booking->booking_status->getPlaceHolder()) ?>" value="<?php echo $hotel_booking->booking_status->EditValue ?>"<?php echo $hotel_booking->booking_status->EditAttributes() ?>>
</span>
<?php echo $hotel_booking->booking_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_booking->notes->Visible) { // notes ?>
	<div id="r_notes" class="form-group">
		<label id="elh_hotel_booking_notes" for="x_notes" class="col-sm-2 control-label ewLabel"><?php echo $hotel_booking->notes->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_booking->notes->CellAttributes() ?>>
<span id="el_hotel_booking_notes">
<textarea data-table="hotel_booking" data-field="x_notes" name="x_notes" id="x_notes" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotel_booking->notes->getPlaceHolder()) ?>"<?php echo $hotel_booking->notes->EditAttributes() ?>><?php echo $hotel_booking->notes->EditValue ?></textarea>
</span>
<?php echo $hotel_booking->notes->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_booking_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_booking_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_bookingadd.Init();
</script>
<?php
$hotel_booking_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_booking_add->Page_Terminate();
?>

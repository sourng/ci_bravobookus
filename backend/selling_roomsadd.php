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

$selling_rooms_add = NULL; // Initialize page object first

class cselling_rooms_add extends cselling_rooms {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'selling_rooms';

	// Page object name
	var $PageObjName = 'selling_rooms_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("selling_roomslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
			if (@$_GET["sell_room_id"] != "") {
				$this->sell_room_id->setQueryStringValue($_GET["sell_room_id"]);
				$this->setKey("sell_room_id", $this->sell_room_id->CurrentValue); // Set up key
			} else {
				$this->setKey("sell_room_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["hroom_id"] != "") {
				$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
				$this->setKey("hroom_id", $this->hroom_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hroom_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["hotel_id"] != "") {
				$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
				$this->setKey("hotel_id", $this->hotel_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hotel_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["rt_id"] != "") {
				$this->rt_id->setQueryStringValue($_GET["rt_id"]);
				$this->setKey("rt_id", $this->rt_id->CurrentValue); // Set up key
			} else {
				$this->setKey("rt_id", ""); // Clear key
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
					$this->Page_Terminate("selling_roomslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "selling_roomslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "selling_roomsview.php")
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
		$this->hotel_id->CurrentValue = NULL;
		$this->hotel_id->OldValue = $this->hotel_id->CurrentValue;
		$this->rt_id->CurrentValue = NULL;
		$this->rt_id->OldValue = $this->rt_id->CurrentValue;
		$this->sell_date->CurrentValue = NULL;
		$this->sell_date->OldValue = $this->sell_date->CurrentValue;
		$this->day->CurrentValue = NULL;
		$this->day->OldValue = $this->day->CurrentValue;
		$this->month->CurrentValue = NULL;
		$this->month->OldValue = $this->month->CurrentValue;
		$this->year->CurrentValue = NULL;
		$this->year->OldValue = $this->year->CurrentValue;
		$this->max_people->CurrentValue = NULL;
		$this->max_people->OldValue = $this->max_people->CurrentValue;
		$this->base_rate->CurrentValue = NULL;
		$this->base_rate->OldValue = $this->base_rate->CurrentValue;
		$this->discount->CurrentValue = NULL;
		$this->discount->OldValue = $this->discount->CurrentValue;
		$this->room_sell->CurrentValue = NULL;
		$this->room_sell->OldValue = $this->room_sell->CurrentValue;
		$this->room_sold->CurrentValue = NULL;
		$this->room_sold->OldValue = $this->room_sold->CurrentValue;
		$this->room_closed->CurrentValue = NULL;
		$this->room_closed->OldValue = $this->room_closed->CurrentValue;
		$this->room_status->CurrentValue = NULL;
		$this->room_status->OldValue = $this->room_status->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->hroom_id->FldIsDetailKey) {
			$this->hroom_id->setFormValue($objForm->GetValue("x_hroom_id"));
		}
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->rt_id->FldIsDetailKey) {
			$this->rt_id->setFormValue($objForm->GetValue("x_rt_id"));
		}
		if (!$this->sell_date->FldIsDetailKey) {
			$this->sell_date->setFormValue($objForm->GetValue("x_sell_date"));
			$this->sell_date->CurrentValue = ew_UnFormatDateTime($this->sell_date->CurrentValue, 0);
		}
		if (!$this->day->FldIsDetailKey) {
			$this->day->setFormValue($objForm->GetValue("x_day"));
		}
		if (!$this->month->FldIsDetailKey) {
			$this->month->setFormValue($objForm->GetValue("x_month"));
		}
		if (!$this->year->FldIsDetailKey) {
			$this->year->setFormValue($objForm->GetValue("x_year"));
		}
		if (!$this->max_people->FldIsDetailKey) {
			$this->max_people->setFormValue($objForm->GetValue("x_max_people"));
		}
		if (!$this->base_rate->FldIsDetailKey) {
			$this->base_rate->setFormValue($objForm->GetValue("x_base_rate"));
		}
		if (!$this->discount->FldIsDetailKey) {
			$this->discount->setFormValue($objForm->GetValue("x_discount"));
		}
		if (!$this->room_sell->FldIsDetailKey) {
			$this->room_sell->setFormValue($objForm->GetValue("x_room_sell"));
		}
		if (!$this->room_sold->FldIsDetailKey) {
			$this->room_sold->setFormValue($objForm->GetValue("x_room_sold"));
		}
		if (!$this->room_closed->FldIsDetailKey) {
			$this->room_closed->setFormValue($objForm->GetValue("x_room_closed"));
		}
		if (!$this->room_status->FldIsDetailKey) {
			$this->room_status->setFormValue($objForm->GetValue("x_room_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->hroom_id->CurrentValue = $this->hroom_id->FormValue;
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->rt_id->CurrentValue = $this->rt_id->FormValue;
		$this->sell_date->CurrentValue = $this->sell_date->FormValue;
		$this->sell_date->CurrentValue = ew_UnFormatDateTime($this->sell_date->CurrentValue, 0);
		$this->day->CurrentValue = $this->day->FormValue;
		$this->month->CurrentValue = $this->month->FormValue;
		$this->year->CurrentValue = $this->year->FormValue;
		$this->max_people->CurrentValue = $this->max_people->FormValue;
		$this->base_rate->CurrentValue = $this->base_rate->FormValue;
		$this->discount->CurrentValue = $this->discount->FormValue;
		$this->room_sell->CurrentValue = $this->room_sell->FormValue;
		$this->room_sold->CurrentValue = $this->room_sold->FormValue;
		$this->room_closed->CurrentValue = $this->room_closed->FormValue;
		$this->room_status->CurrentValue = $this->room_status->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("sell_room_id")) <> "")
			$this->sell_room_id->CurrentValue = $this->getKey("sell_room_id"); // sell_room_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hroom_id")) <> "")
			$this->hroom_id->CurrentValue = $this->getKey("hroom_id"); // hroom_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hotel_id")) <> "")
			$this->hotel_id->CurrentValue = $this->getKey("hotel_id"); // hotel_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("rt_id")) <> "")
			$this->rt_id->CurrentValue = $this->getKey("rt_id"); // rt_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = ew_HtmlEncode($this->hroom_id->CurrentValue);
			$this->hroom_id->PlaceHolder = ew_RemoveHtml($this->hroom_id->FldCaption());

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->CurrentValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// rt_id
			$this->rt_id->EditAttrs["class"] = "form-control";
			$this->rt_id->EditCustomAttributes = "";
			$this->rt_id->EditValue = ew_HtmlEncode($this->rt_id->CurrentValue);
			$this->rt_id->PlaceHolder = ew_RemoveHtml($this->rt_id->FldCaption());

			// sell_date
			$this->sell_date->EditAttrs["class"] = "form-control";
			$this->sell_date->EditCustomAttributes = "";
			$this->sell_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sell_date->CurrentValue, 8));
			$this->sell_date->PlaceHolder = ew_RemoveHtml($this->sell_date->FldCaption());

			// day
			$this->day->EditAttrs["class"] = "form-control";
			$this->day->EditCustomAttributes = "";
			$this->day->EditValue = ew_HtmlEncode($this->day->CurrentValue);
			$this->day->PlaceHolder = ew_RemoveHtml($this->day->FldCaption());

			// month
			$this->month->EditAttrs["class"] = "form-control";
			$this->month->EditCustomAttributes = "";
			$this->month->EditValue = ew_HtmlEncode($this->month->CurrentValue);
			$this->month->PlaceHolder = ew_RemoveHtml($this->month->FldCaption());

			// year
			$this->year->EditAttrs["class"] = "form-control";
			$this->year->EditCustomAttributes = "";
			$this->year->EditValue = ew_HtmlEncode($this->year->CurrentValue);
			$this->year->PlaceHolder = ew_RemoveHtml($this->year->FldCaption());

			// max_people
			$this->max_people->EditAttrs["class"] = "form-control";
			$this->max_people->EditCustomAttributes = "";
			$this->max_people->EditValue = ew_HtmlEncode($this->max_people->CurrentValue);
			$this->max_people->PlaceHolder = ew_RemoveHtml($this->max_people->FldCaption());

			// base_rate
			$this->base_rate->EditAttrs["class"] = "form-control";
			$this->base_rate->EditCustomAttributes = "";
			$this->base_rate->EditValue = ew_HtmlEncode($this->base_rate->CurrentValue);
			$this->base_rate->PlaceHolder = ew_RemoveHtml($this->base_rate->FldCaption());
			if (strval($this->base_rate->EditValue) <> "" && is_numeric($this->base_rate->EditValue)) $this->base_rate->EditValue = ew_FormatNumber($this->base_rate->EditValue, -2, -1, -2, 0);

			// discount
			$this->discount->EditAttrs["class"] = "form-control";
			$this->discount->EditCustomAttributes = "";
			$this->discount->EditValue = ew_HtmlEncode($this->discount->CurrentValue);
			$this->discount->PlaceHolder = ew_RemoveHtml($this->discount->FldCaption());

			// room_sell
			$this->room_sell->EditAttrs["class"] = "form-control";
			$this->room_sell->EditCustomAttributes = "";
			$this->room_sell->EditValue = ew_HtmlEncode($this->room_sell->CurrentValue);
			$this->room_sell->PlaceHolder = ew_RemoveHtml($this->room_sell->FldCaption());

			// room_sold
			$this->room_sold->EditCustomAttributes = "";
			$this->room_sold->EditValue = $this->room_sold->Options(FALSE);

			// room_closed
			$this->room_closed->EditCustomAttributes = "";
			$this->room_closed->EditValue = $this->room_closed->Options(FALSE);

			// room_status
			$this->room_status->EditCustomAttributes = "";
			$this->room_status->EditValue = $this->room_status->Options(FALSE);

			// Add refer script
			// hroom_id

			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// rt_id
			$this->rt_id->LinkCustomAttributes = "";
			$this->rt_id->HrefValue = "";

			// sell_date
			$this->sell_date->LinkCustomAttributes = "";
			$this->sell_date->HrefValue = "";

			// day
			$this->day->LinkCustomAttributes = "";
			$this->day->HrefValue = "";

			// month
			$this->month->LinkCustomAttributes = "";
			$this->month->HrefValue = "";

			// year
			$this->year->LinkCustomAttributes = "";
			$this->year->HrefValue = "";

			// max_people
			$this->max_people->LinkCustomAttributes = "";
			$this->max_people->HrefValue = "";

			// base_rate
			$this->base_rate->LinkCustomAttributes = "";
			$this->base_rate->HrefValue = "";

			// discount
			$this->discount->LinkCustomAttributes = "";
			$this->discount->HrefValue = "";

			// room_sell
			$this->room_sell->LinkCustomAttributes = "";
			$this->room_sell->HrefValue = "";

			// room_sold
			$this->room_sold->LinkCustomAttributes = "";
			$this->room_sold->HrefValue = "";

			// room_closed
			$this->room_closed->LinkCustomAttributes = "";
			$this->room_closed->HrefValue = "";

			// room_status
			$this->room_status->LinkCustomAttributes = "";
			$this->room_status->HrefValue = "";
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
		if (!$this->hotel_id->FldIsDetailKey && !is_null($this->hotel_id->FormValue) && $this->hotel_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hotel_id->FldCaption(), $this->hotel_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hotel_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hotel_id->FldErrMsg());
		}
		if (!$this->rt_id->FldIsDetailKey && !is_null($this->rt_id->FormValue) && $this->rt_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->rt_id->FldCaption(), $this->rt_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->rt_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->rt_id->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->sell_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->sell_date->FldErrMsg());
		}
		if (!ew_CheckInteger($this->max_people->FormValue)) {
			ew_AddMessage($gsFormError, $this->max_people->FldErrMsg());
		}
		if (!ew_CheckNumber($this->base_rate->FormValue)) {
			ew_AddMessage($gsFormError, $this->base_rate->FldErrMsg());
		}
		if (!ew_CheckInteger($this->discount->FormValue)) {
			ew_AddMessage($gsFormError, $this->discount->FldErrMsg());
		}
		if (!ew_CheckInteger($this->room_sell->FormValue)) {
			ew_AddMessage($gsFormError, $this->room_sell->FldErrMsg());
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

		// hotel_id
		$this->hotel_id->SetDbValueDef($rsnew, $this->hotel_id->CurrentValue, 0, FALSE);

		// rt_id
		$this->rt_id->SetDbValueDef($rsnew, $this->rt_id->CurrentValue, 0, FALSE);

		// sell_date
		$this->sell_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sell_date->CurrentValue, 0), NULL, FALSE);

		// day
		$this->day->SetDbValueDef($rsnew, $this->day->CurrentValue, NULL, FALSE);

		// month
		$this->month->SetDbValueDef($rsnew, $this->month->CurrentValue, NULL, FALSE);

		// year
		$this->year->SetDbValueDef($rsnew, $this->year->CurrentValue, NULL, FALSE);

		// max_people
		$this->max_people->SetDbValueDef($rsnew, $this->max_people->CurrentValue, NULL, FALSE);

		// base_rate
		$this->base_rate->SetDbValueDef($rsnew, $this->base_rate->CurrentValue, NULL, FALSE);

		// discount
		$this->discount->SetDbValueDef($rsnew, $this->discount->CurrentValue, NULL, FALSE);

		// room_sell
		$this->room_sell->SetDbValueDef($rsnew, $this->room_sell->CurrentValue, NULL, FALSE);

		// room_sold
		$tmpBool = $this->room_sold->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->room_sold->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// room_closed
		$tmpBool = $this->room_closed->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->room_closed->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// room_status
		$tmpBool = $this->room_status->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->room_status->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hroom_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hotel_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['rt_id']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("selling_roomslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($selling_rooms_add)) $selling_rooms_add = new cselling_rooms_add();

// Page init
$selling_rooms_add->Page_Init();

// Page main
$selling_rooms_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$selling_rooms_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fselling_roomsadd = new ew_Form("fselling_roomsadd", "add");

// Validate form
fselling_roomsadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $selling_rooms->hroom_id->FldCaption(), $selling_rooms->hroom_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hroom_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->hroom_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $selling_rooms->hotel_id->FldCaption(), $selling_rooms->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->hotel_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rt_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $selling_rooms->rt_id->FldCaption(), $selling_rooms->rt_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rt_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->rt_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sell_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->sell_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_max_people");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->max_people->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_base_rate");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->base_rate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_discount");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->discount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_room_sell");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($selling_rooms->room_sell->FldErrMsg()) ?>");

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
fselling_roomsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fselling_roomsadd.ValidateRequired = true;
<?php } else { ?>
fselling_roomsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fselling_roomsadd.Lists["x_room_sold[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsadd.Lists["x_room_sold[]"].Options = <?php echo json_encode($selling_rooms->room_sold->Options()) ?>;
fselling_roomsadd.Lists["x_room_closed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsadd.Lists["x_room_closed[]"].Options = <?php echo json_encode($selling_rooms->room_closed->Options()) ?>;
fselling_roomsadd.Lists["x_room_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomsadd.Lists["x_room_status[]"].Options = <?php echo json_encode($selling_rooms->room_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$selling_rooms_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $selling_rooms_add->ShowPageHeader(); ?>
<?php
$selling_rooms_add->ShowMessage();
?>
<form name="fselling_roomsadd" id="fselling_roomsadd" class="<?php echo $selling_rooms_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($selling_rooms_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $selling_rooms_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="selling_rooms">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($selling_rooms_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($selling_rooms->hroom_id->Visible) { // hroom_id ?>
	<div id="r_hroom_id" class="form-group">
		<label id="elh_selling_rooms_hroom_id" for="x_hroom_id" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->hroom_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->hroom_id->CellAttributes() ?>>
<span id="el_selling_rooms_hroom_id">
<input type="text" data-table="selling_rooms" data-field="x_hroom_id" name="x_hroom_id" id="x_hroom_id" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->hroom_id->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->hroom_id->EditValue ?>"<?php echo $selling_rooms->hroom_id->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->hroom_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_selling_rooms_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->hotel_id->CellAttributes() ?>>
<span id="el_selling_rooms_hotel_id">
<input type="text" data-table="selling_rooms" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->hotel_id->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->hotel_id->EditValue ?>"<?php echo $selling_rooms->hotel_id->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->rt_id->Visible) { // rt_id ?>
	<div id="r_rt_id" class="form-group">
		<label id="elh_selling_rooms_rt_id" for="x_rt_id" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->rt_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->rt_id->CellAttributes() ?>>
<span id="el_selling_rooms_rt_id">
<input type="text" data-table="selling_rooms" data-field="x_rt_id" name="x_rt_id" id="x_rt_id" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->rt_id->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->rt_id->EditValue ?>"<?php echo $selling_rooms->rt_id->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->rt_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->sell_date->Visible) { // sell_date ?>
	<div id="r_sell_date" class="form-group">
		<label id="elh_selling_rooms_sell_date" for="x_sell_date" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->sell_date->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->sell_date->CellAttributes() ?>>
<span id="el_selling_rooms_sell_date">
<input type="text" data-table="selling_rooms" data-field="x_sell_date" name="x_sell_date" id="x_sell_date" placeholder="<?php echo ew_HtmlEncode($selling_rooms->sell_date->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->sell_date->EditValue ?>"<?php echo $selling_rooms->sell_date->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->sell_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->day->Visible) { // day ?>
	<div id="r_day" class="form-group">
		<label id="elh_selling_rooms_day" for="x_day" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->day->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->day->CellAttributes() ?>>
<span id="el_selling_rooms_day">
<input type="text" data-table="selling_rooms" data-field="x_day" name="x_day" id="x_day" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($selling_rooms->day->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->day->EditValue ?>"<?php echo $selling_rooms->day->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->day->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->month->Visible) { // month ?>
	<div id="r_month" class="form-group">
		<label id="elh_selling_rooms_month" for="x_month" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->month->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->month->CellAttributes() ?>>
<span id="el_selling_rooms_month">
<input type="text" data-table="selling_rooms" data-field="x_month" name="x_month" id="x_month" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($selling_rooms->month->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->month->EditValue ?>"<?php echo $selling_rooms->month->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->month->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->year->Visible) { // year ?>
	<div id="r_year" class="form-group">
		<label id="elh_selling_rooms_year" for="x_year" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->year->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->year->CellAttributes() ?>>
<span id="el_selling_rooms_year">
<input type="text" data-table="selling_rooms" data-field="x_year" name="x_year" id="x_year" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($selling_rooms->year->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->year->EditValue ?>"<?php echo $selling_rooms->year->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->year->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->max_people->Visible) { // max_people ?>
	<div id="r_max_people" class="form-group">
		<label id="elh_selling_rooms_max_people" for="x_max_people" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->max_people->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->max_people->CellAttributes() ?>>
<span id="el_selling_rooms_max_people">
<input type="text" data-table="selling_rooms" data-field="x_max_people" name="x_max_people" id="x_max_people" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->max_people->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->max_people->EditValue ?>"<?php echo $selling_rooms->max_people->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->max_people->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->base_rate->Visible) { // base_rate ?>
	<div id="r_base_rate" class="form-group">
		<label id="elh_selling_rooms_base_rate" for="x_base_rate" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->base_rate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->base_rate->CellAttributes() ?>>
<span id="el_selling_rooms_base_rate">
<input type="text" data-table="selling_rooms" data-field="x_base_rate" name="x_base_rate" id="x_base_rate" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->base_rate->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->base_rate->EditValue ?>"<?php echo $selling_rooms->base_rate->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->base_rate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->discount->Visible) { // discount ?>
	<div id="r_discount" class="form-group">
		<label id="elh_selling_rooms_discount" for="x_discount" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->discount->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->discount->CellAttributes() ?>>
<span id="el_selling_rooms_discount">
<input type="text" data-table="selling_rooms" data-field="x_discount" name="x_discount" id="x_discount" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->discount->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->discount->EditValue ?>"<?php echo $selling_rooms->discount->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->discount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->room_sell->Visible) { // room_sell ?>
	<div id="r_room_sell" class="form-group">
		<label id="elh_selling_rooms_room_sell" for="x_room_sell" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->room_sell->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->room_sell->CellAttributes() ?>>
<span id="el_selling_rooms_room_sell">
<input type="text" data-table="selling_rooms" data-field="x_room_sell" name="x_room_sell" id="x_room_sell" size="30" placeholder="<?php echo ew_HtmlEncode($selling_rooms->room_sell->getPlaceHolder()) ?>" value="<?php echo $selling_rooms->room_sell->EditValue ?>"<?php echo $selling_rooms->room_sell->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->room_sell->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
	<div id="r_room_sold" class="form-group">
		<label id="elh_selling_rooms_room_sold" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->room_sold->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->room_sold->CellAttributes() ?>>
<span id="el_selling_rooms_room_sold">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_sold->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_sold" name="x_room_sold[]" id="x_room_sold[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_sold->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->room_sold->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
	<div id="r_room_closed" class="form-group">
		<label id="elh_selling_rooms_room_closed" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->room_closed->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->room_closed->CellAttributes() ?>>
<span id="el_selling_rooms_room_closed">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_closed->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_closed" name="x_room_closed[]" id="x_room_closed[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_closed->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->room_closed->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
	<div id="r_room_status" class="form-group">
		<label id="elh_selling_rooms_room_status" class="col-sm-2 control-label ewLabel"><?php echo $selling_rooms->room_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $selling_rooms->room_status->CellAttributes() ?>>
<span id="el_selling_rooms_room_status">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_status" name="x_room_status[]" id="x_room_status[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_status->EditAttributes() ?>>
</span>
<?php echo $selling_rooms->room_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$selling_rooms_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $selling_rooms_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fselling_roomsadd.Init();
</script>
<?php
$selling_rooms_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$selling_rooms_add->Page_Terminate();
?>

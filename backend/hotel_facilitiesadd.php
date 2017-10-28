<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_facilitiesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_facilities_add = NULL; // Initialize page object first

class chotel_facilities_add extends chotel_facilities {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_facilities';

	// Page object name
	var $PageObjName = 'hotel_facilities_add';

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

		// Table object (hotel_facilities)
		if (!isset($GLOBALS["hotel_facilities"]) || get_class($GLOBALS["hotel_facilities"]) == "chotel_facilities") {
			$GLOBALS["hotel_facilities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_facilities"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_facilities', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hotel_id->SetVisibility();
		$this->hf_name->SetVisibility();
		$this->hf_image->SetVisibility();
		$this->hf_icons->SetVisibility();
		$this->status->SetVisibility();
		$this->hot_facilities->SetVisibility();

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
		global $EW_EXPORT, $hotel_facilities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_facilities);
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
			if (@$_GET["hfacility_id"] != "") {
				$this->hfacility_id->setQueryStringValue($_GET["hfacility_id"]);
				$this->setKey("hfacility_id", $this->hfacility_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hfacility_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["hotel_id"] != "") {
				$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
				$this->setKey("hotel_id", $this->hotel_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hotel_id", ""); // Clear key
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
					$this->Page_Terminate("hotel_facilitieslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "hotel_facilitieslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "hotel_facilitiesview.php")
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
		$this->hotel_id->CurrentValue = NULL;
		$this->hotel_id->OldValue = $this->hotel_id->CurrentValue;
		$this->hf_name->CurrentValue = NULL;
		$this->hf_name->OldValue = $this->hf_name->CurrentValue;
		$this->hf_image->CurrentValue = NULL;
		$this->hf_image->OldValue = $this->hf_image->CurrentValue;
		$this->hf_icons->CurrentValue = NULL;
		$this->hf_icons->OldValue = $this->hf_icons->CurrentValue;
		$this->status->CurrentValue = NULL;
		$this->status->OldValue = $this->status->CurrentValue;
		$this->hot_facilities->CurrentValue = "Y";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->hf_name->FldIsDetailKey) {
			$this->hf_name->setFormValue($objForm->GetValue("x_hf_name"));
		}
		if (!$this->hf_image->FldIsDetailKey) {
			$this->hf_image->setFormValue($objForm->GetValue("x_hf_image"));
		}
		if (!$this->hf_icons->FldIsDetailKey) {
			$this->hf_icons->setFormValue($objForm->GetValue("x_hf_icons"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->hot_facilities->FldIsDetailKey) {
			$this->hot_facilities->setFormValue($objForm->GetValue("x_hot_facilities"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->hf_name->CurrentValue = $this->hf_name->FormValue;
		$this->hf_image->CurrentValue = $this->hf_image->FormValue;
		$this->hf_icons->CurrentValue = $this->hf_icons->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->hot_facilities->CurrentValue = $this->hot_facilities->FormValue;
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
		$this->hfacility_id->setDbValue($rs->fields('hfacility_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->hf_name->setDbValue($rs->fields('hf_name'));
		$this->hf_image->setDbValue($rs->fields('hf_image'));
		$this->hf_icons->setDbValue($rs->fields('hf_icons'));
		$this->status->setDbValue($rs->fields('status'));
		$this->hot_facilities->setDbValue($rs->fields('hot_facilities'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hfacility_id->DbValue = $row['hfacility_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->hf_name->DbValue = $row['hf_name'];
		$this->hf_image->DbValue = $row['hf_image'];
		$this->hf_icons->DbValue = $row['hf_icons'];
		$this->status->DbValue = $row['status'];
		$this->hot_facilities->DbValue = $row['hot_facilities'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("hfacility_id")) <> "")
			$this->hfacility_id->CurrentValue = $this->getKey("hfacility_id"); // hfacility_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hotel_id")) <> "")
			$this->hotel_id->CurrentValue = $this->getKey("hotel_id"); // hotel_id
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// hfacility_id
		// hotel_id
		// hf_name
		// hf_image
		// hf_icons
		// status
		// hot_facilities

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hfacility_id
		$this->hfacility_id->ViewValue = $this->hfacility_id->CurrentValue;
		$this->hfacility_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hf_name
		$this->hf_name->ViewValue = $this->hf_name->CurrentValue;
		$this->hf_name->ViewCustomAttributes = "";

		// hf_image
		$this->hf_image->ViewValue = $this->hf_image->CurrentValue;
		$this->hf_image->ViewCustomAttributes = "";

		// hf_icons
		$this->hf_icons->ViewValue = $this->hf_icons->CurrentValue;
		$this->hf_icons->ViewCustomAttributes = "";

		// status
		if (ew_ConvertToBool($this->status->CurrentValue)) {
			$this->status->ViewValue = $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : "Y";
		} else {
			$this->status->ViewValue = $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : "N";
		}
		$this->status->ViewCustomAttributes = "";

		// hot_facilities
		if (ew_ConvertToBool($this->hot_facilities->CurrentValue)) {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(1) <> "" ? $this->hot_facilities->FldTagCaption(1) : "Y";
		} else {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(2) <> "" ? $this->hot_facilities->FldTagCaption(2) : "N";
		}
		$this->hot_facilities->ViewCustomAttributes = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// hf_name
			$this->hf_name->LinkCustomAttributes = "";
			$this->hf_name->HrefValue = "";
			$this->hf_name->TooltipValue = "";

			// hf_image
			$this->hf_image->LinkCustomAttributes = "";
			$this->hf_image->HrefValue = "";
			$this->hf_image->TooltipValue = "";

			// hf_icons
			$this->hf_icons->LinkCustomAttributes = "";
			$this->hf_icons->HrefValue = "";
			$this->hf_icons->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// hot_facilities
			$this->hot_facilities->LinkCustomAttributes = "";
			$this->hot_facilities->HrefValue = "";
			$this->hot_facilities->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->CurrentValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// hf_name
			$this->hf_name->EditAttrs["class"] = "form-control";
			$this->hf_name->EditCustomAttributes = "";
			$this->hf_name->EditValue = ew_HtmlEncode($this->hf_name->CurrentValue);
			$this->hf_name->PlaceHolder = ew_RemoveHtml($this->hf_name->FldCaption());

			// hf_image
			$this->hf_image->EditAttrs["class"] = "form-control";
			$this->hf_image->EditCustomAttributes = "";
			$this->hf_image->EditValue = ew_HtmlEncode($this->hf_image->CurrentValue);
			$this->hf_image->PlaceHolder = ew_RemoveHtml($this->hf_image->FldCaption());

			// hf_icons
			$this->hf_icons->EditAttrs["class"] = "form-control";
			$this->hf_icons->EditCustomAttributes = "";
			$this->hf_icons->EditValue = ew_HtmlEncode($this->hf_icons->CurrentValue);
			$this->hf_icons->PlaceHolder = ew_RemoveHtml($this->hf_icons->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// hot_facilities
			$this->hot_facilities->EditCustomAttributes = "";
			$this->hot_facilities->EditValue = $this->hot_facilities->Options(FALSE);

			// Add refer script
			// hotel_id

			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// hf_name
			$this->hf_name->LinkCustomAttributes = "";
			$this->hf_name->HrefValue = "";

			// hf_image
			$this->hf_image->LinkCustomAttributes = "";
			$this->hf_image->HrefValue = "";

			// hf_icons
			$this->hf_icons->LinkCustomAttributes = "";
			$this->hf_icons->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// hot_facilities
			$this->hot_facilities->LinkCustomAttributes = "";
			$this->hot_facilities->HrefValue = "";
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
		if (!$this->hotel_id->FldIsDetailKey && !is_null($this->hotel_id->FormValue) && $this->hotel_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hotel_id->FldCaption(), $this->hotel_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hotel_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hotel_id->FldErrMsg());
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

		// hotel_id
		$this->hotel_id->SetDbValueDef($rsnew, $this->hotel_id->CurrentValue, 0, FALSE);

		// hf_name
		$this->hf_name->SetDbValueDef($rsnew, $this->hf_name->CurrentValue, NULL, FALSE);

		// hf_image
		$this->hf_image->SetDbValueDef($rsnew, $this->hf_image->CurrentValue, NULL, FALSE);

		// hf_icons
		$this->hf_icons->SetDbValueDef($rsnew, $this->hf_icons->CurrentValue, NULL, FALSE);

		// status
		$tmpBool = $this->status->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->status->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

		// hot_facilities
		$tmpBool = $this->hot_facilities->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->hot_facilities->SetDbValueDef($rsnew, $tmpBool, NULL, strval($this->hot_facilities->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hotel_id']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_facilitieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_facilities_add)) $hotel_facilities_add = new chotel_facilities_add();

// Page init
$hotel_facilities_add->Page_Init();

// Page main
$hotel_facilities_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_facilities_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhotel_facilitiesadd = new ew_Form("fhotel_facilitiesadd", "add");

// Validate form
fhotel_facilitiesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_facilities->hotel_id->FldCaption(), $hotel_facilities->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_facilities->hotel_id->FldErrMsg()) ?>");

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
fhotel_facilitiesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_facilitiesadd.ValidateRequired = true;
<?php } else { ?>
fhotel_facilitiesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotel_facilitiesadd.Lists["x_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesadd.Lists["x_status[]"].Options = <?php echo json_encode($hotel_facilities->status->Options()) ?>;
fhotel_facilitiesadd.Lists["x_hot_facilities[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesadd.Lists["x_hot_facilities[]"].Options = <?php echo json_encode($hotel_facilities->hot_facilities->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_facilities_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_facilities_add->ShowPageHeader(); ?>
<?php
$hotel_facilities_add->ShowMessage();
?>
<form name="fhotel_facilitiesadd" id="fhotel_facilitiesadd" class="<?php echo $hotel_facilities_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_facilities_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_facilities_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_facilities">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($hotel_facilities_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_facilities->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_hotel_facilities_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hotel_id->CellAttributes() ?>>
<span id="el_hotel_facilities_hotel_id">
<input type="text" data-table="hotel_facilities" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hotel_id->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hotel_id->EditValue ?>"<?php echo $hotel_facilities->hotel_id->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_name->Visible) { // hf_name ?>
	<div id="r_hf_name" class="form-group">
		<label id="elh_hotel_facilities_hf_name" for="x_hf_name" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_name->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_name">
<input type="text" data-table="hotel_facilities" data-field="x_hf_name" name="x_hf_name" id="x_hf_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_name->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_name->EditValue ?>"<?php echo $hotel_facilities->hf_name->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_image->Visible) { // hf_image ?>
	<div id="r_hf_image" class="form-group">
		<label id="elh_hotel_facilities_hf_image" for="x_hf_image" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_image->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_image">
<input type="text" data-table="hotel_facilities" data-field="x_hf_image" name="x_hf_image" id="x_hf_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_image->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_image->EditValue ?>"<?php echo $hotel_facilities->hf_image->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_icons->Visible) { // hf_icons ?>
	<div id="r_hf_icons" class="form-group">
		<label id="elh_hotel_facilities_hf_icons" for="x_hf_icons" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_icons->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_icons->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_icons">
<input type="text" data-table="hotel_facilities" data-field="x_hf_icons" name="x_hf_icons" id="x_hf_icons" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_icons->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_icons->EditValue ?>"<?php echo $hotel_facilities->hf_icons->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_icons->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_hotel_facilities_status" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->status->CellAttributes() ?>>
<span id="el_hotel_facilities_status">
<?php
$selwrk = (ew_ConvertToBool($hotel_facilities->status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_facilities" data-field="x_status" name="x_status[]" id="x_status[]" value="1"<?php echo $selwrk ?><?php echo $hotel_facilities->status->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hot_facilities->Visible) { // hot_facilities ?>
	<div id="r_hot_facilities" class="form-group">
		<label id="elh_hotel_facilities_hot_facilities" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hot_facilities->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hot_facilities->CellAttributes() ?>>
<span id="el_hotel_facilities_hot_facilities">
<?php
$selwrk = (ew_ConvertToBool($hotel_facilities->hot_facilities->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_facilities" data-field="x_hot_facilities" name="x_hot_facilities[]" id="x_hot_facilities[]" value="1"<?php echo $selwrk ?><?php echo $hotel_facilities->hot_facilities->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hot_facilities->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_facilities_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_facilities_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_facilitiesadd.Init();
</script>
<?php
$hotel_facilities_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_facilities_add->Page_Terminate();
?>

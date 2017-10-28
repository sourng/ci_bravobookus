<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "servicesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$services_add = NULL; // Initialize page object first

class cservices_add extends cservices {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'services';

	// Page object name
	var $PageObjName = 'services_add';

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

		// Table object (services)
		if (!isset($GLOBALS["services"]) || get_class($GLOBALS["services"]) == "cservices") {
			$GLOBALS["services"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["services"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'services', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("serviceslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->service_name->SetVisibility();
		$this->service_desc->SetVisibility();
		$this->service_icon->SetVisibility();
		$this->service_image->SetVisibility();
		$this->service_link->SetVisibility();
		$this->status->SetVisibility();

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
		global $EW_EXPORT, $services;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($services);
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
			if (@$_GET["service_id"] != "") {
				$this->service_id->setQueryStringValue($_GET["service_id"]);
				$this->setKey("service_id", $this->service_id->CurrentValue); // Set up key
			} else {
				$this->setKey("service_id", ""); // Clear key
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
					$this->Page_Terminate("serviceslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "serviceslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "servicesview.php")
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
		$this->service_name->CurrentValue = NULL;
		$this->service_name->OldValue = $this->service_name->CurrentValue;
		$this->service_desc->CurrentValue = NULL;
		$this->service_desc->OldValue = $this->service_desc->CurrentValue;
		$this->service_icon->CurrentValue = NULL;
		$this->service_icon->OldValue = $this->service_icon->CurrentValue;
		$this->service_image->CurrentValue = NULL;
		$this->service_image->OldValue = $this->service_image->CurrentValue;
		$this->service_link->CurrentValue = "#";
		$this->status->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->service_name->FldIsDetailKey) {
			$this->service_name->setFormValue($objForm->GetValue("x_service_name"));
		}
		if (!$this->service_desc->FldIsDetailKey) {
			$this->service_desc->setFormValue($objForm->GetValue("x_service_desc"));
		}
		if (!$this->service_icon->FldIsDetailKey) {
			$this->service_icon->setFormValue($objForm->GetValue("x_service_icon"));
		}
		if (!$this->service_image->FldIsDetailKey) {
			$this->service_image->setFormValue($objForm->GetValue("x_service_image"));
		}
		if (!$this->service_link->FldIsDetailKey) {
			$this->service_link->setFormValue($objForm->GetValue("x_service_link"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->service_name->CurrentValue = $this->service_name->FormValue;
		$this->service_desc->CurrentValue = $this->service_desc->FormValue;
		$this->service_icon->CurrentValue = $this->service_icon->FormValue;
		$this->service_image->CurrentValue = $this->service_image->FormValue;
		$this->service_link->CurrentValue = $this->service_link->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->service_id->setDbValue($rs->fields('service_id'));
		$this->service_name->setDbValue($rs->fields('service_name'));
		$this->service_desc->setDbValue($rs->fields('service_desc'));
		$this->service_icon->setDbValue($rs->fields('service_icon'));
		$this->service_image->setDbValue($rs->fields('service_image'));
		$this->service_link->setDbValue($rs->fields('service_link'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->service_id->DbValue = $row['service_id'];
		$this->service_name->DbValue = $row['service_name'];
		$this->service_desc->DbValue = $row['service_desc'];
		$this->service_icon->DbValue = $row['service_icon'];
		$this->service_image->DbValue = $row['service_image'];
		$this->service_link->DbValue = $row['service_link'];
		$this->status->DbValue = $row['status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("service_id")) <> "")
			$this->service_id->CurrentValue = $this->getKey("service_id"); // service_id
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
		// service_id
		// service_name
		// service_desc
		// service_icon
		// service_image
		// service_link
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// service_id
		$this->service_id->ViewValue = $this->service_id->CurrentValue;
		$this->service_id->ViewCustomAttributes = "";

		// service_name
		$this->service_name->ViewValue = $this->service_name->CurrentValue;
		$this->service_name->ViewCustomAttributes = "";

		// service_desc
		$this->service_desc->ViewValue = $this->service_desc->CurrentValue;
		$this->service_desc->ViewCustomAttributes = "";

		// service_icon
		$this->service_icon->ViewValue = $this->service_icon->CurrentValue;
		$this->service_icon->ViewCustomAttributes = "";

		// service_image
		$this->service_image->ViewValue = $this->service_image->CurrentValue;
		$this->service_image->ViewCustomAttributes = "";

		// service_link
		$this->service_link->ViewValue = $this->service_link->CurrentValue;
		$this->service_link->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

			// service_name
			$this->service_name->LinkCustomAttributes = "";
			$this->service_name->HrefValue = "";
			$this->service_name->TooltipValue = "";

			// service_desc
			$this->service_desc->LinkCustomAttributes = "";
			$this->service_desc->HrefValue = "";
			$this->service_desc->TooltipValue = "";

			// service_icon
			$this->service_icon->LinkCustomAttributes = "";
			$this->service_icon->HrefValue = "";
			$this->service_icon->TooltipValue = "";

			// service_image
			$this->service_image->LinkCustomAttributes = "";
			$this->service_image->HrefValue = "";
			$this->service_image->TooltipValue = "";

			// service_link
			$this->service_link->LinkCustomAttributes = "";
			$this->service_link->HrefValue = "";
			$this->service_link->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// service_name
			$this->service_name->EditAttrs["class"] = "form-control";
			$this->service_name->EditCustomAttributes = "";
			$this->service_name->EditValue = ew_HtmlEncode($this->service_name->CurrentValue);
			$this->service_name->PlaceHolder = ew_RemoveHtml($this->service_name->FldCaption());

			// service_desc
			$this->service_desc->EditAttrs["class"] = "form-control";
			$this->service_desc->EditCustomAttributes = "";
			$this->service_desc->EditValue = ew_HtmlEncode($this->service_desc->CurrentValue);
			$this->service_desc->PlaceHolder = ew_RemoveHtml($this->service_desc->FldCaption());

			// service_icon
			$this->service_icon->EditAttrs["class"] = "form-control";
			$this->service_icon->EditCustomAttributes = "";
			$this->service_icon->EditValue = ew_HtmlEncode($this->service_icon->CurrentValue);
			$this->service_icon->PlaceHolder = ew_RemoveHtml($this->service_icon->FldCaption());

			// service_image
			$this->service_image->EditAttrs["class"] = "form-control";
			$this->service_image->EditCustomAttributes = "";
			$this->service_image->EditValue = ew_HtmlEncode($this->service_image->CurrentValue);
			$this->service_image->PlaceHolder = ew_RemoveHtml($this->service_image->FldCaption());

			// service_link
			$this->service_link->EditAttrs["class"] = "form-control";
			$this->service_link->EditCustomAttributes = "";
			$this->service_link->EditValue = ew_HtmlEncode($this->service_link->CurrentValue);
			$this->service_link->PlaceHolder = ew_RemoveHtml($this->service_link->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// Add refer script
			// service_name

			$this->service_name->LinkCustomAttributes = "";
			$this->service_name->HrefValue = "";

			// service_desc
			$this->service_desc->LinkCustomAttributes = "";
			$this->service_desc->HrefValue = "";

			// service_icon
			$this->service_icon->LinkCustomAttributes = "";
			$this->service_icon->HrefValue = "";

			// service_image
			$this->service_image->LinkCustomAttributes = "";
			$this->service_image->HrefValue = "";

			// service_link
			$this->service_link->LinkCustomAttributes = "";
			$this->service_link->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
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
		if (!ew_CheckInteger($this->status->FormValue)) {
			ew_AddMessage($gsFormError, $this->status->FldErrMsg());
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

		// service_name
		$this->service_name->SetDbValueDef($rsnew, $this->service_name->CurrentValue, NULL, FALSE);

		// service_desc
		$this->service_desc->SetDbValueDef($rsnew, $this->service_desc->CurrentValue, NULL, FALSE);

		// service_icon
		$this->service_icon->SetDbValueDef($rsnew, $this->service_icon->CurrentValue, NULL, FALSE);

		// service_image
		$this->service_image->SetDbValueDef($rsnew, $this->service_image->CurrentValue, NULL, FALSE);

		// service_link
		$this->service_link->SetDbValueDef($rsnew, $this->service_link->CurrentValue, NULL, strval($this->service_link->CurrentValue) == "");

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, strval($this->status->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("serviceslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($services_add)) $services_add = new cservices_add();

// Page init
$services_add->Page_Init();

// Page main
$services_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$services_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fservicesadd = new ew_Form("fservicesadd", "add");

// Validate form
fservicesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($services->status->FldErrMsg()) ?>");

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
fservicesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fservicesadd.ValidateRequired = true;
<?php } else { ?>
fservicesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$services_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $services_add->ShowPageHeader(); ?>
<?php
$services_add->ShowMessage();
?>
<form name="fservicesadd" id="fservicesadd" class="<?php echo $services_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($services_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $services_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="services">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($services_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($services->service_name->Visible) { // service_name ?>
	<div id="r_service_name" class="form-group">
		<label id="elh_services_service_name" for="x_service_name" class="col-sm-2 control-label ewLabel"><?php echo $services->service_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_name->CellAttributes() ?>>
<span id="el_services_service_name">
<input type="text" data-table="services" data-field="x_service_name" name="x_service_name" id="x_service_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($services->service_name->getPlaceHolder()) ?>" value="<?php echo $services->service_name->EditValue ?>"<?php echo $services->service_name->EditAttributes() ?>>
</span>
<?php echo $services->service_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_desc->Visible) { // service_desc ?>
	<div id="r_service_desc" class="form-group">
		<label id="elh_services_service_desc" for="x_service_desc" class="col-sm-2 control-label ewLabel"><?php echo $services->service_desc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_desc->CellAttributes() ?>>
<span id="el_services_service_desc">
<input type="text" data-table="services" data-field="x_service_desc" name="x_service_desc" id="x_service_desc" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($services->service_desc->getPlaceHolder()) ?>" value="<?php echo $services->service_desc->EditValue ?>"<?php echo $services->service_desc->EditAttributes() ?>>
</span>
<?php echo $services->service_desc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_icon->Visible) { // service_icon ?>
	<div id="r_service_icon" class="form-group">
		<label id="elh_services_service_icon" for="x_service_icon" class="col-sm-2 control-label ewLabel"><?php echo $services->service_icon->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_icon->CellAttributes() ?>>
<span id="el_services_service_icon">
<input type="text" data-table="services" data-field="x_service_icon" name="x_service_icon" id="x_service_icon" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($services->service_icon->getPlaceHolder()) ?>" value="<?php echo $services->service_icon->EditValue ?>"<?php echo $services->service_icon->EditAttributes() ?>>
</span>
<?php echo $services->service_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_image->Visible) { // service_image ?>
	<div id="r_service_image" class="form-group">
		<label id="elh_services_service_image" for="x_service_image" class="col-sm-2 control-label ewLabel"><?php echo $services->service_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_image->CellAttributes() ?>>
<span id="el_services_service_image">
<input type="text" data-table="services" data-field="x_service_image" name="x_service_image" id="x_service_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($services->service_image->getPlaceHolder()) ?>" value="<?php echo $services->service_image->EditValue ?>"<?php echo $services->service_image->EditAttributes() ?>>
</span>
<?php echo $services->service_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->service_link->Visible) { // service_link ?>
	<div id="r_service_link" class="form-group">
		<label id="elh_services_service_link" for="x_service_link" class="col-sm-2 control-label ewLabel"><?php echo $services->service_link->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->service_link->CellAttributes() ?>>
<span id="el_services_service_link">
<input type="text" data-table="services" data-field="x_service_link" name="x_service_link" id="x_service_link" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($services->service_link->getPlaceHolder()) ?>" value="<?php echo $services->service_link->EditValue ?>"<?php echo $services->service_link->EditAttributes() ?>>
</span>
<?php echo $services->service_link->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($services->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_services_status" for="x_status" class="col-sm-2 control-label ewLabel"><?php echo $services->status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $services->status->CellAttributes() ?>>
<span id="el_services_status">
<input type="text" data-table="services" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?php echo ew_HtmlEncode($services->status->getPlaceHolder()) ?>" value="<?php echo $services->status->EditValue ?>"<?php echo $services->status->EditAttributes() ?>>
</span>
<?php echo $services->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$services_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $services_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fservicesadd.Init();
</script>
<?php
$services_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$services_add->Page_Terminate();
?>

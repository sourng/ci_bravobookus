<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "room_typesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$room_types_add = NULL; // Initialize page object first

class croom_types_add extends croom_types {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'room_types';

	// Page object name
	var $PageObjName = 'room_types_add';

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

		// Table object (room_types)
		if (!isset($GLOBALS["room_types"]) || get_class($GLOBALS["room_types"]) == "croom_types") {
			$GLOBALS["room_types"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["room_types"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'room_types', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("room_typeslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->rt_name->SetVisibility();
		$this->rt_image->SetVisibility();
		$this->rt_note->SetVisibility();
		$this->rt_status->SetVisibility();

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
		global $EW_EXPORT, $room_types;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($room_types);
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
					$this->Page_Terminate("room_typeslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "room_typeslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "room_typesview.php")
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
		$this->rt_name->CurrentValue = NULL;
		$this->rt_name->OldValue = $this->rt_name->CurrentValue;
		$this->rt_image->CurrentValue = NULL;
		$this->rt_image->OldValue = $this->rt_image->CurrentValue;
		$this->rt_note->CurrentValue = NULL;
		$this->rt_note->OldValue = $this->rt_note->CurrentValue;
		$this->rt_status->CurrentValue = NULL;
		$this->rt_status->OldValue = $this->rt_status->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->rt_name->FldIsDetailKey) {
			$this->rt_name->setFormValue($objForm->GetValue("x_rt_name"));
		}
		if (!$this->rt_image->FldIsDetailKey) {
			$this->rt_image->setFormValue($objForm->GetValue("x_rt_image"));
		}
		if (!$this->rt_note->FldIsDetailKey) {
			$this->rt_note->setFormValue($objForm->GetValue("x_rt_note"));
		}
		if (!$this->rt_status->FldIsDetailKey) {
			$this->rt_status->setFormValue($objForm->GetValue("x_rt_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->rt_name->CurrentValue = $this->rt_name->FormValue;
		$this->rt_image->CurrentValue = $this->rt_image->FormValue;
		$this->rt_note->CurrentValue = $this->rt_note->FormValue;
		$this->rt_status->CurrentValue = $this->rt_status->FormValue;
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
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->rt_name->setDbValue($rs->fields('rt_name'));
		$this->rt_image->setDbValue($rs->fields('rt_image'));
		$this->rt_note->setDbValue($rs->fields('rt_note'));
		$this->rt_status->setDbValue($rs->fields('rt_status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->rt_id->DbValue = $row['rt_id'];
		$this->rt_name->DbValue = $row['rt_name'];
		$this->rt_image->DbValue = $row['rt_image'];
		$this->rt_note->DbValue = $row['rt_note'];
		$this->rt_status->DbValue = $row['rt_status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// rt_id
		// rt_name
		// rt_image
		// rt_note
		// rt_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// rt_name
		$this->rt_name->ViewValue = $this->rt_name->CurrentValue;
		$this->rt_name->ViewCustomAttributes = "";

		// rt_image
		$this->rt_image->ViewValue = $this->rt_image->CurrentValue;
		$this->rt_image->ViewCustomAttributes = "";

		// rt_note
		$this->rt_note->ViewValue = $this->rt_note->CurrentValue;
		$this->rt_note->ViewCustomAttributes = "";

		// rt_status
		if (ew_ConvertToBool($this->rt_status->CurrentValue)) {
			$this->rt_status->ViewValue = $this->rt_status->FldTagCaption(1) <> "" ? $this->rt_status->FldTagCaption(1) : "Y";
		} else {
			$this->rt_status->ViewValue = $this->rt_status->FldTagCaption(2) <> "" ? $this->rt_status->FldTagCaption(2) : "N";
		}
		$this->rt_status->ViewCustomAttributes = "";

			// rt_name
			$this->rt_name->LinkCustomAttributes = "";
			$this->rt_name->HrefValue = "";
			$this->rt_name->TooltipValue = "";

			// rt_image
			$this->rt_image->LinkCustomAttributes = "";
			$this->rt_image->HrefValue = "";
			$this->rt_image->TooltipValue = "";

			// rt_note
			$this->rt_note->LinkCustomAttributes = "";
			$this->rt_note->HrefValue = "";
			$this->rt_note->TooltipValue = "";

			// rt_status
			$this->rt_status->LinkCustomAttributes = "";
			$this->rt_status->HrefValue = "";
			$this->rt_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// rt_name
			$this->rt_name->EditAttrs["class"] = "form-control";
			$this->rt_name->EditCustomAttributes = "";
			$this->rt_name->EditValue = ew_HtmlEncode($this->rt_name->CurrentValue);
			$this->rt_name->PlaceHolder = ew_RemoveHtml($this->rt_name->FldCaption());

			// rt_image
			$this->rt_image->EditAttrs["class"] = "form-control";
			$this->rt_image->EditCustomAttributes = "";
			$this->rt_image->EditValue = ew_HtmlEncode($this->rt_image->CurrentValue);
			$this->rt_image->PlaceHolder = ew_RemoveHtml($this->rt_image->FldCaption());

			// rt_note
			$this->rt_note->EditAttrs["class"] = "form-control";
			$this->rt_note->EditCustomAttributes = "";
			$this->rt_note->EditValue = ew_HtmlEncode($this->rt_note->CurrentValue);
			$this->rt_note->PlaceHolder = ew_RemoveHtml($this->rt_note->FldCaption());

			// rt_status
			$this->rt_status->EditCustomAttributes = "";
			$this->rt_status->EditValue = $this->rt_status->Options(FALSE);

			// Add refer script
			// rt_name

			$this->rt_name->LinkCustomAttributes = "";
			$this->rt_name->HrefValue = "";

			// rt_image
			$this->rt_image->LinkCustomAttributes = "";
			$this->rt_image->HrefValue = "";

			// rt_note
			$this->rt_note->LinkCustomAttributes = "";
			$this->rt_note->HrefValue = "";

			// rt_status
			$this->rt_status->LinkCustomAttributes = "";
			$this->rt_status->HrefValue = "";
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

		// rt_name
		$this->rt_name->SetDbValueDef($rsnew, $this->rt_name->CurrentValue, NULL, FALSE);

		// rt_image
		$this->rt_image->SetDbValueDef($rsnew, $this->rt_image->CurrentValue, NULL, FALSE);

		// rt_note
		$this->rt_note->SetDbValueDef($rsnew, $this->rt_note->CurrentValue, NULL, FALSE);

		// rt_status
		$tmpBool = $this->rt_status->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->rt_status->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("room_typeslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($room_types_add)) $room_types_add = new croom_types_add();

// Page init
$room_types_add->Page_Init();

// Page main
$room_types_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$room_types_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = froom_typesadd = new ew_Form("froom_typesadd", "add");

// Validate form
froom_typesadd.Validate = function() {
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
froom_typesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
froom_typesadd.ValidateRequired = true;
<?php } else { ?>
froom_typesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
froom_typesadd.Lists["x_rt_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
froom_typesadd.Lists["x_rt_status[]"].Options = <?php echo json_encode($room_types->rt_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$room_types_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $room_types_add->ShowPageHeader(); ?>
<?php
$room_types_add->ShowMessage();
?>
<form name="froom_typesadd" id="froom_typesadd" class="<?php echo $room_types_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($room_types_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $room_types_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="room_types">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($room_types_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($room_types->rt_name->Visible) { // rt_name ?>
	<div id="r_rt_name" class="form-group">
		<label id="elh_room_types_rt_name" for="x_rt_name" class="col-sm-2 control-label ewLabel"><?php echo $room_types->rt_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $room_types->rt_name->CellAttributes() ?>>
<span id="el_room_types_rt_name">
<input type="text" data-table="room_types" data-field="x_rt_name" name="x_rt_name" id="x_rt_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($room_types->rt_name->getPlaceHolder()) ?>" value="<?php echo $room_types->rt_name->EditValue ?>"<?php echo $room_types->rt_name->EditAttributes() ?>>
</span>
<?php echo $room_types->rt_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($room_types->rt_image->Visible) { // rt_image ?>
	<div id="r_rt_image" class="form-group">
		<label id="elh_room_types_rt_image" for="x_rt_image" class="col-sm-2 control-label ewLabel"><?php echo $room_types->rt_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $room_types->rt_image->CellAttributes() ?>>
<span id="el_room_types_rt_image">
<input type="text" data-table="room_types" data-field="x_rt_image" name="x_rt_image" id="x_rt_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($room_types->rt_image->getPlaceHolder()) ?>" value="<?php echo $room_types->rt_image->EditValue ?>"<?php echo $room_types->rt_image->EditAttributes() ?>>
</span>
<?php echo $room_types->rt_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($room_types->rt_note->Visible) { // rt_note ?>
	<div id="r_rt_note" class="form-group">
		<label id="elh_room_types_rt_note" for="x_rt_note" class="col-sm-2 control-label ewLabel"><?php echo $room_types->rt_note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $room_types->rt_note->CellAttributes() ?>>
<span id="el_room_types_rt_note">
<input type="text" data-table="room_types" data-field="x_rt_note" name="x_rt_note" id="x_rt_note" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($room_types->rt_note->getPlaceHolder()) ?>" value="<?php echo $room_types->rt_note->EditValue ?>"<?php echo $room_types->rt_note->EditAttributes() ?>>
</span>
<?php echo $room_types->rt_note->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($room_types->rt_status->Visible) { // rt_status ?>
	<div id="r_rt_status" class="form-group">
		<label id="elh_room_types_rt_status" class="col-sm-2 control-label ewLabel"><?php echo $room_types->rt_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $room_types->rt_status->CellAttributes() ?>>
<span id="el_room_types_rt_status">
<?php
$selwrk = (ew_ConvertToBool($room_types->rt_status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="room_types" data-field="x_rt_status" name="x_rt_status[]" id="x_rt_status[]" value="1"<?php echo $selwrk ?><?php echo $room_types->rt_status->EditAttributes() ?>>
</span>
<?php echo $room_types->rt_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$room_types_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $room_types_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
froom_typesadd.Init();
</script>
<?php
$room_types_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$room_types_add->Page_Terminate();
?>

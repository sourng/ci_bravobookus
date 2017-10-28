<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "destinationsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$destinations_addopt = NULL; // Initialize page object first

class cdestinations_addopt extends cdestinations {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = "{19C2E4CA-82BD-4916-B125-639D5C0DB456}";

	// Table name
	var $TableName = 'destinations';

	// Page object name
	var $PageObjName = 'destinations_addopt';

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

		// Table object (destinations)
		if (!isset($GLOBALS["destinations"]) || get_class($GLOBALS["destinations"]) == "cdestinations") {
			$GLOBALS["destinations"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["destinations"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'destinations', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("destinationslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->destinations->SetVisibility();
		$this->dest_landmark->SetVisibility();
		$this->dest_description->SetVisibility();
		$this->dest_interest->SetVisibility();
		$this->thing_todo->SetVisibility();
		$this->country->SetVisibility();

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
		global $EW_EXPORT, $destinations;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($destinations);
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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Set up Breadcrumb
		//$this->SetupBreadcrumb(); // Not used
		// Process form if post back

		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_dest_id"] = $this->dest_id->DbValue;
					$row["x_destinations"] = $this->destinations->DbValue;
					$row["x_dest_landmark"] = $this->dest_landmark->DbValue;
					$row["x_dest_description"] = $this->dest_description->DbValue;
					$row["x_dest_interest"] = $this->dest_interest->DbValue;
					$row["x_thing_todo"] = $this->thing_todo->DbValue;
					$row["x_country"] = $this->country->DbValue;
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
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
		$this->destinations->CurrentValue = NULL;
		$this->destinations->OldValue = $this->destinations->CurrentValue;
		$this->dest_landmark->CurrentValue = NULL;
		$this->dest_landmark->OldValue = $this->dest_landmark->CurrentValue;
		$this->dest_description->CurrentValue = NULL;
		$this->dest_description->OldValue = $this->dest_description->CurrentValue;
		$this->dest_interest->CurrentValue = NULL;
		$this->dest_interest->OldValue = $this->dest_interest->CurrentValue;
		$this->thing_todo->CurrentValue = NULL;
		$this->thing_todo->OldValue = $this->thing_todo->CurrentValue;
		$this->country->CurrentValue = NULL;
		$this->country->OldValue = $this->country->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->destinations->FldIsDetailKey) {
			$this->destinations->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_destinations")));
		}
		if (!$this->dest_landmark->FldIsDetailKey) {
			$this->dest_landmark->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_dest_landmark")));
		}
		if (!$this->dest_description->FldIsDetailKey) {
			$this->dest_description->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_dest_description")));
		}
		if (!$this->dest_interest->FldIsDetailKey) {
			$this->dest_interest->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_dest_interest")));
		}
		if (!$this->thing_todo->FldIsDetailKey) {
			$this->thing_todo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_thing_todo")));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_country")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->destinations->CurrentValue = ew_ConvertToUtf8($this->destinations->FormValue);
		$this->dest_landmark->CurrentValue = ew_ConvertToUtf8($this->dest_landmark->FormValue);
		$this->dest_description->CurrentValue = ew_ConvertToUtf8($this->dest_description->FormValue);
		$this->dest_interest->CurrentValue = ew_ConvertToUtf8($this->dest_interest->FormValue);
		$this->thing_todo->CurrentValue = ew_ConvertToUtf8($this->thing_todo->FormValue);
		$this->country->CurrentValue = ew_ConvertToUtf8($this->country->FormValue);
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
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->destinations->setDbValue($rs->fields('destinations'));
		$this->dest_landmark->setDbValue($rs->fields('dest_landmark'));
		$this->dest_description->setDbValue($rs->fields('dest_description'));
		$this->dest_interest->setDbValue($rs->fields('dest_interest'));
		$this->thing_todo->setDbValue($rs->fields('thing_todo'));
		$this->country->setDbValue($rs->fields('country'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->dest_id->DbValue = $row['dest_id'];
		$this->destinations->DbValue = $row['destinations'];
		$this->dest_landmark->DbValue = $row['dest_landmark'];
		$this->dest_description->DbValue = $row['dest_description'];
		$this->dest_interest->DbValue = $row['dest_interest'];
		$this->thing_todo->DbValue = $row['thing_todo'];
		$this->country->DbValue = $row['country'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// dest_id
		// destinations
		// dest_landmark
		// dest_description
		// dest_interest
		// thing_todo
		// country

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// destinations
		$this->destinations->ViewValue = $this->destinations->CurrentValue;
		$this->destinations->ViewCustomAttributes = "";

		// dest_landmark
		$this->dest_landmark->ViewValue = $this->dest_landmark->CurrentValue;
		$this->dest_landmark->ViewCustomAttributes = "";

		// dest_description
		$this->dest_description->ViewValue = $this->dest_description->CurrentValue;
		$this->dest_description->ViewCustomAttributes = "";

		// dest_interest
		$this->dest_interest->ViewValue = $this->dest_interest->CurrentValue;
		$this->dest_interest->ViewCustomAttributes = "";

		// thing_todo
		$this->thing_todo->ViewValue = $this->thing_todo->CurrentValue;
		$this->thing_todo->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

			// destinations
			$this->destinations->LinkCustomAttributes = "";
			$this->destinations->HrefValue = "";
			$this->destinations->TooltipValue = "";

			// dest_landmark
			$this->dest_landmark->LinkCustomAttributes = "";
			$this->dest_landmark->HrefValue = "";
			$this->dest_landmark->TooltipValue = "";

			// dest_description
			$this->dest_description->LinkCustomAttributes = "";
			$this->dest_description->HrefValue = "";
			$this->dest_description->TooltipValue = "";

			// dest_interest
			$this->dest_interest->LinkCustomAttributes = "";
			$this->dest_interest->HrefValue = "";
			$this->dest_interest->TooltipValue = "";

			// thing_todo
			$this->thing_todo->LinkCustomAttributes = "";
			$this->thing_todo->HrefValue = "";
			$this->thing_todo->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// destinations
			$this->destinations->EditAttrs["class"] = "form-control";
			$this->destinations->EditCustomAttributes = "";
			$this->destinations->EditValue = ew_HtmlEncode($this->destinations->CurrentValue);
			$this->destinations->PlaceHolder = ew_RemoveHtml($this->destinations->FldCaption());

			// dest_landmark
			$this->dest_landmark->EditAttrs["class"] = "form-control";
			$this->dest_landmark->EditCustomAttributes = "";
			$this->dest_landmark->EditValue = ew_HtmlEncode($this->dest_landmark->CurrentValue);
			$this->dest_landmark->PlaceHolder = ew_RemoveHtml($this->dest_landmark->FldCaption());

			// dest_description
			$this->dest_description->EditAttrs["class"] = "form-control";
			$this->dest_description->EditCustomAttributes = "";
			$this->dest_description->EditValue = ew_HtmlEncode($this->dest_description->CurrentValue);
			$this->dest_description->PlaceHolder = ew_RemoveHtml($this->dest_description->FldCaption());

			// dest_interest
			$this->dest_interest->EditAttrs["class"] = "form-control";
			$this->dest_interest->EditCustomAttributes = "";
			$this->dest_interest->EditValue = ew_HtmlEncode($this->dest_interest->CurrentValue);
			$this->dest_interest->PlaceHolder = ew_RemoveHtml($this->dest_interest->FldCaption());

			// thing_todo
			$this->thing_todo->EditAttrs["class"] = "form-control";
			$this->thing_todo->EditCustomAttributes = "";
			$this->thing_todo->EditValue = ew_HtmlEncode($this->thing_todo->CurrentValue);
			$this->thing_todo->PlaceHolder = ew_RemoveHtml($this->thing_todo->FldCaption());

			// country
			$this->country->EditAttrs["class"] = "form-control";
			$this->country->EditCustomAttributes = "";
			$this->country->EditValue = ew_HtmlEncode($this->country->CurrentValue);
			$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

			// Add refer script
			// destinations

			$this->destinations->LinkCustomAttributes = "";
			$this->destinations->HrefValue = "";

			// dest_landmark
			$this->dest_landmark->LinkCustomAttributes = "";
			$this->dest_landmark->HrefValue = "";

			// dest_description
			$this->dest_description->LinkCustomAttributes = "";
			$this->dest_description->HrefValue = "";

			// dest_interest
			$this->dest_interest->LinkCustomAttributes = "";
			$this->dest_interest->HrefValue = "";

			// thing_todo
			$this->thing_todo->LinkCustomAttributes = "";
			$this->thing_todo->HrefValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
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

		// destinations
		$this->destinations->SetDbValueDef($rsnew, $this->destinations->CurrentValue, NULL, FALSE);

		// dest_landmark
		$this->dest_landmark->SetDbValueDef($rsnew, $this->dest_landmark->CurrentValue, NULL, FALSE);

		// dest_description
		$this->dest_description->SetDbValueDef($rsnew, $this->dest_description->CurrentValue, NULL, FALSE);

		// dest_interest
		$this->dest_interest->SetDbValueDef($rsnew, $this->dest_interest->CurrentValue, NULL, FALSE);

		// thing_todo
		$this->thing_todo->SetDbValueDef($rsnew, $this->thing_todo->CurrentValue, NULL, FALSE);

		// country
		$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("destinationslist.php"), "", $this->TableVar, TRUE);
		$PageId = "addopt";
		$Breadcrumb->Add("addopt", $PageId, $url);
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

	// Custom validate event
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
if (!isset($destinations_addopt)) $destinations_addopt = new cdestinations_addopt();

// Page init
$destinations_addopt->Page_Init();

// Page main
$destinations_addopt->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$destinations_addopt->Page_Render();
?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "addopt";
var CurrentForm = fdestinationsaddopt = new ew_Form("fdestinationsaddopt", "addopt");

// Validate form
fdestinationsaddopt.Validate = function() {
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
	return true;
}

// Form_CustomValidate event
fdestinationsaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdestinationsaddopt.ValidateRequired = true;
<?php } else { ?>
fdestinationsaddopt.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$destinations_addopt->ShowMessage();
?>
<form name="fdestinationsaddopt" id="fdestinationsaddopt" class="ewForm form-horizontal" action="destinationsaddopt.php" method="post">
<?php if ($destinations_addopt->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $destinations_addopt->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="destinations">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<?php if ($destinations->destinations->Visible) { // destinations ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_destinations"><?php echo $destinations->destinations->FldCaption() ?></label>
		<div class="col-sm-9">
<input type="text" data-table="destinations" data-field="x_destinations" name="x_destinations" id="x_destinations" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->destinations->getPlaceHolder()) ?>" value="<?php echo $destinations->destinations->EditValue ?>"<?php echo $destinations->destinations->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($destinations->dest_landmark->Visible) { // dest_landmark ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_dest_landmark"><?php echo $destinations->dest_landmark->FldCaption() ?></label>
		<div class="col-sm-9">
<input type="text" data-table="destinations" data-field="x_dest_landmark" name="x_dest_landmark" id="x_dest_landmark" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->dest_landmark->getPlaceHolder()) ?>" value="<?php echo $destinations->dest_landmark->EditValue ?>"<?php echo $destinations->dest_landmark->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($destinations->dest_description->Visible) { // dest_description ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_dest_description"><?php echo $destinations->dest_description->FldCaption() ?></label>
		<div class="col-sm-9">
<input type="text" data-table="destinations" data-field="x_dest_description" name="x_dest_description" id="x_dest_description" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->dest_description->getPlaceHolder()) ?>" value="<?php echo $destinations->dest_description->EditValue ?>"<?php echo $destinations->dest_description->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
<?php if ($destinations->dest_interest->Visible) { // dest_interest ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_dest_interest"><?php echo $destinations->dest_interest->FldCaption() ?></label>
		<div class="col-sm-9">
<textarea data-table="destinations" data-field="x_dest_interest" name="x_dest_interest" id="x_dest_interest" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($destinations->dest_interest->getPlaceHolder()) ?>"<?php echo $destinations->dest_interest->EditAttributes() ?>><?php echo $destinations->dest_interest->EditValue ?></textarea>
</div>
	</div>
<?php } ?>	
<?php if ($destinations->thing_todo->Visible) { // thing_todo ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_thing_todo"><?php echo $destinations->thing_todo->FldCaption() ?></label>
		<div class="col-sm-9">
<textarea data-table="destinations" data-field="x_thing_todo" name="x_thing_todo" id="x_thing_todo" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($destinations->thing_todo->getPlaceHolder()) ?>"<?php echo $destinations->thing_todo->EditAttributes() ?>><?php echo $destinations->thing_todo->EditValue ?></textarea>
</div>
	</div>
<?php } ?>	
<?php if ($destinations->country->Visible) { // country ?>
	<div class="form-group">
		<label class="col-sm-3 control-label ewLabel" for="x_country"><?php echo $destinations->country->FldCaption() ?></label>
		<div class="col-sm-9">
<input type="text" data-table="destinations" data-field="x_country" name="x_country" id="x_country" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->country->getPlaceHolder()) ?>" value="<?php echo $destinations->country->EditValue ?>"<?php echo $destinations->country->EditAttributes() ?>>
</div>
	</div>
<?php } ?>	
</form>
<script type="text/javascript">
fdestinationsaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$destinations_addopt->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ci_sessionsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ci_sessions_add = NULL; // Initialize page object first

class cci_sessions_add extends cci_sessions {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'ci_sessions';

	// Page object name
	var $PageObjName = 'ci_sessions_add';

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

		// Table object (ci_sessions)
		if (!isset($GLOBALS["ci_sessions"]) || get_class($GLOBALS["ci_sessions"]) == "cci_sessions") {
			$GLOBALS["ci_sessions"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ci_sessions"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ci_sessions', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ci_sessionslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->session_id->SetVisibility();
		$this->ip_address->SetVisibility();
		$this->user_agent->SetVisibility();
		$this->last_activity->SetVisibility();
		$this->user_data->SetVisibility();

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
		global $EW_EXPORT, $ci_sessions;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ci_sessions);
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
			if (@$_GET["session_id"] != "") {
				$this->session_id->setQueryStringValue($_GET["session_id"]);
				$this->setKey("session_id", $this->session_id->CurrentValue); // Set up key
			} else {
				$this->setKey("session_id", ""); // Clear key
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
					$this->Page_Terminate("ci_sessionslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ci_sessionslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ci_sessionsview.php")
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
		$this->session_id->CurrentValue = "0";
		$this->ip_address->CurrentValue = "0";
		$this->user_agent->CurrentValue = NULL;
		$this->user_agent->OldValue = $this->user_agent->CurrentValue;
		$this->last_activity->CurrentValue = 0;
		$this->user_data->CurrentValue = NULL;
		$this->user_data->OldValue = $this->user_data->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->session_id->FldIsDetailKey) {
			$this->session_id->setFormValue($objForm->GetValue("x_session_id"));
		}
		if (!$this->ip_address->FldIsDetailKey) {
			$this->ip_address->setFormValue($objForm->GetValue("x_ip_address"));
		}
		if (!$this->user_agent->FldIsDetailKey) {
			$this->user_agent->setFormValue($objForm->GetValue("x_user_agent"));
		}
		if (!$this->last_activity->FldIsDetailKey) {
			$this->last_activity->setFormValue($objForm->GetValue("x_last_activity"));
		}
		if (!$this->user_data->FldIsDetailKey) {
			$this->user_data->setFormValue($objForm->GetValue("x_user_data"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->session_id->CurrentValue = $this->session_id->FormValue;
		$this->ip_address->CurrentValue = $this->ip_address->FormValue;
		$this->user_agent->CurrentValue = $this->user_agent->FormValue;
		$this->last_activity->CurrentValue = $this->last_activity->FormValue;
		$this->user_data->CurrentValue = $this->user_data->FormValue;
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
		$this->session_id->setDbValue($rs->fields('session_id'));
		$this->ip_address->setDbValue($rs->fields('ip_address'));
		$this->user_agent->setDbValue($rs->fields('user_agent'));
		$this->last_activity->setDbValue($rs->fields('last_activity'));
		$this->user_data->setDbValue($rs->fields('user_data'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->session_id->DbValue = $row['session_id'];
		$this->ip_address->DbValue = $row['ip_address'];
		$this->user_agent->DbValue = $row['user_agent'];
		$this->last_activity->DbValue = $row['last_activity'];
		$this->user_data->DbValue = $row['user_data'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("session_id")) <> "")
			$this->session_id->CurrentValue = $this->getKey("session_id"); // session_id
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
		// session_id
		// ip_address
		// user_agent
		// last_activity
		// user_data

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// session_id
		$this->session_id->ViewValue = $this->session_id->CurrentValue;
		$this->session_id->ViewCustomAttributes = "";

		// ip_address
		$this->ip_address->ViewValue = $this->ip_address->CurrentValue;
		$this->ip_address->ViewCustomAttributes = "";

		// user_agent
		$this->user_agent->ViewValue = $this->user_agent->CurrentValue;
		$this->user_agent->ViewCustomAttributes = "";

		// last_activity
		$this->last_activity->ViewValue = $this->last_activity->CurrentValue;
		$this->last_activity->ViewCustomAttributes = "";

		// user_data
		$this->user_data->ViewValue = $this->user_data->CurrentValue;
		$this->user_data->ViewCustomAttributes = "";

			// session_id
			$this->session_id->LinkCustomAttributes = "";
			$this->session_id->HrefValue = "";
			$this->session_id->TooltipValue = "";

			// ip_address
			$this->ip_address->LinkCustomAttributes = "";
			$this->ip_address->HrefValue = "";
			$this->ip_address->TooltipValue = "";

			// user_agent
			$this->user_agent->LinkCustomAttributes = "";
			$this->user_agent->HrefValue = "";
			$this->user_agent->TooltipValue = "";

			// last_activity
			$this->last_activity->LinkCustomAttributes = "";
			$this->last_activity->HrefValue = "";
			$this->last_activity->TooltipValue = "";

			// user_data
			$this->user_data->LinkCustomAttributes = "";
			$this->user_data->HrefValue = "";
			$this->user_data->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// session_id
			$this->session_id->EditAttrs["class"] = "form-control";
			$this->session_id->EditCustomAttributes = "";
			$this->session_id->EditValue = ew_HtmlEncode($this->session_id->CurrentValue);
			$this->session_id->PlaceHolder = ew_RemoveHtml($this->session_id->FldCaption());

			// ip_address
			$this->ip_address->EditAttrs["class"] = "form-control";
			$this->ip_address->EditCustomAttributes = "";
			$this->ip_address->EditValue = ew_HtmlEncode($this->ip_address->CurrentValue);
			$this->ip_address->PlaceHolder = ew_RemoveHtml($this->ip_address->FldCaption());

			// user_agent
			$this->user_agent->EditAttrs["class"] = "form-control";
			$this->user_agent->EditCustomAttributes = "";
			$this->user_agent->EditValue = ew_HtmlEncode($this->user_agent->CurrentValue);
			$this->user_agent->PlaceHolder = ew_RemoveHtml($this->user_agent->FldCaption());

			// last_activity
			$this->last_activity->EditAttrs["class"] = "form-control";
			$this->last_activity->EditCustomAttributes = "";
			$this->last_activity->EditValue = ew_HtmlEncode($this->last_activity->CurrentValue);
			$this->last_activity->PlaceHolder = ew_RemoveHtml($this->last_activity->FldCaption());

			// user_data
			$this->user_data->EditAttrs["class"] = "form-control";
			$this->user_data->EditCustomAttributes = "";
			$this->user_data->EditValue = ew_HtmlEncode($this->user_data->CurrentValue);
			$this->user_data->PlaceHolder = ew_RemoveHtml($this->user_data->FldCaption());

			// Add refer script
			// session_id

			$this->session_id->LinkCustomAttributes = "";
			$this->session_id->HrefValue = "";

			// ip_address
			$this->ip_address->LinkCustomAttributes = "";
			$this->ip_address->HrefValue = "";

			// user_agent
			$this->user_agent->LinkCustomAttributes = "";
			$this->user_agent->HrefValue = "";

			// last_activity
			$this->last_activity->LinkCustomAttributes = "";
			$this->last_activity->HrefValue = "";

			// user_data
			$this->user_data->LinkCustomAttributes = "";
			$this->user_data->HrefValue = "";
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
		if (!$this->session_id->FldIsDetailKey && !is_null($this->session_id->FormValue) && $this->session_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->session_id->FldCaption(), $this->session_id->ReqErrMsg));
		}
		if (!$this->ip_address->FldIsDetailKey && !is_null($this->ip_address->FormValue) && $this->ip_address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ip_address->FldCaption(), $this->ip_address->ReqErrMsg));
		}
		if (!$this->user_agent->FldIsDetailKey && !is_null($this->user_agent->FormValue) && $this->user_agent->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user_agent->FldCaption(), $this->user_agent->ReqErrMsg));
		}
		if (!$this->last_activity->FldIsDetailKey && !is_null($this->last_activity->FormValue) && $this->last_activity->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->last_activity->FldCaption(), $this->last_activity->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->last_activity->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_activity->FldErrMsg());
		}
		if (!$this->user_data->FldIsDetailKey && !is_null($this->user_data->FormValue) && $this->user_data->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user_data->FldCaption(), $this->user_data->ReqErrMsg));
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

		// session_id
		$this->session_id->SetDbValueDef($rsnew, $this->session_id->CurrentValue, "", strval($this->session_id->CurrentValue) == "");

		// ip_address
		$this->ip_address->SetDbValueDef($rsnew, $this->ip_address->CurrentValue, "", strval($this->ip_address->CurrentValue) == "");

		// user_agent
		$this->user_agent->SetDbValueDef($rsnew, $this->user_agent->CurrentValue, "", FALSE);

		// last_activity
		$this->last_activity->SetDbValueDef($rsnew, $this->last_activity->CurrentValue, 0, strval($this->last_activity->CurrentValue) == "");

		// user_data
		$this->user_data->SetDbValueDef($rsnew, $this->user_data->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['session_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ci_sessionslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ci_sessions_add)) $ci_sessions_add = new cci_sessions_add();

// Page init
$ci_sessions_add->Page_Init();

// Page main
$ci_sessions_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ci_sessions_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fci_sessionsadd = new ew_Form("fci_sessionsadd", "add");

// Validate form
fci_sessionsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_session_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ci_sessions->session_id->FldCaption(), $ci_sessions->session_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ip_address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ci_sessions->ip_address->FldCaption(), $ci_sessions->ip_address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_user_agent");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ci_sessions->user_agent->FldCaption(), $ci_sessions->user_agent->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_last_activity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ci_sessions->last_activity->FldCaption(), $ci_sessions->last_activity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_last_activity");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ci_sessions->last_activity->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user_data");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $ci_sessions->user_data->FldCaption(), $ci_sessions->user_data->ReqErrMsg)) ?>");

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
fci_sessionsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fci_sessionsadd.ValidateRequired = true;
<?php } else { ?>
fci_sessionsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ci_sessions_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ci_sessions_add->ShowPageHeader(); ?>
<?php
$ci_sessions_add->ShowMessage();
?>
<form name="fci_sessionsadd" id="fci_sessionsadd" class="<?php echo $ci_sessions_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ci_sessions_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ci_sessions_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ci_sessions">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($ci_sessions_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ci_sessions->session_id->Visible) { // session_id ?>
	<div id="r_session_id" class="form-group">
		<label id="elh_ci_sessions_session_id" for="x_session_id" class="col-sm-2 control-label ewLabel"><?php echo $ci_sessions->session_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ci_sessions->session_id->CellAttributes() ?>>
<span id="el_ci_sessions_session_id">
<input type="text" data-table="ci_sessions" data-field="x_session_id" name="x_session_id" id="x_session_id" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($ci_sessions->session_id->getPlaceHolder()) ?>" value="<?php echo $ci_sessions->session_id->EditValue ?>"<?php echo $ci_sessions->session_id->EditAttributes() ?>>
</span>
<?php echo $ci_sessions->session_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_sessions->ip_address->Visible) { // ip_address ?>
	<div id="r_ip_address" class="form-group">
		<label id="elh_ci_sessions_ip_address" for="x_ip_address" class="col-sm-2 control-label ewLabel"><?php echo $ci_sessions->ip_address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ci_sessions->ip_address->CellAttributes() ?>>
<span id="el_ci_sessions_ip_address">
<input type="text" data-table="ci_sessions" data-field="x_ip_address" name="x_ip_address" id="x_ip_address" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($ci_sessions->ip_address->getPlaceHolder()) ?>" value="<?php echo $ci_sessions->ip_address->EditValue ?>"<?php echo $ci_sessions->ip_address->EditAttributes() ?>>
</span>
<?php echo $ci_sessions->ip_address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_sessions->user_agent->Visible) { // user_agent ?>
	<div id="r_user_agent" class="form-group">
		<label id="elh_ci_sessions_user_agent" for="x_user_agent" class="col-sm-2 control-label ewLabel"><?php echo $ci_sessions->user_agent->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ci_sessions->user_agent->CellAttributes() ?>>
<span id="el_ci_sessions_user_agent">
<input type="text" data-table="ci_sessions" data-field="x_user_agent" name="x_user_agent" id="x_user_agent" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($ci_sessions->user_agent->getPlaceHolder()) ?>" value="<?php echo $ci_sessions->user_agent->EditValue ?>"<?php echo $ci_sessions->user_agent->EditAttributes() ?>>
</span>
<?php echo $ci_sessions->user_agent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_sessions->last_activity->Visible) { // last_activity ?>
	<div id="r_last_activity" class="form-group">
		<label id="elh_ci_sessions_last_activity" for="x_last_activity" class="col-sm-2 control-label ewLabel"><?php echo $ci_sessions->last_activity->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ci_sessions->last_activity->CellAttributes() ?>>
<span id="el_ci_sessions_last_activity">
<input type="text" data-table="ci_sessions" data-field="x_last_activity" name="x_last_activity" id="x_last_activity" size="30" placeholder="<?php echo ew_HtmlEncode($ci_sessions->last_activity->getPlaceHolder()) ?>" value="<?php echo $ci_sessions->last_activity->EditValue ?>"<?php echo $ci_sessions->last_activity->EditAttributes() ?>>
</span>
<?php echo $ci_sessions->last_activity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_sessions->user_data->Visible) { // user_data ?>
	<div id="r_user_data" class="form-group">
		<label id="elh_ci_sessions_user_data" for="x_user_data" class="col-sm-2 control-label ewLabel"><?php echo $ci_sessions->user_data->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $ci_sessions->user_data->CellAttributes() ?>>
<span id="el_ci_sessions_user_data">
<textarea data-table="ci_sessions" data-field="x_user_data" name="x_user_data" id="x_user_data" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($ci_sessions->user_data->getPlaceHolder()) ?>"<?php echo $ci_sessions->user_data->EditAttributes() ?>><?php echo $ci_sessions->user_data->EditValue ?></textarea>
</span>
<?php echo $ci_sessions->user_data->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ci_sessions_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ci_sessions_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fci_sessionsadd.Init();
</script>
<?php
$ci_sessions_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ci_sessions_add->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "ci_cookiesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$ci_cookies_add = NULL; // Initialize page object first

class cci_cookies_add extends cci_cookies {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'ci_cookies';

	// Page object name
	var $PageObjName = 'ci_cookies_add';

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

		// Table object (ci_cookies)
		if (!isset($GLOBALS["ci_cookies"]) || get_class($GLOBALS["ci_cookies"]) == "cci_cookies") {
			$GLOBALS["ci_cookies"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ci_cookies"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ci_cookies', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("ci_cookieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->cookie_id->SetVisibility();
		$this->netid->SetVisibility();
		$this->ip_address->SetVisibility();
		$this->user_agent->SetVisibility();
		$this->orig_page_requested->SetVisibility();
		$this->php_session_id->SetVisibility();
		$this->created_at->SetVisibility();
		$this->updated_at->SetVisibility();

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
		global $EW_EXPORT, $ci_cookies;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($ci_cookies);
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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("ci_cookieslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ci_cookieslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ci_cookiesview.php")
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
		$this->cookie_id->CurrentValue = NULL;
		$this->cookie_id->OldValue = $this->cookie_id->CurrentValue;
		$this->netid->CurrentValue = NULL;
		$this->netid->OldValue = $this->netid->CurrentValue;
		$this->ip_address->CurrentValue = NULL;
		$this->ip_address->OldValue = $this->ip_address->CurrentValue;
		$this->user_agent->CurrentValue = NULL;
		$this->user_agent->OldValue = $this->user_agent->CurrentValue;
		$this->orig_page_requested->CurrentValue = NULL;
		$this->orig_page_requested->OldValue = $this->orig_page_requested->CurrentValue;
		$this->php_session_id->CurrentValue = NULL;
		$this->php_session_id->OldValue = $this->php_session_id->CurrentValue;
		$this->created_at->CurrentValue = NULL;
		$this->created_at->OldValue = $this->created_at->CurrentValue;
		$this->updated_at->CurrentValue = NULL;
		$this->updated_at->OldValue = $this->updated_at->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cookie_id->FldIsDetailKey) {
			$this->cookie_id->setFormValue($objForm->GetValue("x_cookie_id"));
		}
		if (!$this->netid->FldIsDetailKey) {
			$this->netid->setFormValue($objForm->GetValue("x_netid"));
		}
		if (!$this->ip_address->FldIsDetailKey) {
			$this->ip_address->setFormValue($objForm->GetValue("x_ip_address"));
		}
		if (!$this->user_agent->FldIsDetailKey) {
			$this->user_agent->setFormValue($objForm->GetValue("x_user_agent"));
		}
		if (!$this->orig_page_requested->FldIsDetailKey) {
			$this->orig_page_requested->setFormValue($objForm->GetValue("x_orig_page_requested"));
		}
		if (!$this->php_session_id->FldIsDetailKey) {
			$this->php_session_id->setFormValue($objForm->GetValue("x_php_session_id"));
		}
		if (!$this->created_at->FldIsDetailKey) {
			$this->created_at->setFormValue($objForm->GetValue("x_created_at"));
			$this->created_at->CurrentValue = ew_UnFormatDateTime($this->created_at->CurrentValue, 0);
		}
		if (!$this->updated_at->FldIsDetailKey) {
			$this->updated_at->setFormValue($objForm->GetValue("x_updated_at"));
			$this->updated_at->CurrentValue = ew_UnFormatDateTime($this->updated_at->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->cookie_id->CurrentValue = $this->cookie_id->FormValue;
		$this->netid->CurrentValue = $this->netid->FormValue;
		$this->ip_address->CurrentValue = $this->ip_address->FormValue;
		$this->user_agent->CurrentValue = $this->user_agent->FormValue;
		$this->orig_page_requested->CurrentValue = $this->orig_page_requested->FormValue;
		$this->php_session_id->CurrentValue = $this->php_session_id->FormValue;
		$this->created_at->CurrentValue = $this->created_at->FormValue;
		$this->created_at->CurrentValue = ew_UnFormatDateTime($this->created_at->CurrentValue, 0);
		$this->updated_at->CurrentValue = $this->updated_at->FormValue;
		$this->updated_at->CurrentValue = ew_UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
		$this->id->setDbValue($rs->fields('id'));
		$this->cookie_id->setDbValue($rs->fields('cookie_id'));
		$this->netid->setDbValue($rs->fields('netid'));
		$this->ip_address->setDbValue($rs->fields('ip_address'));
		$this->user_agent->setDbValue($rs->fields('user_agent'));
		$this->orig_page_requested->setDbValue($rs->fields('orig_page_requested'));
		$this->php_session_id->setDbValue($rs->fields('php_session_id'));
		$this->created_at->setDbValue($rs->fields('created_at'));
		$this->updated_at->setDbValue($rs->fields('updated_at'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->cookie_id->DbValue = $row['cookie_id'];
		$this->netid->DbValue = $row['netid'];
		$this->ip_address->DbValue = $row['ip_address'];
		$this->user_agent->DbValue = $row['user_agent'];
		$this->orig_page_requested->DbValue = $row['orig_page_requested'];
		$this->php_session_id->DbValue = $row['php_session_id'];
		$this->created_at->DbValue = $row['created_at'];
		$this->updated_at->DbValue = $row['updated_at'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// cookie_id
		// netid
		// ip_address
		// user_agent
		// orig_page_requested
		// php_session_id
		// created_at
		// updated_at

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// cookie_id
		$this->cookie_id->ViewValue = $this->cookie_id->CurrentValue;
		$this->cookie_id->ViewCustomAttributes = "";

		// netid
		$this->netid->ViewValue = $this->netid->CurrentValue;
		$this->netid->ViewCustomAttributes = "";

		// ip_address
		$this->ip_address->ViewValue = $this->ip_address->CurrentValue;
		$this->ip_address->ViewCustomAttributes = "";

		// user_agent
		$this->user_agent->ViewValue = $this->user_agent->CurrentValue;
		$this->user_agent->ViewCustomAttributes = "";

		// orig_page_requested
		$this->orig_page_requested->ViewValue = $this->orig_page_requested->CurrentValue;
		$this->orig_page_requested->ViewCustomAttributes = "";

		// php_session_id
		$this->php_session_id->ViewValue = $this->php_session_id->CurrentValue;
		$this->php_session_id->ViewCustomAttributes = "";

		// created_at
		$this->created_at->ViewValue = $this->created_at->CurrentValue;
		$this->created_at->ViewValue = ew_FormatDateTime($this->created_at->ViewValue, 0);
		$this->created_at->ViewCustomAttributes = "";

		// updated_at
		$this->updated_at->ViewValue = $this->updated_at->CurrentValue;
		$this->updated_at->ViewValue = ew_FormatDateTime($this->updated_at->ViewValue, 0);
		$this->updated_at->ViewCustomAttributes = "";

			// cookie_id
			$this->cookie_id->LinkCustomAttributes = "";
			$this->cookie_id->HrefValue = "";
			$this->cookie_id->TooltipValue = "";

			// netid
			$this->netid->LinkCustomAttributes = "";
			$this->netid->HrefValue = "";
			$this->netid->TooltipValue = "";

			// ip_address
			$this->ip_address->LinkCustomAttributes = "";
			$this->ip_address->HrefValue = "";
			$this->ip_address->TooltipValue = "";

			// user_agent
			$this->user_agent->LinkCustomAttributes = "";
			$this->user_agent->HrefValue = "";
			$this->user_agent->TooltipValue = "";

			// orig_page_requested
			$this->orig_page_requested->LinkCustomAttributes = "";
			$this->orig_page_requested->HrefValue = "";
			$this->orig_page_requested->TooltipValue = "";

			// php_session_id
			$this->php_session_id->LinkCustomAttributes = "";
			$this->php_session_id->HrefValue = "";
			$this->php_session_id->TooltipValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";
			$this->created_at->TooltipValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
			$this->updated_at->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// cookie_id
			$this->cookie_id->EditAttrs["class"] = "form-control";
			$this->cookie_id->EditCustomAttributes = "";
			$this->cookie_id->EditValue = ew_HtmlEncode($this->cookie_id->CurrentValue);
			$this->cookie_id->PlaceHolder = ew_RemoveHtml($this->cookie_id->FldCaption());

			// netid
			$this->netid->EditAttrs["class"] = "form-control";
			$this->netid->EditCustomAttributes = "";
			$this->netid->EditValue = ew_HtmlEncode($this->netid->CurrentValue);
			$this->netid->PlaceHolder = ew_RemoveHtml($this->netid->FldCaption());

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

			// orig_page_requested
			$this->orig_page_requested->EditAttrs["class"] = "form-control";
			$this->orig_page_requested->EditCustomAttributes = "";
			$this->orig_page_requested->EditValue = ew_HtmlEncode($this->orig_page_requested->CurrentValue);
			$this->orig_page_requested->PlaceHolder = ew_RemoveHtml($this->orig_page_requested->FldCaption());

			// php_session_id
			$this->php_session_id->EditAttrs["class"] = "form-control";
			$this->php_session_id->EditCustomAttributes = "";
			$this->php_session_id->EditValue = ew_HtmlEncode($this->php_session_id->CurrentValue);
			$this->php_session_id->PlaceHolder = ew_RemoveHtml($this->php_session_id->FldCaption());

			// created_at
			$this->created_at->EditAttrs["class"] = "form-control";
			$this->created_at->EditCustomAttributes = "";
			$this->created_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->created_at->CurrentValue, 8));
			$this->created_at->PlaceHolder = ew_RemoveHtml($this->created_at->FldCaption());

			// updated_at
			$this->updated_at->EditAttrs["class"] = "form-control";
			$this->updated_at->EditCustomAttributes = "";
			$this->updated_at->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->updated_at->CurrentValue, 8));
			$this->updated_at->PlaceHolder = ew_RemoveHtml($this->updated_at->FldCaption());

			// Add refer script
			// cookie_id

			$this->cookie_id->LinkCustomAttributes = "";
			$this->cookie_id->HrefValue = "";

			// netid
			$this->netid->LinkCustomAttributes = "";
			$this->netid->HrefValue = "";

			// ip_address
			$this->ip_address->LinkCustomAttributes = "";
			$this->ip_address->HrefValue = "";

			// user_agent
			$this->user_agent->LinkCustomAttributes = "";
			$this->user_agent->HrefValue = "";

			// orig_page_requested
			$this->orig_page_requested->LinkCustomAttributes = "";
			$this->orig_page_requested->HrefValue = "";

			// php_session_id
			$this->php_session_id->LinkCustomAttributes = "";
			$this->php_session_id->HrefValue = "";

			// created_at
			$this->created_at->LinkCustomAttributes = "";
			$this->created_at->HrefValue = "";

			// updated_at
			$this->updated_at->LinkCustomAttributes = "";
			$this->updated_at->HrefValue = "";
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
		if (!ew_CheckDateDef($this->created_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_at->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->updated_at->FormValue)) {
			ew_AddMessage($gsFormError, $this->updated_at->FldErrMsg());
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

		// cookie_id
		$this->cookie_id->SetDbValueDef($rsnew, $this->cookie_id->CurrentValue, NULL, FALSE);

		// netid
		$this->netid->SetDbValueDef($rsnew, $this->netid->CurrentValue, NULL, FALSE);

		// ip_address
		$this->ip_address->SetDbValueDef($rsnew, $this->ip_address->CurrentValue, NULL, FALSE);

		// user_agent
		$this->user_agent->SetDbValueDef($rsnew, $this->user_agent->CurrentValue, NULL, FALSE);

		// orig_page_requested
		$this->orig_page_requested->SetDbValueDef($rsnew, $this->orig_page_requested->CurrentValue, NULL, FALSE);

		// php_session_id
		$this->php_session_id->SetDbValueDef($rsnew, $this->php_session_id->CurrentValue, NULL, FALSE);

		// created_at
		$this->created_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_at->CurrentValue, 0), NULL, FALSE);

		// updated_at
		$this->updated_at->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->updated_at->CurrentValue, 0), NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ci_cookieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ci_cookies_add)) $ci_cookies_add = new cci_cookies_add();

// Page init
$ci_cookies_add->Page_Init();

// Page main
$ci_cookies_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ci_cookies_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fci_cookiesadd = new ew_Form("fci_cookiesadd", "add");

// Validate form
fci_cookiesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_created_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ci_cookies->created_at->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_at");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($ci_cookies->updated_at->FldErrMsg()) ?>");

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
fci_cookiesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fci_cookiesadd.ValidateRequired = true;
<?php } else { ?>
fci_cookiesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$ci_cookies_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $ci_cookies_add->ShowPageHeader(); ?>
<?php
$ci_cookies_add->ShowMessage();
?>
<form name="fci_cookiesadd" id="fci_cookiesadd" class="<?php echo $ci_cookies_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ci_cookies_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ci_cookies_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ci_cookies">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($ci_cookies_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($ci_cookies->cookie_id->Visible) { // cookie_id ?>
	<div id="r_cookie_id" class="form-group">
		<label id="elh_ci_cookies_cookie_id" for="x_cookie_id" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->cookie_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->cookie_id->CellAttributes() ?>>
<span id="el_ci_cookies_cookie_id">
<input type="text" data-table="ci_cookies" data-field="x_cookie_id" name="x_cookie_id" id="x_cookie_id" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ci_cookies->cookie_id->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->cookie_id->EditValue ?>"<?php echo $ci_cookies->cookie_id->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->cookie_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->netid->Visible) { // netid ?>
	<div id="r_netid" class="form-group">
		<label id="elh_ci_cookies_netid" for="x_netid" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->netid->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->netid->CellAttributes() ?>>
<span id="el_ci_cookies_netid">
<input type="text" data-table="ci_cookies" data-field="x_netid" name="x_netid" id="x_netid" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ci_cookies->netid->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->netid->EditValue ?>"<?php echo $ci_cookies->netid->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->netid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->ip_address->Visible) { // ip_address ?>
	<div id="r_ip_address" class="form-group">
		<label id="elh_ci_cookies_ip_address" for="x_ip_address" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->ip_address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->ip_address->CellAttributes() ?>>
<span id="el_ci_cookies_ip_address">
<input type="text" data-table="ci_cookies" data-field="x_ip_address" name="x_ip_address" id="x_ip_address" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ci_cookies->ip_address->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->ip_address->EditValue ?>"<?php echo $ci_cookies->ip_address->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->ip_address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->user_agent->Visible) { // user_agent ?>
	<div id="r_user_agent" class="form-group">
		<label id="elh_ci_cookies_user_agent" for="x_user_agent" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->user_agent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->user_agent->CellAttributes() ?>>
<span id="el_ci_cookies_user_agent">
<input type="text" data-table="ci_cookies" data-field="x_user_agent" name="x_user_agent" id="x_user_agent" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($ci_cookies->user_agent->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->user_agent->EditValue ?>"<?php echo $ci_cookies->user_agent->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->user_agent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->orig_page_requested->Visible) { // orig_page_requested ?>
	<div id="r_orig_page_requested" class="form-group">
		<label id="elh_ci_cookies_orig_page_requested" for="x_orig_page_requested" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->orig_page_requested->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->orig_page_requested->CellAttributes() ?>>
<span id="el_ci_cookies_orig_page_requested">
<input type="text" data-table="ci_cookies" data-field="x_orig_page_requested" name="x_orig_page_requested" id="x_orig_page_requested" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($ci_cookies->orig_page_requested->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->orig_page_requested->EditValue ?>"<?php echo $ci_cookies->orig_page_requested->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->orig_page_requested->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->php_session_id->Visible) { // php_session_id ?>
	<div id="r_php_session_id" class="form-group">
		<label id="elh_ci_cookies_php_session_id" for="x_php_session_id" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->php_session_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->php_session_id->CellAttributes() ?>>
<span id="el_ci_cookies_php_session_id">
<input type="text" data-table="ci_cookies" data-field="x_php_session_id" name="x_php_session_id" id="x_php_session_id" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($ci_cookies->php_session_id->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->php_session_id->EditValue ?>"<?php echo $ci_cookies->php_session_id->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->php_session_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->created_at->Visible) { // created_at ?>
	<div id="r_created_at" class="form-group">
		<label id="elh_ci_cookies_created_at" for="x_created_at" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->created_at->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->created_at->CellAttributes() ?>>
<span id="el_ci_cookies_created_at">
<input type="text" data-table="ci_cookies" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?php echo ew_HtmlEncode($ci_cookies->created_at->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->created_at->EditValue ?>"<?php echo $ci_cookies->created_at->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->created_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($ci_cookies->updated_at->Visible) { // updated_at ?>
	<div id="r_updated_at" class="form-group">
		<label id="elh_ci_cookies_updated_at" for="x_updated_at" class="col-sm-2 control-label ewLabel"><?php echo $ci_cookies->updated_at->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $ci_cookies->updated_at->CellAttributes() ?>>
<span id="el_ci_cookies_updated_at">
<input type="text" data-table="ci_cookies" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?php echo ew_HtmlEncode($ci_cookies->updated_at->getPlaceHolder()) ?>" value="<?php echo $ci_cookies->updated_at->EditValue ?>"<?php echo $ci_cookies->updated_at->EditAttributes() ?>>
</span>
<?php echo $ci_cookies->updated_at->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$ci_cookies_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ci_cookies_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fci_cookiesadd.Init();
</script>
<?php
$ci_cookies_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ci_cookies_add->Page_Terminate();
?>

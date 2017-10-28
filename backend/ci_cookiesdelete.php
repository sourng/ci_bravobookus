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

$ci_cookies_delete = NULL; // Initialize page object first

class cci_cookies_delete extends cci_cookies {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'ci_cookies';

	// Page object name
	var $PageObjName = 'ci_cookies_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("ci_cookieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			$this->Page_Terminate("ci_cookieslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in ci_cookies class, ci_cookiesinfo.php

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
				$this->Page_Terminate("ci_cookieslist.php"); // Return to list
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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
				$sThisKey .= $row['id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("ci_cookieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($ci_cookies_delete)) $ci_cookies_delete = new cci_cookies_delete();

// Page init
$ci_cookies_delete->Page_Init();

// Page main
$ci_cookies_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$ci_cookies_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fci_cookiesdelete = new ew_Form("fci_cookiesdelete", "delete");

// Form_CustomValidate event
fci_cookiesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fci_cookiesdelete.ValidateRequired = true;
<?php } else { ?>
fci_cookiesdelete.ValidateRequired = false; 
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
<?php $ci_cookies_delete->ShowPageHeader(); ?>
<?php
$ci_cookies_delete->ShowMessage();
?>
<form name="fci_cookiesdelete" id="fci_cookiesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($ci_cookies_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $ci_cookies_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="ci_cookies">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($ci_cookies_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $ci_cookies->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($ci_cookies->id->Visible) { // id ?>
		<th><span id="elh_ci_cookies_id" class="ci_cookies_id"><?php echo $ci_cookies->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->cookie_id->Visible) { // cookie_id ?>
		<th><span id="elh_ci_cookies_cookie_id" class="ci_cookies_cookie_id"><?php echo $ci_cookies->cookie_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->netid->Visible) { // netid ?>
		<th><span id="elh_ci_cookies_netid" class="ci_cookies_netid"><?php echo $ci_cookies->netid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->ip_address->Visible) { // ip_address ?>
		<th><span id="elh_ci_cookies_ip_address" class="ci_cookies_ip_address"><?php echo $ci_cookies->ip_address->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->user_agent->Visible) { // user_agent ?>
		<th><span id="elh_ci_cookies_user_agent" class="ci_cookies_user_agent"><?php echo $ci_cookies->user_agent->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->orig_page_requested->Visible) { // orig_page_requested ?>
		<th><span id="elh_ci_cookies_orig_page_requested" class="ci_cookies_orig_page_requested"><?php echo $ci_cookies->orig_page_requested->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->php_session_id->Visible) { // php_session_id ?>
		<th><span id="elh_ci_cookies_php_session_id" class="ci_cookies_php_session_id"><?php echo $ci_cookies->php_session_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->created_at->Visible) { // created_at ?>
		<th><span id="elh_ci_cookies_created_at" class="ci_cookies_created_at"><?php echo $ci_cookies->created_at->FldCaption() ?></span></th>
<?php } ?>
<?php if ($ci_cookies->updated_at->Visible) { // updated_at ?>
		<th><span id="elh_ci_cookies_updated_at" class="ci_cookies_updated_at"><?php echo $ci_cookies->updated_at->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$ci_cookies_delete->RecCnt = 0;
$i = 0;
while (!$ci_cookies_delete->Recordset->EOF) {
	$ci_cookies_delete->RecCnt++;
	$ci_cookies_delete->RowCnt++;

	// Set row properties
	$ci_cookies->ResetAttrs();
	$ci_cookies->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$ci_cookies_delete->LoadRowValues($ci_cookies_delete->Recordset);

	// Render row
	$ci_cookies_delete->RenderRow();
?>
	<tr<?php echo $ci_cookies->RowAttributes() ?>>
<?php if ($ci_cookies->id->Visible) { // id ?>
		<td<?php echo $ci_cookies->id->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_id" class="ci_cookies_id">
<span<?php echo $ci_cookies->id->ViewAttributes() ?>>
<?php echo $ci_cookies->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->cookie_id->Visible) { // cookie_id ?>
		<td<?php echo $ci_cookies->cookie_id->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_cookie_id" class="ci_cookies_cookie_id">
<span<?php echo $ci_cookies->cookie_id->ViewAttributes() ?>>
<?php echo $ci_cookies->cookie_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->netid->Visible) { // netid ?>
		<td<?php echo $ci_cookies->netid->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_netid" class="ci_cookies_netid">
<span<?php echo $ci_cookies->netid->ViewAttributes() ?>>
<?php echo $ci_cookies->netid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->ip_address->Visible) { // ip_address ?>
		<td<?php echo $ci_cookies->ip_address->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_ip_address" class="ci_cookies_ip_address">
<span<?php echo $ci_cookies->ip_address->ViewAttributes() ?>>
<?php echo $ci_cookies->ip_address->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->user_agent->Visible) { // user_agent ?>
		<td<?php echo $ci_cookies->user_agent->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_user_agent" class="ci_cookies_user_agent">
<span<?php echo $ci_cookies->user_agent->ViewAttributes() ?>>
<?php echo $ci_cookies->user_agent->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->orig_page_requested->Visible) { // orig_page_requested ?>
		<td<?php echo $ci_cookies->orig_page_requested->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_orig_page_requested" class="ci_cookies_orig_page_requested">
<span<?php echo $ci_cookies->orig_page_requested->ViewAttributes() ?>>
<?php echo $ci_cookies->orig_page_requested->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->php_session_id->Visible) { // php_session_id ?>
		<td<?php echo $ci_cookies->php_session_id->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_php_session_id" class="ci_cookies_php_session_id">
<span<?php echo $ci_cookies->php_session_id->ViewAttributes() ?>>
<?php echo $ci_cookies->php_session_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->created_at->Visible) { // created_at ?>
		<td<?php echo $ci_cookies->created_at->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_created_at" class="ci_cookies_created_at">
<span<?php echo $ci_cookies->created_at->ViewAttributes() ?>>
<?php echo $ci_cookies->created_at->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($ci_cookies->updated_at->Visible) { // updated_at ?>
		<td<?php echo $ci_cookies->updated_at->CellAttributes() ?>>
<span id="el<?php echo $ci_cookies_delete->RowCnt ?>_ci_cookies_updated_at" class="ci_cookies_updated_at">
<span<?php echo $ci_cookies->updated_at->ViewAttributes() ?>>
<?php echo $ci_cookies->updated_at->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$ci_cookies_delete->Recordset->MoveNext();
}
$ci_cookies_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $ci_cookies_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fci_cookiesdelete.Init();
</script>
<?php
$ci_cookies_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ci_cookies_delete->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "destinations2info.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$destinations2_delete = NULL; // Initialize page object first

class cdestinations2_delete extends cdestinations2 {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'destinations2';

	// Page object name
	var $PageObjName = 'destinations2_delete';

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

		// Table object (destinations2)
		if (!isset($GLOBALS["destinations2"]) || get_class($GLOBALS["destinations2"]) == "cdestinations2") {
			$GLOBALS["destinations2"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["destinations2"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'destinations2', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("destinations2list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->dest_id->SetVisibility();
		$this->dest_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->dest_name->SetVisibility();
		$this->dest_logo->SetVisibility();
		$this->dest_meta_desc->SetVisibility();
		$this->dest_meta_key->SetVisibility();
		$this->dest_feature_image->SetVisibility();
		$this->country_id->SetVisibility();

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
		global $EW_EXPORT, $destinations2;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($destinations2);
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
			$this->Page_Terminate("destinations2list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in destinations2 class, destinations2info.php

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
				$this->Page_Terminate("destinations2list.php"); // Return to list
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
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->dest_name->setDbValue($rs->fields('dest_name'));
		$this->dest_logo->setDbValue($rs->fields('dest_logo'));
		$this->dest_desc->setDbValue($rs->fields('dest_desc'));
		$this->dest_meta_desc->setDbValue($rs->fields('dest_meta_desc'));
		$this->dest_meta_key->setDbValue($rs->fields('dest_meta_key'));
		$this->dest_feature_image->setDbValue($rs->fields('dest_feature_image'));
		$this->country_id->setDbValue($rs->fields('country_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->dest_id->DbValue = $row['dest_id'];
		$this->dest_name->DbValue = $row['dest_name'];
		$this->dest_logo->DbValue = $row['dest_logo'];
		$this->dest_desc->DbValue = $row['dest_desc'];
		$this->dest_meta_desc->DbValue = $row['dest_meta_desc'];
		$this->dest_meta_key->DbValue = $row['dest_meta_key'];
		$this->dest_feature_image->DbValue = $row['dest_feature_image'];
		$this->country_id->DbValue = $row['country_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// dest_id
		// dest_name
		// dest_logo
		// dest_desc
		// dest_meta_desc
		// dest_meta_key
		// dest_feature_image
		// country_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// dest_name
		$this->dest_name->ViewValue = $this->dest_name->CurrentValue;
		$this->dest_name->ViewCustomAttributes = "";

		// dest_logo
		$this->dest_logo->ViewValue = $this->dest_logo->CurrentValue;
		$this->dest_logo->ViewCustomAttributes = "";

		// dest_meta_desc
		$this->dest_meta_desc->ViewValue = $this->dest_meta_desc->CurrentValue;
		$this->dest_meta_desc->ViewCustomAttributes = "";

		// dest_meta_key
		$this->dest_meta_key->ViewValue = $this->dest_meta_key->CurrentValue;
		$this->dest_meta_key->ViewCustomAttributes = "";

		// dest_feature_image
		$this->dest_feature_image->ViewValue = $this->dest_feature_image->CurrentValue;
		$this->dest_feature_image->ViewCustomAttributes = "";

		// country_id
		$this->country_id->ViewValue = $this->country_id->CurrentValue;
		$this->country_id->ViewCustomAttributes = "";

			// dest_id
			$this->dest_id->LinkCustomAttributes = "";
			$this->dest_id->HrefValue = "";
			$this->dest_id->TooltipValue = "";

			// dest_name
			$this->dest_name->LinkCustomAttributes = "";
			$this->dest_name->HrefValue = "";
			$this->dest_name->TooltipValue = "";

			// dest_logo
			$this->dest_logo->LinkCustomAttributes = "";
			$this->dest_logo->HrefValue = "";
			$this->dest_logo->TooltipValue = "";

			// dest_meta_desc
			$this->dest_meta_desc->LinkCustomAttributes = "";
			$this->dest_meta_desc->HrefValue = "";
			$this->dest_meta_desc->TooltipValue = "";

			// dest_meta_key
			$this->dest_meta_key->LinkCustomAttributes = "";
			$this->dest_meta_key->HrefValue = "";
			$this->dest_meta_key->TooltipValue = "";

			// dest_feature_image
			$this->dest_feature_image->LinkCustomAttributes = "";
			$this->dest_feature_image->HrefValue = "";
			$this->dest_feature_image->TooltipValue = "";

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";
			$this->country_id->TooltipValue = "";
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
				$sThisKey .= $row['dest_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("destinations2list.php"), "", $this->TableVar, TRUE);
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
if (!isset($destinations2_delete)) $destinations2_delete = new cdestinations2_delete();

// Page init
$destinations2_delete->Page_Init();

// Page main
$destinations2_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$destinations2_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdestinations2delete = new ew_Form("fdestinations2delete", "delete");

// Form_CustomValidate event
fdestinations2delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdestinations2delete.ValidateRequired = true;
<?php } else { ?>
fdestinations2delete.ValidateRequired = false; 
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
<?php $destinations2_delete->ShowPageHeader(); ?>
<?php
$destinations2_delete->ShowMessage();
?>
<form name="fdestinations2delete" id="fdestinations2delete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($destinations2_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $destinations2_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="destinations2">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($destinations2_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $destinations2->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($destinations2->dest_id->Visible) { // dest_id ?>
		<th><span id="elh_destinations2_dest_id" class="destinations2_dest_id"><?php echo $destinations2->dest_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->dest_name->Visible) { // dest_name ?>
		<th><span id="elh_destinations2_dest_name" class="destinations2_dest_name"><?php echo $destinations2->dest_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->dest_logo->Visible) { // dest_logo ?>
		<th><span id="elh_destinations2_dest_logo" class="destinations2_dest_logo"><?php echo $destinations2->dest_logo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->dest_meta_desc->Visible) { // dest_meta_desc ?>
		<th><span id="elh_destinations2_dest_meta_desc" class="destinations2_dest_meta_desc"><?php echo $destinations2->dest_meta_desc->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->dest_meta_key->Visible) { // dest_meta_key ?>
		<th><span id="elh_destinations2_dest_meta_key" class="destinations2_dest_meta_key"><?php echo $destinations2->dest_meta_key->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->dest_feature_image->Visible) { // dest_feature_image ?>
		<th><span id="elh_destinations2_dest_feature_image" class="destinations2_dest_feature_image"><?php echo $destinations2->dest_feature_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($destinations2->country_id->Visible) { // country_id ?>
		<th><span id="elh_destinations2_country_id" class="destinations2_country_id"><?php echo $destinations2->country_id->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$destinations2_delete->RecCnt = 0;
$i = 0;
while (!$destinations2_delete->Recordset->EOF) {
	$destinations2_delete->RecCnt++;
	$destinations2_delete->RowCnt++;

	// Set row properties
	$destinations2->ResetAttrs();
	$destinations2->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$destinations2_delete->LoadRowValues($destinations2_delete->Recordset);

	// Render row
	$destinations2_delete->RenderRow();
?>
	<tr<?php echo $destinations2->RowAttributes() ?>>
<?php if ($destinations2->dest_id->Visible) { // dest_id ?>
		<td<?php echo $destinations2->dest_id->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_id" class="destinations2_dest_id">
<span<?php echo $destinations2->dest_id->ViewAttributes() ?>>
<?php echo $destinations2->dest_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->dest_name->Visible) { // dest_name ?>
		<td<?php echo $destinations2->dest_name->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_name" class="destinations2_dest_name">
<span<?php echo $destinations2->dest_name->ViewAttributes() ?>>
<?php echo $destinations2->dest_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->dest_logo->Visible) { // dest_logo ?>
		<td<?php echo $destinations2->dest_logo->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_logo" class="destinations2_dest_logo">
<span<?php echo $destinations2->dest_logo->ViewAttributes() ?>>
<?php echo $destinations2->dest_logo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->dest_meta_desc->Visible) { // dest_meta_desc ?>
		<td<?php echo $destinations2->dest_meta_desc->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_meta_desc" class="destinations2_dest_meta_desc">
<span<?php echo $destinations2->dest_meta_desc->ViewAttributes() ?>>
<?php echo $destinations2->dest_meta_desc->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->dest_meta_key->Visible) { // dest_meta_key ?>
		<td<?php echo $destinations2->dest_meta_key->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_meta_key" class="destinations2_dest_meta_key">
<span<?php echo $destinations2->dest_meta_key->ViewAttributes() ?>>
<?php echo $destinations2->dest_meta_key->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->dest_feature_image->Visible) { // dest_feature_image ?>
		<td<?php echo $destinations2->dest_feature_image->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_dest_feature_image" class="destinations2_dest_feature_image">
<span<?php echo $destinations2->dest_feature_image->ViewAttributes() ?>>
<?php echo $destinations2->dest_feature_image->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($destinations2->country_id->Visible) { // country_id ?>
		<td<?php echo $destinations2->country_id->CellAttributes() ?>>
<span id="el<?php echo $destinations2_delete->RowCnt ?>_destinations2_country_id" class="destinations2_country_id">
<span<?php echo $destinations2->country_id->ViewAttributes() ?>>
<?php echo $destinations2->country_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$destinations2_delete->Recordset->MoveNext();
}
$destinations2_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $destinations2_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdestinations2delete.Init();
</script>
<?php
$destinations2_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$destinations2_delete->Page_Terminate();
?>

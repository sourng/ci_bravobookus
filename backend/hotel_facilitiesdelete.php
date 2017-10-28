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

$hotel_facilities_delete = NULL; // Initialize page object first

class chotel_facilities_delete extends chotel_facilities {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_facilities';

	// Page object name
	var $PageObjName = 'hotel_facilities_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotel_facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hfacility_id->SetVisibility();
		$this->hfacility_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			$this->Page_Terminate("hotel_facilitieslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hotel_facilities class, hotel_facilitiesinfo.php

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
				$this->Page_Terminate("hotel_facilitieslist.php"); // Return to list
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

			// hfacility_id
			$this->hfacility_id->LinkCustomAttributes = "";
			$this->hfacility_id->HrefValue = "";
			$this->hfacility_id->TooltipValue = "";

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
				$sThisKey .= $row['hfacility_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hotel_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_facilitieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_facilities_delete)) $hotel_facilities_delete = new chotel_facilities_delete();

// Page init
$hotel_facilities_delete->Page_Init();

// Page main
$hotel_facilities_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_facilities_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhotel_facilitiesdelete = new ew_Form("fhotel_facilitiesdelete", "delete");

// Form_CustomValidate event
fhotel_facilitiesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_facilitiesdelete.ValidateRequired = true;
<?php } else { ?>
fhotel_facilitiesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotel_facilitiesdelete.Lists["x_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesdelete.Lists["x_status[]"].Options = <?php echo json_encode($hotel_facilities->status->Options()) ?>;
fhotel_facilitiesdelete.Lists["x_hot_facilities[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesdelete.Lists["x_hot_facilities[]"].Options = <?php echo json_encode($hotel_facilities->hot_facilities->Options()) ?>;

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
<?php $hotel_facilities_delete->ShowPageHeader(); ?>
<?php
$hotel_facilities_delete->ShowMessage();
?>
<form name="fhotel_facilitiesdelete" id="fhotel_facilitiesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_facilities_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_facilities_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_facilities">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hotel_facilities_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $hotel_facilities->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($hotel_facilities->hfacility_id->Visible) { // hfacility_id ?>
		<th><span id="elh_hotel_facilities_hfacility_id" class="hotel_facilities_hfacility_id"><?php echo $hotel_facilities->hfacility_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->hotel_id->Visible) { // hotel_id ?>
		<th><span id="elh_hotel_facilities_hotel_id" class="hotel_facilities_hotel_id"><?php echo $hotel_facilities->hotel_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->hf_name->Visible) { // hf_name ?>
		<th><span id="elh_hotel_facilities_hf_name" class="hotel_facilities_hf_name"><?php echo $hotel_facilities->hf_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->hf_image->Visible) { // hf_image ?>
		<th><span id="elh_hotel_facilities_hf_image" class="hotel_facilities_hf_image"><?php echo $hotel_facilities->hf_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->hf_icons->Visible) { // hf_icons ?>
		<th><span id="elh_hotel_facilities_hf_icons" class="hotel_facilities_hf_icons"><?php echo $hotel_facilities->hf_icons->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->status->Visible) { // status ?>
		<th><span id="elh_hotel_facilities_status" class="hotel_facilities_status"><?php echo $hotel_facilities->status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_facilities->hot_facilities->Visible) { // hot_facilities ?>
		<th><span id="elh_hotel_facilities_hot_facilities" class="hotel_facilities_hot_facilities"><?php echo $hotel_facilities->hot_facilities->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hotel_facilities_delete->RecCnt = 0;
$i = 0;
while (!$hotel_facilities_delete->Recordset->EOF) {
	$hotel_facilities_delete->RecCnt++;
	$hotel_facilities_delete->RowCnt++;

	// Set row properties
	$hotel_facilities->ResetAttrs();
	$hotel_facilities->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hotel_facilities_delete->LoadRowValues($hotel_facilities_delete->Recordset);

	// Render row
	$hotel_facilities_delete->RenderRow();
?>
	<tr<?php echo $hotel_facilities->RowAttributes() ?>>
<?php if ($hotel_facilities->hfacility_id->Visible) { // hfacility_id ?>
		<td<?php echo $hotel_facilities->hfacility_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hfacility_id" class="hotel_facilities_hfacility_id">
<span<?php echo $hotel_facilities->hfacility_id->ViewAttributes() ?>>
<?php echo $hotel_facilities->hfacility_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->hotel_id->Visible) { // hotel_id ?>
		<td<?php echo $hotel_facilities->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hotel_id" class="hotel_facilities_hotel_id">
<span<?php echo $hotel_facilities->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_facilities->hotel_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->hf_name->Visible) { // hf_name ?>
		<td<?php echo $hotel_facilities->hf_name->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hf_name" class="hotel_facilities_hf_name">
<span<?php echo $hotel_facilities->hf_name->ViewAttributes() ?>>
<?php echo $hotel_facilities->hf_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->hf_image->Visible) { // hf_image ?>
		<td<?php echo $hotel_facilities->hf_image->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hf_image" class="hotel_facilities_hf_image">
<span<?php echo $hotel_facilities->hf_image->ViewAttributes() ?>>
<?php echo $hotel_facilities->hf_image->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->hf_icons->Visible) { // hf_icons ?>
		<td<?php echo $hotel_facilities->hf_icons->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hf_icons" class="hotel_facilities_hf_icons">
<span<?php echo $hotel_facilities->hf_icons->ViewAttributes() ?>>
<?php echo $hotel_facilities->hf_icons->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->status->Visible) { // status ?>
		<td<?php echo $hotel_facilities->status->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_status" class="hotel_facilities_status">
<span<?php echo $hotel_facilities->status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($hotel_facilities->status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $hotel_facilities->status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $hotel_facilities->status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($hotel_facilities->hot_facilities->Visible) { // hot_facilities ?>
		<td<?php echo $hotel_facilities->hot_facilities->CellAttributes() ?>>
<span id="el<?php echo $hotel_facilities_delete->RowCnt ?>_hotel_facilities_hot_facilities" class="hotel_facilities_hot_facilities">
<span<?php echo $hotel_facilities->hot_facilities->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($hotel_facilities->hot_facilities->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $hotel_facilities->hot_facilities->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $hotel_facilities->hot_facilities->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hotel_facilities_delete->Recordset->MoveNext();
}
$hotel_facilities_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_facilities_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhotel_facilitiesdelete.Init();
</script>
<?php
$hotel_facilities_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_facilities_delete->Page_Terminate();
?>

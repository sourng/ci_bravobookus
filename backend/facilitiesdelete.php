<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "facilitiesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$facilities_delete = NULL; // Initialize page object first

class cfacilities_delete extends cfacilities {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'facilities';

	// Page object name
	var $PageObjName = 'facilities_delete';

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

		// Table object (facilities)
		if (!isset($GLOBALS["facilities"]) || get_class($GLOBALS["facilities"]) == "cfacilities") {
			$GLOBALS["facilities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["facilities"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'facilities', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->facil_id->SetVisibility();
		$this->facil_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->facil_name->SetVisibility();
		$this->facil_image->SetVisibility();
		$this->facil_icon->SetVisibility();
		$this->facil_hot->SetVisibility();

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
		global $EW_EXPORT, $facilities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($facilities);
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
			$this->Page_Terminate("facilitieslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in facilities class, facilitiesinfo.php

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
				$this->Page_Terminate("facilitieslist.php"); // Return to list
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
		$this->facil_id->setDbValue($rs->fields('facil_id'));
		$this->facil_name->setDbValue($rs->fields('facil_name'));
		$this->facil_image->Upload->DbValue = $rs->fields('facil_image');
		$this->facil_image->CurrentValue = $this->facil_image->Upload->DbValue;
		$this->facil_icon->setDbValue($rs->fields('facil_icon'));
		$this->facil_hot->setDbValue($rs->fields('facil_hot'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->facil_id->DbValue = $row['facil_id'];
		$this->facil_name->DbValue = $row['facil_name'];
		$this->facil_image->Upload->DbValue = $row['facil_image'];
		$this->facil_icon->DbValue = $row['facil_icon'];
		$this->facil_hot->DbValue = $row['facil_hot'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// facil_id
		// facil_name
		// facil_image
		// facil_icon
		// facil_hot

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// facil_id
		$this->facil_id->ViewValue = $this->facil_id->CurrentValue;
		$this->facil_id->ViewCustomAttributes = "";

		// facil_name
		$this->facil_name->ViewValue = $this->facil_name->CurrentValue;
		$this->facil_name->ViewCustomAttributes = "";

		// facil_image
		$this->facil_image->UploadPath = "../uploads/facilities";
		if (!ew_Empty($this->facil_image->Upload->DbValue)) {
			$this->facil_image->ImageAlt = $this->facil_image->FldAlt();
			$this->facil_image->ViewValue = $this->facil_image->Upload->DbValue;
		} else {
			$this->facil_image->ViewValue = "";
		}
		$this->facil_image->ViewCustomAttributes = "";

		// facil_icon
		$this->facil_icon->ViewValue = $this->facil_icon->CurrentValue;
		$this->facil_icon->ViewCustomAttributes = "";

		// facil_hot
		if (ew_ConvertToBool($this->facil_hot->CurrentValue)) {
			$this->facil_hot->ViewValue = $this->facil_hot->FldTagCaption(1) <> "" ? $this->facil_hot->FldTagCaption(1) : "Y";
		} else {
			$this->facil_hot->ViewValue = $this->facil_hot->FldTagCaption(2) <> "" ? $this->facil_hot->FldTagCaption(2) : "N";
		}
		$this->facil_hot->ViewCustomAttributes = "";

			// facil_id
			$this->facil_id->LinkCustomAttributes = "";
			$this->facil_id->HrefValue = "";
			$this->facil_id->TooltipValue = "";

			// facil_name
			$this->facil_name->LinkCustomAttributes = "";
			$this->facil_name->HrefValue = "";
			$this->facil_name->TooltipValue = "";

			// facil_image
			$this->facil_image->LinkCustomAttributes = "";
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->DbValue)) {
				$this->facil_image->HrefValue = ew_GetFileUploadUrl($this->facil_image, $this->facil_image->Upload->DbValue); // Add prefix/suffix
				$this->facil_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->facil_image->HrefValue = ew_ConvertFullUrl($this->facil_image->HrefValue);
			} else {
				$this->facil_image->HrefValue = "";
			}
			$this->facil_image->HrefValue2 = $this->facil_image->UploadPath . $this->facil_image->Upload->DbValue;
			$this->facil_image->TooltipValue = "";
			if ($this->facil_image->UseColorbox) {
				if (ew_Empty($this->facil_image->TooltipValue))
					$this->facil_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->facil_image->LinkAttrs["data-rel"] = "facilities_x_facil_image";
				ew_AppendClass($this->facil_image->LinkAttrs["class"], "ewLightbox");
			}

			// facil_icon
			$this->facil_icon->LinkCustomAttributes = "";
			$this->facil_icon->HrefValue = "";
			$this->facil_icon->TooltipValue = "";

			// facil_hot
			$this->facil_hot->LinkCustomAttributes = "";
			$this->facil_hot->HrefValue = "";
			$this->facil_hot->TooltipValue = "";
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
				$sThisKey .= $row['facil_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("facilitieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($facilities_delete)) $facilities_delete = new cfacilities_delete();

// Page init
$facilities_delete->Page_Init();

// Page main
$facilities_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$facilities_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ffacilitiesdelete = new ew_Form("ffacilitiesdelete", "delete");

// Form_CustomValidate event
ffacilitiesdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffacilitiesdelete.ValidateRequired = true;
<?php } else { ?>
ffacilitiesdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffacilitiesdelete.Lists["x_facil_hot[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffacilitiesdelete.Lists["x_facil_hot[]"].Options = <?php echo json_encode($facilities->facil_hot->Options()) ?>;

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
<?php $facilities_delete->ShowPageHeader(); ?>
<?php
$facilities_delete->ShowMessage();
?>
<form name="ffacilitiesdelete" id="ffacilitiesdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($facilities_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $facilities_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="facilities">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($facilities_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $facilities->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($facilities->facil_id->Visible) { // facil_id ?>
		<th><span id="elh_facilities_facil_id" class="facilities_facil_id"><?php echo $facilities->facil_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($facilities->facil_name->Visible) { // facil_name ?>
		<th><span id="elh_facilities_facil_name" class="facilities_facil_name"><?php echo $facilities->facil_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($facilities->facil_image->Visible) { // facil_image ?>
		<th><span id="elh_facilities_facil_image" class="facilities_facil_image"><?php echo $facilities->facil_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($facilities->facil_icon->Visible) { // facil_icon ?>
		<th><span id="elh_facilities_facil_icon" class="facilities_facil_icon"><?php echo $facilities->facil_icon->FldCaption() ?></span></th>
<?php } ?>
<?php if ($facilities->facil_hot->Visible) { // facil_hot ?>
		<th><span id="elh_facilities_facil_hot" class="facilities_facil_hot"><?php echo $facilities->facil_hot->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$facilities_delete->RecCnt = 0;
$i = 0;
while (!$facilities_delete->Recordset->EOF) {
	$facilities_delete->RecCnt++;
	$facilities_delete->RowCnt++;

	// Set row properties
	$facilities->ResetAttrs();
	$facilities->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$facilities_delete->LoadRowValues($facilities_delete->Recordset);

	// Render row
	$facilities_delete->RenderRow();
?>
	<tr<?php echo $facilities->RowAttributes() ?>>
<?php if ($facilities->facil_id->Visible) { // facil_id ?>
		<td<?php echo $facilities->facil_id->CellAttributes() ?>>
<span id="el<?php echo $facilities_delete->RowCnt ?>_facilities_facil_id" class="facilities_facil_id">
<span<?php echo $facilities->facil_id->ViewAttributes() ?>>
<?php echo $facilities->facil_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($facilities->facil_name->Visible) { // facil_name ?>
		<td<?php echo $facilities->facil_name->CellAttributes() ?>>
<span id="el<?php echo $facilities_delete->RowCnt ?>_facilities_facil_name" class="facilities_facil_name">
<span<?php echo $facilities->facil_name->ViewAttributes() ?>>
<?php echo $facilities->facil_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($facilities->facil_image->Visible) { // facil_image ?>
		<td<?php echo $facilities->facil_image->CellAttributes() ?>>
<span id="el<?php echo $facilities_delete->RowCnt ?>_facilities_facil_image" class="facilities_facil_image">
<span>
<?php echo ew_GetFileViewTag($facilities->facil_image, $facilities->facil_image->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($facilities->facil_icon->Visible) { // facil_icon ?>
		<td<?php echo $facilities->facil_icon->CellAttributes() ?>>
<span id="el<?php echo $facilities_delete->RowCnt ?>_facilities_facil_icon" class="facilities_facil_icon">
<span<?php echo $facilities->facil_icon->ViewAttributes() ?>>
<?php echo $facilities->facil_icon->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($facilities->facil_hot->Visible) { // facil_hot ?>
		<td<?php echo $facilities->facil_hot->CellAttributes() ?>>
<span id="el<?php echo $facilities_delete->RowCnt ?>_facilities_facil_hot" class="facilities_facil_hot">
<span<?php echo $facilities->facil_hot->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($facilities->facil_hot->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $facilities->facil_hot->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $facilities->facil_hot->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$facilities_delete->Recordset->MoveNext();
}
$facilities_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $facilities_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ffacilitiesdelete.Init();
</script>
<?php
$facilities_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$facilities_delete->Page_Terminate();
?>

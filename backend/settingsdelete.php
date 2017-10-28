<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "settingsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$settings_delete = NULL; // Initialize page object first

class csettings_delete extends csettings {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_delete';

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

		// Table object (settings)
		if (!isset($GLOBALS["settings"]) || get_class($GLOBALS["settings"]) == "csettings") {
			$GLOBALS["settings"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["settings"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'settings', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("settingslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->setting_id->SetVisibility();
		$this->site_name->SetVisibility();
		$this->logo->SetVisibility();
		$this->phone->SetVisibility();
		$this->fax->SetVisibility();
		$this->_email->SetVisibility();
		$this->address->SetVisibility();
		$this->note->SetVisibility();
		$this->facebook->SetVisibility();
		$this->twitter->SetVisibility();
		$this->gplus->SetVisibility();
		$this->youtube->SetVisibility();
		$this->linkin->SetVisibility();

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
		global $EW_EXPORT, $settings;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($settings);
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
			$this->Page_Terminate("settingslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in settings class, settingsinfo.php

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
				$this->Page_Terminate("settingslist.php"); // Return to list
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
		$this->setting_id->setDbValue($rs->fields('setting_id'));
		$this->site_name->setDbValue($rs->fields('site_name'));
		$this->logo->Upload->DbValue = $rs->fields('logo');
		$this->logo->CurrentValue = $this->logo->Upload->DbValue;
		$this->phone->setDbValue($rs->fields('phone'));
		$this->fax->setDbValue($rs->fields('fax'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->address->setDbValue($rs->fields('address'));
		$this->note->setDbValue($rs->fields('note'));
		$this->facebook->setDbValue($rs->fields('facebook'));
		$this->twitter->setDbValue($rs->fields('twitter'));
		$this->gplus->setDbValue($rs->fields('gplus'));
		$this->youtube->setDbValue($rs->fields('youtube'));
		$this->linkin->setDbValue($rs->fields('linkin'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->setting_id->DbValue = $row['setting_id'];
		$this->site_name->DbValue = $row['site_name'];
		$this->logo->Upload->DbValue = $row['logo'];
		$this->phone->DbValue = $row['phone'];
		$this->fax->DbValue = $row['fax'];
		$this->_email->DbValue = $row['email'];
		$this->address->DbValue = $row['address'];
		$this->note->DbValue = $row['note'];
		$this->facebook->DbValue = $row['facebook'];
		$this->twitter->DbValue = $row['twitter'];
		$this->gplus->DbValue = $row['gplus'];
		$this->youtube->DbValue = $row['youtube'];
		$this->linkin->DbValue = $row['linkin'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// setting_id
		// site_name
		// logo
		// phone
		// fax
		// email
		// address
		// note
		// facebook
		// twitter
		// gplus
		// youtube
		// linkin

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// setting_id
		$this->setting_id->ViewValue = $this->setting_id->CurrentValue;
		$this->setting_id->ViewCustomAttributes = "";

		// site_name
		$this->site_name->ViewValue = $this->site_name->CurrentValue;
		$this->site_name->ViewCustomAttributes = "";

		// logo
		$this->logo->UploadPath = "../public/img";
		if (!ew_Empty($this->logo->Upload->DbValue)) {
			$this->logo->ImageAlt = $this->logo->FldAlt();
			$this->logo->ViewValue = $this->logo->Upload->DbValue;
		} else {
			$this->logo->ViewValue = "";
		}
		$this->logo->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// fax
		$this->fax->ViewValue = $this->fax->CurrentValue;
		$this->fax->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// note
		$this->note->ViewValue = $this->note->CurrentValue;
		$this->note->ViewCustomAttributes = "";

		// facebook
		$this->facebook->ViewValue = $this->facebook->CurrentValue;
		$this->facebook->ViewCustomAttributes = "";

		// twitter
		$this->twitter->ViewValue = $this->twitter->CurrentValue;
		$this->twitter->ViewCustomAttributes = "";

		// gplus
		$this->gplus->ViewValue = $this->gplus->CurrentValue;
		$this->gplus->ViewCustomAttributes = "";

		// youtube
		$this->youtube->ViewValue = $this->youtube->CurrentValue;
		$this->youtube->ViewCustomAttributes = "";

		// linkin
		$this->linkin->ViewValue = $this->linkin->CurrentValue;
		$this->linkin->ViewCustomAttributes = "";

			// setting_id
			$this->setting_id->LinkCustomAttributes = "";
			$this->setting_id->HrefValue = "";
			$this->setting_id->TooltipValue = "";

			// site_name
			$this->site_name->LinkCustomAttributes = "";
			$this->site_name->HrefValue = "";
			$this->site_name->TooltipValue = "";

			// logo
			$this->logo->LinkCustomAttributes = "";
			$this->logo->UploadPath = "../public/img";
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->HrefValue = ew_GetFileUploadUrl($this->logo, $this->logo->Upload->DbValue); // Add prefix/suffix
				$this->logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->logo->HrefValue = ew_ConvertFullUrl($this->logo->HrefValue);
			} else {
				$this->logo->HrefValue = "";
			}
			$this->logo->HrefValue2 = $this->logo->UploadPath . $this->logo->Upload->DbValue;
			$this->logo->TooltipValue = "";
			if ($this->logo->UseColorbox) {
				if (ew_Empty($this->logo->TooltipValue))
					$this->logo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->logo->LinkAttrs["data-rel"] = "settings_x_logo";
				ew_AppendClass($this->logo->LinkAttrs["class"], "ewLightbox");
			}

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// fax
			$this->fax->LinkCustomAttributes = "";
			$this->fax->HrefValue = "";
			$this->fax->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

			// note
			$this->note->LinkCustomAttributes = "";
			$this->note->HrefValue = "";
			$this->note->TooltipValue = "";

			// facebook
			$this->facebook->LinkCustomAttributes = "";
			$this->facebook->HrefValue = "";
			$this->facebook->TooltipValue = "";

			// twitter
			$this->twitter->LinkCustomAttributes = "";
			$this->twitter->HrefValue = "";
			$this->twitter->TooltipValue = "";

			// gplus
			$this->gplus->LinkCustomAttributes = "";
			$this->gplus->HrefValue = "";
			$this->gplus->TooltipValue = "";

			// youtube
			$this->youtube->LinkCustomAttributes = "";
			$this->youtube->HrefValue = "";
			$this->youtube->TooltipValue = "";

			// linkin
			$this->linkin->LinkCustomAttributes = "";
			$this->linkin->HrefValue = "";
			$this->linkin->TooltipValue = "";
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
				$sThisKey .= $row['setting_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("settingslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($settings_delete)) $settings_delete = new csettings_delete();

// Page init
$settings_delete->Page_Init();

// Page main
$settings_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$settings_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fsettingsdelete = new ew_Form("fsettingsdelete", "delete");

// Form_CustomValidate event
fsettingsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingsdelete.ValidateRequired = true;
<?php } else { ?>
fsettingsdelete.ValidateRequired = false; 
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
<?php $settings_delete->ShowPageHeader(); ?>
<?php
$settings_delete->ShowMessage();
?>
<form name="fsettingsdelete" id="fsettingsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($settings_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $settings->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($settings->setting_id->Visible) { // setting_id ?>
		<th><span id="elh_settings_setting_id" class="settings_setting_id"><?php echo $settings->setting_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->site_name->Visible) { // site_name ?>
		<th><span id="elh_settings_site_name" class="settings_site_name"><?php echo $settings->site_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->logo->Visible) { // logo ?>
		<th><span id="elh_settings_logo" class="settings_logo"><?php echo $settings->logo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->phone->Visible) { // phone ?>
		<th><span id="elh_settings_phone" class="settings_phone"><?php echo $settings->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->fax->Visible) { // fax ?>
		<th><span id="elh_settings_fax" class="settings_fax"><?php echo $settings->fax->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->_email->Visible) { // email ?>
		<th><span id="elh_settings__email" class="settings__email"><?php echo $settings->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->address->Visible) { // address ?>
		<th><span id="elh_settings_address" class="settings_address"><?php echo $settings->address->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->note->Visible) { // note ?>
		<th><span id="elh_settings_note" class="settings_note"><?php echo $settings->note->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->facebook->Visible) { // facebook ?>
		<th><span id="elh_settings_facebook" class="settings_facebook"><?php echo $settings->facebook->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->twitter->Visible) { // twitter ?>
		<th><span id="elh_settings_twitter" class="settings_twitter"><?php echo $settings->twitter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->gplus->Visible) { // gplus ?>
		<th><span id="elh_settings_gplus" class="settings_gplus"><?php echo $settings->gplus->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->youtube->Visible) { // youtube ?>
		<th><span id="elh_settings_youtube" class="settings_youtube"><?php echo $settings->youtube->FldCaption() ?></span></th>
<?php } ?>
<?php if ($settings->linkin->Visible) { // linkin ?>
		<th><span id="elh_settings_linkin" class="settings_linkin"><?php echo $settings->linkin->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$settings_delete->RecCnt = 0;
$i = 0;
while (!$settings_delete->Recordset->EOF) {
	$settings_delete->RecCnt++;
	$settings_delete->RowCnt++;

	// Set row properties
	$settings->ResetAttrs();
	$settings->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$settings_delete->LoadRowValues($settings_delete->Recordset);

	// Render row
	$settings_delete->RenderRow();
?>
	<tr<?php echo $settings->RowAttributes() ?>>
<?php if ($settings->setting_id->Visible) { // setting_id ?>
		<td<?php echo $settings->setting_id->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_setting_id" class="settings_setting_id">
<span<?php echo $settings->setting_id->ViewAttributes() ?>>
<?php echo $settings->setting_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->site_name->Visible) { // site_name ?>
		<td<?php echo $settings->site_name->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_site_name" class="settings_site_name">
<span<?php echo $settings->site_name->ViewAttributes() ?>>
<?php echo $settings->site_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->logo->Visible) { // logo ?>
		<td<?php echo $settings->logo->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_logo" class="settings_logo">
<span>
<?php echo ew_GetFileViewTag($settings->logo, $settings->logo->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($settings->phone->Visible) { // phone ?>
		<td<?php echo $settings->phone->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_phone" class="settings_phone">
<span<?php echo $settings->phone->ViewAttributes() ?>>
<?php echo $settings->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->fax->Visible) { // fax ?>
		<td<?php echo $settings->fax->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_fax" class="settings_fax">
<span<?php echo $settings->fax->ViewAttributes() ?>>
<?php echo $settings->fax->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->_email->Visible) { // email ?>
		<td<?php echo $settings->_email->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings__email" class="settings__email">
<span<?php echo $settings->_email->ViewAttributes() ?>>
<?php echo $settings->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->address->Visible) { // address ?>
		<td<?php echo $settings->address->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_address" class="settings_address">
<span<?php echo $settings->address->ViewAttributes() ?>>
<?php echo $settings->address->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->note->Visible) { // note ?>
		<td<?php echo $settings->note->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_note" class="settings_note">
<span<?php echo $settings->note->ViewAttributes() ?>>
<?php echo $settings->note->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->facebook->Visible) { // facebook ?>
		<td<?php echo $settings->facebook->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_facebook" class="settings_facebook">
<span<?php echo $settings->facebook->ViewAttributes() ?>>
<?php echo $settings->facebook->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->twitter->Visible) { // twitter ?>
		<td<?php echo $settings->twitter->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_twitter" class="settings_twitter">
<span<?php echo $settings->twitter->ViewAttributes() ?>>
<?php echo $settings->twitter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->gplus->Visible) { // gplus ?>
		<td<?php echo $settings->gplus->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_gplus" class="settings_gplus">
<span<?php echo $settings->gplus->ViewAttributes() ?>>
<?php echo $settings->gplus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->youtube->Visible) { // youtube ?>
		<td<?php echo $settings->youtube->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_youtube" class="settings_youtube">
<span<?php echo $settings->youtube->ViewAttributes() ?>>
<?php echo $settings->youtube->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($settings->linkin->Visible) { // linkin ?>
		<td<?php echo $settings->linkin->CellAttributes() ?>>
<span id="el<?php echo $settings_delete->RowCnt ?>_settings_linkin" class="settings_linkin">
<span<?php echo $settings->linkin->ViewAttributes() ?>>
<?php echo $settings->linkin->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$settings_delete->Recordset->MoveNext();
}
$settings_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $settings_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fsettingsdelete.Init();
</script>
<?php
$settings_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$settings_delete->Page_Terminate();
?>

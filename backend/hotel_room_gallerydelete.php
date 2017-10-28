<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_room_galleryinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_room_gallery_delete = NULL; // Initialize page object first

class chotel_room_gallery_delete extends chotel_room_gallery {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_room_gallery';

	// Page object name
	var $PageObjName = 'hotel_room_gallery_delete';

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

		// Table object (hotel_room_gallery)
		if (!isset($GLOBALS["hotel_room_gallery"]) || get_class($GLOBALS["hotel_room_gallery"]) == "chotel_room_gallery") {
			$GLOBALS["hotel_room_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_room_gallery"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_room_gallery', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_room_gallerylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hrgallery_id->SetVisibility();
		$this->hrgallery_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hroom_id->SetVisibility();
		$this->hrg_image1->SetVisibility();
		$this->hrg_image2->SetVisibility();
		$this->hrg_image3->SetVisibility();
		$this->hrg_image4->SetVisibility();
		$this->hrg_image5->SetVisibility();
		$this->hrg_image6->SetVisibility();
		$this->hrg_image7->SetVisibility();
		$this->hrg_image8->SetVisibility();

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
		global $EW_EXPORT, $hotel_room_gallery;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_room_gallery);
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
			$this->Page_Terminate("hotel_room_gallerylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hotel_room_gallery class, hotel_room_galleryinfo.php

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
				$this->Page_Terminate("hotel_room_gallerylist.php"); // Return to list
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
		$this->hrgallery_id->setDbValue($rs->fields('hrgallery_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hrg_image1->setDbValue($rs->fields('hrg_image1'));
		$this->hrg_image2->setDbValue($rs->fields('hrg_image2'));
		$this->hrg_image3->setDbValue($rs->fields('hrg_image3'));
		$this->hrg_image4->setDbValue($rs->fields('hrg_image4'));
		$this->hrg_image5->setDbValue($rs->fields('hrg_image5'));
		$this->hrg_image6->setDbValue($rs->fields('hrg_image6'));
		$this->hrg_image7->setDbValue($rs->fields('hrg_image7'));
		$this->hrg_image8->setDbValue($rs->fields('hrg_image8'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hrgallery_id->DbValue = $row['hrgallery_id'];
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->hrg_image1->DbValue = $row['hrg_image1'];
		$this->hrg_image2->DbValue = $row['hrg_image2'];
		$this->hrg_image3->DbValue = $row['hrg_image3'];
		$this->hrg_image4->DbValue = $row['hrg_image4'];
		$this->hrg_image5->DbValue = $row['hrg_image5'];
		$this->hrg_image6->DbValue = $row['hrg_image6'];
		$this->hrg_image7->DbValue = $row['hrg_image7'];
		$this->hrg_image8->DbValue = $row['hrg_image8'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// hrgallery_id
		// hroom_id
		// hrg_image1
		// hrg_image2
		// hrg_image3
		// hrg_image4
		// hrg_image5
		// hrg_image6
		// hrg_image7
		// hrg_image8

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hrgallery_id
		$this->hrgallery_id->ViewValue = $this->hrgallery_id->CurrentValue;
		$this->hrgallery_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hrg_image1
		$this->hrg_image1->ViewValue = $this->hrg_image1->CurrentValue;
		$this->hrg_image1->ViewCustomAttributes = "";

		// hrg_image2
		$this->hrg_image2->ViewValue = $this->hrg_image2->CurrentValue;
		$this->hrg_image2->ViewCustomAttributes = "";

		// hrg_image3
		$this->hrg_image3->ViewValue = $this->hrg_image3->CurrentValue;
		$this->hrg_image3->ViewCustomAttributes = "";

		// hrg_image4
		$this->hrg_image4->ViewValue = $this->hrg_image4->CurrentValue;
		$this->hrg_image4->ViewCustomAttributes = "";

		// hrg_image5
		$this->hrg_image5->ViewValue = $this->hrg_image5->CurrentValue;
		$this->hrg_image5->ViewCustomAttributes = "";

		// hrg_image6
		$this->hrg_image6->ViewValue = $this->hrg_image6->CurrentValue;
		$this->hrg_image6->ViewCustomAttributes = "";

		// hrg_image7
		$this->hrg_image7->ViewValue = $this->hrg_image7->CurrentValue;
		$this->hrg_image7->ViewCustomAttributes = "";

		// hrg_image8
		$this->hrg_image8->ViewValue = $this->hrg_image8->CurrentValue;
		$this->hrg_image8->ViewCustomAttributes = "";

			// hrgallery_id
			$this->hrgallery_id->LinkCustomAttributes = "";
			$this->hrgallery_id->HrefValue = "";
			$this->hrgallery_id->TooltipValue = "";

			// hroom_id
			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";
			$this->hroom_id->TooltipValue = "";

			// hrg_image1
			$this->hrg_image1->LinkCustomAttributes = "";
			$this->hrg_image1->HrefValue = "";
			$this->hrg_image1->TooltipValue = "";

			// hrg_image2
			$this->hrg_image2->LinkCustomAttributes = "";
			$this->hrg_image2->HrefValue = "";
			$this->hrg_image2->TooltipValue = "";

			// hrg_image3
			$this->hrg_image3->LinkCustomAttributes = "";
			$this->hrg_image3->HrefValue = "";
			$this->hrg_image3->TooltipValue = "";

			// hrg_image4
			$this->hrg_image4->LinkCustomAttributes = "";
			$this->hrg_image4->HrefValue = "";
			$this->hrg_image4->TooltipValue = "";

			// hrg_image5
			$this->hrg_image5->LinkCustomAttributes = "";
			$this->hrg_image5->HrefValue = "";
			$this->hrg_image5->TooltipValue = "";

			// hrg_image6
			$this->hrg_image6->LinkCustomAttributes = "";
			$this->hrg_image6->HrefValue = "";
			$this->hrg_image6->TooltipValue = "";

			// hrg_image7
			$this->hrg_image7->LinkCustomAttributes = "";
			$this->hrg_image7->HrefValue = "";
			$this->hrg_image7->TooltipValue = "";

			// hrg_image8
			$this->hrg_image8->LinkCustomAttributes = "";
			$this->hrg_image8->HrefValue = "";
			$this->hrg_image8->TooltipValue = "";
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
				$sThisKey .= $row['hrgallery_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hroom_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_room_gallerylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_room_gallery_delete)) $hotel_room_gallery_delete = new chotel_room_gallery_delete();

// Page init
$hotel_room_gallery_delete->Page_Init();

// Page main
$hotel_room_gallery_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_room_gallery_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhotel_room_gallerydelete = new ew_Form("fhotel_room_gallerydelete", "delete");

// Form_CustomValidate event
fhotel_room_gallerydelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_room_gallerydelete.ValidateRequired = true;
<?php } else { ?>
fhotel_room_gallerydelete.ValidateRequired = false; 
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
<?php $hotel_room_gallery_delete->ShowPageHeader(); ?>
<?php
$hotel_room_gallery_delete->ShowMessage();
?>
<form name="fhotel_room_gallerydelete" id="fhotel_room_gallerydelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_room_gallery_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_room_gallery_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_room_gallery">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hotel_room_gallery_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $hotel_room_gallery->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($hotel_room_gallery->hrgallery_id->Visible) { // hrgallery_id ?>
		<th><span id="elh_hotel_room_gallery_hrgallery_id" class="hotel_room_gallery_hrgallery_id"><?php echo $hotel_room_gallery->hrgallery_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hroom_id->Visible) { // hroom_id ?>
		<th><span id="elh_hotel_room_gallery_hroom_id" class="hotel_room_gallery_hroom_id"><?php echo $hotel_room_gallery->hroom_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image1->Visible) { // hrg_image1 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image1" class="hotel_room_gallery_hrg_image1"><?php echo $hotel_room_gallery->hrg_image1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image2->Visible) { // hrg_image2 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image2" class="hotel_room_gallery_hrg_image2"><?php echo $hotel_room_gallery->hrg_image2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image3->Visible) { // hrg_image3 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image3" class="hotel_room_gallery_hrg_image3"><?php echo $hotel_room_gallery->hrg_image3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image4->Visible) { // hrg_image4 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image4" class="hotel_room_gallery_hrg_image4"><?php echo $hotel_room_gallery->hrg_image4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image5->Visible) { // hrg_image5 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image5" class="hotel_room_gallery_hrg_image5"><?php echo $hotel_room_gallery->hrg_image5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image6->Visible) { // hrg_image6 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image6" class="hotel_room_gallery_hrg_image6"><?php echo $hotel_room_gallery->hrg_image6->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image7->Visible) { // hrg_image7 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image7" class="hotel_room_gallery_hrg_image7"><?php echo $hotel_room_gallery->hrg_image7->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image8->Visible) { // hrg_image8 ?>
		<th><span id="elh_hotel_room_gallery_hrg_image8" class="hotel_room_gallery_hrg_image8"><?php echo $hotel_room_gallery->hrg_image8->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hotel_room_gallery_delete->RecCnt = 0;
$i = 0;
while (!$hotel_room_gallery_delete->Recordset->EOF) {
	$hotel_room_gallery_delete->RecCnt++;
	$hotel_room_gallery_delete->RowCnt++;

	// Set row properties
	$hotel_room_gallery->ResetAttrs();
	$hotel_room_gallery->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hotel_room_gallery_delete->LoadRowValues($hotel_room_gallery_delete->Recordset);

	// Render row
	$hotel_room_gallery_delete->RenderRow();
?>
	<tr<?php echo $hotel_room_gallery->RowAttributes() ?>>
<?php if ($hotel_room_gallery->hrgallery_id->Visible) { // hrgallery_id ?>
		<td<?php echo $hotel_room_gallery->hrgallery_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrgallery_id" class="hotel_room_gallery_hrgallery_id">
<span<?php echo $hotel_room_gallery->hrgallery_id->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrgallery_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hroom_id->Visible) { // hroom_id ?>
		<td<?php echo $hotel_room_gallery->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hroom_id" class="hotel_room_gallery_hroom_id">
<span<?php echo $hotel_room_gallery->hroom_id->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hroom_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image1->Visible) { // hrg_image1 ?>
		<td<?php echo $hotel_room_gallery->hrg_image1->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image1" class="hotel_room_gallery_hrg_image1">
<span<?php echo $hotel_room_gallery->hrg_image1->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image2->Visible) { // hrg_image2 ?>
		<td<?php echo $hotel_room_gallery->hrg_image2->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image2" class="hotel_room_gallery_hrg_image2">
<span<?php echo $hotel_room_gallery->hrg_image2->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image3->Visible) { // hrg_image3 ?>
		<td<?php echo $hotel_room_gallery->hrg_image3->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image3" class="hotel_room_gallery_hrg_image3">
<span<?php echo $hotel_room_gallery->hrg_image3->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image4->Visible) { // hrg_image4 ?>
		<td<?php echo $hotel_room_gallery->hrg_image4->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image4" class="hotel_room_gallery_hrg_image4">
<span<?php echo $hotel_room_gallery->hrg_image4->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image5->Visible) { // hrg_image5 ?>
		<td<?php echo $hotel_room_gallery->hrg_image5->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image5" class="hotel_room_gallery_hrg_image5">
<span<?php echo $hotel_room_gallery->hrg_image5->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image6->Visible) { // hrg_image6 ?>
		<td<?php echo $hotel_room_gallery->hrg_image6->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image6" class="hotel_room_gallery_hrg_image6">
<span<?php echo $hotel_room_gallery->hrg_image6->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image7->Visible) { // hrg_image7 ?>
		<td<?php echo $hotel_room_gallery->hrg_image7->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image7" class="hotel_room_gallery_hrg_image7">
<span<?php echo $hotel_room_gallery->hrg_image7->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image7->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image8->Visible) { // hrg_image8 ?>
		<td<?php echo $hotel_room_gallery->hrg_image8->CellAttributes() ?>>
<span id="el<?php echo $hotel_room_gallery_delete->RowCnt ?>_hotel_room_gallery_hrg_image8" class="hotel_room_gallery_hrg_image8">
<span<?php echo $hotel_room_gallery->hrg_image8->ViewAttributes() ?>>
<?php echo $hotel_room_gallery->hrg_image8->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hotel_room_gallery_delete->Recordset->MoveNext();
}
$hotel_room_gallery_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_room_gallery_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhotel_room_gallerydelete.Init();
</script>
<?php
$hotel_room_gallery_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_room_gallery_delete->Page_Terminate();
?>

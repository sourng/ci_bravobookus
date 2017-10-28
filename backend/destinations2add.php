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

$destinations2_add = NULL; // Initialize page object first

class cdestinations2_add extends cdestinations2 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'destinations2';

	// Page object name
	var $PageObjName = 'destinations2_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("destinations2list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->dest_name->SetVisibility();
		$this->dest_logo->SetVisibility();
		$this->dest_desc->SetVisibility();
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
			if (@$_GET["dest_id"] != "") {
				$this->dest_id->setQueryStringValue($_GET["dest_id"]);
				$this->setKey("dest_id", $this->dest_id->CurrentValue); // Set up key
			} else {
				$this->setKey("dest_id", ""); // Clear key
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
					$this->Page_Terminate("destinations2list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "destinations2list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "destinations2view.php")
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
		$this->dest_name->CurrentValue = "0";
		$this->dest_logo->CurrentValue = "0";
		$this->dest_desc->CurrentValue = NULL;
		$this->dest_desc->OldValue = $this->dest_desc->CurrentValue;
		$this->dest_meta_desc->CurrentValue = "0";
		$this->dest_meta_key->CurrentValue = "0";
		$this->dest_feature_image->CurrentValue = "0";
		$this->country_id->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->dest_name->FldIsDetailKey) {
			$this->dest_name->setFormValue($objForm->GetValue("x_dest_name"));
		}
		if (!$this->dest_logo->FldIsDetailKey) {
			$this->dest_logo->setFormValue($objForm->GetValue("x_dest_logo"));
		}
		if (!$this->dest_desc->FldIsDetailKey) {
			$this->dest_desc->setFormValue($objForm->GetValue("x_dest_desc"));
		}
		if (!$this->dest_meta_desc->FldIsDetailKey) {
			$this->dest_meta_desc->setFormValue($objForm->GetValue("x_dest_meta_desc"));
		}
		if (!$this->dest_meta_key->FldIsDetailKey) {
			$this->dest_meta_key->setFormValue($objForm->GetValue("x_dest_meta_key"));
		}
		if (!$this->dest_feature_image->FldIsDetailKey) {
			$this->dest_feature_image->setFormValue($objForm->GetValue("x_dest_feature_image"));
		}
		if (!$this->country_id->FldIsDetailKey) {
			$this->country_id->setFormValue($objForm->GetValue("x_country_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->dest_name->CurrentValue = $this->dest_name->FormValue;
		$this->dest_logo->CurrentValue = $this->dest_logo->FormValue;
		$this->dest_desc->CurrentValue = $this->dest_desc->FormValue;
		$this->dest_meta_desc->CurrentValue = $this->dest_meta_desc->FormValue;
		$this->dest_meta_key->CurrentValue = $this->dest_meta_key->FormValue;
		$this->dest_feature_image->CurrentValue = $this->dest_feature_image->FormValue;
		$this->country_id->CurrentValue = $this->country_id->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("dest_id")) <> "")
			$this->dest_id->CurrentValue = $this->getKey("dest_id"); // dest_id
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

		// dest_desc
		$this->dest_desc->ViewValue = $this->dest_desc->CurrentValue;
		$this->dest_desc->ViewCustomAttributes = "";

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

			// dest_name
			$this->dest_name->LinkCustomAttributes = "";
			$this->dest_name->HrefValue = "";
			$this->dest_name->TooltipValue = "";

			// dest_logo
			$this->dest_logo->LinkCustomAttributes = "";
			$this->dest_logo->HrefValue = "";
			$this->dest_logo->TooltipValue = "";

			// dest_desc
			$this->dest_desc->LinkCustomAttributes = "";
			$this->dest_desc->HrefValue = "";
			$this->dest_desc->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// dest_name
			$this->dest_name->EditAttrs["class"] = "form-control";
			$this->dest_name->EditCustomAttributes = "";
			$this->dest_name->EditValue = ew_HtmlEncode($this->dest_name->CurrentValue);
			$this->dest_name->PlaceHolder = ew_RemoveHtml($this->dest_name->FldCaption());

			// dest_logo
			$this->dest_logo->EditAttrs["class"] = "form-control";
			$this->dest_logo->EditCustomAttributes = "";
			$this->dest_logo->EditValue = ew_HtmlEncode($this->dest_logo->CurrentValue);
			$this->dest_logo->PlaceHolder = ew_RemoveHtml($this->dest_logo->FldCaption());

			// dest_desc
			$this->dest_desc->EditAttrs["class"] = "form-control";
			$this->dest_desc->EditCustomAttributes = "";
			$this->dest_desc->EditValue = ew_HtmlEncode($this->dest_desc->CurrentValue);
			$this->dest_desc->PlaceHolder = ew_RemoveHtml($this->dest_desc->FldCaption());

			// dest_meta_desc
			$this->dest_meta_desc->EditAttrs["class"] = "form-control";
			$this->dest_meta_desc->EditCustomAttributes = "";
			$this->dest_meta_desc->EditValue = ew_HtmlEncode($this->dest_meta_desc->CurrentValue);
			$this->dest_meta_desc->PlaceHolder = ew_RemoveHtml($this->dest_meta_desc->FldCaption());

			// dest_meta_key
			$this->dest_meta_key->EditAttrs["class"] = "form-control";
			$this->dest_meta_key->EditCustomAttributes = "";
			$this->dest_meta_key->EditValue = ew_HtmlEncode($this->dest_meta_key->CurrentValue);
			$this->dest_meta_key->PlaceHolder = ew_RemoveHtml($this->dest_meta_key->FldCaption());

			// dest_feature_image
			$this->dest_feature_image->EditAttrs["class"] = "form-control";
			$this->dest_feature_image->EditCustomAttributes = "";
			$this->dest_feature_image->EditValue = ew_HtmlEncode($this->dest_feature_image->CurrentValue);
			$this->dest_feature_image->PlaceHolder = ew_RemoveHtml($this->dest_feature_image->FldCaption());

			// country_id
			$this->country_id->EditAttrs["class"] = "form-control";
			$this->country_id->EditCustomAttributes = "";
			$this->country_id->EditValue = ew_HtmlEncode($this->country_id->CurrentValue);
			$this->country_id->PlaceHolder = ew_RemoveHtml($this->country_id->FldCaption());

			// Add refer script
			// dest_name

			$this->dest_name->LinkCustomAttributes = "";
			$this->dest_name->HrefValue = "";

			// dest_logo
			$this->dest_logo->LinkCustomAttributes = "";
			$this->dest_logo->HrefValue = "";

			// dest_desc
			$this->dest_desc->LinkCustomAttributes = "";
			$this->dest_desc->HrefValue = "";

			// dest_meta_desc
			$this->dest_meta_desc->LinkCustomAttributes = "";
			$this->dest_meta_desc->HrefValue = "";

			// dest_meta_key
			$this->dest_meta_key->LinkCustomAttributes = "";
			$this->dest_meta_key->HrefValue = "";

			// dest_feature_image
			$this->dest_feature_image->LinkCustomAttributes = "";
			$this->dest_feature_image->HrefValue = "";

			// country_id
			$this->country_id->LinkCustomAttributes = "";
			$this->country_id->HrefValue = "";
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
		if (!ew_CheckInteger($this->country_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->country_id->FldErrMsg());
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

		// dest_name
		$this->dest_name->SetDbValueDef($rsnew, $this->dest_name->CurrentValue, NULL, strval($this->dest_name->CurrentValue) == "");

		// dest_logo
		$this->dest_logo->SetDbValueDef($rsnew, $this->dest_logo->CurrentValue, NULL, strval($this->dest_logo->CurrentValue) == "");

		// dest_desc
		$this->dest_desc->SetDbValueDef($rsnew, $this->dest_desc->CurrentValue, NULL, FALSE);

		// dest_meta_desc
		$this->dest_meta_desc->SetDbValueDef($rsnew, $this->dest_meta_desc->CurrentValue, NULL, strval($this->dest_meta_desc->CurrentValue) == "");

		// dest_meta_key
		$this->dest_meta_key->SetDbValueDef($rsnew, $this->dest_meta_key->CurrentValue, NULL, strval($this->dest_meta_key->CurrentValue) == "");

		// dest_feature_image
		$this->dest_feature_image->SetDbValueDef($rsnew, $this->dest_feature_image->CurrentValue, NULL, strval($this->dest_feature_image->CurrentValue) == "");

		// country_id
		$this->country_id->SetDbValueDef($rsnew, $this->country_id->CurrentValue, NULL, strval($this->country_id->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("destinations2list.php"), "", $this->TableVar, TRUE);
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
if (!isset($destinations2_add)) $destinations2_add = new cdestinations2_add();

// Page init
$destinations2_add->Page_Init();

// Page main
$destinations2_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$destinations2_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdestinations2add = new ew_Form("fdestinations2add", "add");

// Validate form
fdestinations2add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_country_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($destinations2->country_id->FldErrMsg()) ?>");

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
fdestinations2add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdestinations2add.ValidateRequired = true;
<?php } else { ?>
fdestinations2add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$destinations2_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $destinations2_add->ShowPageHeader(); ?>
<?php
$destinations2_add->ShowMessage();
?>
<form name="fdestinations2add" id="fdestinations2add" class="<?php echo $destinations2_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($destinations2_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $destinations2_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="destinations2">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($destinations2_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($destinations2->dest_name->Visible) { // dest_name ?>
	<div id="r_dest_name" class="form-group">
		<label id="elh_destinations2_dest_name" for="x_dest_name" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_name->CellAttributes() ?>>
<span id="el_destinations2_dest_name">
<input type="text" data-table="destinations2" data-field="x_dest_name" name="x_dest_name" id="x_dest_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_name->getPlaceHolder()) ?>" value="<?php echo $destinations2->dest_name->EditValue ?>"<?php echo $destinations2->dest_name->EditAttributes() ?>>
</span>
<?php echo $destinations2->dest_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->dest_logo->Visible) { // dest_logo ?>
	<div id="r_dest_logo" class="form-group">
		<label id="elh_destinations2_dest_logo" for="x_dest_logo" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_logo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_logo->CellAttributes() ?>>
<span id="el_destinations2_dest_logo">
<input type="text" data-table="destinations2" data-field="x_dest_logo" name="x_dest_logo" id="x_dest_logo" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_logo->getPlaceHolder()) ?>" value="<?php echo $destinations2->dest_logo->EditValue ?>"<?php echo $destinations2->dest_logo->EditAttributes() ?>>
</span>
<?php echo $destinations2->dest_logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->dest_desc->Visible) { // dest_desc ?>
	<div id="r_dest_desc" class="form-group">
		<label id="elh_destinations2_dest_desc" for="x_dest_desc" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_desc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_desc->CellAttributes() ?>>
<span id="el_destinations2_dest_desc">
<textarea data-table="destinations2" data-field="x_dest_desc" name="x_dest_desc" id="x_dest_desc" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_desc->getPlaceHolder()) ?>"<?php echo $destinations2->dest_desc->EditAttributes() ?>><?php echo $destinations2->dest_desc->EditValue ?></textarea>
</span>
<?php echo $destinations2->dest_desc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->dest_meta_desc->Visible) { // dest_meta_desc ?>
	<div id="r_dest_meta_desc" class="form-group">
		<label id="elh_destinations2_dest_meta_desc" for="x_dest_meta_desc" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_meta_desc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_meta_desc->CellAttributes() ?>>
<span id="el_destinations2_dest_meta_desc">
<input type="text" data-table="destinations2" data-field="x_dest_meta_desc" name="x_dest_meta_desc" id="x_dest_meta_desc" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_meta_desc->getPlaceHolder()) ?>" value="<?php echo $destinations2->dest_meta_desc->EditValue ?>"<?php echo $destinations2->dest_meta_desc->EditAttributes() ?>>
</span>
<?php echo $destinations2->dest_meta_desc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->dest_meta_key->Visible) { // dest_meta_key ?>
	<div id="r_dest_meta_key" class="form-group">
		<label id="elh_destinations2_dest_meta_key" for="x_dest_meta_key" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_meta_key->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_meta_key->CellAttributes() ?>>
<span id="el_destinations2_dest_meta_key">
<input type="text" data-table="destinations2" data-field="x_dest_meta_key" name="x_dest_meta_key" id="x_dest_meta_key" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_meta_key->getPlaceHolder()) ?>" value="<?php echo $destinations2->dest_meta_key->EditValue ?>"<?php echo $destinations2->dest_meta_key->EditAttributes() ?>>
</span>
<?php echo $destinations2->dest_meta_key->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->dest_feature_image->Visible) { // dest_feature_image ?>
	<div id="r_dest_feature_image" class="form-group">
		<label id="elh_destinations2_dest_feature_image" for="x_dest_feature_image" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->dest_feature_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->dest_feature_image->CellAttributes() ?>>
<span id="el_destinations2_dest_feature_image">
<input type="text" data-table="destinations2" data-field="x_dest_feature_image" name="x_dest_feature_image" id="x_dest_feature_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations2->dest_feature_image->getPlaceHolder()) ?>" value="<?php echo $destinations2->dest_feature_image->EditValue ?>"<?php echo $destinations2->dest_feature_image->EditAttributes() ?>>
</span>
<?php echo $destinations2->dest_feature_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations2->country_id->Visible) { // country_id ?>
	<div id="r_country_id" class="form-group">
		<label id="elh_destinations2_country_id" for="x_country_id" class="col-sm-2 control-label ewLabel"><?php echo $destinations2->country_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations2->country_id->CellAttributes() ?>>
<span id="el_destinations2_country_id">
<input type="text" data-table="destinations2" data-field="x_country_id" name="x_country_id" id="x_country_id" size="30" placeholder="<?php echo ew_HtmlEncode($destinations2->country_id->getPlaceHolder()) ?>" value="<?php echo $destinations2->country_id->EditValue ?>"<?php echo $destinations2->country_id->EditAttributes() ?>>
</span>
<?php echo $destinations2->country_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$destinations2_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $destinations2_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdestinations2add.Init();
</script>
<?php
$destinations2_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$destinations2_add->Page_Terminate();
?>

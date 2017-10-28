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

$settings_add = NULL; // Initialize page object first

class csettings_add extends csettings {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'settings';

	// Page object name
	var $PageObjName = 'settings_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("settingslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
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
			if (@$_GET["setting_id"] != "") {
				$this->setting_id->setQueryStringValue($_GET["setting_id"]);
				$this->setKey("setting_id", $this->setting_id->CurrentValue); // Set up key
			} else {
				$this->setKey("setting_id", ""); // Clear key
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
					$this->Page_Terminate("settingslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "settingslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "settingsview.php")
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
		$this->logo->Upload->Index = $objForm->Index;
		$this->logo->Upload->UploadFile();
		$this->logo->CurrentValue = $this->logo->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->setting_id->CurrentValue = NULL;
		$this->setting_id->OldValue = $this->setting_id->CurrentValue;
		$this->site_name->CurrentValue = NULL;
		$this->site_name->OldValue = $this->site_name->CurrentValue;
		$this->logo->Upload->DbValue = NULL;
		$this->logo->OldValue = $this->logo->Upload->DbValue;
		$this->logo->CurrentValue = NULL; // Clear file related field
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->fax->CurrentValue = NULL;
		$this->fax->OldValue = $this->fax->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->address->CurrentValue = NULL;
		$this->address->OldValue = $this->address->CurrentValue;
		$this->note->CurrentValue = NULL;
		$this->note->OldValue = $this->note->CurrentValue;
		$this->facebook->CurrentValue = NULL;
		$this->facebook->OldValue = $this->facebook->CurrentValue;
		$this->twitter->CurrentValue = NULL;
		$this->twitter->OldValue = $this->twitter->CurrentValue;
		$this->gplus->CurrentValue = NULL;
		$this->gplus->OldValue = $this->gplus->CurrentValue;
		$this->youtube->CurrentValue = NULL;
		$this->youtube->OldValue = $this->youtube->CurrentValue;
		$this->linkin->CurrentValue = NULL;
		$this->linkin->OldValue = $this->linkin->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->setting_id->FldIsDetailKey) {
			$this->setting_id->setFormValue($objForm->GetValue("x_setting_id"));
		}
		if (!$this->site_name->FldIsDetailKey) {
			$this->site_name->setFormValue($objForm->GetValue("x_site_name"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->fax->FldIsDetailKey) {
			$this->fax->setFormValue($objForm->GetValue("x_fax"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->note->FldIsDetailKey) {
			$this->note->setFormValue($objForm->GetValue("x_note"));
		}
		if (!$this->facebook->FldIsDetailKey) {
			$this->facebook->setFormValue($objForm->GetValue("x_facebook"));
		}
		if (!$this->twitter->FldIsDetailKey) {
			$this->twitter->setFormValue($objForm->GetValue("x_twitter"));
		}
		if (!$this->gplus->FldIsDetailKey) {
			$this->gplus->setFormValue($objForm->GetValue("x_gplus"));
		}
		if (!$this->youtube->FldIsDetailKey) {
			$this->youtube->setFormValue($objForm->GetValue("x_youtube"));
		}
		if (!$this->linkin->FldIsDetailKey) {
			$this->linkin->setFormValue($objForm->GetValue("x_linkin"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->setting_id->CurrentValue = $this->setting_id->FormValue;
		$this->site_name->CurrentValue = $this->site_name->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->fax->CurrentValue = $this->fax->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->note->CurrentValue = $this->note->FormValue;
		$this->facebook->CurrentValue = $this->facebook->FormValue;
		$this->twitter->CurrentValue = $this->twitter->FormValue;
		$this->gplus->CurrentValue = $this->gplus->FormValue;
		$this->youtube->CurrentValue = $this->youtube->FormValue;
		$this->linkin->CurrentValue = $this->linkin->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("setting_id")) <> "")
			$this->setting_id->CurrentValue = $this->getKey("setting_id"); // setting_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// setting_id
			$this->setting_id->EditAttrs["class"] = "form-control";
			$this->setting_id->EditCustomAttributes = "";
			$this->setting_id->EditValue = ew_HtmlEncode($this->setting_id->CurrentValue);
			$this->setting_id->PlaceHolder = ew_RemoveHtml($this->setting_id->FldCaption());

			// site_name
			$this->site_name->EditAttrs["class"] = "form-control";
			$this->site_name->EditCustomAttributes = "";
			$this->site_name->EditValue = ew_HtmlEncode($this->site_name->CurrentValue);
			$this->site_name->PlaceHolder = ew_RemoveHtml($this->site_name->FldCaption());

			// logo
			$this->logo->EditAttrs["class"] = "form-control";
			$this->logo->EditCustomAttributes = "";
			$this->logo->UploadPath = "../public/img";
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->ImageAlt = $this->logo->FldAlt();
				$this->logo->EditValue = $this->logo->Upload->DbValue;
			} else {
				$this->logo->EditValue = "";
			}
			if (!ew_Empty($this->logo->CurrentValue))
				$this->logo->Upload->FileName = $this->logo->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->logo);

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// fax
			$this->fax->EditAttrs["class"] = "form-control";
			$this->fax->EditCustomAttributes = "";
			$this->fax->EditValue = ew_HtmlEncode($this->fax->CurrentValue);
			$this->fax->PlaceHolder = ew_RemoveHtml($this->fax->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// address
			$this->address->EditAttrs["class"] = "form-control";
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = ew_HtmlEncode($this->address->CurrentValue);
			$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

			// note
			$this->note->EditAttrs["class"] = "form-control";
			$this->note->EditCustomAttributes = "";
			$this->note->EditValue = ew_HtmlEncode($this->note->CurrentValue);
			$this->note->PlaceHolder = ew_RemoveHtml($this->note->FldCaption());

			// facebook
			$this->facebook->EditAttrs["class"] = "form-control";
			$this->facebook->EditCustomAttributes = "";
			$this->facebook->EditValue = ew_HtmlEncode($this->facebook->CurrentValue);
			$this->facebook->PlaceHolder = ew_RemoveHtml($this->facebook->FldCaption());

			// twitter
			$this->twitter->EditAttrs["class"] = "form-control";
			$this->twitter->EditCustomAttributes = "";
			$this->twitter->EditValue = ew_HtmlEncode($this->twitter->CurrentValue);
			$this->twitter->PlaceHolder = ew_RemoveHtml($this->twitter->FldCaption());

			// gplus
			$this->gplus->EditAttrs["class"] = "form-control";
			$this->gplus->EditCustomAttributes = "";
			$this->gplus->EditValue = ew_HtmlEncode($this->gplus->CurrentValue);
			$this->gplus->PlaceHolder = ew_RemoveHtml($this->gplus->FldCaption());

			// youtube
			$this->youtube->EditAttrs["class"] = "form-control";
			$this->youtube->EditCustomAttributes = "";
			$this->youtube->EditValue = ew_HtmlEncode($this->youtube->CurrentValue);
			$this->youtube->PlaceHolder = ew_RemoveHtml($this->youtube->FldCaption());

			// linkin
			$this->linkin->EditAttrs["class"] = "form-control";
			$this->linkin->EditCustomAttributes = "";
			$this->linkin->EditValue = ew_HtmlEncode($this->linkin->CurrentValue);
			$this->linkin->PlaceHolder = ew_RemoveHtml($this->linkin->FldCaption());

			// Add refer script
			// setting_id

			$this->setting_id->LinkCustomAttributes = "";
			$this->setting_id->HrefValue = "";

			// site_name
			$this->site_name->LinkCustomAttributes = "";
			$this->site_name->HrefValue = "";

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

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// fax
			$this->fax->LinkCustomAttributes = "";
			$this->fax->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// note
			$this->note->LinkCustomAttributes = "";
			$this->note->HrefValue = "";

			// facebook
			$this->facebook->LinkCustomAttributes = "";
			$this->facebook->HrefValue = "";

			// twitter
			$this->twitter->LinkCustomAttributes = "";
			$this->twitter->HrefValue = "";

			// gplus
			$this->gplus->LinkCustomAttributes = "";
			$this->gplus->HrefValue = "";

			// youtube
			$this->youtube->LinkCustomAttributes = "";
			$this->youtube->HrefValue = "";

			// linkin
			$this->linkin->LinkCustomAttributes = "";
			$this->linkin->HrefValue = "";
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
		if (!$this->setting_id->FldIsDetailKey && !is_null($this->setting_id->FormValue) && $this->setting_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->setting_id->FldCaption(), $this->setting_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->setting_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->setting_id->FldErrMsg());
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
			$this->logo->OldUploadPath = "../public/img";
			$this->logo->UploadPath = $this->logo->OldUploadPath;
		}
		$rsnew = array();

		// setting_id
		$this->setting_id->SetDbValueDef($rsnew, $this->setting_id->CurrentValue, 0, FALSE);

		// site_name
		$this->site_name->SetDbValueDef($rsnew, $this->site_name->CurrentValue, NULL, FALSE);

		// logo
		if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
			$this->logo->Upload->DbValue = ""; // No need to delete old file
			if ($this->logo->Upload->FileName == "") {
				$rsnew['logo'] = NULL;
			} else {
				$rsnew['logo'] = $this->logo->Upload->FileName;
			}
		}

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// fax
		$this->fax->SetDbValueDef($rsnew, $this->fax->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// address
		$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, FALSE);

		// note
		$this->note->SetDbValueDef($rsnew, $this->note->CurrentValue, NULL, FALSE);

		// facebook
		$this->facebook->SetDbValueDef($rsnew, $this->facebook->CurrentValue, NULL, FALSE);

		// twitter
		$this->twitter->SetDbValueDef($rsnew, $this->twitter->CurrentValue, NULL, FALSE);

		// gplus
		$this->gplus->SetDbValueDef($rsnew, $this->gplus->CurrentValue, NULL, FALSE);

		// youtube
		$this->youtube->SetDbValueDef($rsnew, $this->youtube->CurrentValue, NULL, FALSE);

		// linkin
		$this->linkin->SetDbValueDef($rsnew, $this->linkin->CurrentValue, NULL, FALSE);
		if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
			$this->logo->UploadPath = "../public/img";
			if (!ew_Empty($this->logo->Upload->Value)) {
				$rsnew['logo'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->logo->UploadPath), $rsnew['logo']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['setting_id']) == "") {
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
				if ($this->logo->Visible && !$this->logo->Upload->KeepFile) {
					if (!ew_Empty($this->logo->Upload->Value)) {
						if (!$this->logo->Upload->SaveToFile($this->logo->UploadPath, $rsnew['logo'], TRUE)) {
							$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
							return FALSE;
						}
					}
				}
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

		// logo
		ew_CleanUploadTempPath($this->logo, $this->logo->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("settingslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($settings_add)) $settings_add = new csettings_add();

// Page init
$settings_add->Page_Init();

// Page main
$settings_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$settings_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsettingsadd = new ew_Form("fsettingsadd", "add");

// Validate form
fsettingsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_setting_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $settings->setting_id->FldCaption(), $settings->setting_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_setting_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($settings->setting_id->FldErrMsg()) ?>");

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
fsettingsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsettingsadd.ValidateRequired = true;
<?php } else { ?>
fsettingsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$settings_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $settings_add->ShowPageHeader(); ?>
<?php
$settings_add->ShowMessage();
?>
<form name="fsettingsadd" id="fsettingsadd" class="<?php echo $settings_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($settings_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $settings_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="settings">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($settings_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($settings->setting_id->Visible) { // setting_id ?>
	<div id="r_setting_id" class="form-group">
		<label id="elh_settings_setting_id" for="x_setting_id" class="col-sm-2 control-label ewLabel"><?php echo $settings->setting_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $settings->setting_id->CellAttributes() ?>>
<span id="el_settings_setting_id">
<input type="text" data-table="settings" data-field="x_setting_id" name="x_setting_id" id="x_setting_id" size="30" placeholder="<?php echo ew_HtmlEncode($settings->setting_id->getPlaceHolder()) ?>" value="<?php echo $settings->setting_id->EditValue ?>"<?php echo $settings->setting_id->EditAttributes() ?>>
</span>
<?php echo $settings->setting_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->site_name->Visible) { // site_name ?>
	<div id="r_site_name" class="form-group">
		<label id="elh_settings_site_name" for="x_site_name" class="col-sm-2 control-label ewLabel"><?php echo $settings->site_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->site_name->CellAttributes() ?>>
<span id="el_settings_site_name">
<input type="text" data-table="settings" data-field="x_site_name" name="x_site_name" id="x_site_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->site_name->getPlaceHolder()) ?>" value="<?php echo $settings->site_name->EditValue ?>"<?php echo $settings->site_name->EditAttributes() ?>>
</span>
<?php echo $settings->site_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->logo->Visible) { // logo ?>
	<div id="r_logo" class="form-group">
		<label id="elh_settings_logo" class="col-sm-2 control-label ewLabel"><?php echo $settings->logo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->logo->CellAttributes() ?>>
<span id="el_settings_logo">
<div id="fd_x_logo">
<span title="<?php echo $settings->logo->FldTitle() ? $settings->logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($settings->logo->ReadOnly || $settings->logo->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="settings" data-field="x_logo" name="x_logo" id="x_logo"<?php echo $settings->logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_logo" id= "fn_x_logo" value="<?php echo $settings->logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_logo" id= "fa_x_logo" value="0">
<input type="hidden" name="fs_x_logo" id= "fs_x_logo" value="250">
<input type="hidden" name="fx_x_logo" id= "fx_x_logo" value="<?php echo $settings->logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_logo" id= "fm_x_logo" value="<?php echo $settings->logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $settings->logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_settings_phone" for="x_phone" class="col-sm-2 control-label ewLabel"><?php echo $settings->phone->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->phone->CellAttributes() ?>>
<span id="el_settings_phone">
<input type="text" data-table="settings" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->phone->getPlaceHolder()) ?>" value="<?php echo $settings->phone->EditValue ?>"<?php echo $settings->phone->EditAttributes() ?>>
</span>
<?php echo $settings->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->fax->Visible) { // fax ?>
	<div id="r_fax" class="form-group">
		<label id="elh_settings_fax" for="x_fax" class="col-sm-2 control-label ewLabel"><?php echo $settings->fax->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->fax->CellAttributes() ?>>
<span id="el_settings_fax">
<input type="text" data-table="settings" data-field="x_fax" name="x_fax" id="x_fax" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->fax->getPlaceHolder()) ?>" value="<?php echo $settings->fax->EditValue ?>"<?php echo $settings->fax->EditAttributes() ?>>
</span>
<?php echo $settings->fax->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_settings__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $settings->_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->_email->CellAttributes() ?>>
<span id="el_settings__email">
<input type="text" data-table="settings" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->_email->getPlaceHolder()) ?>" value="<?php echo $settings->_email->EditValue ?>"<?php echo $settings->_email->EditAttributes() ?>>
</span>
<?php echo $settings->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->address->Visible) { // address ?>
	<div id="r_address" class="form-group">
		<label id="elh_settings_address" for="x_address" class="col-sm-2 control-label ewLabel"><?php echo $settings->address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->address->CellAttributes() ?>>
<span id="el_settings_address">
<input type="text" data-table="settings" data-field="x_address" name="x_address" id="x_address" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->address->getPlaceHolder()) ?>" value="<?php echo $settings->address->EditValue ?>"<?php echo $settings->address->EditAttributes() ?>>
</span>
<?php echo $settings->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->note->Visible) { // note ?>
	<div id="r_note" class="form-group">
		<label id="elh_settings_note" for="x_note" class="col-sm-2 control-label ewLabel"><?php echo $settings->note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->note->CellAttributes() ?>>
<span id="el_settings_note">
<input type="text" data-table="settings" data-field="x_note" name="x_note" id="x_note" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->note->getPlaceHolder()) ?>" value="<?php echo $settings->note->EditValue ?>"<?php echo $settings->note->EditAttributes() ?>>
</span>
<?php echo $settings->note->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->facebook->Visible) { // facebook ?>
	<div id="r_facebook" class="form-group">
		<label id="elh_settings_facebook" for="x_facebook" class="col-sm-2 control-label ewLabel"><?php echo $settings->facebook->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->facebook->CellAttributes() ?>>
<span id="el_settings_facebook">
<input type="text" data-table="settings" data-field="x_facebook" name="x_facebook" id="x_facebook" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->facebook->getPlaceHolder()) ?>" value="<?php echo $settings->facebook->EditValue ?>"<?php echo $settings->facebook->EditAttributes() ?>>
</span>
<?php echo $settings->facebook->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->twitter->Visible) { // twitter ?>
	<div id="r_twitter" class="form-group">
		<label id="elh_settings_twitter" for="x_twitter" class="col-sm-2 control-label ewLabel"><?php echo $settings->twitter->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->twitter->CellAttributes() ?>>
<span id="el_settings_twitter">
<input type="text" data-table="settings" data-field="x_twitter" name="x_twitter" id="x_twitter" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->twitter->getPlaceHolder()) ?>" value="<?php echo $settings->twitter->EditValue ?>"<?php echo $settings->twitter->EditAttributes() ?>>
</span>
<?php echo $settings->twitter->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->gplus->Visible) { // gplus ?>
	<div id="r_gplus" class="form-group">
		<label id="elh_settings_gplus" for="x_gplus" class="col-sm-2 control-label ewLabel"><?php echo $settings->gplus->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->gplus->CellAttributes() ?>>
<span id="el_settings_gplus">
<input type="text" data-table="settings" data-field="x_gplus" name="x_gplus" id="x_gplus" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->gplus->getPlaceHolder()) ?>" value="<?php echo $settings->gplus->EditValue ?>"<?php echo $settings->gplus->EditAttributes() ?>>
</span>
<?php echo $settings->gplus->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->youtube->Visible) { // youtube ?>
	<div id="r_youtube" class="form-group">
		<label id="elh_settings_youtube" for="x_youtube" class="col-sm-2 control-label ewLabel"><?php echo $settings->youtube->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->youtube->CellAttributes() ?>>
<span id="el_settings_youtube">
<input type="text" data-table="settings" data-field="x_youtube" name="x_youtube" id="x_youtube" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->youtube->getPlaceHolder()) ?>" value="<?php echo $settings->youtube->EditValue ?>"<?php echo $settings->youtube->EditAttributes() ?>>
</span>
<?php echo $settings->youtube->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($settings->linkin->Visible) { // linkin ?>
	<div id="r_linkin" class="form-group">
		<label id="elh_settings_linkin" for="x_linkin" class="col-sm-2 control-label ewLabel"><?php echo $settings->linkin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $settings->linkin->CellAttributes() ?>>
<span id="el_settings_linkin">
<input type="text" data-table="settings" data-field="x_linkin" name="x_linkin" id="x_linkin" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($settings->linkin->getPlaceHolder()) ?>" value="<?php echo $settings->linkin->EditValue ?>"<?php echo $settings->linkin->EditAttributes() ?>>
</span>
<?php echo $settings->linkin->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$settings_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $settings_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fsettingsadd.Init();
</script>
<?php
$settings_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$settings_add->Page_Terminate();
?>

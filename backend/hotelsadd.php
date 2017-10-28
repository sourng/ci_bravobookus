<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotelsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotels_add = NULL; // Initialize page object first

class chotels_add extends chotels {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotels';

	// Page object name
	var $PageObjName = 'hotels_add';

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

		// Table object (hotels)
		if (!isset($GLOBALS["hotels"]) || get_class($GLOBALS["hotels"]) == "chotels") {
			$GLOBALS["hotels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotels"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotels', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotelslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->h_name->SetVisibility();
		$this->h_slug->SetVisibility();
		$this->h_feature_image->SetVisibility();
		$this->h_description->SetVisibility();
		$this->h_meta_key->SetVisibility();
		$this->h_deatail->SetVisibility();
		$this->h_facilities->SetVisibility();
		$this->h_address->SetVisibility();
		$this->h_create->SetVisibility();
		$this->dest_id->SetVisibility();
		$this->province->SetVisibility();
		$this->whylike->SetVisibility();
		$this->lang_spoken->SetVisibility();
		$this->map->SetVisibility();
		$this->what_todo->SetVisibility();
		$this->h_id_cod->SetVisibility();
		$this->h_email->SetVisibility();
		$this->h_contact_name->SetVisibility();
		$this->h_pass->SetVisibility();
		$this->h_contact_phone->SetVisibility();
		$this->h_site->SetVisibility();
		$this->contact_fax->SetVisibility();
		$this->star_rating->SetVisibility();
		$this->create_date->SetVisibility();
		$this->update_date->SetVisibility();
		$this->h_online_status->SetVisibility();
		$this->hotel_blocked->SetVisibility();

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
		global $EW_EXPORT, $hotels;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotels);
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
			if (@$_GET["hotel_id"] != "") {
				$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
				$this->setKey("hotel_id", $this->hotel_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hotel_id", ""); // Clear key
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
					$this->Page_Terminate("hotelslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "hotelslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "hotelsview.php")
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
		$this->h_feature_image->Upload->Index = $objForm->Index;
		$this->h_feature_image->Upload->UploadFile();
		$this->h_feature_image->CurrentValue = $this->h_feature_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->h_name->CurrentValue = NULL;
		$this->h_name->OldValue = $this->h_name->CurrentValue;
		$this->h_slug->CurrentValue = NULL;
		$this->h_slug->OldValue = $this->h_slug->CurrentValue;
		$this->h_feature_image->Upload->DbValue = NULL;
		$this->h_feature_image->OldValue = $this->h_feature_image->Upload->DbValue;
		$this->h_feature_image->CurrentValue = NULL; // Clear file related field
		$this->h_description->CurrentValue = NULL;
		$this->h_description->OldValue = $this->h_description->CurrentValue;
		$this->h_meta_key->CurrentValue = NULL;
		$this->h_meta_key->OldValue = $this->h_meta_key->CurrentValue;
		$this->h_deatail->CurrentValue = NULL;
		$this->h_deatail->OldValue = $this->h_deatail->CurrentValue;
		$this->h_facilities->CurrentValue = NULL;
		$this->h_facilities->OldValue = $this->h_facilities->CurrentValue;
		$this->h_address->CurrentValue = NULL;
		$this->h_address->OldValue = $this->h_address->CurrentValue;
		$this->h_create->CurrentValue = NULL;
		$this->h_create->OldValue = $this->h_create->CurrentValue;
		$this->dest_id->CurrentValue = NULL;
		$this->dest_id->OldValue = $this->dest_id->CurrentValue;
		$this->province->CurrentValue = NULL;
		$this->province->OldValue = $this->province->CurrentValue;
		$this->whylike->CurrentValue = NULL;
		$this->whylike->OldValue = $this->whylike->CurrentValue;
		$this->lang_spoken->CurrentValue = NULL;
		$this->lang_spoken->OldValue = $this->lang_spoken->CurrentValue;
		$this->map->CurrentValue = NULL;
		$this->map->OldValue = $this->map->CurrentValue;
		$this->what_todo->CurrentValue = NULL;
		$this->what_todo->OldValue = $this->what_todo->CurrentValue;
		$this->h_id_cod->CurrentValue = NULL;
		$this->h_id_cod->OldValue = $this->h_id_cod->CurrentValue;
		$this->h_email->CurrentValue = NULL;
		$this->h_email->OldValue = $this->h_email->CurrentValue;
		$this->h_contact_name->CurrentValue = NULL;
		$this->h_contact_name->OldValue = $this->h_contact_name->CurrentValue;
		$this->h_pass->CurrentValue = NULL;
		$this->h_pass->OldValue = $this->h_pass->CurrentValue;
		$this->h_contact_phone->CurrentValue = NULL;
		$this->h_contact_phone->OldValue = $this->h_contact_phone->CurrentValue;
		$this->h_site->CurrentValue = NULL;
		$this->h_site->OldValue = $this->h_site->CurrentValue;
		$this->contact_fax->CurrentValue = NULL;
		$this->contact_fax->OldValue = $this->contact_fax->CurrentValue;
		$this->star_rating->CurrentValue = NULL;
		$this->star_rating->OldValue = $this->star_rating->CurrentValue;
		$this->create_date->CurrentValue = NULL;
		$this->create_date->OldValue = $this->create_date->CurrentValue;
		$this->update_date->CurrentValue = NULL;
		$this->update_date->OldValue = $this->update_date->CurrentValue;
		$this->h_online_status->CurrentValue = NULL;
		$this->h_online_status->OldValue = $this->h_online_status->CurrentValue;
		$this->hotel_blocked->CurrentValue = NULL;
		$this->hotel_blocked->OldValue = $this->hotel_blocked->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->h_name->FldIsDetailKey) {
			$this->h_name->setFormValue($objForm->GetValue("x_h_name"));
		}
		if (!$this->h_slug->FldIsDetailKey) {
			$this->h_slug->setFormValue($objForm->GetValue("x_h_slug"));
		}
		if (!$this->h_description->FldIsDetailKey) {
			$this->h_description->setFormValue($objForm->GetValue("x_h_description"));
		}
		if (!$this->h_meta_key->FldIsDetailKey) {
			$this->h_meta_key->setFormValue($objForm->GetValue("x_h_meta_key"));
		}
		if (!$this->h_deatail->FldIsDetailKey) {
			$this->h_deatail->setFormValue($objForm->GetValue("x_h_deatail"));
		}
		if (!$this->h_facilities->FldIsDetailKey) {
			$this->h_facilities->setFormValue($objForm->GetValue("x_h_facilities"));
		}
		if (!$this->h_address->FldIsDetailKey) {
			$this->h_address->setFormValue($objForm->GetValue("x_h_address"));
		}
		if (!$this->h_create->FldIsDetailKey) {
			$this->h_create->setFormValue($objForm->GetValue("x_h_create"));
			$this->h_create->CurrentValue = ew_UnFormatDateTime($this->h_create->CurrentValue, 0);
		}
		if (!$this->dest_id->FldIsDetailKey) {
			$this->dest_id->setFormValue($objForm->GetValue("x_dest_id"));
		}
		if (!$this->province->FldIsDetailKey) {
			$this->province->setFormValue($objForm->GetValue("x_province"));
		}
		if (!$this->whylike->FldIsDetailKey) {
			$this->whylike->setFormValue($objForm->GetValue("x_whylike"));
		}
		if (!$this->lang_spoken->FldIsDetailKey) {
			$this->lang_spoken->setFormValue($objForm->GetValue("x_lang_spoken"));
		}
		if (!$this->map->FldIsDetailKey) {
			$this->map->setFormValue($objForm->GetValue("x_map"));
		}
		if (!$this->what_todo->FldIsDetailKey) {
			$this->what_todo->setFormValue($objForm->GetValue("x_what_todo"));
		}
		if (!$this->h_id_cod->FldIsDetailKey) {
			$this->h_id_cod->setFormValue($objForm->GetValue("x_h_id_cod"));
		}
		if (!$this->h_email->FldIsDetailKey) {
			$this->h_email->setFormValue($objForm->GetValue("x_h_email"));
		}
		if (!$this->h_contact_name->FldIsDetailKey) {
			$this->h_contact_name->setFormValue($objForm->GetValue("x_h_contact_name"));
		}
		if (!$this->h_pass->FldIsDetailKey) {
			$this->h_pass->setFormValue($objForm->GetValue("x_h_pass"));
		}
		if (!$this->h_contact_phone->FldIsDetailKey) {
			$this->h_contact_phone->setFormValue($objForm->GetValue("x_h_contact_phone"));
		}
		if (!$this->h_site->FldIsDetailKey) {
			$this->h_site->setFormValue($objForm->GetValue("x_h_site"));
		}
		if (!$this->contact_fax->FldIsDetailKey) {
			$this->contact_fax->setFormValue($objForm->GetValue("x_contact_fax"));
		}
		if (!$this->star_rating->FldIsDetailKey) {
			$this->star_rating->setFormValue($objForm->GetValue("x_star_rating"));
		}
		if (!$this->create_date->FldIsDetailKey) {
			$this->create_date->setFormValue($objForm->GetValue("x_create_date"));
			$this->create_date->CurrentValue = ew_UnFormatDateTime($this->create_date->CurrentValue, 1);
		}
		if (!$this->update_date->FldIsDetailKey) {
			$this->update_date->setFormValue($objForm->GetValue("x_update_date"));
			$this->update_date->CurrentValue = ew_UnFormatDateTime($this->update_date->CurrentValue, 2);
		}
		if (!$this->h_online_status->FldIsDetailKey) {
			$this->h_online_status->setFormValue($objForm->GetValue("x_h_online_status"));
		}
		if (!$this->hotel_blocked->FldIsDetailKey) {
			$this->hotel_blocked->setFormValue($objForm->GetValue("x_hotel_blocked"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->h_name->CurrentValue = $this->h_name->FormValue;
		$this->h_slug->CurrentValue = $this->h_slug->FormValue;
		$this->h_description->CurrentValue = $this->h_description->FormValue;
		$this->h_meta_key->CurrentValue = $this->h_meta_key->FormValue;
		$this->h_deatail->CurrentValue = $this->h_deatail->FormValue;
		$this->h_facilities->CurrentValue = $this->h_facilities->FormValue;
		$this->h_address->CurrentValue = $this->h_address->FormValue;
		$this->h_create->CurrentValue = $this->h_create->FormValue;
		$this->h_create->CurrentValue = ew_UnFormatDateTime($this->h_create->CurrentValue, 0);
		$this->dest_id->CurrentValue = $this->dest_id->FormValue;
		$this->province->CurrentValue = $this->province->FormValue;
		$this->whylike->CurrentValue = $this->whylike->FormValue;
		$this->lang_spoken->CurrentValue = $this->lang_spoken->FormValue;
		$this->map->CurrentValue = $this->map->FormValue;
		$this->what_todo->CurrentValue = $this->what_todo->FormValue;
		$this->h_id_cod->CurrentValue = $this->h_id_cod->FormValue;
		$this->h_email->CurrentValue = $this->h_email->FormValue;
		$this->h_contact_name->CurrentValue = $this->h_contact_name->FormValue;
		$this->h_pass->CurrentValue = $this->h_pass->FormValue;
		$this->h_contact_phone->CurrentValue = $this->h_contact_phone->FormValue;
		$this->h_site->CurrentValue = $this->h_site->FormValue;
		$this->contact_fax->CurrentValue = $this->contact_fax->FormValue;
		$this->star_rating->CurrentValue = $this->star_rating->FormValue;
		$this->create_date->CurrentValue = $this->create_date->FormValue;
		$this->create_date->CurrentValue = ew_UnFormatDateTime($this->create_date->CurrentValue, 1);
		$this->update_date->CurrentValue = $this->update_date->FormValue;
		$this->update_date->CurrentValue = ew_UnFormatDateTime($this->update_date->CurrentValue, 2);
		$this->h_online_status->CurrentValue = $this->h_online_status->FormValue;
		$this->hotel_blocked->CurrentValue = $this->hotel_blocked->FormValue;
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
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->h_name->setDbValue($rs->fields('h_name'));
		$this->h_slug->setDbValue($rs->fields('h_slug'));
		$this->h_feature_image->Upload->DbValue = $rs->fields('h_feature_image');
		$this->h_feature_image->CurrentValue = $this->h_feature_image->Upload->DbValue;
		$this->h_description->setDbValue($rs->fields('h_description'));
		$this->h_meta_key->setDbValue($rs->fields('h_meta_key'));
		$this->h_deatail->setDbValue($rs->fields('h_deatail'));
		$this->h_facilities->setDbValue($rs->fields('h_facilities'));
		$this->h_address->setDbValue($rs->fields('h_address'));
		$this->h_create->setDbValue($rs->fields('h_create'));
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->province->setDbValue($rs->fields('province'));
		$this->whylike->setDbValue($rs->fields('whylike'));
		$this->lang_spoken->setDbValue($rs->fields('lang_spoken'));
		$this->map->setDbValue($rs->fields('map'));
		$this->what_todo->setDbValue($rs->fields('what_todo'));
		$this->h_id_cod->setDbValue($rs->fields('h_id_cod'));
		$this->h_email->setDbValue($rs->fields('h_email'));
		$this->h_contact_name->setDbValue($rs->fields('h_contact_name'));
		$this->h_pass->setDbValue($rs->fields('h_pass'));
		$this->h_contact_phone->setDbValue($rs->fields('h_contact_phone'));
		$this->h_site->setDbValue($rs->fields('h_site'));
		$this->contact_fax->setDbValue($rs->fields('contact_fax'));
		$this->star_rating->setDbValue($rs->fields('star_rating'));
		$this->create_date->setDbValue($rs->fields('create_date'));
		$this->update_date->setDbValue($rs->fields('update_date'));
		$this->h_online_status->setDbValue($rs->fields('h_online_status'));
		$this->hotel_blocked->setDbValue($rs->fields('hotel_blocked'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->h_name->DbValue = $row['h_name'];
		$this->h_slug->DbValue = $row['h_slug'];
		$this->h_feature_image->Upload->DbValue = $row['h_feature_image'];
		$this->h_description->DbValue = $row['h_description'];
		$this->h_meta_key->DbValue = $row['h_meta_key'];
		$this->h_deatail->DbValue = $row['h_deatail'];
		$this->h_facilities->DbValue = $row['h_facilities'];
		$this->h_address->DbValue = $row['h_address'];
		$this->h_create->DbValue = $row['h_create'];
		$this->dest_id->DbValue = $row['dest_id'];
		$this->province->DbValue = $row['province'];
		$this->whylike->DbValue = $row['whylike'];
		$this->lang_spoken->DbValue = $row['lang_spoken'];
		$this->map->DbValue = $row['map'];
		$this->what_todo->DbValue = $row['what_todo'];
		$this->h_id_cod->DbValue = $row['h_id_cod'];
		$this->h_email->DbValue = $row['h_email'];
		$this->h_contact_name->DbValue = $row['h_contact_name'];
		$this->h_pass->DbValue = $row['h_pass'];
		$this->h_contact_phone->DbValue = $row['h_contact_phone'];
		$this->h_site->DbValue = $row['h_site'];
		$this->contact_fax->DbValue = $row['contact_fax'];
		$this->star_rating->DbValue = $row['star_rating'];
		$this->create_date->DbValue = $row['create_date'];
		$this->update_date->DbValue = $row['update_date'];
		$this->h_online_status->DbValue = $row['h_online_status'];
		$this->hotel_blocked->DbValue = $row['hotel_blocked'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("hotel_id")) <> "")
			$this->hotel_id->CurrentValue = $this->getKey("hotel_id"); // hotel_id
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
		// hotel_id
		// h_name
		// h_slug
		// h_feature_image
		// h_description
		// h_meta_key
		// h_deatail
		// h_facilities
		// h_address
		// h_create
		// dest_id
		// province
		// whylike
		// lang_spoken
		// map
		// what_todo
		// h_id_cod
		// h_email
		// h_contact_name
		// h_pass
		// h_contact_phone
		// h_site
		// contact_fax
		// star_rating
		// create_date
		// update_date
		// h_online_status
		// hotel_blocked

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// h_name
		$this->h_name->ViewValue = $this->h_name->CurrentValue;
		$this->h_name->ViewCustomAttributes = "";

		// h_slug
		$this->h_slug->ViewValue = $this->h_slug->CurrentValue;
		$this->h_slug->ViewCustomAttributes = "";

		// h_feature_image
		$this->h_feature_image->UploadPath = "../uploads/hotels";
		if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
			$this->h_feature_image->ImageAlt = $this->h_feature_image->FldAlt();
			$this->h_feature_image->ViewValue = $this->h_feature_image->Upload->DbValue;
		} else {
			$this->h_feature_image->ViewValue = "";
		}
		$this->h_feature_image->ViewCustomAttributes = "";

		// h_description
		$this->h_description->ViewValue = $this->h_description->CurrentValue;
		$this->h_description->ViewCustomAttributes = "";

		// h_meta_key
		$this->h_meta_key->ViewValue = $this->h_meta_key->CurrentValue;
		$this->h_meta_key->ViewCustomAttributes = "";

		// h_deatail
		$this->h_deatail->ViewValue = $this->h_deatail->CurrentValue;
		$this->h_deatail->ViewCustomAttributes = "";

		// h_facilities
		$this->h_facilities->ViewValue = $this->h_facilities->CurrentValue;
		$this->h_facilities->ViewCustomAttributes = "";

		// h_address
		$this->h_address->ViewValue = $this->h_address->CurrentValue;
		$this->h_address->ViewCustomAttributes = "";

		// h_create
		$this->h_create->ViewValue = $this->h_create->CurrentValue;
		$this->h_create->ViewValue = ew_FormatDateTime($this->h_create->ViewValue, 0);
		$this->h_create->ViewCustomAttributes = "";

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// province
		$this->province->ViewValue = $this->province->CurrentValue;
		$this->province->ViewCustomAttributes = "";

		// whylike
		$this->whylike->ViewValue = $this->whylike->CurrentValue;
		$this->whylike->ViewCustomAttributes = "";

		// lang_spoken
		$this->lang_spoken->ViewValue = $this->lang_spoken->CurrentValue;
		$this->lang_spoken->ViewCustomAttributes = "";

		// map
		$this->map->ViewValue = $this->map->CurrentValue;
		$this->map->ViewCustomAttributes = "";

		// what_todo
		$this->what_todo->ViewValue = $this->what_todo->CurrentValue;
		$this->what_todo->ViewCustomAttributes = "";

		// h_id_cod
		$this->h_id_cod->ViewValue = $this->h_id_cod->CurrentValue;
		$this->h_id_cod->ViewCustomAttributes = "";

		// h_email
		$this->h_email->ViewValue = $this->h_email->CurrentValue;
		$this->h_email->ViewCustomAttributes = "";

		// h_contact_name
		$this->h_contact_name->ViewValue = $this->h_contact_name->CurrentValue;
		$this->h_contact_name->ViewCustomAttributes = "";

		// h_pass
		$this->h_pass->ViewValue = $this->h_pass->CurrentValue;
		$this->h_pass->ViewCustomAttributes = "";

		// h_contact_phone
		$this->h_contact_phone->ViewValue = $this->h_contact_phone->CurrentValue;
		$this->h_contact_phone->ViewCustomAttributes = "";

		// h_site
		$this->h_site->ViewValue = $this->h_site->CurrentValue;
		$this->h_site->ViewCustomAttributes = "";

		// contact_fax
		$this->contact_fax->ViewValue = $this->contact_fax->CurrentValue;
		$this->contact_fax->ViewCustomAttributes = "";

		// star_rating
		$this->star_rating->ViewValue = $this->star_rating->CurrentValue;
		$this->star_rating->ViewCustomAttributes = "";

		// create_date
		$this->create_date->ViewValue = $this->create_date->CurrentValue;
		$this->create_date->ViewValue = ew_FormatDateTime($this->create_date->ViewValue, 1);
		$this->create_date->ViewCustomAttributes = "";

		// update_date
		$this->update_date->ViewValue = $this->update_date->CurrentValue;
		$this->update_date->ViewValue = ew_FormatDateTime($this->update_date->ViewValue, 2);
		$this->update_date->ViewCustomAttributes = "";

		// h_online_status
		if (ew_ConvertToBool($this->h_online_status->CurrentValue)) {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(1) <> "" ? $this->h_online_status->FldTagCaption(1) : "Yes";
		} else {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(2) <> "" ? $this->h_online_status->FldTagCaption(2) : "No";
		}
		$this->h_online_status->ViewCustomAttributes = "";

		// hotel_blocked
		if (ew_ConvertToBool($this->hotel_blocked->CurrentValue)) {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(1) <> "" ? $this->hotel_blocked->FldTagCaption(1) : "Yes";
		} else {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(2) <> "" ? $this->hotel_blocked->FldTagCaption(2) : "No";
		}
		$this->hotel_blocked->ViewCustomAttributes = "";

			// h_name
			$this->h_name->LinkCustomAttributes = "";
			$this->h_name->HrefValue = "";
			$this->h_name->TooltipValue = "";

			// h_slug
			$this->h_slug->LinkCustomAttributes = "";
			$this->h_slug->HrefValue = "";
			$this->h_slug->TooltipValue = "";

			// h_feature_image
			$this->h_feature_image->LinkCustomAttributes = "";
			$this->h_feature_image->UploadPath = "../uploads/hotels";
			if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
				$this->h_feature_image->HrefValue = ew_GetFileUploadUrl($this->h_feature_image, $this->h_feature_image->Upload->DbValue); // Add prefix/suffix
				$this->h_feature_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->h_feature_image->HrefValue = ew_ConvertFullUrl($this->h_feature_image->HrefValue);
			} else {
				$this->h_feature_image->HrefValue = "";
			}
			$this->h_feature_image->HrefValue2 = $this->h_feature_image->UploadPath . $this->h_feature_image->Upload->DbValue;
			$this->h_feature_image->TooltipValue = "";
			if ($this->h_feature_image->UseColorbox) {
				if (ew_Empty($this->h_feature_image->TooltipValue))
					$this->h_feature_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->h_feature_image->LinkAttrs["data-rel"] = "hotels_x_h_feature_image";
				ew_AppendClass($this->h_feature_image->LinkAttrs["class"], "ewLightbox");
			}

			// h_description
			$this->h_description->LinkCustomAttributes = "";
			$this->h_description->HrefValue = "";
			$this->h_description->TooltipValue = "";

			// h_meta_key
			$this->h_meta_key->LinkCustomAttributes = "";
			$this->h_meta_key->HrefValue = "";
			$this->h_meta_key->TooltipValue = "";

			// h_deatail
			$this->h_deatail->LinkCustomAttributes = "";
			$this->h_deatail->HrefValue = "";
			$this->h_deatail->TooltipValue = "";

			// h_facilities
			$this->h_facilities->LinkCustomAttributes = "";
			$this->h_facilities->HrefValue = "";
			$this->h_facilities->TooltipValue = "";

			// h_address
			$this->h_address->LinkCustomAttributes = "";
			$this->h_address->HrefValue = "";
			$this->h_address->TooltipValue = "";

			// h_create
			$this->h_create->LinkCustomAttributes = "";
			$this->h_create->HrefValue = "";
			$this->h_create->TooltipValue = "";

			// dest_id
			$this->dest_id->LinkCustomAttributes = "";
			$this->dest_id->HrefValue = "";
			$this->dest_id->TooltipValue = "";

			// province
			$this->province->LinkCustomAttributes = "";
			$this->province->HrefValue = "";
			$this->province->TooltipValue = "";

			// whylike
			$this->whylike->LinkCustomAttributes = "";
			$this->whylike->HrefValue = "";
			$this->whylike->TooltipValue = "";

			// lang_spoken
			$this->lang_spoken->LinkCustomAttributes = "";
			$this->lang_spoken->HrefValue = "";
			$this->lang_spoken->TooltipValue = "";

			// map
			$this->map->LinkCustomAttributes = "";
			$this->map->HrefValue = "";
			$this->map->TooltipValue = "";

			// what_todo
			$this->what_todo->LinkCustomAttributes = "";
			$this->what_todo->HrefValue = "";
			$this->what_todo->TooltipValue = "";

			// h_id_cod
			$this->h_id_cod->LinkCustomAttributes = "";
			$this->h_id_cod->HrefValue = "";
			$this->h_id_cod->TooltipValue = "";

			// h_email
			$this->h_email->LinkCustomAttributes = "";
			$this->h_email->HrefValue = "";
			$this->h_email->TooltipValue = "";

			// h_contact_name
			$this->h_contact_name->LinkCustomAttributes = "";
			$this->h_contact_name->HrefValue = "";
			$this->h_contact_name->TooltipValue = "";

			// h_pass
			$this->h_pass->LinkCustomAttributes = "";
			$this->h_pass->HrefValue = "";
			$this->h_pass->TooltipValue = "";

			// h_contact_phone
			$this->h_contact_phone->LinkCustomAttributes = "";
			$this->h_contact_phone->HrefValue = "";
			$this->h_contact_phone->TooltipValue = "";

			// h_site
			$this->h_site->LinkCustomAttributes = "";
			$this->h_site->HrefValue = "";
			$this->h_site->TooltipValue = "";

			// contact_fax
			$this->contact_fax->LinkCustomAttributes = "";
			$this->contact_fax->HrefValue = "";
			$this->contact_fax->TooltipValue = "";

			// star_rating
			$this->star_rating->LinkCustomAttributes = "";
			$this->star_rating->HrefValue = "";
			$this->star_rating->TooltipValue = "";

			// create_date
			$this->create_date->LinkCustomAttributes = "";
			$this->create_date->HrefValue = "";
			$this->create_date->TooltipValue = "";

			// update_date
			$this->update_date->LinkCustomAttributes = "";
			$this->update_date->HrefValue = "";
			$this->update_date->TooltipValue = "";

			// h_online_status
			$this->h_online_status->LinkCustomAttributes = "";
			$this->h_online_status->HrefValue = "";
			$this->h_online_status->TooltipValue = "";

			// hotel_blocked
			$this->hotel_blocked->LinkCustomAttributes = "";
			$this->hotel_blocked->HrefValue = "";
			$this->hotel_blocked->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// h_name
			$this->h_name->EditAttrs["class"] = "form-control";
			$this->h_name->EditCustomAttributes = "";
			$this->h_name->EditValue = ew_HtmlEncode($this->h_name->CurrentValue);
			$this->h_name->PlaceHolder = ew_RemoveHtml($this->h_name->FldCaption());

			// h_slug
			$this->h_slug->EditAttrs["class"] = "form-control";
			$this->h_slug->EditCustomAttributes = "";
			$this->h_slug->EditValue = ew_HtmlEncode($this->h_slug->CurrentValue);
			$this->h_slug->PlaceHolder = ew_RemoveHtml($this->h_slug->FldCaption());

			// h_feature_image
			$this->h_feature_image->EditAttrs["class"] = "form-control";
			$this->h_feature_image->EditCustomAttributes = "";
			$this->h_feature_image->UploadPath = "../uploads/hotels";
			if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
				$this->h_feature_image->ImageAlt = $this->h_feature_image->FldAlt();
				$this->h_feature_image->EditValue = $this->h_feature_image->Upload->DbValue;
			} else {
				$this->h_feature_image->EditValue = "";
			}
			if (!ew_Empty($this->h_feature_image->CurrentValue))
				$this->h_feature_image->Upload->FileName = $this->h_feature_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->h_feature_image);

			// h_description
			$this->h_description->EditAttrs["class"] = "form-control";
			$this->h_description->EditCustomAttributes = "";
			$this->h_description->EditValue = ew_HtmlEncode($this->h_description->CurrentValue);
			$this->h_description->PlaceHolder = ew_RemoveHtml($this->h_description->FldCaption());

			// h_meta_key
			$this->h_meta_key->EditAttrs["class"] = "form-control";
			$this->h_meta_key->EditCustomAttributes = "";
			$this->h_meta_key->EditValue = ew_HtmlEncode($this->h_meta_key->CurrentValue);
			$this->h_meta_key->PlaceHolder = ew_RemoveHtml($this->h_meta_key->FldCaption());

			// h_deatail
			$this->h_deatail->EditAttrs["class"] = "form-control";
			$this->h_deatail->EditCustomAttributes = "";
			$this->h_deatail->EditValue = ew_HtmlEncode($this->h_deatail->CurrentValue);
			$this->h_deatail->PlaceHolder = ew_RemoveHtml($this->h_deatail->FldCaption());

			// h_facilities
			$this->h_facilities->EditAttrs["class"] = "form-control";
			$this->h_facilities->EditCustomAttributes = "";
			$this->h_facilities->EditValue = ew_HtmlEncode($this->h_facilities->CurrentValue);
			$this->h_facilities->PlaceHolder = ew_RemoveHtml($this->h_facilities->FldCaption());

			// h_address
			$this->h_address->EditAttrs["class"] = "form-control";
			$this->h_address->EditCustomAttributes = "";
			$this->h_address->EditValue = ew_HtmlEncode($this->h_address->CurrentValue);
			$this->h_address->PlaceHolder = ew_RemoveHtml($this->h_address->FldCaption());

			// h_create
			$this->h_create->EditAttrs["class"] = "form-control";
			$this->h_create->EditCustomAttributes = "";
			$this->h_create->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->h_create->CurrentValue, 8));
			$this->h_create->PlaceHolder = ew_RemoveHtml($this->h_create->FldCaption());

			// dest_id
			$this->dest_id->EditAttrs["class"] = "form-control";
			$this->dest_id->EditCustomAttributes = "";
			$this->dest_id->EditValue = ew_HtmlEncode($this->dest_id->CurrentValue);
			$this->dest_id->PlaceHolder = ew_RemoveHtml($this->dest_id->FldCaption());

			// province
			$this->province->EditAttrs["class"] = "form-control";
			$this->province->EditCustomAttributes = "";
			$this->province->EditValue = ew_HtmlEncode($this->province->CurrentValue);
			$this->province->PlaceHolder = ew_RemoveHtml($this->province->FldCaption());

			// whylike
			$this->whylike->EditAttrs["class"] = "form-control";
			$this->whylike->EditCustomAttributes = "";
			$this->whylike->EditValue = ew_HtmlEncode($this->whylike->CurrentValue);
			$this->whylike->PlaceHolder = ew_RemoveHtml($this->whylike->FldCaption());

			// lang_spoken
			$this->lang_spoken->EditAttrs["class"] = "form-control";
			$this->lang_spoken->EditCustomAttributes = "";
			$this->lang_spoken->EditValue = ew_HtmlEncode($this->lang_spoken->CurrentValue);
			$this->lang_spoken->PlaceHolder = ew_RemoveHtml($this->lang_spoken->FldCaption());

			// map
			$this->map->EditAttrs["class"] = "form-control";
			$this->map->EditCustomAttributes = "";
			$this->map->EditValue = ew_HtmlEncode($this->map->CurrentValue);
			$this->map->PlaceHolder = ew_RemoveHtml($this->map->FldCaption());

			// what_todo
			$this->what_todo->EditAttrs["class"] = "form-control";
			$this->what_todo->EditCustomAttributes = "";
			$this->what_todo->EditValue = ew_HtmlEncode($this->what_todo->CurrentValue);
			$this->what_todo->PlaceHolder = ew_RemoveHtml($this->what_todo->FldCaption());

			// h_id_cod
			$this->h_id_cod->EditAttrs["class"] = "form-control";
			$this->h_id_cod->EditCustomAttributes = "";
			$this->h_id_cod->EditValue = ew_HtmlEncode($this->h_id_cod->CurrentValue);
			$this->h_id_cod->PlaceHolder = ew_RemoveHtml($this->h_id_cod->FldCaption());

			// h_email
			$this->h_email->EditAttrs["class"] = "form-control";
			$this->h_email->EditCustomAttributes = "";
			$this->h_email->EditValue = ew_HtmlEncode($this->h_email->CurrentValue);
			$this->h_email->PlaceHolder = ew_RemoveHtml($this->h_email->FldCaption());

			// h_contact_name
			$this->h_contact_name->EditAttrs["class"] = "form-control";
			$this->h_contact_name->EditCustomAttributes = "";
			$this->h_contact_name->EditValue = ew_HtmlEncode($this->h_contact_name->CurrentValue);
			$this->h_contact_name->PlaceHolder = ew_RemoveHtml($this->h_contact_name->FldCaption());

			// h_pass
			$this->h_pass->EditAttrs["class"] = "form-control";
			$this->h_pass->EditCustomAttributes = "";
			$this->h_pass->EditValue = ew_HtmlEncode($this->h_pass->CurrentValue);
			$this->h_pass->PlaceHolder = ew_RemoveHtml($this->h_pass->FldCaption());

			// h_contact_phone
			$this->h_contact_phone->EditAttrs["class"] = "form-control";
			$this->h_contact_phone->EditCustomAttributes = "";
			$this->h_contact_phone->EditValue = ew_HtmlEncode($this->h_contact_phone->CurrentValue);
			$this->h_contact_phone->PlaceHolder = ew_RemoveHtml($this->h_contact_phone->FldCaption());

			// h_site
			$this->h_site->EditAttrs["class"] = "form-control";
			$this->h_site->EditCustomAttributes = "";
			$this->h_site->EditValue = ew_HtmlEncode($this->h_site->CurrentValue);
			$this->h_site->PlaceHolder = ew_RemoveHtml($this->h_site->FldCaption());

			// contact_fax
			$this->contact_fax->EditAttrs["class"] = "form-control";
			$this->contact_fax->EditCustomAttributes = "";
			$this->contact_fax->EditValue = ew_HtmlEncode($this->contact_fax->CurrentValue);
			$this->contact_fax->PlaceHolder = ew_RemoveHtml($this->contact_fax->FldCaption());

			// star_rating
			$this->star_rating->EditAttrs["class"] = "form-control";
			$this->star_rating->EditCustomAttributes = "";
			$this->star_rating->EditValue = ew_HtmlEncode($this->star_rating->CurrentValue);
			$this->star_rating->PlaceHolder = ew_RemoveHtml($this->star_rating->FldCaption());

			// create_date
			$this->create_date->EditAttrs["class"] = "form-control";
			$this->create_date->EditCustomAttributes = "";
			$this->create_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->create_date->CurrentValue, 8));
			$this->create_date->PlaceHolder = ew_RemoveHtml($this->create_date->FldCaption());

			// update_date
			$this->update_date->EditAttrs["class"] = "form-control";
			$this->update_date->EditCustomAttributes = "";
			$this->update_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->update_date->CurrentValue, 2));
			$this->update_date->PlaceHolder = ew_RemoveHtml($this->update_date->FldCaption());

			// h_online_status
			$this->h_online_status->EditCustomAttributes = "";
			$this->h_online_status->EditValue = $this->h_online_status->Options(FALSE);

			// hotel_blocked
			$this->hotel_blocked->EditCustomAttributes = "";
			$this->hotel_blocked->EditValue = $this->hotel_blocked->Options(FALSE);

			// Add refer script
			// h_name

			$this->h_name->LinkCustomAttributes = "";
			$this->h_name->HrefValue = "";

			// h_slug
			$this->h_slug->LinkCustomAttributes = "";
			$this->h_slug->HrefValue = "";

			// h_feature_image
			$this->h_feature_image->LinkCustomAttributes = "";
			$this->h_feature_image->UploadPath = "../uploads/hotels";
			if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
				$this->h_feature_image->HrefValue = ew_GetFileUploadUrl($this->h_feature_image, $this->h_feature_image->Upload->DbValue); // Add prefix/suffix
				$this->h_feature_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->h_feature_image->HrefValue = ew_ConvertFullUrl($this->h_feature_image->HrefValue);
			} else {
				$this->h_feature_image->HrefValue = "";
			}
			$this->h_feature_image->HrefValue2 = $this->h_feature_image->UploadPath . $this->h_feature_image->Upload->DbValue;

			// h_description
			$this->h_description->LinkCustomAttributes = "";
			$this->h_description->HrefValue = "";

			// h_meta_key
			$this->h_meta_key->LinkCustomAttributes = "";
			$this->h_meta_key->HrefValue = "";

			// h_deatail
			$this->h_deatail->LinkCustomAttributes = "";
			$this->h_deatail->HrefValue = "";

			// h_facilities
			$this->h_facilities->LinkCustomAttributes = "";
			$this->h_facilities->HrefValue = "";

			// h_address
			$this->h_address->LinkCustomAttributes = "";
			$this->h_address->HrefValue = "";

			// h_create
			$this->h_create->LinkCustomAttributes = "";
			$this->h_create->HrefValue = "";

			// dest_id
			$this->dest_id->LinkCustomAttributes = "";
			$this->dest_id->HrefValue = "";

			// province
			$this->province->LinkCustomAttributes = "";
			$this->province->HrefValue = "";

			// whylike
			$this->whylike->LinkCustomAttributes = "";
			$this->whylike->HrefValue = "";

			// lang_spoken
			$this->lang_spoken->LinkCustomAttributes = "";
			$this->lang_spoken->HrefValue = "";

			// map
			$this->map->LinkCustomAttributes = "";
			$this->map->HrefValue = "";

			// what_todo
			$this->what_todo->LinkCustomAttributes = "";
			$this->what_todo->HrefValue = "";

			// h_id_cod
			$this->h_id_cod->LinkCustomAttributes = "";
			$this->h_id_cod->HrefValue = "";

			// h_email
			$this->h_email->LinkCustomAttributes = "";
			$this->h_email->HrefValue = "";

			// h_contact_name
			$this->h_contact_name->LinkCustomAttributes = "";
			$this->h_contact_name->HrefValue = "";

			// h_pass
			$this->h_pass->LinkCustomAttributes = "";
			$this->h_pass->HrefValue = "";

			// h_contact_phone
			$this->h_contact_phone->LinkCustomAttributes = "";
			$this->h_contact_phone->HrefValue = "";

			// h_site
			$this->h_site->LinkCustomAttributes = "";
			$this->h_site->HrefValue = "";

			// contact_fax
			$this->contact_fax->LinkCustomAttributes = "";
			$this->contact_fax->HrefValue = "";

			// star_rating
			$this->star_rating->LinkCustomAttributes = "";
			$this->star_rating->HrefValue = "";

			// create_date
			$this->create_date->LinkCustomAttributes = "";
			$this->create_date->HrefValue = "";

			// update_date
			$this->update_date->LinkCustomAttributes = "";
			$this->update_date->HrefValue = "";

			// h_online_status
			$this->h_online_status->LinkCustomAttributes = "";
			$this->h_online_status->HrefValue = "";

			// hotel_blocked
			$this->hotel_blocked->LinkCustomAttributes = "";
			$this->hotel_blocked->HrefValue = "";
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
		if (!$this->h_create->FldIsDetailKey && !is_null($this->h_create->FormValue) && $this->h_create->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->h_create->FldCaption(), $this->h_create->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->h_create->FormValue)) {
			ew_AddMessage($gsFormError, $this->h_create->FldErrMsg());
		}
		if (!ew_CheckInteger($this->dest_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->dest_id->FldErrMsg());
		}
		if (!$this->create_date->FldIsDetailKey && !is_null($this->create_date->FormValue) && $this->create_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->create_date->FldCaption(), $this->create_date->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->create_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->create_date->FldErrMsg());
		}
		if (!$this->update_date->FldIsDetailKey && !is_null($this->update_date->FormValue) && $this->update_date->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->update_date->FldCaption(), $this->update_date->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->update_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->update_date->FldErrMsg());
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
			$this->h_feature_image->OldUploadPath = "../uploads/hotels";
			$this->h_feature_image->UploadPath = $this->h_feature_image->OldUploadPath;
		}
		$rsnew = array();

		// h_name
		$this->h_name->SetDbValueDef($rsnew, $this->h_name->CurrentValue, NULL, FALSE);

		// h_slug
		$this->h_slug->SetDbValueDef($rsnew, $this->h_slug->CurrentValue, NULL, FALSE);

		// h_feature_image
		if ($this->h_feature_image->Visible && !$this->h_feature_image->Upload->KeepFile) {
			$this->h_feature_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->h_feature_image->Upload->FileName == "") {
				$rsnew['h_feature_image'] = NULL;
			} else {
				$rsnew['h_feature_image'] = $this->h_feature_image->Upload->FileName;
			}
		}

		// h_description
		$this->h_description->SetDbValueDef($rsnew, $this->h_description->CurrentValue, NULL, FALSE);

		// h_meta_key
		$this->h_meta_key->SetDbValueDef($rsnew, $this->h_meta_key->CurrentValue, NULL, FALSE);

		// h_deatail
		$this->h_deatail->SetDbValueDef($rsnew, $this->h_deatail->CurrentValue, NULL, FALSE);

		// h_facilities
		$this->h_facilities->SetDbValueDef($rsnew, $this->h_facilities->CurrentValue, NULL, FALSE);

		// h_address
		$this->h_address->SetDbValueDef($rsnew, $this->h_address->CurrentValue, NULL, FALSE);

		// h_create
		$this->h_create->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->h_create->CurrentValue, 0), NULL, FALSE);

		// dest_id
		$this->dest_id->SetDbValueDef($rsnew, $this->dest_id->CurrentValue, NULL, FALSE);

		// province
		$this->province->SetDbValueDef($rsnew, $this->province->CurrentValue, NULL, FALSE);

		// whylike
		$this->whylike->SetDbValueDef($rsnew, $this->whylike->CurrentValue, NULL, FALSE);

		// lang_spoken
		$this->lang_spoken->SetDbValueDef($rsnew, $this->lang_spoken->CurrentValue, NULL, FALSE);

		// map
		$this->map->SetDbValueDef($rsnew, $this->map->CurrentValue, NULL, FALSE);

		// what_todo
		$this->what_todo->SetDbValueDef($rsnew, $this->what_todo->CurrentValue, NULL, FALSE);

		// h_id_cod
		$this->h_id_cod->SetDbValueDef($rsnew, $this->h_id_cod->CurrentValue, NULL, FALSE);

		// h_email
		$this->h_email->SetDbValueDef($rsnew, $this->h_email->CurrentValue, NULL, FALSE);

		// h_contact_name
		$this->h_contact_name->SetDbValueDef($rsnew, $this->h_contact_name->CurrentValue, NULL, FALSE);

		// h_pass
		$this->h_pass->SetDbValueDef($rsnew, $this->h_pass->CurrentValue, NULL, FALSE);

		// h_contact_phone
		$this->h_contact_phone->SetDbValueDef($rsnew, $this->h_contact_phone->CurrentValue, NULL, FALSE);

		// h_site
		$this->h_site->SetDbValueDef($rsnew, $this->h_site->CurrentValue, NULL, FALSE);

		// contact_fax
		$this->contact_fax->SetDbValueDef($rsnew, $this->contact_fax->CurrentValue, NULL, FALSE);

		// star_rating
		$this->star_rating->SetDbValueDef($rsnew, $this->star_rating->CurrentValue, NULL, FALSE);

		// create_date
		$this->create_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->create_date->CurrentValue, 1), NULL, FALSE);

		// update_date
		$this->update_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->update_date->CurrentValue, 2), NULL, FALSE);

		// h_online_status
		$this->h_online_status->SetDbValueDef($rsnew, ((strval($this->h_online_status->CurrentValue) == "Y") ? "Y" : "N"), NULL, FALSE);

		// hotel_blocked
		$this->hotel_blocked->SetDbValueDef($rsnew, ((strval($this->hotel_blocked->CurrentValue) == "Y") ? "Y" : "N"), NULL, FALSE);
		if ($this->h_feature_image->Visible && !$this->h_feature_image->Upload->KeepFile) {
			$this->h_feature_image->UploadPath = "../uploads/hotels";
			if (!ew_Empty($this->h_feature_image->Upload->Value)) {
				$rsnew['h_feature_image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->h_feature_image->UploadPath), $rsnew['h_feature_image']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->h_feature_image->Visible && !$this->h_feature_image->Upload->KeepFile) {
					if (!ew_Empty($this->h_feature_image->Upload->Value)) {
						if (!$this->h_feature_image->Upload->SaveToFile($this->h_feature_image->UploadPath, $rsnew['h_feature_image'], TRUE)) {
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

		// h_feature_image
		ew_CleanUploadTempPath($this->h_feature_image, $this->h_feature_image->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotelslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotels_add)) $hotels_add = new chotels_add();

// Page init
$hotels_add->Page_Init();

// Page main
$hotels_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotels_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhotelsadd = new ew_Form("fhotelsadd", "add");

// Validate form
fhotelsadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_h_create");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotels->h_create->FldCaption(), $hotels->h_create->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_h_create");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotels->h_create->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dest_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotels->dest_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_create_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotels->create_date->FldCaption(), $hotels->create_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_create_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotels->create_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_update_date");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotels->update_date->FldCaption(), $hotels->update_date->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_update_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotels->update_date->FldErrMsg()) ?>");

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
fhotelsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotelsadd.ValidateRequired = true;
<?php } else { ?>
fhotelsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotelsadd.Lists["x_h_online_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsadd.Lists["x_h_online_status"].Options = <?php echo json_encode($hotels->h_online_status->Options()) ?>;
fhotelsadd.Lists["x_hotel_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsadd.Lists["x_hotel_blocked"].Options = <?php echo json_encode($hotels->hotel_blocked->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotels_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotels_add->ShowPageHeader(); ?>
<?php
$hotels_add->ShowMessage();
?>
<form name="fhotelsadd" id="fhotelsadd" class="<?php echo $hotels_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotels_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotels_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotels">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($hotels_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotels->h_name->Visible) { // h_name ?>
	<div id="r_h_name" class="form-group">
		<label id="elh_hotels_h_name" for="x_h_name" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_name->CellAttributes() ?>>
<span id="el_hotels_h_name">
<input type="text" data-table="hotels" data-field="x_h_name" name="x_h_name" id="x_h_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_name->getPlaceHolder()) ?>" value="<?php echo $hotels->h_name->EditValue ?>"<?php echo $hotels->h_name->EditAttributes() ?>>
</span>
<?php echo $hotels->h_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_slug->Visible) { // h_slug ?>
	<div id="r_h_slug" class="form-group">
		<label id="elh_hotels_h_slug" for="x_h_slug" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_slug->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_slug->CellAttributes() ?>>
<span id="el_hotels_h_slug">
<input type="text" data-table="hotels" data-field="x_h_slug" name="x_h_slug" id="x_h_slug" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_slug->getPlaceHolder()) ?>" value="<?php echo $hotels->h_slug->EditValue ?>"<?php echo $hotels->h_slug->EditAttributes() ?>>
</span>
<?php echo $hotels->h_slug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
	<div id="r_h_feature_image" class="form-group">
		<label id="elh_hotels_h_feature_image" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_feature_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_feature_image->CellAttributes() ?>>
<span id="el_hotels_h_feature_image">
<div id="fd_x_h_feature_image">
<span title="<?php echo $hotels->h_feature_image->FldTitle() ? $hotels->h_feature_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($hotels->h_feature_image->ReadOnly || $hotels->h_feature_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="hotels" data-field="x_h_feature_image" name="x_h_feature_image" id="x_h_feature_image"<?php echo $hotels->h_feature_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_h_feature_image" id= "fn_x_h_feature_image" value="<?php echo $hotels->h_feature_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_h_feature_image" id= "fa_x_h_feature_image" value="0">
<input type="hidden" name="fs_x_h_feature_image" id= "fs_x_h_feature_image" value="250">
<input type="hidden" name="fx_x_h_feature_image" id= "fx_x_h_feature_image" value="<?php echo $hotels->h_feature_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_h_feature_image" id= "fm_x_h_feature_image" value="<?php echo $hotels->h_feature_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_h_feature_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $hotels->h_feature_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_description->Visible) { // h_description ?>
	<div id="r_h_description" class="form-group">
		<label id="elh_hotels_h_description" for="x_h_description" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_description->CellAttributes() ?>>
<span id="el_hotels_h_description">
<textarea data-table="hotels" data-field="x_h_description" name="x_h_description" id="x_h_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->h_description->getPlaceHolder()) ?>"<?php echo $hotels->h_description->EditAttributes() ?>><?php echo $hotels->h_description->EditValue ?></textarea>
</span>
<?php echo $hotels->h_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_meta_key->Visible) { // h_meta_key ?>
	<div id="r_h_meta_key" class="form-group">
		<label id="elh_hotels_h_meta_key" for="x_h_meta_key" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_meta_key->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_meta_key->CellAttributes() ?>>
<span id="el_hotels_h_meta_key">
<textarea data-table="hotels" data-field="x_h_meta_key" name="x_h_meta_key" id="x_h_meta_key" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->h_meta_key->getPlaceHolder()) ?>"<?php echo $hotels->h_meta_key->EditAttributes() ?>><?php echo $hotels->h_meta_key->EditValue ?></textarea>
</span>
<?php echo $hotels->h_meta_key->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_deatail->Visible) { // h_deatail ?>
	<div id="r_h_deatail" class="form-group">
		<label id="elh_hotels_h_deatail" for="x_h_deatail" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_deatail->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_deatail->CellAttributes() ?>>
<span id="el_hotels_h_deatail">
<textarea data-table="hotels" data-field="x_h_deatail" name="x_h_deatail" id="x_h_deatail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->h_deatail->getPlaceHolder()) ?>"<?php echo $hotels->h_deatail->EditAttributes() ?>><?php echo $hotels->h_deatail->EditValue ?></textarea>
</span>
<?php echo $hotels->h_deatail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_facilities->Visible) { // h_facilities ?>
	<div id="r_h_facilities" class="form-group">
		<label id="elh_hotels_h_facilities" for="x_h_facilities" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_facilities->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_facilities->CellAttributes() ?>>
<span id="el_hotels_h_facilities">
<textarea data-table="hotels" data-field="x_h_facilities" name="x_h_facilities" id="x_h_facilities" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->h_facilities->getPlaceHolder()) ?>"<?php echo $hotels->h_facilities->EditAttributes() ?>><?php echo $hotels->h_facilities->EditValue ?></textarea>
</span>
<?php echo $hotels->h_facilities->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_address->Visible) { // h_address ?>
	<div id="r_h_address" class="form-group">
		<label id="elh_hotels_h_address" for="x_h_address" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_address->CellAttributes() ?>>
<span id="el_hotels_h_address">
<input type="text" data-table="hotels" data-field="x_h_address" name="x_h_address" id="x_h_address" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_address->getPlaceHolder()) ?>" value="<?php echo $hotels->h_address->EditValue ?>"<?php echo $hotels->h_address->EditAttributes() ?>>
</span>
<?php echo $hotels->h_address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_create->Visible) { // h_create ?>
	<div id="r_h_create" class="form-group">
		<label id="elh_hotels_h_create" for="x_h_create" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_create->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_create->CellAttributes() ?>>
<span id="el_hotels_h_create">
<input type="text" data-table="hotels" data-field="x_h_create" name="x_h_create" id="x_h_create" placeholder="<?php echo ew_HtmlEncode($hotels->h_create->getPlaceHolder()) ?>" value="<?php echo $hotels->h_create->EditValue ?>"<?php echo $hotels->h_create->EditAttributes() ?>>
</span>
<?php echo $hotels->h_create->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->dest_id->Visible) { // dest_id ?>
	<div id="r_dest_id" class="form-group">
		<label id="elh_hotels_dest_id" for="x_dest_id" class="col-sm-2 control-label ewLabel"><?php echo $hotels->dest_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->dest_id->CellAttributes() ?>>
<span id="el_hotels_dest_id">
<input type="text" data-table="hotels" data-field="x_dest_id" name="x_dest_id" id="x_dest_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotels->dest_id->getPlaceHolder()) ?>" value="<?php echo $hotels->dest_id->EditValue ?>"<?php echo $hotels->dest_id->EditAttributes() ?>>
</span>
<?php echo $hotels->dest_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->province->Visible) { // province ?>
	<div id="r_province" class="form-group">
		<label id="elh_hotels_province" for="x_province" class="col-sm-2 control-label ewLabel"><?php echo $hotels->province->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->province->CellAttributes() ?>>
<span id="el_hotels_province">
<input type="text" data-table="hotels" data-field="x_province" name="x_province" id="x_province" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->province->getPlaceHolder()) ?>" value="<?php echo $hotels->province->EditValue ?>"<?php echo $hotels->province->EditAttributes() ?>>
</span>
<?php echo $hotels->province->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->whylike->Visible) { // whylike ?>
	<div id="r_whylike" class="form-group">
		<label id="elh_hotels_whylike" for="x_whylike" class="col-sm-2 control-label ewLabel"><?php echo $hotels->whylike->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->whylike->CellAttributes() ?>>
<span id="el_hotels_whylike">
<textarea data-table="hotels" data-field="x_whylike" name="x_whylike" id="x_whylike" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->whylike->getPlaceHolder()) ?>"<?php echo $hotels->whylike->EditAttributes() ?>><?php echo $hotels->whylike->EditValue ?></textarea>
</span>
<?php echo $hotels->whylike->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->lang_spoken->Visible) { // lang_spoken ?>
	<div id="r_lang_spoken" class="form-group">
		<label id="elh_hotels_lang_spoken" for="x_lang_spoken" class="col-sm-2 control-label ewLabel"><?php echo $hotels->lang_spoken->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->lang_spoken->CellAttributes() ?>>
<span id="el_hotels_lang_spoken">
<textarea data-table="hotels" data-field="x_lang_spoken" name="x_lang_spoken" id="x_lang_spoken" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->lang_spoken->getPlaceHolder()) ?>"<?php echo $hotels->lang_spoken->EditAttributes() ?>><?php echo $hotels->lang_spoken->EditValue ?></textarea>
</span>
<?php echo $hotels->lang_spoken->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->map->Visible) { // map ?>
	<div id="r_map" class="form-group">
		<label id="elh_hotels_map" for="x_map" class="col-sm-2 control-label ewLabel"><?php echo $hotels->map->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->map->CellAttributes() ?>>
<span id="el_hotels_map">
<textarea data-table="hotels" data-field="x_map" name="x_map" id="x_map" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->map->getPlaceHolder()) ?>"<?php echo $hotels->map->EditAttributes() ?>><?php echo $hotels->map->EditValue ?></textarea>
</span>
<?php echo $hotels->map->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->what_todo->Visible) { // what_todo ?>
	<div id="r_what_todo" class="form-group">
		<label id="elh_hotels_what_todo" for="x_what_todo" class="col-sm-2 control-label ewLabel"><?php echo $hotels->what_todo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->what_todo->CellAttributes() ?>>
<span id="el_hotels_what_todo">
<textarea data-table="hotels" data-field="x_what_todo" name="x_what_todo" id="x_what_todo" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotels->what_todo->getPlaceHolder()) ?>"<?php echo $hotels->what_todo->EditAttributes() ?>><?php echo $hotels->what_todo->EditValue ?></textarea>
</span>
<?php echo $hotels->what_todo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
	<div id="r_h_id_cod" class="form-group">
		<label id="elh_hotels_h_id_cod" for="x_h_id_cod" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_id_cod->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_id_cod->CellAttributes() ?>>
<span id="el_hotels_h_id_cod">
<input type="text" data-table="hotels" data-field="x_h_id_cod" name="x_h_id_cod" id="x_h_id_cod" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_id_cod->getPlaceHolder()) ?>" value="<?php echo $hotels->h_id_cod->EditValue ?>"<?php echo $hotels->h_id_cod->EditAttributes() ?>>
</span>
<?php echo $hotels->h_id_cod->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_email->Visible) { // h_email ?>
	<div id="r_h_email" class="form-group">
		<label id="elh_hotels_h_email" for="x_h_email" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_email->CellAttributes() ?>>
<span id="el_hotels_h_email">
<input type="text" data-table="hotels" data-field="x_h_email" name="x_h_email" id="x_h_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_email->getPlaceHolder()) ?>" value="<?php echo $hotels->h_email->EditValue ?>"<?php echo $hotels->h_email->EditAttributes() ?>>
</span>
<?php echo $hotels->h_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
	<div id="r_h_contact_name" class="form-group">
		<label id="elh_hotels_h_contact_name" for="x_h_contact_name" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_contact_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_contact_name->CellAttributes() ?>>
<span id="el_hotels_h_contact_name">
<input type="text" data-table="hotels" data-field="x_h_contact_name" name="x_h_contact_name" id="x_h_contact_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_contact_name->getPlaceHolder()) ?>" value="<?php echo $hotels->h_contact_name->EditValue ?>"<?php echo $hotels->h_contact_name->EditAttributes() ?>>
</span>
<?php echo $hotels->h_contact_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_pass->Visible) { // h_pass ?>
	<div id="r_h_pass" class="form-group">
		<label id="elh_hotels_h_pass" for="x_h_pass" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_pass->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_pass->CellAttributes() ?>>
<span id="el_hotels_h_pass">
<input type="text" data-table="hotels" data-field="x_h_pass" name="x_h_pass" id="x_h_pass" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_pass->getPlaceHolder()) ?>" value="<?php echo $hotels->h_pass->EditValue ?>"<?php echo $hotels->h_pass->EditAttributes() ?>>
</span>
<?php echo $hotels->h_pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
	<div id="r_h_contact_phone" class="form-group">
		<label id="elh_hotels_h_contact_phone" for="x_h_contact_phone" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_contact_phone->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_contact_phone->CellAttributes() ?>>
<span id="el_hotels_h_contact_phone">
<input type="text" data-table="hotels" data-field="x_h_contact_phone" name="x_h_contact_phone" id="x_h_contact_phone" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_contact_phone->getPlaceHolder()) ?>" value="<?php echo $hotels->h_contact_phone->EditValue ?>"<?php echo $hotels->h_contact_phone->EditAttributes() ?>>
</span>
<?php echo $hotels->h_contact_phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_site->Visible) { // h_site ?>
	<div id="r_h_site" class="form-group">
		<label id="elh_hotels_h_site" for="x_h_site" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_site->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_site->CellAttributes() ?>>
<span id="el_hotels_h_site">
<input type="text" data-table="hotels" data-field="x_h_site" name="x_h_site" id="x_h_site" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->h_site->getPlaceHolder()) ?>" value="<?php echo $hotels->h_site->EditValue ?>"<?php echo $hotels->h_site->EditAttributes() ?>>
</span>
<?php echo $hotels->h_site->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
	<div id="r_contact_fax" class="form-group">
		<label id="elh_hotels_contact_fax" for="x_contact_fax" class="col-sm-2 control-label ewLabel"><?php echo $hotels->contact_fax->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->contact_fax->CellAttributes() ?>>
<span id="el_hotels_contact_fax">
<input type="text" data-table="hotels" data-field="x_contact_fax" name="x_contact_fax" id="x_contact_fax" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->contact_fax->getPlaceHolder()) ?>" value="<?php echo $hotels->contact_fax->EditValue ?>"<?php echo $hotels->contact_fax->EditAttributes() ?>>
</span>
<?php echo $hotels->contact_fax->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->star_rating->Visible) { // star_rating ?>
	<div id="r_star_rating" class="form-group">
		<label id="elh_hotels_star_rating" for="x_star_rating" class="col-sm-2 control-label ewLabel"><?php echo $hotels->star_rating->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->star_rating->CellAttributes() ?>>
<span id="el_hotels_star_rating">
<input type="text" data-table="hotels" data-field="x_star_rating" name="x_star_rating" id="x_star_rating" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotels->star_rating->getPlaceHolder()) ?>" value="<?php echo $hotels->star_rating->EditValue ?>"<?php echo $hotels->star_rating->EditAttributes() ?>>
</span>
<?php echo $hotels->star_rating->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->create_date->Visible) { // create_date ?>
	<div id="r_create_date" class="form-group">
		<label id="elh_hotels_create_date" for="x_create_date" class="col-sm-2 control-label ewLabel"><?php echo $hotels->create_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->create_date->CellAttributes() ?>>
<span id="el_hotels_create_date">
<input type="text" data-table="hotels" data-field="x_create_date" data-format="1" name="x_create_date" id="x_create_date" placeholder="<?php echo ew_HtmlEncode($hotels->create_date->getPlaceHolder()) ?>" value="<?php echo $hotels->create_date->EditValue ?>"<?php echo $hotels->create_date->EditAttributes() ?>>
</span>
<?php echo $hotels->create_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->update_date->Visible) { // update_date ?>
	<div id="r_update_date" class="form-group">
		<label id="elh_hotels_update_date" for="x_update_date" class="col-sm-2 control-label ewLabel"><?php echo $hotels->update_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->update_date->CellAttributes() ?>>
<span id="el_hotels_update_date">
<input type="text" data-table="hotels" data-field="x_update_date" data-format="2" name="x_update_date" id="x_update_date" placeholder="<?php echo ew_HtmlEncode($hotels->update_date->getPlaceHolder()) ?>" value="<?php echo $hotels->update_date->EditValue ?>"<?php echo $hotels->update_date->EditAttributes() ?>>
</span>
<?php echo $hotels->update_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
	<div id="r_h_online_status" class="form-group">
		<label id="elh_hotels_h_online_status" class="col-sm-2 control-label ewLabel"><?php echo $hotels->h_online_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->h_online_status->CellAttributes() ?>>
<span id="el_hotels_h_online_status">
<div id="tp_x_h_online_status" class="ewTemplate"><input type="radio" data-table="hotels" data-field="x_h_online_status" data-value-separator="<?php echo $hotels->h_online_status->DisplayValueSeparatorAttribute() ?>" name="x_h_online_status" id="x_h_online_status" value="{value}"<?php echo $hotels->h_online_status->EditAttributes() ?>></div>
<div id="dsl_x_h_online_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $hotels->h_online_status->RadioButtonListHtml(FALSE, "x_h_online_status") ?>
</div></div>
</span>
<?php echo $hotels->h_online_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
	<div id="r_hotel_blocked" class="form-group">
		<label id="elh_hotels_hotel_blocked" class="col-sm-2 control-label ewLabel"><?php echo $hotels->hotel_blocked->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotels->hotel_blocked->CellAttributes() ?>>
<span id="el_hotels_hotel_blocked">
<div id="tp_x_hotel_blocked" class="ewTemplate"><input type="radio" data-table="hotels" data-field="x_hotel_blocked" data-value-separator="<?php echo $hotels->hotel_blocked->DisplayValueSeparatorAttribute() ?>" name="x_hotel_blocked" id="x_hotel_blocked" value="{value}"<?php echo $hotels->hotel_blocked->EditAttributes() ?>></div>
<div id="dsl_x_hotel_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $hotels->hotel_blocked->RadioButtonListHtml(FALSE, "x_hotel_blocked") ?>
</div></div>
</span>
<?php echo $hotels->hotel_blocked->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotels_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotels_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fhotelsadd.Init();
</script>
<?php
$hotels_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotels_add->Page_Terminate();
?>

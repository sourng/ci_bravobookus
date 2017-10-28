<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "usersinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$users_add = NULL; // Initialize page object first

class cusers_add extends cusers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'users';

	// Page object name
	var $PageObjName = 'users_add';

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

		// Table object (users)
		if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == "cusers") {
			$GLOBALS["users"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["users"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'users', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("userslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->gro_id->SetVisibility();
		$this->unique_id->SetVisibility();
		$this->name->SetVisibility();
		$this->_email->SetVisibility();
		$this->user_name->SetVisibility();
		$this->encrypted_password->SetVisibility();
		$this->salt->SetVisibility();
		$this->note->SetVisibility();
		$this->user_create->SetVisibility();
		$this->created_date->SetVisibility();
		$this->user_update->SetVisibility();
		$this->updated_date->SetVisibility();
		$this->image->SetVisibility();

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
		global $EW_EXPORT, $users;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($users);
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
			if (@$_GET["uid"] != "") {
				$this->uid->setQueryStringValue($_GET["uid"]);
				$this->setKey("uid", $this->uid->CurrentValue); // Set up key
			} else {
				$this->setKey("uid", ""); // Clear key
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
					$this->Page_Terminate("userslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "userslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "usersview.php")
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
		$this->gro_id->CurrentValue = NULL;
		$this->gro_id->OldValue = $this->gro_id->CurrentValue;
		$this->unique_id->CurrentValue = NULL;
		$this->unique_id->OldValue = $this->unique_id->CurrentValue;
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->user_name->CurrentValue = NULL;
		$this->user_name->OldValue = $this->user_name->CurrentValue;
		$this->encrypted_password->CurrentValue = NULL;
		$this->encrypted_password->OldValue = $this->encrypted_password->CurrentValue;
		$this->salt->CurrentValue = NULL;
		$this->salt->OldValue = $this->salt->CurrentValue;
		$this->note->CurrentValue = NULL;
		$this->note->OldValue = $this->note->CurrentValue;
		$this->user_create->CurrentValue = NULL;
		$this->user_create->OldValue = $this->user_create->CurrentValue;
		$this->created_date->CurrentValue = NULL;
		$this->created_date->OldValue = $this->created_date->CurrentValue;
		$this->user_update->CurrentValue = NULL;
		$this->user_update->OldValue = $this->user_update->CurrentValue;
		$this->updated_date->CurrentValue = NULL;
		$this->updated_date->OldValue = $this->updated_date->CurrentValue;
		$this->image->CurrentValue = "default.jpg";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->gro_id->FldIsDetailKey) {
			$this->gro_id->setFormValue($objForm->GetValue("x_gro_id"));
		}
		if (!$this->unique_id->FldIsDetailKey) {
			$this->unique_id->setFormValue($objForm->GetValue("x_unique_id"));
		}
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->user_name->FldIsDetailKey) {
			$this->user_name->setFormValue($objForm->GetValue("x_user_name"));
		}
		if (!$this->encrypted_password->FldIsDetailKey) {
			$this->encrypted_password->setFormValue($objForm->GetValue("x_encrypted_password"));
		}
		if (!$this->salt->FldIsDetailKey) {
			$this->salt->setFormValue($objForm->GetValue("x_salt"));
		}
		if (!$this->note->FldIsDetailKey) {
			$this->note->setFormValue($objForm->GetValue("x_note"));
		}
		if (!$this->user_create->FldIsDetailKey) {
			$this->user_create->setFormValue($objForm->GetValue("x_user_create"));
		}
		if (!$this->created_date->FldIsDetailKey) {
			$this->created_date->setFormValue($objForm->GetValue("x_created_date"));
			$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		}
		if (!$this->user_update->FldIsDetailKey) {
			$this->user_update->setFormValue($objForm->GetValue("x_user_update"));
		}
		if (!$this->updated_date->FldIsDetailKey) {
			$this->updated_date->setFormValue($objForm->GetValue("x_updated_date"));
			$this->updated_date->CurrentValue = ew_UnFormatDateTime($this->updated_date->CurrentValue, 0);
		}
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->gro_id->CurrentValue = $this->gro_id->FormValue;
		$this->unique_id->CurrentValue = $this->unique_id->FormValue;
		$this->name->CurrentValue = $this->name->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->user_name->CurrentValue = $this->user_name->FormValue;
		$this->encrypted_password->CurrentValue = $this->encrypted_password->FormValue;
		$this->salt->CurrentValue = $this->salt->FormValue;
		$this->note->CurrentValue = $this->note->FormValue;
		$this->user_create->CurrentValue = $this->user_create->FormValue;
		$this->created_date->CurrentValue = $this->created_date->FormValue;
		$this->created_date->CurrentValue = ew_UnFormatDateTime($this->created_date->CurrentValue, 0);
		$this->user_update->CurrentValue = $this->user_update->FormValue;
		$this->updated_date->CurrentValue = $this->updated_date->FormValue;
		$this->updated_date->CurrentValue = ew_UnFormatDateTime($this->updated_date->CurrentValue, 0);
		$this->image->CurrentValue = $this->image->FormValue;
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
		$this->uid->setDbValue($rs->fields('uid'));
		$this->gro_id->setDbValue($rs->fields('gro_id'));
		$this->unique_id->setDbValue($rs->fields('unique_id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->user_name->setDbValue($rs->fields('user_name'));
		$this->encrypted_password->setDbValue($rs->fields('encrypted_password'));
		$this->salt->setDbValue($rs->fields('salt'));
		$this->note->setDbValue($rs->fields('note'));
		$this->user_create->setDbValue($rs->fields('user_create'));
		$this->created_date->setDbValue($rs->fields('created_date'));
		$this->user_update->setDbValue($rs->fields('user_update'));
		$this->updated_date->setDbValue($rs->fields('updated_date'));
		$this->image->setDbValue($rs->fields('image'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->uid->DbValue = $row['uid'];
		$this->gro_id->DbValue = $row['gro_id'];
		$this->unique_id->DbValue = $row['unique_id'];
		$this->name->DbValue = $row['name'];
		$this->_email->DbValue = $row['email'];
		$this->user_name->DbValue = $row['user_name'];
		$this->encrypted_password->DbValue = $row['encrypted_password'];
		$this->salt->DbValue = $row['salt'];
		$this->note->DbValue = $row['note'];
		$this->user_create->DbValue = $row['user_create'];
		$this->created_date->DbValue = $row['created_date'];
		$this->user_update->DbValue = $row['user_update'];
		$this->updated_date->DbValue = $row['updated_date'];
		$this->image->DbValue = $row['image'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("uid")) <> "")
			$this->uid->CurrentValue = $this->getKey("uid"); // uid
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
		// uid
		// gro_id
		// unique_id
		// name
		// email
		// user_name
		// encrypted_password
		// salt
		// note
		// user_create
		// created_date
		// user_update
		// updated_date
		// image

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// gro_id
		$this->gro_id->ViewValue = $this->gro_id->CurrentValue;
		$this->gro_id->ViewCustomAttributes = "";

		// unique_id
		$this->unique_id->ViewValue = $this->unique_id->CurrentValue;
		$this->unique_id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// user_name
		$this->user_name->ViewValue = $this->user_name->CurrentValue;
		$this->user_name->ViewCustomAttributes = "";

		// encrypted_password
		$this->encrypted_password->ViewValue = $this->encrypted_password->CurrentValue;
		$this->encrypted_password->ViewCustomAttributes = "";

		// salt
		$this->salt->ViewValue = $this->salt->CurrentValue;
		$this->salt->ViewCustomAttributes = "";

		// note
		$this->note->ViewValue = $this->note->CurrentValue;
		$this->note->ViewCustomAttributes = "";

		// user_create
		$this->user_create->ViewValue = $this->user_create->CurrentValue;
		$this->user_create->ViewCustomAttributes = "";

		// created_date
		$this->created_date->ViewValue = $this->created_date->CurrentValue;
		$this->created_date->ViewValue = ew_FormatDateTime($this->created_date->ViewValue, 0);
		$this->created_date->ViewCustomAttributes = "";

		// user_update
		$this->user_update->ViewValue = $this->user_update->CurrentValue;
		$this->user_update->ViewCustomAttributes = "";

		// updated_date
		$this->updated_date->ViewValue = $this->updated_date->CurrentValue;
		$this->updated_date->ViewValue = ew_FormatDateTime($this->updated_date->ViewValue, 0);
		$this->updated_date->ViewCustomAttributes = "";

		// image
		$this->image->ViewValue = $this->image->CurrentValue;
		$this->image->ViewCustomAttributes = "";

			// gro_id
			$this->gro_id->LinkCustomAttributes = "";
			$this->gro_id->HrefValue = "";
			$this->gro_id->TooltipValue = "";

			// unique_id
			$this->unique_id->LinkCustomAttributes = "";
			$this->unique_id->HrefValue = "";
			$this->unique_id->TooltipValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";
			$this->user_name->TooltipValue = "";

			// encrypted_password
			$this->encrypted_password->LinkCustomAttributes = "";
			$this->encrypted_password->HrefValue = "";
			$this->encrypted_password->TooltipValue = "";

			// salt
			$this->salt->LinkCustomAttributes = "";
			$this->salt->HrefValue = "";
			$this->salt->TooltipValue = "";

			// note
			$this->note->LinkCustomAttributes = "";
			$this->note->HrefValue = "";
			$this->note->TooltipValue = "";

			// user_create
			$this->user_create->LinkCustomAttributes = "";
			$this->user_create->HrefValue = "";
			$this->user_create->TooltipValue = "";

			// created_date
			$this->created_date->LinkCustomAttributes = "";
			$this->created_date->HrefValue = "";
			$this->created_date->TooltipValue = "";

			// user_update
			$this->user_update->LinkCustomAttributes = "";
			$this->user_update->HrefValue = "";
			$this->user_update->TooltipValue = "";

			// updated_date
			$this->updated_date->LinkCustomAttributes = "";
			$this->updated_date->HrefValue = "";
			$this->updated_date->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// gro_id
			$this->gro_id->EditAttrs["class"] = "form-control";
			$this->gro_id->EditCustomAttributes = "";
			$this->gro_id->EditValue = ew_HtmlEncode($this->gro_id->CurrentValue);
			$this->gro_id->PlaceHolder = ew_RemoveHtml($this->gro_id->FldCaption());

			// unique_id
			$this->unique_id->EditAttrs["class"] = "form-control";
			$this->unique_id->EditCustomAttributes = "";
			$this->unique_id->EditValue = ew_HtmlEncode($this->unique_id->CurrentValue);
			$this->unique_id->PlaceHolder = ew_RemoveHtml($this->unique_id->FldCaption());

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// user_name
			$this->user_name->EditAttrs["class"] = "form-control";
			$this->user_name->EditCustomAttributes = "";
			$this->user_name->EditValue = ew_HtmlEncode($this->user_name->CurrentValue);
			$this->user_name->PlaceHolder = ew_RemoveHtml($this->user_name->FldCaption());

			// encrypted_password
			$this->encrypted_password->EditAttrs["class"] = "form-control";
			$this->encrypted_password->EditCustomAttributes = "";
			$this->encrypted_password->EditValue = ew_HtmlEncode($this->encrypted_password->CurrentValue);
			$this->encrypted_password->PlaceHolder = ew_RemoveHtml($this->encrypted_password->FldCaption());

			// salt
			$this->salt->EditAttrs["class"] = "form-control";
			$this->salt->EditCustomAttributes = "";
			$this->salt->EditValue = ew_HtmlEncode($this->salt->CurrentValue);
			$this->salt->PlaceHolder = ew_RemoveHtml($this->salt->FldCaption());

			// note
			$this->note->EditAttrs["class"] = "form-control";
			$this->note->EditCustomAttributes = "";
			$this->note->EditValue = ew_HtmlEncode($this->note->CurrentValue);
			$this->note->PlaceHolder = ew_RemoveHtml($this->note->FldCaption());

			// user_create
			$this->user_create->EditAttrs["class"] = "form-control";
			$this->user_create->EditCustomAttributes = "";
			$this->user_create->EditValue = ew_HtmlEncode($this->user_create->CurrentValue);
			$this->user_create->PlaceHolder = ew_RemoveHtml($this->user_create->FldCaption());

			// created_date
			$this->created_date->EditAttrs["class"] = "form-control";
			$this->created_date->EditCustomAttributes = "";
			$this->created_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->created_date->CurrentValue, 8));
			$this->created_date->PlaceHolder = ew_RemoveHtml($this->created_date->FldCaption());

			// user_update
			$this->user_update->EditAttrs["class"] = "form-control";
			$this->user_update->EditCustomAttributes = "";
			$this->user_update->EditValue = ew_HtmlEncode($this->user_update->CurrentValue);
			$this->user_update->PlaceHolder = ew_RemoveHtml($this->user_update->FldCaption());

			// updated_date
			$this->updated_date->EditAttrs["class"] = "form-control";
			$this->updated_date->EditCustomAttributes = "";
			$this->updated_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->updated_date->CurrentValue, 8));
			$this->updated_date->PlaceHolder = ew_RemoveHtml($this->updated_date->FldCaption());

			// image
			$this->image->EditAttrs["class"] = "form-control";
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);
			$this->image->PlaceHolder = ew_RemoveHtml($this->image->FldCaption());

			// Add refer script
			// gro_id

			$this->gro_id->LinkCustomAttributes = "";
			$this->gro_id->HrefValue = "";

			// unique_id
			$this->unique_id->LinkCustomAttributes = "";
			$this->unique_id->HrefValue = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";

			// encrypted_password
			$this->encrypted_password->LinkCustomAttributes = "";
			$this->encrypted_password->HrefValue = "";

			// salt
			$this->salt->LinkCustomAttributes = "";
			$this->salt->HrefValue = "";

			// note
			$this->note->LinkCustomAttributes = "";
			$this->note->HrefValue = "";

			// user_create
			$this->user_create->LinkCustomAttributes = "";
			$this->user_create->HrefValue = "";

			// created_date
			$this->created_date->LinkCustomAttributes = "";
			$this->created_date->HrefValue = "";

			// user_update
			$this->user_update->LinkCustomAttributes = "";
			$this->user_update->HrefValue = "";

			// updated_date
			$this->updated_date->LinkCustomAttributes = "";
			$this->updated_date->HrefValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
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
		if (!ew_CheckInteger($this->gro_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->gro_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->user_create->FormValue)) {
			ew_AddMessage($gsFormError, $this->user_create->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->created_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->created_date->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->updated_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->updated_date->FldErrMsg());
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
		if ($this->unique_id->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(unique_id = '" . ew_AdjustSql($this->unique_id->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->unique_id->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->unique_id->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->_email->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(email = '" . ew_AdjustSql($this->_email->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->_email->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->_email->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// gro_id
		$this->gro_id->SetDbValueDef($rsnew, $this->gro_id->CurrentValue, NULL, FALSE);

		// unique_id
		$this->unique_id->SetDbValueDef($rsnew, $this->unique_id->CurrentValue, NULL, FALSE);

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// user_name
		$this->user_name->SetDbValueDef($rsnew, $this->user_name->CurrentValue, NULL, FALSE);

		// encrypted_password
		$this->encrypted_password->SetDbValueDef($rsnew, $this->encrypted_password->CurrentValue, NULL, FALSE);

		// salt
		$this->salt->SetDbValueDef($rsnew, $this->salt->CurrentValue, NULL, FALSE);

		// note
		$this->note->SetDbValueDef($rsnew, $this->note->CurrentValue, NULL, FALSE);

		// user_create
		$this->user_create->SetDbValueDef($rsnew, $this->user_create->CurrentValue, NULL, FALSE);

		// created_date
		$this->created_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->created_date->CurrentValue, 0), NULL, FALSE);

		// user_update
		$this->user_update->SetDbValueDef($rsnew, $this->user_update->CurrentValue, NULL, FALSE);

		// updated_date
		$this->updated_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->updated_date->CurrentValue, 0), NULL, FALSE);

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, strval($this->image->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($users_add)) $users_add = new cusers_add();

// Page init
$users_add->Page_Init();

// Page main
$users_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$users_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fusersadd = new ew_Form("fusersadd", "add");

// Validate form
fusersadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_gro_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->gro_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user_create");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->user_create->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_created_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->created_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_updated_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($users->updated_date->FldErrMsg()) ?>");

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
fusersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fusersadd.ValidateRequired = true;
<?php } else { ?>
fusersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$users_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $users_add->ShowPageHeader(); ?>
<?php
$users_add->ShowMessage();
?>
<form name="fusersadd" id="fusersadd" class="<?php echo $users_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($users_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $users_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($users_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($users->gro_id->Visible) { // gro_id ?>
	<div id="r_gro_id" class="form-group">
		<label id="elh_users_gro_id" for="x_gro_id" class="col-sm-2 control-label ewLabel"><?php echo $users->gro_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->gro_id->CellAttributes() ?>>
<span id="el_users_gro_id">
<input type="text" data-table="users" data-field="x_gro_id" name="x_gro_id" id="x_gro_id" size="30" placeholder="<?php echo ew_HtmlEncode($users->gro_id->getPlaceHolder()) ?>" value="<?php echo $users->gro_id->EditValue ?>"<?php echo $users->gro_id->EditAttributes() ?>>
</span>
<?php echo $users->gro_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->unique_id->Visible) { // unique_id ?>
	<div id="r_unique_id" class="form-group">
		<label id="elh_users_unique_id" for="x_unique_id" class="col-sm-2 control-label ewLabel"><?php echo $users->unique_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->unique_id->CellAttributes() ?>>
<span id="el_users_unique_id">
<input type="text" data-table="users" data-field="x_unique_id" name="x_unique_id" id="x_unique_id" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->unique_id->getPlaceHolder()) ?>" value="<?php echo $users->unique_id->EditValue ?>"<?php echo $users->unique_id->EditAttributes() ?>>
</span>
<?php echo $users->unique_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_users_name" for="x_name" class="col-sm-2 control-label ewLabel"><?php echo $users->name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->name->CellAttributes() ?>>
<span id="el_users_name">
<input type="text" data-table="users" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->name->getPlaceHolder()) ?>" value="<?php echo $users->name->EditValue ?>"<?php echo $users->name->EditAttributes() ?>>
</span>
<?php echo $users->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_users__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $users->_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->_email->CellAttributes() ?>>
<span id="el_users__email">
<input type="text" data-table="users" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->_email->getPlaceHolder()) ?>" value="<?php echo $users->_email->EditValue ?>"<?php echo $users->_email->EditAttributes() ?>>
</span>
<?php echo $users->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->user_name->Visible) { // user_name ?>
	<div id="r_user_name" class="form-group">
		<label id="elh_users_user_name" for="x_user_name" class="col-sm-2 control-label ewLabel"><?php echo $users->user_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->user_name->CellAttributes() ?>>
<span id="el_users_user_name">
<input type="text" data-table="users" data-field="x_user_name" name="x_user_name" id="x_user_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($users->user_name->getPlaceHolder()) ?>" value="<?php echo $users->user_name->EditValue ?>"<?php echo $users->user_name->EditAttributes() ?>>
</span>
<?php echo $users->user_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->encrypted_password->Visible) { // encrypted_password ?>
	<div id="r_encrypted_password" class="form-group">
		<label id="elh_users_encrypted_password" for="x_encrypted_password" class="col-sm-2 control-label ewLabel"><?php echo $users->encrypted_password->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->encrypted_password->CellAttributes() ?>>
<span id="el_users_encrypted_password">
<input type="text" data-table="users" data-field="x_encrypted_password" name="x_encrypted_password" id="x_encrypted_password" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($users->encrypted_password->getPlaceHolder()) ?>" value="<?php echo $users->encrypted_password->EditValue ?>"<?php echo $users->encrypted_password->EditAttributes() ?>>
</span>
<?php echo $users->encrypted_password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->salt->Visible) { // salt ?>
	<div id="r_salt" class="form-group">
		<label id="elh_users_salt" for="x_salt" class="col-sm-2 control-label ewLabel"><?php echo $users->salt->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->salt->CellAttributes() ?>>
<span id="el_users_salt">
<input type="text" data-table="users" data-field="x_salt" name="x_salt" id="x_salt" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($users->salt->getPlaceHolder()) ?>" value="<?php echo $users->salt->EditValue ?>"<?php echo $users->salt->EditAttributes() ?>>
</span>
<?php echo $users->salt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->note->Visible) { // note ?>
	<div id="r_note" class="form-group">
		<label id="elh_users_note" for="x_note" class="col-sm-2 control-label ewLabel"><?php echo $users->note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->note->CellAttributes() ?>>
<span id="el_users_note">
<textarea data-table="users" data-field="x_note" name="x_note" id="x_note" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($users->note->getPlaceHolder()) ?>"<?php echo $users->note->EditAttributes() ?>><?php echo $users->note->EditValue ?></textarea>
</span>
<?php echo $users->note->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->user_create->Visible) { // user_create ?>
	<div id="r_user_create" class="form-group">
		<label id="elh_users_user_create" for="x_user_create" class="col-sm-2 control-label ewLabel"><?php echo $users->user_create->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->user_create->CellAttributes() ?>>
<span id="el_users_user_create">
<input type="text" data-table="users" data-field="x_user_create" name="x_user_create" id="x_user_create" size="30" placeholder="<?php echo ew_HtmlEncode($users->user_create->getPlaceHolder()) ?>" value="<?php echo $users->user_create->EditValue ?>"<?php echo $users->user_create->EditAttributes() ?>>
</span>
<?php echo $users->user_create->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->created_date->Visible) { // created_date ?>
	<div id="r_created_date" class="form-group">
		<label id="elh_users_created_date" for="x_created_date" class="col-sm-2 control-label ewLabel"><?php echo $users->created_date->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->created_date->CellAttributes() ?>>
<span id="el_users_created_date">
<input type="text" data-table="users" data-field="x_created_date" name="x_created_date" id="x_created_date" placeholder="<?php echo ew_HtmlEncode($users->created_date->getPlaceHolder()) ?>" value="<?php echo $users->created_date->EditValue ?>"<?php echo $users->created_date->EditAttributes() ?>>
</span>
<?php echo $users->created_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->user_update->Visible) { // user_update ?>
	<div id="r_user_update" class="form-group">
		<label id="elh_users_user_update" for="x_user_update" class="col-sm-2 control-label ewLabel"><?php echo $users->user_update->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->user_update->CellAttributes() ?>>
<span id="el_users_user_update">
<input type="text" data-table="users" data-field="x_user_update" name="x_user_update" id="x_user_update" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($users->user_update->getPlaceHolder()) ?>" value="<?php echo $users->user_update->EditValue ?>"<?php echo $users->user_update->EditAttributes() ?>>
</span>
<?php echo $users->user_update->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->updated_date->Visible) { // updated_date ?>
	<div id="r_updated_date" class="form-group">
		<label id="elh_users_updated_date" for="x_updated_date" class="col-sm-2 control-label ewLabel"><?php echo $users->updated_date->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->updated_date->CellAttributes() ?>>
<span id="el_users_updated_date">
<input type="text" data-table="users" data-field="x_updated_date" name="x_updated_date" id="x_updated_date" placeholder="<?php echo ew_HtmlEncode($users->updated_date->getPlaceHolder()) ?>" value="<?php echo $users->updated_date->EditValue ?>"<?php echo $users->updated_date->EditAttributes() ?>>
</span>
<?php echo $users->updated_date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($users->image->Visible) { // image ?>
	<div id="r_image" class="form-group">
		<label id="elh_users_image" for="x_image" class="col-sm-2 control-label ewLabel"><?php echo $users->image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $users->image->CellAttributes() ?>>
<span id="el_users_image">
<input type="text" data-table="users" data-field="x_image" name="x_image" id="x_image" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($users->image->getPlaceHolder()) ?>" value="<?php echo $users->image->EditValue ?>"<?php echo $users->image->EditAttributes() ?>>
</span>
<?php echo $users->image->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$users_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $users_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fusersadd.Init();
</script>
<?php
$users_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$users_add->Page_Terminate();
?>

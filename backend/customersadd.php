<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "customersinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$customers_add = NULL; // Initialize page object first

class ccustomers_add extends ccustomers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'customers';

	// Page object name
	var $PageObjName = 'customers_add';

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

		// Table object (customers)
		if (!isset($GLOBALS["customers"]) || get_class($GLOBALS["customers"]) == "ccustomers") {
			$GLOBALS["customers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["customers"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'customers', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("customerslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->cus_fname->SetVisibility();
		$this->cus_lname->SetVisibility();
		$this->cus_gender->SetVisibility();
		$this->cus_address->SetVisibility();
		$this->cus_country->SetVisibility();
		$this->cus_email->SetVisibility();
		$this->cus_pass->SetVisibility();
		$this->cus_picutre->SetVisibility();
		$this->cus_note->SetVisibility();

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
		global $EW_EXPORT, $customers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($customers);
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
			if (@$_GET["customer_id"] != "") {
				$this->customer_id->setQueryStringValue($_GET["customer_id"]);
				$this->setKey("customer_id", $this->customer_id->CurrentValue); // Set up key
			} else {
				$this->setKey("customer_id", ""); // Clear key
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
					$this->Page_Terminate("customerslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "customerslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "customersview.php")
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
		$this->cus_fname->CurrentValue = NULL;
		$this->cus_fname->OldValue = $this->cus_fname->CurrentValue;
		$this->cus_lname->CurrentValue = NULL;
		$this->cus_lname->OldValue = $this->cus_lname->CurrentValue;
		$this->cus_gender->CurrentValue = NULL;
		$this->cus_gender->OldValue = $this->cus_gender->CurrentValue;
		$this->cus_address->CurrentValue = NULL;
		$this->cus_address->OldValue = $this->cus_address->CurrentValue;
		$this->cus_country->CurrentValue = NULL;
		$this->cus_country->OldValue = $this->cus_country->CurrentValue;
		$this->cus_email->CurrentValue = NULL;
		$this->cus_email->OldValue = $this->cus_email->CurrentValue;
		$this->cus_pass->CurrentValue = NULL;
		$this->cus_pass->OldValue = $this->cus_pass->CurrentValue;
		$this->cus_picutre->CurrentValue = NULL;
		$this->cus_picutre->OldValue = $this->cus_picutre->CurrentValue;
		$this->cus_note->CurrentValue = NULL;
		$this->cus_note->OldValue = $this->cus_note->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->cus_fname->FldIsDetailKey) {
			$this->cus_fname->setFormValue($objForm->GetValue("x_cus_fname"));
		}
		if (!$this->cus_lname->FldIsDetailKey) {
			$this->cus_lname->setFormValue($objForm->GetValue("x_cus_lname"));
		}
		if (!$this->cus_gender->FldIsDetailKey) {
			$this->cus_gender->setFormValue($objForm->GetValue("x_cus_gender"));
		}
		if (!$this->cus_address->FldIsDetailKey) {
			$this->cus_address->setFormValue($objForm->GetValue("x_cus_address"));
		}
		if (!$this->cus_country->FldIsDetailKey) {
			$this->cus_country->setFormValue($objForm->GetValue("x_cus_country"));
		}
		if (!$this->cus_email->FldIsDetailKey) {
			$this->cus_email->setFormValue($objForm->GetValue("x_cus_email"));
		}
		if (!$this->cus_pass->FldIsDetailKey) {
			$this->cus_pass->setFormValue($objForm->GetValue("x_cus_pass"));
		}
		if (!$this->cus_picutre->FldIsDetailKey) {
			$this->cus_picutre->setFormValue($objForm->GetValue("x_cus_picutre"));
		}
		if (!$this->cus_note->FldIsDetailKey) {
			$this->cus_note->setFormValue($objForm->GetValue("x_cus_note"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->cus_fname->CurrentValue = $this->cus_fname->FormValue;
		$this->cus_lname->CurrentValue = $this->cus_lname->FormValue;
		$this->cus_gender->CurrentValue = $this->cus_gender->FormValue;
		$this->cus_address->CurrentValue = $this->cus_address->FormValue;
		$this->cus_country->CurrentValue = $this->cus_country->FormValue;
		$this->cus_email->CurrentValue = $this->cus_email->FormValue;
		$this->cus_pass->CurrentValue = $this->cus_pass->FormValue;
		$this->cus_picutre->CurrentValue = $this->cus_picutre->FormValue;
		$this->cus_note->CurrentValue = $this->cus_note->FormValue;
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
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->cus_fname->setDbValue($rs->fields('cus_fname'));
		$this->cus_lname->setDbValue($rs->fields('cus_lname'));
		$this->cus_gender->setDbValue($rs->fields('cus_gender'));
		$this->cus_address->setDbValue($rs->fields('cus_address'));
		$this->cus_country->setDbValue($rs->fields('cus_country'));
		$this->cus_email->setDbValue($rs->fields('cus_email'));
		$this->cus_pass->setDbValue($rs->fields('cus_pass'));
		$this->cus_picutre->setDbValue($rs->fields('cus_picutre'));
		$this->cus_note->setDbValue($rs->fields('cus_note'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->customer_id->DbValue = $row['customer_id'];
		$this->cus_fname->DbValue = $row['cus_fname'];
		$this->cus_lname->DbValue = $row['cus_lname'];
		$this->cus_gender->DbValue = $row['cus_gender'];
		$this->cus_address->DbValue = $row['cus_address'];
		$this->cus_country->DbValue = $row['cus_country'];
		$this->cus_email->DbValue = $row['cus_email'];
		$this->cus_pass->DbValue = $row['cus_pass'];
		$this->cus_picutre->DbValue = $row['cus_picutre'];
		$this->cus_note->DbValue = $row['cus_note'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("customer_id")) <> "")
			$this->customer_id->CurrentValue = $this->getKey("customer_id"); // customer_id
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
		// customer_id
		// cus_fname
		// cus_lname
		// cus_gender
		// cus_address
		// cus_country
		// cus_email
		// cus_pass
		// cus_picutre
		// cus_note

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// cus_fname
		$this->cus_fname->ViewValue = $this->cus_fname->CurrentValue;
		$this->cus_fname->ViewCustomAttributes = "";

		// cus_lname
		$this->cus_lname->ViewValue = $this->cus_lname->CurrentValue;
		$this->cus_lname->ViewCustomAttributes = "";

		// cus_gender
		$this->cus_gender->ViewValue = $this->cus_gender->CurrentValue;
		$this->cus_gender->ViewCustomAttributes = "";

		// cus_address
		$this->cus_address->ViewValue = $this->cus_address->CurrentValue;
		$this->cus_address->ViewCustomAttributes = "";

		// cus_country
		$this->cus_country->ViewValue = $this->cus_country->CurrentValue;
		$this->cus_country->ViewCustomAttributes = "";

		// cus_email
		$this->cus_email->ViewValue = $this->cus_email->CurrentValue;
		$this->cus_email->ViewCustomAttributes = "";

		// cus_pass
		$this->cus_pass->ViewValue = $this->cus_pass->CurrentValue;
		$this->cus_pass->ViewCustomAttributes = "";

		// cus_picutre
		$this->cus_picutre->ViewValue = $this->cus_picutre->CurrentValue;
		$this->cus_picutre->ViewCustomAttributes = "";

		// cus_note
		$this->cus_note->ViewValue = $this->cus_note->CurrentValue;
		$this->cus_note->ViewCustomAttributes = "";

			// cus_fname
			$this->cus_fname->LinkCustomAttributes = "";
			$this->cus_fname->HrefValue = "";
			$this->cus_fname->TooltipValue = "";

			// cus_lname
			$this->cus_lname->LinkCustomAttributes = "";
			$this->cus_lname->HrefValue = "";
			$this->cus_lname->TooltipValue = "";

			// cus_gender
			$this->cus_gender->LinkCustomAttributes = "";
			$this->cus_gender->HrefValue = "";
			$this->cus_gender->TooltipValue = "";

			// cus_address
			$this->cus_address->LinkCustomAttributes = "";
			$this->cus_address->HrefValue = "";
			$this->cus_address->TooltipValue = "";

			// cus_country
			$this->cus_country->LinkCustomAttributes = "";
			$this->cus_country->HrefValue = "";
			$this->cus_country->TooltipValue = "";

			// cus_email
			$this->cus_email->LinkCustomAttributes = "";
			$this->cus_email->HrefValue = "";
			$this->cus_email->TooltipValue = "";

			// cus_pass
			$this->cus_pass->LinkCustomAttributes = "";
			$this->cus_pass->HrefValue = "";
			$this->cus_pass->TooltipValue = "";

			// cus_picutre
			$this->cus_picutre->LinkCustomAttributes = "";
			$this->cus_picutre->HrefValue = "";
			$this->cus_picutre->TooltipValue = "";

			// cus_note
			$this->cus_note->LinkCustomAttributes = "";
			$this->cus_note->HrefValue = "";
			$this->cus_note->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// cus_fname
			$this->cus_fname->EditAttrs["class"] = "form-control";
			$this->cus_fname->EditCustomAttributes = "";
			$this->cus_fname->EditValue = ew_HtmlEncode($this->cus_fname->CurrentValue);
			$this->cus_fname->PlaceHolder = ew_RemoveHtml($this->cus_fname->FldCaption());

			// cus_lname
			$this->cus_lname->EditAttrs["class"] = "form-control";
			$this->cus_lname->EditCustomAttributes = "";
			$this->cus_lname->EditValue = ew_HtmlEncode($this->cus_lname->CurrentValue);
			$this->cus_lname->PlaceHolder = ew_RemoveHtml($this->cus_lname->FldCaption());

			// cus_gender
			$this->cus_gender->EditAttrs["class"] = "form-control";
			$this->cus_gender->EditCustomAttributes = "";
			$this->cus_gender->EditValue = ew_HtmlEncode($this->cus_gender->CurrentValue);
			$this->cus_gender->PlaceHolder = ew_RemoveHtml($this->cus_gender->FldCaption());

			// cus_address
			$this->cus_address->EditAttrs["class"] = "form-control";
			$this->cus_address->EditCustomAttributes = "";
			$this->cus_address->EditValue = ew_HtmlEncode($this->cus_address->CurrentValue);
			$this->cus_address->PlaceHolder = ew_RemoveHtml($this->cus_address->FldCaption());

			// cus_country
			$this->cus_country->EditAttrs["class"] = "form-control";
			$this->cus_country->EditCustomAttributes = "";
			$this->cus_country->EditValue = ew_HtmlEncode($this->cus_country->CurrentValue);
			$this->cus_country->PlaceHolder = ew_RemoveHtml($this->cus_country->FldCaption());

			// cus_email
			$this->cus_email->EditAttrs["class"] = "form-control";
			$this->cus_email->EditCustomAttributes = "";
			$this->cus_email->EditValue = ew_HtmlEncode($this->cus_email->CurrentValue);
			$this->cus_email->PlaceHolder = ew_RemoveHtml($this->cus_email->FldCaption());

			// cus_pass
			$this->cus_pass->EditAttrs["class"] = "form-control";
			$this->cus_pass->EditCustomAttributes = "";
			$this->cus_pass->EditValue = ew_HtmlEncode($this->cus_pass->CurrentValue);
			$this->cus_pass->PlaceHolder = ew_RemoveHtml($this->cus_pass->FldCaption());

			// cus_picutre
			$this->cus_picutre->EditAttrs["class"] = "form-control";
			$this->cus_picutre->EditCustomAttributes = "";
			$this->cus_picutre->EditValue = ew_HtmlEncode($this->cus_picutre->CurrentValue);
			$this->cus_picutre->PlaceHolder = ew_RemoveHtml($this->cus_picutre->FldCaption());

			// cus_note
			$this->cus_note->EditAttrs["class"] = "form-control";
			$this->cus_note->EditCustomAttributes = "";
			$this->cus_note->EditValue = ew_HtmlEncode($this->cus_note->CurrentValue);
			$this->cus_note->PlaceHolder = ew_RemoveHtml($this->cus_note->FldCaption());

			// Add refer script
			// cus_fname

			$this->cus_fname->LinkCustomAttributes = "";
			$this->cus_fname->HrefValue = "";

			// cus_lname
			$this->cus_lname->LinkCustomAttributes = "";
			$this->cus_lname->HrefValue = "";

			// cus_gender
			$this->cus_gender->LinkCustomAttributes = "";
			$this->cus_gender->HrefValue = "";

			// cus_address
			$this->cus_address->LinkCustomAttributes = "";
			$this->cus_address->HrefValue = "";

			// cus_country
			$this->cus_country->LinkCustomAttributes = "";
			$this->cus_country->HrefValue = "";

			// cus_email
			$this->cus_email->LinkCustomAttributes = "";
			$this->cus_email->HrefValue = "";

			// cus_pass
			$this->cus_pass->LinkCustomAttributes = "";
			$this->cus_pass->HrefValue = "";

			// cus_picutre
			$this->cus_picutre->LinkCustomAttributes = "";
			$this->cus_picutre->HrefValue = "";

			// cus_note
			$this->cus_note->LinkCustomAttributes = "";
			$this->cus_note->HrefValue = "";
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

		// cus_fname
		$this->cus_fname->SetDbValueDef($rsnew, $this->cus_fname->CurrentValue, NULL, FALSE);

		// cus_lname
		$this->cus_lname->SetDbValueDef($rsnew, $this->cus_lname->CurrentValue, NULL, FALSE);

		// cus_gender
		$this->cus_gender->SetDbValueDef($rsnew, $this->cus_gender->CurrentValue, NULL, FALSE);

		// cus_address
		$this->cus_address->SetDbValueDef($rsnew, $this->cus_address->CurrentValue, NULL, FALSE);

		// cus_country
		$this->cus_country->SetDbValueDef($rsnew, $this->cus_country->CurrentValue, NULL, FALSE);

		// cus_email
		$this->cus_email->SetDbValueDef($rsnew, $this->cus_email->CurrentValue, NULL, FALSE);

		// cus_pass
		$this->cus_pass->SetDbValueDef($rsnew, $this->cus_pass->CurrentValue, NULL, FALSE);

		// cus_picutre
		$this->cus_picutre->SetDbValueDef($rsnew, $this->cus_picutre->CurrentValue, NULL, FALSE);

		// cus_note
		$this->cus_note->SetDbValueDef($rsnew, $this->cus_note->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("customerslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($customers_add)) $customers_add = new ccustomers_add();

// Page init
$customers_add->Page_Init();

// Page main
$customers_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$customers_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcustomersadd = new ew_Form("fcustomersadd", "add");

// Validate form
fcustomersadd.Validate = function() {
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
fcustomersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcustomersadd.ValidateRequired = true;
<?php } else { ?>
fcustomersadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$customers_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $customers_add->ShowPageHeader(); ?>
<?php
$customers_add->ShowMessage();
?>
<form name="fcustomersadd" id="fcustomersadd" class="<?php echo $customers_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($customers_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $customers_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="customers">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($customers_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($customers->cus_fname->Visible) { // cus_fname ?>
	<div id="r_cus_fname" class="form-group">
		<label id="elh_customers_cus_fname" for="x_cus_fname" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_fname->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_fname->CellAttributes() ?>>
<span id="el_customers_cus_fname">
<input type="text" data-table="customers" data-field="x_cus_fname" name="x_cus_fname" id="x_cus_fname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_fname->getPlaceHolder()) ?>" value="<?php echo $customers->cus_fname->EditValue ?>"<?php echo $customers->cus_fname->EditAttributes() ?>>
</span>
<?php echo $customers->cus_fname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_lname->Visible) { // cus_lname ?>
	<div id="r_cus_lname" class="form-group">
		<label id="elh_customers_cus_lname" for="x_cus_lname" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_lname->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_lname->CellAttributes() ?>>
<span id="el_customers_cus_lname">
<input type="text" data-table="customers" data-field="x_cus_lname" name="x_cus_lname" id="x_cus_lname" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_lname->getPlaceHolder()) ?>" value="<?php echo $customers->cus_lname->EditValue ?>"<?php echo $customers->cus_lname->EditAttributes() ?>>
</span>
<?php echo $customers->cus_lname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_gender->Visible) { // cus_gender ?>
	<div id="r_cus_gender" class="form-group">
		<label id="elh_customers_cus_gender" for="x_cus_gender" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_gender->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_gender->CellAttributes() ?>>
<span id="el_customers_cus_gender">
<input type="text" data-table="customers" data-field="x_cus_gender" name="x_cus_gender" id="x_cus_gender" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_gender->getPlaceHolder()) ?>" value="<?php echo $customers->cus_gender->EditValue ?>"<?php echo $customers->cus_gender->EditAttributes() ?>>
</span>
<?php echo $customers->cus_gender->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_address->Visible) { // cus_address ?>
	<div id="r_cus_address" class="form-group">
		<label id="elh_customers_cus_address" for="x_cus_address" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_address->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_address->CellAttributes() ?>>
<span id="el_customers_cus_address">
<input type="text" data-table="customers" data-field="x_cus_address" name="x_cus_address" id="x_cus_address" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_address->getPlaceHolder()) ?>" value="<?php echo $customers->cus_address->EditValue ?>"<?php echo $customers->cus_address->EditAttributes() ?>>
</span>
<?php echo $customers->cus_address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_country->Visible) { // cus_country ?>
	<div id="r_cus_country" class="form-group">
		<label id="elh_customers_cus_country" for="x_cus_country" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_country->CellAttributes() ?>>
<span id="el_customers_cus_country">
<input type="text" data-table="customers" data-field="x_cus_country" name="x_cus_country" id="x_cus_country" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_country->getPlaceHolder()) ?>" value="<?php echo $customers->cus_country->EditValue ?>"<?php echo $customers->cus_country->EditAttributes() ?>>
</span>
<?php echo $customers->cus_country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_email->Visible) { // cus_email ?>
	<div id="r_cus_email" class="form-group">
		<label id="elh_customers_cus_email" for="x_cus_email" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_email->CellAttributes() ?>>
<span id="el_customers_cus_email">
<input type="text" data-table="customers" data-field="x_cus_email" name="x_cus_email" id="x_cus_email" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_email->getPlaceHolder()) ?>" value="<?php echo $customers->cus_email->EditValue ?>"<?php echo $customers->cus_email->EditAttributes() ?>>
</span>
<?php echo $customers->cus_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_pass->Visible) { // cus_pass ?>
	<div id="r_cus_pass" class="form-group">
		<label id="elh_customers_cus_pass" for="x_cus_pass" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_pass->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_pass->CellAttributes() ?>>
<span id="el_customers_cus_pass">
<input type="text" data-table="customers" data-field="x_cus_pass" name="x_cus_pass" id="x_cus_pass" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_pass->getPlaceHolder()) ?>" value="<?php echo $customers->cus_pass->EditValue ?>"<?php echo $customers->cus_pass->EditAttributes() ?>>
</span>
<?php echo $customers->cus_pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_picutre->Visible) { // cus_picutre ?>
	<div id="r_cus_picutre" class="form-group">
		<label id="elh_customers_cus_picutre" for="x_cus_picutre" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_picutre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_picutre->CellAttributes() ?>>
<span id="el_customers_cus_picutre">
<input type="text" data-table="customers" data-field="x_cus_picutre" name="x_cus_picutre" id="x_cus_picutre" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_picutre->getPlaceHolder()) ?>" value="<?php echo $customers->cus_picutre->EditValue ?>"<?php echo $customers->cus_picutre->EditAttributes() ?>>
</span>
<?php echo $customers->cus_picutre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->cus_note->Visible) { // cus_note ?>
	<div id="r_cus_note" class="form-group">
		<label id="elh_customers_cus_note" for="x_cus_note" class="col-sm-2 control-label ewLabel"><?php echo $customers->cus_note->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $customers->cus_note->CellAttributes() ?>>
<span id="el_customers_cus_note">
<input type="text" data-table="customers" data-field="x_cus_note" name="x_cus_note" id="x_cus_note" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($customers->cus_note->getPlaceHolder()) ?>" value="<?php echo $customers->cus_note->EditValue ?>"<?php echo $customers->cus_note->EditAttributes() ?>>
</span>
<?php echo $customers->cus_note->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$customers_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $customers_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fcustomersadd.Init();
</script>
<?php
$customers_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$customers_add->Page_Terminate();
?>

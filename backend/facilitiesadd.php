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

$facilities_add = NULL; // Initialize page object first

class cfacilities_add extends cfacilities {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'facilities';

	// Page object name
	var $PageObjName = 'facilities_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
			if (@$_GET["facil_id"] != "") {
				$this->facil_id->setQueryStringValue($_GET["facil_id"]);
				$this->setKey("facil_id", $this->facil_id->CurrentValue); // Set up key
			} else {
				$this->setKey("facil_id", ""); // Clear key
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
					$this->Page_Terminate("facilitieslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "facilitieslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "facilitiesview.php")
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
		$this->facil_image->Upload->Index = $objForm->Index;
		$this->facil_image->Upload->UploadFile();
		$this->facil_image->CurrentValue = $this->facil_image->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->facil_name->CurrentValue = NULL;
		$this->facil_name->OldValue = $this->facil_name->CurrentValue;
		$this->facil_image->Upload->DbValue = NULL;
		$this->facil_image->OldValue = $this->facil_image->Upload->DbValue;
		$this->facil_image->CurrentValue = NULL; // Clear file related field
		$this->facil_icon->CurrentValue = NULL;
		$this->facil_icon->OldValue = $this->facil_icon->CurrentValue;
		$this->facil_hot->CurrentValue = NULL;
		$this->facil_hot->OldValue = $this->facil_hot->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->facil_name->FldIsDetailKey) {
			$this->facil_name->setFormValue($objForm->GetValue("x_facil_name"));
		}
		if (!$this->facil_icon->FldIsDetailKey) {
			$this->facil_icon->setFormValue($objForm->GetValue("x_facil_icon"));
		}
		if (!$this->facil_hot->FldIsDetailKey) {
			$this->facil_hot->setFormValue($objForm->GetValue("x_facil_hot"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->facil_name->CurrentValue = $this->facil_name->FormValue;
		$this->facil_icon->CurrentValue = $this->facil_icon->FormValue;
		$this->facil_hot->CurrentValue = $this->facil_hot->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("facil_id")) <> "")
			$this->facil_id->CurrentValue = $this->getKey("facil_id"); // facil_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// facil_name
			$this->facil_name->EditAttrs["class"] = "form-control";
			$this->facil_name->EditCustomAttributes = "";
			$this->facil_name->EditValue = ew_HtmlEncode($this->facil_name->CurrentValue);
			$this->facil_name->PlaceHolder = ew_RemoveHtml($this->facil_name->FldCaption());

			// facil_image
			$this->facil_image->EditAttrs["class"] = "form-control";
			$this->facil_image->EditCustomAttributes = "";
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->DbValue)) {
				$this->facil_image->ImageAlt = $this->facil_image->FldAlt();
				$this->facil_image->EditValue = $this->facil_image->Upload->DbValue;
			} else {
				$this->facil_image->EditValue = "";
			}
			if (!ew_Empty($this->facil_image->CurrentValue))
				$this->facil_image->Upload->FileName = $this->facil_image->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->facil_image);

			// facil_icon
			$this->facil_icon->EditAttrs["class"] = "form-control";
			$this->facil_icon->EditCustomAttributes = "";
			$this->facil_icon->EditValue = ew_HtmlEncode($this->facil_icon->CurrentValue);
			$this->facil_icon->PlaceHolder = ew_RemoveHtml($this->facil_icon->FldCaption());

			// facil_hot
			$this->facil_hot->EditCustomAttributes = "";
			$this->facil_hot->EditValue = $this->facil_hot->Options(FALSE);

			// Add refer script
			// facil_name

			$this->facil_name->LinkCustomAttributes = "";
			$this->facil_name->HrefValue = "";

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

			// facil_icon
			$this->facil_icon->LinkCustomAttributes = "";
			$this->facil_icon->HrefValue = "";

			// facil_hot
			$this->facil_hot->LinkCustomAttributes = "";
			$this->facil_hot->HrefValue = "";
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
			$this->facil_image->OldUploadPath = "../uploads/facilities";
			$this->facil_image->UploadPath = $this->facil_image->OldUploadPath;
		}
		$rsnew = array();

		// facil_name
		$this->facil_name->SetDbValueDef($rsnew, $this->facil_name->CurrentValue, NULL, FALSE);

		// facil_image
		if ($this->facil_image->Visible && !$this->facil_image->Upload->KeepFile) {
			$this->facil_image->Upload->DbValue = ""; // No need to delete old file
			if ($this->facil_image->Upload->FileName == "") {
				$rsnew['facil_image'] = NULL;
			} else {
				$rsnew['facil_image'] = $this->facil_image->Upload->FileName;
			}
		}

		// facil_icon
		$this->facil_icon->SetDbValueDef($rsnew, $this->facil_icon->CurrentValue, NULL, FALSE);

		// facil_hot
		$tmpBool = $this->facil_hot->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->facil_hot->SetDbValueDef($rsnew, $tmpBool, NULL, FALSE);
		if ($this->facil_image->Visible && !$this->facil_image->Upload->KeepFile) {
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->Value)) {
				$rsnew['facil_image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->facil_image->UploadPath), $rsnew['facil_image']); // Get new file name
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
				if ($this->facil_image->Visible && !$this->facil_image->Upload->KeepFile) {
					if (!ew_Empty($this->facil_image->Upload->Value)) {
						if (!$this->facil_image->Upload->SaveToFile($this->facil_image->UploadPath, $rsnew['facil_image'], TRUE)) {
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

		// facil_image
		ew_CleanUploadTempPath($this->facil_image, $this->facil_image->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("facilitieslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($facilities_add)) $facilities_add = new cfacilities_add();

// Page init
$facilities_add->Page_Init();

// Page main
$facilities_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$facilities_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ffacilitiesadd = new ew_Form("ffacilitiesadd", "add");

// Validate form
ffacilitiesadd.Validate = function() {
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
ffacilitiesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffacilitiesadd.ValidateRequired = true;
<?php } else { ?>
ffacilitiesadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffacilitiesadd.Lists["x_facil_hot[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffacilitiesadd.Lists["x_facil_hot[]"].Options = <?php echo json_encode($facilities->facil_hot->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$facilities_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $facilities_add->ShowPageHeader(); ?>
<?php
$facilities_add->ShowMessage();
?>
<form name="ffacilitiesadd" id="ffacilitiesadd" class="<?php echo $facilities_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($facilities_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $facilities_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="facilities">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($facilities_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($facilities->facil_name->Visible) { // facil_name ?>
	<div id="r_facil_name" class="form-group">
		<label id="elh_facilities_facil_name" for="x_facil_name" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_name->CellAttributes() ?>>
<span id="el_facilities_facil_name">
<input type="text" data-table="facilities" data-field="x_facil_name" name="x_facil_name" id="x_facil_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($facilities->facil_name->getPlaceHolder()) ?>" value="<?php echo $facilities->facil_name->EditValue ?>"<?php echo $facilities->facil_name->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_image->Visible) { // facil_image ?>
	<div id="r_facil_image" class="form-group">
		<label id="elh_facilities_facil_image" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_image->CellAttributes() ?>>
<span id="el_facilities_facil_image">
<div id="fd_x_facil_image">
<span title="<?php echo $facilities->facil_image->FldTitle() ? $facilities->facil_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($facilities->facil_image->ReadOnly || $facilities->facil_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="facilities" data-field="x_facil_image" name="x_facil_image" id="x_facil_image"<?php echo $facilities->facil_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_facil_image" id= "fn_x_facil_image" value="<?php echo $facilities->facil_image->Upload->FileName ?>">
<input type="hidden" name="fa_x_facil_image" id= "fa_x_facil_image" value="0">
<input type="hidden" name="fs_x_facil_image" id= "fs_x_facil_image" value="250">
<input type="hidden" name="fx_x_facil_image" id= "fx_x_facil_image" value="<?php echo $facilities->facil_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_facil_image" id= "fm_x_facil_image" value="<?php echo $facilities->facil_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_facil_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $facilities->facil_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_icon->Visible) { // facil_icon ?>
	<div id="r_facil_icon" class="form-group">
		<label id="elh_facilities_facil_icon" for="x_facil_icon" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_icon->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_icon->CellAttributes() ?>>
<span id="el_facilities_facil_icon">
<input type="text" data-table="facilities" data-field="x_facil_icon" name="x_facil_icon" id="x_facil_icon" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($facilities->facil_icon->getPlaceHolder()) ?>" value="<?php echo $facilities->facil_icon->EditValue ?>"<?php echo $facilities->facil_icon->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_hot->Visible) { // facil_hot ?>
	<div id="r_facil_hot" class="form-group">
		<label id="elh_facilities_facil_hot" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_hot->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_hot->CellAttributes() ?>>
<span id="el_facilities_facil_hot">
<?php
$selwrk = (ew_ConvertToBool($facilities->facil_hot->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="facilities" data-field="x_facil_hot" name="x_facil_hot[]" id="x_facil_hot[]" value="1"<?php echo $selwrk ?><?php echo $facilities->facil_hot->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_hot->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$facilities_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $facilities_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ffacilitiesadd.Init();
</script>
<?php
$facilities_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$facilities_add->Page_Terminate();
?>

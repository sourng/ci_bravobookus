<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "destinationsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$destinations_add = NULL; // Initialize page object first

class cdestinations_add extends cdestinations {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'destinations';

	// Page object name
	var $PageObjName = 'destinations_add';

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

		// Table object (destinations)
		if (!isset($GLOBALS["destinations"]) || get_class($GLOBALS["destinations"]) == "cdestinations") {
			$GLOBALS["destinations"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["destinations"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'destinations', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("destinationslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->destinations->SetVisibility();
		$this->dest_landmark->SetVisibility();
		$this->dest_description->SetVisibility();
		$this->dest_interest->SetVisibility();
		$this->thing_todo->SetVisibility();
		$this->country->SetVisibility();

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
		global $EW_EXPORT, $destinations;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($destinations);
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
					$this->Page_Terminate("destinationslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "destinationslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "destinationsview.php")
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
		$this->dest_landmark->Upload->Index = $objForm->Index;
		$this->dest_landmark->Upload->UploadFile();
		$this->dest_landmark->CurrentValue = $this->dest_landmark->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->destinations->CurrentValue = NULL;
		$this->destinations->OldValue = $this->destinations->CurrentValue;
		$this->dest_landmark->Upload->DbValue = NULL;
		$this->dest_landmark->OldValue = $this->dest_landmark->Upload->DbValue;
		$this->dest_landmark->CurrentValue = NULL; // Clear file related field
		$this->dest_description->CurrentValue = NULL;
		$this->dest_description->OldValue = $this->dest_description->CurrentValue;
		$this->dest_interest->CurrentValue = NULL;
		$this->dest_interest->OldValue = $this->dest_interest->CurrentValue;
		$this->thing_todo->CurrentValue = NULL;
		$this->thing_todo->OldValue = $this->thing_todo->CurrentValue;
		$this->country->CurrentValue = NULL;
		$this->country->OldValue = $this->country->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->destinations->FldIsDetailKey) {
			$this->destinations->setFormValue($objForm->GetValue("x_destinations"));
		}
		if (!$this->dest_description->FldIsDetailKey) {
			$this->dest_description->setFormValue($objForm->GetValue("x_dest_description"));
		}
		if (!$this->dest_interest->FldIsDetailKey) {
			$this->dest_interest->setFormValue($objForm->GetValue("x_dest_interest"));
		}
		if (!$this->thing_todo->FldIsDetailKey) {
			$this->thing_todo->setFormValue($objForm->GetValue("x_thing_todo"));
		}
		if (!$this->country->FldIsDetailKey) {
			$this->country->setFormValue($objForm->GetValue("x_country"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->destinations->CurrentValue = $this->destinations->FormValue;
		$this->dest_description->CurrentValue = $this->dest_description->FormValue;
		$this->dest_interest->CurrentValue = $this->dest_interest->FormValue;
		$this->thing_todo->CurrentValue = $this->thing_todo->FormValue;
		$this->country->CurrentValue = $this->country->FormValue;
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
		$this->destinations->setDbValue($rs->fields('destinations'));
		$this->dest_landmark->Upload->DbValue = $rs->fields('dest_landmark');
		$this->dest_landmark->CurrentValue = $this->dest_landmark->Upload->DbValue;
		$this->dest_description->setDbValue($rs->fields('dest_description'));
		$this->dest_interest->setDbValue($rs->fields('dest_interest'));
		$this->thing_todo->setDbValue($rs->fields('thing_todo'));
		$this->country->setDbValue($rs->fields('country'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->dest_id->DbValue = $row['dest_id'];
		$this->destinations->DbValue = $row['destinations'];
		$this->dest_landmark->Upload->DbValue = $row['dest_landmark'];
		$this->dest_description->DbValue = $row['dest_description'];
		$this->dest_interest->DbValue = $row['dest_interest'];
		$this->thing_todo->DbValue = $row['thing_todo'];
		$this->country->DbValue = $row['country'];
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
		// destinations
		// dest_landmark
		// dest_description
		// dest_interest
		// thing_todo
		// country

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// destinations
		$this->destinations->ViewValue = $this->destinations->CurrentValue;
		$this->destinations->ViewCustomAttributes = "";

		// dest_landmark
		$this->dest_landmark->UploadPath = "../uploads/destinations";
		if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
			$this->dest_landmark->ImageAlt = $this->dest_landmark->FldAlt();
			$this->dest_landmark->ViewValue = $this->dest_landmark->Upload->DbValue;
		} else {
			$this->dest_landmark->ViewValue = "";
		}
		$this->dest_landmark->ViewCustomAttributes = "";

		// dest_description
		$this->dest_description->ViewValue = $this->dest_description->CurrentValue;
		$this->dest_description->ViewCustomAttributes = "";

		// dest_interest
		$this->dest_interest->ViewValue = $this->dest_interest->CurrentValue;
		$this->dest_interest->ViewCustomAttributes = "";

		// thing_todo
		$this->thing_todo->ViewValue = $this->thing_todo->CurrentValue;
		$this->thing_todo->ViewCustomAttributes = "";

		// country
		$this->country->ViewValue = $this->country->CurrentValue;
		$this->country->ViewCustomAttributes = "";

			// destinations
			$this->destinations->LinkCustomAttributes = "";
			$this->destinations->HrefValue = "";
			$this->destinations->TooltipValue = "";

			// dest_landmark
			$this->dest_landmark->LinkCustomAttributes = "";
			$this->dest_landmark->UploadPath = "../uploads/destinations";
			if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
				$this->dest_landmark->HrefValue = ew_GetFileUploadUrl($this->dest_landmark, $this->dest_landmark->Upload->DbValue); // Add prefix/suffix
				$this->dest_landmark->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->dest_landmark->HrefValue = ew_ConvertFullUrl($this->dest_landmark->HrefValue);
			} else {
				$this->dest_landmark->HrefValue = "";
			}
			$this->dest_landmark->HrefValue2 = $this->dest_landmark->UploadPath . $this->dest_landmark->Upload->DbValue;
			$this->dest_landmark->TooltipValue = "";
			if ($this->dest_landmark->UseColorbox) {
				if (ew_Empty($this->dest_landmark->TooltipValue))
					$this->dest_landmark->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->dest_landmark->LinkAttrs["data-rel"] = "destinations_x_dest_landmark";
				ew_AppendClass($this->dest_landmark->LinkAttrs["class"], "ewLightbox");
			}

			// dest_description
			$this->dest_description->LinkCustomAttributes = "";
			$this->dest_description->HrefValue = "";
			$this->dest_description->TooltipValue = "";

			// dest_interest
			$this->dest_interest->LinkCustomAttributes = "";
			$this->dest_interest->HrefValue = "";
			$this->dest_interest->TooltipValue = "";

			// thing_todo
			$this->thing_todo->LinkCustomAttributes = "";
			$this->thing_todo->HrefValue = "";
			$this->thing_todo->TooltipValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
			$this->country->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// destinations
			$this->destinations->EditAttrs["class"] = "form-control";
			$this->destinations->EditCustomAttributes = "";
			$this->destinations->EditValue = ew_HtmlEncode($this->destinations->CurrentValue);
			$this->destinations->PlaceHolder = ew_RemoveHtml($this->destinations->FldCaption());

			// dest_landmark
			$this->dest_landmark->EditAttrs["class"] = "form-control";
			$this->dest_landmark->EditCustomAttributes = "";
			$this->dest_landmark->UploadPath = "../uploads/destinations";
			if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
				$this->dest_landmark->ImageAlt = $this->dest_landmark->FldAlt();
				$this->dest_landmark->EditValue = $this->dest_landmark->Upload->DbValue;
			} else {
				$this->dest_landmark->EditValue = "";
			}
			if (!ew_Empty($this->dest_landmark->CurrentValue))
				$this->dest_landmark->Upload->FileName = $this->dest_landmark->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->dest_landmark);

			// dest_description
			$this->dest_description->EditAttrs["class"] = "form-control";
			$this->dest_description->EditCustomAttributes = "";
			$this->dest_description->EditValue = ew_HtmlEncode($this->dest_description->CurrentValue);
			$this->dest_description->PlaceHolder = ew_RemoveHtml($this->dest_description->FldCaption());

			// dest_interest
			$this->dest_interest->EditAttrs["class"] = "form-control";
			$this->dest_interest->EditCustomAttributes = "";
			$this->dest_interest->EditValue = ew_HtmlEncode($this->dest_interest->CurrentValue);
			$this->dest_interest->PlaceHolder = ew_RemoveHtml($this->dest_interest->FldCaption());

			// thing_todo
			$this->thing_todo->EditAttrs["class"] = "form-control";
			$this->thing_todo->EditCustomAttributes = "";
			$this->thing_todo->EditValue = ew_HtmlEncode($this->thing_todo->CurrentValue);
			$this->thing_todo->PlaceHolder = ew_RemoveHtml($this->thing_todo->FldCaption());

			// country
			$this->country->EditAttrs["class"] = "form-control";
			$this->country->EditCustomAttributes = "";
			$this->country->EditValue = ew_HtmlEncode($this->country->CurrentValue);
			$this->country->PlaceHolder = ew_RemoveHtml($this->country->FldCaption());

			// Add refer script
			// destinations

			$this->destinations->LinkCustomAttributes = "";
			$this->destinations->HrefValue = "";

			// dest_landmark
			$this->dest_landmark->LinkCustomAttributes = "";
			$this->dest_landmark->UploadPath = "../uploads/destinations";
			if (!ew_Empty($this->dest_landmark->Upload->DbValue)) {
				$this->dest_landmark->HrefValue = ew_GetFileUploadUrl($this->dest_landmark, $this->dest_landmark->Upload->DbValue); // Add prefix/suffix
				$this->dest_landmark->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->dest_landmark->HrefValue = ew_ConvertFullUrl($this->dest_landmark->HrefValue);
			} else {
				$this->dest_landmark->HrefValue = "";
			}
			$this->dest_landmark->HrefValue2 = $this->dest_landmark->UploadPath . $this->dest_landmark->Upload->DbValue;

			// dest_description
			$this->dest_description->LinkCustomAttributes = "";
			$this->dest_description->HrefValue = "";

			// dest_interest
			$this->dest_interest->LinkCustomAttributes = "";
			$this->dest_interest->HrefValue = "";

			// thing_todo
			$this->thing_todo->LinkCustomAttributes = "";
			$this->thing_todo->HrefValue = "";

			// country
			$this->country->LinkCustomAttributes = "";
			$this->country->HrefValue = "";
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
			$this->dest_landmark->OldUploadPath = "../uploads/destinations";
			$this->dest_landmark->UploadPath = $this->dest_landmark->OldUploadPath;
		}
		$rsnew = array();

		// destinations
		$this->destinations->SetDbValueDef($rsnew, $this->destinations->CurrentValue, NULL, FALSE);

		// dest_landmark
		if ($this->dest_landmark->Visible && !$this->dest_landmark->Upload->KeepFile) {
			$this->dest_landmark->Upload->DbValue = ""; // No need to delete old file
			if ($this->dest_landmark->Upload->FileName == "") {
				$rsnew['dest_landmark'] = NULL;
			} else {
				$rsnew['dest_landmark'] = $this->dest_landmark->Upload->FileName;
			}
		}

		// dest_description
		$this->dest_description->SetDbValueDef($rsnew, $this->dest_description->CurrentValue, NULL, FALSE);

		// dest_interest
		$this->dest_interest->SetDbValueDef($rsnew, $this->dest_interest->CurrentValue, NULL, FALSE);

		// thing_todo
		$this->thing_todo->SetDbValueDef($rsnew, $this->thing_todo->CurrentValue, NULL, FALSE);

		// country
		$this->country->SetDbValueDef($rsnew, $this->country->CurrentValue, NULL, FALSE);
		if ($this->dest_landmark->Visible && !$this->dest_landmark->Upload->KeepFile) {
			$this->dest_landmark->UploadPath = "../uploads/destinations";
			if (!ew_Empty($this->dest_landmark->Upload->Value)) {
				$rsnew['dest_landmark'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->dest_landmark->UploadPath), $rsnew['dest_landmark']); // Get new file name
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
				if ($this->dest_landmark->Visible && !$this->dest_landmark->Upload->KeepFile) {
					if (!ew_Empty($this->dest_landmark->Upload->Value)) {
						if (!$this->dest_landmark->Upload->SaveToFile($this->dest_landmark->UploadPath, $rsnew['dest_landmark'], TRUE)) {
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

		// dest_landmark
		ew_CleanUploadTempPath($this->dest_landmark, $this->dest_landmark->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("destinationslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($destinations_add)) $destinations_add = new cdestinations_add();

// Page init
$destinations_add->Page_Init();

// Page main
$destinations_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$destinations_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdestinationsadd = new ew_Form("fdestinationsadd", "add");

// Validate form
fdestinationsadd.Validate = function() {
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
fdestinationsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdestinationsadd.ValidateRequired = true;
<?php } else { ?>
fdestinationsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$destinations_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $destinations_add->ShowPageHeader(); ?>
<?php
$destinations_add->ShowMessage();
?>
<form name="fdestinationsadd" id="fdestinationsadd" class="<?php echo $destinations_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($destinations_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $destinations_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="destinations">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($destinations_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($destinations->destinations->Visible) { // destinations ?>
	<div id="r_destinations" class="form-group">
		<label id="elh_destinations_destinations" for="x_destinations" class="col-sm-2 control-label ewLabel"><?php echo $destinations->destinations->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->destinations->CellAttributes() ?>>
<span id="el_destinations_destinations">
<input type="text" data-table="destinations" data-field="x_destinations" name="x_destinations" id="x_destinations" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->destinations->getPlaceHolder()) ?>" value="<?php echo $destinations->destinations->EditValue ?>"<?php echo $destinations->destinations->EditAttributes() ?>>
</span>
<?php echo $destinations->destinations->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations->dest_landmark->Visible) { // dest_landmark ?>
	<div id="r_dest_landmark" class="form-group">
		<label id="elh_destinations_dest_landmark" class="col-sm-2 control-label ewLabel"><?php echo $destinations->dest_landmark->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->dest_landmark->CellAttributes() ?>>
<span id="el_destinations_dest_landmark">
<div id="fd_x_dest_landmark">
<span title="<?php echo $destinations->dest_landmark->FldTitle() ? $destinations->dest_landmark->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($destinations->dest_landmark->ReadOnly || $destinations->dest_landmark->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="destinations" data-field="x_dest_landmark" name="x_dest_landmark" id="x_dest_landmark"<?php echo $destinations->dest_landmark->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_dest_landmark" id= "fn_x_dest_landmark" value="<?php echo $destinations->dest_landmark->Upload->FileName ?>">
<input type="hidden" name="fa_x_dest_landmark" id= "fa_x_dest_landmark" value="0">
<input type="hidden" name="fs_x_dest_landmark" id= "fs_x_dest_landmark" value="250">
<input type="hidden" name="fx_x_dest_landmark" id= "fx_x_dest_landmark" value="<?php echo $destinations->dest_landmark->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_dest_landmark" id= "fm_x_dest_landmark" value="<?php echo $destinations->dest_landmark->UploadMaxFileSize ?>">
</div>
<table id="ft_x_dest_landmark" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $destinations->dest_landmark->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations->dest_description->Visible) { // dest_description ?>
	<div id="r_dest_description" class="form-group">
		<label id="elh_destinations_dest_description" for="x_dest_description" class="col-sm-2 control-label ewLabel"><?php echo $destinations->dest_description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->dest_description->CellAttributes() ?>>
<span id="el_destinations_dest_description">
<input type="text" data-table="destinations" data-field="x_dest_description" name="x_dest_description" id="x_dest_description" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->dest_description->getPlaceHolder()) ?>" value="<?php echo $destinations->dest_description->EditValue ?>"<?php echo $destinations->dest_description->EditAttributes() ?>>
</span>
<?php echo $destinations->dest_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations->dest_interest->Visible) { // dest_interest ?>
	<div id="r_dest_interest" class="form-group">
		<label id="elh_destinations_dest_interest" for="x_dest_interest" class="col-sm-2 control-label ewLabel"><?php echo $destinations->dest_interest->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->dest_interest->CellAttributes() ?>>
<span id="el_destinations_dest_interest">
<textarea data-table="destinations" data-field="x_dest_interest" name="x_dest_interest" id="x_dest_interest" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($destinations->dest_interest->getPlaceHolder()) ?>"<?php echo $destinations->dest_interest->EditAttributes() ?>><?php echo $destinations->dest_interest->EditValue ?></textarea>
</span>
<?php echo $destinations->dest_interest->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations->thing_todo->Visible) { // thing_todo ?>
	<div id="r_thing_todo" class="form-group">
		<label id="elh_destinations_thing_todo" for="x_thing_todo" class="col-sm-2 control-label ewLabel"><?php echo $destinations->thing_todo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->thing_todo->CellAttributes() ?>>
<span id="el_destinations_thing_todo">
<textarea data-table="destinations" data-field="x_thing_todo" name="x_thing_todo" id="x_thing_todo" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($destinations->thing_todo->getPlaceHolder()) ?>"<?php echo $destinations->thing_todo->EditAttributes() ?>><?php echo $destinations->thing_todo->EditValue ?></textarea>
</span>
<?php echo $destinations->thing_todo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($destinations->country->Visible) { // country ?>
	<div id="r_country" class="form-group">
		<label id="elh_destinations_country" for="x_country" class="col-sm-2 control-label ewLabel"><?php echo $destinations->country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $destinations->country->CellAttributes() ?>>
<span id="el_destinations_country">
<input type="text" data-table="destinations" data-field="x_country" name="x_country" id="x_country" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($destinations->country->getPlaceHolder()) ?>" value="<?php echo $destinations->country->EditValue ?>"<?php echo $destinations->country->EditAttributes() ?>>
</span>
<?php echo $destinations->country->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$destinations_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $destinations_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdestinationsadd.Init();
</script>
<?php
$destinations_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$destinations_add->Page_Terminate();
?>

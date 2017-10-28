<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_facilitiesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_facilities_edit = NULL; // Initialize page object first

class chotel_facilities_edit extends chotel_facilities {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_facilities';

	// Page object name
	var $PageObjName = 'hotel_facilities_edit';

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

		// Table object (hotel_facilities)
		if (!isset($GLOBALS["hotel_facilities"]) || get_class($GLOBALS["hotel_facilities"]) == "chotel_facilities") {
			$GLOBALS["hotel_facilities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_facilities"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_facilities', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotel_facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hfacility_id->SetVisibility();
		$this->hfacility_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hotel_id->SetVisibility();
		$this->hf_name->SetVisibility();
		$this->hf_image->SetVisibility();
		$this->hf_icons->SetVisibility();
		$this->status->SetVisibility();
		$this->hot_facilities->SetVisibility();

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
		global $EW_EXPORT, $hotel_facilities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_facilities);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

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

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["hfacility_id"] <> "") {
			$this->hfacility_id->setQueryStringValue($_GET["hfacility_id"]);
			$this->RecKey["hfacility_id"] = $this->hfacility_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}
		if (@$_GET["hotel_id"] <> "") {
			$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
			$this->RecKey["hotel_id"] = $this->hotel_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("hotel_facilitieslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->hfacility_id->CurrentValue) == strval($this->Recordset->fields('hfacility_id')) && strval($this->hotel_id->CurrentValue) == strval($this->Recordset->fields('hotel_id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("hotel_facilitieslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "hotel_facilitieslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->hfacility_id->FldIsDetailKey)
			$this->hfacility_id->setFormValue($objForm->GetValue("x_hfacility_id"));
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->hf_name->FldIsDetailKey) {
			$this->hf_name->setFormValue($objForm->GetValue("x_hf_name"));
		}
		if (!$this->hf_image->FldIsDetailKey) {
			$this->hf_image->setFormValue($objForm->GetValue("x_hf_image"));
		}
		if (!$this->hf_icons->FldIsDetailKey) {
			$this->hf_icons->setFormValue($objForm->GetValue("x_hf_icons"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->hot_facilities->FldIsDetailKey) {
			$this->hot_facilities->setFormValue($objForm->GetValue("x_hot_facilities"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->hfacility_id->CurrentValue = $this->hfacility_id->FormValue;
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->hf_name->CurrentValue = $this->hf_name->FormValue;
		$this->hf_image->CurrentValue = $this->hf_image->FormValue;
		$this->hf_icons->CurrentValue = $this->hf_icons->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->hot_facilities->CurrentValue = $this->hot_facilities->FormValue;
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
		$this->hfacility_id->setDbValue($rs->fields('hfacility_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->hf_name->setDbValue($rs->fields('hf_name'));
		$this->hf_image->setDbValue($rs->fields('hf_image'));
		$this->hf_icons->setDbValue($rs->fields('hf_icons'));
		$this->status->setDbValue($rs->fields('status'));
		$this->hot_facilities->setDbValue($rs->fields('hot_facilities'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hfacility_id->DbValue = $row['hfacility_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->hf_name->DbValue = $row['hf_name'];
		$this->hf_image->DbValue = $row['hf_image'];
		$this->hf_icons->DbValue = $row['hf_icons'];
		$this->status->DbValue = $row['status'];
		$this->hot_facilities->DbValue = $row['hot_facilities'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// hfacility_id
		// hotel_id
		// hf_name
		// hf_image
		// hf_icons
		// status
		// hot_facilities

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hfacility_id
		$this->hfacility_id->ViewValue = $this->hfacility_id->CurrentValue;
		$this->hfacility_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hf_name
		$this->hf_name->ViewValue = $this->hf_name->CurrentValue;
		$this->hf_name->ViewCustomAttributes = "";

		// hf_image
		$this->hf_image->ViewValue = $this->hf_image->CurrentValue;
		$this->hf_image->ViewCustomAttributes = "";

		// hf_icons
		$this->hf_icons->ViewValue = $this->hf_icons->CurrentValue;
		$this->hf_icons->ViewCustomAttributes = "";

		// status
		if (ew_ConvertToBool($this->status->CurrentValue)) {
			$this->status->ViewValue = $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : "Y";
		} else {
			$this->status->ViewValue = $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : "N";
		}
		$this->status->ViewCustomAttributes = "";

		// hot_facilities
		if (ew_ConvertToBool($this->hot_facilities->CurrentValue)) {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(1) <> "" ? $this->hot_facilities->FldTagCaption(1) : "Y";
		} else {
			$this->hot_facilities->ViewValue = $this->hot_facilities->FldTagCaption(2) <> "" ? $this->hot_facilities->FldTagCaption(2) : "N";
		}
		$this->hot_facilities->ViewCustomAttributes = "";

			// hfacility_id
			$this->hfacility_id->LinkCustomAttributes = "";
			$this->hfacility_id->HrefValue = "";
			$this->hfacility_id->TooltipValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// hf_name
			$this->hf_name->LinkCustomAttributes = "";
			$this->hf_name->HrefValue = "";
			$this->hf_name->TooltipValue = "";

			// hf_image
			$this->hf_image->LinkCustomAttributes = "";
			$this->hf_image->HrefValue = "";
			$this->hf_image->TooltipValue = "";

			// hf_icons
			$this->hf_icons->LinkCustomAttributes = "";
			$this->hf_icons->HrefValue = "";
			$this->hf_icons->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// hot_facilities
			$this->hot_facilities->LinkCustomAttributes = "";
			$this->hot_facilities->HrefValue = "";
			$this->hot_facilities->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// hfacility_id
			$this->hfacility_id->EditAttrs["class"] = "form-control";
			$this->hfacility_id->EditCustomAttributes = "";
			$this->hfacility_id->EditValue = $this->hfacility_id->CurrentValue;
			$this->hfacility_id->ViewCustomAttributes = "";

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
			$this->hotel_id->ViewCustomAttributes = "";

			// hf_name
			$this->hf_name->EditAttrs["class"] = "form-control";
			$this->hf_name->EditCustomAttributes = "";
			$this->hf_name->EditValue = ew_HtmlEncode($this->hf_name->CurrentValue);
			$this->hf_name->PlaceHolder = ew_RemoveHtml($this->hf_name->FldCaption());

			// hf_image
			$this->hf_image->EditAttrs["class"] = "form-control";
			$this->hf_image->EditCustomAttributes = "";
			$this->hf_image->EditValue = ew_HtmlEncode($this->hf_image->CurrentValue);
			$this->hf_image->PlaceHolder = ew_RemoveHtml($this->hf_image->FldCaption());

			// hf_icons
			$this->hf_icons->EditAttrs["class"] = "form-control";
			$this->hf_icons->EditCustomAttributes = "";
			$this->hf_icons->EditValue = ew_HtmlEncode($this->hf_icons->CurrentValue);
			$this->hf_icons->PlaceHolder = ew_RemoveHtml($this->hf_icons->FldCaption());

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(FALSE);

			// hot_facilities
			$this->hot_facilities->EditCustomAttributes = "";
			$this->hot_facilities->EditValue = $this->hot_facilities->Options(FALSE);

			// Edit refer script
			// hfacility_id

			$this->hfacility_id->LinkCustomAttributes = "";
			$this->hfacility_id->HrefValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// hf_name
			$this->hf_name->LinkCustomAttributes = "";
			$this->hf_name->HrefValue = "";

			// hf_image
			$this->hf_image->LinkCustomAttributes = "";
			$this->hf_image->HrefValue = "";

			// hf_icons
			$this->hf_icons->LinkCustomAttributes = "";
			$this->hf_icons->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// hot_facilities
			$this->hot_facilities->LinkCustomAttributes = "";
			$this->hot_facilities->HrefValue = "";
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
		if (!$this->hotel_id->FldIsDetailKey && !is_null($this->hotel_id->FormValue) && $this->hotel_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hotel_id->FldCaption(), $this->hotel_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hotel_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hotel_id->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// hotel_id
			// hf_name

			$this->hf_name->SetDbValueDef($rsnew, $this->hf_name->CurrentValue, NULL, $this->hf_name->ReadOnly);

			// hf_image
			$this->hf_image->SetDbValueDef($rsnew, $this->hf_image->CurrentValue, NULL, $this->hf_image->ReadOnly);

			// hf_icons
			$this->hf_icons->SetDbValueDef($rsnew, $this->hf_icons->CurrentValue, NULL, $this->hf_icons->ReadOnly);

			// status
			$tmpBool = $this->status->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->status->SetDbValueDef($rsnew, $tmpBool, NULL, $this->status->ReadOnly);

			// hot_facilities
			$tmpBool = $this->hot_facilities->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->hot_facilities->SetDbValueDef($rsnew, $tmpBool, NULL, $this->hot_facilities->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_facilitieslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($hotel_facilities_edit)) $hotel_facilities_edit = new chotel_facilities_edit();

// Page init
$hotel_facilities_edit->Page_Init();

// Page main
$hotel_facilities_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_facilities_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhotel_facilitiesedit = new ew_Form("fhotel_facilitiesedit", "edit");

// Validate form
fhotel_facilitiesedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_facilities->hotel_id->FldCaption(), $hotel_facilities->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_facilities->hotel_id->FldErrMsg()) ?>");

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
fhotel_facilitiesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_facilitiesedit.ValidateRequired = true;
<?php } else { ?>
fhotel_facilitiesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotel_facilitiesedit.Lists["x_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesedit.Lists["x_status[]"].Options = <?php echo json_encode($hotel_facilities->status->Options()) ?>;
fhotel_facilitiesedit.Lists["x_hot_facilities[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_facilitiesedit.Lists["x_hot_facilities[]"].Options = <?php echo json_encode($hotel_facilities->hot_facilities->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_facilities_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_facilities_edit->ShowPageHeader(); ?>
<?php
$hotel_facilities_edit->ShowMessage();
?>
<?php if (!$hotel_facilities_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_facilities_edit->Pager)) $hotel_facilities_edit->Pager = new cPrevNextPager($hotel_facilities_edit->StartRec, $hotel_facilities_edit->DisplayRecs, $hotel_facilities_edit->TotalRecs) ?>
<?php if ($hotel_facilities_edit->Pager->RecordCount > 0 && $hotel_facilities_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_facilities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_facilities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_facilities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_facilities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_facilities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_facilities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fhotel_facilitiesedit" id="fhotel_facilitiesedit" class="<?php echo $hotel_facilities_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_facilities_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_facilities_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_facilities">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($hotel_facilities_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_facilities->hfacility_id->Visible) { // hfacility_id ?>
	<div id="r_hfacility_id" class="form-group">
		<label id="elh_hotel_facilities_hfacility_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hfacility_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hfacility_id->CellAttributes() ?>>
<span id="el_hotel_facilities_hfacility_id">
<span<?php echo $hotel_facilities->hfacility_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_facilities->hfacility_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_facilities" data-field="x_hfacility_id" name="x_hfacility_id" id="x_hfacility_id" value="<?php echo ew_HtmlEncode($hotel_facilities->hfacility_id->CurrentValue) ?>">
<?php echo $hotel_facilities->hfacility_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_hotel_facilities_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hotel_id->CellAttributes() ?>>
<span id="el_hotel_facilities_hotel_id">
<span<?php echo $hotel_facilities->hotel_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_facilities->hotel_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_facilities" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" value="<?php echo ew_HtmlEncode($hotel_facilities->hotel_id->CurrentValue) ?>">
<?php echo $hotel_facilities->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_name->Visible) { // hf_name ?>
	<div id="r_hf_name" class="form-group">
		<label id="elh_hotel_facilities_hf_name" for="x_hf_name" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_name->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_name">
<input type="text" data-table="hotel_facilities" data-field="x_hf_name" name="x_hf_name" id="x_hf_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_name->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_name->EditValue ?>"<?php echo $hotel_facilities->hf_name->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_image->Visible) { // hf_image ?>
	<div id="r_hf_image" class="form-group">
		<label id="elh_hotel_facilities_hf_image" for="x_hf_image" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_image->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_image">
<input type="text" data-table="hotel_facilities" data-field="x_hf_image" name="x_hf_image" id="x_hf_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_image->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_image->EditValue ?>"<?php echo $hotel_facilities->hf_image->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hf_icons->Visible) { // hf_icons ?>
	<div id="r_hf_icons" class="form-group">
		<label id="elh_hotel_facilities_hf_icons" for="x_hf_icons" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hf_icons->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hf_icons->CellAttributes() ?>>
<span id="el_hotel_facilities_hf_icons">
<input type="text" data-table="hotel_facilities" data-field="x_hf_icons" name="x_hf_icons" id="x_hf_icons" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_facilities->hf_icons->getPlaceHolder()) ?>" value="<?php echo $hotel_facilities->hf_icons->EditValue ?>"<?php echo $hotel_facilities->hf_icons->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hf_icons->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_hotel_facilities_status" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->status->CellAttributes() ?>>
<span id="el_hotel_facilities_status">
<?php
$selwrk = (ew_ConvertToBool($hotel_facilities->status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_facilities" data-field="x_status" name="x_status[]" id="x_status[]" value="1"<?php echo $selwrk ?><?php echo $hotel_facilities->status->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_facilities->hot_facilities->Visible) { // hot_facilities ?>
	<div id="r_hot_facilities" class="form-group">
		<label id="elh_hotel_facilities_hot_facilities" class="col-sm-2 control-label ewLabel"><?php echo $hotel_facilities->hot_facilities->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_facilities->hot_facilities->CellAttributes() ?>>
<span id="el_hotel_facilities_hot_facilities">
<?php
$selwrk = (ew_ConvertToBool($hotel_facilities->hot_facilities->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_facilities" data-field="x_hot_facilities" name="x_hot_facilities[]" id="x_hot_facilities[]" value="1"<?php echo $selwrk ?><?php echo $hotel_facilities->hot_facilities->EditAttributes() ?>>
</span>
<?php echo $hotel_facilities->hot_facilities->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_facilities_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_facilities_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($hotel_facilities_edit->Pager)) $hotel_facilities_edit->Pager = new cPrevNextPager($hotel_facilities_edit->StartRec, $hotel_facilities_edit->DisplayRecs, $hotel_facilities_edit->TotalRecs) ?>
<?php if ($hotel_facilities_edit->Pager->RecordCount > 0 && $hotel_facilities_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_facilities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_facilities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_facilities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_facilities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_facilities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_facilities_edit->PageUrl() ?>start=<?php echo $hotel_facilities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_facilities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_facilitiesedit.Init();
</script>
<?php
$hotel_facilities_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_facilities_edit->Page_Terminate();
?>

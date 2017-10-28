<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_roomsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_rooms_edit = NULL; // Initialize page object first

class chotel_rooms_edit extends chotel_rooms {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_rooms';

	// Page object name
	var $PageObjName = 'hotel_rooms_edit';

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

		// Table object (hotel_rooms)
		if (!isset($GLOBALS["hotel_rooms"]) || get_class($GLOBALS["hotel_rooms"]) == "chotel_rooms") {
			$GLOBALS["hotel_rooms"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_rooms"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_rooms', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_roomslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hroom_id->SetVisibility();
		$this->hroom_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hotel_id->SetVisibility();
		$this->rt_id->SetVisibility();
		$this->hr_name->SetVisibility();
		$this->hr_image->SetVisibility();
		$this->hr_description->SetVisibility();
		$this->amenities->SetVisibility();
		$this->hr_max->SetVisibility();
		$this->hr_base_rate->SetVisibility();
		$this->hr_status->SetVisibility();

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
		global $EW_EXPORT, $hotel_rooms;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_rooms);
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
		if (@$_GET["hroom_id"] <> "") {
			$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
			$this->RecKey["hroom_id"] = $this->hroom_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}
		if (@$_GET["hotel_id"] <> "") {
			$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
			$this->RecKey["hotel_id"] = $this->hotel_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}
		if (@$_GET["rt_id"] <> "") {
			$this->rt_id->setQueryStringValue($_GET["rt_id"]);
			$this->RecKey["rt_id"] = $this->rt_id->QueryStringValue;
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
			$this->Page_Terminate("hotel_roomslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->hroom_id->CurrentValue) == strval($this->Recordset->fields('hroom_id')) && strval($this->hotel_id->CurrentValue) == strval($this->Recordset->fields('hotel_id')) && strval($this->rt_id->CurrentValue) == strval($this->Recordset->fields('rt_id'))) {
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
					$this->Page_Terminate("hotel_roomslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "hotel_roomslist.php")
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
		if (!$this->hroom_id->FldIsDetailKey)
			$this->hroom_id->setFormValue($objForm->GetValue("x_hroom_id"));
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->rt_id->FldIsDetailKey) {
			$this->rt_id->setFormValue($objForm->GetValue("x_rt_id"));
		}
		if (!$this->hr_name->FldIsDetailKey) {
			$this->hr_name->setFormValue($objForm->GetValue("x_hr_name"));
		}
		if (!$this->hr_image->FldIsDetailKey) {
			$this->hr_image->setFormValue($objForm->GetValue("x_hr_image"));
		}
		if (!$this->hr_description->FldIsDetailKey) {
			$this->hr_description->setFormValue($objForm->GetValue("x_hr_description"));
		}
		if (!$this->amenities->FldIsDetailKey) {
			$this->amenities->setFormValue($objForm->GetValue("x_amenities"));
		}
		if (!$this->hr_max->FldIsDetailKey) {
			$this->hr_max->setFormValue($objForm->GetValue("x_hr_max"));
		}
		if (!$this->hr_base_rate->FldIsDetailKey) {
			$this->hr_base_rate->setFormValue($objForm->GetValue("x_hr_base_rate"));
		}
		if (!$this->hr_status->FldIsDetailKey) {
			$this->hr_status->setFormValue($objForm->GetValue("x_hr_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->hroom_id->CurrentValue = $this->hroom_id->FormValue;
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->rt_id->CurrentValue = $this->rt_id->FormValue;
		$this->hr_name->CurrentValue = $this->hr_name->FormValue;
		$this->hr_image->CurrentValue = $this->hr_image->FormValue;
		$this->hr_description->CurrentValue = $this->hr_description->FormValue;
		$this->amenities->CurrentValue = $this->amenities->FormValue;
		$this->hr_max->CurrentValue = $this->hr_max->FormValue;
		$this->hr_base_rate->CurrentValue = $this->hr_base_rate->FormValue;
		$this->hr_status->CurrentValue = $this->hr_status->FormValue;
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
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->hr_name->setDbValue($rs->fields('hr_name'));
		$this->hr_image->setDbValue($rs->fields('hr_image'));
		$this->hr_description->setDbValue($rs->fields('hr_description'));
		$this->amenities->setDbValue($rs->fields('amenities'));
		$this->hr_max->setDbValue($rs->fields('hr_max'));
		$this->hr_base_rate->setDbValue($rs->fields('hr_base_rate'));
		$this->hr_status->setDbValue($rs->fields('hr_status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->rt_id->DbValue = $row['rt_id'];
		$this->hr_name->DbValue = $row['hr_name'];
		$this->hr_image->DbValue = $row['hr_image'];
		$this->hr_description->DbValue = $row['hr_description'];
		$this->amenities->DbValue = $row['amenities'];
		$this->hr_max->DbValue = $row['hr_max'];
		$this->hr_base_rate->DbValue = $row['hr_base_rate'];
		$this->hr_status->DbValue = $row['hr_status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->hr_base_rate->FormValue == $this->hr_base_rate->CurrentValue && is_numeric(ew_StrToFloat($this->hr_base_rate->CurrentValue)))
			$this->hr_base_rate->CurrentValue = ew_StrToFloat($this->hr_base_rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// hroom_id
		// hotel_id
		// rt_id
		// hr_name
		// hr_image
		// hr_description
		// amenities
		// hr_max
		// hr_base_rate
		// hr_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// hr_name
		$this->hr_name->ViewValue = $this->hr_name->CurrentValue;
		$this->hr_name->ViewCustomAttributes = "";

		// hr_image
		$this->hr_image->ViewValue = $this->hr_image->CurrentValue;
		$this->hr_image->ViewCustomAttributes = "";

		// hr_description
		$this->hr_description->ViewValue = $this->hr_description->CurrentValue;
		$this->hr_description->ViewCustomAttributes = "";

		// amenities
		$this->amenities->ViewValue = $this->amenities->CurrentValue;
		$this->amenities->ViewCustomAttributes = "";

		// hr_max
		$this->hr_max->ViewValue = $this->hr_max->CurrentValue;
		$this->hr_max->ViewCustomAttributes = "";

		// hr_base_rate
		$this->hr_base_rate->ViewValue = $this->hr_base_rate->CurrentValue;
		$this->hr_base_rate->ViewCustomAttributes = "";

		// hr_status
		if (ew_ConvertToBool($this->hr_status->CurrentValue)) {
			$this->hr_status->ViewValue = $this->hr_status->FldTagCaption(1) <> "" ? $this->hr_status->FldTagCaption(1) : "Y";
		} else {
			$this->hr_status->ViewValue = $this->hr_status->FldTagCaption(2) <> "" ? $this->hr_status->FldTagCaption(2) : "N";
		}
		$this->hr_status->ViewCustomAttributes = "";

			// hroom_id
			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";
			$this->hroom_id->TooltipValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// rt_id
			$this->rt_id->LinkCustomAttributes = "";
			$this->rt_id->HrefValue = "";
			$this->rt_id->TooltipValue = "";

			// hr_name
			$this->hr_name->LinkCustomAttributes = "";
			$this->hr_name->HrefValue = "";
			$this->hr_name->TooltipValue = "";

			// hr_image
			$this->hr_image->LinkCustomAttributes = "";
			$this->hr_image->HrefValue = "";
			$this->hr_image->TooltipValue = "";

			// hr_description
			$this->hr_description->LinkCustomAttributes = "";
			$this->hr_description->HrefValue = "";
			$this->hr_description->TooltipValue = "";

			// amenities
			$this->amenities->LinkCustomAttributes = "";
			$this->amenities->HrefValue = "";
			$this->amenities->TooltipValue = "";

			// hr_max
			$this->hr_max->LinkCustomAttributes = "";
			$this->hr_max->HrefValue = "";
			$this->hr_max->TooltipValue = "";

			// hr_base_rate
			$this->hr_base_rate->LinkCustomAttributes = "";
			$this->hr_base_rate->HrefValue = "";
			$this->hr_base_rate->TooltipValue = "";

			// hr_status
			$this->hr_status->LinkCustomAttributes = "";
			$this->hr_status->HrefValue = "";
			$this->hr_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
			$this->hroom_id->ViewCustomAttributes = "";

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = $this->hotel_id->CurrentValue;
			$this->hotel_id->ViewCustomAttributes = "";

			// rt_id
			$this->rt_id->EditAttrs["class"] = "form-control";
			$this->rt_id->EditCustomAttributes = "";
			$this->rt_id->EditValue = $this->rt_id->CurrentValue;
			$this->rt_id->ViewCustomAttributes = "";

			// hr_name
			$this->hr_name->EditAttrs["class"] = "form-control";
			$this->hr_name->EditCustomAttributes = "";
			$this->hr_name->EditValue = ew_HtmlEncode($this->hr_name->CurrentValue);
			$this->hr_name->PlaceHolder = ew_RemoveHtml($this->hr_name->FldCaption());

			// hr_image
			$this->hr_image->EditAttrs["class"] = "form-control";
			$this->hr_image->EditCustomAttributes = "";
			$this->hr_image->EditValue = ew_HtmlEncode($this->hr_image->CurrentValue);
			$this->hr_image->PlaceHolder = ew_RemoveHtml($this->hr_image->FldCaption());

			// hr_description
			$this->hr_description->EditAttrs["class"] = "form-control";
			$this->hr_description->EditCustomAttributes = "";
			$this->hr_description->EditValue = ew_HtmlEncode($this->hr_description->CurrentValue);
			$this->hr_description->PlaceHolder = ew_RemoveHtml($this->hr_description->FldCaption());

			// amenities
			$this->amenities->EditAttrs["class"] = "form-control";
			$this->amenities->EditCustomAttributes = "";
			$this->amenities->EditValue = ew_HtmlEncode($this->amenities->CurrentValue);
			$this->amenities->PlaceHolder = ew_RemoveHtml($this->amenities->FldCaption());

			// hr_max
			$this->hr_max->EditAttrs["class"] = "form-control";
			$this->hr_max->EditCustomAttributes = "";
			$this->hr_max->EditValue = ew_HtmlEncode($this->hr_max->CurrentValue);
			$this->hr_max->PlaceHolder = ew_RemoveHtml($this->hr_max->FldCaption());

			// hr_base_rate
			$this->hr_base_rate->EditAttrs["class"] = "form-control";
			$this->hr_base_rate->EditCustomAttributes = "";
			$this->hr_base_rate->EditValue = ew_HtmlEncode($this->hr_base_rate->CurrentValue);
			$this->hr_base_rate->PlaceHolder = ew_RemoveHtml($this->hr_base_rate->FldCaption());
			if (strval($this->hr_base_rate->EditValue) <> "" && is_numeric($this->hr_base_rate->EditValue)) $this->hr_base_rate->EditValue = ew_FormatNumber($this->hr_base_rate->EditValue, -2, -1, -2, 0);

			// hr_status
			$this->hr_status->EditCustomAttributes = "";
			$this->hr_status->EditValue = $this->hr_status->Options(FALSE);

			// Edit refer script
			// hroom_id

			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// rt_id
			$this->rt_id->LinkCustomAttributes = "";
			$this->rt_id->HrefValue = "";

			// hr_name
			$this->hr_name->LinkCustomAttributes = "";
			$this->hr_name->HrefValue = "";

			// hr_image
			$this->hr_image->LinkCustomAttributes = "";
			$this->hr_image->HrefValue = "";

			// hr_description
			$this->hr_description->LinkCustomAttributes = "";
			$this->hr_description->HrefValue = "";

			// amenities
			$this->amenities->LinkCustomAttributes = "";
			$this->amenities->HrefValue = "";

			// hr_max
			$this->hr_max->LinkCustomAttributes = "";
			$this->hr_max->HrefValue = "";

			// hr_base_rate
			$this->hr_base_rate->LinkCustomAttributes = "";
			$this->hr_base_rate->HrefValue = "";

			// hr_status
			$this->hr_status->LinkCustomAttributes = "";
			$this->hr_status->HrefValue = "";
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
		if (!$this->rt_id->FldIsDetailKey && !is_null($this->rt_id->FormValue) && $this->rt_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->rt_id->FldCaption(), $this->rt_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->rt_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->rt_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->hr_max->FormValue)) {
			ew_AddMessage($gsFormError, $this->hr_max->FldErrMsg());
		}
		if (!ew_CheckNumber($this->hr_base_rate->FormValue)) {
			ew_AddMessage($gsFormError, $this->hr_base_rate->FldErrMsg());
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
			// rt_id
			// hr_name

			$this->hr_name->SetDbValueDef($rsnew, $this->hr_name->CurrentValue, NULL, $this->hr_name->ReadOnly);

			// hr_image
			$this->hr_image->SetDbValueDef($rsnew, $this->hr_image->CurrentValue, NULL, $this->hr_image->ReadOnly);

			// hr_description
			$this->hr_description->SetDbValueDef($rsnew, $this->hr_description->CurrentValue, NULL, $this->hr_description->ReadOnly);

			// amenities
			$this->amenities->SetDbValueDef($rsnew, $this->amenities->CurrentValue, NULL, $this->amenities->ReadOnly);

			// hr_max
			$this->hr_max->SetDbValueDef($rsnew, $this->hr_max->CurrentValue, NULL, $this->hr_max->ReadOnly);

			// hr_base_rate
			$this->hr_base_rate->SetDbValueDef($rsnew, $this->hr_base_rate->CurrentValue, NULL, $this->hr_base_rate->ReadOnly);

			// hr_status
			$tmpBool = $this->hr_status->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->hr_status->SetDbValueDef($rsnew, $tmpBool, NULL, $this->hr_status->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_roomslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_rooms_edit)) $hotel_rooms_edit = new chotel_rooms_edit();

// Page init
$hotel_rooms_edit->Page_Init();

// Page main
$hotel_rooms_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_rooms_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhotel_roomsedit = new ew_Form("fhotel_roomsedit", "edit");

// Validate form
fhotel_roomsedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_rooms->hotel_id->FldCaption(), $hotel_rooms->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_rooms->hotel_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rt_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_rooms->rt_id->FldCaption(), $hotel_rooms->rt_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_rt_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_rooms->rt_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_hr_max");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_rooms->hr_max->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_hr_base_rate");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_rooms->hr_base_rate->FldErrMsg()) ?>");

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
fhotel_roomsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_roomsedit.ValidateRequired = true;
<?php } else { ?>
fhotel_roomsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotel_roomsedit.Lists["x_hr_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_roomsedit.Lists["x_hr_status[]"].Options = <?php echo json_encode($hotel_rooms->hr_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_rooms_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_rooms_edit->ShowPageHeader(); ?>
<?php
$hotel_rooms_edit->ShowMessage();
?>
<?php if (!$hotel_rooms_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_rooms_edit->Pager)) $hotel_rooms_edit->Pager = new cPrevNextPager($hotel_rooms_edit->StartRec, $hotel_rooms_edit->DisplayRecs, $hotel_rooms_edit->TotalRecs) ?>
<?php if ($hotel_rooms_edit->Pager->RecordCount > 0 && $hotel_rooms_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_rooms_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_rooms_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_rooms_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_rooms_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_rooms_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_rooms_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fhotel_roomsedit" id="fhotel_roomsedit" class="<?php echo $hotel_rooms_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_rooms_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_rooms_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_rooms">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($hotel_rooms_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_rooms->hroom_id->Visible) { // hroom_id ?>
	<div id="r_hroom_id" class="form-group">
		<label id="elh_hotel_rooms_hroom_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hroom_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hroom_id->CellAttributes() ?>>
<span id="el_hotel_rooms_hroom_id">
<span<?php echo $hotel_rooms->hroom_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_rooms->hroom_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_rooms" data-field="x_hroom_id" name="x_hroom_id" id="x_hroom_id" value="<?php echo ew_HtmlEncode($hotel_rooms->hroom_id->CurrentValue) ?>">
<?php echo $hotel_rooms->hroom_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_hotel_rooms_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hotel_id->CellAttributes() ?>>
<span id="el_hotel_rooms_hotel_id">
<span<?php echo $hotel_rooms->hotel_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_rooms->hotel_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_rooms" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" value="<?php echo ew_HtmlEncode($hotel_rooms->hotel_id->CurrentValue) ?>">
<?php echo $hotel_rooms->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->rt_id->Visible) { // rt_id ?>
	<div id="r_rt_id" class="form-group">
		<label id="elh_hotel_rooms_rt_id" for="x_rt_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->rt_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->rt_id->CellAttributes() ?>>
<span id="el_hotel_rooms_rt_id">
<span<?php echo $hotel_rooms->rt_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_rooms->rt_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_rooms" data-field="x_rt_id" name="x_rt_id" id="x_rt_id" value="<?php echo ew_HtmlEncode($hotel_rooms->rt_id->CurrentValue) ?>">
<?php echo $hotel_rooms->rt_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_name->Visible) { // hr_name ?>
	<div id="r_hr_name" class="form-group">
		<label id="elh_hotel_rooms_hr_name" for="x_hr_name" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_name->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_name">
<input type="text" data-table="hotel_rooms" data-field="x_hr_name" name="x_hr_name" id="x_hr_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->hr_name->getPlaceHolder()) ?>" value="<?php echo $hotel_rooms->hr_name->EditValue ?>"<?php echo $hotel_rooms->hr_name->EditAttributes() ?>>
</span>
<?php echo $hotel_rooms->hr_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_image->Visible) { // hr_image ?>
	<div id="r_hr_image" class="form-group">
		<label id="elh_hotel_rooms_hr_image" for="x_hr_image" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_image->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_image">
<input type="text" data-table="hotel_rooms" data-field="x_hr_image" name="x_hr_image" id="x_hr_image" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->hr_image->getPlaceHolder()) ?>" value="<?php echo $hotel_rooms->hr_image->EditValue ?>"<?php echo $hotel_rooms->hr_image->EditAttributes() ?>>
</span>
<?php echo $hotel_rooms->hr_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_description->Visible) { // hr_description ?>
	<div id="r_hr_description" class="form-group">
		<label id="elh_hotel_rooms_hr_description" for="x_hr_description" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_description->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_description">
<textarea data-table="hotel_rooms" data-field="x_hr_description" name="x_hr_description" id="x_hr_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->hr_description->getPlaceHolder()) ?>"<?php echo $hotel_rooms->hr_description->EditAttributes() ?>><?php echo $hotel_rooms->hr_description->EditValue ?></textarea>
</span>
<?php echo $hotel_rooms->hr_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->amenities->Visible) { // amenities ?>
	<div id="r_amenities" class="form-group">
		<label id="elh_hotel_rooms_amenities" for="x_amenities" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->amenities->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->amenities->CellAttributes() ?>>
<span id="el_hotel_rooms_amenities">
<textarea data-table="hotel_rooms" data-field="x_amenities" name="x_amenities" id="x_amenities" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->amenities->getPlaceHolder()) ?>"<?php echo $hotel_rooms->amenities->EditAttributes() ?>><?php echo $hotel_rooms->amenities->EditValue ?></textarea>
</span>
<?php echo $hotel_rooms->amenities->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_max->Visible) { // hr_max ?>
	<div id="r_hr_max" class="form-group">
		<label id="elh_hotel_rooms_hr_max" for="x_hr_max" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_max->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_max->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_max">
<input type="text" data-table="hotel_rooms" data-field="x_hr_max" name="x_hr_max" id="x_hr_max" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->hr_max->getPlaceHolder()) ?>" value="<?php echo $hotel_rooms->hr_max->EditValue ?>"<?php echo $hotel_rooms->hr_max->EditAttributes() ?>>
</span>
<?php echo $hotel_rooms->hr_max->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_base_rate->Visible) { // hr_base_rate ?>
	<div id="r_hr_base_rate" class="form-group">
		<label id="elh_hotel_rooms_hr_base_rate" for="x_hr_base_rate" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_base_rate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_base_rate->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_base_rate">
<input type="text" data-table="hotel_rooms" data-field="x_hr_base_rate" name="x_hr_base_rate" id="x_hr_base_rate" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_rooms->hr_base_rate->getPlaceHolder()) ?>" value="<?php echo $hotel_rooms->hr_base_rate->EditValue ?>"<?php echo $hotel_rooms->hr_base_rate->EditAttributes() ?>>
</span>
<?php echo $hotel_rooms->hr_base_rate->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_rooms->hr_status->Visible) { // hr_status ?>
	<div id="r_hr_status" class="form-group">
		<label id="elh_hotel_rooms_hr_status" class="col-sm-2 control-label ewLabel"><?php echo $hotel_rooms->hr_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_rooms->hr_status->CellAttributes() ?>>
<span id="el_hotel_rooms_hr_status">
<?php
$selwrk = (ew_ConvertToBool($hotel_rooms->hr_status->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_rooms" data-field="x_hr_status" name="x_hr_status[]" id="x_hr_status[]" value="1"<?php echo $selwrk ?><?php echo $hotel_rooms->hr_status->EditAttributes() ?>>
</span>
<?php echo $hotel_rooms->hr_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_rooms_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_rooms_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($hotel_rooms_edit->Pager)) $hotel_rooms_edit->Pager = new cPrevNextPager($hotel_rooms_edit->StartRec, $hotel_rooms_edit->DisplayRecs, $hotel_rooms_edit->TotalRecs) ?>
<?php if ($hotel_rooms_edit->Pager->RecordCount > 0 && $hotel_rooms_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_rooms_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_rooms_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_rooms_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_rooms_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_rooms_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_rooms_edit->PageUrl() ?>start=<?php echo $hotel_rooms_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_rooms_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_roomsedit.Init();
</script>
<?php
$hotel_rooms_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_rooms_edit->Page_Terminate();
?>

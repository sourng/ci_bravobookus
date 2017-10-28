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

$hotel_room_gallery_edit = NULL; // Initialize page object first

class chotel_room_gallery_edit extends chotel_room_gallery {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_room_gallery';

	// Page object name
	var $PageObjName = 'hotel_room_gallery_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotel_room_gallerylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
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
		if (@$_GET["hrgallery_id"] <> "") {
			$this->hrgallery_id->setQueryStringValue($_GET["hrgallery_id"]);
			$this->RecKey["hrgallery_id"] = $this->hrgallery_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}
		if (@$_GET["hroom_id"] <> "") {
			$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
			$this->RecKey["hroom_id"] = $this->hroom_id->QueryStringValue;
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
			$this->Page_Terminate("hotel_room_gallerylist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->hrgallery_id->CurrentValue) == strval($this->Recordset->fields('hrgallery_id')) && strval($this->hroom_id->CurrentValue) == strval($this->Recordset->fields('hroom_id'))) {
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
					$this->Page_Terminate("hotel_room_gallerylist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "hotel_room_gallerylist.php")
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
		if (!$this->hrgallery_id->FldIsDetailKey)
			$this->hrgallery_id->setFormValue($objForm->GetValue("x_hrgallery_id"));
		if (!$this->hroom_id->FldIsDetailKey) {
			$this->hroom_id->setFormValue($objForm->GetValue("x_hroom_id"));
		}
		if (!$this->hrg_image1->FldIsDetailKey) {
			$this->hrg_image1->setFormValue($objForm->GetValue("x_hrg_image1"));
		}
		if (!$this->hrg_image2->FldIsDetailKey) {
			$this->hrg_image2->setFormValue($objForm->GetValue("x_hrg_image2"));
		}
		if (!$this->hrg_image3->FldIsDetailKey) {
			$this->hrg_image3->setFormValue($objForm->GetValue("x_hrg_image3"));
		}
		if (!$this->hrg_image4->FldIsDetailKey) {
			$this->hrg_image4->setFormValue($objForm->GetValue("x_hrg_image4"));
		}
		if (!$this->hrg_image5->FldIsDetailKey) {
			$this->hrg_image5->setFormValue($objForm->GetValue("x_hrg_image5"));
		}
		if (!$this->hrg_image6->FldIsDetailKey) {
			$this->hrg_image6->setFormValue($objForm->GetValue("x_hrg_image6"));
		}
		if (!$this->hrg_image7->FldIsDetailKey) {
			$this->hrg_image7->setFormValue($objForm->GetValue("x_hrg_image7"));
		}
		if (!$this->hrg_image8->FldIsDetailKey) {
			$this->hrg_image8->setFormValue($objForm->GetValue("x_hrg_image8"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->hrgallery_id->CurrentValue = $this->hrgallery_id->FormValue;
		$this->hroom_id->CurrentValue = $this->hroom_id->FormValue;
		$this->hrg_image1->CurrentValue = $this->hrg_image1->FormValue;
		$this->hrg_image2->CurrentValue = $this->hrg_image2->FormValue;
		$this->hrg_image3->CurrentValue = $this->hrg_image3->FormValue;
		$this->hrg_image4->CurrentValue = $this->hrg_image4->FormValue;
		$this->hrg_image5->CurrentValue = $this->hrg_image5->FormValue;
		$this->hrg_image6->CurrentValue = $this->hrg_image6->FormValue;
		$this->hrg_image7->CurrentValue = $this->hrg_image7->FormValue;
		$this->hrg_image8->CurrentValue = $this->hrg_image8->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// hrgallery_id
			$this->hrgallery_id->EditAttrs["class"] = "form-control";
			$this->hrgallery_id->EditCustomAttributes = "";
			$this->hrgallery_id->EditValue = $this->hrgallery_id->CurrentValue;
			$this->hrgallery_id->ViewCustomAttributes = "";

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = $this->hroom_id->CurrentValue;
			$this->hroom_id->ViewCustomAttributes = "";

			// hrg_image1
			$this->hrg_image1->EditAttrs["class"] = "form-control";
			$this->hrg_image1->EditCustomAttributes = "";
			$this->hrg_image1->EditValue = ew_HtmlEncode($this->hrg_image1->CurrentValue);
			$this->hrg_image1->PlaceHolder = ew_RemoveHtml($this->hrg_image1->FldCaption());

			// hrg_image2
			$this->hrg_image2->EditAttrs["class"] = "form-control";
			$this->hrg_image2->EditCustomAttributes = "";
			$this->hrg_image2->EditValue = ew_HtmlEncode($this->hrg_image2->CurrentValue);
			$this->hrg_image2->PlaceHolder = ew_RemoveHtml($this->hrg_image2->FldCaption());

			// hrg_image3
			$this->hrg_image3->EditAttrs["class"] = "form-control";
			$this->hrg_image3->EditCustomAttributes = "";
			$this->hrg_image3->EditValue = ew_HtmlEncode($this->hrg_image3->CurrentValue);
			$this->hrg_image3->PlaceHolder = ew_RemoveHtml($this->hrg_image3->FldCaption());

			// hrg_image4
			$this->hrg_image4->EditAttrs["class"] = "form-control";
			$this->hrg_image4->EditCustomAttributes = "";
			$this->hrg_image4->EditValue = ew_HtmlEncode($this->hrg_image4->CurrentValue);
			$this->hrg_image4->PlaceHolder = ew_RemoveHtml($this->hrg_image4->FldCaption());

			// hrg_image5
			$this->hrg_image5->EditAttrs["class"] = "form-control";
			$this->hrg_image5->EditCustomAttributes = "";
			$this->hrg_image5->EditValue = ew_HtmlEncode($this->hrg_image5->CurrentValue);
			$this->hrg_image5->PlaceHolder = ew_RemoveHtml($this->hrg_image5->FldCaption());

			// hrg_image6
			$this->hrg_image6->EditAttrs["class"] = "form-control";
			$this->hrg_image6->EditCustomAttributes = "";
			$this->hrg_image6->EditValue = ew_HtmlEncode($this->hrg_image6->CurrentValue);
			$this->hrg_image6->PlaceHolder = ew_RemoveHtml($this->hrg_image6->FldCaption());

			// hrg_image7
			$this->hrg_image7->EditAttrs["class"] = "form-control";
			$this->hrg_image7->EditCustomAttributes = "";
			$this->hrg_image7->EditValue = ew_HtmlEncode($this->hrg_image7->CurrentValue);
			$this->hrg_image7->PlaceHolder = ew_RemoveHtml($this->hrg_image7->FldCaption());

			// hrg_image8
			$this->hrg_image8->EditAttrs["class"] = "form-control";
			$this->hrg_image8->EditCustomAttributes = "";
			$this->hrg_image8->EditValue = ew_HtmlEncode($this->hrg_image8->CurrentValue);
			$this->hrg_image8->PlaceHolder = ew_RemoveHtml($this->hrg_image8->FldCaption());

			// Edit refer script
			// hrgallery_id

			$this->hrgallery_id->LinkCustomAttributes = "";
			$this->hrgallery_id->HrefValue = "";

			// hroom_id
			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";

			// hrg_image1
			$this->hrg_image1->LinkCustomAttributes = "";
			$this->hrg_image1->HrefValue = "";

			// hrg_image2
			$this->hrg_image2->LinkCustomAttributes = "";
			$this->hrg_image2->HrefValue = "";

			// hrg_image3
			$this->hrg_image3->LinkCustomAttributes = "";
			$this->hrg_image3->HrefValue = "";

			// hrg_image4
			$this->hrg_image4->LinkCustomAttributes = "";
			$this->hrg_image4->HrefValue = "";

			// hrg_image5
			$this->hrg_image5->LinkCustomAttributes = "";
			$this->hrg_image5->HrefValue = "";

			// hrg_image6
			$this->hrg_image6->LinkCustomAttributes = "";
			$this->hrg_image6->HrefValue = "";

			// hrg_image7
			$this->hrg_image7->LinkCustomAttributes = "";
			$this->hrg_image7->HrefValue = "";

			// hrg_image8
			$this->hrg_image8->LinkCustomAttributes = "";
			$this->hrg_image8->HrefValue = "";
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
		if (!$this->hroom_id->FldIsDetailKey && !is_null($this->hroom_id->FormValue) && $this->hroom_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->hroom_id->FldCaption(), $this->hroom_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->hroom_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->hroom_id->FldErrMsg());
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

			// hroom_id
			// hrg_image1

			$this->hrg_image1->SetDbValueDef($rsnew, $this->hrg_image1->CurrentValue, NULL, $this->hrg_image1->ReadOnly);

			// hrg_image2
			$this->hrg_image2->SetDbValueDef($rsnew, $this->hrg_image2->CurrentValue, NULL, $this->hrg_image2->ReadOnly);

			// hrg_image3
			$this->hrg_image3->SetDbValueDef($rsnew, $this->hrg_image3->CurrentValue, NULL, $this->hrg_image3->ReadOnly);

			// hrg_image4
			$this->hrg_image4->SetDbValueDef($rsnew, $this->hrg_image4->CurrentValue, NULL, $this->hrg_image4->ReadOnly);

			// hrg_image5
			$this->hrg_image5->SetDbValueDef($rsnew, $this->hrg_image5->CurrentValue, NULL, $this->hrg_image5->ReadOnly);

			// hrg_image6
			$this->hrg_image6->SetDbValueDef($rsnew, $this->hrg_image6->CurrentValue, NULL, $this->hrg_image6->ReadOnly);

			// hrg_image7
			$this->hrg_image7->SetDbValueDef($rsnew, $this->hrg_image7->CurrentValue, NULL, $this->hrg_image7->ReadOnly);

			// hrg_image8
			$this->hrg_image8->SetDbValueDef($rsnew, $this->hrg_image8->CurrentValue, NULL, $this->hrg_image8->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_room_gallerylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_room_gallery_edit)) $hotel_room_gallery_edit = new chotel_room_gallery_edit();

// Page init
$hotel_room_gallery_edit->Page_Init();

// Page main
$hotel_room_gallery_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_room_gallery_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fhotel_room_galleryedit = new ew_Form("fhotel_room_galleryedit", "edit");

// Validate form
fhotel_room_galleryedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_hroom_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_room_gallery->hroom_id->FldCaption(), $hotel_room_gallery->hroom_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hroom_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_room_gallery->hroom_id->FldErrMsg()) ?>");

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
fhotel_room_galleryedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_room_galleryedit.ValidateRequired = true;
<?php } else { ?>
fhotel_room_galleryedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_room_gallery_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_room_gallery_edit->ShowPageHeader(); ?>
<?php
$hotel_room_gallery_edit->ShowMessage();
?>
<?php if (!$hotel_room_gallery_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_room_gallery_edit->Pager)) $hotel_room_gallery_edit->Pager = new cPrevNextPager($hotel_room_gallery_edit->StartRec, $hotel_room_gallery_edit->DisplayRecs, $hotel_room_gallery_edit->TotalRecs) ?>
<?php if ($hotel_room_gallery_edit->Pager->RecordCount > 0 && $hotel_room_gallery_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_room_gallery_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_room_gallery_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_room_gallery_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_room_gallery_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_room_gallery_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_room_gallery_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="fhotel_room_galleryedit" id="fhotel_room_galleryedit" class="<?php echo $hotel_room_gallery_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_room_gallery_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_room_gallery_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_room_gallery">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($hotel_room_gallery_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_room_gallery->hrgallery_id->Visible) { // hrgallery_id ?>
	<div id="r_hrgallery_id" class="form-group">
		<label id="elh_hotel_room_gallery_hrgallery_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrgallery_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrgallery_id->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrgallery_id">
<span<?php echo $hotel_room_gallery->hrgallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_room_gallery->hrgallery_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_room_gallery" data-field="x_hrgallery_id" name="x_hrgallery_id" id="x_hrgallery_id" value="<?php echo ew_HtmlEncode($hotel_room_gallery->hrgallery_id->CurrentValue) ?>">
<?php echo $hotel_room_gallery->hrgallery_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hroom_id->Visible) { // hroom_id ?>
	<div id="r_hroom_id" class="form-group">
		<label id="elh_hotel_room_gallery_hroom_id" for="x_hroom_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hroom_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hroom_id->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hroom_id">
<span<?php echo $hotel_room_gallery->hroom_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $hotel_room_gallery->hroom_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="hotel_room_gallery" data-field="x_hroom_id" name="x_hroom_id" id="x_hroom_id" value="<?php echo ew_HtmlEncode($hotel_room_gallery->hroom_id->CurrentValue) ?>">
<?php echo $hotel_room_gallery->hroom_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image1->Visible) { // hrg_image1 ?>
	<div id="r_hrg_image1" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image1" for="x_hrg_image1" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image1->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image1">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image1" name="x_hrg_image1" id="x_hrg_image1" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image1->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image1->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image1->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image2->Visible) { // hrg_image2 ?>
	<div id="r_hrg_image2" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image2" for="x_hrg_image2" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image2->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image2">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image2" name="x_hrg_image2" id="x_hrg_image2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image2->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image2->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image2->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image3->Visible) { // hrg_image3 ?>
	<div id="r_hrg_image3" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image3" for="x_hrg_image3" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image3->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image3">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image3" name="x_hrg_image3" id="x_hrg_image3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image3->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image3->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image3->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image4->Visible) { // hrg_image4 ?>
	<div id="r_hrg_image4" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image4" for="x_hrg_image4" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image4->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image4">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image4" name="x_hrg_image4" id="x_hrg_image4" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image4->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image4->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image4->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image5->Visible) { // hrg_image5 ?>
	<div id="r_hrg_image5" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image5" for="x_hrg_image5" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image5->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image5">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image5" name="x_hrg_image5" id="x_hrg_image5" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image5->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image5->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image5->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image6->Visible) { // hrg_image6 ?>
	<div id="r_hrg_image6" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image6" for="x_hrg_image6" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image6->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image6->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image6">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image6" name="x_hrg_image6" id="x_hrg_image6" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image6->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image6->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image6->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image7->Visible) { // hrg_image7 ?>
	<div id="r_hrg_image7" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image7" for="x_hrg_image7" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image7->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image7->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image7">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image7" name="x_hrg_image7" id="x_hrg_image7" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image7->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image7->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image7->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_room_gallery->hrg_image8->Visible) { // hrg_image8 ?>
	<div id="r_hrg_image8" class="form-group">
		<label id="elh_hotel_room_gallery_hrg_image8" for="x_hrg_image8" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hrg_image8->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hrg_image8->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hrg_image8">
<input type="text" data-table="hotel_room_gallery" data-field="x_hrg_image8" name="x_hrg_image8" id="x_hrg_image8" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hrg_image8->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hrg_image8->EditValue ?>"<?php echo $hotel_room_gallery->hrg_image8->EditAttributes() ?>>
</span>
<?php echo $hotel_room_gallery->hrg_image8->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_room_gallery_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_room_gallery_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($hotel_room_gallery_edit->Pager)) $hotel_room_gallery_edit->Pager = new cPrevNextPager($hotel_room_gallery_edit->StartRec, $hotel_room_gallery_edit->DisplayRecs, $hotel_room_gallery_edit->TotalRecs) ?>
<?php if ($hotel_room_gallery_edit->Pager->RecordCount > 0 && $hotel_room_gallery_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_room_gallery_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_room_gallery_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_room_gallery_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_room_gallery_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_room_gallery_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_room_gallery_edit->PageUrl() ?>start=<?php echo $hotel_room_gallery_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_room_gallery_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_room_galleryedit.Init();
</script>
<?php
$hotel_room_gallery_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_room_gallery_edit->Page_Terminate();
?>

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

$hotel_room_gallery_add = NULL; // Initialize page object first

class chotel_room_gallery_add extends chotel_room_gallery {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_room_gallery';

	// Page object name
	var $PageObjName = 'hotel_room_gallery_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
			if (@$_GET["hrgallery_id"] != "") {
				$this->hrgallery_id->setQueryStringValue($_GET["hrgallery_id"]);
				$this->setKey("hrgallery_id", $this->hrgallery_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hrgallery_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if (@$_GET["hroom_id"] != "") {
				$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
				$this->setKey("hroom_id", $this->hroom_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hroom_id", ""); // Clear key
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
					$this->Page_Terminate("hotel_room_gallerylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "hotel_room_gallerylist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "hotel_room_galleryview.php")
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
		$this->hroom_id->CurrentValue = NULL;
		$this->hroom_id->OldValue = $this->hroom_id->CurrentValue;
		$this->hrg_image1->CurrentValue = NULL;
		$this->hrg_image1->OldValue = $this->hrg_image1->CurrentValue;
		$this->hrg_image2->CurrentValue = NULL;
		$this->hrg_image2->OldValue = $this->hrg_image2->CurrentValue;
		$this->hrg_image3->CurrentValue = NULL;
		$this->hrg_image3->OldValue = $this->hrg_image3->CurrentValue;
		$this->hrg_image4->CurrentValue = NULL;
		$this->hrg_image4->OldValue = $this->hrg_image4->CurrentValue;
		$this->hrg_image5->CurrentValue = NULL;
		$this->hrg_image5->OldValue = $this->hrg_image5->CurrentValue;
		$this->hrg_image6->CurrentValue = NULL;
		$this->hrg_image6->OldValue = $this->hrg_image6->CurrentValue;
		$this->hrg_image7->CurrentValue = NULL;
		$this->hrg_image7->OldValue = $this->hrg_image7->CurrentValue;
		$this->hrg_image8->CurrentValue = NULL;
		$this->hrg_image8->OldValue = $this->hrg_image8->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
		$this->LoadOldRecord();
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("hrgallery_id")) <> "")
			$this->hrgallery_id->CurrentValue = $this->getKey("hrgallery_id"); // hrgallery_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hroom_id")) <> "")
			$this->hroom_id->CurrentValue = $this->getKey("hroom_id"); // hroom_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = ew_HtmlEncode($this->hroom_id->CurrentValue);
			$this->hroom_id->PlaceHolder = ew_RemoveHtml($this->hroom_id->FldCaption());

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

			// Add refer script
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// hroom_id
		$this->hroom_id->SetDbValueDef($rsnew, $this->hroom_id->CurrentValue, 0, FALSE);

		// hrg_image1
		$this->hrg_image1->SetDbValueDef($rsnew, $this->hrg_image1->CurrentValue, NULL, FALSE);

		// hrg_image2
		$this->hrg_image2->SetDbValueDef($rsnew, $this->hrg_image2->CurrentValue, NULL, FALSE);

		// hrg_image3
		$this->hrg_image3->SetDbValueDef($rsnew, $this->hrg_image3->CurrentValue, NULL, FALSE);

		// hrg_image4
		$this->hrg_image4->SetDbValueDef($rsnew, $this->hrg_image4->CurrentValue, NULL, FALSE);

		// hrg_image5
		$this->hrg_image5->SetDbValueDef($rsnew, $this->hrg_image5->CurrentValue, NULL, FALSE);

		// hrg_image6
		$this->hrg_image6->SetDbValueDef($rsnew, $this->hrg_image6->CurrentValue, NULL, FALSE);

		// hrg_image7
		$this->hrg_image7->SetDbValueDef($rsnew, $this->hrg_image7->CurrentValue, NULL, FALSE);

		// hrg_image8
		$this->hrg_image8->SetDbValueDef($rsnew, $this->hrg_image8->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hroom_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_room_gallerylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_room_gallery_add)) $hotel_room_gallery_add = new chotel_room_gallery_add();

// Page init
$hotel_room_gallery_add->Page_Init();

// Page main
$hotel_room_gallery_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_room_gallery_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhotel_room_galleryadd = new ew_Form("fhotel_room_galleryadd", "add");

// Validate form
fhotel_room_galleryadd.Validate = function() {
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
fhotel_room_galleryadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_room_galleryadd.ValidateRequired = true;
<?php } else { ?>
fhotel_room_galleryadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_room_gallery_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_room_gallery_add->ShowPageHeader(); ?>
<?php
$hotel_room_gallery_add->ShowMessage();
?>
<form name="fhotel_room_galleryadd" id="fhotel_room_galleryadd" class="<?php echo $hotel_room_gallery_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_room_gallery_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_room_gallery_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_room_gallery">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($hotel_room_gallery_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_room_gallery->hroom_id->Visible) { // hroom_id ?>
	<div id="r_hroom_id" class="form-group">
		<label id="elh_hotel_room_gallery_hroom_id" for="x_hroom_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_room_gallery->hroom_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_room_gallery->hroom_id->CellAttributes() ?>>
<span id="el_hotel_room_gallery_hroom_id">
<input type="text" data-table="hotel_room_gallery" data-field="x_hroom_id" name="x_hroom_id" id="x_hroom_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_room_gallery->hroom_id->getPlaceHolder()) ?>" value="<?php echo $hotel_room_gallery->hroom_id->EditValue ?>"<?php echo $hotel_room_gallery->hroom_id->EditAttributes() ?>>
</span>
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
<?php if (!$hotel_room_gallery_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_room_gallery_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_room_galleryadd.Init();
</script>
<?php
$hotel_room_gallery_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_room_gallery_add->Page_Terminate();
?>

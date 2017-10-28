<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_galleryinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_gallery_add = NULL; // Initialize page object first

class chotel_gallery_add extends chotel_gallery {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_gallery';

	// Page object name
	var $PageObjName = 'hotel_gallery_add';

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

		// Table object (hotel_gallery)
		if (!isset($GLOBALS["hotel_gallery"]) || get_class($GLOBALS["hotel_gallery"]) == "chotel_gallery") {
			$GLOBALS["hotel_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_gallery"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_gallery', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_gallerylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hotel_id->SetVisibility();
		$this->hg_img1->SetVisibility();
		$this->hg_img2->SetVisibility();
		$this->hg_img3->SetVisibility();
		$this->hg_img4->SetVisibility();
		$this->hg_img5->SetVisibility();
		$this->hg_img6->SetVisibility();
		$this->hg_img7->SetVisibility();
		$this->hg_img8->SetVisibility();
		$this->hg_img9->SetVisibility();
		$this->hg_img10->SetVisibility();
		$this->hg_img11->SetVisibility();
		$this->hg_img12->SetVisibility();
		$this->hg_img13->SetVisibility();
		$this->hg_img14->SetVisibility();
		$this->hg_img15->SetVisibility();
		$this->hg_img16->SetVisibility();
		$this->hg_img17->SetVisibility();
		$this->hg_img18->SetVisibility();
		$this->hg_img19->SetVisibility();
		$this->hg_img20->SetVisibility();
		$this->hg_img21->SetVisibility();
		$this->hg_img22->SetVisibility();
		$this->hg_img23->SetVisibility();
		$this->hg_img24->SetVisibility();
		$this->last_update->SetVisibility();

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
		global $EW_EXPORT, $hotel_gallery;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_gallery);
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
			if (@$_GET["hgallery_id"] != "") {
				$this->hgallery_id->setQueryStringValue($_GET["hgallery_id"]);
				$this->setKey("hgallery_id", $this->hgallery_id->CurrentValue); // Set up key
			} else {
				$this->setKey("hgallery_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
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
					$this->Page_Terminate("hotel_gallerylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "hotel_gallerylist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "hotel_galleryview.php")
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
		$this->hotel_id->CurrentValue = NULL;
		$this->hotel_id->OldValue = $this->hotel_id->CurrentValue;
		$this->hg_img1->CurrentValue = NULL;
		$this->hg_img1->OldValue = $this->hg_img1->CurrentValue;
		$this->hg_img2->CurrentValue = NULL;
		$this->hg_img2->OldValue = $this->hg_img2->CurrentValue;
		$this->hg_img3->CurrentValue = NULL;
		$this->hg_img3->OldValue = $this->hg_img3->CurrentValue;
		$this->hg_img4->CurrentValue = NULL;
		$this->hg_img4->OldValue = $this->hg_img4->CurrentValue;
		$this->hg_img5->CurrentValue = NULL;
		$this->hg_img5->OldValue = $this->hg_img5->CurrentValue;
		$this->hg_img6->CurrentValue = NULL;
		$this->hg_img6->OldValue = $this->hg_img6->CurrentValue;
		$this->hg_img7->CurrentValue = NULL;
		$this->hg_img7->OldValue = $this->hg_img7->CurrentValue;
		$this->hg_img8->CurrentValue = NULL;
		$this->hg_img8->OldValue = $this->hg_img8->CurrentValue;
		$this->hg_img9->CurrentValue = NULL;
		$this->hg_img9->OldValue = $this->hg_img9->CurrentValue;
		$this->hg_img10->CurrentValue = NULL;
		$this->hg_img10->OldValue = $this->hg_img10->CurrentValue;
		$this->hg_img11->CurrentValue = NULL;
		$this->hg_img11->OldValue = $this->hg_img11->CurrentValue;
		$this->hg_img12->CurrentValue = NULL;
		$this->hg_img12->OldValue = $this->hg_img12->CurrentValue;
		$this->hg_img13->CurrentValue = NULL;
		$this->hg_img13->OldValue = $this->hg_img13->CurrentValue;
		$this->hg_img14->CurrentValue = NULL;
		$this->hg_img14->OldValue = $this->hg_img14->CurrentValue;
		$this->hg_img15->CurrentValue = NULL;
		$this->hg_img15->OldValue = $this->hg_img15->CurrentValue;
		$this->hg_img16->CurrentValue = NULL;
		$this->hg_img16->OldValue = $this->hg_img16->CurrentValue;
		$this->hg_img17->CurrentValue = NULL;
		$this->hg_img17->OldValue = $this->hg_img17->CurrentValue;
		$this->hg_img18->CurrentValue = NULL;
		$this->hg_img18->OldValue = $this->hg_img18->CurrentValue;
		$this->hg_img19->CurrentValue = NULL;
		$this->hg_img19->OldValue = $this->hg_img19->CurrentValue;
		$this->hg_img20->CurrentValue = NULL;
		$this->hg_img20->OldValue = $this->hg_img20->CurrentValue;
		$this->hg_img21->CurrentValue = NULL;
		$this->hg_img21->OldValue = $this->hg_img21->CurrentValue;
		$this->hg_img22->CurrentValue = NULL;
		$this->hg_img22->OldValue = $this->hg_img22->CurrentValue;
		$this->hg_img23->CurrentValue = NULL;
		$this->hg_img23->OldValue = $this->hg_img23->CurrentValue;
		$this->hg_img24->CurrentValue = NULL;
		$this->hg_img24->OldValue = $this->hg_img24->CurrentValue;
		$this->last_update->CurrentValue = NULL;
		$this->last_update->OldValue = $this->last_update->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->hotel_id->FldIsDetailKey) {
			$this->hotel_id->setFormValue($objForm->GetValue("x_hotel_id"));
		}
		if (!$this->hg_img1->FldIsDetailKey) {
			$this->hg_img1->setFormValue($objForm->GetValue("x_hg_img1"));
		}
		if (!$this->hg_img2->FldIsDetailKey) {
			$this->hg_img2->setFormValue($objForm->GetValue("x_hg_img2"));
		}
		if (!$this->hg_img3->FldIsDetailKey) {
			$this->hg_img3->setFormValue($objForm->GetValue("x_hg_img3"));
		}
		if (!$this->hg_img4->FldIsDetailKey) {
			$this->hg_img4->setFormValue($objForm->GetValue("x_hg_img4"));
		}
		if (!$this->hg_img5->FldIsDetailKey) {
			$this->hg_img5->setFormValue($objForm->GetValue("x_hg_img5"));
		}
		if (!$this->hg_img6->FldIsDetailKey) {
			$this->hg_img6->setFormValue($objForm->GetValue("x_hg_img6"));
		}
		if (!$this->hg_img7->FldIsDetailKey) {
			$this->hg_img7->setFormValue($objForm->GetValue("x_hg_img7"));
		}
		if (!$this->hg_img8->FldIsDetailKey) {
			$this->hg_img8->setFormValue($objForm->GetValue("x_hg_img8"));
		}
		if (!$this->hg_img9->FldIsDetailKey) {
			$this->hg_img9->setFormValue($objForm->GetValue("x_hg_img9"));
		}
		if (!$this->hg_img10->FldIsDetailKey) {
			$this->hg_img10->setFormValue($objForm->GetValue("x_hg_img10"));
		}
		if (!$this->hg_img11->FldIsDetailKey) {
			$this->hg_img11->setFormValue($objForm->GetValue("x_hg_img11"));
		}
		if (!$this->hg_img12->FldIsDetailKey) {
			$this->hg_img12->setFormValue($objForm->GetValue("x_hg_img12"));
		}
		if (!$this->hg_img13->FldIsDetailKey) {
			$this->hg_img13->setFormValue($objForm->GetValue("x_hg_img13"));
		}
		if (!$this->hg_img14->FldIsDetailKey) {
			$this->hg_img14->setFormValue($objForm->GetValue("x_hg_img14"));
		}
		if (!$this->hg_img15->FldIsDetailKey) {
			$this->hg_img15->setFormValue($objForm->GetValue("x_hg_img15"));
		}
		if (!$this->hg_img16->FldIsDetailKey) {
			$this->hg_img16->setFormValue($objForm->GetValue("x_hg_img16"));
		}
		if (!$this->hg_img17->FldIsDetailKey) {
			$this->hg_img17->setFormValue($objForm->GetValue("x_hg_img17"));
		}
		if (!$this->hg_img18->FldIsDetailKey) {
			$this->hg_img18->setFormValue($objForm->GetValue("x_hg_img18"));
		}
		if (!$this->hg_img19->FldIsDetailKey) {
			$this->hg_img19->setFormValue($objForm->GetValue("x_hg_img19"));
		}
		if (!$this->hg_img20->FldIsDetailKey) {
			$this->hg_img20->setFormValue($objForm->GetValue("x_hg_img20"));
		}
		if (!$this->hg_img21->FldIsDetailKey) {
			$this->hg_img21->setFormValue($objForm->GetValue("x_hg_img21"));
		}
		if (!$this->hg_img22->FldIsDetailKey) {
			$this->hg_img22->setFormValue($objForm->GetValue("x_hg_img22"));
		}
		if (!$this->hg_img23->FldIsDetailKey) {
			$this->hg_img23->setFormValue($objForm->GetValue("x_hg_img23"));
		}
		if (!$this->hg_img24->FldIsDetailKey) {
			$this->hg_img24->setFormValue($objForm->GetValue("x_hg_img24"));
		}
		if (!$this->last_update->FldIsDetailKey) {
			$this->last_update->setFormValue($objForm->GetValue("x_last_update"));
			$this->last_update->CurrentValue = ew_UnFormatDateTime($this->last_update->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->hotel_id->CurrentValue = $this->hotel_id->FormValue;
		$this->hg_img1->CurrentValue = $this->hg_img1->FormValue;
		$this->hg_img2->CurrentValue = $this->hg_img2->FormValue;
		$this->hg_img3->CurrentValue = $this->hg_img3->FormValue;
		$this->hg_img4->CurrentValue = $this->hg_img4->FormValue;
		$this->hg_img5->CurrentValue = $this->hg_img5->FormValue;
		$this->hg_img6->CurrentValue = $this->hg_img6->FormValue;
		$this->hg_img7->CurrentValue = $this->hg_img7->FormValue;
		$this->hg_img8->CurrentValue = $this->hg_img8->FormValue;
		$this->hg_img9->CurrentValue = $this->hg_img9->FormValue;
		$this->hg_img10->CurrentValue = $this->hg_img10->FormValue;
		$this->hg_img11->CurrentValue = $this->hg_img11->FormValue;
		$this->hg_img12->CurrentValue = $this->hg_img12->FormValue;
		$this->hg_img13->CurrentValue = $this->hg_img13->FormValue;
		$this->hg_img14->CurrentValue = $this->hg_img14->FormValue;
		$this->hg_img15->CurrentValue = $this->hg_img15->FormValue;
		$this->hg_img16->CurrentValue = $this->hg_img16->FormValue;
		$this->hg_img17->CurrentValue = $this->hg_img17->FormValue;
		$this->hg_img18->CurrentValue = $this->hg_img18->FormValue;
		$this->hg_img19->CurrentValue = $this->hg_img19->FormValue;
		$this->hg_img20->CurrentValue = $this->hg_img20->FormValue;
		$this->hg_img21->CurrentValue = $this->hg_img21->FormValue;
		$this->hg_img22->CurrentValue = $this->hg_img22->FormValue;
		$this->hg_img23->CurrentValue = $this->hg_img23->FormValue;
		$this->hg_img24->CurrentValue = $this->hg_img24->FormValue;
		$this->last_update->CurrentValue = $this->last_update->FormValue;
		$this->last_update->CurrentValue = ew_UnFormatDateTime($this->last_update->CurrentValue, 0);
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
		$this->hgallery_id->setDbValue($rs->fields('hgallery_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->hg_img1->setDbValue($rs->fields('hg_img1'));
		$this->hg_img2->setDbValue($rs->fields('hg_img2'));
		$this->hg_img3->setDbValue($rs->fields('hg_img3'));
		$this->hg_img4->setDbValue($rs->fields('hg_img4'));
		$this->hg_img5->setDbValue($rs->fields('hg_img5'));
		$this->hg_img6->setDbValue($rs->fields('hg_img6'));
		$this->hg_img7->setDbValue($rs->fields('hg_img7'));
		$this->hg_img8->setDbValue($rs->fields('hg_img8'));
		$this->hg_img9->setDbValue($rs->fields('hg_img9'));
		$this->hg_img10->setDbValue($rs->fields('hg_img10'));
		$this->hg_img11->setDbValue($rs->fields('hg_img11'));
		$this->hg_img12->setDbValue($rs->fields('hg_img12'));
		$this->hg_img13->setDbValue($rs->fields('hg_img13'));
		$this->hg_img14->setDbValue($rs->fields('hg_img14'));
		$this->hg_img15->setDbValue($rs->fields('hg_img15'));
		$this->hg_img16->setDbValue($rs->fields('hg_img16'));
		$this->hg_img17->setDbValue($rs->fields('hg_img17'));
		$this->hg_img18->setDbValue($rs->fields('hg_img18'));
		$this->hg_img19->setDbValue($rs->fields('hg_img19'));
		$this->hg_img20->setDbValue($rs->fields('hg_img20'));
		$this->hg_img21->setDbValue($rs->fields('hg_img21'));
		$this->hg_img22->setDbValue($rs->fields('hg_img22'));
		$this->hg_img23->setDbValue($rs->fields('hg_img23'));
		$this->hg_img24->setDbValue($rs->fields('hg_img24'));
		$this->last_update->setDbValue($rs->fields('last_update'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hgallery_id->DbValue = $row['hgallery_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->hg_img1->DbValue = $row['hg_img1'];
		$this->hg_img2->DbValue = $row['hg_img2'];
		$this->hg_img3->DbValue = $row['hg_img3'];
		$this->hg_img4->DbValue = $row['hg_img4'];
		$this->hg_img5->DbValue = $row['hg_img5'];
		$this->hg_img6->DbValue = $row['hg_img6'];
		$this->hg_img7->DbValue = $row['hg_img7'];
		$this->hg_img8->DbValue = $row['hg_img8'];
		$this->hg_img9->DbValue = $row['hg_img9'];
		$this->hg_img10->DbValue = $row['hg_img10'];
		$this->hg_img11->DbValue = $row['hg_img11'];
		$this->hg_img12->DbValue = $row['hg_img12'];
		$this->hg_img13->DbValue = $row['hg_img13'];
		$this->hg_img14->DbValue = $row['hg_img14'];
		$this->hg_img15->DbValue = $row['hg_img15'];
		$this->hg_img16->DbValue = $row['hg_img16'];
		$this->hg_img17->DbValue = $row['hg_img17'];
		$this->hg_img18->DbValue = $row['hg_img18'];
		$this->hg_img19->DbValue = $row['hg_img19'];
		$this->hg_img20->DbValue = $row['hg_img20'];
		$this->hg_img21->DbValue = $row['hg_img21'];
		$this->hg_img22->DbValue = $row['hg_img22'];
		$this->hg_img23->DbValue = $row['hg_img23'];
		$this->hg_img24->DbValue = $row['hg_img24'];
		$this->last_update->DbValue = $row['last_update'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("hgallery_id")) <> "")
			$this->hgallery_id->CurrentValue = $this->getKey("hgallery_id"); // hgallery_id
		else
			$bValidKey = FALSE;
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
		// hgallery_id
		// hotel_id
		// hg_img1
		// hg_img2
		// hg_img3
		// hg_img4
		// hg_img5
		// hg_img6
		// hg_img7
		// hg_img8
		// hg_img9
		// hg_img10
		// hg_img11
		// hg_img12
		// hg_img13
		// hg_img14
		// hg_img15
		// hg_img16
		// hg_img17
		// hg_img18
		// hg_img19
		// hg_img20
		// hg_img21
		// hg_img22
		// hg_img23
		// hg_img24
		// last_update

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hgallery_id
		$this->hgallery_id->ViewValue = $this->hgallery_id->CurrentValue;
		$this->hgallery_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// hg_img1
		$this->hg_img1->ViewValue = $this->hg_img1->CurrentValue;
		$this->hg_img1->ViewCustomAttributes = "";

		// hg_img2
		$this->hg_img2->ViewValue = $this->hg_img2->CurrentValue;
		$this->hg_img2->ViewCustomAttributes = "";

		// hg_img3
		$this->hg_img3->ViewValue = $this->hg_img3->CurrentValue;
		$this->hg_img3->ViewCustomAttributes = "";

		// hg_img4
		$this->hg_img4->ViewValue = $this->hg_img4->CurrentValue;
		$this->hg_img4->ViewCustomAttributes = "";

		// hg_img5
		$this->hg_img5->ViewValue = $this->hg_img5->CurrentValue;
		$this->hg_img5->ViewCustomAttributes = "";

		// hg_img6
		$this->hg_img6->ViewValue = $this->hg_img6->CurrentValue;
		$this->hg_img6->ViewCustomAttributes = "";

		// hg_img7
		$this->hg_img7->ViewValue = $this->hg_img7->CurrentValue;
		$this->hg_img7->ViewCustomAttributes = "";

		// hg_img8
		$this->hg_img8->ViewValue = $this->hg_img8->CurrentValue;
		$this->hg_img8->ViewCustomAttributes = "";

		// hg_img9
		$this->hg_img9->ViewValue = $this->hg_img9->CurrentValue;
		$this->hg_img9->ViewCustomAttributes = "";

		// hg_img10
		$this->hg_img10->ViewValue = $this->hg_img10->CurrentValue;
		$this->hg_img10->ViewCustomAttributes = "";

		// hg_img11
		$this->hg_img11->ViewValue = $this->hg_img11->CurrentValue;
		$this->hg_img11->ViewCustomAttributes = "";

		// hg_img12
		$this->hg_img12->ViewValue = $this->hg_img12->CurrentValue;
		$this->hg_img12->ViewCustomAttributes = "";

		// hg_img13
		$this->hg_img13->ViewValue = $this->hg_img13->CurrentValue;
		$this->hg_img13->ViewCustomAttributes = "";

		// hg_img14
		$this->hg_img14->ViewValue = $this->hg_img14->CurrentValue;
		$this->hg_img14->ViewCustomAttributes = "";

		// hg_img15
		$this->hg_img15->ViewValue = $this->hg_img15->CurrentValue;
		$this->hg_img15->ViewCustomAttributes = "";

		// hg_img16
		$this->hg_img16->ViewValue = $this->hg_img16->CurrentValue;
		$this->hg_img16->ViewCustomAttributes = "";

		// hg_img17
		$this->hg_img17->ViewValue = $this->hg_img17->CurrentValue;
		$this->hg_img17->ViewCustomAttributes = "";

		// hg_img18
		$this->hg_img18->ViewValue = $this->hg_img18->CurrentValue;
		$this->hg_img18->ViewCustomAttributes = "";

		// hg_img19
		$this->hg_img19->ViewValue = $this->hg_img19->CurrentValue;
		$this->hg_img19->ViewCustomAttributes = "";

		// hg_img20
		$this->hg_img20->ViewValue = $this->hg_img20->CurrentValue;
		$this->hg_img20->ViewCustomAttributes = "";

		// hg_img21
		$this->hg_img21->ViewValue = $this->hg_img21->CurrentValue;
		$this->hg_img21->ViewCustomAttributes = "";

		// hg_img22
		$this->hg_img22->ViewValue = $this->hg_img22->CurrentValue;
		$this->hg_img22->ViewCustomAttributes = "";

		// hg_img23
		$this->hg_img23->ViewValue = $this->hg_img23->CurrentValue;
		$this->hg_img23->ViewCustomAttributes = "";

		// hg_img24
		$this->hg_img24->ViewValue = $this->hg_img24->CurrentValue;
		$this->hg_img24->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// hg_img1
			$this->hg_img1->LinkCustomAttributes = "";
			$this->hg_img1->HrefValue = "";
			$this->hg_img1->TooltipValue = "";

			// hg_img2
			$this->hg_img2->LinkCustomAttributes = "";
			$this->hg_img2->HrefValue = "";
			$this->hg_img2->TooltipValue = "";

			// hg_img3
			$this->hg_img3->LinkCustomAttributes = "";
			$this->hg_img3->HrefValue = "";
			$this->hg_img3->TooltipValue = "";

			// hg_img4
			$this->hg_img4->LinkCustomAttributes = "";
			$this->hg_img4->HrefValue = "";
			$this->hg_img4->TooltipValue = "";

			// hg_img5
			$this->hg_img5->LinkCustomAttributes = "";
			$this->hg_img5->HrefValue = "";
			$this->hg_img5->TooltipValue = "";

			// hg_img6
			$this->hg_img6->LinkCustomAttributes = "";
			$this->hg_img6->HrefValue = "";
			$this->hg_img6->TooltipValue = "";

			// hg_img7
			$this->hg_img7->LinkCustomAttributes = "";
			$this->hg_img7->HrefValue = "";
			$this->hg_img7->TooltipValue = "";

			// hg_img8
			$this->hg_img8->LinkCustomAttributes = "";
			$this->hg_img8->HrefValue = "";
			$this->hg_img8->TooltipValue = "";

			// hg_img9
			$this->hg_img9->LinkCustomAttributes = "";
			$this->hg_img9->HrefValue = "";
			$this->hg_img9->TooltipValue = "";

			// hg_img10
			$this->hg_img10->LinkCustomAttributes = "";
			$this->hg_img10->HrefValue = "";
			$this->hg_img10->TooltipValue = "";

			// hg_img11
			$this->hg_img11->LinkCustomAttributes = "";
			$this->hg_img11->HrefValue = "";
			$this->hg_img11->TooltipValue = "";

			// hg_img12
			$this->hg_img12->LinkCustomAttributes = "";
			$this->hg_img12->HrefValue = "";
			$this->hg_img12->TooltipValue = "";

			// hg_img13
			$this->hg_img13->LinkCustomAttributes = "";
			$this->hg_img13->HrefValue = "";
			$this->hg_img13->TooltipValue = "";

			// hg_img14
			$this->hg_img14->LinkCustomAttributes = "";
			$this->hg_img14->HrefValue = "";
			$this->hg_img14->TooltipValue = "";

			// hg_img15
			$this->hg_img15->LinkCustomAttributes = "";
			$this->hg_img15->HrefValue = "";
			$this->hg_img15->TooltipValue = "";

			// hg_img16
			$this->hg_img16->LinkCustomAttributes = "";
			$this->hg_img16->HrefValue = "";
			$this->hg_img16->TooltipValue = "";

			// hg_img17
			$this->hg_img17->LinkCustomAttributes = "";
			$this->hg_img17->HrefValue = "";
			$this->hg_img17->TooltipValue = "";

			// hg_img18
			$this->hg_img18->LinkCustomAttributes = "";
			$this->hg_img18->HrefValue = "";
			$this->hg_img18->TooltipValue = "";

			// hg_img19
			$this->hg_img19->LinkCustomAttributes = "";
			$this->hg_img19->HrefValue = "";
			$this->hg_img19->TooltipValue = "";

			// hg_img20
			$this->hg_img20->LinkCustomAttributes = "";
			$this->hg_img20->HrefValue = "";
			$this->hg_img20->TooltipValue = "";

			// hg_img21
			$this->hg_img21->LinkCustomAttributes = "";
			$this->hg_img21->HrefValue = "";
			$this->hg_img21->TooltipValue = "";

			// hg_img22
			$this->hg_img22->LinkCustomAttributes = "";
			$this->hg_img22->HrefValue = "";
			$this->hg_img22->TooltipValue = "";

			// hg_img23
			$this->hg_img23->LinkCustomAttributes = "";
			$this->hg_img23->HrefValue = "";
			$this->hg_img23->TooltipValue = "";

			// hg_img24
			$this->hg_img24->LinkCustomAttributes = "";
			$this->hg_img24->HrefValue = "";
			$this->hg_img24->TooltipValue = "";

			// last_update
			$this->last_update->LinkCustomAttributes = "";
			$this->last_update->HrefValue = "";
			$this->last_update->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->CurrentValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// hg_img1
			$this->hg_img1->EditAttrs["class"] = "form-control";
			$this->hg_img1->EditCustomAttributes = "";
			$this->hg_img1->EditValue = ew_HtmlEncode($this->hg_img1->CurrentValue);
			$this->hg_img1->PlaceHolder = ew_RemoveHtml($this->hg_img1->FldCaption());

			// hg_img2
			$this->hg_img2->EditAttrs["class"] = "form-control";
			$this->hg_img2->EditCustomAttributes = "";
			$this->hg_img2->EditValue = ew_HtmlEncode($this->hg_img2->CurrentValue);
			$this->hg_img2->PlaceHolder = ew_RemoveHtml($this->hg_img2->FldCaption());

			// hg_img3
			$this->hg_img3->EditAttrs["class"] = "form-control";
			$this->hg_img3->EditCustomAttributes = "";
			$this->hg_img3->EditValue = ew_HtmlEncode($this->hg_img3->CurrentValue);
			$this->hg_img3->PlaceHolder = ew_RemoveHtml($this->hg_img3->FldCaption());

			// hg_img4
			$this->hg_img4->EditAttrs["class"] = "form-control";
			$this->hg_img4->EditCustomAttributes = "";
			$this->hg_img4->EditValue = ew_HtmlEncode($this->hg_img4->CurrentValue);
			$this->hg_img4->PlaceHolder = ew_RemoveHtml($this->hg_img4->FldCaption());

			// hg_img5
			$this->hg_img5->EditAttrs["class"] = "form-control";
			$this->hg_img5->EditCustomAttributes = "";
			$this->hg_img5->EditValue = ew_HtmlEncode($this->hg_img5->CurrentValue);
			$this->hg_img5->PlaceHolder = ew_RemoveHtml($this->hg_img5->FldCaption());

			// hg_img6
			$this->hg_img6->EditAttrs["class"] = "form-control";
			$this->hg_img6->EditCustomAttributes = "";
			$this->hg_img6->EditValue = ew_HtmlEncode($this->hg_img6->CurrentValue);
			$this->hg_img6->PlaceHolder = ew_RemoveHtml($this->hg_img6->FldCaption());

			// hg_img7
			$this->hg_img7->EditAttrs["class"] = "form-control";
			$this->hg_img7->EditCustomAttributes = "";
			$this->hg_img7->EditValue = ew_HtmlEncode($this->hg_img7->CurrentValue);
			$this->hg_img7->PlaceHolder = ew_RemoveHtml($this->hg_img7->FldCaption());

			// hg_img8
			$this->hg_img8->EditAttrs["class"] = "form-control";
			$this->hg_img8->EditCustomAttributes = "";
			$this->hg_img8->EditValue = ew_HtmlEncode($this->hg_img8->CurrentValue);
			$this->hg_img8->PlaceHolder = ew_RemoveHtml($this->hg_img8->FldCaption());

			// hg_img9
			$this->hg_img9->EditAttrs["class"] = "form-control";
			$this->hg_img9->EditCustomAttributes = "";
			$this->hg_img9->EditValue = ew_HtmlEncode($this->hg_img9->CurrentValue);
			$this->hg_img9->PlaceHolder = ew_RemoveHtml($this->hg_img9->FldCaption());

			// hg_img10
			$this->hg_img10->EditAttrs["class"] = "form-control";
			$this->hg_img10->EditCustomAttributes = "";
			$this->hg_img10->EditValue = ew_HtmlEncode($this->hg_img10->CurrentValue);
			$this->hg_img10->PlaceHolder = ew_RemoveHtml($this->hg_img10->FldCaption());

			// hg_img11
			$this->hg_img11->EditAttrs["class"] = "form-control";
			$this->hg_img11->EditCustomAttributes = "";
			$this->hg_img11->EditValue = ew_HtmlEncode($this->hg_img11->CurrentValue);
			$this->hg_img11->PlaceHolder = ew_RemoveHtml($this->hg_img11->FldCaption());

			// hg_img12
			$this->hg_img12->EditAttrs["class"] = "form-control";
			$this->hg_img12->EditCustomAttributes = "";
			$this->hg_img12->EditValue = ew_HtmlEncode($this->hg_img12->CurrentValue);
			$this->hg_img12->PlaceHolder = ew_RemoveHtml($this->hg_img12->FldCaption());

			// hg_img13
			$this->hg_img13->EditAttrs["class"] = "form-control";
			$this->hg_img13->EditCustomAttributes = "";
			$this->hg_img13->EditValue = ew_HtmlEncode($this->hg_img13->CurrentValue);
			$this->hg_img13->PlaceHolder = ew_RemoveHtml($this->hg_img13->FldCaption());

			// hg_img14
			$this->hg_img14->EditAttrs["class"] = "form-control";
			$this->hg_img14->EditCustomAttributes = "";
			$this->hg_img14->EditValue = ew_HtmlEncode($this->hg_img14->CurrentValue);
			$this->hg_img14->PlaceHolder = ew_RemoveHtml($this->hg_img14->FldCaption());

			// hg_img15
			$this->hg_img15->EditAttrs["class"] = "form-control";
			$this->hg_img15->EditCustomAttributes = "";
			$this->hg_img15->EditValue = ew_HtmlEncode($this->hg_img15->CurrentValue);
			$this->hg_img15->PlaceHolder = ew_RemoveHtml($this->hg_img15->FldCaption());

			// hg_img16
			$this->hg_img16->EditAttrs["class"] = "form-control";
			$this->hg_img16->EditCustomAttributes = "";
			$this->hg_img16->EditValue = ew_HtmlEncode($this->hg_img16->CurrentValue);
			$this->hg_img16->PlaceHolder = ew_RemoveHtml($this->hg_img16->FldCaption());

			// hg_img17
			$this->hg_img17->EditAttrs["class"] = "form-control";
			$this->hg_img17->EditCustomAttributes = "";
			$this->hg_img17->EditValue = ew_HtmlEncode($this->hg_img17->CurrentValue);
			$this->hg_img17->PlaceHolder = ew_RemoveHtml($this->hg_img17->FldCaption());

			// hg_img18
			$this->hg_img18->EditAttrs["class"] = "form-control";
			$this->hg_img18->EditCustomAttributes = "";
			$this->hg_img18->EditValue = ew_HtmlEncode($this->hg_img18->CurrentValue);
			$this->hg_img18->PlaceHolder = ew_RemoveHtml($this->hg_img18->FldCaption());

			// hg_img19
			$this->hg_img19->EditAttrs["class"] = "form-control";
			$this->hg_img19->EditCustomAttributes = "";
			$this->hg_img19->EditValue = ew_HtmlEncode($this->hg_img19->CurrentValue);
			$this->hg_img19->PlaceHolder = ew_RemoveHtml($this->hg_img19->FldCaption());

			// hg_img20
			$this->hg_img20->EditAttrs["class"] = "form-control";
			$this->hg_img20->EditCustomAttributes = "";
			$this->hg_img20->EditValue = ew_HtmlEncode($this->hg_img20->CurrentValue);
			$this->hg_img20->PlaceHolder = ew_RemoveHtml($this->hg_img20->FldCaption());

			// hg_img21
			$this->hg_img21->EditAttrs["class"] = "form-control";
			$this->hg_img21->EditCustomAttributes = "";
			$this->hg_img21->EditValue = ew_HtmlEncode($this->hg_img21->CurrentValue);
			$this->hg_img21->PlaceHolder = ew_RemoveHtml($this->hg_img21->FldCaption());

			// hg_img22
			$this->hg_img22->EditAttrs["class"] = "form-control";
			$this->hg_img22->EditCustomAttributes = "";
			$this->hg_img22->EditValue = ew_HtmlEncode($this->hg_img22->CurrentValue);
			$this->hg_img22->PlaceHolder = ew_RemoveHtml($this->hg_img22->FldCaption());

			// hg_img23
			$this->hg_img23->EditAttrs["class"] = "form-control";
			$this->hg_img23->EditCustomAttributes = "";
			$this->hg_img23->EditValue = ew_HtmlEncode($this->hg_img23->CurrentValue);
			$this->hg_img23->PlaceHolder = ew_RemoveHtml($this->hg_img23->FldCaption());

			// hg_img24
			$this->hg_img24->EditAttrs["class"] = "form-control";
			$this->hg_img24->EditCustomAttributes = "";
			$this->hg_img24->EditValue = ew_HtmlEncode($this->hg_img24->CurrentValue);
			$this->hg_img24->PlaceHolder = ew_RemoveHtml($this->hg_img24->FldCaption());

			// last_update
			$this->last_update->EditAttrs["class"] = "form-control";
			$this->last_update->EditCustomAttributes = "";
			$this->last_update->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->last_update->CurrentValue, 8));
			$this->last_update->PlaceHolder = ew_RemoveHtml($this->last_update->FldCaption());

			// Add refer script
			// hotel_id

			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";

			// hg_img1
			$this->hg_img1->LinkCustomAttributes = "";
			$this->hg_img1->HrefValue = "";

			// hg_img2
			$this->hg_img2->LinkCustomAttributes = "";
			$this->hg_img2->HrefValue = "";

			// hg_img3
			$this->hg_img3->LinkCustomAttributes = "";
			$this->hg_img3->HrefValue = "";

			// hg_img4
			$this->hg_img4->LinkCustomAttributes = "";
			$this->hg_img4->HrefValue = "";

			// hg_img5
			$this->hg_img5->LinkCustomAttributes = "";
			$this->hg_img5->HrefValue = "";

			// hg_img6
			$this->hg_img6->LinkCustomAttributes = "";
			$this->hg_img6->HrefValue = "";

			// hg_img7
			$this->hg_img7->LinkCustomAttributes = "";
			$this->hg_img7->HrefValue = "";

			// hg_img8
			$this->hg_img8->LinkCustomAttributes = "";
			$this->hg_img8->HrefValue = "";

			// hg_img9
			$this->hg_img9->LinkCustomAttributes = "";
			$this->hg_img9->HrefValue = "";

			// hg_img10
			$this->hg_img10->LinkCustomAttributes = "";
			$this->hg_img10->HrefValue = "";

			// hg_img11
			$this->hg_img11->LinkCustomAttributes = "";
			$this->hg_img11->HrefValue = "";

			// hg_img12
			$this->hg_img12->LinkCustomAttributes = "";
			$this->hg_img12->HrefValue = "";

			// hg_img13
			$this->hg_img13->LinkCustomAttributes = "";
			$this->hg_img13->HrefValue = "";

			// hg_img14
			$this->hg_img14->LinkCustomAttributes = "";
			$this->hg_img14->HrefValue = "";

			// hg_img15
			$this->hg_img15->LinkCustomAttributes = "";
			$this->hg_img15->HrefValue = "";

			// hg_img16
			$this->hg_img16->LinkCustomAttributes = "";
			$this->hg_img16->HrefValue = "";

			// hg_img17
			$this->hg_img17->LinkCustomAttributes = "";
			$this->hg_img17->HrefValue = "";

			// hg_img18
			$this->hg_img18->LinkCustomAttributes = "";
			$this->hg_img18->HrefValue = "";

			// hg_img19
			$this->hg_img19->LinkCustomAttributes = "";
			$this->hg_img19->HrefValue = "";

			// hg_img20
			$this->hg_img20->LinkCustomAttributes = "";
			$this->hg_img20->HrefValue = "";

			// hg_img21
			$this->hg_img21->LinkCustomAttributes = "";
			$this->hg_img21->HrefValue = "";

			// hg_img22
			$this->hg_img22->LinkCustomAttributes = "";
			$this->hg_img22->HrefValue = "";

			// hg_img23
			$this->hg_img23->LinkCustomAttributes = "";
			$this->hg_img23->HrefValue = "";

			// hg_img24
			$this->hg_img24->LinkCustomAttributes = "";
			$this->hg_img24->HrefValue = "";

			// last_update
			$this->last_update->LinkCustomAttributes = "";
			$this->last_update->HrefValue = "";
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
		if (!ew_CheckDateDef($this->last_update->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_update->FldErrMsg());
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

		// hotel_id
		$this->hotel_id->SetDbValueDef($rsnew, $this->hotel_id->CurrentValue, 0, FALSE);

		// hg_img1
		$this->hg_img1->SetDbValueDef($rsnew, $this->hg_img1->CurrentValue, NULL, FALSE);

		// hg_img2
		$this->hg_img2->SetDbValueDef($rsnew, $this->hg_img2->CurrentValue, NULL, FALSE);

		// hg_img3
		$this->hg_img3->SetDbValueDef($rsnew, $this->hg_img3->CurrentValue, NULL, FALSE);

		// hg_img4
		$this->hg_img4->SetDbValueDef($rsnew, $this->hg_img4->CurrentValue, NULL, FALSE);

		// hg_img5
		$this->hg_img5->SetDbValueDef($rsnew, $this->hg_img5->CurrentValue, NULL, FALSE);

		// hg_img6
		$this->hg_img6->SetDbValueDef($rsnew, $this->hg_img6->CurrentValue, NULL, FALSE);

		// hg_img7
		$this->hg_img7->SetDbValueDef($rsnew, $this->hg_img7->CurrentValue, NULL, FALSE);

		// hg_img8
		$this->hg_img8->SetDbValueDef($rsnew, $this->hg_img8->CurrentValue, NULL, FALSE);

		// hg_img9
		$this->hg_img9->SetDbValueDef($rsnew, $this->hg_img9->CurrentValue, NULL, FALSE);

		// hg_img10
		$this->hg_img10->SetDbValueDef($rsnew, $this->hg_img10->CurrentValue, NULL, FALSE);

		// hg_img11
		$this->hg_img11->SetDbValueDef($rsnew, $this->hg_img11->CurrentValue, NULL, FALSE);

		// hg_img12
		$this->hg_img12->SetDbValueDef($rsnew, $this->hg_img12->CurrentValue, NULL, FALSE);

		// hg_img13
		$this->hg_img13->SetDbValueDef($rsnew, $this->hg_img13->CurrentValue, NULL, FALSE);

		// hg_img14
		$this->hg_img14->SetDbValueDef($rsnew, $this->hg_img14->CurrentValue, NULL, FALSE);

		// hg_img15
		$this->hg_img15->SetDbValueDef($rsnew, $this->hg_img15->CurrentValue, NULL, FALSE);

		// hg_img16
		$this->hg_img16->SetDbValueDef($rsnew, $this->hg_img16->CurrentValue, NULL, FALSE);

		// hg_img17
		$this->hg_img17->SetDbValueDef($rsnew, $this->hg_img17->CurrentValue, NULL, FALSE);

		// hg_img18
		$this->hg_img18->SetDbValueDef($rsnew, $this->hg_img18->CurrentValue, NULL, FALSE);

		// hg_img19
		$this->hg_img19->SetDbValueDef($rsnew, $this->hg_img19->CurrentValue, NULL, FALSE);

		// hg_img20
		$this->hg_img20->SetDbValueDef($rsnew, $this->hg_img20->CurrentValue, NULL, FALSE);

		// hg_img21
		$this->hg_img21->SetDbValueDef($rsnew, $this->hg_img21->CurrentValue, NULL, FALSE);

		// hg_img22
		$this->hg_img22->SetDbValueDef($rsnew, $this->hg_img22->CurrentValue, NULL, FALSE);

		// hg_img23
		$this->hg_img23->SetDbValueDef($rsnew, $this->hg_img23->CurrentValue, NULL, FALSE);

		// hg_img24
		$this->hg_img24->SetDbValueDef($rsnew, $this->hg_img24->CurrentValue, NULL, FALSE);

		// last_update
		$this->last_update->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update->CurrentValue, 0), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['hotel_id']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_gallerylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_gallery_add)) $hotel_gallery_add = new chotel_gallery_add();

// Page init
$hotel_gallery_add->Page_Init();

// Page main
$hotel_gallery_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_gallery_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fhotel_galleryadd = new ew_Form("fhotel_galleryadd", "add");

// Validate form
fhotel_galleryadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $hotel_gallery->hotel_id->FldCaption(), $hotel_gallery->hotel_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_hotel_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_gallery->hotel_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($hotel_gallery->last_update->FldErrMsg()) ?>");

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
fhotel_galleryadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_galleryadd.ValidateRequired = true;
<?php } else { ?>
fhotel_galleryadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$hotel_gallery_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_gallery_add->ShowPageHeader(); ?>
<?php
$hotel_gallery_add->ShowMessage();
?>
<form name="fhotel_galleryadd" id="fhotel_galleryadd" class="<?php echo $hotel_gallery_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_gallery_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_gallery_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_gallery">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($hotel_gallery_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($hotel_gallery->hotel_id->Visible) { // hotel_id ?>
	<div id="r_hotel_id" class="form-group">
		<label id="elh_hotel_gallery_hotel_id" for="x_hotel_id" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hotel_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hotel_id->CellAttributes() ?>>
<span id="el_hotel_gallery_hotel_id">
<input type="text" data-table="hotel_gallery" data-field="x_hotel_id" name="x_hotel_id" id="x_hotel_id" size="30" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hotel_id->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hotel_id->EditValue ?>"<?php echo $hotel_gallery->hotel_id->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hotel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img1->Visible) { // hg_img1 ?>
	<div id="r_hg_img1" class="form-group">
		<label id="elh_hotel_gallery_hg_img1" for="x_hg_img1" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img1->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img1">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img1" name="x_hg_img1" id="x_hg_img1" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img1->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img1->EditValue ?>"<?php echo $hotel_gallery->hg_img1->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img2->Visible) { // hg_img2 ?>
	<div id="r_hg_img2" class="form-group">
		<label id="elh_hotel_gallery_hg_img2" for="x_hg_img2" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img2->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img2">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img2" name="x_hg_img2" id="x_hg_img2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img2->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img2->EditValue ?>"<?php echo $hotel_gallery->hg_img2->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img3->Visible) { // hg_img3 ?>
	<div id="r_hg_img3" class="form-group">
		<label id="elh_hotel_gallery_hg_img3" for="x_hg_img3" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img3->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img3">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img3" name="x_hg_img3" id="x_hg_img3" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img3->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img3->EditValue ?>"<?php echo $hotel_gallery->hg_img3->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img4->Visible) { // hg_img4 ?>
	<div id="r_hg_img4" class="form-group">
		<label id="elh_hotel_gallery_hg_img4" for="x_hg_img4" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img4->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img4">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img4" name="x_hg_img4" id="x_hg_img4" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img4->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img4->EditValue ?>"<?php echo $hotel_gallery->hg_img4->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img5->Visible) { // hg_img5 ?>
	<div id="r_hg_img5" class="form-group">
		<label id="elh_hotel_gallery_hg_img5" for="x_hg_img5" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img5->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img5">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img5" name="x_hg_img5" id="x_hg_img5" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img5->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img5->EditValue ?>"<?php echo $hotel_gallery->hg_img5->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img6->Visible) { // hg_img6 ?>
	<div id="r_hg_img6" class="form-group">
		<label id="elh_hotel_gallery_hg_img6" for="x_hg_img6" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img6->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img6->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img6">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img6" name="x_hg_img6" id="x_hg_img6" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img6->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img6->EditValue ?>"<?php echo $hotel_gallery->hg_img6->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img7->Visible) { // hg_img7 ?>
	<div id="r_hg_img7" class="form-group">
		<label id="elh_hotel_gallery_hg_img7" for="x_hg_img7" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img7->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img7->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img7">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img7" name="x_hg_img7" id="x_hg_img7" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img7->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img7->EditValue ?>"<?php echo $hotel_gallery->hg_img7->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img7->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img8->Visible) { // hg_img8 ?>
	<div id="r_hg_img8" class="form-group">
		<label id="elh_hotel_gallery_hg_img8" for="x_hg_img8" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img8->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img8->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img8">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img8" name="x_hg_img8" id="x_hg_img8" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img8->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img8->EditValue ?>"<?php echo $hotel_gallery->hg_img8->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img8->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img9->Visible) { // hg_img9 ?>
	<div id="r_hg_img9" class="form-group">
		<label id="elh_hotel_gallery_hg_img9" for="x_hg_img9" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img9->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img9->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img9">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img9" name="x_hg_img9" id="x_hg_img9" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img9->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img9->EditValue ?>"<?php echo $hotel_gallery->hg_img9->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img9->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img10->Visible) { // hg_img10 ?>
	<div id="r_hg_img10" class="form-group">
		<label id="elh_hotel_gallery_hg_img10" for="x_hg_img10" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img10->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img10->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img10">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img10" name="x_hg_img10" id="x_hg_img10" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img10->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img10->EditValue ?>"<?php echo $hotel_gallery->hg_img10->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img10->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img11->Visible) { // hg_img11 ?>
	<div id="r_hg_img11" class="form-group">
		<label id="elh_hotel_gallery_hg_img11" for="x_hg_img11" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img11->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img11->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img11">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img11" name="x_hg_img11" id="x_hg_img11" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img11->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img11->EditValue ?>"<?php echo $hotel_gallery->hg_img11->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img11->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img12->Visible) { // hg_img12 ?>
	<div id="r_hg_img12" class="form-group">
		<label id="elh_hotel_gallery_hg_img12" for="x_hg_img12" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img12->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img12->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img12">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img12" name="x_hg_img12" id="x_hg_img12" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img12->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img12->EditValue ?>"<?php echo $hotel_gallery->hg_img12->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img12->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img13->Visible) { // hg_img13 ?>
	<div id="r_hg_img13" class="form-group">
		<label id="elh_hotel_gallery_hg_img13" for="x_hg_img13" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img13->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img13->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img13">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img13" name="x_hg_img13" id="x_hg_img13" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img13->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img13->EditValue ?>"<?php echo $hotel_gallery->hg_img13->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img13->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img14->Visible) { // hg_img14 ?>
	<div id="r_hg_img14" class="form-group">
		<label id="elh_hotel_gallery_hg_img14" for="x_hg_img14" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img14->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img14->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img14">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img14" name="x_hg_img14" id="x_hg_img14" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img14->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img14->EditValue ?>"<?php echo $hotel_gallery->hg_img14->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img14->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img15->Visible) { // hg_img15 ?>
	<div id="r_hg_img15" class="form-group">
		<label id="elh_hotel_gallery_hg_img15" for="x_hg_img15" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img15->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img15->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img15">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img15" name="x_hg_img15" id="x_hg_img15" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img15->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img15->EditValue ?>"<?php echo $hotel_gallery->hg_img15->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img15->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img16->Visible) { // hg_img16 ?>
	<div id="r_hg_img16" class="form-group">
		<label id="elh_hotel_gallery_hg_img16" for="x_hg_img16" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img16->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img16->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img16">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img16" name="x_hg_img16" id="x_hg_img16" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img16->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img16->EditValue ?>"<?php echo $hotel_gallery->hg_img16->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img16->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img17->Visible) { // hg_img17 ?>
	<div id="r_hg_img17" class="form-group">
		<label id="elh_hotel_gallery_hg_img17" for="x_hg_img17" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img17->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img17->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img17">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img17" name="x_hg_img17" id="x_hg_img17" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img17->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img17->EditValue ?>"<?php echo $hotel_gallery->hg_img17->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img17->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img18->Visible) { // hg_img18 ?>
	<div id="r_hg_img18" class="form-group">
		<label id="elh_hotel_gallery_hg_img18" for="x_hg_img18" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img18->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img18->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img18">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img18" name="x_hg_img18" id="x_hg_img18" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img18->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img18->EditValue ?>"<?php echo $hotel_gallery->hg_img18->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img18->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img19->Visible) { // hg_img19 ?>
	<div id="r_hg_img19" class="form-group">
		<label id="elh_hotel_gallery_hg_img19" for="x_hg_img19" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img19->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img19->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img19">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img19" name="x_hg_img19" id="x_hg_img19" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img19->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img19->EditValue ?>"<?php echo $hotel_gallery->hg_img19->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img19->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img20->Visible) { // hg_img20 ?>
	<div id="r_hg_img20" class="form-group">
		<label id="elh_hotel_gallery_hg_img20" for="x_hg_img20" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img20->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img20->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img20">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img20" name="x_hg_img20" id="x_hg_img20" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img20->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img20->EditValue ?>"<?php echo $hotel_gallery->hg_img20->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img20->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img21->Visible) { // hg_img21 ?>
	<div id="r_hg_img21" class="form-group">
		<label id="elh_hotel_gallery_hg_img21" for="x_hg_img21" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img21->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img21->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img21">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img21" name="x_hg_img21" id="x_hg_img21" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img21->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img21->EditValue ?>"<?php echo $hotel_gallery->hg_img21->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img21->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img22->Visible) { // hg_img22 ?>
	<div id="r_hg_img22" class="form-group">
		<label id="elh_hotel_gallery_hg_img22" for="x_hg_img22" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img22->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img22->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img22">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img22" name="x_hg_img22" id="x_hg_img22" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img22->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img22->EditValue ?>"<?php echo $hotel_gallery->hg_img22->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img22->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img23->Visible) { // hg_img23 ?>
	<div id="r_hg_img23" class="form-group">
		<label id="elh_hotel_gallery_hg_img23" for="x_hg_img23" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img23->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img23->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img23">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img23" name="x_hg_img23" id="x_hg_img23" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img23->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img23->EditValue ?>"<?php echo $hotel_gallery->hg_img23->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img23->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->hg_img24->Visible) { // hg_img24 ?>
	<div id="r_hg_img24" class="form-group">
		<label id="elh_hotel_gallery_hg_img24" for="x_hg_img24" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->hg_img24->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->hg_img24->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img24">
<input type="text" data-table="hotel_gallery" data-field="x_hg_img24" name="x_hg_img24" id="x_hg_img24" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->hg_img24->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->hg_img24->EditValue ?>"<?php echo $hotel_gallery->hg_img24->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->hg_img24->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($hotel_gallery->last_update->Visible) { // last_update ?>
	<div id="r_last_update" class="form-group">
		<label id="elh_hotel_gallery_last_update" for="x_last_update" class="col-sm-2 control-label ewLabel"><?php echo $hotel_gallery->last_update->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $hotel_gallery->last_update->CellAttributes() ?>>
<span id="el_hotel_gallery_last_update">
<input type="text" data-table="hotel_gallery" data-field="x_last_update" name="x_last_update" id="x_last_update" placeholder="<?php echo ew_HtmlEncode($hotel_gallery->last_update->getPlaceHolder()) ?>" value="<?php echo $hotel_gallery->last_update->EditValue ?>"<?php echo $hotel_gallery->last_update->EditAttributes() ?>>
</span>
<?php echo $hotel_gallery->last_update->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$hotel_gallery_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_gallery_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fhotel_galleryadd.Init();
</script>
<?php
$hotel_gallery_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_gallery_add->Page_Terminate();
?>

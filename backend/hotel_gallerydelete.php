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

$hotel_gallery_delete = NULL; // Initialize page object first

class chotel_gallery_delete extends chotel_gallery {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_gallery';

	// Page object name
	var $PageObjName = 'hotel_gallery_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotel_gallerylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->hgallery_id->SetVisibility();
		$this->hgallery_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("hotel_gallerylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hotel_gallery class, hotel_galleryinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("hotel_gallerylist.php"); // Return to list
			}
		}
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

			// hgallery_id
			$this->hgallery_id->LinkCustomAttributes = "";
			$this->hgallery_id->HrefValue = "";
			$this->hgallery_id->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hgallery_id'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['hotel_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_gallerylist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($hotel_gallery_delete)) $hotel_gallery_delete = new chotel_gallery_delete();

// Page init
$hotel_gallery_delete->Page_Init();

// Page main
$hotel_gallery_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_gallery_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhotel_gallerydelete = new ew_Form("fhotel_gallerydelete", "delete");

// Form_CustomValidate event
fhotel_gallerydelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_gallerydelete.ValidateRequired = true;
<?php } else { ?>
fhotel_gallerydelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $hotel_gallery_delete->ShowPageHeader(); ?>
<?php
$hotel_gallery_delete->ShowMessage();
?>
<form name="fhotel_gallerydelete" id="fhotel_gallerydelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_gallery_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_gallery_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_gallery">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hotel_gallery_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $hotel_gallery->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($hotel_gallery->hgallery_id->Visible) { // hgallery_id ?>
		<th><span id="elh_hotel_gallery_hgallery_id" class="hotel_gallery_hgallery_id"><?php echo $hotel_gallery->hgallery_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hotel_id->Visible) { // hotel_id ?>
		<th><span id="elh_hotel_gallery_hotel_id" class="hotel_gallery_hotel_id"><?php echo $hotel_gallery->hotel_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img1->Visible) { // hg_img1 ?>
		<th><span id="elh_hotel_gallery_hg_img1" class="hotel_gallery_hg_img1"><?php echo $hotel_gallery->hg_img1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img2->Visible) { // hg_img2 ?>
		<th><span id="elh_hotel_gallery_hg_img2" class="hotel_gallery_hg_img2"><?php echo $hotel_gallery->hg_img2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img3->Visible) { // hg_img3 ?>
		<th><span id="elh_hotel_gallery_hg_img3" class="hotel_gallery_hg_img3"><?php echo $hotel_gallery->hg_img3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img4->Visible) { // hg_img4 ?>
		<th><span id="elh_hotel_gallery_hg_img4" class="hotel_gallery_hg_img4"><?php echo $hotel_gallery->hg_img4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img5->Visible) { // hg_img5 ?>
		<th><span id="elh_hotel_gallery_hg_img5" class="hotel_gallery_hg_img5"><?php echo $hotel_gallery->hg_img5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img6->Visible) { // hg_img6 ?>
		<th><span id="elh_hotel_gallery_hg_img6" class="hotel_gallery_hg_img6"><?php echo $hotel_gallery->hg_img6->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img7->Visible) { // hg_img7 ?>
		<th><span id="elh_hotel_gallery_hg_img7" class="hotel_gallery_hg_img7"><?php echo $hotel_gallery->hg_img7->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img8->Visible) { // hg_img8 ?>
		<th><span id="elh_hotel_gallery_hg_img8" class="hotel_gallery_hg_img8"><?php echo $hotel_gallery->hg_img8->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img9->Visible) { // hg_img9 ?>
		<th><span id="elh_hotel_gallery_hg_img9" class="hotel_gallery_hg_img9"><?php echo $hotel_gallery->hg_img9->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img10->Visible) { // hg_img10 ?>
		<th><span id="elh_hotel_gallery_hg_img10" class="hotel_gallery_hg_img10"><?php echo $hotel_gallery->hg_img10->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img11->Visible) { // hg_img11 ?>
		<th><span id="elh_hotel_gallery_hg_img11" class="hotel_gallery_hg_img11"><?php echo $hotel_gallery->hg_img11->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img12->Visible) { // hg_img12 ?>
		<th><span id="elh_hotel_gallery_hg_img12" class="hotel_gallery_hg_img12"><?php echo $hotel_gallery->hg_img12->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img13->Visible) { // hg_img13 ?>
		<th><span id="elh_hotel_gallery_hg_img13" class="hotel_gallery_hg_img13"><?php echo $hotel_gallery->hg_img13->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img14->Visible) { // hg_img14 ?>
		<th><span id="elh_hotel_gallery_hg_img14" class="hotel_gallery_hg_img14"><?php echo $hotel_gallery->hg_img14->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img15->Visible) { // hg_img15 ?>
		<th><span id="elh_hotel_gallery_hg_img15" class="hotel_gallery_hg_img15"><?php echo $hotel_gallery->hg_img15->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img16->Visible) { // hg_img16 ?>
		<th><span id="elh_hotel_gallery_hg_img16" class="hotel_gallery_hg_img16"><?php echo $hotel_gallery->hg_img16->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img17->Visible) { // hg_img17 ?>
		<th><span id="elh_hotel_gallery_hg_img17" class="hotel_gallery_hg_img17"><?php echo $hotel_gallery->hg_img17->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img18->Visible) { // hg_img18 ?>
		<th><span id="elh_hotel_gallery_hg_img18" class="hotel_gallery_hg_img18"><?php echo $hotel_gallery->hg_img18->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img19->Visible) { // hg_img19 ?>
		<th><span id="elh_hotel_gallery_hg_img19" class="hotel_gallery_hg_img19"><?php echo $hotel_gallery->hg_img19->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img20->Visible) { // hg_img20 ?>
		<th><span id="elh_hotel_gallery_hg_img20" class="hotel_gallery_hg_img20"><?php echo $hotel_gallery->hg_img20->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img21->Visible) { // hg_img21 ?>
		<th><span id="elh_hotel_gallery_hg_img21" class="hotel_gallery_hg_img21"><?php echo $hotel_gallery->hg_img21->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img22->Visible) { // hg_img22 ?>
		<th><span id="elh_hotel_gallery_hg_img22" class="hotel_gallery_hg_img22"><?php echo $hotel_gallery->hg_img22->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img23->Visible) { // hg_img23 ?>
		<th><span id="elh_hotel_gallery_hg_img23" class="hotel_gallery_hg_img23"><?php echo $hotel_gallery->hg_img23->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->hg_img24->Visible) { // hg_img24 ?>
		<th><span id="elh_hotel_gallery_hg_img24" class="hotel_gallery_hg_img24"><?php echo $hotel_gallery->hg_img24->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotel_gallery->last_update->Visible) { // last_update ?>
		<th><span id="elh_hotel_gallery_last_update" class="hotel_gallery_last_update"><?php echo $hotel_gallery->last_update->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hotel_gallery_delete->RecCnt = 0;
$i = 0;
while (!$hotel_gallery_delete->Recordset->EOF) {
	$hotel_gallery_delete->RecCnt++;
	$hotel_gallery_delete->RowCnt++;

	// Set row properties
	$hotel_gallery->ResetAttrs();
	$hotel_gallery->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hotel_gallery_delete->LoadRowValues($hotel_gallery_delete->Recordset);

	// Render row
	$hotel_gallery_delete->RenderRow();
?>
	<tr<?php echo $hotel_gallery->RowAttributes() ?>>
<?php if ($hotel_gallery->hgallery_id->Visible) { // hgallery_id ?>
		<td<?php echo $hotel_gallery->hgallery_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hgallery_id" class="hotel_gallery_hgallery_id">
<span<?php echo $hotel_gallery->hgallery_id->ViewAttributes() ?>>
<?php echo $hotel_gallery->hgallery_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hotel_id->Visible) { // hotel_id ?>
		<td<?php echo $hotel_gallery->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hotel_id" class="hotel_gallery_hotel_id">
<span<?php echo $hotel_gallery->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_gallery->hotel_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img1->Visible) { // hg_img1 ?>
		<td<?php echo $hotel_gallery->hg_img1->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img1" class="hotel_gallery_hg_img1">
<span<?php echo $hotel_gallery->hg_img1->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img2->Visible) { // hg_img2 ?>
		<td<?php echo $hotel_gallery->hg_img2->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img2" class="hotel_gallery_hg_img2">
<span<?php echo $hotel_gallery->hg_img2->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img3->Visible) { // hg_img3 ?>
		<td<?php echo $hotel_gallery->hg_img3->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img3" class="hotel_gallery_hg_img3">
<span<?php echo $hotel_gallery->hg_img3->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img4->Visible) { // hg_img4 ?>
		<td<?php echo $hotel_gallery->hg_img4->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img4" class="hotel_gallery_hg_img4">
<span<?php echo $hotel_gallery->hg_img4->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img5->Visible) { // hg_img5 ?>
		<td<?php echo $hotel_gallery->hg_img5->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img5" class="hotel_gallery_hg_img5">
<span<?php echo $hotel_gallery->hg_img5->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img6->Visible) { // hg_img6 ?>
		<td<?php echo $hotel_gallery->hg_img6->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img6" class="hotel_gallery_hg_img6">
<span<?php echo $hotel_gallery->hg_img6->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img7->Visible) { // hg_img7 ?>
		<td<?php echo $hotel_gallery->hg_img7->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img7" class="hotel_gallery_hg_img7">
<span<?php echo $hotel_gallery->hg_img7->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img7->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img8->Visible) { // hg_img8 ?>
		<td<?php echo $hotel_gallery->hg_img8->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img8" class="hotel_gallery_hg_img8">
<span<?php echo $hotel_gallery->hg_img8->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img8->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img9->Visible) { // hg_img9 ?>
		<td<?php echo $hotel_gallery->hg_img9->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img9" class="hotel_gallery_hg_img9">
<span<?php echo $hotel_gallery->hg_img9->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img9->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img10->Visible) { // hg_img10 ?>
		<td<?php echo $hotel_gallery->hg_img10->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img10" class="hotel_gallery_hg_img10">
<span<?php echo $hotel_gallery->hg_img10->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img10->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img11->Visible) { // hg_img11 ?>
		<td<?php echo $hotel_gallery->hg_img11->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img11" class="hotel_gallery_hg_img11">
<span<?php echo $hotel_gallery->hg_img11->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img11->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img12->Visible) { // hg_img12 ?>
		<td<?php echo $hotel_gallery->hg_img12->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img12" class="hotel_gallery_hg_img12">
<span<?php echo $hotel_gallery->hg_img12->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img12->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img13->Visible) { // hg_img13 ?>
		<td<?php echo $hotel_gallery->hg_img13->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img13" class="hotel_gallery_hg_img13">
<span<?php echo $hotel_gallery->hg_img13->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img13->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img14->Visible) { // hg_img14 ?>
		<td<?php echo $hotel_gallery->hg_img14->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img14" class="hotel_gallery_hg_img14">
<span<?php echo $hotel_gallery->hg_img14->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img14->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img15->Visible) { // hg_img15 ?>
		<td<?php echo $hotel_gallery->hg_img15->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img15" class="hotel_gallery_hg_img15">
<span<?php echo $hotel_gallery->hg_img15->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img15->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img16->Visible) { // hg_img16 ?>
		<td<?php echo $hotel_gallery->hg_img16->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img16" class="hotel_gallery_hg_img16">
<span<?php echo $hotel_gallery->hg_img16->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img16->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img17->Visible) { // hg_img17 ?>
		<td<?php echo $hotel_gallery->hg_img17->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img17" class="hotel_gallery_hg_img17">
<span<?php echo $hotel_gallery->hg_img17->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img17->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img18->Visible) { // hg_img18 ?>
		<td<?php echo $hotel_gallery->hg_img18->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img18" class="hotel_gallery_hg_img18">
<span<?php echo $hotel_gallery->hg_img18->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img18->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img19->Visible) { // hg_img19 ?>
		<td<?php echo $hotel_gallery->hg_img19->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img19" class="hotel_gallery_hg_img19">
<span<?php echo $hotel_gallery->hg_img19->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img19->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img20->Visible) { // hg_img20 ?>
		<td<?php echo $hotel_gallery->hg_img20->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img20" class="hotel_gallery_hg_img20">
<span<?php echo $hotel_gallery->hg_img20->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img20->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img21->Visible) { // hg_img21 ?>
		<td<?php echo $hotel_gallery->hg_img21->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img21" class="hotel_gallery_hg_img21">
<span<?php echo $hotel_gallery->hg_img21->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img21->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img22->Visible) { // hg_img22 ?>
		<td<?php echo $hotel_gallery->hg_img22->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img22" class="hotel_gallery_hg_img22">
<span<?php echo $hotel_gallery->hg_img22->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img22->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img23->Visible) { // hg_img23 ?>
		<td<?php echo $hotel_gallery->hg_img23->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img23" class="hotel_gallery_hg_img23">
<span<?php echo $hotel_gallery->hg_img23->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img23->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->hg_img24->Visible) { // hg_img24 ?>
		<td<?php echo $hotel_gallery->hg_img24->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_hg_img24" class="hotel_gallery_hg_img24">
<span<?php echo $hotel_gallery->hg_img24->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img24->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotel_gallery->last_update->Visible) { // last_update ?>
		<td<?php echo $hotel_gallery->last_update->CellAttributes() ?>>
<span id="el<?php echo $hotel_gallery_delete->RowCnt ?>_hotel_gallery_last_update" class="hotel_gallery_last_update">
<span<?php echo $hotel_gallery->last_update->ViewAttributes() ?>>
<?php echo $hotel_gallery->last_update->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hotel_gallery_delete->Recordset->MoveNext();
}
$hotel_gallery_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotel_gallery_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhotel_gallerydelete.Init();
</script>
<?php
$hotel_gallery_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotel_gallery_delete->Page_Terminate();
?>

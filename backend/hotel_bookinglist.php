<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotel_bookinginfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotel_booking_list = NULL; // Initialize page object first

class chotel_booking_list extends chotel_booking {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_booking';

	// Page object name
	var $PageObjName = 'hotel_booking_list';

	// Grid form hidden field names
	var $FormName = 'fhotel_bookinglist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (hotel_booking)
		if (!isset($GLOBALS["hotel_booking"]) || get_class($GLOBALS["hotel_booking"]) == "chotel_booking") {
			$GLOBALS["hotel_booking"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_booking"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "hotel_bookingadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "hotel_bookingdelete.php";
		$this->MultiUpdateUrl = "hotel_bookingupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_booking', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fhotel_bookinglistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->booking_id->SetVisibility();
		$this->booking_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hroom_id->SetVisibility();
		$this->customer_id->SetVisibility();
		$this->hotel_id->SetVisibility();
		$this->room_type->SetVisibility();
		$this->max_adult->SetVisibility();
		$this->max_child->SetVisibility();
		$this->cus_email->SetVisibility();
		$this->cus_passport->SetVisibility();
		$this->cus_pickup->SetVisibility();
		$this->check_in->SetVisibility();
		$this->check_out->SetVisibility();
		$this->max_day_stay->SetVisibility();
		$this->total_amount->SetVisibility();
		$this->booking_status->SetVisibility();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $hotel_booking;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotel_booking);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 15;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 15; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 3) {
			$this->booking_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->booking_id->FormValue))
				return FALSE;
			$this->hroom_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->hroom_id->FormValue))
				return FALSE;
			$this->customer_id->setFormValue($arrKeyFlds[2]);
			if (!is_numeric($this->customer_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fhotel_bookinglistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->booking_id->AdvancedSearch->ToJSON(), ","); // Field booking_id
		$sFilterList = ew_Concat($sFilterList, $this->hroom_id->AdvancedSearch->ToJSON(), ","); // Field hroom_id
		$sFilterList = ew_Concat($sFilterList, $this->customer_id->AdvancedSearch->ToJSON(), ","); // Field customer_id
		$sFilterList = ew_Concat($sFilterList, $this->hotel_id->AdvancedSearch->ToJSON(), ","); // Field hotel_id
		$sFilterList = ew_Concat($sFilterList, $this->room_type->AdvancedSearch->ToJSON(), ","); // Field room_type
		$sFilterList = ew_Concat($sFilterList, $this->max_adult->AdvancedSearch->ToJSON(), ","); // Field max_adult
		$sFilterList = ew_Concat($sFilterList, $this->max_child->AdvancedSearch->ToJSON(), ","); // Field max_child
		$sFilterList = ew_Concat($sFilterList, $this->cus_email->AdvancedSearch->ToJSON(), ","); // Field cus_email
		$sFilterList = ew_Concat($sFilterList, $this->cus_passport->AdvancedSearch->ToJSON(), ","); // Field cus_passport
		$sFilterList = ew_Concat($sFilterList, $this->cus_pickup->AdvancedSearch->ToJSON(), ","); // Field cus_pickup
		$sFilterList = ew_Concat($sFilterList, $this->check_in->AdvancedSearch->ToJSON(), ","); // Field check_in
		$sFilterList = ew_Concat($sFilterList, $this->check_out->AdvancedSearch->ToJSON(), ","); // Field check_out
		$sFilterList = ew_Concat($sFilterList, $this->max_day_stay->AdvancedSearch->ToJSON(), ","); // Field max_day_stay
		$sFilterList = ew_Concat($sFilterList, $this->total_amount->AdvancedSearch->ToJSON(), ","); // Field total_amount
		$sFilterList = ew_Concat($sFilterList, $this->booking_status->AdvancedSearch->ToJSON(), ","); // Field booking_status
		$sFilterList = ew_Concat($sFilterList, $this->notes->AdvancedSearch->ToJSON(), ","); // Field notes
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fhotel_bookinglistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field booking_id
		$this->booking_id->AdvancedSearch->SearchValue = @$filter["x_booking_id"];
		$this->booking_id->AdvancedSearch->SearchOperator = @$filter["z_booking_id"];
		$this->booking_id->AdvancedSearch->SearchCondition = @$filter["v_booking_id"];
		$this->booking_id->AdvancedSearch->SearchValue2 = @$filter["y_booking_id"];
		$this->booking_id->AdvancedSearch->SearchOperator2 = @$filter["w_booking_id"];
		$this->booking_id->AdvancedSearch->Save();

		// Field hroom_id
		$this->hroom_id->AdvancedSearch->SearchValue = @$filter["x_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchOperator = @$filter["z_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchCondition = @$filter["v_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchValue2 = @$filter["y_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchOperator2 = @$filter["w_hroom_id"];
		$this->hroom_id->AdvancedSearch->Save();

		// Field customer_id
		$this->customer_id->AdvancedSearch->SearchValue = @$filter["x_customer_id"];
		$this->customer_id->AdvancedSearch->SearchOperator = @$filter["z_customer_id"];
		$this->customer_id->AdvancedSearch->SearchCondition = @$filter["v_customer_id"];
		$this->customer_id->AdvancedSearch->SearchValue2 = @$filter["y_customer_id"];
		$this->customer_id->AdvancedSearch->SearchOperator2 = @$filter["w_customer_id"];
		$this->customer_id->AdvancedSearch->Save();

		// Field hotel_id
		$this->hotel_id->AdvancedSearch->SearchValue = @$filter["x_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator = @$filter["z_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchCondition = @$filter["v_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchValue2 = @$filter["y_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator2 = @$filter["w_hotel_id"];
		$this->hotel_id->AdvancedSearch->Save();

		// Field room_type
		$this->room_type->AdvancedSearch->SearchValue = @$filter["x_room_type"];
		$this->room_type->AdvancedSearch->SearchOperator = @$filter["z_room_type"];
		$this->room_type->AdvancedSearch->SearchCondition = @$filter["v_room_type"];
		$this->room_type->AdvancedSearch->SearchValue2 = @$filter["y_room_type"];
		$this->room_type->AdvancedSearch->SearchOperator2 = @$filter["w_room_type"];
		$this->room_type->AdvancedSearch->Save();

		// Field max_adult
		$this->max_adult->AdvancedSearch->SearchValue = @$filter["x_max_adult"];
		$this->max_adult->AdvancedSearch->SearchOperator = @$filter["z_max_adult"];
		$this->max_adult->AdvancedSearch->SearchCondition = @$filter["v_max_adult"];
		$this->max_adult->AdvancedSearch->SearchValue2 = @$filter["y_max_adult"];
		$this->max_adult->AdvancedSearch->SearchOperator2 = @$filter["w_max_adult"];
		$this->max_adult->AdvancedSearch->Save();

		// Field max_child
		$this->max_child->AdvancedSearch->SearchValue = @$filter["x_max_child"];
		$this->max_child->AdvancedSearch->SearchOperator = @$filter["z_max_child"];
		$this->max_child->AdvancedSearch->SearchCondition = @$filter["v_max_child"];
		$this->max_child->AdvancedSearch->SearchValue2 = @$filter["y_max_child"];
		$this->max_child->AdvancedSearch->SearchOperator2 = @$filter["w_max_child"];
		$this->max_child->AdvancedSearch->Save();

		// Field cus_email
		$this->cus_email->AdvancedSearch->SearchValue = @$filter["x_cus_email"];
		$this->cus_email->AdvancedSearch->SearchOperator = @$filter["z_cus_email"];
		$this->cus_email->AdvancedSearch->SearchCondition = @$filter["v_cus_email"];
		$this->cus_email->AdvancedSearch->SearchValue2 = @$filter["y_cus_email"];
		$this->cus_email->AdvancedSearch->SearchOperator2 = @$filter["w_cus_email"];
		$this->cus_email->AdvancedSearch->Save();

		// Field cus_passport
		$this->cus_passport->AdvancedSearch->SearchValue = @$filter["x_cus_passport"];
		$this->cus_passport->AdvancedSearch->SearchOperator = @$filter["z_cus_passport"];
		$this->cus_passport->AdvancedSearch->SearchCondition = @$filter["v_cus_passport"];
		$this->cus_passport->AdvancedSearch->SearchValue2 = @$filter["y_cus_passport"];
		$this->cus_passport->AdvancedSearch->SearchOperator2 = @$filter["w_cus_passport"];
		$this->cus_passport->AdvancedSearch->Save();

		// Field cus_pickup
		$this->cus_pickup->AdvancedSearch->SearchValue = @$filter["x_cus_pickup"];
		$this->cus_pickup->AdvancedSearch->SearchOperator = @$filter["z_cus_pickup"];
		$this->cus_pickup->AdvancedSearch->SearchCondition = @$filter["v_cus_pickup"];
		$this->cus_pickup->AdvancedSearch->SearchValue2 = @$filter["y_cus_pickup"];
		$this->cus_pickup->AdvancedSearch->SearchOperator2 = @$filter["w_cus_pickup"];
		$this->cus_pickup->AdvancedSearch->Save();

		// Field check_in
		$this->check_in->AdvancedSearch->SearchValue = @$filter["x_check_in"];
		$this->check_in->AdvancedSearch->SearchOperator = @$filter["z_check_in"];
		$this->check_in->AdvancedSearch->SearchCondition = @$filter["v_check_in"];
		$this->check_in->AdvancedSearch->SearchValue2 = @$filter["y_check_in"];
		$this->check_in->AdvancedSearch->SearchOperator2 = @$filter["w_check_in"];
		$this->check_in->AdvancedSearch->Save();

		// Field check_out
		$this->check_out->AdvancedSearch->SearchValue = @$filter["x_check_out"];
		$this->check_out->AdvancedSearch->SearchOperator = @$filter["z_check_out"];
		$this->check_out->AdvancedSearch->SearchCondition = @$filter["v_check_out"];
		$this->check_out->AdvancedSearch->SearchValue2 = @$filter["y_check_out"];
		$this->check_out->AdvancedSearch->SearchOperator2 = @$filter["w_check_out"];
		$this->check_out->AdvancedSearch->Save();

		// Field max_day_stay
		$this->max_day_stay->AdvancedSearch->SearchValue = @$filter["x_max_day_stay"];
		$this->max_day_stay->AdvancedSearch->SearchOperator = @$filter["z_max_day_stay"];
		$this->max_day_stay->AdvancedSearch->SearchCondition = @$filter["v_max_day_stay"];
		$this->max_day_stay->AdvancedSearch->SearchValue2 = @$filter["y_max_day_stay"];
		$this->max_day_stay->AdvancedSearch->SearchOperator2 = @$filter["w_max_day_stay"];
		$this->max_day_stay->AdvancedSearch->Save();

		// Field total_amount
		$this->total_amount->AdvancedSearch->SearchValue = @$filter["x_total_amount"];
		$this->total_amount->AdvancedSearch->SearchOperator = @$filter["z_total_amount"];
		$this->total_amount->AdvancedSearch->SearchCondition = @$filter["v_total_amount"];
		$this->total_amount->AdvancedSearch->SearchValue2 = @$filter["y_total_amount"];
		$this->total_amount->AdvancedSearch->SearchOperator2 = @$filter["w_total_amount"];
		$this->total_amount->AdvancedSearch->Save();

		// Field booking_status
		$this->booking_status->AdvancedSearch->SearchValue = @$filter["x_booking_status"];
		$this->booking_status->AdvancedSearch->SearchOperator = @$filter["z_booking_status"];
		$this->booking_status->AdvancedSearch->SearchCondition = @$filter["v_booking_status"];
		$this->booking_status->AdvancedSearch->SearchValue2 = @$filter["y_booking_status"];
		$this->booking_status->AdvancedSearch->SearchOperator2 = @$filter["w_booking_status"];
		$this->booking_status->AdvancedSearch->Save();

		// Field notes
		$this->notes->AdvancedSearch->SearchValue = @$filter["x_notes"];
		$this->notes->AdvancedSearch->SearchOperator = @$filter["z_notes"];
		$this->notes->AdvancedSearch->SearchCondition = @$filter["v_notes"];
		$this->notes->AdvancedSearch->SearchValue2 = @$filter["y_notes"];
		$this->notes->AdvancedSearch->SearchOperator2 = @$filter["w_notes"];
		$this->notes->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->room_type, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cus_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cus_passport, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->cus_pickup, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->notes, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->booking_id); // booking_id
			$this->UpdateSort($this->hroom_id); // hroom_id
			$this->UpdateSort($this->customer_id); // customer_id
			$this->UpdateSort($this->hotel_id); // hotel_id
			$this->UpdateSort($this->room_type); // room_type
			$this->UpdateSort($this->max_adult); // max_adult
			$this->UpdateSort($this->max_child); // max_child
			$this->UpdateSort($this->cus_email); // cus_email
			$this->UpdateSort($this->cus_passport); // cus_passport
			$this->UpdateSort($this->cus_pickup); // cus_pickup
			$this->UpdateSort($this->check_in); // check_in
			$this->UpdateSort($this->check_out); // check_out
			$this->UpdateSort($this->max_day_stay); // max_day_stay
			$this->UpdateSort($this->total_amount); // total_amount
			$this->UpdateSort($this->booking_status); // booking_status
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->booking_id->setSort("");
				$this->hroom_id->setSort("");
				$this->customer_id->setSort("");
				$this->hotel_id->setSort("");
				$this->room_type->setSort("");
				$this->max_adult->setSort("");
				$this->max_child->setSort("");
				$this->cus_email->setSort("");
				$this->cus_passport->setSort("");
				$this->cus_pickup->setSort("");
				$this->check_in->setSort("");
				$this->check_out->setSort("");
				$this->max_day_stay->setSort("");
				$this->total_amount->setSort("");
				$this->booking_status->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->booking_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->hroom_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->customer_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fhotel_bookinglist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->IsLoggedIn());

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fhotel_bookinglistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fhotel_bookinglistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fhotel_bookinglist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fhotel_bookinglistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->booking_id->setDbValue($rs->fields('booking_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->room_type->setDbValue($rs->fields('room_type'));
		$this->max_adult->setDbValue($rs->fields('max_adult'));
		$this->max_child->setDbValue($rs->fields('max_child'));
		$this->cus_email->setDbValue($rs->fields('cus_email'));
		$this->cus_passport->setDbValue($rs->fields('cus_passport'));
		$this->cus_pickup->setDbValue($rs->fields('cus_pickup'));
		$this->check_in->setDbValue($rs->fields('check_in'));
		$this->check_out->setDbValue($rs->fields('check_out'));
		$this->max_day_stay->setDbValue($rs->fields('max_day_stay'));
		$this->total_amount->setDbValue($rs->fields('total_amount'));
		$this->booking_status->setDbValue($rs->fields('booking_status'));
		$this->notes->setDbValue($rs->fields('notes'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->booking_id->DbValue = $row['booking_id'];
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->customer_id->DbValue = $row['customer_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->room_type->DbValue = $row['room_type'];
		$this->max_adult->DbValue = $row['max_adult'];
		$this->max_child->DbValue = $row['max_child'];
		$this->cus_email->DbValue = $row['cus_email'];
		$this->cus_passport->DbValue = $row['cus_passport'];
		$this->cus_pickup->DbValue = $row['cus_pickup'];
		$this->check_in->DbValue = $row['check_in'];
		$this->check_out->DbValue = $row['check_out'];
		$this->max_day_stay->DbValue = $row['max_day_stay'];
		$this->total_amount->DbValue = $row['total_amount'];
		$this->booking_status->DbValue = $row['booking_status'];
		$this->notes->DbValue = $row['notes'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("booking_id")) <> "")
			$this->booking_id->CurrentValue = $this->getKey("booking_id"); // booking_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hroom_id")) <> "")
			$this->hroom_id->CurrentValue = $this->getKey("hroom_id"); // hroom_id
		else
			$bValidKey = FALSE;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->total_amount->FormValue == $this->total_amount->CurrentValue && is_numeric(ew_StrToFloat($this->total_amount->CurrentValue)))
			$this->total_amount->CurrentValue = ew_StrToFloat($this->total_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// booking_id
		// hroom_id
		// customer_id
		// hotel_id
		// room_type
		// max_adult
		// max_child
		// cus_email
		// cus_passport
		// cus_pickup
		// check_in
		// check_out
		// max_day_stay
		// total_amount
		// booking_status
		// notes

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// booking_id
		$this->booking_id->ViewValue = $this->booking_id->CurrentValue;
		$this->booking_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// room_type
		$this->room_type->ViewValue = $this->room_type->CurrentValue;
		$this->room_type->ViewCustomAttributes = "";

		// max_adult
		$this->max_adult->ViewValue = $this->max_adult->CurrentValue;
		$this->max_adult->ViewCustomAttributes = "";

		// max_child
		$this->max_child->ViewValue = $this->max_child->CurrentValue;
		$this->max_child->ViewCustomAttributes = "";

		// cus_email
		$this->cus_email->ViewValue = $this->cus_email->CurrentValue;
		$this->cus_email->ViewCustomAttributes = "";

		// cus_passport
		$this->cus_passport->ViewValue = $this->cus_passport->CurrentValue;
		$this->cus_passport->ViewCustomAttributes = "";

		// cus_pickup
		$this->cus_pickup->ViewValue = $this->cus_pickup->CurrentValue;
		$this->cus_pickup->ViewCustomAttributes = "";

		// check_in
		$this->check_in->ViewValue = $this->check_in->CurrentValue;
		$this->check_in->ViewValue = ew_FormatDateTime($this->check_in->ViewValue, 0);
		$this->check_in->ViewCustomAttributes = "";

		// check_out
		$this->check_out->ViewValue = $this->check_out->CurrentValue;
		$this->check_out->ViewValue = ew_FormatDateTime($this->check_out->ViewValue, 0);
		$this->check_out->ViewCustomAttributes = "";

		// max_day_stay
		$this->max_day_stay->ViewValue = $this->max_day_stay->CurrentValue;
		$this->max_day_stay->ViewCustomAttributes = "";

		// total_amount
		$this->total_amount->ViewValue = $this->total_amount->CurrentValue;
		$this->total_amount->ViewCustomAttributes = "";

		// booking_status
		$this->booking_status->ViewValue = $this->booking_status->CurrentValue;
		$this->booking_status->ViewCustomAttributes = "";

			// booking_id
			$this->booking_id->LinkCustomAttributes = "";
			$this->booking_id->HrefValue = "";
			$this->booking_id->TooltipValue = "";

			// hroom_id
			$this->hroom_id->LinkCustomAttributes = "";
			$this->hroom_id->HrefValue = "";
			$this->hroom_id->TooltipValue = "";

			// customer_id
			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";
			$this->customer_id->TooltipValue = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// room_type
			$this->room_type->LinkCustomAttributes = "";
			$this->room_type->HrefValue = "";
			$this->room_type->TooltipValue = "";

			// max_adult
			$this->max_adult->LinkCustomAttributes = "";
			$this->max_adult->HrefValue = "";
			$this->max_adult->TooltipValue = "";

			// max_child
			$this->max_child->LinkCustomAttributes = "";
			$this->max_child->HrefValue = "";
			$this->max_child->TooltipValue = "";

			// cus_email
			$this->cus_email->LinkCustomAttributes = "";
			$this->cus_email->HrefValue = "";
			$this->cus_email->TooltipValue = "";

			// cus_passport
			$this->cus_passport->LinkCustomAttributes = "";
			$this->cus_passport->HrefValue = "";
			$this->cus_passport->TooltipValue = "";

			// cus_pickup
			$this->cus_pickup->LinkCustomAttributes = "";
			$this->cus_pickup->HrefValue = "";
			$this->cus_pickup->TooltipValue = "";

			// check_in
			$this->check_in->LinkCustomAttributes = "";
			$this->check_in->HrefValue = "";
			$this->check_in->TooltipValue = "";

			// check_out
			$this->check_out->LinkCustomAttributes = "";
			$this->check_out->HrefValue = "";
			$this->check_out->TooltipValue = "";

			// max_day_stay
			$this->max_day_stay->LinkCustomAttributes = "";
			$this->max_day_stay->HrefValue = "";
			$this->max_day_stay->TooltipValue = "";

			// total_amount
			$this->total_amount->LinkCustomAttributes = "";
			$this->total_amount->HrefValue = "";
			$this->total_amount->TooltipValue = "";

			// booking_status
			$this->booking_status->LinkCustomAttributes = "";
			$this->booking_status->HrefValue = "";
			$this->booking_status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = TRUE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_hotel_booking\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotel_booking',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotel_bookinglist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = TRUE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		if ($this->Export == "email") {
			echo $this->ExportEmail($Doc->Text);
		} else {
			$Doc->Export();
		}
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $gTmpImages, $Language;
		$sSender = @$_POST["sender"];
		$sRecipient = @$_POST["recipient"];
		$sCc = @$_POST["cc"];
		$sBcc = @$_POST["bcc"];
		$sContentType = @$_POST["contenttype"];

		// Subject
		$sSubject = ew_StripSlashes(@$_POST["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ew_StripSlashes(@$_POST["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterSenderEmail") . "</p>";
		}
		if (!ew_CheckEmail($sSender)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperSenderEmail") . "</p>";
		}

		// Check recipient
		if (!ew_CheckEmailList($sRecipient, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperRecipientEmail") . "</p>";
		}

		// Check cc
		if (!ew_CheckEmailList($sCc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperCcEmail") . "</p>";
		}

		// Check bcc
		if (!ew_CheckEmailList($sBcc, EW_MAX_EMAIL_RECIPIENT)) {
			return "<p class=\"text-danger\">" . $Language->Phrase("EnterProperBccEmail") . "</p>";
		}

		// Check email sent count
		if (!isset($_SESSION[EW_EXPORT_EMAIL_COUNTER]))
			$_SESSION[EW_EXPORT_EMAIL_COUNTER] = 0;
		if (intval($_SESSION[EW_EXPORT_EMAIL_COUNTER]) > EW_MAX_EMAIL_SENT_COUNT) {
			return "<p class=\"text-danger\">" . $Language->Phrase("ExceedMaxEmailExport") . "</p>";
		}

		// Send email
		$Email = new cEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		if ($sEmailMessage <> "") {
			$sEmailMessage = ew_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		if ($sContentType == "url") {
			$sUrl = ew_ConvertFullUrl(ew_CurrentPage() . "?" . $this->ExportQueryString());
			$sEmailMessage .= $sUrl; // Send URL only
		} else {
			foreach ($gTmpImages as $tmpimage)
				$Email->AddEmbeddedImage($tmpimage);
			$sEmailMessage .= ew_CleanEmailContent($EmailContent); // Send HTML
		}
		$Email->Content = $sEmailMessage; // Content
		$EventArgs = array();
		if ($this->Recordset) {
			$this->RecCnt = $this->StartRec - 1;
			$this->Recordset->MoveFirst();
			if ($this->StartRec > 1)
				$this->Recordset->Move($this->StartRec - 1);
			$EventArgs["rs"] = &$this->Recordset;
		}
		$bEmailSent = FALSE;
		if ($this->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count
			$_SESSION[EW_EXPORT_EMAIL_COUNTER]++;

			// Sent email success
			return "<p class=\"text-success\">" . $Language->Phrase("SendEmailSuccess") . "</p>"; // Set up success message
		} else {

			// Sent email failure
			return "<p class=\"text-danger\">" . $Email->SendErrDescription . "</p>";
		}
	}

	// Export QueryString
	function ExportQueryString() {

		// Initialize
		$sQry = "export=html";

		// Build QueryString for search
		if ($this->BasicSearch->getKeyword() <> "") {
			$sQry .= "&" . EW_TABLE_BASIC_SEARCH . "=" . urlencode($this->BasicSearch->getKeyword()) . "&" . EW_TABLE_BASIC_SEARCH_TYPE . "=" . urlencode($this->BasicSearch->getType());
		}

		// Build QueryString for pager
		$sQry .= "&" . EW_TABLE_REC_PER_PAGE . "=" . urlencode($this->getRecordsPerPage()) . "&" . EW_TABLE_START_REC . "=" . urlencode($this->getStartRecordNumber());
		return $sQry;
	}

	// Add search QueryString
	function AddSearchQueryString(&$Qry, &$Fld) {
		$FldSearchValue = $Fld->AdvancedSearch->getValue("x");
		$FldParm = substr($Fld->FldVar,2);
		if (strval($FldSearchValue) <> "") {
			$Qry .= "&x_" . $FldParm . "=" . urlencode($FldSearchValue) .
				"&z_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("z"));
		}
		$FldSearchValue2 = $Fld->AdvancedSearch->getValue("y");
		if (strval($FldSearchValue2) <> "") {
			$Qry .= "&v_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("v")) .
				"&y_" . $FldParm . "=" . urlencode($FldSearchValue2) .
				"&w_" . $FldParm . "=" . urlencode($Fld->AdvancedSearch->getValue("w"));
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($hotel_booking_list)) $hotel_booking_list = new chotel_booking_list();

// Page init
$hotel_booking_list->Page_Init();

// Page main
$hotel_booking_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_booking_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotel_booking->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fhotel_bookinglist = new ew_Form("fhotel_bookinglist", "list");
fhotel_bookinglist.FormKeyCountName = '<?php echo $hotel_booking_list->FormKeyCountName ?>';

// Form_CustomValidate event
fhotel_bookinglist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_bookinglist.ValidateRequired = true;
<?php } else { ?>
fhotel_bookinglist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fhotel_bookinglistsrch = new ew_Form("fhotel_bookinglistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotel_booking->Export == "") { ?>
<div class="ewToolbar">
<?php if ($hotel_booking->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($hotel_booking_list->TotalRecs > 0 && $hotel_booking_list->ExportOptions->Visible()) { ?>
<?php $hotel_booking_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_booking_list->SearchOptions->Visible()) { ?>
<?php $hotel_booking_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_booking_list->FilterOptions->Visible()) { ?>
<?php $hotel_booking_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_booking->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $hotel_booking_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($hotel_booking_list->TotalRecs <= 0)
			$hotel_booking_list->TotalRecs = $hotel_booking->SelectRecordCount();
	} else {
		if (!$hotel_booking_list->Recordset && ($hotel_booking_list->Recordset = $hotel_booking_list->LoadRecordset()))
			$hotel_booking_list->TotalRecs = $hotel_booking_list->Recordset->RecordCount();
	}
	$hotel_booking_list->StartRec = 1;
	if ($hotel_booking_list->DisplayRecs <= 0 || ($hotel_booking->Export <> "" && $hotel_booking->ExportAll)) // Display all records
		$hotel_booking_list->DisplayRecs = $hotel_booking_list->TotalRecs;
	if (!($hotel_booking->Export <> "" && $hotel_booking->ExportAll))
		$hotel_booking_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$hotel_booking_list->Recordset = $hotel_booking_list->LoadRecordset($hotel_booking_list->StartRec-1, $hotel_booking_list->DisplayRecs);

	// Set no record found message
	if ($hotel_booking->CurrentAction == "" && $hotel_booking_list->TotalRecs == 0) {
		if ($hotel_booking_list->SearchWhere == "0=101")
			$hotel_booking_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$hotel_booking_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$hotel_booking_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($hotel_booking->Export == "" && $hotel_booking->CurrentAction == "") { ?>
<form name="fhotel_bookinglistsrch" id="fhotel_bookinglistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($hotel_booking_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fhotel_bookinglistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="hotel_booking">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($hotel_booking_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($hotel_booking_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $hotel_booking_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($hotel_booking_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($hotel_booking_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($hotel_booking_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($hotel_booking_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $hotel_booking_list->ShowPageHeader(); ?>
<?php
$hotel_booking_list->ShowMessage();
?>
<?php if ($hotel_booking_list->TotalRecs > 0 || $hotel_booking->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid hotel_booking">
<?php if ($hotel_booking->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($hotel_booking->CurrentAction <> "gridadd" && $hotel_booking->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_booking_list->Pager)) $hotel_booking_list->Pager = new cPrevNextPager($hotel_booking_list->StartRec, $hotel_booking_list->DisplayRecs, $hotel_booking_list->TotalRecs) ?>
<?php if ($hotel_booking_list->Pager->RecordCount > 0 && $hotel_booking_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_booking_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_booking_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_booking_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_booking_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_booking_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_booking_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotel_booking_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotel_booking_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotel_booking_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_booking_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fhotel_bookinglist" id="fhotel_bookinglist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_booking_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_booking_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_booking">
<div id="gmp_hotel_booking" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($hotel_booking_list->TotalRecs > 0 || $hotel_booking->CurrentAction == "gridedit") { ?>
<table id="tbl_hotel_bookinglist" class="table ewTable">
<?php echo $hotel_booking->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$hotel_booking_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$hotel_booking_list->RenderListOptions();

// Render list options (header, left)
$hotel_booking_list->ListOptions->Render("header", "left");
?>
<?php if ($hotel_booking->booking_id->Visible) { // booking_id ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->booking_id) == "") { ?>
		<th data-name="booking_id"><div id="elh_hotel_booking_booking_id" class="hotel_booking_booking_id"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->booking_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="booking_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->booking_id) ?>',1);"><div id="elh_hotel_booking_booking_id" class="hotel_booking_booking_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->booking_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->booking_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->booking_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->hroom_id) == "") { ?>
		<th data-name="hroom_id"><div id="elh_hotel_booking_hroom_id" class="hotel_booking_hroom_id"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->hroom_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hroom_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->hroom_id) ?>',1);"><div id="elh_hotel_booking_hroom_id" class="hotel_booking_hroom_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->hroom_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->hroom_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->hroom_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->customer_id) == "") { ?>
		<th data-name="customer_id"><div id="elh_hotel_booking_customer_id" class="hotel_booking_customer_id"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->customer_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="customer_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->customer_id) ?>',1);"><div id="elh_hotel_booking_customer_id" class="hotel_booking_customer_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->customer_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->customer_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->customer_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->hotel_id) == "") { ?>
		<th data-name="hotel_id"><div id="elh_hotel_booking_hotel_id" class="hotel_booking_hotel_id"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->hotel_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hotel_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->hotel_id) ?>',1);"><div id="elh_hotel_booking_hotel_id" class="hotel_booking_hotel_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->hotel_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->hotel_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->hotel_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->room_type) == "") { ?>
		<th data-name="room_type"><div id="elh_hotel_booking_room_type" class="hotel_booking_room_type"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->room_type->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="room_type"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->room_type) ?>',1);"><div id="elh_hotel_booking_room_type" class="hotel_booking_room_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->room_type->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->room_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->room_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->max_adult) == "") { ?>
		<th data-name="max_adult"><div id="elh_hotel_booking_max_adult" class="hotel_booking_max_adult"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->max_adult->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="max_adult"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->max_adult) ?>',1);"><div id="elh_hotel_booking_max_adult" class="hotel_booking_max_adult">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->max_adult->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->max_adult->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->max_adult->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->max_child) == "") { ?>
		<th data-name="max_child"><div id="elh_hotel_booking_max_child" class="hotel_booking_max_child"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->max_child->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="max_child"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->max_child) ?>',1);"><div id="elh_hotel_booking_max_child" class="hotel_booking_max_child">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->max_child->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->max_child->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->max_child->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->cus_email) == "") { ?>
		<th data-name="cus_email"><div id="elh_hotel_booking_cus_email" class="hotel_booking_cus_email"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cus_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->cus_email) ?>',1);"><div id="elh_hotel_booking_cus_email" class="hotel_booking_cus_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->cus_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->cus_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->cus_passport) == "") { ?>
		<th data-name="cus_passport"><div id="elh_hotel_booking_cus_passport" class="hotel_booking_cus_passport"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_passport->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cus_passport"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->cus_passport) ?>',1);"><div id="elh_hotel_booking_cus_passport" class="hotel_booking_cus_passport">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_passport->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->cus_passport->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->cus_passport->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->cus_pickup) == "") { ?>
		<th data-name="cus_pickup"><div id="elh_hotel_booking_cus_pickup" class="hotel_booking_cus_pickup"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_pickup->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cus_pickup"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->cus_pickup) ?>',1);"><div id="elh_hotel_booking_cus_pickup" class="hotel_booking_cus_pickup">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->cus_pickup->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->cus_pickup->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->cus_pickup->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->check_in) == "") { ?>
		<th data-name="check_in"><div id="elh_hotel_booking_check_in" class="hotel_booking_check_in"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->check_in->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="check_in"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->check_in) ?>',1);"><div id="elh_hotel_booking_check_in" class="hotel_booking_check_in">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->check_in->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->check_in->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->check_in->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->check_out) == "") { ?>
		<th data-name="check_out"><div id="elh_hotel_booking_check_out" class="hotel_booking_check_out"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->check_out->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="check_out"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->check_out) ?>',1);"><div id="elh_hotel_booking_check_out" class="hotel_booking_check_out">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->check_out->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->check_out->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->check_out->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->max_day_stay) == "") { ?>
		<th data-name="max_day_stay"><div id="elh_hotel_booking_max_day_stay" class="hotel_booking_max_day_stay"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->max_day_stay->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="max_day_stay"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->max_day_stay) ?>',1);"><div id="elh_hotel_booking_max_day_stay" class="hotel_booking_max_day_stay">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->max_day_stay->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->max_day_stay->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->max_day_stay->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->total_amount) == "") { ?>
		<th data-name="total_amount"><div id="elh_hotel_booking_total_amount" class="hotel_booking_total_amount"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->total_amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="total_amount"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->total_amount) ?>',1);"><div id="elh_hotel_booking_total_amount" class="hotel_booking_total_amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->total_amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->total_amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->total_amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
	<?php if ($hotel_booking->SortUrl($hotel_booking->booking_status) == "") { ?>
		<th data-name="booking_status"><div id="elh_hotel_booking_booking_status" class="hotel_booking_booking_status"><div class="ewTableHeaderCaption"><?php echo $hotel_booking->booking_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="booking_status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_booking->SortUrl($hotel_booking->booking_status) ?>',1);"><div id="elh_hotel_booking_booking_status" class="hotel_booking_booking_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_booking->booking_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_booking->booking_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_booking->booking_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$hotel_booking_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($hotel_booking->ExportAll && $hotel_booking->Export <> "") {
	$hotel_booking_list->StopRec = $hotel_booking_list->TotalRecs;
} else {

	// Set the last record to display
	if ($hotel_booking_list->TotalRecs > $hotel_booking_list->StartRec + $hotel_booking_list->DisplayRecs - 1)
		$hotel_booking_list->StopRec = $hotel_booking_list->StartRec + $hotel_booking_list->DisplayRecs - 1;
	else
		$hotel_booking_list->StopRec = $hotel_booking_list->TotalRecs;
}
$hotel_booking_list->RecCnt = $hotel_booking_list->StartRec - 1;
if ($hotel_booking_list->Recordset && !$hotel_booking_list->Recordset->EOF) {
	$hotel_booking_list->Recordset->MoveFirst();
	$bSelectLimit = $hotel_booking_list->UseSelectLimit;
	if (!$bSelectLimit && $hotel_booking_list->StartRec > 1)
		$hotel_booking_list->Recordset->Move($hotel_booking_list->StartRec - 1);
} elseif (!$hotel_booking->AllowAddDeleteRow && $hotel_booking_list->StopRec == 0) {
	$hotel_booking_list->StopRec = $hotel_booking->GridAddRowCount;
}

// Initialize aggregate
$hotel_booking->RowType = EW_ROWTYPE_AGGREGATEINIT;
$hotel_booking->ResetAttrs();
$hotel_booking_list->RenderRow();
while ($hotel_booking_list->RecCnt < $hotel_booking_list->StopRec) {
	$hotel_booking_list->RecCnt++;
	if (intval($hotel_booking_list->RecCnt) >= intval($hotel_booking_list->StartRec)) {
		$hotel_booking_list->RowCnt++;

		// Set up key count
		$hotel_booking_list->KeyCount = $hotel_booking_list->RowIndex;

		// Init row class and style
		$hotel_booking->ResetAttrs();
		$hotel_booking->CssClass = "";
		if ($hotel_booking->CurrentAction == "gridadd") {
		} else {
			$hotel_booking_list->LoadRowValues($hotel_booking_list->Recordset); // Load row values
		}
		$hotel_booking->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$hotel_booking->RowAttrs = array_merge($hotel_booking->RowAttrs, array('data-rowindex'=>$hotel_booking_list->RowCnt, 'id'=>'r' . $hotel_booking_list->RowCnt . '_hotel_booking', 'data-rowtype'=>$hotel_booking->RowType));

		// Render row
		$hotel_booking_list->RenderRow();

		// Render list options
		$hotel_booking_list->RenderListOptions();
?>
	<tr<?php echo $hotel_booking->RowAttributes() ?>>
<?php

// Render list options (body, left)
$hotel_booking_list->ListOptions->Render("body", "left", $hotel_booking_list->RowCnt);
?>
	<?php if ($hotel_booking->booking_id->Visible) { // booking_id ?>
		<td data-name="booking_id"<?php echo $hotel_booking->booking_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_booking_id" class="hotel_booking_booking_id">
<span<?php echo $hotel_booking->booking_id->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $hotel_booking_list->PageObjName . "_row_" . $hotel_booking_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
		<td data-name="hroom_id"<?php echo $hotel_booking->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_hroom_id" class="hotel_booking_hroom_id">
<span<?php echo $hotel_booking->hroom_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hroom_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
		<td data-name="customer_id"<?php echo $hotel_booking->customer_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_customer_id" class="hotel_booking_customer_id">
<span<?php echo $hotel_booking->customer_id->ViewAttributes() ?>>
<?php echo $hotel_booking->customer_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
		<td data-name="hotel_id"<?php echo $hotel_booking->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_hotel_id" class="hotel_booking_hotel_id">
<span<?php echo $hotel_booking->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hotel_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
		<td data-name="room_type"<?php echo $hotel_booking->room_type->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_room_type" class="hotel_booking_room_type">
<span<?php echo $hotel_booking->room_type->ViewAttributes() ?>>
<?php echo $hotel_booking->room_type->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
		<td data-name="max_adult"<?php echo $hotel_booking->max_adult->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_max_adult" class="hotel_booking_max_adult">
<span<?php echo $hotel_booking->max_adult->ViewAttributes() ?>>
<?php echo $hotel_booking->max_adult->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
		<td data-name="max_child"<?php echo $hotel_booking->max_child->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_max_child" class="hotel_booking_max_child">
<span<?php echo $hotel_booking->max_child->ViewAttributes() ?>>
<?php echo $hotel_booking->max_child->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
		<td data-name="cus_email"<?php echo $hotel_booking->cus_email->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_cus_email" class="hotel_booking_cus_email">
<span<?php echo $hotel_booking->cus_email->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
		<td data-name="cus_passport"<?php echo $hotel_booking->cus_passport->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_cus_passport" class="hotel_booking_cus_passport">
<span<?php echo $hotel_booking->cus_passport->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_passport->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
		<td data-name="cus_pickup"<?php echo $hotel_booking->cus_pickup->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_cus_pickup" class="hotel_booking_cus_pickup">
<span<?php echo $hotel_booking->cus_pickup->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_pickup->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
		<td data-name="check_in"<?php echo $hotel_booking->check_in->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_check_in" class="hotel_booking_check_in">
<span<?php echo $hotel_booking->check_in->ViewAttributes() ?>>
<?php echo $hotel_booking->check_in->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
		<td data-name="check_out"<?php echo $hotel_booking->check_out->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_check_out" class="hotel_booking_check_out">
<span<?php echo $hotel_booking->check_out->ViewAttributes() ?>>
<?php echo $hotel_booking->check_out->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
		<td data-name="max_day_stay"<?php echo $hotel_booking->max_day_stay->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_max_day_stay" class="hotel_booking_max_day_stay">
<span<?php echo $hotel_booking->max_day_stay->ViewAttributes() ?>>
<?php echo $hotel_booking->max_day_stay->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
		<td data-name="total_amount"<?php echo $hotel_booking->total_amount->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_total_amount" class="hotel_booking_total_amount">
<span<?php echo $hotel_booking->total_amount->ViewAttributes() ?>>
<?php echo $hotel_booking->total_amount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
		<td data-name="booking_status"<?php echo $hotel_booking->booking_status->CellAttributes() ?>>
<span id="el<?php echo $hotel_booking_list->RowCnt ?>_hotel_booking_booking_status" class="hotel_booking_booking_status">
<span<?php echo $hotel_booking->booking_status->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$hotel_booking_list->ListOptions->Render("body", "right", $hotel_booking_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($hotel_booking->CurrentAction <> "gridadd")
		$hotel_booking_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($hotel_booking->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($hotel_booking_list->Recordset)
	$hotel_booking_list->Recordset->Close();
?>
<?php if ($hotel_booking->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($hotel_booking->CurrentAction <> "gridadd" && $hotel_booking->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_booking_list->Pager)) $hotel_booking_list->Pager = new cPrevNextPager($hotel_booking_list->StartRec, $hotel_booking_list->DisplayRecs, $hotel_booking_list->TotalRecs) ?>
<?php if ($hotel_booking_list->Pager->RecordCount > 0 && $hotel_booking_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_booking_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_booking_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_booking_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_booking_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_booking_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_booking_list->PageUrl() ?>start=<?php echo $hotel_booking_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_booking_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotel_booking_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotel_booking_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotel_booking_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_booking_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($hotel_booking_list->TotalRecs == 0 && $hotel_booking->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_booking_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($hotel_booking->Export == "") { ?>
<script type="text/javascript">
fhotel_bookinglistsrch.FilterList = <?php echo $hotel_booking_list->GetFilterList() ?>;
fhotel_bookinglistsrch.Init();
fhotel_bookinglist.Init();
</script>
<?php } ?>
<?php
$hotel_booking_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($hotel_booking->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$hotel_booking_list->Page_Terminate();
?>

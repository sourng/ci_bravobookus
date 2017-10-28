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

$hotel_rooms_list = NULL; // Initialize page object first

class chotel_rooms_list extends chotel_rooms {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_rooms';

	// Page object name
	var $PageObjName = 'hotel_rooms_list';

	// Grid form hidden field names
	var $FormName = 'fhotel_roomslist';
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

		// Table object (hotel_rooms)
		if (!isset($GLOBALS["hotel_rooms"]) || get_class($GLOBALS["hotel_rooms"]) == "chotel_rooms") {
			$GLOBALS["hotel_rooms"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_rooms"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "hotel_roomsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "hotel_roomsdelete.php";
		$this->MultiUpdateUrl = "hotel_roomsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotel_rooms', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fhotel_roomslistsrch";

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
		$this->hroom_id->SetVisibility();
		$this->hroom_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hotel_id->SetVisibility();
		$this->rt_id->SetVisibility();
		$this->hr_name->SetVisibility();
		$this->hr_image->SetVisibility();
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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
			$this->hroom_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->hroom_id->FormValue))
				return FALSE;
			$this->hotel_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->hotel_id->FormValue))
				return FALSE;
			$this->rt_id->setFormValue($arrKeyFlds[2]);
			if (!is_numeric($this->rt_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fhotel_roomslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->hroom_id->AdvancedSearch->ToJSON(), ","); // Field hroom_id
		$sFilterList = ew_Concat($sFilterList, $this->hotel_id->AdvancedSearch->ToJSON(), ","); // Field hotel_id
		$sFilterList = ew_Concat($sFilterList, $this->rt_id->AdvancedSearch->ToJSON(), ","); // Field rt_id
		$sFilterList = ew_Concat($sFilterList, $this->hr_name->AdvancedSearch->ToJSON(), ","); // Field hr_name
		$sFilterList = ew_Concat($sFilterList, $this->hr_image->AdvancedSearch->ToJSON(), ","); // Field hr_image
		$sFilterList = ew_Concat($sFilterList, $this->hr_description->AdvancedSearch->ToJSON(), ","); // Field hr_description
		$sFilterList = ew_Concat($sFilterList, $this->amenities->AdvancedSearch->ToJSON(), ","); // Field amenities
		$sFilterList = ew_Concat($sFilterList, $this->hr_max->AdvancedSearch->ToJSON(), ","); // Field hr_max
		$sFilterList = ew_Concat($sFilterList, $this->hr_base_rate->AdvancedSearch->ToJSON(), ","); // Field hr_base_rate
		$sFilterList = ew_Concat($sFilterList, $this->hr_status->AdvancedSearch->ToJSON(), ","); // Field hr_status
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fhotel_roomslistsrch", $filters);

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

		// Field hroom_id
		$this->hroom_id->AdvancedSearch->SearchValue = @$filter["x_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchOperator = @$filter["z_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchCondition = @$filter["v_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchValue2 = @$filter["y_hroom_id"];
		$this->hroom_id->AdvancedSearch->SearchOperator2 = @$filter["w_hroom_id"];
		$this->hroom_id->AdvancedSearch->Save();

		// Field hotel_id
		$this->hotel_id->AdvancedSearch->SearchValue = @$filter["x_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator = @$filter["z_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchCondition = @$filter["v_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchValue2 = @$filter["y_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator2 = @$filter["w_hotel_id"];
		$this->hotel_id->AdvancedSearch->Save();

		// Field rt_id
		$this->rt_id->AdvancedSearch->SearchValue = @$filter["x_rt_id"];
		$this->rt_id->AdvancedSearch->SearchOperator = @$filter["z_rt_id"];
		$this->rt_id->AdvancedSearch->SearchCondition = @$filter["v_rt_id"];
		$this->rt_id->AdvancedSearch->SearchValue2 = @$filter["y_rt_id"];
		$this->rt_id->AdvancedSearch->SearchOperator2 = @$filter["w_rt_id"];
		$this->rt_id->AdvancedSearch->Save();

		// Field hr_name
		$this->hr_name->AdvancedSearch->SearchValue = @$filter["x_hr_name"];
		$this->hr_name->AdvancedSearch->SearchOperator = @$filter["z_hr_name"];
		$this->hr_name->AdvancedSearch->SearchCondition = @$filter["v_hr_name"];
		$this->hr_name->AdvancedSearch->SearchValue2 = @$filter["y_hr_name"];
		$this->hr_name->AdvancedSearch->SearchOperator2 = @$filter["w_hr_name"];
		$this->hr_name->AdvancedSearch->Save();

		// Field hr_image
		$this->hr_image->AdvancedSearch->SearchValue = @$filter["x_hr_image"];
		$this->hr_image->AdvancedSearch->SearchOperator = @$filter["z_hr_image"];
		$this->hr_image->AdvancedSearch->SearchCondition = @$filter["v_hr_image"];
		$this->hr_image->AdvancedSearch->SearchValue2 = @$filter["y_hr_image"];
		$this->hr_image->AdvancedSearch->SearchOperator2 = @$filter["w_hr_image"];
		$this->hr_image->AdvancedSearch->Save();

		// Field hr_description
		$this->hr_description->AdvancedSearch->SearchValue = @$filter["x_hr_description"];
		$this->hr_description->AdvancedSearch->SearchOperator = @$filter["z_hr_description"];
		$this->hr_description->AdvancedSearch->SearchCondition = @$filter["v_hr_description"];
		$this->hr_description->AdvancedSearch->SearchValue2 = @$filter["y_hr_description"];
		$this->hr_description->AdvancedSearch->SearchOperator2 = @$filter["w_hr_description"];
		$this->hr_description->AdvancedSearch->Save();

		// Field amenities
		$this->amenities->AdvancedSearch->SearchValue = @$filter["x_amenities"];
		$this->amenities->AdvancedSearch->SearchOperator = @$filter["z_amenities"];
		$this->amenities->AdvancedSearch->SearchCondition = @$filter["v_amenities"];
		$this->amenities->AdvancedSearch->SearchValue2 = @$filter["y_amenities"];
		$this->amenities->AdvancedSearch->SearchOperator2 = @$filter["w_amenities"];
		$this->amenities->AdvancedSearch->Save();

		// Field hr_max
		$this->hr_max->AdvancedSearch->SearchValue = @$filter["x_hr_max"];
		$this->hr_max->AdvancedSearch->SearchOperator = @$filter["z_hr_max"];
		$this->hr_max->AdvancedSearch->SearchCondition = @$filter["v_hr_max"];
		$this->hr_max->AdvancedSearch->SearchValue2 = @$filter["y_hr_max"];
		$this->hr_max->AdvancedSearch->SearchOperator2 = @$filter["w_hr_max"];
		$this->hr_max->AdvancedSearch->Save();

		// Field hr_base_rate
		$this->hr_base_rate->AdvancedSearch->SearchValue = @$filter["x_hr_base_rate"];
		$this->hr_base_rate->AdvancedSearch->SearchOperator = @$filter["z_hr_base_rate"];
		$this->hr_base_rate->AdvancedSearch->SearchCondition = @$filter["v_hr_base_rate"];
		$this->hr_base_rate->AdvancedSearch->SearchValue2 = @$filter["y_hr_base_rate"];
		$this->hr_base_rate->AdvancedSearch->SearchOperator2 = @$filter["w_hr_base_rate"];
		$this->hr_base_rate->AdvancedSearch->Save();

		// Field hr_status
		$this->hr_status->AdvancedSearch->SearchValue = @$filter["x_hr_status"];
		$this->hr_status->AdvancedSearch->SearchOperator = @$filter["z_hr_status"];
		$this->hr_status->AdvancedSearch->SearchCondition = @$filter["v_hr_status"];
		$this->hr_status->AdvancedSearch->SearchValue2 = @$filter["y_hr_status"];
		$this->hr_status->AdvancedSearch->SearchOperator2 = @$filter["w_hr_status"];
		$this->hr_status->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->hroom_id, $Default, FALSE); // hroom_id
		$this->BuildSearchSql($sWhere, $this->hotel_id, $Default, FALSE); // hotel_id
		$this->BuildSearchSql($sWhere, $this->rt_id, $Default, FALSE); // rt_id
		$this->BuildSearchSql($sWhere, $this->hr_name, $Default, FALSE); // hr_name
		$this->BuildSearchSql($sWhere, $this->hr_image, $Default, FALSE); // hr_image
		$this->BuildSearchSql($sWhere, $this->hr_description, $Default, FALSE); // hr_description
		$this->BuildSearchSql($sWhere, $this->amenities, $Default, FALSE); // amenities
		$this->BuildSearchSql($sWhere, $this->hr_max, $Default, FALSE); // hr_max
		$this->BuildSearchSql($sWhere, $this->hr_base_rate, $Default, FALSE); // hr_base_rate
		$this->BuildSearchSql($sWhere, $this->hr_status, $Default, FALSE); // hr_status

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->hroom_id->AdvancedSearch->Save(); // hroom_id
			$this->hotel_id->AdvancedSearch->Save(); // hotel_id
			$this->rt_id->AdvancedSearch->Save(); // rt_id
			$this->hr_name->AdvancedSearch->Save(); // hr_name
			$this->hr_image->AdvancedSearch->Save(); // hr_image
			$this->hr_description->AdvancedSearch->Save(); // hr_description
			$this->amenities->AdvancedSearch->Save(); // amenities
			$this->hr_max->AdvancedSearch->Save(); // hr_max
			$this->hr_base_rate->AdvancedSearch->Save(); // hr_base_rate
			$this->hr_status->AdvancedSearch->Save(); // hr_status
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->hr_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->hr_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->hr_description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->amenities, $arKeywords, $type);
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
		if ($this->hroom_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hotel_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->rt_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_image->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_description->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->amenities->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_max->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_base_rate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hr_status->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->hroom_id->AdvancedSearch->UnsetSession();
		$this->hotel_id->AdvancedSearch->UnsetSession();
		$this->rt_id->AdvancedSearch->UnsetSession();
		$this->hr_name->AdvancedSearch->UnsetSession();
		$this->hr_image->AdvancedSearch->UnsetSession();
		$this->hr_description->AdvancedSearch->UnsetSession();
		$this->amenities->AdvancedSearch->UnsetSession();
		$this->hr_max->AdvancedSearch->UnsetSession();
		$this->hr_base_rate->AdvancedSearch->UnsetSession();
		$this->hr_status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->hroom_id->AdvancedSearch->Load();
		$this->hotel_id->AdvancedSearch->Load();
		$this->rt_id->AdvancedSearch->Load();
		$this->hr_name->AdvancedSearch->Load();
		$this->hr_image->AdvancedSearch->Load();
		$this->hr_description->AdvancedSearch->Load();
		$this->amenities->AdvancedSearch->Load();
		$this->hr_max->AdvancedSearch->Load();
		$this->hr_base_rate->AdvancedSearch->Load();
		$this->hr_status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->hroom_id); // hroom_id
			$this->UpdateSort($this->hotel_id); // hotel_id
			$this->UpdateSort($this->rt_id); // rt_id
			$this->UpdateSort($this->hr_name); // hr_name
			$this->UpdateSort($this->hr_image); // hr_image
			$this->UpdateSort($this->hr_max); // hr_max
			$this->UpdateSort($this->hr_base_rate); // hr_base_rate
			$this->UpdateSort($this->hr_status); // hr_status
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
				$this->hroom_id->setSort("");
				$this->hotel_id->setSort("");
				$this->rt_id->setSort("");
				$this->hr_name->setSort("");
				$this->hr_image->setSort("");
				$this->hr_max->setSort("");
				$this->hr_base_rate->setSort("");
				$this->hr_status->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->hroom_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->hotel_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->rt_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fhotel_roomslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fhotel_roomslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fhotel_roomslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fhotel_roomslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fhotel_roomslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// hroom_id

		$this->hroom_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hroom_id"]);
		if ($this->hroom_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hroom_id->AdvancedSearch->SearchOperator = @$_GET["z_hroom_id"];

		// hotel_id
		$this->hotel_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hotel_id"]);
		if ($this->hotel_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hotel_id->AdvancedSearch->SearchOperator = @$_GET["z_hotel_id"];

		// rt_id
		$this->rt_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_rt_id"]);
		if ($this->rt_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->rt_id->AdvancedSearch->SearchOperator = @$_GET["z_rt_id"];

		// hr_name
		$this->hr_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_name"]);
		if ($this->hr_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_name->AdvancedSearch->SearchOperator = @$_GET["z_hr_name"];

		// hr_image
		$this->hr_image->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_image"]);
		if ($this->hr_image->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_image->AdvancedSearch->SearchOperator = @$_GET["z_hr_image"];

		// hr_description
		$this->hr_description->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_description"]);
		if ($this->hr_description->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_description->AdvancedSearch->SearchOperator = @$_GET["z_hr_description"];

		// amenities
		$this->amenities->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_amenities"]);
		if ($this->amenities->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->amenities->AdvancedSearch->SearchOperator = @$_GET["z_amenities"];

		// hr_max
		$this->hr_max->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_max"]);
		if ($this->hr_max->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_max->AdvancedSearch->SearchOperator = @$_GET["z_hr_max"];

		// hr_base_rate
		$this->hr_base_rate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_base_rate"]);
		if ($this->hr_base_rate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_base_rate->AdvancedSearch->SearchOperator = @$_GET["z_hr_base_rate"];

		// hr_status
		$this->hr_status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hr_status"]);
		if ($this->hr_status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hr_status->AdvancedSearch->SearchOperator = @$_GET["z_hr_status"];
		if (is_array($this->hr_status->AdvancedSearch->SearchValue)) $this->hr_status->AdvancedSearch->SearchValue = implode(",", $this->hr_status->AdvancedSearch->SearchValue);
		if (is_array($this->hr_status->AdvancedSearch->SearchValue2)) $this->hr_status->AdvancedSearch->SearchValue2 = implode(",", $this->hr_status->AdvancedSearch->SearchValue2);
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("hroom_id")) <> "")
			$this->hroom_id->CurrentValue = $this->getKey("hroom_id"); // hroom_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("hotel_id")) <> "")
			$this->hotel_id->CurrentValue = $this->getKey("hotel_id"); // hotel_id
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("rt_id")) <> "")
			$this->rt_id->CurrentValue = $this->getKey("rt_id"); // rt_id
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// hroom_id
			$this->hroom_id->EditAttrs["class"] = "form-control";
			$this->hroom_id->EditCustomAttributes = "";
			$this->hroom_id->EditValue = ew_HtmlEncode($this->hroom_id->AdvancedSearch->SearchValue);
			$this->hroom_id->PlaceHolder = ew_RemoveHtml($this->hroom_id->FldCaption());

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->AdvancedSearch->SearchValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// rt_id
			$this->rt_id->EditAttrs["class"] = "form-control";
			$this->rt_id->EditCustomAttributes = "";
			$this->rt_id->EditValue = ew_HtmlEncode($this->rt_id->AdvancedSearch->SearchValue);
			$this->rt_id->PlaceHolder = ew_RemoveHtml($this->rt_id->FldCaption());

			// hr_name
			$this->hr_name->EditAttrs["class"] = "form-control";
			$this->hr_name->EditCustomAttributes = "";
			$this->hr_name->EditValue = ew_HtmlEncode($this->hr_name->AdvancedSearch->SearchValue);
			$this->hr_name->PlaceHolder = ew_RemoveHtml($this->hr_name->FldCaption());

			// hr_image
			$this->hr_image->EditAttrs["class"] = "form-control";
			$this->hr_image->EditCustomAttributes = "";
			$this->hr_image->EditValue = ew_HtmlEncode($this->hr_image->AdvancedSearch->SearchValue);
			$this->hr_image->PlaceHolder = ew_RemoveHtml($this->hr_image->FldCaption());

			// hr_max
			$this->hr_max->EditAttrs["class"] = "form-control";
			$this->hr_max->EditCustomAttributes = "";
			$this->hr_max->EditValue = ew_HtmlEncode($this->hr_max->AdvancedSearch->SearchValue);
			$this->hr_max->PlaceHolder = ew_RemoveHtml($this->hr_max->FldCaption());

			// hr_base_rate
			$this->hr_base_rate->EditAttrs["class"] = "form-control";
			$this->hr_base_rate->EditCustomAttributes = "";
			$this->hr_base_rate->EditValue = ew_HtmlEncode($this->hr_base_rate->AdvancedSearch->SearchValue);
			$this->hr_base_rate->PlaceHolder = ew_RemoveHtml($this->hr_base_rate->FldCaption());

			// hr_status
			$this->hr_status->EditCustomAttributes = "";
			$this->hr_status->EditValue = $this->hr_status->Options(FALSE);
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->hroom_id->AdvancedSearch->Load();
		$this->hotel_id->AdvancedSearch->Load();
		$this->rt_id->AdvancedSearch->Load();
		$this->hr_name->AdvancedSearch->Load();
		$this->hr_image->AdvancedSearch->Load();
		$this->hr_description->AdvancedSearch->Load();
		$this->amenities->AdvancedSearch->Load();
		$this->hr_max->AdvancedSearch->Load();
		$this->hr_base_rate->AdvancedSearch->Load();
		$this->hr_status->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_hotel_rooms\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotel_rooms',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotel_roomslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$this->AddSearchQueryString($sQry, $this->hroom_id); // hroom_id
		$this->AddSearchQueryString($sQry, $this->hotel_id); // hotel_id
		$this->AddSearchQueryString($sQry, $this->rt_id); // rt_id
		$this->AddSearchQueryString($sQry, $this->hr_name); // hr_name
		$this->AddSearchQueryString($sQry, $this->hr_image); // hr_image
		$this->AddSearchQueryString($sQry, $this->hr_description); // hr_description
		$this->AddSearchQueryString($sQry, $this->amenities); // amenities
		$this->AddSearchQueryString($sQry, $this->hr_max); // hr_max
		$this->AddSearchQueryString($sQry, $this->hr_base_rate); // hr_base_rate
		$this->AddSearchQueryString($sQry, $this->hr_status); // hr_status

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
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		} 
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
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
if (!isset($hotel_rooms_list)) $hotel_rooms_list = new chotel_rooms_list();

// Page init
$hotel_rooms_list->Page_Init();

// Page main
$hotel_rooms_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_rooms_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotel_rooms->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fhotel_roomslist = new ew_Form("fhotel_roomslist", "list");
fhotel_roomslist.FormKeyCountName = '<?php echo $hotel_rooms_list->FormKeyCountName ?>';

// Form_CustomValidate event
fhotel_roomslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_roomslist.ValidateRequired = true;
<?php } else { ?>
fhotel_roomslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotel_roomslist.Lists["x_hr_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_roomslist.Lists["x_hr_status[]"].Options = <?php echo json_encode($hotel_rooms->hr_status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fhotel_roomslistsrch = new ew_Form("fhotel_roomslistsrch");

// Validate function for search
fhotel_roomslistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fhotel_roomslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_roomslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fhotel_roomslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fhotel_roomslistsrch.Lists["x_hr_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotel_roomslistsrch.Lists["x_hr_status[]"].Options = <?php echo json_encode($hotel_rooms->hr_status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotel_rooms->Export == "") { ?>
<div class="ewToolbar">
<?php if ($hotel_rooms->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($hotel_rooms_list->TotalRecs > 0 && $hotel_rooms_list->ExportOptions->Visible()) { ?>
<?php $hotel_rooms_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_rooms_list->SearchOptions->Visible()) { ?>
<?php $hotel_rooms_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_rooms_list->FilterOptions->Visible()) { ?>
<?php $hotel_rooms_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($hotel_rooms->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $hotel_rooms_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($hotel_rooms_list->TotalRecs <= 0)
			$hotel_rooms_list->TotalRecs = $hotel_rooms->SelectRecordCount();
	} else {
		if (!$hotel_rooms_list->Recordset && ($hotel_rooms_list->Recordset = $hotel_rooms_list->LoadRecordset()))
			$hotel_rooms_list->TotalRecs = $hotel_rooms_list->Recordset->RecordCount();
	}
	$hotel_rooms_list->StartRec = 1;
	if ($hotel_rooms_list->DisplayRecs <= 0 || ($hotel_rooms->Export <> "" && $hotel_rooms->ExportAll)) // Display all records
		$hotel_rooms_list->DisplayRecs = $hotel_rooms_list->TotalRecs;
	if (!($hotel_rooms->Export <> "" && $hotel_rooms->ExportAll))
		$hotel_rooms_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$hotel_rooms_list->Recordset = $hotel_rooms_list->LoadRecordset($hotel_rooms_list->StartRec-1, $hotel_rooms_list->DisplayRecs);

	// Set no record found message
	if ($hotel_rooms->CurrentAction == "" && $hotel_rooms_list->TotalRecs == 0) {
		if ($hotel_rooms_list->SearchWhere == "0=101")
			$hotel_rooms_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$hotel_rooms_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$hotel_rooms_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($hotel_rooms->Export == "" && $hotel_rooms->CurrentAction == "") { ?>
<form name="fhotel_roomslistsrch" id="fhotel_roomslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($hotel_rooms_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fhotel_roomslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="hotel_rooms">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$hotel_rooms_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$hotel_rooms->RowType = EW_ROWTYPE_SEARCH;

// Render row
$hotel_rooms->ResetAttrs();
$hotel_rooms_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($hotel_rooms->hr_status->Visible) { // hr_status ?>
	<div id="xsc_hr_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $hotel_rooms->hr_status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_hr_status" id="z_hr_status" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($hotel_rooms->hr_status->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="hotel_rooms" data-field="x_hr_status" name="x_hr_status[]" id="x_hr_status[]" value="1"<?php echo $selwrk ?><?php echo $hotel_rooms->hr_status->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($hotel_rooms_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($hotel_rooms_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $hotel_rooms_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($hotel_rooms_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($hotel_rooms_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($hotel_rooms_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($hotel_rooms_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $hotel_rooms_list->ShowPageHeader(); ?>
<?php
$hotel_rooms_list->ShowMessage();
?>
<?php if ($hotel_rooms_list->TotalRecs > 0 || $hotel_rooms->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid hotel_rooms">
<?php if ($hotel_rooms->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($hotel_rooms->CurrentAction <> "gridadd" && $hotel_rooms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_rooms_list->Pager)) $hotel_rooms_list->Pager = new cPrevNextPager($hotel_rooms_list->StartRec, $hotel_rooms_list->DisplayRecs, $hotel_rooms_list->TotalRecs) ?>
<?php if ($hotel_rooms_list->Pager->RecordCount > 0 && $hotel_rooms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_rooms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_rooms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_rooms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_rooms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_rooms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_rooms_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fhotel_roomslist" id="fhotel_roomslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_rooms_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_rooms_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_rooms">
<div id="gmp_hotel_rooms" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($hotel_rooms_list->TotalRecs > 0 || $hotel_rooms->CurrentAction == "gridedit") { ?>
<table id="tbl_hotel_roomslist" class="table ewTable">
<?php echo $hotel_rooms->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$hotel_rooms_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$hotel_rooms_list->RenderListOptions();

// Render list options (header, left)
$hotel_rooms_list->ListOptions->Render("header", "left");
?>
<?php if ($hotel_rooms->hroom_id->Visible) { // hroom_id ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hroom_id) == "") { ?>
		<th data-name="hroom_id"><div id="elh_hotel_rooms_hroom_id" class="hotel_rooms_hroom_id"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hroom_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hroom_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hroom_id) ?>',1);"><div id="elh_hotel_rooms_hroom_id" class="hotel_rooms_hroom_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hroom_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hroom_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hroom_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hotel_id->Visible) { // hotel_id ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hotel_id) == "") { ?>
		<th data-name="hotel_id"><div id="elh_hotel_rooms_hotel_id" class="hotel_rooms_hotel_id"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hotel_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hotel_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hotel_id) ?>',1);"><div id="elh_hotel_rooms_hotel_id" class="hotel_rooms_hotel_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hotel_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hotel_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hotel_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->rt_id->Visible) { // rt_id ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->rt_id) == "") { ?>
		<th data-name="rt_id"><div id="elh_hotel_rooms_rt_id" class="hotel_rooms_rt_id"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->rt_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rt_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->rt_id) ?>',1);"><div id="elh_hotel_rooms_rt_id" class="hotel_rooms_rt_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->rt_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->rt_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->rt_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hr_name->Visible) { // hr_name ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hr_name) == "") { ?>
		<th data-name="hr_name"><div id="elh_hotel_rooms_hr_name" class="hotel_rooms_hr_name"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hr_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hr_name) ?>',1);"><div id="elh_hotel_rooms_hr_name" class="hotel_rooms_hr_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hr_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hr_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hr_image->Visible) { // hr_image ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hr_image) == "") { ?>
		<th data-name="hr_image"><div id="elh_hotel_rooms_hr_image" class="hotel_rooms_hr_image"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hr_image"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hr_image) ?>',1);"><div id="elh_hotel_rooms_hr_image" class="hotel_rooms_hr_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hr_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hr_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hr_max->Visible) { // hr_max ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hr_max) == "") { ?>
		<th data-name="hr_max"><div id="elh_hotel_rooms_hr_max" class="hotel_rooms_hr_max"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_max->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hr_max"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hr_max) ?>',1);"><div id="elh_hotel_rooms_hr_max" class="hotel_rooms_hr_max">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_max->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hr_max->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hr_max->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hr_base_rate->Visible) { // hr_base_rate ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hr_base_rate) == "") { ?>
		<th data-name="hr_base_rate"><div id="elh_hotel_rooms_hr_base_rate" class="hotel_rooms_hr_base_rate"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_base_rate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hr_base_rate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hr_base_rate) ?>',1);"><div id="elh_hotel_rooms_hr_base_rate" class="hotel_rooms_hr_base_rate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_base_rate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hr_base_rate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hr_base_rate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotel_rooms->hr_status->Visible) { // hr_status ?>
	<?php if ($hotel_rooms->SortUrl($hotel_rooms->hr_status) == "") { ?>
		<th data-name="hr_status"><div id="elh_hotel_rooms_hr_status" class="hotel_rooms_hr_status"><div class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hr_status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotel_rooms->SortUrl($hotel_rooms->hr_status) ?>',1);"><div id="elh_hotel_rooms_hr_status" class="hotel_rooms_hr_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotel_rooms->hr_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotel_rooms->hr_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotel_rooms->hr_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$hotel_rooms_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($hotel_rooms->ExportAll && $hotel_rooms->Export <> "") {
	$hotel_rooms_list->StopRec = $hotel_rooms_list->TotalRecs;
} else {

	// Set the last record to display
	if ($hotel_rooms_list->TotalRecs > $hotel_rooms_list->StartRec + $hotel_rooms_list->DisplayRecs - 1)
		$hotel_rooms_list->StopRec = $hotel_rooms_list->StartRec + $hotel_rooms_list->DisplayRecs - 1;
	else
		$hotel_rooms_list->StopRec = $hotel_rooms_list->TotalRecs;
}
$hotel_rooms_list->RecCnt = $hotel_rooms_list->StartRec - 1;
if ($hotel_rooms_list->Recordset && !$hotel_rooms_list->Recordset->EOF) {
	$hotel_rooms_list->Recordset->MoveFirst();
	$bSelectLimit = $hotel_rooms_list->UseSelectLimit;
	if (!$bSelectLimit && $hotel_rooms_list->StartRec > 1)
		$hotel_rooms_list->Recordset->Move($hotel_rooms_list->StartRec - 1);
} elseif (!$hotel_rooms->AllowAddDeleteRow && $hotel_rooms_list->StopRec == 0) {
	$hotel_rooms_list->StopRec = $hotel_rooms->GridAddRowCount;
}

// Initialize aggregate
$hotel_rooms->RowType = EW_ROWTYPE_AGGREGATEINIT;
$hotel_rooms->ResetAttrs();
$hotel_rooms_list->RenderRow();
while ($hotel_rooms_list->RecCnt < $hotel_rooms_list->StopRec) {
	$hotel_rooms_list->RecCnt++;
	if (intval($hotel_rooms_list->RecCnt) >= intval($hotel_rooms_list->StartRec)) {
		$hotel_rooms_list->RowCnt++;

		// Set up key count
		$hotel_rooms_list->KeyCount = $hotel_rooms_list->RowIndex;

		// Init row class and style
		$hotel_rooms->ResetAttrs();
		$hotel_rooms->CssClass = "";
		if ($hotel_rooms->CurrentAction == "gridadd") {
		} else {
			$hotel_rooms_list->LoadRowValues($hotel_rooms_list->Recordset); // Load row values
		}
		$hotel_rooms->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$hotel_rooms->RowAttrs = array_merge($hotel_rooms->RowAttrs, array('data-rowindex'=>$hotel_rooms_list->RowCnt, 'id'=>'r' . $hotel_rooms_list->RowCnt . '_hotel_rooms', 'data-rowtype'=>$hotel_rooms->RowType));

		// Render row
		$hotel_rooms_list->RenderRow();

		// Render list options
		$hotel_rooms_list->RenderListOptions();
?>
	<tr<?php echo $hotel_rooms->RowAttributes() ?>>
<?php

// Render list options (body, left)
$hotel_rooms_list->ListOptions->Render("body", "left", $hotel_rooms_list->RowCnt);
?>
	<?php if ($hotel_rooms->hroom_id->Visible) { // hroom_id ?>
		<td data-name="hroom_id"<?php echo $hotel_rooms->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hroom_id" class="hotel_rooms_hroom_id">
<span<?php echo $hotel_rooms->hroom_id->ViewAttributes() ?>>
<?php echo $hotel_rooms->hroom_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $hotel_rooms_list->PageObjName . "_row_" . $hotel_rooms_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($hotel_rooms->hotel_id->Visible) { // hotel_id ?>
		<td data-name="hotel_id"<?php echo $hotel_rooms->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hotel_id" class="hotel_rooms_hotel_id">
<span<?php echo $hotel_rooms->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_rooms->hotel_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->rt_id->Visible) { // rt_id ?>
		<td data-name="rt_id"<?php echo $hotel_rooms->rt_id->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_rt_id" class="hotel_rooms_rt_id">
<span<?php echo $hotel_rooms->rt_id->ViewAttributes() ?>>
<?php echo $hotel_rooms->rt_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->hr_name->Visible) { // hr_name ?>
		<td data-name="hr_name"<?php echo $hotel_rooms->hr_name->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hr_name" class="hotel_rooms_hr_name">
<span<?php echo $hotel_rooms->hr_name->ViewAttributes() ?>>
<?php echo $hotel_rooms->hr_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->hr_image->Visible) { // hr_image ?>
		<td data-name="hr_image"<?php echo $hotel_rooms->hr_image->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hr_image" class="hotel_rooms_hr_image">
<span<?php echo $hotel_rooms->hr_image->ViewAttributes() ?>>
<?php echo $hotel_rooms->hr_image->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->hr_max->Visible) { // hr_max ?>
		<td data-name="hr_max"<?php echo $hotel_rooms->hr_max->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hr_max" class="hotel_rooms_hr_max">
<span<?php echo $hotel_rooms->hr_max->ViewAttributes() ?>>
<?php echo $hotel_rooms->hr_max->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->hr_base_rate->Visible) { // hr_base_rate ?>
		<td data-name="hr_base_rate"<?php echo $hotel_rooms->hr_base_rate->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hr_base_rate" class="hotel_rooms_hr_base_rate">
<span<?php echo $hotel_rooms->hr_base_rate->ViewAttributes() ?>>
<?php echo $hotel_rooms->hr_base_rate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotel_rooms->hr_status->Visible) { // hr_status ?>
		<td data-name="hr_status"<?php echo $hotel_rooms->hr_status->CellAttributes() ?>>
<span id="el<?php echo $hotel_rooms_list->RowCnt ?>_hotel_rooms_hr_status" class="hotel_rooms_hr_status">
<span<?php echo $hotel_rooms->hr_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($hotel_rooms->hr_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $hotel_rooms->hr_status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $hotel_rooms->hr_status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$hotel_rooms_list->ListOptions->Render("body", "right", $hotel_rooms_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($hotel_rooms->CurrentAction <> "gridadd")
		$hotel_rooms_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($hotel_rooms->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($hotel_rooms_list->Recordset)
	$hotel_rooms_list->Recordset->Close();
?>
<?php if ($hotel_rooms->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($hotel_rooms->CurrentAction <> "gridadd" && $hotel_rooms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_rooms_list->Pager)) $hotel_rooms_list->Pager = new cPrevNextPager($hotel_rooms_list->StartRec, $hotel_rooms_list->DisplayRecs, $hotel_rooms_list->TotalRecs) ?>
<?php if ($hotel_rooms_list->Pager->RecordCount > 0 && $hotel_rooms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_rooms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_rooms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_rooms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_rooms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_rooms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_rooms_list->PageUrl() ?>start=<?php echo $hotel_rooms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotel_rooms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_rooms_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($hotel_rooms_list->TotalRecs == 0 && $hotel_rooms->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotel_rooms_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($hotel_rooms->Export == "") { ?>
<script type="text/javascript">
fhotel_roomslistsrch.FilterList = <?php echo $hotel_rooms_list->GetFilterList() ?>;
fhotel_roomslistsrch.Init();
fhotel_roomslist.Init();
</script>
<?php } ?>
<?php
$hotel_rooms_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($hotel_rooms->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$hotel_rooms_list->Page_Terminate();
?>

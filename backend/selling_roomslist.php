<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "selling_roomsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$selling_rooms_list = NULL; // Initialize page object first

class cselling_rooms_list extends cselling_rooms {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'selling_rooms';

	// Page object name
	var $PageObjName = 'selling_rooms_list';

	// Grid form hidden field names
	var $FormName = 'fselling_roomslist';
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

		// Table object (selling_rooms)
		if (!isset($GLOBALS["selling_rooms"]) || get_class($GLOBALS["selling_rooms"]) == "cselling_rooms") {
			$GLOBALS["selling_rooms"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["selling_rooms"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "selling_roomsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "selling_roomsdelete.php";
		$this->MultiUpdateUrl = "selling_roomsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'selling_rooms', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fselling_roomslistsrch";

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
		$this->sell_room_id->SetVisibility();
		$this->sell_room_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->hroom_id->SetVisibility();
		$this->hotel_id->SetVisibility();
		$this->rt_id->SetVisibility();
		$this->sell_date->SetVisibility();
		$this->day->SetVisibility();
		$this->month->SetVisibility();
		$this->year->SetVisibility();
		$this->max_people->SetVisibility();
		$this->base_rate->SetVisibility();
		$this->discount->SetVisibility();
		$this->room_sell->SetVisibility();
		$this->room_sold->SetVisibility();
		$this->room_closed->SetVisibility();
		$this->room_status->SetVisibility();

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
		global $EW_EXPORT, $selling_rooms;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($selling_rooms);
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
		if (count($arrKeyFlds) >= 4) {
			$this->sell_room_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->sell_room_id->FormValue))
				return FALSE;
			$this->hroom_id->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->hroom_id->FormValue))
				return FALSE;
			$this->hotel_id->setFormValue($arrKeyFlds[2]);
			if (!is_numeric($this->hotel_id->FormValue))
				return FALSE;
			$this->rt_id->setFormValue($arrKeyFlds[3]);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fselling_roomslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->sell_room_id->AdvancedSearch->ToJSON(), ","); // Field sell_room_id
		$sFilterList = ew_Concat($sFilterList, $this->hroom_id->AdvancedSearch->ToJSON(), ","); // Field hroom_id
		$sFilterList = ew_Concat($sFilterList, $this->hotel_id->AdvancedSearch->ToJSON(), ","); // Field hotel_id
		$sFilterList = ew_Concat($sFilterList, $this->rt_id->AdvancedSearch->ToJSON(), ","); // Field rt_id
		$sFilterList = ew_Concat($sFilterList, $this->sell_date->AdvancedSearch->ToJSON(), ","); // Field sell_date
		$sFilterList = ew_Concat($sFilterList, $this->day->AdvancedSearch->ToJSON(), ","); // Field day
		$sFilterList = ew_Concat($sFilterList, $this->month->AdvancedSearch->ToJSON(), ","); // Field month
		$sFilterList = ew_Concat($sFilterList, $this->year->AdvancedSearch->ToJSON(), ","); // Field year
		$sFilterList = ew_Concat($sFilterList, $this->max_people->AdvancedSearch->ToJSON(), ","); // Field max_people
		$sFilterList = ew_Concat($sFilterList, $this->base_rate->AdvancedSearch->ToJSON(), ","); // Field base_rate
		$sFilterList = ew_Concat($sFilterList, $this->discount->AdvancedSearch->ToJSON(), ","); // Field discount
		$sFilterList = ew_Concat($sFilterList, $this->room_sell->AdvancedSearch->ToJSON(), ","); // Field room_sell
		$sFilterList = ew_Concat($sFilterList, $this->room_sold->AdvancedSearch->ToJSON(), ","); // Field room_sold
		$sFilterList = ew_Concat($sFilterList, $this->room_closed->AdvancedSearch->ToJSON(), ","); // Field room_closed
		$sFilterList = ew_Concat($sFilterList, $this->room_status->AdvancedSearch->ToJSON(), ","); // Field room_status
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fselling_roomslistsrch", $filters);

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

		// Field sell_room_id
		$this->sell_room_id->AdvancedSearch->SearchValue = @$filter["x_sell_room_id"];
		$this->sell_room_id->AdvancedSearch->SearchOperator = @$filter["z_sell_room_id"];
		$this->sell_room_id->AdvancedSearch->SearchCondition = @$filter["v_sell_room_id"];
		$this->sell_room_id->AdvancedSearch->SearchValue2 = @$filter["y_sell_room_id"];
		$this->sell_room_id->AdvancedSearch->SearchOperator2 = @$filter["w_sell_room_id"];
		$this->sell_room_id->AdvancedSearch->Save();

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

		// Field sell_date
		$this->sell_date->AdvancedSearch->SearchValue = @$filter["x_sell_date"];
		$this->sell_date->AdvancedSearch->SearchOperator = @$filter["z_sell_date"];
		$this->sell_date->AdvancedSearch->SearchCondition = @$filter["v_sell_date"];
		$this->sell_date->AdvancedSearch->SearchValue2 = @$filter["y_sell_date"];
		$this->sell_date->AdvancedSearch->SearchOperator2 = @$filter["w_sell_date"];
		$this->sell_date->AdvancedSearch->Save();

		// Field day
		$this->day->AdvancedSearch->SearchValue = @$filter["x_day"];
		$this->day->AdvancedSearch->SearchOperator = @$filter["z_day"];
		$this->day->AdvancedSearch->SearchCondition = @$filter["v_day"];
		$this->day->AdvancedSearch->SearchValue2 = @$filter["y_day"];
		$this->day->AdvancedSearch->SearchOperator2 = @$filter["w_day"];
		$this->day->AdvancedSearch->Save();

		// Field month
		$this->month->AdvancedSearch->SearchValue = @$filter["x_month"];
		$this->month->AdvancedSearch->SearchOperator = @$filter["z_month"];
		$this->month->AdvancedSearch->SearchCondition = @$filter["v_month"];
		$this->month->AdvancedSearch->SearchValue2 = @$filter["y_month"];
		$this->month->AdvancedSearch->SearchOperator2 = @$filter["w_month"];
		$this->month->AdvancedSearch->Save();

		// Field year
		$this->year->AdvancedSearch->SearchValue = @$filter["x_year"];
		$this->year->AdvancedSearch->SearchOperator = @$filter["z_year"];
		$this->year->AdvancedSearch->SearchCondition = @$filter["v_year"];
		$this->year->AdvancedSearch->SearchValue2 = @$filter["y_year"];
		$this->year->AdvancedSearch->SearchOperator2 = @$filter["w_year"];
		$this->year->AdvancedSearch->Save();

		// Field max_people
		$this->max_people->AdvancedSearch->SearchValue = @$filter["x_max_people"];
		$this->max_people->AdvancedSearch->SearchOperator = @$filter["z_max_people"];
		$this->max_people->AdvancedSearch->SearchCondition = @$filter["v_max_people"];
		$this->max_people->AdvancedSearch->SearchValue2 = @$filter["y_max_people"];
		$this->max_people->AdvancedSearch->SearchOperator2 = @$filter["w_max_people"];
		$this->max_people->AdvancedSearch->Save();

		// Field base_rate
		$this->base_rate->AdvancedSearch->SearchValue = @$filter["x_base_rate"];
		$this->base_rate->AdvancedSearch->SearchOperator = @$filter["z_base_rate"];
		$this->base_rate->AdvancedSearch->SearchCondition = @$filter["v_base_rate"];
		$this->base_rate->AdvancedSearch->SearchValue2 = @$filter["y_base_rate"];
		$this->base_rate->AdvancedSearch->SearchOperator2 = @$filter["w_base_rate"];
		$this->base_rate->AdvancedSearch->Save();

		// Field discount
		$this->discount->AdvancedSearch->SearchValue = @$filter["x_discount"];
		$this->discount->AdvancedSearch->SearchOperator = @$filter["z_discount"];
		$this->discount->AdvancedSearch->SearchCondition = @$filter["v_discount"];
		$this->discount->AdvancedSearch->SearchValue2 = @$filter["y_discount"];
		$this->discount->AdvancedSearch->SearchOperator2 = @$filter["w_discount"];
		$this->discount->AdvancedSearch->Save();

		// Field room_sell
		$this->room_sell->AdvancedSearch->SearchValue = @$filter["x_room_sell"];
		$this->room_sell->AdvancedSearch->SearchOperator = @$filter["z_room_sell"];
		$this->room_sell->AdvancedSearch->SearchCondition = @$filter["v_room_sell"];
		$this->room_sell->AdvancedSearch->SearchValue2 = @$filter["y_room_sell"];
		$this->room_sell->AdvancedSearch->SearchOperator2 = @$filter["w_room_sell"];
		$this->room_sell->AdvancedSearch->Save();

		// Field room_sold
		$this->room_sold->AdvancedSearch->SearchValue = @$filter["x_room_sold"];
		$this->room_sold->AdvancedSearch->SearchOperator = @$filter["z_room_sold"];
		$this->room_sold->AdvancedSearch->SearchCondition = @$filter["v_room_sold"];
		$this->room_sold->AdvancedSearch->SearchValue2 = @$filter["y_room_sold"];
		$this->room_sold->AdvancedSearch->SearchOperator2 = @$filter["w_room_sold"];
		$this->room_sold->AdvancedSearch->Save();

		// Field room_closed
		$this->room_closed->AdvancedSearch->SearchValue = @$filter["x_room_closed"];
		$this->room_closed->AdvancedSearch->SearchOperator = @$filter["z_room_closed"];
		$this->room_closed->AdvancedSearch->SearchCondition = @$filter["v_room_closed"];
		$this->room_closed->AdvancedSearch->SearchValue2 = @$filter["y_room_closed"];
		$this->room_closed->AdvancedSearch->SearchOperator2 = @$filter["w_room_closed"];
		$this->room_closed->AdvancedSearch->Save();

		// Field room_status
		$this->room_status->AdvancedSearch->SearchValue = @$filter["x_room_status"];
		$this->room_status->AdvancedSearch->SearchOperator = @$filter["z_room_status"];
		$this->room_status->AdvancedSearch->SearchCondition = @$filter["v_room_status"];
		$this->room_status->AdvancedSearch->SearchValue2 = @$filter["y_room_status"];
		$this->room_status->AdvancedSearch->SearchOperator2 = @$filter["w_room_status"];
		$this->room_status->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->sell_room_id, $Default, FALSE); // sell_room_id
		$this->BuildSearchSql($sWhere, $this->hroom_id, $Default, FALSE); // hroom_id
		$this->BuildSearchSql($sWhere, $this->hotel_id, $Default, FALSE); // hotel_id
		$this->BuildSearchSql($sWhere, $this->rt_id, $Default, FALSE); // rt_id
		$this->BuildSearchSql($sWhere, $this->sell_date, $Default, FALSE); // sell_date
		$this->BuildSearchSql($sWhere, $this->day, $Default, FALSE); // day
		$this->BuildSearchSql($sWhere, $this->month, $Default, FALSE); // month
		$this->BuildSearchSql($sWhere, $this->year, $Default, FALSE); // year
		$this->BuildSearchSql($sWhere, $this->max_people, $Default, FALSE); // max_people
		$this->BuildSearchSql($sWhere, $this->base_rate, $Default, FALSE); // base_rate
		$this->BuildSearchSql($sWhere, $this->discount, $Default, FALSE); // discount
		$this->BuildSearchSql($sWhere, $this->room_sell, $Default, FALSE); // room_sell
		$this->BuildSearchSql($sWhere, $this->room_sold, $Default, FALSE); // room_sold
		$this->BuildSearchSql($sWhere, $this->room_closed, $Default, FALSE); // room_closed
		$this->BuildSearchSql($sWhere, $this->room_status, $Default, FALSE); // room_status

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->sell_room_id->AdvancedSearch->Save(); // sell_room_id
			$this->hroom_id->AdvancedSearch->Save(); // hroom_id
			$this->hotel_id->AdvancedSearch->Save(); // hotel_id
			$this->rt_id->AdvancedSearch->Save(); // rt_id
			$this->sell_date->AdvancedSearch->Save(); // sell_date
			$this->day->AdvancedSearch->Save(); // day
			$this->month->AdvancedSearch->Save(); // month
			$this->year->AdvancedSearch->Save(); // year
			$this->max_people->AdvancedSearch->Save(); // max_people
			$this->base_rate->AdvancedSearch->Save(); // base_rate
			$this->discount->AdvancedSearch->Save(); // discount
			$this->room_sell->AdvancedSearch->Save(); // room_sell
			$this->room_sold->AdvancedSearch->Save(); // room_sold
			$this->room_closed->AdvancedSearch->Save(); // room_closed
			$this->room_status->AdvancedSearch->Save(); // room_status
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
		$this->BuildBasicSearchSQL($sWhere, $this->day, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->month, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->year, $arKeywords, $type);
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
		if ($this->sell_room_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hroom_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hotel_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->rt_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sell_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->day->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->month->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->year->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->max_people->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->base_rate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->discount->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->room_sell->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->room_sold->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->room_closed->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->room_status->AdvancedSearch->IssetSession())
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
		$this->sell_room_id->AdvancedSearch->UnsetSession();
		$this->hroom_id->AdvancedSearch->UnsetSession();
		$this->hotel_id->AdvancedSearch->UnsetSession();
		$this->rt_id->AdvancedSearch->UnsetSession();
		$this->sell_date->AdvancedSearch->UnsetSession();
		$this->day->AdvancedSearch->UnsetSession();
		$this->month->AdvancedSearch->UnsetSession();
		$this->year->AdvancedSearch->UnsetSession();
		$this->max_people->AdvancedSearch->UnsetSession();
		$this->base_rate->AdvancedSearch->UnsetSession();
		$this->discount->AdvancedSearch->UnsetSession();
		$this->room_sell->AdvancedSearch->UnsetSession();
		$this->room_sold->AdvancedSearch->UnsetSession();
		$this->room_closed->AdvancedSearch->UnsetSession();
		$this->room_status->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->sell_room_id->AdvancedSearch->Load();
		$this->hroom_id->AdvancedSearch->Load();
		$this->hotel_id->AdvancedSearch->Load();
		$this->rt_id->AdvancedSearch->Load();
		$this->sell_date->AdvancedSearch->Load();
		$this->day->AdvancedSearch->Load();
		$this->month->AdvancedSearch->Load();
		$this->year->AdvancedSearch->Load();
		$this->max_people->AdvancedSearch->Load();
		$this->base_rate->AdvancedSearch->Load();
		$this->discount->AdvancedSearch->Load();
		$this->room_sell->AdvancedSearch->Load();
		$this->room_sold->AdvancedSearch->Load();
		$this->room_closed->AdvancedSearch->Load();
		$this->room_status->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->sell_room_id); // sell_room_id
			$this->UpdateSort($this->hroom_id); // hroom_id
			$this->UpdateSort($this->hotel_id); // hotel_id
			$this->UpdateSort($this->rt_id); // rt_id
			$this->UpdateSort($this->sell_date); // sell_date
			$this->UpdateSort($this->day); // day
			$this->UpdateSort($this->month); // month
			$this->UpdateSort($this->year); // year
			$this->UpdateSort($this->max_people); // max_people
			$this->UpdateSort($this->base_rate); // base_rate
			$this->UpdateSort($this->discount); // discount
			$this->UpdateSort($this->room_sell); // room_sell
			$this->UpdateSort($this->room_sold); // room_sold
			$this->UpdateSort($this->room_closed); // room_closed
			$this->UpdateSort($this->room_status); // room_status
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
				$this->sell_room_id->setSort("");
				$this->hroom_id->setSort("");
				$this->hotel_id->setSort("");
				$this->rt_id->setSort("");
				$this->sell_date->setSort("");
				$this->day->setSort("");
				$this->month->setSort("");
				$this->year->setSort("");
				$this->max_people->setSort("");
				$this->base_rate->setSort("");
				$this->discount->setSort("");
				$this->room_sell->setSort("");
				$this->room_sold->setSort("");
				$this->room_closed->setSort("");
				$this->room_status->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->sell_room_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->hroom_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->hotel_id->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->rt_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fselling_roomslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fselling_roomslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fselling_roomslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fselling_roomslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fselling_roomslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// sell_room_id

		$this->sell_room_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sell_room_id"]);
		if ($this->sell_room_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sell_room_id->AdvancedSearch->SearchOperator = @$_GET["z_sell_room_id"];

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

		// sell_date
		$this->sell_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_sell_date"]);
		if ($this->sell_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->sell_date->AdvancedSearch->SearchOperator = @$_GET["z_sell_date"];

		// day
		$this->day->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_day"]);
		if ($this->day->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->day->AdvancedSearch->SearchOperator = @$_GET["z_day"];

		// month
		$this->month->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_month"]);
		if ($this->month->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->month->AdvancedSearch->SearchOperator = @$_GET["z_month"];

		// year
		$this->year->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_year"]);
		if ($this->year->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->year->AdvancedSearch->SearchOperator = @$_GET["z_year"];

		// max_people
		$this->max_people->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_max_people"]);
		if ($this->max_people->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->max_people->AdvancedSearch->SearchOperator = @$_GET["z_max_people"];

		// base_rate
		$this->base_rate->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_base_rate"]);
		if ($this->base_rate->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->base_rate->AdvancedSearch->SearchOperator = @$_GET["z_base_rate"];

		// discount
		$this->discount->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_discount"]);
		if ($this->discount->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->discount->AdvancedSearch->SearchOperator = @$_GET["z_discount"];

		// room_sell
		$this->room_sell->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_room_sell"]);
		if ($this->room_sell->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->room_sell->AdvancedSearch->SearchOperator = @$_GET["z_room_sell"];

		// room_sold
		$this->room_sold->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_room_sold"]);
		if ($this->room_sold->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->room_sold->AdvancedSearch->SearchOperator = @$_GET["z_room_sold"];
		if (is_array($this->room_sold->AdvancedSearch->SearchValue)) $this->room_sold->AdvancedSearch->SearchValue = implode(",", $this->room_sold->AdvancedSearch->SearchValue);
		if (is_array($this->room_sold->AdvancedSearch->SearchValue2)) $this->room_sold->AdvancedSearch->SearchValue2 = implode(",", $this->room_sold->AdvancedSearch->SearchValue2);

		// room_closed
		$this->room_closed->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_room_closed"]);
		if ($this->room_closed->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->room_closed->AdvancedSearch->SearchOperator = @$_GET["z_room_closed"];
		if (is_array($this->room_closed->AdvancedSearch->SearchValue)) $this->room_closed->AdvancedSearch->SearchValue = implode(",", $this->room_closed->AdvancedSearch->SearchValue);
		if (is_array($this->room_closed->AdvancedSearch->SearchValue2)) $this->room_closed->AdvancedSearch->SearchValue2 = implode(",", $this->room_closed->AdvancedSearch->SearchValue2);

		// room_status
		$this->room_status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_room_status"]);
		if ($this->room_status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->room_status->AdvancedSearch->SearchOperator = @$_GET["z_room_status"];
		if (is_array($this->room_status->AdvancedSearch->SearchValue)) $this->room_status->AdvancedSearch->SearchValue = implode(",", $this->room_status->AdvancedSearch->SearchValue);
		if (is_array($this->room_status->AdvancedSearch->SearchValue2)) $this->room_status->AdvancedSearch->SearchValue2 = implode(",", $this->room_status->AdvancedSearch->SearchValue2);
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
		$this->sell_room_id->setDbValue($rs->fields('sell_room_id'));
		$this->hroom_id->setDbValue($rs->fields('hroom_id'));
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->rt_id->setDbValue($rs->fields('rt_id'));
		$this->sell_date->setDbValue($rs->fields('sell_date'));
		$this->day->setDbValue($rs->fields('day'));
		$this->month->setDbValue($rs->fields('month'));
		$this->year->setDbValue($rs->fields('year'));
		$this->max_people->setDbValue($rs->fields('max_people'));
		$this->base_rate->setDbValue($rs->fields('base_rate'));
		$this->discount->setDbValue($rs->fields('discount'));
		$this->room_sell->setDbValue($rs->fields('room_sell'));
		$this->room_sold->setDbValue($rs->fields('room_sold'));
		$this->room_closed->setDbValue($rs->fields('room_closed'));
		$this->room_status->setDbValue($rs->fields('room_status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->sell_room_id->DbValue = $row['sell_room_id'];
		$this->hroom_id->DbValue = $row['hroom_id'];
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->rt_id->DbValue = $row['rt_id'];
		$this->sell_date->DbValue = $row['sell_date'];
		$this->day->DbValue = $row['day'];
		$this->month->DbValue = $row['month'];
		$this->year->DbValue = $row['year'];
		$this->max_people->DbValue = $row['max_people'];
		$this->base_rate->DbValue = $row['base_rate'];
		$this->discount->DbValue = $row['discount'];
		$this->room_sell->DbValue = $row['room_sell'];
		$this->room_sold->DbValue = $row['room_sold'];
		$this->room_closed->DbValue = $row['room_closed'];
		$this->room_status->DbValue = $row['room_status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("sell_room_id")) <> "")
			$this->sell_room_id->CurrentValue = $this->getKey("sell_room_id"); // sell_room_id
		else
			$bValidKey = FALSE;
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
		if ($this->base_rate->FormValue == $this->base_rate->CurrentValue && is_numeric(ew_StrToFloat($this->base_rate->CurrentValue)))
			$this->base_rate->CurrentValue = ew_StrToFloat($this->base_rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// sell_room_id
		// hroom_id
		// hotel_id
		// rt_id
		// sell_date
		// day
		// month
		// year
		// max_people
		// base_rate
		// discount
		// room_sell
		// room_sold
		// room_closed
		// room_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sell_room_id
		$this->sell_room_id->ViewValue = $this->sell_room_id->CurrentValue;
		$this->sell_room_id->ViewCustomAttributes = "";

		// hroom_id
		$this->hroom_id->ViewValue = $this->hroom_id->CurrentValue;
		$this->hroom_id->ViewCustomAttributes = "";

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// rt_id
		$this->rt_id->ViewValue = $this->rt_id->CurrentValue;
		$this->rt_id->ViewCustomAttributes = "";

		// sell_date
		$this->sell_date->ViewValue = $this->sell_date->CurrentValue;
		$this->sell_date->ViewValue = ew_FormatDateTime($this->sell_date->ViewValue, 0);
		$this->sell_date->ViewCustomAttributes = "";

		// day
		$this->day->ViewValue = $this->day->CurrentValue;
		$this->day->ViewCustomAttributes = "";

		// month
		$this->month->ViewValue = $this->month->CurrentValue;
		$this->month->ViewCustomAttributes = "";

		// year
		$this->year->ViewValue = $this->year->CurrentValue;
		$this->year->ViewCustomAttributes = "";

		// max_people
		$this->max_people->ViewValue = $this->max_people->CurrentValue;
		$this->max_people->ViewCustomAttributes = "";

		// base_rate
		$this->base_rate->ViewValue = $this->base_rate->CurrentValue;
		$this->base_rate->ViewCustomAttributes = "";

		// discount
		$this->discount->ViewValue = $this->discount->CurrentValue;
		$this->discount->ViewCustomAttributes = "";

		// room_sell
		$this->room_sell->ViewValue = $this->room_sell->CurrentValue;
		$this->room_sell->ViewCustomAttributes = "";

		// room_sold
		if (ew_ConvertToBool($this->room_sold->CurrentValue)) {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(1) <> "" ? $this->room_sold->FldTagCaption(1) : "Y";
		} else {
			$this->room_sold->ViewValue = $this->room_sold->FldTagCaption(2) <> "" ? $this->room_sold->FldTagCaption(2) : "N";
		}
		$this->room_sold->ViewCustomAttributes = "";

		// room_closed
		if (ew_ConvertToBool($this->room_closed->CurrentValue)) {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(1) <> "" ? $this->room_closed->FldTagCaption(1) : "Y";
		} else {
			$this->room_closed->ViewValue = $this->room_closed->FldTagCaption(2) <> "" ? $this->room_closed->FldTagCaption(2) : "N";
		}
		$this->room_closed->ViewCustomAttributes = "";

		// room_status
		if (ew_ConvertToBool($this->room_status->CurrentValue)) {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(1) <> "" ? $this->room_status->FldTagCaption(1) : "Y";
		} else {
			$this->room_status->ViewValue = $this->room_status->FldTagCaption(2) <> "" ? $this->room_status->FldTagCaption(2) : "N";
		}
		$this->room_status->ViewCustomAttributes = "";

			// sell_room_id
			$this->sell_room_id->LinkCustomAttributes = "";
			$this->sell_room_id->HrefValue = "";
			$this->sell_room_id->TooltipValue = "";

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

			// sell_date
			$this->sell_date->LinkCustomAttributes = "";
			$this->sell_date->HrefValue = "";
			$this->sell_date->TooltipValue = "";

			// day
			$this->day->LinkCustomAttributes = "";
			$this->day->HrefValue = "";
			$this->day->TooltipValue = "";

			// month
			$this->month->LinkCustomAttributes = "";
			$this->month->HrefValue = "";
			$this->month->TooltipValue = "";

			// year
			$this->year->LinkCustomAttributes = "";
			$this->year->HrefValue = "";
			$this->year->TooltipValue = "";

			// max_people
			$this->max_people->LinkCustomAttributes = "";
			$this->max_people->HrefValue = "";
			$this->max_people->TooltipValue = "";

			// base_rate
			$this->base_rate->LinkCustomAttributes = "";
			$this->base_rate->HrefValue = "";
			$this->base_rate->TooltipValue = "";

			// discount
			$this->discount->LinkCustomAttributes = "";
			$this->discount->HrefValue = "";
			$this->discount->TooltipValue = "";

			// room_sell
			$this->room_sell->LinkCustomAttributes = "";
			$this->room_sell->HrefValue = "";
			$this->room_sell->TooltipValue = "";

			// room_sold
			$this->room_sold->LinkCustomAttributes = "";
			$this->room_sold->HrefValue = "";
			$this->room_sold->TooltipValue = "";

			// room_closed
			$this->room_closed->LinkCustomAttributes = "";
			$this->room_closed->HrefValue = "";
			$this->room_closed->TooltipValue = "";

			// room_status
			$this->room_status->LinkCustomAttributes = "";
			$this->room_status->HrefValue = "";
			$this->room_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// sell_room_id
			$this->sell_room_id->EditAttrs["class"] = "form-control";
			$this->sell_room_id->EditCustomAttributes = "";
			$this->sell_room_id->EditValue = ew_HtmlEncode($this->sell_room_id->AdvancedSearch->SearchValue);
			$this->sell_room_id->PlaceHolder = ew_RemoveHtml($this->sell_room_id->FldCaption());

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

			// sell_date
			$this->sell_date->EditAttrs["class"] = "form-control";
			$this->sell_date->EditCustomAttributes = "";
			$this->sell_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->sell_date->AdvancedSearch->SearchValue, 0), 8));
			$this->sell_date->PlaceHolder = ew_RemoveHtml($this->sell_date->FldCaption());

			// day
			$this->day->EditAttrs["class"] = "form-control";
			$this->day->EditCustomAttributes = "";
			$this->day->EditValue = ew_HtmlEncode($this->day->AdvancedSearch->SearchValue);
			$this->day->PlaceHolder = ew_RemoveHtml($this->day->FldCaption());

			// month
			$this->month->EditAttrs["class"] = "form-control";
			$this->month->EditCustomAttributes = "";
			$this->month->EditValue = ew_HtmlEncode($this->month->AdvancedSearch->SearchValue);
			$this->month->PlaceHolder = ew_RemoveHtml($this->month->FldCaption());

			// year
			$this->year->EditAttrs["class"] = "form-control";
			$this->year->EditCustomAttributes = "";
			$this->year->EditValue = ew_HtmlEncode($this->year->AdvancedSearch->SearchValue);
			$this->year->PlaceHolder = ew_RemoveHtml($this->year->FldCaption());

			// max_people
			$this->max_people->EditAttrs["class"] = "form-control";
			$this->max_people->EditCustomAttributes = "";
			$this->max_people->EditValue = ew_HtmlEncode($this->max_people->AdvancedSearch->SearchValue);
			$this->max_people->PlaceHolder = ew_RemoveHtml($this->max_people->FldCaption());

			// base_rate
			$this->base_rate->EditAttrs["class"] = "form-control";
			$this->base_rate->EditCustomAttributes = "";
			$this->base_rate->EditValue = ew_HtmlEncode($this->base_rate->AdvancedSearch->SearchValue);
			$this->base_rate->PlaceHolder = ew_RemoveHtml($this->base_rate->FldCaption());

			// discount
			$this->discount->EditAttrs["class"] = "form-control";
			$this->discount->EditCustomAttributes = "";
			$this->discount->EditValue = ew_HtmlEncode($this->discount->AdvancedSearch->SearchValue);
			$this->discount->PlaceHolder = ew_RemoveHtml($this->discount->FldCaption());

			// room_sell
			$this->room_sell->EditAttrs["class"] = "form-control";
			$this->room_sell->EditCustomAttributes = "";
			$this->room_sell->EditValue = ew_HtmlEncode($this->room_sell->AdvancedSearch->SearchValue);
			$this->room_sell->PlaceHolder = ew_RemoveHtml($this->room_sell->FldCaption());

			// room_sold
			$this->room_sold->EditCustomAttributes = "";
			$this->room_sold->EditValue = $this->room_sold->Options(FALSE);

			// room_closed
			$this->room_closed->EditCustomAttributes = "";
			$this->room_closed->EditValue = $this->room_closed->Options(FALSE);

			// room_status
			$this->room_status->EditCustomAttributes = "";
			$this->room_status->EditValue = $this->room_status->Options(FALSE);
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
		$this->sell_room_id->AdvancedSearch->Load();
		$this->hroom_id->AdvancedSearch->Load();
		$this->hotel_id->AdvancedSearch->Load();
		$this->rt_id->AdvancedSearch->Load();
		$this->sell_date->AdvancedSearch->Load();
		$this->day->AdvancedSearch->Load();
		$this->month->AdvancedSearch->Load();
		$this->year->AdvancedSearch->Load();
		$this->max_people->AdvancedSearch->Load();
		$this->base_rate->AdvancedSearch->Load();
		$this->discount->AdvancedSearch->Load();
		$this->room_sell->AdvancedSearch->Load();
		$this->room_sold->AdvancedSearch->Load();
		$this->room_closed->AdvancedSearch->Load();
		$this->room_status->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_selling_rooms\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_selling_rooms',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fselling_roomslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$this->AddSearchQueryString($sQry, $this->sell_room_id); // sell_room_id
		$this->AddSearchQueryString($sQry, $this->hroom_id); // hroom_id
		$this->AddSearchQueryString($sQry, $this->hotel_id); // hotel_id
		$this->AddSearchQueryString($sQry, $this->rt_id); // rt_id
		$this->AddSearchQueryString($sQry, $this->sell_date); // sell_date
		$this->AddSearchQueryString($sQry, $this->day); // day
		$this->AddSearchQueryString($sQry, $this->month); // month
		$this->AddSearchQueryString($sQry, $this->year); // year
		$this->AddSearchQueryString($sQry, $this->max_people); // max_people
		$this->AddSearchQueryString($sQry, $this->base_rate); // base_rate
		$this->AddSearchQueryString($sQry, $this->discount); // discount
		$this->AddSearchQueryString($sQry, $this->room_sell); // room_sell
		$this->AddSearchQueryString($sQry, $this->room_sold); // room_sold
		$this->AddSearchQueryString($sQry, $this->room_closed); // room_closed
		$this->AddSearchQueryString($sQry, $this->room_status); // room_status

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
if (!isset($selling_rooms_list)) $selling_rooms_list = new cselling_rooms_list();

// Page init
$selling_rooms_list->Page_Init();

// Page main
$selling_rooms_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$selling_rooms_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($selling_rooms->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fselling_roomslist = new ew_Form("fselling_roomslist", "list");
fselling_roomslist.FormKeyCountName = '<?php echo $selling_rooms_list->FormKeyCountName ?>';

// Form_CustomValidate event
fselling_roomslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fselling_roomslist.ValidateRequired = true;
<?php } else { ?>
fselling_roomslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fselling_roomslist.Lists["x_room_sold[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslist.Lists["x_room_sold[]"].Options = <?php echo json_encode($selling_rooms->room_sold->Options()) ?>;
fselling_roomslist.Lists["x_room_closed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslist.Lists["x_room_closed[]"].Options = <?php echo json_encode($selling_rooms->room_closed->Options()) ?>;
fselling_roomslist.Lists["x_room_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslist.Lists["x_room_status[]"].Options = <?php echo json_encode($selling_rooms->room_status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fselling_roomslistsrch = new ew_Form("fselling_roomslistsrch");

// Validate function for search
fselling_roomslistsrch.Validate = function(fobj) {
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
fselling_roomslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fselling_roomslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fselling_roomslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fselling_roomslistsrch.Lists["x_room_sold[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslistsrch.Lists["x_room_sold[]"].Options = <?php echo json_encode($selling_rooms->room_sold->Options()) ?>;
fselling_roomslistsrch.Lists["x_room_closed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslistsrch.Lists["x_room_closed[]"].Options = <?php echo json_encode($selling_rooms->room_closed->Options()) ?>;
fselling_roomslistsrch.Lists["x_room_status[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fselling_roomslistsrch.Lists["x_room_status[]"].Options = <?php echo json_encode($selling_rooms->room_status->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($selling_rooms->Export == "") { ?>
<div class="ewToolbar">
<?php if ($selling_rooms->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($selling_rooms_list->TotalRecs > 0 && $selling_rooms_list->ExportOptions->Visible()) { ?>
<?php $selling_rooms_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($selling_rooms_list->SearchOptions->Visible()) { ?>
<?php $selling_rooms_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($selling_rooms_list->FilterOptions->Visible()) { ?>
<?php $selling_rooms_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($selling_rooms->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $selling_rooms_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($selling_rooms_list->TotalRecs <= 0)
			$selling_rooms_list->TotalRecs = $selling_rooms->SelectRecordCount();
	} else {
		if (!$selling_rooms_list->Recordset && ($selling_rooms_list->Recordset = $selling_rooms_list->LoadRecordset()))
			$selling_rooms_list->TotalRecs = $selling_rooms_list->Recordset->RecordCount();
	}
	$selling_rooms_list->StartRec = 1;
	if ($selling_rooms_list->DisplayRecs <= 0 || ($selling_rooms->Export <> "" && $selling_rooms->ExportAll)) // Display all records
		$selling_rooms_list->DisplayRecs = $selling_rooms_list->TotalRecs;
	if (!($selling_rooms->Export <> "" && $selling_rooms->ExportAll))
		$selling_rooms_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$selling_rooms_list->Recordset = $selling_rooms_list->LoadRecordset($selling_rooms_list->StartRec-1, $selling_rooms_list->DisplayRecs);

	// Set no record found message
	if ($selling_rooms->CurrentAction == "" && $selling_rooms_list->TotalRecs == 0) {
		if ($selling_rooms_list->SearchWhere == "0=101")
			$selling_rooms_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$selling_rooms_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$selling_rooms_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($selling_rooms->Export == "" && $selling_rooms->CurrentAction == "") { ?>
<form name="fselling_roomslistsrch" id="fselling_roomslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($selling_rooms_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fselling_roomslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="selling_rooms">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$selling_rooms_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$selling_rooms->RowType = EW_ROWTYPE_SEARCH;

// Render row
$selling_rooms->ResetAttrs();
$selling_rooms_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
	<div id="xsc_room_sold" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $selling_rooms->room_sold->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_room_sold" id="z_room_sold" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_sold->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_sold" name="x_room_sold[]" id="x_room_sold[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_sold->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
	<div id="xsc_room_closed" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $selling_rooms->room_closed->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_room_closed" id="z_room_closed" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_closed->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_closed" name="x_room_closed[]" id="x_room_closed[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_closed->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
	<div id="xsc_room_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $selling_rooms->room_status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_room_status" id="z_room_status" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($selling_rooms->room_status->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="selling_rooms" data-field="x_room_status" name="x_room_status[]" id="x_room_status[]" value="1"<?php echo $selwrk ?><?php echo $selling_rooms->room_status->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_4" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($selling_rooms_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($selling_rooms_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $selling_rooms_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($selling_rooms_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($selling_rooms_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($selling_rooms_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($selling_rooms_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $selling_rooms_list->ShowPageHeader(); ?>
<?php
$selling_rooms_list->ShowMessage();
?>
<?php if ($selling_rooms_list->TotalRecs > 0 || $selling_rooms->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid selling_rooms">
<?php if ($selling_rooms->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($selling_rooms->CurrentAction <> "gridadd" && $selling_rooms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($selling_rooms_list->Pager)) $selling_rooms_list->Pager = new cPrevNextPager($selling_rooms_list->StartRec, $selling_rooms_list->DisplayRecs, $selling_rooms_list->TotalRecs) ?>
<?php if ($selling_rooms_list->Pager->RecordCount > 0 && $selling_rooms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($selling_rooms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($selling_rooms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $selling_rooms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($selling_rooms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($selling_rooms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $selling_rooms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $selling_rooms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $selling_rooms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $selling_rooms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($selling_rooms_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fselling_roomslist" id="fselling_roomslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($selling_rooms_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $selling_rooms_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="selling_rooms">
<div id="gmp_selling_rooms" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($selling_rooms_list->TotalRecs > 0 || $selling_rooms->CurrentAction == "gridedit") { ?>
<table id="tbl_selling_roomslist" class="table ewTable">
<?php echo $selling_rooms->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$selling_rooms_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$selling_rooms_list->RenderListOptions();

// Render list options (header, left)
$selling_rooms_list->ListOptions->Render("header", "left");
?>
<?php if ($selling_rooms->sell_room_id->Visible) { // sell_room_id ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->sell_room_id) == "") { ?>
		<th data-name="sell_room_id"><div id="elh_selling_rooms_sell_room_id" class="selling_rooms_sell_room_id"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->sell_room_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sell_room_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->sell_room_id) ?>',1);"><div id="elh_selling_rooms_sell_room_id" class="selling_rooms_sell_room_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->sell_room_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->sell_room_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->sell_room_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->hroom_id->Visible) { // hroom_id ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->hroom_id) == "") { ?>
		<th data-name="hroom_id"><div id="elh_selling_rooms_hroom_id" class="selling_rooms_hroom_id"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->hroom_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hroom_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->hroom_id) ?>',1);"><div id="elh_selling_rooms_hroom_id" class="selling_rooms_hroom_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->hroom_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->hroom_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->hroom_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->hotel_id->Visible) { // hotel_id ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->hotel_id) == "") { ?>
		<th data-name="hotel_id"><div id="elh_selling_rooms_hotel_id" class="selling_rooms_hotel_id"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->hotel_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hotel_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->hotel_id) ?>',1);"><div id="elh_selling_rooms_hotel_id" class="selling_rooms_hotel_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->hotel_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->hotel_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->hotel_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->rt_id->Visible) { // rt_id ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->rt_id) == "") { ?>
		<th data-name="rt_id"><div id="elh_selling_rooms_rt_id" class="selling_rooms_rt_id"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->rt_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rt_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->rt_id) ?>',1);"><div id="elh_selling_rooms_rt_id" class="selling_rooms_rt_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->rt_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->rt_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->rt_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->sell_date->Visible) { // sell_date ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->sell_date) == "") { ?>
		<th data-name="sell_date"><div id="elh_selling_rooms_sell_date" class="selling_rooms_sell_date"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->sell_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sell_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->sell_date) ?>',1);"><div id="elh_selling_rooms_sell_date" class="selling_rooms_sell_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->sell_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->sell_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->sell_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->day->Visible) { // day ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->day) == "") { ?>
		<th data-name="day"><div id="elh_selling_rooms_day" class="selling_rooms_day"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->day->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="day"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->day) ?>',1);"><div id="elh_selling_rooms_day" class="selling_rooms_day">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->day->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->day->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->day->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->month->Visible) { // month ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->month) == "") { ?>
		<th data-name="month"><div id="elh_selling_rooms_month" class="selling_rooms_month"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->month->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="month"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->month) ?>',1);"><div id="elh_selling_rooms_month" class="selling_rooms_month">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->month->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->month->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->month->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->year->Visible) { // year ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->year) == "") { ?>
		<th data-name="year"><div id="elh_selling_rooms_year" class="selling_rooms_year"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->year->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="year"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->year) ?>',1);"><div id="elh_selling_rooms_year" class="selling_rooms_year">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->year->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->year->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->year->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->max_people->Visible) { // max_people ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->max_people) == "") { ?>
		<th data-name="max_people"><div id="elh_selling_rooms_max_people" class="selling_rooms_max_people"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->max_people->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="max_people"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->max_people) ?>',1);"><div id="elh_selling_rooms_max_people" class="selling_rooms_max_people">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->max_people->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->max_people->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->max_people->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->base_rate->Visible) { // base_rate ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->base_rate) == "") { ?>
		<th data-name="base_rate"><div id="elh_selling_rooms_base_rate" class="selling_rooms_base_rate"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->base_rate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="base_rate"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->base_rate) ?>',1);"><div id="elh_selling_rooms_base_rate" class="selling_rooms_base_rate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->base_rate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->base_rate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->base_rate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->discount->Visible) { // discount ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->discount) == "") { ?>
		<th data-name="discount"><div id="elh_selling_rooms_discount" class="selling_rooms_discount"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->discount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="discount"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->discount) ?>',1);"><div id="elh_selling_rooms_discount" class="selling_rooms_discount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->discount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->discount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->discount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->room_sell->Visible) { // room_sell ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->room_sell) == "") { ?>
		<th data-name="room_sell"><div id="elh_selling_rooms_room_sell" class="selling_rooms_room_sell"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->room_sell->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="room_sell"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->room_sell) ?>',1);"><div id="elh_selling_rooms_room_sell" class="selling_rooms_room_sell">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->room_sell->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->room_sell->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->room_sell->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->room_sold) == "") { ?>
		<th data-name="room_sold"><div id="elh_selling_rooms_room_sold" class="selling_rooms_room_sold"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->room_sold->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="room_sold"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->room_sold) ?>',1);"><div id="elh_selling_rooms_room_sold" class="selling_rooms_room_sold">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->room_sold->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->room_sold->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->room_sold->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->room_closed) == "") { ?>
		<th data-name="room_closed"><div id="elh_selling_rooms_room_closed" class="selling_rooms_room_closed"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->room_closed->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="room_closed"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->room_closed) ?>',1);"><div id="elh_selling_rooms_room_closed" class="selling_rooms_room_closed">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->room_closed->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->room_closed->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->room_closed->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
	<?php if ($selling_rooms->SortUrl($selling_rooms->room_status) == "") { ?>
		<th data-name="room_status"><div id="elh_selling_rooms_room_status" class="selling_rooms_room_status"><div class="ewTableHeaderCaption"><?php echo $selling_rooms->room_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="room_status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $selling_rooms->SortUrl($selling_rooms->room_status) ?>',1);"><div id="elh_selling_rooms_room_status" class="selling_rooms_room_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $selling_rooms->room_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($selling_rooms->room_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($selling_rooms->room_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$selling_rooms_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($selling_rooms->ExportAll && $selling_rooms->Export <> "") {
	$selling_rooms_list->StopRec = $selling_rooms_list->TotalRecs;
} else {

	// Set the last record to display
	if ($selling_rooms_list->TotalRecs > $selling_rooms_list->StartRec + $selling_rooms_list->DisplayRecs - 1)
		$selling_rooms_list->StopRec = $selling_rooms_list->StartRec + $selling_rooms_list->DisplayRecs - 1;
	else
		$selling_rooms_list->StopRec = $selling_rooms_list->TotalRecs;
}
$selling_rooms_list->RecCnt = $selling_rooms_list->StartRec - 1;
if ($selling_rooms_list->Recordset && !$selling_rooms_list->Recordset->EOF) {
	$selling_rooms_list->Recordset->MoveFirst();
	$bSelectLimit = $selling_rooms_list->UseSelectLimit;
	if (!$bSelectLimit && $selling_rooms_list->StartRec > 1)
		$selling_rooms_list->Recordset->Move($selling_rooms_list->StartRec - 1);
} elseif (!$selling_rooms->AllowAddDeleteRow && $selling_rooms_list->StopRec == 0) {
	$selling_rooms_list->StopRec = $selling_rooms->GridAddRowCount;
}

// Initialize aggregate
$selling_rooms->RowType = EW_ROWTYPE_AGGREGATEINIT;
$selling_rooms->ResetAttrs();
$selling_rooms_list->RenderRow();
while ($selling_rooms_list->RecCnt < $selling_rooms_list->StopRec) {
	$selling_rooms_list->RecCnt++;
	if (intval($selling_rooms_list->RecCnt) >= intval($selling_rooms_list->StartRec)) {
		$selling_rooms_list->RowCnt++;

		// Set up key count
		$selling_rooms_list->KeyCount = $selling_rooms_list->RowIndex;

		// Init row class and style
		$selling_rooms->ResetAttrs();
		$selling_rooms->CssClass = "";
		if ($selling_rooms->CurrentAction == "gridadd") {
		} else {
			$selling_rooms_list->LoadRowValues($selling_rooms_list->Recordset); // Load row values
		}
		$selling_rooms->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$selling_rooms->RowAttrs = array_merge($selling_rooms->RowAttrs, array('data-rowindex'=>$selling_rooms_list->RowCnt, 'id'=>'r' . $selling_rooms_list->RowCnt . '_selling_rooms', 'data-rowtype'=>$selling_rooms->RowType));

		// Render row
		$selling_rooms_list->RenderRow();

		// Render list options
		$selling_rooms_list->RenderListOptions();
?>
	<tr<?php echo $selling_rooms->RowAttributes() ?>>
<?php

// Render list options (body, left)
$selling_rooms_list->ListOptions->Render("body", "left", $selling_rooms_list->RowCnt);
?>
	<?php if ($selling_rooms->sell_room_id->Visible) { // sell_room_id ?>
		<td data-name="sell_room_id"<?php echo $selling_rooms->sell_room_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_sell_room_id" class="selling_rooms_sell_room_id">
<span<?php echo $selling_rooms->sell_room_id->ViewAttributes() ?>>
<?php echo $selling_rooms->sell_room_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $selling_rooms_list->PageObjName . "_row_" . $selling_rooms_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($selling_rooms->hroom_id->Visible) { // hroom_id ?>
		<td data-name="hroom_id"<?php echo $selling_rooms->hroom_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_hroom_id" class="selling_rooms_hroom_id">
<span<?php echo $selling_rooms->hroom_id->ViewAttributes() ?>>
<?php echo $selling_rooms->hroom_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->hotel_id->Visible) { // hotel_id ?>
		<td data-name="hotel_id"<?php echo $selling_rooms->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_hotel_id" class="selling_rooms_hotel_id">
<span<?php echo $selling_rooms->hotel_id->ViewAttributes() ?>>
<?php echo $selling_rooms->hotel_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->rt_id->Visible) { // rt_id ?>
		<td data-name="rt_id"<?php echo $selling_rooms->rt_id->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_rt_id" class="selling_rooms_rt_id">
<span<?php echo $selling_rooms->rt_id->ViewAttributes() ?>>
<?php echo $selling_rooms->rt_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->sell_date->Visible) { // sell_date ?>
		<td data-name="sell_date"<?php echo $selling_rooms->sell_date->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_sell_date" class="selling_rooms_sell_date">
<span<?php echo $selling_rooms->sell_date->ViewAttributes() ?>>
<?php echo $selling_rooms->sell_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->day->Visible) { // day ?>
		<td data-name="day"<?php echo $selling_rooms->day->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_day" class="selling_rooms_day">
<span<?php echo $selling_rooms->day->ViewAttributes() ?>>
<?php echo $selling_rooms->day->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->month->Visible) { // month ?>
		<td data-name="month"<?php echo $selling_rooms->month->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_month" class="selling_rooms_month">
<span<?php echo $selling_rooms->month->ViewAttributes() ?>>
<?php echo $selling_rooms->month->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->year->Visible) { // year ?>
		<td data-name="year"<?php echo $selling_rooms->year->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_year" class="selling_rooms_year">
<span<?php echo $selling_rooms->year->ViewAttributes() ?>>
<?php echo $selling_rooms->year->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->max_people->Visible) { // max_people ?>
		<td data-name="max_people"<?php echo $selling_rooms->max_people->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_max_people" class="selling_rooms_max_people">
<span<?php echo $selling_rooms->max_people->ViewAttributes() ?>>
<?php echo $selling_rooms->max_people->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->base_rate->Visible) { // base_rate ?>
		<td data-name="base_rate"<?php echo $selling_rooms->base_rate->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_base_rate" class="selling_rooms_base_rate">
<span<?php echo $selling_rooms->base_rate->ViewAttributes() ?>>
<?php echo $selling_rooms->base_rate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->discount->Visible) { // discount ?>
		<td data-name="discount"<?php echo $selling_rooms->discount->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_discount" class="selling_rooms_discount">
<span<?php echo $selling_rooms->discount->ViewAttributes() ?>>
<?php echo $selling_rooms->discount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->room_sell->Visible) { // room_sell ?>
		<td data-name="room_sell"<?php echo $selling_rooms->room_sell->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_room_sell" class="selling_rooms_room_sell">
<span<?php echo $selling_rooms->room_sell->ViewAttributes() ?>>
<?php echo $selling_rooms->room_sell->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->room_sold->Visible) { // room_sold ?>
		<td data-name="room_sold"<?php echo $selling_rooms->room_sold->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_room_sold" class="selling_rooms_room_sold">
<span<?php echo $selling_rooms->room_sold->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_sold->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_sold->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_sold->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->room_closed->Visible) { // room_closed ?>
		<td data-name="room_closed"<?php echo $selling_rooms->room_closed->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_room_closed" class="selling_rooms_room_closed">
<span<?php echo $selling_rooms->room_closed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_closed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_closed->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_closed->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($selling_rooms->room_status->Visible) { // room_status ?>
		<td data-name="room_status"<?php echo $selling_rooms->room_status->CellAttributes() ?>>
<span id="el<?php echo $selling_rooms_list->RowCnt ?>_selling_rooms_room_status" class="selling_rooms_room_status">
<span<?php echo $selling_rooms->room_status->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($selling_rooms->room_status->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_status->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $selling_rooms->room_status->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$selling_rooms_list->ListOptions->Render("body", "right", $selling_rooms_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($selling_rooms->CurrentAction <> "gridadd")
		$selling_rooms_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($selling_rooms->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($selling_rooms_list->Recordset)
	$selling_rooms_list->Recordset->Close();
?>
<?php if ($selling_rooms->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($selling_rooms->CurrentAction <> "gridadd" && $selling_rooms->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($selling_rooms_list->Pager)) $selling_rooms_list->Pager = new cPrevNextPager($selling_rooms_list->StartRec, $selling_rooms_list->DisplayRecs, $selling_rooms_list->TotalRecs) ?>
<?php if ($selling_rooms_list->Pager->RecordCount > 0 && $selling_rooms_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($selling_rooms_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($selling_rooms_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $selling_rooms_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($selling_rooms_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($selling_rooms_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $selling_rooms_list->PageUrl() ?>start=<?php echo $selling_rooms_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $selling_rooms_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $selling_rooms_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $selling_rooms_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $selling_rooms_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($selling_rooms_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($selling_rooms_list->TotalRecs == 0 && $selling_rooms->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($selling_rooms_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($selling_rooms->Export == "") { ?>
<script type="text/javascript">
fselling_roomslistsrch.FilterList = <?php echo $selling_rooms_list->GetFilterList() ?>;
fselling_roomslistsrch.Init();
fselling_roomslist.Init();
</script>
<?php } ?>
<?php
$selling_rooms_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($selling_rooms->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$selling_rooms_list->Page_Terminate();
?>

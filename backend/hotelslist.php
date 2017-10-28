<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "hotelsinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$hotels_list = NULL; // Initialize page object first

class chotels_list extends chotels {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotels';

	// Page object name
	var $PageObjName = 'hotels_list';

	// Grid form hidden field names
	var $FormName = 'fhotelslist';
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

		// Table object (hotels)
		if (!isset($GLOBALS["hotels"]) || get_class($GLOBALS["hotels"]) == "chotels") {
			$GLOBALS["hotels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotels"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "hotelsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "hotelsdelete.php";
		$this->MultiUpdateUrl = "hotelsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotels', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fhotelslistsrch";

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
		$this->hotel_id->SetVisibility();
		$this->hotel_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->h_name->SetVisibility();
		$this->h_slug->SetVisibility();
		$this->h_feature_image->SetVisibility();
		$this->h_address->SetVisibility();
		$this->h_create->SetVisibility();
		$this->dest_id->SetVisibility();
		$this->province->SetVisibility();
		$this->h_id_cod->SetVisibility();
		$this->h_email->SetVisibility();
		$this->h_contact_name->SetVisibility();
		$this->h_pass->SetVisibility();
		$this->h_contact_phone->SetVisibility();
		$this->h_site->SetVisibility();
		$this->contact_fax->SetVisibility();
		$this->star_rating->SetVisibility();
		$this->create_date->SetVisibility();
		$this->update_date->SetVisibility();
		$this->h_online_status->SetVisibility();
		$this->hotel_blocked->SetVisibility();

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
		global $EW_EXPORT, $hotels;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($hotels);
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
		if (count($arrKeyFlds) >= 1) {
			$this->hotel_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->hotel_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fhotelslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->hotel_id->AdvancedSearch->ToJSON(), ","); // Field hotel_id
		$sFilterList = ew_Concat($sFilterList, $this->h_name->AdvancedSearch->ToJSON(), ","); // Field h_name
		$sFilterList = ew_Concat($sFilterList, $this->h_slug->AdvancedSearch->ToJSON(), ","); // Field h_slug
		$sFilterList = ew_Concat($sFilterList, $this->h_feature_image->AdvancedSearch->ToJSON(), ","); // Field h_feature_image
		$sFilterList = ew_Concat($sFilterList, $this->h_description->AdvancedSearch->ToJSON(), ","); // Field h_description
		$sFilterList = ew_Concat($sFilterList, $this->h_meta_key->AdvancedSearch->ToJSON(), ","); // Field h_meta_key
		$sFilterList = ew_Concat($sFilterList, $this->h_deatail->AdvancedSearch->ToJSON(), ","); // Field h_deatail
		$sFilterList = ew_Concat($sFilterList, $this->h_facilities->AdvancedSearch->ToJSON(), ","); // Field h_facilities
		$sFilterList = ew_Concat($sFilterList, $this->h_address->AdvancedSearch->ToJSON(), ","); // Field h_address
		$sFilterList = ew_Concat($sFilterList, $this->h_create->AdvancedSearch->ToJSON(), ","); // Field h_create
		$sFilterList = ew_Concat($sFilterList, $this->dest_id->AdvancedSearch->ToJSON(), ","); // Field dest_id
		$sFilterList = ew_Concat($sFilterList, $this->province->AdvancedSearch->ToJSON(), ","); // Field province
		$sFilterList = ew_Concat($sFilterList, $this->whylike->AdvancedSearch->ToJSON(), ","); // Field whylike
		$sFilterList = ew_Concat($sFilterList, $this->lang_spoken->AdvancedSearch->ToJSON(), ","); // Field lang_spoken
		$sFilterList = ew_Concat($sFilterList, $this->map->AdvancedSearch->ToJSON(), ","); // Field map
		$sFilterList = ew_Concat($sFilterList, $this->what_todo->AdvancedSearch->ToJSON(), ","); // Field what_todo
		$sFilterList = ew_Concat($sFilterList, $this->h_id_cod->AdvancedSearch->ToJSON(), ","); // Field h_id_cod
		$sFilterList = ew_Concat($sFilterList, $this->h_email->AdvancedSearch->ToJSON(), ","); // Field h_email
		$sFilterList = ew_Concat($sFilterList, $this->h_contact_name->AdvancedSearch->ToJSON(), ","); // Field h_contact_name
		$sFilterList = ew_Concat($sFilterList, $this->h_pass->AdvancedSearch->ToJSON(), ","); // Field h_pass
		$sFilterList = ew_Concat($sFilterList, $this->h_contact_phone->AdvancedSearch->ToJSON(), ","); // Field h_contact_phone
		$sFilterList = ew_Concat($sFilterList, $this->h_site->AdvancedSearch->ToJSON(), ","); // Field h_site
		$sFilterList = ew_Concat($sFilterList, $this->contact_fax->AdvancedSearch->ToJSON(), ","); // Field contact_fax
		$sFilterList = ew_Concat($sFilterList, $this->star_rating->AdvancedSearch->ToJSON(), ","); // Field star_rating
		$sFilterList = ew_Concat($sFilterList, $this->create_date->AdvancedSearch->ToJSON(), ","); // Field create_date
		$sFilterList = ew_Concat($sFilterList, $this->update_date->AdvancedSearch->ToJSON(), ","); // Field update_date
		$sFilterList = ew_Concat($sFilterList, $this->h_online_status->AdvancedSearch->ToJSON(), ","); // Field h_online_status
		$sFilterList = ew_Concat($sFilterList, $this->hotel_blocked->AdvancedSearch->ToJSON(), ","); // Field hotel_blocked
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fhotelslistsrch", $filters);

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

		// Field hotel_id
		$this->hotel_id->AdvancedSearch->SearchValue = @$filter["x_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator = @$filter["z_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchCondition = @$filter["v_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchValue2 = @$filter["y_hotel_id"];
		$this->hotel_id->AdvancedSearch->SearchOperator2 = @$filter["w_hotel_id"];
		$this->hotel_id->AdvancedSearch->Save();

		// Field h_name
		$this->h_name->AdvancedSearch->SearchValue = @$filter["x_h_name"];
		$this->h_name->AdvancedSearch->SearchOperator = @$filter["z_h_name"];
		$this->h_name->AdvancedSearch->SearchCondition = @$filter["v_h_name"];
		$this->h_name->AdvancedSearch->SearchValue2 = @$filter["y_h_name"];
		$this->h_name->AdvancedSearch->SearchOperator2 = @$filter["w_h_name"];
		$this->h_name->AdvancedSearch->Save();

		// Field h_slug
		$this->h_slug->AdvancedSearch->SearchValue = @$filter["x_h_slug"];
		$this->h_slug->AdvancedSearch->SearchOperator = @$filter["z_h_slug"];
		$this->h_slug->AdvancedSearch->SearchCondition = @$filter["v_h_slug"];
		$this->h_slug->AdvancedSearch->SearchValue2 = @$filter["y_h_slug"];
		$this->h_slug->AdvancedSearch->SearchOperator2 = @$filter["w_h_slug"];
		$this->h_slug->AdvancedSearch->Save();

		// Field h_feature_image
		$this->h_feature_image->AdvancedSearch->SearchValue = @$filter["x_h_feature_image"];
		$this->h_feature_image->AdvancedSearch->SearchOperator = @$filter["z_h_feature_image"];
		$this->h_feature_image->AdvancedSearch->SearchCondition = @$filter["v_h_feature_image"];
		$this->h_feature_image->AdvancedSearch->SearchValue2 = @$filter["y_h_feature_image"];
		$this->h_feature_image->AdvancedSearch->SearchOperator2 = @$filter["w_h_feature_image"];
		$this->h_feature_image->AdvancedSearch->Save();

		// Field h_description
		$this->h_description->AdvancedSearch->SearchValue = @$filter["x_h_description"];
		$this->h_description->AdvancedSearch->SearchOperator = @$filter["z_h_description"];
		$this->h_description->AdvancedSearch->SearchCondition = @$filter["v_h_description"];
		$this->h_description->AdvancedSearch->SearchValue2 = @$filter["y_h_description"];
		$this->h_description->AdvancedSearch->SearchOperator2 = @$filter["w_h_description"];
		$this->h_description->AdvancedSearch->Save();

		// Field h_meta_key
		$this->h_meta_key->AdvancedSearch->SearchValue = @$filter["x_h_meta_key"];
		$this->h_meta_key->AdvancedSearch->SearchOperator = @$filter["z_h_meta_key"];
		$this->h_meta_key->AdvancedSearch->SearchCondition = @$filter["v_h_meta_key"];
		$this->h_meta_key->AdvancedSearch->SearchValue2 = @$filter["y_h_meta_key"];
		$this->h_meta_key->AdvancedSearch->SearchOperator2 = @$filter["w_h_meta_key"];
		$this->h_meta_key->AdvancedSearch->Save();

		// Field h_deatail
		$this->h_deatail->AdvancedSearch->SearchValue = @$filter["x_h_deatail"];
		$this->h_deatail->AdvancedSearch->SearchOperator = @$filter["z_h_deatail"];
		$this->h_deatail->AdvancedSearch->SearchCondition = @$filter["v_h_deatail"];
		$this->h_deatail->AdvancedSearch->SearchValue2 = @$filter["y_h_deatail"];
		$this->h_deatail->AdvancedSearch->SearchOperator2 = @$filter["w_h_deatail"];
		$this->h_deatail->AdvancedSearch->Save();

		// Field h_facilities
		$this->h_facilities->AdvancedSearch->SearchValue = @$filter["x_h_facilities"];
		$this->h_facilities->AdvancedSearch->SearchOperator = @$filter["z_h_facilities"];
		$this->h_facilities->AdvancedSearch->SearchCondition = @$filter["v_h_facilities"];
		$this->h_facilities->AdvancedSearch->SearchValue2 = @$filter["y_h_facilities"];
		$this->h_facilities->AdvancedSearch->SearchOperator2 = @$filter["w_h_facilities"];
		$this->h_facilities->AdvancedSearch->Save();

		// Field h_address
		$this->h_address->AdvancedSearch->SearchValue = @$filter["x_h_address"];
		$this->h_address->AdvancedSearch->SearchOperator = @$filter["z_h_address"];
		$this->h_address->AdvancedSearch->SearchCondition = @$filter["v_h_address"];
		$this->h_address->AdvancedSearch->SearchValue2 = @$filter["y_h_address"];
		$this->h_address->AdvancedSearch->SearchOperator2 = @$filter["w_h_address"];
		$this->h_address->AdvancedSearch->Save();

		// Field h_create
		$this->h_create->AdvancedSearch->SearchValue = @$filter["x_h_create"];
		$this->h_create->AdvancedSearch->SearchOperator = @$filter["z_h_create"];
		$this->h_create->AdvancedSearch->SearchCondition = @$filter["v_h_create"];
		$this->h_create->AdvancedSearch->SearchValue2 = @$filter["y_h_create"];
		$this->h_create->AdvancedSearch->SearchOperator2 = @$filter["w_h_create"];
		$this->h_create->AdvancedSearch->Save();

		// Field dest_id
		$this->dest_id->AdvancedSearch->SearchValue = @$filter["x_dest_id"];
		$this->dest_id->AdvancedSearch->SearchOperator = @$filter["z_dest_id"];
		$this->dest_id->AdvancedSearch->SearchCondition = @$filter["v_dest_id"];
		$this->dest_id->AdvancedSearch->SearchValue2 = @$filter["y_dest_id"];
		$this->dest_id->AdvancedSearch->SearchOperator2 = @$filter["w_dest_id"];
		$this->dest_id->AdvancedSearch->Save();

		// Field province
		$this->province->AdvancedSearch->SearchValue = @$filter["x_province"];
		$this->province->AdvancedSearch->SearchOperator = @$filter["z_province"];
		$this->province->AdvancedSearch->SearchCondition = @$filter["v_province"];
		$this->province->AdvancedSearch->SearchValue2 = @$filter["y_province"];
		$this->province->AdvancedSearch->SearchOperator2 = @$filter["w_province"];
		$this->province->AdvancedSearch->Save();

		// Field whylike
		$this->whylike->AdvancedSearch->SearchValue = @$filter["x_whylike"];
		$this->whylike->AdvancedSearch->SearchOperator = @$filter["z_whylike"];
		$this->whylike->AdvancedSearch->SearchCondition = @$filter["v_whylike"];
		$this->whylike->AdvancedSearch->SearchValue2 = @$filter["y_whylike"];
		$this->whylike->AdvancedSearch->SearchOperator2 = @$filter["w_whylike"];
		$this->whylike->AdvancedSearch->Save();

		// Field lang_spoken
		$this->lang_spoken->AdvancedSearch->SearchValue = @$filter["x_lang_spoken"];
		$this->lang_spoken->AdvancedSearch->SearchOperator = @$filter["z_lang_spoken"];
		$this->lang_spoken->AdvancedSearch->SearchCondition = @$filter["v_lang_spoken"];
		$this->lang_spoken->AdvancedSearch->SearchValue2 = @$filter["y_lang_spoken"];
		$this->lang_spoken->AdvancedSearch->SearchOperator2 = @$filter["w_lang_spoken"];
		$this->lang_spoken->AdvancedSearch->Save();

		// Field map
		$this->map->AdvancedSearch->SearchValue = @$filter["x_map"];
		$this->map->AdvancedSearch->SearchOperator = @$filter["z_map"];
		$this->map->AdvancedSearch->SearchCondition = @$filter["v_map"];
		$this->map->AdvancedSearch->SearchValue2 = @$filter["y_map"];
		$this->map->AdvancedSearch->SearchOperator2 = @$filter["w_map"];
		$this->map->AdvancedSearch->Save();

		// Field what_todo
		$this->what_todo->AdvancedSearch->SearchValue = @$filter["x_what_todo"];
		$this->what_todo->AdvancedSearch->SearchOperator = @$filter["z_what_todo"];
		$this->what_todo->AdvancedSearch->SearchCondition = @$filter["v_what_todo"];
		$this->what_todo->AdvancedSearch->SearchValue2 = @$filter["y_what_todo"];
		$this->what_todo->AdvancedSearch->SearchOperator2 = @$filter["w_what_todo"];
		$this->what_todo->AdvancedSearch->Save();

		// Field h_id_cod
		$this->h_id_cod->AdvancedSearch->SearchValue = @$filter["x_h_id_cod"];
		$this->h_id_cod->AdvancedSearch->SearchOperator = @$filter["z_h_id_cod"];
		$this->h_id_cod->AdvancedSearch->SearchCondition = @$filter["v_h_id_cod"];
		$this->h_id_cod->AdvancedSearch->SearchValue2 = @$filter["y_h_id_cod"];
		$this->h_id_cod->AdvancedSearch->SearchOperator2 = @$filter["w_h_id_cod"];
		$this->h_id_cod->AdvancedSearch->Save();

		// Field h_email
		$this->h_email->AdvancedSearch->SearchValue = @$filter["x_h_email"];
		$this->h_email->AdvancedSearch->SearchOperator = @$filter["z_h_email"];
		$this->h_email->AdvancedSearch->SearchCondition = @$filter["v_h_email"];
		$this->h_email->AdvancedSearch->SearchValue2 = @$filter["y_h_email"];
		$this->h_email->AdvancedSearch->SearchOperator2 = @$filter["w_h_email"];
		$this->h_email->AdvancedSearch->Save();

		// Field h_contact_name
		$this->h_contact_name->AdvancedSearch->SearchValue = @$filter["x_h_contact_name"];
		$this->h_contact_name->AdvancedSearch->SearchOperator = @$filter["z_h_contact_name"];
		$this->h_contact_name->AdvancedSearch->SearchCondition = @$filter["v_h_contact_name"];
		$this->h_contact_name->AdvancedSearch->SearchValue2 = @$filter["y_h_contact_name"];
		$this->h_contact_name->AdvancedSearch->SearchOperator2 = @$filter["w_h_contact_name"];
		$this->h_contact_name->AdvancedSearch->Save();

		// Field h_pass
		$this->h_pass->AdvancedSearch->SearchValue = @$filter["x_h_pass"];
		$this->h_pass->AdvancedSearch->SearchOperator = @$filter["z_h_pass"];
		$this->h_pass->AdvancedSearch->SearchCondition = @$filter["v_h_pass"];
		$this->h_pass->AdvancedSearch->SearchValue2 = @$filter["y_h_pass"];
		$this->h_pass->AdvancedSearch->SearchOperator2 = @$filter["w_h_pass"];
		$this->h_pass->AdvancedSearch->Save();

		// Field h_contact_phone
		$this->h_contact_phone->AdvancedSearch->SearchValue = @$filter["x_h_contact_phone"];
		$this->h_contact_phone->AdvancedSearch->SearchOperator = @$filter["z_h_contact_phone"];
		$this->h_contact_phone->AdvancedSearch->SearchCondition = @$filter["v_h_contact_phone"];
		$this->h_contact_phone->AdvancedSearch->SearchValue2 = @$filter["y_h_contact_phone"];
		$this->h_contact_phone->AdvancedSearch->SearchOperator2 = @$filter["w_h_contact_phone"];
		$this->h_contact_phone->AdvancedSearch->Save();

		// Field h_site
		$this->h_site->AdvancedSearch->SearchValue = @$filter["x_h_site"];
		$this->h_site->AdvancedSearch->SearchOperator = @$filter["z_h_site"];
		$this->h_site->AdvancedSearch->SearchCondition = @$filter["v_h_site"];
		$this->h_site->AdvancedSearch->SearchValue2 = @$filter["y_h_site"];
		$this->h_site->AdvancedSearch->SearchOperator2 = @$filter["w_h_site"];
		$this->h_site->AdvancedSearch->Save();

		// Field contact_fax
		$this->contact_fax->AdvancedSearch->SearchValue = @$filter["x_contact_fax"];
		$this->contact_fax->AdvancedSearch->SearchOperator = @$filter["z_contact_fax"];
		$this->contact_fax->AdvancedSearch->SearchCondition = @$filter["v_contact_fax"];
		$this->contact_fax->AdvancedSearch->SearchValue2 = @$filter["y_contact_fax"];
		$this->contact_fax->AdvancedSearch->SearchOperator2 = @$filter["w_contact_fax"];
		$this->contact_fax->AdvancedSearch->Save();

		// Field star_rating
		$this->star_rating->AdvancedSearch->SearchValue = @$filter["x_star_rating"];
		$this->star_rating->AdvancedSearch->SearchOperator = @$filter["z_star_rating"];
		$this->star_rating->AdvancedSearch->SearchCondition = @$filter["v_star_rating"];
		$this->star_rating->AdvancedSearch->SearchValue2 = @$filter["y_star_rating"];
		$this->star_rating->AdvancedSearch->SearchOperator2 = @$filter["w_star_rating"];
		$this->star_rating->AdvancedSearch->Save();

		// Field create_date
		$this->create_date->AdvancedSearch->SearchValue = @$filter["x_create_date"];
		$this->create_date->AdvancedSearch->SearchOperator = @$filter["z_create_date"];
		$this->create_date->AdvancedSearch->SearchCondition = @$filter["v_create_date"];
		$this->create_date->AdvancedSearch->SearchValue2 = @$filter["y_create_date"];
		$this->create_date->AdvancedSearch->SearchOperator2 = @$filter["w_create_date"];
		$this->create_date->AdvancedSearch->Save();

		// Field update_date
		$this->update_date->AdvancedSearch->SearchValue = @$filter["x_update_date"];
		$this->update_date->AdvancedSearch->SearchOperator = @$filter["z_update_date"];
		$this->update_date->AdvancedSearch->SearchCondition = @$filter["v_update_date"];
		$this->update_date->AdvancedSearch->SearchValue2 = @$filter["y_update_date"];
		$this->update_date->AdvancedSearch->SearchOperator2 = @$filter["w_update_date"];
		$this->update_date->AdvancedSearch->Save();

		// Field h_online_status
		$this->h_online_status->AdvancedSearch->SearchValue = @$filter["x_h_online_status"];
		$this->h_online_status->AdvancedSearch->SearchOperator = @$filter["z_h_online_status"];
		$this->h_online_status->AdvancedSearch->SearchCondition = @$filter["v_h_online_status"];
		$this->h_online_status->AdvancedSearch->SearchValue2 = @$filter["y_h_online_status"];
		$this->h_online_status->AdvancedSearch->SearchOperator2 = @$filter["w_h_online_status"];
		$this->h_online_status->AdvancedSearch->Save();

		// Field hotel_blocked
		$this->hotel_blocked->AdvancedSearch->SearchValue = @$filter["x_hotel_blocked"];
		$this->hotel_blocked->AdvancedSearch->SearchOperator = @$filter["z_hotel_blocked"];
		$this->hotel_blocked->AdvancedSearch->SearchCondition = @$filter["v_hotel_blocked"];
		$this->hotel_blocked->AdvancedSearch->SearchValue2 = @$filter["y_hotel_blocked"];
		$this->hotel_blocked->AdvancedSearch->SearchOperator2 = @$filter["w_hotel_blocked"];
		$this->hotel_blocked->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->hotel_id, $Default, FALSE); // hotel_id
		$this->BuildSearchSql($sWhere, $this->h_name, $Default, FALSE); // h_name
		$this->BuildSearchSql($sWhere, $this->h_slug, $Default, FALSE); // h_slug
		$this->BuildSearchSql($sWhere, $this->h_feature_image, $Default, FALSE); // h_feature_image
		$this->BuildSearchSql($sWhere, $this->h_description, $Default, FALSE); // h_description
		$this->BuildSearchSql($sWhere, $this->h_meta_key, $Default, FALSE); // h_meta_key
		$this->BuildSearchSql($sWhere, $this->h_deatail, $Default, FALSE); // h_deatail
		$this->BuildSearchSql($sWhere, $this->h_facilities, $Default, FALSE); // h_facilities
		$this->BuildSearchSql($sWhere, $this->h_address, $Default, FALSE); // h_address
		$this->BuildSearchSql($sWhere, $this->h_create, $Default, FALSE); // h_create
		$this->BuildSearchSql($sWhere, $this->dest_id, $Default, FALSE); // dest_id
		$this->BuildSearchSql($sWhere, $this->province, $Default, FALSE); // province
		$this->BuildSearchSql($sWhere, $this->whylike, $Default, FALSE); // whylike
		$this->BuildSearchSql($sWhere, $this->lang_spoken, $Default, FALSE); // lang_spoken
		$this->BuildSearchSql($sWhere, $this->map, $Default, FALSE); // map
		$this->BuildSearchSql($sWhere, $this->what_todo, $Default, FALSE); // what_todo
		$this->BuildSearchSql($sWhere, $this->h_id_cod, $Default, FALSE); // h_id_cod
		$this->BuildSearchSql($sWhere, $this->h_email, $Default, FALSE); // h_email
		$this->BuildSearchSql($sWhere, $this->h_contact_name, $Default, FALSE); // h_contact_name
		$this->BuildSearchSql($sWhere, $this->h_pass, $Default, FALSE); // h_pass
		$this->BuildSearchSql($sWhere, $this->h_contact_phone, $Default, FALSE); // h_contact_phone
		$this->BuildSearchSql($sWhere, $this->h_site, $Default, FALSE); // h_site
		$this->BuildSearchSql($sWhere, $this->contact_fax, $Default, FALSE); // contact_fax
		$this->BuildSearchSql($sWhere, $this->star_rating, $Default, FALSE); // star_rating
		$this->BuildSearchSql($sWhere, $this->create_date, $Default, FALSE); // create_date
		$this->BuildSearchSql($sWhere, $this->update_date, $Default, FALSE); // update_date
		$this->BuildSearchSql($sWhere, $this->h_online_status, $Default, FALSE); // h_online_status
		$this->BuildSearchSql($sWhere, $this->hotel_blocked, $Default, FALSE); // hotel_blocked

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->hotel_id->AdvancedSearch->Save(); // hotel_id
			$this->h_name->AdvancedSearch->Save(); // h_name
			$this->h_slug->AdvancedSearch->Save(); // h_slug
			$this->h_feature_image->AdvancedSearch->Save(); // h_feature_image
			$this->h_description->AdvancedSearch->Save(); // h_description
			$this->h_meta_key->AdvancedSearch->Save(); // h_meta_key
			$this->h_deatail->AdvancedSearch->Save(); // h_deatail
			$this->h_facilities->AdvancedSearch->Save(); // h_facilities
			$this->h_address->AdvancedSearch->Save(); // h_address
			$this->h_create->AdvancedSearch->Save(); // h_create
			$this->dest_id->AdvancedSearch->Save(); // dest_id
			$this->province->AdvancedSearch->Save(); // province
			$this->whylike->AdvancedSearch->Save(); // whylike
			$this->lang_spoken->AdvancedSearch->Save(); // lang_spoken
			$this->map->AdvancedSearch->Save(); // map
			$this->what_todo->AdvancedSearch->Save(); // what_todo
			$this->h_id_cod->AdvancedSearch->Save(); // h_id_cod
			$this->h_email->AdvancedSearch->Save(); // h_email
			$this->h_contact_name->AdvancedSearch->Save(); // h_contact_name
			$this->h_pass->AdvancedSearch->Save(); // h_pass
			$this->h_contact_phone->AdvancedSearch->Save(); // h_contact_phone
			$this->h_site->AdvancedSearch->Save(); // h_site
			$this->contact_fax->AdvancedSearch->Save(); // contact_fax
			$this->star_rating->AdvancedSearch->Save(); // star_rating
			$this->create_date->AdvancedSearch->Save(); // create_date
			$this->update_date->AdvancedSearch->Save(); // update_date
			$this->h_online_status->AdvancedSearch->Save(); // h_online_status
			$this->hotel_blocked->AdvancedSearch->Save(); // hotel_blocked
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
		$this->BuildBasicSearchSQL($sWhere, $this->h_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_slug, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_feature_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_meta_key, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_deatail, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_facilities, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->province, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->whylike, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->lang_spoken, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->map, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->what_todo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_id_cod, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_contact_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_pass, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_contact_phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->h_site, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->contact_fax, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->star_rating, $arKeywords, $type);
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
		if ($this->hotel_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_slug->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_feature_image->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_description->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_meta_key->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_deatail->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_facilities->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_address->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_create->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->dest_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->province->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->whylike->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->lang_spoken->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->map->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->what_todo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_id_cod->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_email->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_contact_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_pass->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_contact_phone->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_site->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->contact_fax->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->star_rating->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->create_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->update_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->h_online_status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->hotel_blocked->AdvancedSearch->IssetSession())
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
		$this->hotel_id->AdvancedSearch->UnsetSession();
		$this->h_name->AdvancedSearch->UnsetSession();
		$this->h_slug->AdvancedSearch->UnsetSession();
		$this->h_feature_image->AdvancedSearch->UnsetSession();
		$this->h_description->AdvancedSearch->UnsetSession();
		$this->h_meta_key->AdvancedSearch->UnsetSession();
		$this->h_deatail->AdvancedSearch->UnsetSession();
		$this->h_facilities->AdvancedSearch->UnsetSession();
		$this->h_address->AdvancedSearch->UnsetSession();
		$this->h_create->AdvancedSearch->UnsetSession();
		$this->dest_id->AdvancedSearch->UnsetSession();
		$this->province->AdvancedSearch->UnsetSession();
		$this->whylike->AdvancedSearch->UnsetSession();
		$this->lang_spoken->AdvancedSearch->UnsetSession();
		$this->map->AdvancedSearch->UnsetSession();
		$this->what_todo->AdvancedSearch->UnsetSession();
		$this->h_id_cod->AdvancedSearch->UnsetSession();
		$this->h_email->AdvancedSearch->UnsetSession();
		$this->h_contact_name->AdvancedSearch->UnsetSession();
		$this->h_pass->AdvancedSearch->UnsetSession();
		$this->h_contact_phone->AdvancedSearch->UnsetSession();
		$this->h_site->AdvancedSearch->UnsetSession();
		$this->contact_fax->AdvancedSearch->UnsetSession();
		$this->star_rating->AdvancedSearch->UnsetSession();
		$this->create_date->AdvancedSearch->UnsetSession();
		$this->update_date->AdvancedSearch->UnsetSession();
		$this->h_online_status->AdvancedSearch->UnsetSession();
		$this->hotel_blocked->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->hotel_id->AdvancedSearch->Load();
		$this->h_name->AdvancedSearch->Load();
		$this->h_slug->AdvancedSearch->Load();
		$this->h_feature_image->AdvancedSearch->Load();
		$this->h_description->AdvancedSearch->Load();
		$this->h_meta_key->AdvancedSearch->Load();
		$this->h_deatail->AdvancedSearch->Load();
		$this->h_facilities->AdvancedSearch->Load();
		$this->h_address->AdvancedSearch->Load();
		$this->h_create->AdvancedSearch->Load();
		$this->dest_id->AdvancedSearch->Load();
		$this->province->AdvancedSearch->Load();
		$this->whylike->AdvancedSearch->Load();
		$this->lang_spoken->AdvancedSearch->Load();
		$this->map->AdvancedSearch->Load();
		$this->what_todo->AdvancedSearch->Load();
		$this->h_id_cod->AdvancedSearch->Load();
		$this->h_email->AdvancedSearch->Load();
		$this->h_contact_name->AdvancedSearch->Load();
		$this->h_pass->AdvancedSearch->Load();
		$this->h_contact_phone->AdvancedSearch->Load();
		$this->h_site->AdvancedSearch->Load();
		$this->contact_fax->AdvancedSearch->Load();
		$this->star_rating->AdvancedSearch->Load();
		$this->create_date->AdvancedSearch->Load();
		$this->update_date->AdvancedSearch->Load();
		$this->h_online_status->AdvancedSearch->Load();
		$this->hotel_blocked->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->hotel_id); // hotel_id
			$this->UpdateSort($this->h_name); // h_name
			$this->UpdateSort($this->h_slug); // h_slug
			$this->UpdateSort($this->h_feature_image); // h_feature_image
			$this->UpdateSort($this->h_address); // h_address
			$this->UpdateSort($this->h_create); // h_create
			$this->UpdateSort($this->dest_id); // dest_id
			$this->UpdateSort($this->province); // province
			$this->UpdateSort($this->h_id_cod); // h_id_cod
			$this->UpdateSort($this->h_email); // h_email
			$this->UpdateSort($this->h_contact_name); // h_contact_name
			$this->UpdateSort($this->h_pass); // h_pass
			$this->UpdateSort($this->h_contact_phone); // h_contact_phone
			$this->UpdateSort($this->h_site); // h_site
			$this->UpdateSort($this->contact_fax); // contact_fax
			$this->UpdateSort($this->star_rating); // star_rating
			$this->UpdateSort($this->create_date); // create_date
			$this->UpdateSort($this->update_date); // update_date
			$this->UpdateSort($this->h_online_status); // h_online_status
			$this->UpdateSort($this->hotel_blocked); // hotel_blocked
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
				$this->hotel_id->setSort("");
				$this->h_name->setSort("");
				$this->h_slug->setSort("");
				$this->h_feature_image->setSort("");
				$this->h_address->setSort("");
				$this->h_create->setSort("");
				$this->dest_id->setSort("");
				$this->province->setSort("");
				$this->h_id_cod->setSort("");
				$this->h_email->setSort("");
				$this->h_contact_name->setSort("");
				$this->h_pass->setSort("");
				$this->h_contact_phone->setSort("");
				$this->h_site->setSort("");
				$this->contact_fax->setSort("");
				$this->star_rating->setSort("");
				$this->create_date->setSort("");
				$this->update_date->setSort("");
				$this->h_online_status->setSort("");
				$this->hotel_blocked->setSort("");
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->hotel_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fhotelslist,url:'" . $this->MultiDeleteUrl . "'});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fhotelslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fhotelslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fhotelslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fhotelslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		// hotel_id

		$this->hotel_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hotel_id"]);
		if ($this->hotel_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hotel_id->AdvancedSearch->SearchOperator = @$_GET["z_hotel_id"];

		// h_name
		$this->h_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_name"]);
		if ($this->h_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_name->AdvancedSearch->SearchOperator = @$_GET["z_h_name"];

		// h_slug
		$this->h_slug->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_slug"]);
		if ($this->h_slug->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_slug->AdvancedSearch->SearchOperator = @$_GET["z_h_slug"];

		// h_feature_image
		$this->h_feature_image->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_feature_image"]);
		if ($this->h_feature_image->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_feature_image->AdvancedSearch->SearchOperator = @$_GET["z_h_feature_image"];

		// h_description
		$this->h_description->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_description"]);
		if ($this->h_description->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_description->AdvancedSearch->SearchOperator = @$_GET["z_h_description"];

		// h_meta_key
		$this->h_meta_key->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_meta_key"]);
		if ($this->h_meta_key->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_meta_key->AdvancedSearch->SearchOperator = @$_GET["z_h_meta_key"];

		// h_deatail
		$this->h_deatail->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_deatail"]);
		if ($this->h_deatail->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_deatail->AdvancedSearch->SearchOperator = @$_GET["z_h_deatail"];

		// h_facilities
		$this->h_facilities->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_facilities"]);
		if ($this->h_facilities->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_facilities->AdvancedSearch->SearchOperator = @$_GET["z_h_facilities"];

		// h_address
		$this->h_address->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_address"]);
		if ($this->h_address->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_address->AdvancedSearch->SearchOperator = @$_GET["z_h_address"];

		// h_create
		$this->h_create->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_create"]);
		if ($this->h_create->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_create->AdvancedSearch->SearchOperator = @$_GET["z_h_create"];

		// dest_id
		$this->dest_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_dest_id"]);
		if ($this->dest_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->dest_id->AdvancedSearch->SearchOperator = @$_GET["z_dest_id"];

		// province
		$this->province->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_province"]);
		if ($this->province->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->province->AdvancedSearch->SearchOperator = @$_GET["z_province"];

		// whylike
		$this->whylike->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_whylike"]);
		if ($this->whylike->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->whylike->AdvancedSearch->SearchOperator = @$_GET["z_whylike"];

		// lang_spoken
		$this->lang_spoken->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_lang_spoken"]);
		if ($this->lang_spoken->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->lang_spoken->AdvancedSearch->SearchOperator = @$_GET["z_lang_spoken"];

		// map
		$this->map->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_map"]);
		if ($this->map->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->map->AdvancedSearch->SearchOperator = @$_GET["z_map"];

		// what_todo
		$this->what_todo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_what_todo"]);
		if ($this->what_todo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->what_todo->AdvancedSearch->SearchOperator = @$_GET["z_what_todo"];

		// h_id_cod
		$this->h_id_cod->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_id_cod"]);
		if ($this->h_id_cod->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_id_cod->AdvancedSearch->SearchOperator = @$_GET["z_h_id_cod"];

		// h_email
		$this->h_email->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_email"]);
		if ($this->h_email->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_email->AdvancedSearch->SearchOperator = @$_GET["z_h_email"];

		// h_contact_name
		$this->h_contact_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_contact_name"]);
		if ($this->h_contact_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_contact_name->AdvancedSearch->SearchOperator = @$_GET["z_h_contact_name"];

		// h_pass
		$this->h_pass->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_pass"]);
		if ($this->h_pass->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_pass->AdvancedSearch->SearchOperator = @$_GET["z_h_pass"];

		// h_contact_phone
		$this->h_contact_phone->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_contact_phone"]);
		if ($this->h_contact_phone->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_contact_phone->AdvancedSearch->SearchOperator = @$_GET["z_h_contact_phone"];

		// h_site
		$this->h_site->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_site"]);
		if ($this->h_site->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_site->AdvancedSearch->SearchOperator = @$_GET["z_h_site"];

		// contact_fax
		$this->contact_fax->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_contact_fax"]);
		if ($this->contact_fax->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->contact_fax->AdvancedSearch->SearchOperator = @$_GET["z_contact_fax"];

		// star_rating
		$this->star_rating->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_star_rating"]);
		if ($this->star_rating->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->star_rating->AdvancedSearch->SearchOperator = @$_GET["z_star_rating"];

		// create_date
		$this->create_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_create_date"]);
		if ($this->create_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->create_date->AdvancedSearch->SearchOperator = @$_GET["z_create_date"];

		// update_date
		$this->update_date->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_update_date"]);
		if ($this->update_date->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->update_date->AdvancedSearch->SearchOperator = @$_GET["z_update_date"];

		// h_online_status
		$this->h_online_status->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_h_online_status"]);
		if ($this->h_online_status->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->h_online_status->AdvancedSearch->SearchOperator = @$_GET["z_h_online_status"];

		// hotel_blocked
		$this->hotel_blocked->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_hotel_blocked"]);
		if ($this->hotel_blocked->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->hotel_blocked->AdvancedSearch->SearchOperator = @$_GET["z_hotel_blocked"];
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
		$this->hotel_id->setDbValue($rs->fields('hotel_id'));
		$this->h_name->setDbValue($rs->fields('h_name'));
		$this->h_slug->setDbValue($rs->fields('h_slug'));
		$this->h_feature_image->Upload->DbValue = $rs->fields('h_feature_image');
		$this->h_feature_image->CurrentValue = $this->h_feature_image->Upload->DbValue;
		$this->h_description->setDbValue($rs->fields('h_description'));
		$this->h_meta_key->setDbValue($rs->fields('h_meta_key'));
		$this->h_deatail->setDbValue($rs->fields('h_deatail'));
		$this->h_facilities->setDbValue($rs->fields('h_facilities'));
		$this->h_address->setDbValue($rs->fields('h_address'));
		$this->h_create->setDbValue($rs->fields('h_create'));
		$this->dest_id->setDbValue($rs->fields('dest_id'));
		$this->province->setDbValue($rs->fields('province'));
		$this->whylike->setDbValue($rs->fields('whylike'));
		$this->lang_spoken->setDbValue($rs->fields('lang_spoken'));
		$this->map->setDbValue($rs->fields('map'));
		$this->what_todo->setDbValue($rs->fields('what_todo'));
		$this->h_id_cod->setDbValue($rs->fields('h_id_cod'));
		$this->h_email->setDbValue($rs->fields('h_email'));
		$this->h_contact_name->setDbValue($rs->fields('h_contact_name'));
		$this->h_pass->setDbValue($rs->fields('h_pass'));
		$this->h_contact_phone->setDbValue($rs->fields('h_contact_phone'));
		$this->h_site->setDbValue($rs->fields('h_site'));
		$this->contact_fax->setDbValue($rs->fields('contact_fax'));
		$this->star_rating->setDbValue($rs->fields('star_rating'));
		$this->create_date->setDbValue($rs->fields('create_date'));
		$this->update_date->setDbValue($rs->fields('update_date'));
		$this->h_online_status->setDbValue($rs->fields('h_online_status'));
		$this->hotel_blocked->setDbValue($rs->fields('hotel_blocked'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->hotel_id->DbValue = $row['hotel_id'];
		$this->h_name->DbValue = $row['h_name'];
		$this->h_slug->DbValue = $row['h_slug'];
		$this->h_feature_image->Upload->DbValue = $row['h_feature_image'];
		$this->h_description->DbValue = $row['h_description'];
		$this->h_meta_key->DbValue = $row['h_meta_key'];
		$this->h_deatail->DbValue = $row['h_deatail'];
		$this->h_facilities->DbValue = $row['h_facilities'];
		$this->h_address->DbValue = $row['h_address'];
		$this->h_create->DbValue = $row['h_create'];
		$this->dest_id->DbValue = $row['dest_id'];
		$this->province->DbValue = $row['province'];
		$this->whylike->DbValue = $row['whylike'];
		$this->lang_spoken->DbValue = $row['lang_spoken'];
		$this->map->DbValue = $row['map'];
		$this->what_todo->DbValue = $row['what_todo'];
		$this->h_id_cod->DbValue = $row['h_id_cod'];
		$this->h_email->DbValue = $row['h_email'];
		$this->h_contact_name->DbValue = $row['h_contact_name'];
		$this->h_pass->DbValue = $row['h_pass'];
		$this->h_contact_phone->DbValue = $row['h_contact_phone'];
		$this->h_site->DbValue = $row['h_site'];
		$this->contact_fax->DbValue = $row['contact_fax'];
		$this->star_rating->DbValue = $row['star_rating'];
		$this->create_date->DbValue = $row['create_date'];
		$this->update_date->DbValue = $row['update_date'];
		$this->h_online_status->DbValue = $row['h_online_status'];
		$this->hotel_blocked->DbValue = $row['hotel_blocked'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// hotel_id
		// h_name
		// h_slug
		// h_feature_image
		// h_description
		// h_meta_key
		// h_deatail
		// h_facilities
		// h_address
		// h_create
		// dest_id
		// province
		// whylike
		// lang_spoken
		// map
		// what_todo
		// h_id_cod
		// h_email
		// h_contact_name
		// h_pass
		// h_contact_phone
		// h_site
		// contact_fax
		// star_rating
		// create_date
		// update_date
		// h_online_status
		// hotel_blocked

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// hotel_id
		$this->hotel_id->ViewValue = $this->hotel_id->CurrentValue;
		$this->hotel_id->ViewCustomAttributes = "";

		// h_name
		$this->h_name->ViewValue = $this->h_name->CurrentValue;
		$this->h_name->ViewCustomAttributes = "";

		// h_slug
		$this->h_slug->ViewValue = $this->h_slug->CurrentValue;
		$this->h_slug->ViewCustomAttributes = "";

		// h_feature_image
		$this->h_feature_image->UploadPath = "../uploads/hotels";
		if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
			$this->h_feature_image->ImageAlt = $this->h_feature_image->FldAlt();
			$this->h_feature_image->ViewValue = $this->h_feature_image->Upload->DbValue;
		} else {
			$this->h_feature_image->ViewValue = "";
		}
		$this->h_feature_image->ViewCustomAttributes = "";

		// h_address
		$this->h_address->ViewValue = $this->h_address->CurrentValue;
		$this->h_address->ViewCustomAttributes = "";

		// h_create
		$this->h_create->ViewValue = $this->h_create->CurrentValue;
		$this->h_create->ViewValue = ew_FormatDateTime($this->h_create->ViewValue, 0);
		$this->h_create->ViewCustomAttributes = "";

		// dest_id
		$this->dest_id->ViewValue = $this->dest_id->CurrentValue;
		$this->dest_id->ViewCustomAttributes = "";

		// province
		$this->province->ViewValue = $this->province->CurrentValue;
		$this->province->ViewCustomAttributes = "";

		// h_id_cod
		$this->h_id_cod->ViewValue = $this->h_id_cod->CurrentValue;
		$this->h_id_cod->ViewCustomAttributes = "";

		// h_email
		$this->h_email->ViewValue = $this->h_email->CurrentValue;
		$this->h_email->ViewCustomAttributes = "";

		// h_contact_name
		$this->h_contact_name->ViewValue = $this->h_contact_name->CurrentValue;
		$this->h_contact_name->ViewCustomAttributes = "";

		// h_pass
		$this->h_pass->ViewValue = $this->h_pass->CurrentValue;
		$this->h_pass->ViewCustomAttributes = "";

		// h_contact_phone
		$this->h_contact_phone->ViewValue = $this->h_contact_phone->CurrentValue;
		$this->h_contact_phone->ViewCustomAttributes = "";

		// h_site
		$this->h_site->ViewValue = $this->h_site->CurrentValue;
		$this->h_site->ViewCustomAttributes = "";

		// contact_fax
		$this->contact_fax->ViewValue = $this->contact_fax->CurrentValue;
		$this->contact_fax->ViewCustomAttributes = "";

		// star_rating
		$this->star_rating->ViewValue = $this->star_rating->CurrentValue;
		$this->star_rating->ViewCustomAttributes = "";

		// create_date
		$this->create_date->ViewValue = $this->create_date->CurrentValue;
		$this->create_date->ViewValue = ew_FormatDateTime($this->create_date->ViewValue, 1);
		$this->create_date->ViewCustomAttributes = "";

		// update_date
		$this->update_date->ViewValue = $this->update_date->CurrentValue;
		$this->update_date->ViewValue = ew_FormatDateTime($this->update_date->ViewValue, 2);
		$this->update_date->ViewCustomAttributes = "";

		// h_online_status
		if (ew_ConvertToBool($this->h_online_status->CurrentValue)) {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(1) <> "" ? $this->h_online_status->FldTagCaption(1) : "Yes";
		} else {
			$this->h_online_status->ViewValue = $this->h_online_status->FldTagCaption(2) <> "" ? $this->h_online_status->FldTagCaption(2) : "No";
		}
		$this->h_online_status->ViewCustomAttributes = "";

		// hotel_blocked
		if (ew_ConvertToBool($this->hotel_blocked->CurrentValue)) {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(1) <> "" ? $this->hotel_blocked->FldTagCaption(1) : "Yes";
		} else {
			$this->hotel_blocked->ViewValue = $this->hotel_blocked->FldTagCaption(2) <> "" ? $this->hotel_blocked->FldTagCaption(2) : "No";
		}
		$this->hotel_blocked->ViewCustomAttributes = "";

			// hotel_id
			$this->hotel_id->LinkCustomAttributes = "";
			$this->hotel_id->HrefValue = "";
			$this->hotel_id->TooltipValue = "";

			// h_name
			$this->h_name->LinkCustomAttributes = "";
			$this->h_name->HrefValue = "";
			$this->h_name->TooltipValue = "";

			// h_slug
			$this->h_slug->LinkCustomAttributes = "";
			$this->h_slug->HrefValue = "";
			$this->h_slug->TooltipValue = "";

			// h_feature_image
			$this->h_feature_image->LinkCustomAttributes = "";
			$this->h_feature_image->UploadPath = "../uploads/hotels";
			if (!ew_Empty($this->h_feature_image->Upload->DbValue)) {
				$this->h_feature_image->HrefValue = ew_GetFileUploadUrl($this->h_feature_image, $this->h_feature_image->Upload->DbValue); // Add prefix/suffix
				$this->h_feature_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->h_feature_image->HrefValue = ew_ConvertFullUrl($this->h_feature_image->HrefValue);
			} else {
				$this->h_feature_image->HrefValue = "";
			}
			$this->h_feature_image->HrefValue2 = $this->h_feature_image->UploadPath . $this->h_feature_image->Upload->DbValue;
			$this->h_feature_image->TooltipValue = "";
			if ($this->h_feature_image->UseColorbox) {
				if (ew_Empty($this->h_feature_image->TooltipValue))
					$this->h_feature_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->h_feature_image->LinkAttrs["data-rel"] = "hotels_x" . $this->RowCnt . "_h_feature_image";
				ew_AppendClass($this->h_feature_image->LinkAttrs["class"], "ewLightbox");
			}

			// h_address
			$this->h_address->LinkCustomAttributes = "";
			$this->h_address->HrefValue = "";
			$this->h_address->TooltipValue = "";

			// h_create
			$this->h_create->LinkCustomAttributes = "";
			$this->h_create->HrefValue = "";
			$this->h_create->TooltipValue = "";

			// dest_id
			$this->dest_id->LinkCustomAttributes = "";
			$this->dest_id->HrefValue = "";
			$this->dest_id->TooltipValue = "";

			// province
			$this->province->LinkCustomAttributes = "";
			$this->province->HrefValue = "";
			$this->province->TooltipValue = "";

			// h_id_cod
			$this->h_id_cod->LinkCustomAttributes = "";
			$this->h_id_cod->HrefValue = "";
			$this->h_id_cod->TooltipValue = "";

			// h_email
			$this->h_email->LinkCustomAttributes = "";
			$this->h_email->HrefValue = "";
			$this->h_email->TooltipValue = "";

			// h_contact_name
			$this->h_contact_name->LinkCustomAttributes = "";
			$this->h_contact_name->HrefValue = "";
			$this->h_contact_name->TooltipValue = "";

			// h_pass
			$this->h_pass->LinkCustomAttributes = "";
			$this->h_pass->HrefValue = "";
			$this->h_pass->TooltipValue = "";

			// h_contact_phone
			$this->h_contact_phone->LinkCustomAttributes = "";
			$this->h_contact_phone->HrefValue = "";
			$this->h_contact_phone->TooltipValue = "";

			// h_site
			$this->h_site->LinkCustomAttributes = "";
			$this->h_site->HrefValue = "";
			$this->h_site->TooltipValue = "";

			// contact_fax
			$this->contact_fax->LinkCustomAttributes = "";
			$this->contact_fax->HrefValue = "";
			$this->contact_fax->TooltipValue = "";

			// star_rating
			$this->star_rating->LinkCustomAttributes = "";
			$this->star_rating->HrefValue = "";
			$this->star_rating->TooltipValue = "";

			// create_date
			$this->create_date->LinkCustomAttributes = "";
			$this->create_date->HrefValue = "";
			$this->create_date->TooltipValue = "";

			// update_date
			$this->update_date->LinkCustomAttributes = "";
			$this->update_date->HrefValue = "";
			$this->update_date->TooltipValue = "";

			// h_online_status
			$this->h_online_status->LinkCustomAttributes = "";
			$this->h_online_status->HrefValue = "";
			$this->h_online_status->TooltipValue = "";

			// hotel_blocked
			$this->hotel_blocked->LinkCustomAttributes = "";
			$this->hotel_blocked->HrefValue = "";
			$this->hotel_blocked->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// hotel_id
			$this->hotel_id->EditAttrs["class"] = "form-control";
			$this->hotel_id->EditCustomAttributes = "";
			$this->hotel_id->EditValue = ew_HtmlEncode($this->hotel_id->AdvancedSearch->SearchValue);
			$this->hotel_id->PlaceHolder = ew_RemoveHtml($this->hotel_id->FldCaption());

			// h_name
			$this->h_name->EditAttrs["class"] = "form-control";
			$this->h_name->EditCustomAttributes = "";
			$this->h_name->EditValue = ew_HtmlEncode($this->h_name->AdvancedSearch->SearchValue);
			$this->h_name->PlaceHolder = ew_RemoveHtml($this->h_name->FldCaption());

			// h_slug
			$this->h_slug->EditAttrs["class"] = "form-control";
			$this->h_slug->EditCustomAttributes = "";
			$this->h_slug->EditValue = ew_HtmlEncode($this->h_slug->AdvancedSearch->SearchValue);
			$this->h_slug->PlaceHolder = ew_RemoveHtml($this->h_slug->FldCaption());

			// h_feature_image
			$this->h_feature_image->EditAttrs["class"] = "form-control";
			$this->h_feature_image->EditCustomAttributes = "";
			$this->h_feature_image->EditValue = ew_HtmlEncode($this->h_feature_image->AdvancedSearch->SearchValue);
			$this->h_feature_image->PlaceHolder = ew_RemoveHtml($this->h_feature_image->FldCaption());

			// h_address
			$this->h_address->EditAttrs["class"] = "form-control";
			$this->h_address->EditCustomAttributes = "";
			$this->h_address->EditValue = ew_HtmlEncode($this->h_address->AdvancedSearch->SearchValue);
			$this->h_address->PlaceHolder = ew_RemoveHtml($this->h_address->FldCaption());

			// h_create
			$this->h_create->EditAttrs["class"] = "form-control";
			$this->h_create->EditCustomAttributes = "";
			$this->h_create->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->h_create->AdvancedSearch->SearchValue, 0), 8));
			$this->h_create->PlaceHolder = ew_RemoveHtml($this->h_create->FldCaption());

			// dest_id
			$this->dest_id->EditAttrs["class"] = "form-control";
			$this->dest_id->EditCustomAttributes = "";
			$this->dest_id->EditValue = ew_HtmlEncode($this->dest_id->AdvancedSearch->SearchValue);
			$this->dest_id->PlaceHolder = ew_RemoveHtml($this->dest_id->FldCaption());

			// province
			$this->province->EditAttrs["class"] = "form-control";
			$this->province->EditCustomAttributes = "";
			$this->province->EditValue = ew_HtmlEncode($this->province->AdvancedSearch->SearchValue);
			$this->province->PlaceHolder = ew_RemoveHtml($this->province->FldCaption());

			// h_id_cod
			$this->h_id_cod->EditAttrs["class"] = "form-control";
			$this->h_id_cod->EditCustomAttributes = "";
			$this->h_id_cod->EditValue = ew_HtmlEncode($this->h_id_cod->AdvancedSearch->SearchValue);
			$this->h_id_cod->PlaceHolder = ew_RemoveHtml($this->h_id_cod->FldCaption());

			// h_email
			$this->h_email->EditAttrs["class"] = "form-control";
			$this->h_email->EditCustomAttributes = "";
			$this->h_email->EditValue = ew_HtmlEncode($this->h_email->AdvancedSearch->SearchValue);
			$this->h_email->PlaceHolder = ew_RemoveHtml($this->h_email->FldCaption());

			// h_contact_name
			$this->h_contact_name->EditAttrs["class"] = "form-control";
			$this->h_contact_name->EditCustomAttributes = "";
			$this->h_contact_name->EditValue = ew_HtmlEncode($this->h_contact_name->AdvancedSearch->SearchValue);
			$this->h_contact_name->PlaceHolder = ew_RemoveHtml($this->h_contact_name->FldCaption());

			// h_pass
			$this->h_pass->EditAttrs["class"] = "form-control";
			$this->h_pass->EditCustomAttributes = "";
			$this->h_pass->EditValue = ew_HtmlEncode($this->h_pass->AdvancedSearch->SearchValue);
			$this->h_pass->PlaceHolder = ew_RemoveHtml($this->h_pass->FldCaption());

			// h_contact_phone
			$this->h_contact_phone->EditAttrs["class"] = "form-control";
			$this->h_contact_phone->EditCustomAttributes = "";
			$this->h_contact_phone->EditValue = ew_HtmlEncode($this->h_contact_phone->AdvancedSearch->SearchValue);
			$this->h_contact_phone->PlaceHolder = ew_RemoveHtml($this->h_contact_phone->FldCaption());

			// h_site
			$this->h_site->EditAttrs["class"] = "form-control";
			$this->h_site->EditCustomAttributes = "";
			$this->h_site->EditValue = ew_HtmlEncode($this->h_site->AdvancedSearch->SearchValue);
			$this->h_site->PlaceHolder = ew_RemoveHtml($this->h_site->FldCaption());

			// contact_fax
			$this->contact_fax->EditAttrs["class"] = "form-control";
			$this->contact_fax->EditCustomAttributes = "";
			$this->contact_fax->EditValue = ew_HtmlEncode($this->contact_fax->AdvancedSearch->SearchValue);
			$this->contact_fax->PlaceHolder = ew_RemoveHtml($this->contact_fax->FldCaption());

			// star_rating
			$this->star_rating->EditAttrs["class"] = "form-control";
			$this->star_rating->EditCustomAttributes = "";
			$this->star_rating->EditValue = ew_HtmlEncode($this->star_rating->AdvancedSearch->SearchValue);
			$this->star_rating->PlaceHolder = ew_RemoveHtml($this->star_rating->FldCaption());

			// create_date
			$this->create_date->EditAttrs["class"] = "form-control";
			$this->create_date->EditCustomAttributes = "";
			$this->create_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->create_date->AdvancedSearch->SearchValue, 1), 8));
			$this->create_date->PlaceHolder = ew_RemoveHtml($this->create_date->FldCaption());

			// update_date
			$this->update_date->EditAttrs["class"] = "form-control";
			$this->update_date->EditCustomAttributes = "";
			$this->update_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->update_date->AdvancedSearch->SearchValue, 2), 2));
			$this->update_date->PlaceHolder = ew_RemoveHtml($this->update_date->FldCaption());

			// h_online_status
			$this->h_online_status->EditCustomAttributes = "";
			$this->h_online_status->EditValue = $this->h_online_status->Options(FALSE);

			// hotel_blocked
			$this->hotel_blocked->EditCustomAttributes = "";
			$this->hotel_blocked->EditValue = $this->hotel_blocked->Options(FALSE);
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
		$this->hotel_id->AdvancedSearch->Load();
		$this->h_name->AdvancedSearch->Load();
		$this->h_slug->AdvancedSearch->Load();
		$this->h_feature_image->AdvancedSearch->Load();
		$this->h_description->AdvancedSearch->Load();
		$this->h_meta_key->AdvancedSearch->Load();
		$this->h_deatail->AdvancedSearch->Load();
		$this->h_facilities->AdvancedSearch->Load();
		$this->h_address->AdvancedSearch->Load();
		$this->h_create->AdvancedSearch->Load();
		$this->dest_id->AdvancedSearch->Load();
		$this->province->AdvancedSearch->Load();
		$this->whylike->AdvancedSearch->Load();
		$this->lang_spoken->AdvancedSearch->Load();
		$this->map->AdvancedSearch->Load();
		$this->what_todo->AdvancedSearch->Load();
		$this->h_id_cod->AdvancedSearch->Load();
		$this->h_email->AdvancedSearch->Load();
		$this->h_contact_name->AdvancedSearch->Load();
		$this->h_pass->AdvancedSearch->Load();
		$this->h_contact_phone->AdvancedSearch->Load();
		$this->h_site->AdvancedSearch->Load();
		$this->contact_fax->AdvancedSearch->Load();
		$this->star_rating->AdvancedSearch->Load();
		$this->create_date->AdvancedSearch->Load();
		$this->update_date->AdvancedSearch->Load();
		$this->h_online_status->AdvancedSearch->Load();
		$this->hotel_blocked->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_hotels\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotels',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotelslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$this->AddSearchQueryString($sQry, $this->hotel_id); // hotel_id
		$this->AddSearchQueryString($sQry, $this->h_name); // h_name
		$this->AddSearchQueryString($sQry, $this->h_slug); // h_slug
		$this->AddSearchQueryString($sQry, $this->h_description); // h_description
		$this->AddSearchQueryString($sQry, $this->h_meta_key); // h_meta_key
		$this->AddSearchQueryString($sQry, $this->h_deatail); // h_deatail
		$this->AddSearchQueryString($sQry, $this->h_facilities); // h_facilities
		$this->AddSearchQueryString($sQry, $this->h_address); // h_address
		$this->AddSearchQueryString($sQry, $this->h_create); // h_create
		$this->AddSearchQueryString($sQry, $this->dest_id); // dest_id
		$this->AddSearchQueryString($sQry, $this->province); // province
		$this->AddSearchQueryString($sQry, $this->whylike); // whylike
		$this->AddSearchQueryString($sQry, $this->lang_spoken); // lang_spoken
		$this->AddSearchQueryString($sQry, $this->map); // map
		$this->AddSearchQueryString($sQry, $this->what_todo); // what_todo
		$this->AddSearchQueryString($sQry, $this->h_id_cod); // h_id_cod
		$this->AddSearchQueryString($sQry, $this->h_email); // h_email
		$this->AddSearchQueryString($sQry, $this->h_contact_name); // h_contact_name
		$this->AddSearchQueryString($sQry, $this->h_pass); // h_pass
		$this->AddSearchQueryString($sQry, $this->h_contact_phone); // h_contact_phone
		$this->AddSearchQueryString($sQry, $this->h_site); // h_site
		$this->AddSearchQueryString($sQry, $this->contact_fax); // contact_fax
		$this->AddSearchQueryString($sQry, $this->star_rating); // star_rating
		$this->AddSearchQueryString($sQry, $this->create_date); // create_date
		$this->AddSearchQueryString($sQry, $this->update_date); // update_date
		$this->AddSearchQueryString($sQry, $this->h_online_status); // h_online_status
		$this->AddSearchQueryString($sQry, $this->hotel_blocked); // hotel_blocked

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
if (!isset($hotels_list)) $hotels_list = new chotels_list();

// Page init
$hotels_list->Page_Init();

// Page main
$hotels_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotels_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotels->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fhotelslist = new ew_Form("fhotelslist", "list");
fhotelslist.FormKeyCountName = '<?php echo $hotels_list->FormKeyCountName ?>';

// Form_CustomValidate event
fhotelslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotelslist.ValidateRequired = true;
<?php } else { ?>
fhotelslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotelslist.Lists["x_h_online_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelslist.Lists["x_h_online_status"].Options = <?php echo json_encode($hotels->h_online_status->Options()) ?>;
fhotelslist.Lists["x_hotel_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelslist.Lists["x_hotel_blocked"].Options = <?php echo json_encode($hotels->hotel_blocked->Options()) ?>;

// Form object for search
var CurrentSearchForm = fhotelslistsrch = new ew_Form("fhotelslistsrch");

// Validate function for search
fhotelslistsrch.Validate = function(fobj) {
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
fhotelslistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotelslistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
fhotelslistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
fhotelslistsrch.Lists["x_h_online_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelslistsrch.Lists["x_h_online_status"].Options = <?php echo json_encode($hotels->h_online_status->Options()) ?>;
fhotelslistsrch.Lists["x_hotel_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelslistsrch.Lists["x_hotel_blocked"].Options = <?php echo json_encode($hotels->hotel_blocked->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotels->Export == "") { ?>
<div class="ewToolbar">
<?php if ($hotels->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($hotels_list->TotalRecs > 0 && $hotels_list->ExportOptions->Visible()) { ?>
<?php $hotels_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($hotels_list->SearchOptions->Visible()) { ?>
<?php $hotels_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($hotels_list->FilterOptions->Visible()) { ?>
<?php $hotels_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($hotels->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $hotels_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($hotels_list->TotalRecs <= 0)
			$hotels_list->TotalRecs = $hotels->SelectRecordCount();
	} else {
		if (!$hotels_list->Recordset && ($hotels_list->Recordset = $hotels_list->LoadRecordset()))
			$hotels_list->TotalRecs = $hotels_list->Recordset->RecordCount();
	}
	$hotels_list->StartRec = 1;
	if ($hotels_list->DisplayRecs <= 0 || ($hotels->Export <> "" && $hotels->ExportAll)) // Display all records
		$hotels_list->DisplayRecs = $hotels_list->TotalRecs;
	if (!($hotels->Export <> "" && $hotels->ExportAll))
		$hotels_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$hotels_list->Recordset = $hotels_list->LoadRecordset($hotels_list->StartRec-1, $hotels_list->DisplayRecs);

	// Set no record found message
	if ($hotels->CurrentAction == "" && $hotels_list->TotalRecs == 0) {
		if ($hotels_list->SearchWhere == "0=101")
			$hotels_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$hotels_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$hotels_list->RenderOtherOptions();
?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($hotels->Export == "" && $hotels->CurrentAction == "") { ?>
<form name="fhotelslistsrch" id="fhotelslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($hotels_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fhotelslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="hotels">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$hotels_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$hotels->RowType = EW_ROWTYPE_SEARCH;

// Render row
$hotels->ResetAttrs();
$hotels_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
	<div id="xsc_h_online_status" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $hotels->h_online_status->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_h_online_status" id="z_h_online_status" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_h_online_status" class="ewTemplate"><input type="radio" data-table="hotels" data-field="x_h_online_status" data-value-separator="<?php echo $hotels->h_online_status->DisplayValueSeparatorAttribute() ?>" name="x_h_online_status" id="x_h_online_status" value="{value}"<?php echo $hotels->h_online_status->EditAttributes() ?>></div>
<div id="dsl_x_h_online_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $hotels->h_online_status->RadioButtonListHtml(FALSE, "x_h_online_status") ?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
	<div id="xsc_hotel_blocked" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $hotels->hotel_blocked->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_hotel_blocked" id="z_hotel_blocked" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_hotel_blocked" class="ewTemplate"><input type="radio" data-table="hotels" data-field="x_hotel_blocked" data-value-separator="<?php echo $hotels->hotel_blocked->DisplayValueSeparatorAttribute() ?>" name="x_hotel_blocked" id="x_hotel_blocked" value="{value}"<?php echo $hotels->hotel_blocked->EditAttributes() ?>></div>
<div id="dsl_x_hotel_blocked" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $hotels->hotel_blocked->RadioButtonListHtml(FALSE, "x_hotel_blocked") ?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_3" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($hotels_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($hotels_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $hotels_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($hotels_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($hotels_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($hotels_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($hotels_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $hotels_list->ShowPageHeader(); ?>
<?php
$hotels_list->ShowMessage();
?>
<?php if ($hotels_list->TotalRecs > 0 || $hotels->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid hotels">
<?php if ($hotels->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($hotels->CurrentAction <> "gridadd" && $hotels->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotels_list->Pager)) $hotels_list->Pager = new cPrevNextPager($hotels_list->StartRec, $hotels_list->DisplayRecs, $hotels_list->TotalRecs) ?>
<?php if ($hotels_list->Pager->RecordCount > 0 && $hotels_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotels_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotels_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotels_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotels_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotels_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotels_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotels_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotels_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotels_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotels_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fhotelslist" id="fhotelslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotels_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotels_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotels">
<div id="gmp_hotels" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($hotels_list->TotalRecs > 0 || $hotels->CurrentAction == "gridedit") { ?>
<table id="tbl_hotelslist" class="table ewTable">
<?php echo $hotels->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$hotels_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$hotels_list->RenderListOptions();

// Render list options (header, left)
$hotels_list->ListOptions->Render("header", "left");
?>
<?php if ($hotels->hotel_id->Visible) { // hotel_id ?>
	<?php if ($hotels->SortUrl($hotels->hotel_id) == "") { ?>
		<th data-name="hotel_id"><div id="elh_hotels_hotel_id" class="hotels_hotel_id"><div class="ewTableHeaderCaption"><?php echo $hotels->hotel_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hotel_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->hotel_id) ?>',1);"><div id="elh_hotels_hotel_id" class="hotels_hotel_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->hotel_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->hotel_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->hotel_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_name->Visible) { // h_name ?>
	<?php if ($hotels->SortUrl($hotels->h_name) == "") { ?>
		<th data-name="h_name"><div id="elh_hotels_h_name" class="hotels_h_name"><div class="ewTableHeaderCaption"><?php echo $hotels->h_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_name) ?>',1);"><div id="elh_hotels_h_name" class="hotels_h_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_slug->Visible) { // h_slug ?>
	<?php if ($hotels->SortUrl($hotels->h_slug) == "") { ?>
		<th data-name="h_slug"><div id="elh_hotels_h_slug" class="hotels_h_slug"><div class="ewTableHeaderCaption"><?php echo $hotels->h_slug->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_slug"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_slug) ?>',1);"><div id="elh_hotels_h_slug" class="hotels_h_slug">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_slug->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_slug->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_slug->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
	<?php if ($hotels->SortUrl($hotels->h_feature_image) == "") { ?>
		<th data-name="h_feature_image"><div id="elh_hotels_h_feature_image" class="hotels_h_feature_image"><div class="ewTableHeaderCaption"><?php echo $hotels->h_feature_image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_feature_image"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_feature_image) ?>',1);"><div id="elh_hotels_h_feature_image" class="hotels_h_feature_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_feature_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_feature_image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_feature_image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_address->Visible) { // h_address ?>
	<?php if ($hotels->SortUrl($hotels->h_address) == "") { ?>
		<th data-name="h_address"><div id="elh_hotels_h_address" class="hotels_h_address"><div class="ewTableHeaderCaption"><?php echo $hotels->h_address->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_address"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_address) ?>',1);"><div id="elh_hotels_h_address" class="hotels_h_address">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_address->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_address->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_address->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_create->Visible) { // h_create ?>
	<?php if ($hotels->SortUrl($hotels->h_create) == "") { ?>
		<th data-name="h_create"><div id="elh_hotels_h_create" class="hotels_h_create"><div class="ewTableHeaderCaption"><?php echo $hotels->h_create->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_create"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_create) ?>',1);"><div id="elh_hotels_h_create" class="hotels_h_create">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_create->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_create->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_create->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->dest_id->Visible) { // dest_id ?>
	<?php if ($hotels->SortUrl($hotels->dest_id) == "") { ?>
		<th data-name="dest_id"><div id="elh_hotels_dest_id" class="hotels_dest_id"><div class="ewTableHeaderCaption"><?php echo $hotels->dest_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dest_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->dest_id) ?>',1);"><div id="elh_hotels_dest_id" class="hotels_dest_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->dest_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->dest_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->dest_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->province->Visible) { // province ?>
	<?php if ($hotels->SortUrl($hotels->province) == "") { ?>
		<th data-name="province"><div id="elh_hotels_province" class="hotels_province"><div class="ewTableHeaderCaption"><?php echo $hotels->province->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->province) ?>',1);"><div id="elh_hotels_province" class="hotels_province">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->province->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->province->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->province->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
	<?php if ($hotels->SortUrl($hotels->h_id_cod) == "") { ?>
		<th data-name="h_id_cod"><div id="elh_hotels_h_id_cod" class="hotels_h_id_cod"><div class="ewTableHeaderCaption"><?php echo $hotels->h_id_cod->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_id_cod"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_id_cod) ?>',1);"><div id="elh_hotels_h_id_cod" class="hotels_h_id_cod">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_id_cod->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_id_cod->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_id_cod->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_email->Visible) { // h_email ?>
	<?php if ($hotels->SortUrl($hotels->h_email) == "") { ?>
		<th data-name="h_email"><div id="elh_hotels_h_email" class="hotels_h_email"><div class="ewTableHeaderCaption"><?php echo $hotels->h_email->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_email"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_email) ?>',1);"><div id="elh_hotels_h_email" class="hotels_h_email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_email->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
	<?php if ($hotels->SortUrl($hotels->h_contact_name) == "") { ?>
		<th data-name="h_contact_name"><div id="elh_hotels_h_contact_name" class="hotels_h_contact_name"><div class="ewTableHeaderCaption"><?php echo $hotels->h_contact_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_contact_name"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_contact_name) ?>',1);"><div id="elh_hotels_h_contact_name" class="hotels_h_contact_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_contact_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_contact_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_contact_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_pass->Visible) { // h_pass ?>
	<?php if ($hotels->SortUrl($hotels->h_pass) == "") { ?>
		<th data-name="h_pass"><div id="elh_hotels_h_pass" class="hotels_h_pass"><div class="ewTableHeaderCaption"><?php echo $hotels->h_pass->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_pass"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_pass) ?>',1);"><div id="elh_hotels_h_pass" class="hotels_h_pass">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_pass->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_pass->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_pass->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
	<?php if ($hotels->SortUrl($hotels->h_contact_phone) == "") { ?>
		<th data-name="h_contact_phone"><div id="elh_hotels_h_contact_phone" class="hotels_h_contact_phone"><div class="ewTableHeaderCaption"><?php echo $hotels->h_contact_phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_contact_phone"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_contact_phone) ?>',1);"><div id="elh_hotels_h_contact_phone" class="hotels_h_contact_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_contact_phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_contact_phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_contact_phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_site->Visible) { // h_site ?>
	<?php if ($hotels->SortUrl($hotels->h_site) == "") { ?>
		<th data-name="h_site"><div id="elh_hotels_h_site" class="hotels_h_site"><div class="ewTableHeaderCaption"><?php echo $hotels->h_site->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_site"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_site) ?>',1);"><div id="elh_hotels_h_site" class="hotels_h_site">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_site->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_site->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_site->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
	<?php if ($hotels->SortUrl($hotels->contact_fax) == "") { ?>
		<th data-name="contact_fax"><div id="elh_hotels_contact_fax" class="hotels_contact_fax"><div class="ewTableHeaderCaption"><?php echo $hotels->contact_fax->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="contact_fax"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->contact_fax) ?>',1);"><div id="elh_hotels_contact_fax" class="hotels_contact_fax">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->contact_fax->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->contact_fax->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->contact_fax->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->star_rating->Visible) { // star_rating ?>
	<?php if ($hotels->SortUrl($hotels->star_rating) == "") { ?>
		<th data-name="star_rating"><div id="elh_hotels_star_rating" class="hotels_star_rating"><div class="ewTableHeaderCaption"><?php echo $hotels->star_rating->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="star_rating"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->star_rating) ?>',1);"><div id="elh_hotels_star_rating" class="hotels_star_rating">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->star_rating->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($hotels->star_rating->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->star_rating->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->create_date->Visible) { // create_date ?>
	<?php if ($hotels->SortUrl($hotels->create_date) == "") { ?>
		<th data-name="create_date"><div id="elh_hotels_create_date" class="hotels_create_date"><div class="ewTableHeaderCaption"><?php echo $hotels->create_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="create_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->create_date) ?>',1);"><div id="elh_hotels_create_date" class="hotels_create_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->create_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->create_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->create_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->update_date->Visible) { // update_date ?>
	<?php if ($hotels->SortUrl($hotels->update_date) == "") { ?>
		<th data-name="update_date"><div id="elh_hotels_update_date" class="hotels_update_date"><div class="ewTableHeaderCaption"><?php echo $hotels->update_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="update_date"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->update_date) ?>',1);"><div id="elh_hotels_update_date" class="hotels_update_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->update_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->update_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->update_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
	<?php if ($hotels->SortUrl($hotels->h_online_status) == "") { ?>
		<th data-name="h_online_status"><div id="elh_hotels_h_online_status" class="hotels_h_online_status"><div class="ewTableHeaderCaption"><?php echo $hotels->h_online_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="h_online_status"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->h_online_status) ?>',1);"><div id="elh_hotels_h_online_status" class="hotels_h_online_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->h_online_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->h_online_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->h_online_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
	<?php if ($hotels->SortUrl($hotels->hotel_blocked) == "") { ?>
		<th data-name="hotel_blocked"><div id="elh_hotels_hotel_blocked" class="hotels_hotel_blocked"><div class="ewTableHeaderCaption"><?php echo $hotels->hotel_blocked->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="hotel_blocked"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $hotels->SortUrl($hotels->hotel_blocked) ?>',1);"><div id="elh_hotels_hotel_blocked" class="hotels_hotel_blocked">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $hotels->hotel_blocked->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($hotels->hotel_blocked->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($hotels->hotel_blocked->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$hotels_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($hotels->ExportAll && $hotels->Export <> "") {
	$hotels_list->StopRec = $hotels_list->TotalRecs;
} else {

	// Set the last record to display
	if ($hotels_list->TotalRecs > $hotels_list->StartRec + $hotels_list->DisplayRecs - 1)
		$hotels_list->StopRec = $hotels_list->StartRec + $hotels_list->DisplayRecs - 1;
	else
		$hotels_list->StopRec = $hotels_list->TotalRecs;
}
$hotels_list->RecCnt = $hotels_list->StartRec - 1;
if ($hotels_list->Recordset && !$hotels_list->Recordset->EOF) {
	$hotels_list->Recordset->MoveFirst();
	$bSelectLimit = $hotels_list->UseSelectLimit;
	if (!$bSelectLimit && $hotels_list->StartRec > 1)
		$hotels_list->Recordset->Move($hotels_list->StartRec - 1);
} elseif (!$hotels->AllowAddDeleteRow && $hotels_list->StopRec == 0) {
	$hotels_list->StopRec = $hotels->GridAddRowCount;
}

// Initialize aggregate
$hotels->RowType = EW_ROWTYPE_AGGREGATEINIT;
$hotels->ResetAttrs();
$hotels_list->RenderRow();
while ($hotels_list->RecCnt < $hotels_list->StopRec) {
	$hotels_list->RecCnt++;
	if (intval($hotels_list->RecCnt) >= intval($hotels_list->StartRec)) {
		$hotels_list->RowCnt++;

		// Set up key count
		$hotels_list->KeyCount = $hotels_list->RowIndex;

		// Init row class and style
		$hotels->ResetAttrs();
		$hotels->CssClass = "";
		if ($hotels->CurrentAction == "gridadd") {
		} else {
			$hotels_list->LoadRowValues($hotels_list->Recordset); // Load row values
		}
		$hotels->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$hotels->RowAttrs = array_merge($hotels->RowAttrs, array('data-rowindex'=>$hotels_list->RowCnt, 'id'=>'r' . $hotels_list->RowCnt . '_hotels', 'data-rowtype'=>$hotels->RowType));

		// Render row
		$hotels_list->RenderRow();

		// Render list options
		$hotels_list->RenderListOptions();
?>
	<tr<?php echo $hotels->RowAttributes() ?>>
<?php

// Render list options (body, left)
$hotels_list->ListOptions->Render("body", "left", $hotels_list->RowCnt);
?>
	<?php if ($hotels->hotel_id->Visible) { // hotel_id ?>
		<td data-name="hotel_id"<?php echo $hotels->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_hotel_id" class="hotels_hotel_id">
<span<?php echo $hotels->hotel_id->ViewAttributes() ?>>
<?php echo $hotels->hotel_id->ListViewValue() ?></span>
</span>
<a id="<?php echo $hotels_list->PageObjName . "_row_" . $hotels_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($hotels->h_name->Visible) { // h_name ?>
		<td data-name="h_name"<?php echo $hotels->h_name->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_name" class="hotels_h_name">
<span<?php echo $hotels->h_name->ViewAttributes() ?>>
<?php echo $hotels->h_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_slug->Visible) { // h_slug ?>
		<td data-name="h_slug"<?php echo $hotels->h_slug->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_slug" class="hotels_h_slug">
<span<?php echo $hotels->h_slug->ViewAttributes() ?>>
<?php echo $hotels->h_slug->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
		<td data-name="h_feature_image"<?php echo $hotels->h_feature_image->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_feature_image" class="hotels_h_feature_image">
<span>
<?php echo ew_GetFileViewTag($hotels->h_feature_image, $hotels->h_feature_image->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_address->Visible) { // h_address ?>
		<td data-name="h_address"<?php echo $hotels->h_address->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_address" class="hotels_h_address">
<span<?php echo $hotels->h_address->ViewAttributes() ?>>
<?php echo $hotels->h_address->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_create->Visible) { // h_create ?>
		<td data-name="h_create"<?php echo $hotels->h_create->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_create" class="hotels_h_create">
<span<?php echo $hotels->h_create->ViewAttributes() ?>>
<?php echo $hotels->h_create->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->dest_id->Visible) { // dest_id ?>
		<td data-name="dest_id"<?php echo $hotels->dest_id->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_dest_id" class="hotels_dest_id">
<span<?php echo $hotels->dest_id->ViewAttributes() ?>>
<?php echo $hotels->dest_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->province->Visible) { // province ?>
		<td data-name="province"<?php echo $hotels->province->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_province" class="hotels_province">
<span<?php echo $hotels->province->ViewAttributes() ?>>
<?php echo $hotels->province->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
		<td data-name="h_id_cod"<?php echo $hotels->h_id_cod->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_id_cod" class="hotels_h_id_cod">
<span<?php echo $hotels->h_id_cod->ViewAttributes() ?>>
<?php echo $hotels->h_id_cod->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_email->Visible) { // h_email ?>
		<td data-name="h_email"<?php echo $hotels->h_email->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_email" class="hotels_h_email">
<span<?php echo $hotels->h_email->ViewAttributes() ?>>
<?php echo $hotels->h_email->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
		<td data-name="h_contact_name"<?php echo $hotels->h_contact_name->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_contact_name" class="hotels_h_contact_name">
<span<?php echo $hotels->h_contact_name->ViewAttributes() ?>>
<?php echo $hotels->h_contact_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_pass->Visible) { // h_pass ?>
		<td data-name="h_pass"<?php echo $hotels->h_pass->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_pass" class="hotels_h_pass">
<span<?php echo $hotels->h_pass->ViewAttributes() ?>>
<?php echo $hotels->h_pass->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
		<td data-name="h_contact_phone"<?php echo $hotels->h_contact_phone->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_contact_phone" class="hotels_h_contact_phone">
<span<?php echo $hotels->h_contact_phone->ViewAttributes() ?>>
<?php echo $hotels->h_contact_phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_site->Visible) { // h_site ?>
		<td data-name="h_site"<?php echo $hotels->h_site->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_site" class="hotels_h_site">
<span<?php echo $hotels->h_site->ViewAttributes() ?>>
<?php echo $hotels->h_site->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
		<td data-name="contact_fax"<?php echo $hotels->contact_fax->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_contact_fax" class="hotels_contact_fax">
<span<?php echo $hotels->contact_fax->ViewAttributes() ?>>
<?php echo $hotels->contact_fax->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->star_rating->Visible) { // star_rating ?>
		<td data-name="star_rating"<?php echo $hotels->star_rating->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_star_rating" class="hotels_star_rating">
<span<?php echo $hotels->star_rating->ViewAttributes() ?>>
<?php echo $hotels->star_rating->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->create_date->Visible) { // create_date ?>
		<td data-name="create_date"<?php echo $hotels->create_date->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_create_date" class="hotels_create_date">
<span<?php echo $hotels->create_date->ViewAttributes() ?>>
<?php echo $hotels->create_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->update_date->Visible) { // update_date ?>
		<td data-name="update_date"<?php echo $hotels->update_date->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_update_date" class="hotels_update_date">
<span<?php echo $hotels->update_date->ViewAttributes() ?>>
<?php echo $hotels->update_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
		<td data-name="h_online_status"<?php echo $hotels->h_online_status->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_h_online_status" class="hotels_h_online_status">
<span<?php echo $hotels->h_online_status->ViewAttributes() ?>>
<?php echo $hotels->h_online_status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
		<td data-name="hotel_blocked"<?php echo $hotels->hotel_blocked->CellAttributes() ?>>
<span id="el<?php echo $hotels_list->RowCnt ?>_hotels_hotel_blocked" class="hotels_hotel_blocked">
<span<?php echo $hotels->hotel_blocked->ViewAttributes() ?>>
<?php echo $hotels->hotel_blocked->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$hotels_list->ListOptions->Render("body", "right", $hotels_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($hotels->CurrentAction <> "gridadd")
		$hotels_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($hotels->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($hotels_list->Recordset)
	$hotels_list->Recordset->Close();
?>
<?php if ($hotels->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($hotels->CurrentAction <> "gridadd" && $hotels->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotels_list->Pager)) $hotels_list->Pager = new cPrevNextPager($hotels_list->StartRec, $hotels_list->DisplayRecs, $hotels_list->TotalRecs) ?>
<?php if ($hotels_list->Pager->RecordCount > 0 && $hotels_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotels_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotels_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotels_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotels_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotels_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotels_list->PageUrl() ?>start=<?php echo $hotels_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotels_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $hotels_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $hotels_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $hotels_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotels_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($hotels_list->TotalRecs == 0 && $hotels->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($hotels_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($hotels->Export == "") { ?>
<script type="text/javascript">
fhotelslistsrch.FilterList = <?php echo $hotels_list->GetFilterList() ?>;
fhotelslistsrch.Init();
fhotelslist.Init();
</script>
<?php } ?>
<?php
$hotels_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($hotels->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$hotels_list->Page_Terminate();
?>

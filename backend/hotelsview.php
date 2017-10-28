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

$hotels_view = NULL; // Initialize page object first

class chotels_view extends chotels {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotels';

	// Page object name
	var $PageObjName = 'hotels_view';

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
		$KeyUrl = "";
		if (@$_GET["hotel_id"] <> "") {
			$this->RecKey["hotel_id"] = $_GET["hotel_id"];
			$KeyUrl .= "&amp;hotel_id=" . urlencode($this->RecKey["hotel_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotels', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("hotelslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
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
		if (@$_GET["hotel_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["hotel_id"]);
		}

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

		// Setup export options
		$this->SetupExportOptions();
		$this->hotel_id->SetVisibility();
		$this->hotel_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->h_name->SetVisibility();
		$this->h_slug->SetVisibility();
		$this->h_feature_image->SetVisibility();
		$this->h_description->SetVisibility();
		$this->h_meta_key->SetVisibility();
		$this->h_deatail->SetVisibility();
		$this->h_facilities->SetVisibility();
		$this->h_address->SetVisibility();
		$this->h_create->SetVisibility();
		$this->dest_id->SetVisibility();
		$this->province->SetVisibility();
		$this->whylike->SetVisibility();
		$this->lang_spoken->SetVisibility();
		$this->map->SetVisibility();
		$this->what_todo->SetVisibility();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["hotel_id"] <> "") {
				$this->hotel_id->setQueryStringValue($_GET["hotel_id"]);
				$this->RecKey["hotel_id"] = $this->hotel_id->QueryStringValue;
			} elseif (@$_POST["hotel_id"] <> "") {
				$this->hotel_id->setFormValue($_POST["hotel_id"]);
				$this->RecKey["hotel_id"] = $this->hotel_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					$this->StartRec = 1; // Initialize start position
					if ($this->Recordset = $this->LoadRecordset()) // Load records
						$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
					if ($this->TotalRecs <= 0) { // No record found
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$this->Page_Terminate("hotelslist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->hotel_id->CurrentValue) == strval($this->Recordset->fields('hotel_id'))) {
								$this->setStartRecordNumber($this->StartRec); // Save record position
								$bMatchRecord = TRUE;
								break;
							} else {
								$this->StartRec++;
								$this->Recordset->MoveNext();
							}
						}
					}
					if (!$bMatchRecord) {
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "hotelslist.php"; // No matching record, return to list
					} else {
						$this->LoadRowValues($this->Recordset); // Load row values
					}
			}

			// Export data only
			if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
				$this->ExportData();
				$this->Page_Terminate(); // Terminate response
				exit();
			}
		} else {
			$sReturnUrl = "hotelslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->IsLoggedIn());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->IsLoggedIn());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->IsLoggedIn());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->IsLoggedIn());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// h_description
		$this->h_description->ViewValue = $this->h_description->CurrentValue;
		$this->h_description->ViewCustomAttributes = "";

		// h_meta_key
		$this->h_meta_key->ViewValue = $this->h_meta_key->CurrentValue;
		$this->h_meta_key->ViewCustomAttributes = "";

		// h_deatail
		$this->h_deatail->ViewValue = $this->h_deatail->CurrentValue;
		$this->h_deatail->ViewCustomAttributes = "";

		// h_facilities
		$this->h_facilities->ViewValue = $this->h_facilities->CurrentValue;
		$this->h_facilities->ViewCustomAttributes = "";

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

		// whylike
		$this->whylike->ViewValue = $this->whylike->CurrentValue;
		$this->whylike->ViewCustomAttributes = "";

		// lang_spoken
		$this->lang_spoken->ViewValue = $this->lang_spoken->CurrentValue;
		$this->lang_spoken->ViewCustomAttributes = "";

		// map
		$this->map->ViewValue = $this->map->CurrentValue;
		$this->map->ViewCustomAttributes = "";

		// what_todo
		$this->what_todo->ViewValue = $this->what_todo->CurrentValue;
		$this->what_todo->ViewCustomAttributes = "";

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
				$this->h_feature_image->LinkAttrs["data-rel"] = "hotels_x_h_feature_image";
				ew_AppendClass($this->h_feature_image->LinkAttrs["class"], "ewLightbox");
			}

			// h_description
			$this->h_description->LinkCustomAttributes = "";
			$this->h_description->HrefValue = "";
			$this->h_description->TooltipValue = "";

			// h_meta_key
			$this->h_meta_key->LinkCustomAttributes = "";
			$this->h_meta_key->HrefValue = "";
			$this->h_meta_key->TooltipValue = "";

			// h_deatail
			$this->h_deatail->LinkCustomAttributes = "";
			$this->h_deatail->HrefValue = "";
			$this->h_deatail->TooltipValue = "";

			// h_facilities
			$this->h_facilities->LinkCustomAttributes = "";
			$this->h_facilities->HrefValue = "";
			$this->h_facilities->TooltipValue = "";

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

			// whylike
			$this->whylike->LinkCustomAttributes = "";
			$this->whylike->HrefValue = "";
			$this->whylike->TooltipValue = "";

			// lang_spoken
			$this->lang_spoken->LinkCustomAttributes = "";
			$this->lang_spoken->HrefValue = "";
			$this->lang_spoken->TooltipValue = "";

			// map
			$this->map->LinkCustomAttributes = "";
			$this->map->HrefValue = "";
			$this->map->TooltipValue = "";

			// what_todo
			$this->what_todo->LinkCustomAttributes = "";
			$this->what_todo->HrefValue = "";
			$this->what_todo->TooltipValue = "";

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
		$item->Body = "<button id=\"emf_hotels\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotels',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotelsview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Hide options for export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = FALSE;

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
		$this->SetUpStartRec(); // Set up start record position

		// Set the last record to display
		if ($this->DisplayRecs <= 0) {
			$this->StopRec = $this->TotalRecs;
		} else {
			$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
		}
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "v");
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
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "view");
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

		// Add record key QueryString
		$sQry .= "&" . substr($this->KeyUrl("", ""), 1);
		return $sQry;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotelslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($hotels_view)) $hotels_view = new chotels_view();

// Page init
$hotels_view->Page_Init();

// Page main
$hotels_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotels_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotels->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhotelsview = new ew_Form("fhotelsview", "view");

// Form_CustomValidate event
fhotelsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotelsview.ValidateRequired = true;
<?php } else { ?>
fhotelsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotelsview.Lists["x_h_online_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsview.Lists["x_h_online_status"].Options = <?php echo json_encode($hotels->h_online_status->Options()) ?>;
fhotelsview.Lists["x_hotel_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsview.Lists["x_hotel_blocked"].Options = <?php echo json_encode($hotels->hotel_blocked->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotels->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$hotels_view->IsModal) { ?>
<?php if ($hotels->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $hotels_view->ExportOptions->Render("body") ?>
<?php
	foreach ($hotels_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$hotels_view->IsModal) { ?>
<?php if ($hotels->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotels_view->ShowPageHeader(); ?>
<?php
$hotels_view->ShowMessage();
?>
<?php if (!$hotels_view->IsModal) { ?>
<?php if ($hotels->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotels_view->Pager)) $hotels_view->Pager = new cPrevNextPager($hotels_view->StartRec, $hotels_view->DisplayRecs, $hotels_view->TotalRecs) ?>
<?php if ($hotels_view->Pager->RecordCount > 0 && $hotels_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotels_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotels_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotels_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotels_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotels_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotels_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fhotelsview" id="fhotelsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotels_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotels_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotels">
<?php if ($hotels_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($hotels->hotel_id->Visible) { // hotel_id ?>
	<tr id="r_hotel_id">
		<td><span id="elh_hotels_hotel_id"><?php echo $hotels->hotel_id->FldCaption() ?></span></td>
		<td data-name="hotel_id"<?php echo $hotels->hotel_id->CellAttributes() ?>>
<span id="el_hotels_hotel_id">
<span<?php echo $hotels->hotel_id->ViewAttributes() ?>>
<?php echo $hotels->hotel_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_name->Visible) { // h_name ?>
	<tr id="r_h_name">
		<td><span id="elh_hotels_h_name"><?php echo $hotels->h_name->FldCaption() ?></span></td>
		<td data-name="h_name"<?php echo $hotels->h_name->CellAttributes() ?>>
<span id="el_hotels_h_name">
<span<?php echo $hotels->h_name->ViewAttributes() ?>>
<?php echo $hotels->h_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_slug->Visible) { // h_slug ?>
	<tr id="r_h_slug">
		<td><span id="elh_hotels_h_slug"><?php echo $hotels->h_slug->FldCaption() ?></span></td>
		<td data-name="h_slug"<?php echo $hotels->h_slug->CellAttributes() ?>>
<span id="el_hotels_h_slug">
<span<?php echo $hotels->h_slug->ViewAttributes() ?>>
<?php echo $hotels->h_slug->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
	<tr id="r_h_feature_image">
		<td><span id="elh_hotels_h_feature_image"><?php echo $hotels->h_feature_image->FldCaption() ?></span></td>
		<td data-name="h_feature_image"<?php echo $hotels->h_feature_image->CellAttributes() ?>>
<span id="el_hotels_h_feature_image">
<span>
<?php echo ew_GetFileViewTag($hotels->h_feature_image, $hotels->h_feature_image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_description->Visible) { // h_description ?>
	<tr id="r_h_description">
		<td><span id="elh_hotels_h_description"><?php echo $hotels->h_description->FldCaption() ?></span></td>
		<td data-name="h_description"<?php echo $hotels->h_description->CellAttributes() ?>>
<span id="el_hotels_h_description">
<span<?php echo $hotels->h_description->ViewAttributes() ?>>
<?php echo $hotels->h_description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_meta_key->Visible) { // h_meta_key ?>
	<tr id="r_h_meta_key">
		<td><span id="elh_hotels_h_meta_key"><?php echo $hotels->h_meta_key->FldCaption() ?></span></td>
		<td data-name="h_meta_key"<?php echo $hotels->h_meta_key->CellAttributes() ?>>
<span id="el_hotels_h_meta_key">
<span<?php echo $hotels->h_meta_key->ViewAttributes() ?>>
<?php echo $hotels->h_meta_key->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_deatail->Visible) { // h_deatail ?>
	<tr id="r_h_deatail">
		<td><span id="elh_hotels_h_deatail"><?php echo $hotels->h_deatail->FldCaption() ?></span></td>
		<td data-name="h_deatail"<?php echo $hotels->h_deatail->CellAttributes() ?>>
<span id="el_hotels_h_deatail">
<span<?php echo $hotels->h_deatail->ViewAttributes() ?>>
<?php echo $hotels->h_deatail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_facilities->Visible) { // h_facilities ?>
	<tr id="r_h_facilities">
		<td><span id="elh_hotels_h_facilities"><?php echo $hotels->h_facilities->FldCaption() ?></span></td>
		<td data-name="h_facilities"<?php echo $hotels->h_facilities->CellAttributes() ?>>
<span id="el_hotels_h_facilities">
<span<?php echo $hotels->h_facilities->ViewAttributes() ?>>
<?php echo $hotels->h_facilities->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_address->Visible) { // h_address ?>
	<tr id="r_h_address">
		<td><span id="elh_hotels_h_address"><?php echo $hotels->h_address->FldCaption() ?></span></td>
		<td data-name="h_address"<?php echo $hotels->h_address->CellAttributes() ?>>
<span id="el_hotels_h_address">
<span<?php echo $hotels->h_address->ViewAttributes() ?>>
<?php echo $hotels->h_address->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_create->Visible) { // h_create ?>
	<tr id="r_h_create">
		<td><span id="elh_hotels_h_create"><?php echo $hotels->h_create->FldCaption() ?></span></td>
		<td data-name="h_create"<?php echo $hotels->h_create->CellAttributes() ?>>
<span id="el_hotels_h_create">
<span<?php echo $hotels->h_create->ViewAttributes() ?>>
<?php echo $hotels->h_create->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->dest_id->Visible) { // dest_id ?>
	<tr id="r_dest_id">
		<td><span id="elh_hotels_dest_id"><?php echo $hotels->dest_id->FldCaption() ?></span></td>
		<td data-name="dest_id"<?php echo $hotels->dest_id->CellAttributes() ?>>
<span id="el_hotels_dest_id">
<span<?php echo $hotels->dest_id->ViewAttributes() ?>>
<?php echo $hotels->dest_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->province->Visible) { // province ?>
	<tr id="r_province">
		<td><span id="elh_hotels_province"><?php echo $hotels->province->FldCaption() ?></span></td>
		<td data-name="province"<?php echo $hotels->province->CellAttributes() ?>>
<span id="el_hotels_province">
<span<?php echo $hotels->province->ViewAttributes() ?>>
<?php echo $hotels->province->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->whylike->Visible) { // whylike ?>
	<tr id="r_whylike">
		<td><span id="elh_hotels_whylike"><?php echo $hotels->whylike->FldCaption() ?></span></td>
		<td data-name="whylike"<?php echo $hotels->whylike->CellAttributes() ?>>
<span id="el_hotels_whylike">
<span<?php echo $hotels->whylike->ViewAttributes() ?>>
<?php echo $hotels->whylike->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->lang_spoken->Visible) { // lang_spoken ?>
	<tr id="r_lang_spoken">
		<td><span id="elh_hotels_lang_spoken"><?php echo $hotels->lang_spoken->FldCaption() ?></span></td>
		<td data-name="lang_spoken"<?php echo $hotels->lang_spoken->CellAttributes() ?>>
<span id="el_hotels_lang_spoken">
<span<?php echo $hotels->lang_spoken->ViewAttributes() ?>>
<?php echo $hotels->lang_spoken->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->map->Visible) { // map ?>
	<tr id="r_map">
		<td><span id="elh_hotels_map"><?php echo $hotels->map->FldCaption() ?></span></td>
		<td data-name="map"<?php echo $hotels->map->CellAttributes() ?>>
<span id="el_hotels_map">
<span<?php echo $hotels->map->ViewAttributes() ?>>
<?php echo $hotels->map->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->what_todo->Visible) { // what_todo ?>
	<tr id="r_what_todo">
		<td><span id="elh_hotels_what_todo"><?php echo $hotels->what_todo->FldCaption() ?></span></td>
		<td data-name="what_todo"<?php echo $hotels->what_todo->CellAttributes() ?>>
<span id="el_hotels_what_todo">
<span<?php echo $hotels->what_todo->ViewAttributes() ?>>
<?php echo $hotels->what_todo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
	<tr id="r_h_id_cod">
		<td><span id="elh_hotels_h_id_cod"><?php echo $hotels->h_id_cod->FldCaption() ?></span></td>
		<td data-name="h_id_cod"<?php echo $hotels->h_id_cod->CellAttributes() ?>>
<span id="el_hotels_h_id_cod">
<span<?php echo $hotels->h_id_cod->ViewAttributes() ?>>
<?php echo $hotels->h_id_cod->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_email->Visible) { // h_email ?>
	<tr id="r_h_email">
		<td><span id="elh_hotels_h_email"><?php echo $hotels->h_email->FldCaption() ?></span></td>
		<td data-name="h_email"<?php echo $hotels->h_email->CellAttributes() ?>>
<span id="el_hotels_h_email">
<span<?php echo $hotels->h_email->ViewAttributes() ?>>
<?php echo $hotels->h_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
	<tr id="r_h_contact_name">
		<td><span id="elh_hotels_h_contact_name"><?php echo $hotels->h_contact_name->FldCaption() ?></span></td>
		<td data-name="h_contact_name"<?php echo $hotels->h_contact_name->CellAttributes() ?>>
<span id="el_hotels_h_contact_name">
<span<?php echo $hotels->h_contact_name->ViewAttributes() ?>>
<?php echo $hotels->h_contact_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_pass->Visible) { // h_pass ?>
	<tr id="r_h_pass">
		<td><span id="elh_hotels_h_pass"><?php echo $hotels->h_pass->FldCaption() ?></span></td>
		<td data-name="h_pass"<?php echo $hotels->h_pass->CellAttributes() ?>>
<span id="el_hotels_h_pass">
<span<?php echo $hotels->h_pass->ViewAttributes() ?>>
<?php echo $hotels->h_pass->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
	<tr id="r_h_contact_phone">
		<td><span id="elh_hotels_h_contact_phone"><?php echo $hotels->h_contact_phone->FldCaption() ?></span></td>
		<td data-name="h_contact_phone"<?php echo $hotels->h_contact_phone->CellAttributes() ?>>
<span id="el_hotels_h_contact_phone">
<span<?php echo $hotels->h_contact_phone->ViewAttributes() ?>>
<?php echo $hotels->h_contact_phone->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_site->Visible) { // h_site ?>
	<tr id="r_h_site">
		<td><span id="elh_hotels_h_site"><?php echo $hotels->h_site->FldCaption() ?></span></td>
		<td data-name="h_site"<?php echo $hotels->h_site->CellAttributes() ?>>
<span id="el_hotels_h_site">
<span<?php echo $hotels->h_site->ViewAttributes() ?>>
<?php echo $hotels->h_site->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
	<tr id="r_contact_fax">
		<td><span id="elh_hotels_contact_fax"><?php echo $hotels->contact_fax->FldCaption() ?></span></td>
		<td data-name="contact_fax"<?php echo $hotels->contact_fax->CellAttributes() ?>>
<span id="el_hotels_contact_fax">
<span<?php echo $hotels->contact_fax->ViewAttributes() ?>>
<?php echo $hotels->contact_fax->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->star_rating->Visible) { // star_rating ?>
	<tr id="r_star_rating">
		<td><span id="elh_hotels_star_rating"><?php echo $hotels->star_rating->FldCaption() ?></span></td>
		<td data-name="star_rating"<?php echo $hotels->star_rating->CellAttributes() ?>>
<span id="el_hotels_star_rating">
<span<?php echo $hotels->star_rating->ViewAttributes() ?>>
<?php echo $hotels->star_rating->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->create_date->Visible) { // create_date ?>
	<tr id="r_create_date">
		<td><span id="elh_hotels_create_date"><?php echo $hotels->create_date->FldCaption() ?></span></td>
		<td data-name="create_date"<?php echo $hotels->create_date->CellAttributes() ?>>
<span id="el_hotels_create_date">
<span<?php echo $hotels->create_date->ViewAttributes() ?>>
<?php echo $hotels->create_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->update_date->Visible) { // update_date ?>
	<tr id="r_update_date">
		<td><span id="elh_hotels_update_date"><?php echo $hotels->update_date->FldCaption() ?></span></td>
		<td data-name="update_date"<?php echo $hotels->update_date->CellAttributes() ?>>
<span id="el_hotels_update_date">
<span<?php echo $hotels->update_date->ViewAttributes() ?>>
<?php echo $hotels->update_date->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
	<tr id="r_h_online_status">
		<td><span id="elh_hotels_h_online_status"><?php echo $hotels->h_online_status->FldCaption() ?></span></td>
		<td data-name="h_online_status"<?php echo $hotels->h_online_status->CellAttributes() ?>>
<span id="el_hotels_h_online_status">
<span<?php echo $hotels->h_online_status->ViewAttributes() ?>>
<?php echo $hotels->h_online_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
	<tr id="r_hotel_blocked">
		<td><span id="elh_hotels_hotel_blocked"><?php echo $hotels->hotel_blocked->FldCaption() ?></span></td>
		<td data-name="hotel_blocked"<?php echo $hotels->hotel_blocked->CellAttributes() ?>>
<span id="el_hotels_hotel_blocked">
<span<?php echo $hotels->hotel_blocked->ViewAttributes() ?>>
<?php echo $hotels->hotel_blocked->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$hotels_view->IsModal) { ?>
<?php if ($hotels->Export == "") { ?>
<?php if (!isset($hotels_view->Pager)) $hotels_view->Pager = new cPrevNextPager($hotels_view->StartRec, $hotels_view->DisplayRecs, $hotels_view->TotalRecs) ?>
<?php if ($hotels_view->Pager->RecordCount > 0 && $hotels_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotels_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotels_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotels_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotels_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotels_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotels_view->PageUrl() ?>start=<?php echo $hotels_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotels_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php if ($hotels->Export == "") { ?>
<script type="text/javascript">
fhotelsview.Init();
</script>
<?php } ?>
<?php
$hotels_view->ShowPageFooter();
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
$hotels_view->Page_Terminate();
?>

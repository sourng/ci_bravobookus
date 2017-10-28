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

$hotel_booking_view = NULL; // Initialize page object first

class chotel_booking_view extends chotel_booking {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_booking';

	// Page object name
	var $PageObjName = 'hotel_booking_view';

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
		$KeyUrl = "";
		if (@$_GET["booking_id"] <> "") {
			$this->RecKey["booking_id"] = $_GET["booking_id"];
			$KeyUrl .= "&amp;booking_id=" . urlencode($this->RecKey["booking_id"]);
		}
		if (@$_GET["hroom_id"] <> "") {
			$this->RecKey["hroom_id"] = $_GET["hroom_id"];
			$KeyUrl .= "&amp;hroom_id=" . urlencode($this->RecKey["hroom_id"]);
		}
		if (@$_GET["customer_id"] <> "") {
			$this->RecKey["customer_id"] = $_GET["customer_id"];
			$KeyUrl .= "&amp;customer_id=" . urlencode($this->RecKey["customer_id"]);
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
			define("EW_TABLE_NAME", 'hotel_booking', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_bookinglist.php"));
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
		if (@$_GET["booking_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["booking_id"]);
		}
		if (@$_GET["hroom_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["hroom_id"]);
		}
		if (@$_GET["customer_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["customer_id"]);
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
		$this->notes->SetVisibility();

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
			if (@$_GET["booking_id"] <> "") {
				$this->booking_id->setQueryStringValue($_GET["booking_id"]);
				$this->RecKey["booking_id"] = $this->booking_id->QueryStringValue;
			} elseif (@$_POST["booking_id"] <> "") {
				$this->booking_id->setFormValue($_POST["booking_id"]);
				$this->RecKey["booking_id"] = $this->booking_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
			if (@$_GET["hroom_id"] <> "") {
				$this->hroom_id->setQueryStringValue($_GET["hroom_id"]);
				$this->RecKey["hroom_id"] = $this->hroom_id->QueryStringValue;
			} elseif (@$_POST["hroom_id"] <> "") {
				$this->hroom_id->setFormValue($_POST["hroom_id"]);
				$this->RecKey["hroom_id"] = $this->hroom_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
			if (@$_GET["customer_id"] <> "") {
				$this->customer_id->setQueryStringValue($_GET["customer_id"]);
				$this->RecKey["customer_id"] = $this->customer_id->QueryStringValue;
			} elseif (@$_POST["customer_id"] <> "") {
				$this->customer_id->setFormValue($_POST["customer_id"]);
				$this->RecKey["customer_id"] = $this->customer_id->FormValue;
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
						$this->Page_Terminate("hotel_bookinglist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->booking_id->CurrentValue) == strval($this->Recordset->fields('booking_id')) && strval($this->hroom_id->CurrentValue) == strval($this->Recordset->fields('hroom_id')) && strval($this->customer_id->CurrentValue) == strval($this->Recordset->fields('customer_id'))) {
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
						$sReturnUrl = "hotel_bookinglist.php"; // No matching record, return to list
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
			$sReturnUrl = "hotel_bookinglist.php"; // Not page request, return to list
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

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

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

			// notes
			$this->notes->LinkCustomAttributes = "";
			$this->notes->HrefValue = "";
			$this->notes->TooltipValue = "";
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
		$item->Body = "<button id=\"emf_hotel_booking\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotel_booking',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotel_bookingview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_bookinglist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_booking_view)) $hotel_booking_view = new chotel_booking_view();

// Page init
$hotel_booking_view->Page_Init();

// Page main
$hotel_booking_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_booking_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotel_booking->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhotel_bookingview = new ew_Form("fhotel_bookingview", "view");

// Form_CustomValidate event
fhotel_bookingview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_bookingview.ValidateRequired = true;
<?php } else { ?>
fhotel_bookingview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotel_booking->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$hotel_booking_view->IsModal) { ?>
<?php if ($hotel_booking->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $hotel_booking_view->ExportOptions->Render("body") ?>
<?php
	foreach ($hotel_booking_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$hotel_booking_view->IsModal) { ?>
<?php if ($hotel_booking->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_booking_view->ShowPageHeader(); ?>
<?php
$hotel_booking_view->ShowMessage();
?>
<?php if (!$hotel_booking_view->IsModal) { ?>
<?php if ($hotel_booking->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_booking_view->Pager)) $hotel_booking_view->Pager = new cPrevNextPager($hotel_booking_view->StartRec, $hotel_booking_view->DisplayRecs, $hotel_booking_view->TotalRecs) ?>
<?php if ($hotel_booking_view->Pager->RecordCount > 0 && $hotel_booking_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_booking_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_booking_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_booking_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_booking_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_booking_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_booking_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fhotel_bookingview" id="fhotel_bookingview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_booking_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_booking_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_booking">
<?php if ($hotel_booking_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($hotel_booking->booking_id->Visible) { // booking_id ?>
	<tr id="r_booking_id">
		<td><span id="elh_hotel_booking_booking_id"><?php echo $hotel_booking->booking_id->FldCaption() ?></span></td>
		<td data-name="booking_id"<?php echo $hotel_booking->booking_id->CellAttributes() ?>>
<span id="el_hotel_booking_booking_id">
<span<?php echo $hotel_booking->booking_id->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->hroom_id->Visible) { // hroom_id ?>
	<tr id="r_hroom_id">
		<td><span id="elh_hotel_booking_hroom_id"><?php echo $hotel_booking->hroom_id->FldCaption() ?></span></td>
		<td data-name="hroom_id"<?php echo $hotel_booking->hroom_id->CellAttributes() ?>>
<span id="el_hotel_booking_hroom_id">
<span<?php echo $hotel_booking->hroom_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hroom_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->customer_id->Visible) { // customer_id ?>
	<tr id="r_customer_id">
		<td><span id="elh_hotel_booking_customer_id"><?php echo $hotel_booking->customer_id->FldCaption() ?></span></td>
		<td data-name="customer_id"<?php echo $hotel_booking->customer_id->CellAttributes() ?>>
<span id="el_hotel_booking_customer_id">
<span<?php echo $hotel_booking->customer_id->ViewAttributes() ?>>
<?php echo $hotel_booking->customer_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->hotel_id->Visible) { // hotel_id ?>
	<tr id="r_hotel_id">
		<td><span id="elh_hotel_booking_hotel_id"><?php echo $hotel_booking->hotel_id->FldCaption() ?></span></td>
		<td data-name="hotel_id"<?php echo $hotel_booking->hotel_id->CellAttributes() ?>>
<span id="el_hotel_booking_hotel_id">
<span<?php echo $hotel_booking->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_booking->hotel_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->room_type->Visible) { // room_type ?>
	<tr id="r_room_type">
		<td><span id="elh_hotel_booking_room_type"><?php echo $hotel_booking->room_type->FldCaption() ?></span></td>
		<td data-name="room_type"<?php echo $hotel_booking->room_type->CellAttributes() ?>>
<span id="el_hotel_booking_room_type">
<span<?php echo $hotel_booking->room_type->ViewAttributes() ?>>
<?php echo $hotel_booking->room_type->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->max_adult->Visible) { // max_adult ?>
	<tr id="r_max_adult">
		<td><span id="elh_hotel_booking_max_adult"><?php echo $hotel_booking->max_adult->FldCaption() ?></span></td>
		<td data-name="max_adult"<?php echo $hotel_booking->max_adult->CellAttributes() ?>>
<span id="el_hotel_booking_max_adult">
<span<?php echo $hotel_booking->max_adult->ViewAttributes() ?>>
<?php echo $hotel_booking->max_adult->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->max_child->Visible) { // max_child ?>
	<tr id="r_max_child">
		<td><span id="elh_hotel_booking_max_child"><?php echo $hotel_booking->max_child->FldCaption() ?></span></td>
		<td data-name="max_child"<?php echo $hotel_booking->max_child->CellAttributes() ?>>
<span id="el_hotel_booking_max_child">
<span<?php echo $hotel_booking->max_child->ViewAttributes() ?>>
<?php echo $hotel_booking->max_child->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->cus_email->Visible) { // cus_email ?>
	<tr id="r_cus_email">
		<td><span id="elh_hotel_booking_cus_email"><?php echo $hotel_booking->cus_email->FldCaption() ?></span></td>
		<td data-name="cus_email"<?php echo $hotel_booking->cus_email->CellAttributes() ?>>
<span id="el_hotel_booking_cus_email">
<span<?php echo $hotel_booking->cus_email->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->cus_passport->Visible) { // cus_passport ?>
	<tr id="r_cus_passport">
		<td><span id="elh_hotel_booking_cus_passport"><?php echo $hotel_booking->cus_passport->FldCaption() ?></span></td>
		<td data-name="cus_passport"<?php echo $hotel_booking->cus_passport->CellAttributes() ?>>
<span id="el_hotel_booking_cus_passport">
<span<?php echo $hotel_booking->cus_passport->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_passport->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->cus_pickup->Visible) { // cus_pickup ?>
	<tr id="r_cus_pickup">
		<td><span id="elh_hotel_booking_cus_pickup"><?php echo $hotel_booking->cus_pickup->FldCaption() ?></span></td>
		<td data-name="cus_pickup"<?php echo $hotel_booking->cus_pickup->CellAttributes() ?>>
<span id="el_hotel_booking_cus_pickup">
<span<?php echo $hotel_booking->cus_pickup->ViewAttributes() ?>>
<?php echo $hotel_booking->cus_pickup->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->check_in->Visible) { // check_in ?>
	<tr id="r_check_in">
		<td><span id="elh_hotel_booking_check_in"><?php echo $hotel_booking->check_in->FldCaption() ?></span></td>
		<td data-name="check_in"<?php echo $hotel_booking->check_in->CellAttributes() ?>>
<span id="el_hotel_booking_check_in">
<span<?php echo $hotel_booking->check_in->ViewAttributes() ?>>
<?php echo $hotel_booking->check_in->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->check_out->Visible) { // check_out ?>
	<tr id="r_check_out">
		<td><span id="elh_hotel_booking_check_out"><?php echo $hotel_booking->check_out->FldCaption() ?></span></td>
		<td data-name="check_out"<?php echo $hotel_booking->check_out->CellAttributes() ?>>
<span id="el_hotel_booking_check_out">
<span<?php echo $hotel_booking->check_out->ViewAttributes() ?>>
<?php echo $hotel_booking->check_out->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->max_day_stay->Visible) { // max_day_stay ?>
	<tr id="r_max_day_stay">
		<td><span id="elh_hotel_booking_max_day_stay"><?php echo $hotel_booking->max_day_stay->FldCaption() ?></span></td>
		<td data-name="max_day_stay"<?php echo $hotel_booking->max_day_stay->CellAttributes() ?>>
<span id="el_hotel_booking_max_day_stay">
<span<?php echo $hotel_booking->max_day_stay->ViewAttributes() ?>>
<?php echo $hotel_booking->max_day_stay->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->total_amount->Visible) { // total_amount ?>
	<tr id="r_total_amount">
		<td><span id="elh_hotel_booking_total_amount"><?php echo $hotel_booking->total_amount->FldCaption() ?></span></td>
		<td data-name="total_amount"<?php echo $hotel_booking->total_amount->CellAttributes() ?>>
<span id="el_hotel_booking_total_amount">
<span<?php echo $hotel_booking->total_amount->ViewAttributes() ?>>
<?php echo $hotel_booking->total_amount->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->booking_status->Visible) { // booking_status ?>
	<tr id="r_booking_status">
		<td><span id="elh_hotel_booking_booking_status"><?php echo $hotel_booking->booking_status->FldCaption() ?></span></td>
		<td data-name="booking_status"<?php echo $hotel_booking->booking_status->CellAttributes() ?>>
<span id="el_hotel_booking_booking_status">
<span<?php echo $hotel_booking->booking_status->ViewAttributes() ?>>
<?php echo $hotel_booking->booking_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_booking->notes->Visible) { // notes ?>
	<tr id="r_notes">
		<td><span id="elh_hotel_booking_notes"><?php echo $hotel_booking->notes->FldCaption() ?></span></td>
		<td data-name="notes"<?php echo $hotel_booking->notes->CellAttributes() ?>>
<span id="el_hotel_booking_notes">
<span<?php echo $hotel_booking->notes->ViewAttributes() ?>>
<?php echo $hotel_booking->notes->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$hotel_booking_view->IsModal) { ?>
<?php if ($hotel_booking->Export == "") { ?>
<?php if (!isset($hotel_booking_view->Pager)) $hotel_booking_view->Pager = new cPrevNextPager($hotel_booking_view->StartRec, $hotel_booking_view->DisplayRecs, $hotel_booking_view->TotalRecs) ?>
<?php if ($hotel_booking_view->Pager->RecordCount > 0 && $hotel_booking_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_booking_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_booking_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_booking_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_booking_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_booking_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_booking_view->PageUrl() ?>start=<?php echo $hotel_booking_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_booking_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php if ($hotel_booking->Export == "") { ?>
<script type="text/javascript">
fhotel_bookingview.Init();
</script>
<?php } ?>
<?php
$hotel_booking_view->ShowPageFooter();
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
$hotel_booking_view->Page_Terminate();
?>

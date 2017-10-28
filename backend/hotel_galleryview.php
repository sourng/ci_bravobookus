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

$hotel_gallery_view = NULL; // Initialize page object first

class chotel_gallery_view extends chotel_gallery {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotel_gallery';

	// Page object name
	var $PageObjName = 'hotel_gallery_view';

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

		// Table object (hotel_gallery)
		if (!isset($GLOBALS["hotel_gallery"]) || get_class($GLOBALS["hotel_gallery"]) == "chotel_gallery") {
			$GLOBALS["hotel_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotel_gallery"];
		}
		$KeyUrl = "";
		if (@$_GET["hgallery_id"] <> "") {
			$this->RecKey["hgallery_id"] = $_GET["hgallery_id"];
			$KeyUrl .= "&amp;hgallery_id=" . urlencode($this->RecKey["hgallery_id"]);
		}
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
			define("EW_TABLE_NAME", 'hotel_gallery', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotel_gallerylist.php"));
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
		if (@$_GET["hgallery_id"] <> "") {
			if ($gsExportFile <> "") $gsExportFile .= "_";
			$gsExportFile .= ew_StripSlashes($_GET["hgallery_id"]);
		}
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
			if (@$_GET["hgallery_id"] <> "") {
				$this->hgallery_id->setQueryStringValue($_GET["hgallery_id"]);
				$this->RecKey["hgallery_id"] = $this->hgallery_id->QueryStringValue;
			} elseif (@$_POST["hgallery_id"] <> "") {
				$this->hgallery_id->setFormValue($_POST["hgallery_id"]);
				$this->RecKey["hgallery_id"] = $this->hgallery_id->FormValue;
			} else {
				$bLoadCurrentRecord = TRUE;
			}
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
						$this->Page_Terminate("hotel_gallerylist.php"); // Return to list page
					} elseif ($bLoadCurrentRecord) { // Load current record position
						$this->SetUpStartRec(); // Set up start record position

						// Point to current record
						if (intval($this->StartRec) <= intval($this->TotalRecs)) {
							$bMatchRecord = TRUE;
							$this->Recordset->Move($this->StartRec-1);
						}
					} else { // Match key values
						while (!$this->Recordset->EOF) {
							if (strval($this->hgallery_id->CurrentValue) == strval($this->Recordset->fields('hgallery_id')) && strval($this->hotel_id->CurrentValue) == strval($this->Recordset->fields('hotel_id'))) {
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
						$sReturnUrl = "hotel_gallerylist.php"; // No matching record, return to list
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
			$sReturnUrl = "hotel_gallerylist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$item->Body = "<button id=\"emf_hotel_gallery\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_hotel_gallery',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fhotel_galleryview,key:" . ew_ArrayToJsonAttr($this->RecKey) . ",sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotel_gallerylist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotel_gallery_view)) $hotel_gallery_view = new chotel_gallery_view();

// Page init
$hotel_gallery_view->Page_Init();

// Page main
$hotel_gallery_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotel_gallery_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($hotel_gallery->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fhotel_galleryview = new ew_Form("fhotel_galleryview", "view");

// Form_CustomValidate event
fhotel_galleryview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotel_galleryview.ValidateRequired = true;
<?php } else { ?>
fhotel_galleryview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($hotel_gallery->Export == "") { ?>
<div class="ewToolbar">
<?php if (!$hotel_gallery_view->IsModal) { ?>
<?php if ($hotel_gallery->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php } ?>
<?php $hotel_gallery_view->ExportOptions->Render("body") ?>
<?php
	foreach ($hotel_gallery_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$hotel_gallery_view->IsModal) { ?>
<?php if ($hotel_gallery->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $hotel_gallery_view->ShowPageHeader(); ?>
<?php
$hotel_gallery_view->ShowMessage();
?>
<?php if (!$hotel_gallery_view->IsModal) { ?>
<?php if ($hotel_gallery->Export == "") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($hotel_gallery_view->Pager)) $hotel_gallery_view->Pager = new cPrevNextPager($hotel_gallery_view->StartRec, $hotel_gallery_view->DisplayRecs, $hotel_gallery_view->TotalRecs) ?>
<?php if ($hotel_gallery_view->Pager->RecordCount > 0 && $hotel_gallery_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_gallery_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_gallery_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_gallery_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_gallery_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_gallery_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_gallery_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="fhotel_galleryview" id="fhotel_galleryview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotel_gallery_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotel_gallery_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotel_gallery">
<?php if ($hotel_gallery_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped ewViewTable">
<?php if ($hotel_gallery->hgallery_id->Visible) { // hgallery_id ?>
	<tr id="r_hgallery_id">
		<td><span id="elh_hotel_gallery_hgallery_id"><?php echo $hotel_gallery->hgallery_id->FldCaption() ?></span></td>
		<td data-name="hgallery_id"<?php echo $hotel_gallery->hgallery_id->CellAttributes() ?>>
<span id="el_hotel_gallery_hgallery_id">
<span<?php echo $hotel_gallery->hgallery_id->ViewAttributes() ?>>
<?php echo $hotel_gallery->hgallery_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hotel_id->Visible) { // hotel_id ?>
	<tr id="r_hotel_id">
		<td><span id="elh_hotel_gallery_hotel_id"><?php echo $hotel_gallery->hotel_id->FldCaption() ?></span></td>
		<td data-name="hotel_id"<?php echo $hotel_gallery->hotel_id->CellAttributes() ?>>
<span id="el_hotel_gallery_hotel_id">
<span<?php echo $hotel_gallery->hotel_id->ViewAttributes() ?>>
<?php echo $hotel_gallery->hotel_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img1->Visible) { // hg_img1 ?>
	<tr id="r_hg_img1">
		<td><span id="elh_hotel_gallery_hg_img1"><?php echo $hotel_gallery->hg_img1->FldCaption() ?></span></td>
		<td data-name="hg_img1"<?php echo $hotel_gallery->hg_img1->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img1">
<span<?php echo $hotel_gallery->hg_img1->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img2->Visible) { // hg_img2 ?>
	<tr id="r_hg_img2">
		<td><span id="elh_hotel_gallery_hg_img2"><?php echo $hotel_gallery->hg_img2->FldCaption() ?></span></td>
		<td data-name="hg_img2"<?php echo $hotel_gallery->hg_img2->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img2">
<span<?php echo $hotel_gallery->hg_img2->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img3->Visible) { // hg_img3 ?>
	<tr id="r_hg_img3">
		<td><span id="elh_hotel_gallery_hg_img3"><?php echo $hotel_gallery->hg_img3->FldCaption() ?></span></td>
		<td data-name="hg_img3"<?php echo $hotel_gallery->hg_img3->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img3">
<span<?php echo $hotel_gallery->hg_img3->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img4->Visible) { // hg_img4 ?>
	<tr id="r_hg_img4">
		<td><span id="elh_hotel_gallery_hg_img4"><?php echo $hotel_gallery->hg_img4->FldCaption() ?></span></td>
		<td data-name="hg_img4"<?php echo $hotel_gallery->hg_img4->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img4">
<span<?php echo $hotel_gallery->hg_img4->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img5->Visible) { // hg_img5 ?>
	<tr id="r_hg_img5">
		<td><span id="elh_hotel_gallery_hg_img5"><?php echo $hotel_gallery->hg_img5->FldCaption() ?></span></td>
		<td data-name="hg_img5"<?php echo $hotel_gallery->hg_img5->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img5">
<span<?php echo $hotel_gallery->hg_img5->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img6->Visible) { // hg_img6 ?>
	<tr id="r_hg_img6">
		<td><span id="elh_hotel_gallery_hg_img6"><?php echo $hotel_gallery->hg_img6->FldCaption() ?></span></td>
		<td data-name="hg_img6"<?php echo $hotel_gallery->hg_img6->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img6">
<span<?php echo $hotel_gallery->hg_img6->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img6->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img7->Visible) { // hg_img7 ?>
	<tr id="r_hg_img7">
		<td><span id="elh_hotel_gallery_hg_img7"><?php echo $hotel_gallery->hg_img7->FldCaption() ?></span></td>
		<td data-name="hg_img7"<?php echo $hotel_gallery->hg_img7->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img7">
<span<?php echo $hotel_gallery->hg_img7->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img7->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img8->Visible) { // hg_img8 ?>
	<tr id="r_hg_img8">
		<td><span id="elh_hotel_gallery_hg_img8"><?php echo $hotel_gallery->hg_img8->FldCaption() ?></span></td>
		<td data-name="hg_img8"<?php echo $hotel_gallery->hg_img8->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img8">
<span<?php echo $hotel_gallery->hg_img8->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img8->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img9->Visible) { // hg_img9 ?>
	<tr id="r_hg_img9">
		<td><span id="elh_hotel_gallery_hg_img9"><?php echo $hotel_gallery->hg_img9->FldCaption() ?></span></td>
		<td data-name="hg_img9"<?php echo $hotel_gallery->hg_img9->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img9">
<span<?php echo $hotel_gallery->hg_img9->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img9->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img10->Visible) { // hg_img10 ?>
	<tr id="r_hg_img10">
		<td><span id="elh_hotel_gallery_hg_img10"><?php echo $hotel_gallery->hg_img10->FldCaption() ?></span></td>
		<td data-name="hg_img10"<?php echo $hotel_gallery->hg_img10->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img10">
<span<?php echo $hotel_gallery->hg_img10->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img10->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img11->Visible) { // hg_img11 ?>
	<tr id="r_hg_img11">
		<td><span id="elh_hotel_gallery_hg_img11"><?php echo $hotel_gallery->hg_img11->FldCaption() ?></span></td>
		<td data-name="hg_img11"<?php echo $hotel_gallery->hg_img11->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img11">
<span<?php echo $hotel_gallery->hg_img11->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img11->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img12->Visible) { // hg_img12 ?>
	<tr id="r_hg_img12">
		<td><span id="elh_hotel_gallery_hg_img12"><?php echo $hotel_gallery->hg_img12->FldCaption() ?></span></td>
		<td data-name="hg_img12"<?php echo $hotel_gallery->hg_img12->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img12">
<span<?php echo $hotel_gallery->hg_img12->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img12->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img13->Visible) { // hg_img13 ?>
	<tr id="r_hg_img13">
		<td><span id="elh_hotel_gallery_hg_img13"><?php echo $hotel_gallery->hg_img13->FldCaption() ?></span></td>
		<td data-name="hg_img13"<?php echo $hotel_gallery->hg_img13->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img13">
<span<?php echo $hotel_gallery->hg_img13->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img13->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img14->Visible) { // hg_img14 ?>
	<tr id="r_hg_img14">
		<td><span id="elh_hotel_gallery_hg_img14"><?php echo $hotel_gallery->hg_img14->FldCaption() ?></span></td>
		<td data-name="hg_img14"<?php echo $hotel_gallery->hg_img14->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img14">
<span<?php echo $hotel_gallery->hg_img14->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img14->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img15->Visible) { // hg_img15 ?>
	<tr id="r_hg_img15">
		<td><span id="elh_hotel_gallery_hg_img15"><?php echo $hotel_gallery->hg_img15->FldCaption() ?></span></td>
		<td data-name="hg_img15"<?php echo $hotel_gallery->hg_img15->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img15">
<span<?php echo $hotel_gallery->hg_img15->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img15->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img16->Visible) { // hg_img16 ?>
	<tr id="r_hg_img16">
		<td><span id="elh_hotel_gallery_hg_img16"><?php echo $hotel_gallery->hg_img16->FldCaption() ?></span></td>
		<td data-name="hg_img16"<?php echo $hotel_gallery->hg_img16->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img16">
<span<?php echo $hotel_gallery->hg_img16->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img16->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img17->Visible) { // hg_img17 ?>
	<tr id="r_hg_img17">
		<td><span id="elh_hotel_gallery_hg_img17"><?php echo $hotel_gallery->hg_img17->FldCaption() ?></span></td>
		<td data-name="hg_img17"<?php echo $hotel_gallery->hg_img17->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img17">
<span<?php echo $hotel_gallery->hg_img17->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img17->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img18->Visible) { // hg_img18 ?>
	<tr id="r_hg_img18">
		<td><span id="elh_hotel_gallery_hg_img18"><?php echo $hotel_gallery->hg_img18->FldCaption() ?></span></td>
		<td data-name="hg_img18"<?php echo $hotel_gallery->hg_img18->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img18">
<span<?php echo $hotel_gallery->hg_img18->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img18->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img19->Visible) { // hg_img19 ?>
	<tr id="r_hg_img19">
		<td><span id="elh_hotel_gallery_hg_img19"><?php echo $hotel_gallery->hg_img19->FldCaption() ?></span></td>
		<td data-name="hg_img19"<?php echo $hotel_gallery->hg_img19->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img19">
<span<?php echo $hotel_gallery->hg_img19->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img19->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img20->Visible) { // hg_img20 ?>
	<tr id="r_hg_img20">
		<td><span id="elh_hotel_gallery_hg_img20"><?php echo $hotel_gallery->hg_img20->FldCaption() ?></span></td>
		<td data-name="hg_img20"<?php echo $hotel_gallery->hg_img20->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img20">
<span<?php echo $hotel_gallery->hg_img20->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img20->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img21->Visible) { // hg_img21 ?>
	<tr id="r_hg_img21">
		<td><span id="elh_hotel_gallery_hg_img21"><?php echo $hotel_gallery->hg_img21->FldCaption() ?></span></td>
		<td data-name="hg_img21"<?php echo $hotel_gallery->hg_img21->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img21">
<span<?php echo $hotel_gallery->hg_img21->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img21->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img22->Visible) { // hg_img22 ?>
	<tr id="r_hg_img22">
		<td><span id="elh_hotel_gallery_hg_img22"><?php echo $hotel_gallery->hg_img22->FldCaption() ?></span></td>
		<td data-name="hg_img22"<?php echo $hotel_gallery->hg_img22->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img22">
<span<?php echo $hotel_gallery->hg_img22->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img22->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img23->Visible) { // hg_img23 ?>
	<tr id="r_hg_img23">
		<td><span id="elh_hotel_gallery_hg_img23"><?php echo $hotel_gallery->hg_img23->FldCaption() ?></span></td>
		<td data-name="hg_img23"<?php echo $hotel_gallery->hg_img23->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img23">
<span<?php echo $hotel_gallery->hg_img23->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img23->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->hg_img24->Visible) { // hg_img24 ?>
	<tr id="r_hg_img24">
		<td><span id="elh_hotel_gallery_hg_img24"><?php echo $hotel_gallery->hg_img24->FldCaption() ?></span></td>
		<td data-name="hg_img24"<?php echo $hotel_gallery->hg_img24->CellAttributes() ?>>
<span id="el_hotel_gallery_hg_img24">
<span<?php echo $hotel_gallery->hg_img24->ViewAttributes() ?>>
<?php echo $hotel_gallery->hg_img24->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($hotel_gallery->last_update->Visible) { // last_update ?>
	<tr id="r_last_update">
		<td><span id="elh_hotel_gallery_last_update"><?php echo $hotel_gallery->last_update->FldCaption() ?></span></td>
		<td data-name="last_update"<?php echo $hotel_gallery->last_update->CellAttributes() ?>>
<span id="el_hotel_gallery_last_update">
<span<?php echo $hotel_gallery->last_update->ViewAttributes() ?>>
<?php echo $hotel_gallery->last_update->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php if (!$hotel_gallery_view->IsModal) { ?>
<?php if ($hotel_gallery->Export == "") { ?>
<?php if (!isset($hotel_gallery_view->Pager)) $hotel_gallery_view->Pager = new cPrevNextPager($hotel_gallery_view->StartRec, $hotel_gallery_view->DisplayRecs, $hotel_gallery_view->TotalRecs) ?>
<?php if ($hotel_gallery_view->Pager->RecordCount > 0 && $hotel_gallery_view->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($hotel_gallery_view->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($hotel_gallery_view->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $hotel_gallery_view->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($hotel_gallery_view->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($hotel_gallery_view->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $hotel_gallery_view->PageUrl() ?>start=<?php echo $hotel_gallery_view->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $hotel_gallery_view->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php if ($hotel_gallery->Export == "") { ?>
<script type="text/javascript">
fhotel_galleryview.Init();
</script>
<?php } ?>
<?php
$hotel_gallery_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($hotel_gallery->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$hotel_gallery_view->Page_Terminate();
?>

<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "facilitiesinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$facilities_edit = NULL; // Initialize page object first

class cfacilities_edit extends cfacilities {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'facilities';

	// Page object name
	var $PageObjName = 'facilities_edit';

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

		// Table object (facilities)
		if (!isset($GLOBALS["facilities"]) || get_class($GLOBALS["facilities"]) == "cfacilities") {
			$GLOBALS["facilities"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["facilities"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'facilities', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("facilitieslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->facil_id->SetVisibility();
		$this->facil_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->facil_name->SetVisibility();
		$this->facil_image->SetVisibility();
		$this->facil_icon->SetVisibility();
		$this->facil_hot->SetVisibility();

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
		global $EW_EXPORT, $facilities;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($facilities);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

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

		// Load current record
		$bLoadCurrentRecord = FALSE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Load key from QueryString
		if (@$_GET["facil_id"] <> "") {
			$this->facil_id->setQueryStringValue($_GET["facil_id"]);
			$this->RecKey["facil_id"] = $this->facil_id->QueryStringValue;
		} else {
			$bLoadCurrentRecord = TRUE;
		}

		// Load recordset
		$this->StartRec = 1; // Initialize start position
		if ($this->Recordset = $this->LoadRecordset()) // Load records
			$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
		if ($this->TotalRecs <= 0) { // No record found
			if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$this->Page_Terminate("facilitieslist.php"); // Return to list page
		} elseif ($bLoadCurrentRecord) { // Load current record position
			$this->SetUpStartRec(); // Set up start record position

			// Point to current record
			if (intval($this->StartRec) <= intval($this->TotalRecs)) {
				$bMatchRecord = TRUE;
				$this->Recordset->Move($this->StartRec-1);
			}
		} else { // Match key values
			while (!$this->Recordset->EOF) {
				if (strval($this->facil_id->CurrentValue) == strval($this->Recordset->fields('facil_id'))) {
					$this->setStartRecordNumber($this->StartRec); // Save record position
					$bMatchRecord = TRUE;
					break;
				} else {
					$this->StartRec++;
					$this->Recordset->MoveNext();
				}
			}
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$bMatchRecord) {
					if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
						$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
					$this->Page_Terminate("facilitieslist.php"); // Return to list page
				} else {
					$this->LoadRowValues($this->Recordset); // Load row values
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "facilitieslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->facil_image->Upload->Index = $objForm->Index;
		$this->facil_image->Upload->UploadFile();
		$this->facil_image->CurrentValue = $this->facil_image->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->facil_id->FldIsDetailKey)
			$this->facil_id->setFormValue($objForm->GetValue("x_facil_id"));
		if (!$this->facil_name->FldIsDetailKey) {
			$this->facil_name->setFormValue($objForm->GetValue("x_facil_name"));
		}
		if (!$this->facil_icon->FldIsDetailKey) {
			$this->facil_icon->setFormValue($objForm->GetValue("x_facil_icon"));
		}
		if (!$this->facil_hot->FldIsDetailKey) {
			$this->facil_hot->setFormValue($objForm->GetValue("x_facil_hot"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->facil_id->CurrentValue = $this->facil_id->FormValue;
		$this->facil_name->CurrentValue = $this->facil_name->FormValue;
		$this->facil_icon->CurrentValue = $this->facil_icon->FormValue;
		$this->facil_hot->CurrentValue = $this->facil_hot->FormValue;
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
		$this->facil_id->setDbValue($rs->fields('facil_id'));
		$this->facil_name->setDbValue($rs->fields('facil_name'));
		$this->facil_image->Upload->DbValue = $rs->fields('facil_image');
		$this->facil_image->CurrentValue = $this->facil_image->Upload->DbValue;
		$this->facil_icon->setDbValue($rs->fields('facil_icon'));
		$this->facil_hot->setDbValue($rs->fields('facil_hot'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->facil_id->DbValue = $row['facil_id'];
		$this->facil_name->DbValue = $row['facil_name'];
		$this->facil_image->Upload->DbValue = $row['facil_image'];
		$this->facil_icon->DbValue = $row['facil_icon'];
		$this->facil_hot->DbValue = $row['facil_hot'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// facil_id
		// facil_name
		// facil_image
		// facil_icon
		// facil_hot

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// facil_id
		$this->facil_id->ViewValue = $this->facil_id->CurrentValue;
		$this->facil_id->ViewCustomAttributes = "";

		// facil_name
		$this->facil_name->ViewValue = $this->facil_name->CurrentValue;
		$this->facil_name->ViewCustomAttributes = "";

		// facil_image
		$this->facil_image->UploadPath = "../uploads/facilities";
		if (!ew_Empty($this->facil_image->Upload->DbValue)) {
			$this->facil_image->ImageAlt = $this->facil_image->FldAlt();
			$this->facil_image->ViewValue = $this->facil_image->Upload->DbValue;
		} else {
			$this->facil_image->ViewValue = "";
		}
		$this->facil_image->ViewCustomAttributes = "";

		// facil_icon
		$this->facil_icon->ViewValue = $this->facil_icon->CurrentValue;
		$this->facil_icon->ViewCustomAttributes = "";

		// facil_hot
		if (ew_ConvertToBool($this->facil_hot->CurrentValue)) {
			$this->facil_hot->ViewValue = $this->facil_hot->FldTagCaption(1) <> "" ? $this->facil_hot->FldTagCaption(1) : "Y";
		} else {
			$this->facil_hot->ViewValue = $this->facil_hot->FldTagCaption(2) <> "" ? $this->facil_hot->FldTagCaption(2) : "N";
		}
		$this->facil_hot->ViewCustomAttributes = "";

			// facil_id
			$this->facil_id->LinkCustomAttributes = "";
			$this->facil_id->HrefValue = "";
			$this->facil_id->TooltipValue = "";

			// facil_name
			$this->facil_name->LinkCustomAttributes = "";
			$this->facil_name->HrefValue = "";
			$this->facil_name->TooltipValue = "";

			// facil_image
			$this->facil_image->LinkCustomAttributes = "";
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->DbValue)) {
				$this->facil_image->HrefValue = ew_GetFileUploadUrl($this->facil_image, $this->facil_image->Upload->DbValue); // Add prefix/suffix
				$this->facil_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->facil_image->HrefValue = ew_ConvertFullUrl($this->facil_image->HrefValue);
			} else {
				$this->facil_image->HrefValue = "";
			}
			$this->facil_image->HrefValue2 = $this->facil_image->UploadPath . $this->facil_image->Upload->DbValue;
			$this->facil_image->TooltipValue = "";
			if ($this->facil_image->UseColorbox) {
				if (ew_Empty($this->facil_image->TooltipValue))
					$this->facil_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->facil_image->LinkAttrs["data-rel"] = "facilities_x_facil_image";
				ew_AppendClass($this->facil_image->LinkAttrs["class"], "ewLightbox");
			}

			// facil_icon
			$this->facil_icon->LinkCustomAttributes = "";
			$this->facil_icon->HrefValue = "";
			$this->facil_icon->TooltipValue = "";

			// facil_hot
			$this->facil_hot->LinkCustomAttributes = "";
			$this->facil_hot->HrefValue = "";
			$this->facil_hot->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// facil_id
			$this->facil_id->EditAttrs["class"] = "form-control";
			$this->facil_id->EditCustomAttributes = "";
			$this->facil_id->EditValue = $this->facil_id->CurrentValue;
			$this->facil_id->ViewCustomAttributes = "";

			// facil_name
			$this->facil_name->EditAttrs["class"] = "form-control";
			$this->facil_name->EditCustomAttributes = "";
			$this->facil_name->EditValue = ew_HtmlEncode($this->facil_name->CurrentValue);
			$this->facil_name->PlaceHolder = ew_RemoveHtml($this->facil_name->FldCaption());

			// facil_image
			$this->facil_image->EditAttrs["class"] = "form-control";
			$this->facil_image->EditCustomAttributes = "";
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->DbValue)) {
				$this->facil_image->ImageAlt = $this->facil_image->FldAlt();
				$this->facil_image->EditValue = $this->facil_image->Upload->DbValue;
			} else {
				$this->facil_image->EditValue = "";
			}
			if (!ew_Empty($this->facil_image->CurrentValue))
				$this->facil_image->Upload->FileName = $this->facil_image->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->facil_image);

			// facil_icon
			$this->facil_icon->EditAttrs["class"] = "form-control";
			$this->facil_icon->EditCustomAttributes = "";
			$this->facil_icon->EditValue = ew_HtmlEncode($this->facil_icon->CurrentValue);
			$this->facil_icon->PlaceHolder = ew_RemoveHtml($this->facil_icon->FldCaption());

			// facil_hot
			$this->facil_hot->EditCustomAttributes = "";
			$this->facil_hot->EditValue = $this->facil_hot->Options(FALSE);

			// Edit refer script
			// facil_id

			$this->facil_id->LinkCustomAttributes = "";
			$this->facil_id->HrefValue = "";

			// facil_name
			$this->facil_name->LinkCustomAttributes = "";
			$this->facil_name->HrefValue = "";

			// facil_image
			$this->facil_image->LinkCustomAttributes = "";
			$this->facil_image->UploadPath = "../uploads/facilities";
			if (!ew_Empty($this->facil_image->Upload->DbValue)) {
				$this->facil_image->HrefValue = ew_GetFileUploadUrl($this->facil_image, $this->facil_image->Upload->DbValue); // Add prefix/suffix
				$this->facil_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->facil_image->HrefValue = ew_ConvertFullUrl($this->facil_image->HrefValue);
			} else {
				$this->facil_image->HrefValue = "";
			}
			$this->facil_image->HrefValue2 = $this->facil_image->UploadPath . $this->facil_image->Upload->DbValue;

			// facil_icon
			$this->facil_icon->LinkCustomAttributes = "";
			$this->facil_icon->HrefValue = "";

			// facil_hot
			$this->facil_hot->LinkCustomAttributes = "";
			$this->facil_hot->HrefValue = "";
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->facil_image->OldUploadPath = "../uploads/facilities";
			$this->facil_image->UploadPath = $this->facil_image->OldUploadPath;
			$rsnew = array();

			// facil_name
			$this->facil_name->SetDbValueDef($rsnew, $this->facil_name->CurrentValue, NULL, $this->facil_name->ReadOnly);

			// facil_image
			if ($this->facil_image->Visible && !$this->facil_image->ReadOnly && !$this->facil_image->Upload->KeepFile) {
				$this->facil_image->Upload->DbValue = $rsold['facil_image']; // Get original value
				if ($this->facil_image->Upload->FileName == "") {
					$rsnew['facil_image'] = NULL;
				} else {
					$rsnew['facil_image'] = $this->facil_image->Upload->FileName;
				}
			}

			// facil_icon
			$this->facil_icon->SetDbValueDef($rsnew, $this->facil_icon->CurrentValue, NULL, $this->facil_icon->ReadOnly);

			// facil_hot
			$tmpBool = $this->facil_hot->CurrentValue;
			if ($tmpBool <> "Y" && $tmpBool <> "N")
				$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
			$this->facil_hot->SetDbValueDef($rsnew, $tmpBool, NULL, $this->facil_hot->ReadOnly);
			if ($this->facil_image->Visible && !$this->facil_image->Upload->KeepFile) {
				$this->facil_image->UploadPath = "../uploads/facilities";
				if (!ew_Empty($this->facil_image->Upload->Value)) {
					$rsnew['facil_image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->facil_image->UploadPath), $rsnew['facil_image']); // Get new file name
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->facil_image->Visible && !$this->facil_image->Upload->KeepFile) {
						if (!ew_Empty($this->facil_image->Upload->Value)) {
							if (!$this->facil_image->Upload->SaveToFile($this->facil_image->UploadPath, $rsnew['facil_image'], TRUE)) {
								$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
								return FALSE;
							}
						}
					}
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// facil_image
		ew_CleanUploadTempPath($this->facil_image, $this->facil_image->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("facilitieslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($facilities_edit)) $facilities_edit = new cfacilities_edit();

// Page init
$facilities_edit->Page_Init();

// Page main
$facilities_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$facilities_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ffacilitiesedit = new ew_Form("ffacilitiesedit", "edit");

// Validate form
ffacilitiesedit.Validate = function() {
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
ffacilitiesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffacilitiesedit.ValidateRequired = true;
<?php } else { ?>
ffacilitiesedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffacilitiesedit.Lists["x_facil_hot[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffacilitiesedit.Lists["x_facil_hot[]"].Options = <?php echo json_encode($facilities->facil_hot->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$facilities_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $facilities_edit->ShowPageHeader(); ?>
<?php
$facilities_edit->ShowMessage();
?>
<?php if (!$facilities_edit->IsModal) { ?>
<form name="ewPagerForm" class="form-horizontal ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($facilities_edit->Pager)) $facilities_edit->Pager = new cPrevNextPager($facilities_edit->StartRec, $facilities_edit->DisplayRecs, $facilities_edit->TotalRecs) ?>
<?php if ($facilities_edit->Pager->RecordCount > 0 && $facilities_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($facilities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($facilities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $facilities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($facilities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($facilities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $facilities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="ffacilitiesedit" id="ffacilitiesedit" class="<?php echo $facilities_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($facilities_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $facilities_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="facilities">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($facilities_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($facilities->facil_id->Visible) { // facil_id ?>
	<div id="r_facil_id" class="form-group">
		<label id="elh_facilities_facil_id" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_id->CellAttributes() ?>>
<span id="el_facilities_facil_id">
<span<?php echo $facilities->facil_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $facilities->facil_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="facilities" data-field="x_facil_id" name="x_facil_id" id="x_facil_id" value="<?php echo ew_HtmlEncode($facilities->facil_id->CurrentValue) ?>">
<?php echo $facilities->facil_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_name->Visible) { // facil_name ?>
	<div id="r_facil_name" class="form-group">
		<label id="elh_facilities_facil_name" for="x_facil_name" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_name->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_name->CellAttributes() ?>>
<span id="el_facilities_facil_name">
<input type="text" data-table="facilities" data-field="x_facil_name" name="x_facil_name" id="x_facil_name" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($facilities->facil_name->getPlaceHolder()) ?>" value="<?php echo $facilities->facil_name->EditValue ?>"<?php echo $facilities->facil_name->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_image->Visible) { // facil_image ?>
	<div id="r_facil_image" class="form-group">
		<label id="elh_facilities_facil_image" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_image->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_image->CellAttributes() ?>>
<span id="el_facilities_facil_image">
<div id="fd_x_facil_image">
<span title="<?php echo $facilities->facil_image->FldTitle() ? $facilities->facil_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($facilities->facil_image->ReadOnly || $facilities->facil_image->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="facilities" data-field="x_facil_image" name="x_facil_image" id="x_facil_image"<?php echo $facilities->facil_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_facil_image" id= "fn_x_facil_image" value="<?php echo $facilities->facil_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_facil_image"] == "0") { ?>
<input type="hidden" name="fa_x_facil_image" id= "fa_x_facil_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_facil_image" id= "fa_x_facil_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_facil_image" id= "fs_x_facil_image" value="250">
<input type="hidden" name="fx_x_facil_image" id= "fx_x_facil_image" value="<?php echo $facilities->facil_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_facil_image" id= "fm_x_facil_image" value="<?php echo $facilities->facil_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_facil_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $facilities->facil_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_icon->Visible) { // facil_icon ?>
	<div id="r_facil_icon" class="form-group">
		<label id="elh_facilities_facil_icon" for="x_facil_icon" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_icon->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_icon->CellAttributes() ?>>
<span id="el_facilities_facil_icon">
<input type="text" data-table="facilities" data-field="x_facil_icon" name="x_facil_icon" id="x_facil_icon" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($facilities->facil_icon->getPlaceHolder()) ?>" value="<?php echo $facilities->facil_icon->EditValue ?>"<?php echo $facilities->facil_icon->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_icon->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($facilities->facil_hot->Visible) { // facil_hot ?>
	<div id="r_facil_hot" class="form-group">
		<label id="elh_facilities_facil_hot" class="col-sm-2 control-label ewLabel"><?php echo $facilities->facil_hot->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $facilities->facil_hot->CellAttributes() ?>>
<span id="el_facilities_facil_hot">
<?php
$selwrk = (ew_ConvertToBool($facilities->facil_hot->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="facilities" data-field="x_facil_hot" name="x_facil_hot[]" id="x_facil_hot[]" value="1"<?php echo $selwrk ?><?php echo $facilities->facil_hot->EditAttributes() ?>>
</span>
<?php echo $facilities->facil_hot->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$facilities_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $facilities_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php if (!isset($facilities_edit->Pager)) $facilities_edit->Pager = new cPrevNextPager($facilities_edit->StartRec, $facilities_edit->DisplayRecs, $facilities_edit->TotalRecs) ?>
<?php if ($facilities_edit->Pager->RecordCount > 0 && $facilities_edit->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($facilities_edit->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($facilities_edit->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $facilities_edit->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($facilities_edit->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($facilities_edit->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $facilities_edit->PageUrl() ?>start=<?php echo $facilities_edit->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $facilities_edit->Pager->PageCount ?></span>
</div>
<?php } ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<script type="text/javascript">
ffacilitiesedit.Init();
</script>
<?php
$facilities_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$facilities_edit->Page_Terminate();
?>

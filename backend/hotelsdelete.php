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

$hotels_delete = NULL; // Initialize page object first

class chotels_delete extends chotels {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}";

	// Table name
	var $TableName = 'hotels';

	// Page object name
	var $PageObjName = 'hotels_delete';

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

		// Table object (hotels)
		if (!isset($GLOBALS["hotels"]) || get_class($GLOBALS["hotels"]) == "chotels") {
			$GLOBALS["hotels"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["hotels"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'hotels', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("hotelslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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
			$this->Page_Terminate("hotelslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in hotels class, hotelsinfo.php

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
				$this->Page_Terminate("hotelslist.php"); // Return to list
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
				$this->h_feature_image->LinkAttrs["data-rel"] = "hotels_x_h_feature_image";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("hotelslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($hotels_delete)) $hotels_delete = new chotels_delete();

// Page init
$hotels_delete->Page_Init();

// Page main
$hotels_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$hotels_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fhotelsdelete = new ew_Form("fhotelsdelete", "delete");

// Form_CustomValidate event
fhotelsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fhotelsdelete.ValidateRequired = true;
<?php } else { ?>
fhotelsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fhotelsdelete.Lists["x_h_online_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsdelete.Lists["x_h_online_status"].Options = <?php echo json_encode($hotels->h_online_status->Options()) ?>;
fhotelsdelete.Lists["x_hotel_blocked"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fhotelsdelete.Lists["x_hotel_blocked"].Options = <?php echo json_encode($hotels->hotel_blocked->Options()) ?>;

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
<?php $hotels_delete->ShowPageHeader(); ?>
<?php
$hotels_delete->ShowMessage();
?>
<form name="fhotelsdelete" id="fhotelsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($hotels_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $hotels_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="hotels">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($hotels_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $hotels->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($hotels->hotel_id->Visible) { // hotel_id ?>
		<th><span id="elh_hotels_hotel_id" class="hotels_hotel_id"><?php echo $hotels->hotel_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_name->Visible) { // h_name ?>
		<th><span id="elh_hotels_h_name" class="hotels_h_name"><?php echo $hotels->h_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_slug->Visible) { // h_slug ?>
		<th><span id="elh_hotels_h_slug" class="hotels_h_slug"><?php echo $hotels->h_slug->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
		<th><span id="elh_hotels_h_feature_image" class="hotels_h_feature_image"><?php echo $hotels->h_feature_image->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_address->Visible) { // h_address ?>
		<th><span id="elh_hotels_h_address" class="hotels_h_address"><?php echo $hotels->h_address->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_create->Visible) { // h_create ?>
		<th><span id="elh_hotels_h_create" class="hotels_h_create"><?php echo $hotels->h_create->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->dest_id->Visible) { // dest_id ?>
		<th><span id="elh_hotels_dest_id" class="hotels_dest_id"><?php echo $hotels->dest_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->province->Visible) { // province ?>
		<th><span id="elh_hotels_province" class="hotels_province"><?php echo $hotels->province->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
		<th><span id="elh_hotels_h_id_cod" class="hotels_h_id_cod"><?php echo $hotels->h_id_cod->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_email->Visible) { // h_email ?>
		<th><span id="elh_hotels_h_email" class="hotels_h_email"><?php echo $hotels->h_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
		<th><span id="elh_hotels_h_contact_name" class="hotels_h_contact_name"><?php echo $hotels->h_contact_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_pass->Visible) { // h_pass ?>
		<th><span id="elh_hotels_h_pass" class="hotels_h_pass"><?php echo $hotels->h_pass->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
		<th><span id="elh_hotels_h_contact_phone" class="hotels_h_contact_phone"><?php echo $hotels->h_contact_phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_site->Visible) { // h_site ?>
		<th><span id="elh_hotels_h_site" class="hotels_h_site"><?php echo $hotels->h_site->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
		<th><span id="elh_hotels_contact_fax" class="hotels_contact_fax"><?php echo $hotels->contact_fax->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->star_rating->Visible) { // star_rating ?>
		<th><span id="elh_hotels_star_rating" class="hotels_star_rating"><?php echo $hotels->star_rating->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->create_date->Visible) { // create_date ?>
		<th><span id="elh_hotels_create_date" class="hotels_create_date"><?php echo $hotels->create_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->update_date->Visible) { // update_date ?>
		<th><span id="elh_hotels_update_date" class="hotels_update_date"><?php echo $hotels->update_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
		<th><span id="elh_hotels_h_online_status" class="hotels_h_online_status"><?php echo $hotels->h_online_status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
		<th><span id="elh_hotels_hotel_blocked" class="hotels_hotel_blocked"><?php echo $hotels->hotel_blocked->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$hotels_delete->RecCnt = 0;
$i = 0;
while (!$hotels_delete->Recordset->EOF) {
	$hotels_delete->RecCnt++;
	$hotels_delete->RowCnt++;

	// Set row properties
	$hotels->ResetAttrs();
	$hotels->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$hotels_delete->LoadRowValues($hotels_delete->Recordset);

	// Render row
	$hotels_delete->RenderRow();
?>
	<tr<?php echo $hotels->RowAttributes() ?>>
<?php if ($hotels->hotel_id->Visible) { // hotel_id ?>
		<td<?php echo $hotels->hotel_id->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_hotel_id" class="hotels_hotel_id">
<span<?php echo $hotels->hotel_id->ViewAttributes() ?>>
<?php echo $hotels->hotel_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_name->Visible) { // h_name ?>
		<td<?php echo $hotels->h_name->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_name" class="hotels_h_name">
<span<?php echo $hotels->h_name->ViewAttributes() ?>>
<?php echo $hotels->h_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_slug->Visible) { // h_slug ?>
		<td<?php echo $hotels->h_slug->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_slug" class="hotels_h_slug">
<span<?php echo $hotels->h_slug->ViewAttributes() ?>>
<?php echo $hotels->h_slug->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_feature_image->Visible) { // h_feature_image ?>
		<td<?php echo $hotels->h_feature_image->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_feature_image" class="hotels_h_feature_image">
<span>
<?php echo ew_GetFileViewTag($hotels->h_feature_image, $hotels->h_feature_image->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_address->Visible) { // h_address ?>
		<td<?php echo $hotels->h_address->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_address" class="hotels_h_address">
<span<?php echo $hotels->h_address->ViewAttributes() ?>>
<?php echo $hotels->h_address->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_create->Visible) { // h_create ?>
		<td<?php echo $hotels->h_create->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_create" class="hotels_h_create">
<span<?php echo $hotels->h_create->ViewAttributes() ?>>
<?php echo $hotels->h_create->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->dest_id->Visible) { // dest_id ?>
		<td<?php echo $hotels->dest_id->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_dest_id" class="hotels_dest_id">
<span<?php echo $hotels->dest_id->ViewAttributes() ?>>
<?php echo $hotels->dest_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->province->Visible) { // province ?>
		<td<?php echo $hotels->province->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_province" class="hotels_province">
<span<?php echo $hotels->province->ViewAttributes() ?>>
<?php echo $hotels->province->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_id_cod->Visible) { // h_id_cod ?>
		<td<?php echo $hotels->h_id_cod->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_id_cod" class="hotels_h_id_cod">
<span<?php echo $hotels->h_id_cod->ViewAttributes() ?>>
<?php echo $hotels->h_id_cod->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_email->Visible) { // h_email ?>
		<td<?php echo $hotels->h_email->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_email" class="hotels_h_email">
<span<?php echo $hotels->h_email->ViewAttributes() ?>>
<?php echo $hotels->h_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_contact_name->Visible) { // h_contact_name ?>
		<td<?php echo $hotels->h_contact_name->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_contact_name" class="hotels_h_contact_name">
<span<?php echo $hotels->h_contact_name->ViewAttributes() ?>>
<?php echo $hotels->h_contact_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_pass->Visible) { // h_pass ?>
		<td<?php echo $hotels->h_pass->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_pass" class="hotels_h_pass">
<span<?php echo $hotels->h_pass->ViewAttributes() ?>>
<?php echo $hotels->h_pass->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_contact_phone->Visible) { // h_contact_phone ?>
		<td<?php echo $hotels->h_contact_phone->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_contact_phone" class="hotels_h_contact_phone">
<span<?php echo $hotels->h_contact_phone->ViewAttributes() ?>>
<?php echo $hotels->h_contact_phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_site->Visible) { // h_site ?>
		<td<?php echo $hotels->h_site->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_site" class="hotels_h_site">
<span<?php echo $hotels->h_site->ViewAttributes() ?>>
<?php echo $hotels->h_site->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->contact_fax->Visible) { // contact_fax ?>
		<td<?php echo $hotels->contact_fax->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_contact_fax" class="hotels_contact_fax">
<span<?php echo $hotels->contact_fax->ViewAttributes() ?>>
<?php echo $hotels->contact_fax->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->star_rating->Visible) { // star_rating ?>
		<td<?php echo $hotels->star_rating->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_star_rating" class="hotels_star_rating">
<span<?php echo $hotels->star_rating->ViewAttributes() ?>>
<?php echo $hotels->star_rating->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->create_date->Visible) { // create_date ?>
		<td<?php echo $hotels->create_date->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_create_date" class="hotels_create_date">
<span<?php echo $hotels->create_date->ViewAttributes() ?>>
<?php echo $hotels->create_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->update_date->Visible) { // update_date ?>
		<td<?php echo $hotels->update_date->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_update_date" class="hotels_update_date">
<span<?php echo $hotels->update_date->ViewAttributes() ?>>
<?php echo $hotels->update_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->h_online_status->Visible) { // h_online_status ?>
		<td<?php echo $hotels->h_online_status->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_h_online_status" class="hotels_h_online_status">
<span<?php echo $hotels->h_online_status->ViewAttributes() ?>>
<?php echo $hotels->h_online_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($hotels->hotel_blocked->Visible) { // hotel_blocked ?>
		<td<?php echo $hotels->hotel_blocked->CellAttributes() ?>>
<span id="el<?php echo $hotels_delete->RowCnt ?>_hotels_hotel_blocked" class="hotels_hotel_blocked">
<span<?php echo $hotels->hotel_blocked->ViewAttributes() ?>>
<?php echo $hotels->hotel_blocked->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$hotels_delete->Recordset->MoveNext();
}
$hotels_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $hotels_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fhotelsdelete.Init();
</script>
<?php
$hotels_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$hotels_delete->Page_Terminate();
?>

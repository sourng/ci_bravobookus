<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_settings", $Language->MenuPhrase("1", "MenuText"), "settingslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}settings'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_ci_cookies", $Language->MenuPhrase("2", "MenuText"), "ci_cookieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}ci_cookies'), FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_ci_sessions", $Language->MenuPhrase("3", "MenuText"), "ci_sessionslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}ci_sessions'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_country", $Language->MenuPhrase("4", "MenuText"), "countrylist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}country'), FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_customers", $Language->MenuPhrase("5", "MenuText"), "customerslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}customers'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_destinations", $Language->MenuPhrase("6", "MenuText"), "destinationslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}destinations'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmi_destinations2", $Language->MenuPhrase("7", "MenuText"), "destinations2list.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}destinations2'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_facilities_hotels", $Language->MenuPhrase("8", "MenuText"), "facilities_hotelslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}facilities_hotels'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_facilities", $Language->MenuPhrase("9", "MenuText"), "facilitieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}facilities'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_hotel_rooms", $Language->MenuPhrase("10", "MenuText"), "hotel_roomslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_rooms'), FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mmi_hotel_booking", $Language->MenuPhrase("11", "MenuText"), "hotel_bookinglist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_booking'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mmi_hotel_facilities", $Language->MenuPhrase("12", "MenuText"), "hotel_facilitieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_facilities'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mmi_hotel_gallery", $Language->MenuPhrase("13", "MenuText"), "hotel_gallerylist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_gallery'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_hotel_policy", $Language->MenuPhrase("14", "MenuText"), "hotel_policylist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_policy'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mmi_hotel_room_gallery", $Language->MenuPhrase("15", "MenuText"), "hotel_room_gallerylist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotel_room_gallery'), FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mmi_hotels", $Language->MenuPhrase("16", "MenuText"), "hotelslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotels'), FALSE, FALSE);
$RootMenu->AddMenuItem(17, "mmi_hotels_gallery", $Language->MenuPhrase("17", "MenuText"), "hotels_gallerylist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}hotels_gallery'), FALSE, FALSE);
$RootMenu->AddMenuItem(18, "mmi_policies", $Language->MenuPhrase("18", "MenuText"), "policieslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}policies'), FALSE, FALSE);
$RootMenu->AddMenuItem(19, "mmi_room_types", $Language->MenuPhrase("19", "MenuText"), "room_typeslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}room_types'), FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mmi_selling_rooms", $Language->MenuPhrase("20", "MenuText"), "selling_roomslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}selling_rooms'), FALSE, FALSE);
$RootMenu->AddMenuItem(21, "mmi_services", $Language->MenuPhrase("21", "MenuText"), "serviceslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}services'), FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mmi_user_groups", $Language->MenuPhrase("22", "MenuText"), "user_groupslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}user_groups'), FALSE, FALSE);
$RootMenu->AddMenuItem(23, "mmi_users", $Language->MenuPhrase("23", "MenuText"), "userslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}users'), FALSE, FALSE);
$RootMenu->AddMenuItem(24, "mmi_v_last_minute_deals", $Language->MenuPhrase("24", "MenuText"), "v_last_minute_dealslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}v_last_minute_deals'), FALSE, FALSE);
$RootMenu->AddMenuItem(25, "mmi_v_list_hotels", $Language->MenuPhrase("25", "MenuText"), "v_list_hotelslist.php", -1, "", IsLoggedIn() || AllowListMenu('{C8C6CF44-D3A2-4CDE-9B21-6EDF1C9CDF0A}v_list_hotels'), FALSE, FALSE);
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->

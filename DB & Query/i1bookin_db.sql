-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2017 at 05:34 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `i1bookin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `id` int(4) NOT NULL,
  `site_keyword` text NOT NULL,
  `site_description` text NOT NULL,
  `contact` text,
  `map` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contact_us`
--

INSERT INTO `tbl_contact_us` (`id`, `site_keyword`, `site_description`, `contact`, `map`, `last_update`) VALUES
(1, 'bus booking, cambodia bus', 'Please contact to daily booking', '<p>i1booking.com offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.</p>\r\n\r\n<div class=\"row\">\r\n<div class=\"col-sm-6\">\r\n<p>Vihear Chin Village, SvayDangkum Commune, Siem Reap City</p>\r\n</div>\r\n\r\n<div class=\"col-sm-6\">\r\n<p>www.i1booking.com</p>\r\n</div>\r\n\r\n<div class=\"col-sm-6\">\r\n<p>+855 70 87 77 27</p>\r\n\r\n<p>+855 78&nbsp;87 77 27</p>\r\n</div>\r\n\r\n<div class=\"col-sm-6\">\r\n<p>info@i1booking.com</p>\r\n</div>\r\n</div>', '<p><iframe frameborder=\"0\" height=\"450\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3881.9851650960704!2d103.84351501482605!3d13.35119849060761!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31101767437ecca1%3A0xc63409da87a99163!2sAsia+I1Booking!5e0!3m2!1sen!2skh!4v1460229992845\" style=\"border:0\" width=\"100%\"></iframe></p>\r\n\r\n<p><iframe frameborder=\"0\" height=\"600\" src=\"https://www.google.com/maps/embed?pb=!1m0!3m2!1sen!2skh!4v1460462637366!6m8!1m7!1sUqBvR5YSLAeY68i87yWi7A!2m2!1d13.35125223207012!2d103.8453940334234!3f44.47250205473678!4f-9.956593578151953!5f0.7820865974627469\" style=\"border:0\" width=\"100%\"></iframe></p>', '2016-08-03 17:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_accommodation`
--

CREATE TABLE `tbl_home_accommodation` (
  `id` int(6) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `description` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_home_accommodation`
--

INSERT INTO `tbl_home_accommodation` (`id`, `title`, `image`, `description`, `last_update`) VALUES
(1, 'Tuk tuk 13$/day for small tour', 'tuk-tuk.png', 'Transportation options for touring\r\n\r\nTo get around visiting the temples, you have a few options. You can ride on the back of a motorbike or hire either a tuk tuk or car with driver. The back of a motorbike is cheap and looks like it gives a good adrenalin kick but comfort and safety... not so sure. A car offers all the comforts of home but that\'s also it\'s drawback - it offers all the comforts of home.\r\n\r\n                                          Great news! Expansion!\r\n\r\n\r\nThanks to Mr. LEE\'s great service and our past guests, we now often have enough guests that Savuth can also help out a few of his best mates and now work-partners when he is booked.These are all very experienced drivers and totally trustworthy and personable fellows. I also know each of these guys personally. Our guests seem to be very happy with all these great guys.\r\n\r\nLEE also has some excellent mates in his network to arrange a good minivan, car or licensed guide. Its a wonderful feeling knowing that some other fine and deserving fellows and their families can also be helped in this way! So no matter when you are coming or what your needs may be, we can always arrange a great solution.', '2016-11-24 17:33:16'),
(2, 'Bus ticket to cambodia', '33_Nattakan (1).jpg', 'Lowest price Guarantee\r\n\r\n- E-Ticket & M-Ticket support\r\n\r\n- Reschedule\r\n\r\n- Book & Save points for rewards\r\n\r\n- Review & Rate bus operators\r\n\r\n- VISA Card, Master Card  acceptance', '2016-11-27 04:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_highlight`
--

CREATE TABLE `tbl_home_highlight` (
  `id` int(6) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `description` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_home_highlight`
--

INSERT INTO `tbl_home_highlight` (`id`, `title`, `image`, `link`, `description`, `last_update`) VALUES
(1, 'Book bus ticket', 'MMMM.jpg', '/bus-operator', '<p><span style=\"font-size:12px\"><em><strong>- </strong></em><strong>Competitive Prices</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>- No extra charges for bookings</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>-&nbsp;E-Ticket &amp; M-Ticket support</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>-&nbsp;Rescheduling</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>-&nbsp;Book &amp; Save points for rewards</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>-&nbsp;Review &amp; Rate bus operators</strong></span></p>\r\n\r\n<p><span style=\"font-size:12px\"><strong>-&nbsp;VISA Card &amp;&nbsp;Master Card accepted</strong></span></p>', '2017-08-03 16:16:44'),
(2, 'Start Here', 'Tour2334.jpg', '/tours-packages', '<p><strong>Temples Entrance Fee:</strong><br />\r\n* Angkor temples Area : ticket for 1 day is 37USD.<br />\r\n* Angkor temples Area : ticket for 2-3 days is 62USD (you can use any 3 days in one week).<br />\r\n* Angkor temples Area : ticket for 4-7 days is 72USD (you can use any 7 days in one month).<br />\r\n* Phnom Kulen or Kulen Mountain ticket is 20USD per person.<br />\r\n* Beng Melea ticket is 5USD per person<br />\r\n* Koh Ker tickets is 10USD per person.</p>', '2017-07-15 04:38:44'),
(3, 'Start Booking', 'Hotel vcu.jpg', 'accommodation.html', '<p><span style=\"color:#0099cc\"><strong>+ Accomondations</strong></span></p>\r\n\r\n<p><span style=\"color:#444444\"><strong>-</strong></span><span style=\"color:#777777\"><strong> 5 star Hotel&nbsp;( Good Locations )</strong></span></p>\r\n\r\n<p><span style=\"color:#777777\"><strong>- 4 star Hotel&nbsp;( Good Locations )</strong></span></p>\r\n\r\n<p><span style=\"color:#777777\"><strong>- 3 star Hotel&nbsp;( Good Locations )</strong></span></p>\r\n\r\n<p><span style=\"color:#777777\"><strong>- Guest house &amp; Hostel ( Good Locations )</strong></span></p>\r\n\r\n<p>&nbsp;</p>', '2017-07-10 14:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_photo_slide`
--

CREATE TABLE `tbl_home_photo_slide` (
  `id` int(6) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `description` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_home_photo_slide`
--

INSERT INTO `tbl_home_photo_slide` (`id`, `title`, `image`, `link`, `description`, `last_update`) VALUES
(1, '$6/Pax Share to Small Tour', 'Small tour.jpg', 'http://www.i1booking.com/tour-detail.html?tour_package_id=1', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:35:24'),
(2, 'Special Holiday at Koh Rong Saloem', 'destination6-ae9757d57dc5385317b458d6fe76f2d3.jpg', 'i1booking.com', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:35:41'),
(6, 'Bus ticket to Bangkok $28', 'best-bangkok-old-city-restaurants.jpg', 'https://i1booking.com/bus-comid-1/', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:35:56'),
(7, 'Tuk tuk 13$/day for small tour', 'tuk-tuk.png', 'http://www.i1booking.com/tours-packages', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:36:10'),
(8, 'Booking Good Hotel ( Siem Reap )', 'taraangkorhotel_daily-booking.jpg', '/hotel-room.html?hotel_id=8', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:36:32'),
(9, 'Nattakan', '33_Nattakan (3).JPG', 'http://www.i1booking.com/tour-detail.html?tour_package_id=2', 'Daily Share Tour To Angkor Wat $6 for 1Person\r\nWe would to say many thanks for used our service.\r\n+85570999666 \r\nEmail: i1bookbus@gmail.com \r\nEmail. info@i1booking.com www.i1booking.com', '2017-07-12 06:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel`
--

CREATE TABLE `tbl_hotel` (
  `id` int(6) NOT NULL,
  `site_keyword` text NOT NULL,
  `site_description` text NOT NULL,
  `Hotel_Category` int(11) NOT NULL,
  `hotel_name` varchar(100) NOT NULL,
  `Rank` int(2) NOT NULL,
  `Location` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `hotel_feature_id` varchar(512) CHARACTER SET utf8 DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotel`
--

INSERT INTO `tbl_hotel` (`id`, `site_keyword`, `site_description`, `Hotel_Category`, `hotel_name`, `Rank`, `Location`, `image`, `description`, `hotel_feature_id`, `last_update`) VALUES
(7, 'somadevi', 'somadevi angkor', 1, 'Somadevi Angkor', 3, 1, 'slider-3.jpg', '<p>HOTEL SOMADEVI ANGKOR RESORT &amp; SPA is indeed a Resort of Class and Character in which you should not miss while you are visiting the mystical land &ndash; Siem Reap Angkor. The Resort has been designed to guarantee you a most pleasant and memorable stay as we aim to deliver products and services that consistently meet and exceed your travel&rsquo;s needs and wants. HOTEL SOMADEVI ANGKOR RESORT &amp; SPA is quite centrally situated handy for Top Business, Restaurant, Shopping, Museum, Bank, and Entertainment Centers. It is just fifteen (15) minutes drive from Siem Reap International Airport and ten (10) minutes to the world-renowned Angkor Watt Temple. Truly, HOTEL SOMADEVI ANGKOR RESORT &amp; SPA is a convenient address to Business and Leisure Travelers.</p>', '1,2,3,4,5', '2016-12-07 20:57:31'),
(8, 'Tara Angkor Hotel', 'Tara Angkor Hotel', 1, 'Tara Angkor Hotel', 4, 1, 'superior-king-6.jpg', '<p>Tara Angkor Hotel is the 4-Star Luxury Hotel built in the mystical land of Angkor. Ideally and conveniently located, Tara Angkor Hotel is situated only 6 km from the World Heritage site of Angkor Wat Temples, 15 min drive from the Siem Reap International Airport, a few minutes stroll to the Angkor National Museum and a short ride to the city town center with an array of Cambodian souvenirs, shopping and culture.</p>', '1,2,3,4,5', '2016-12-07 20:58:55'),
(9, 'New Riverside Hotel', 'New Riverside Hotel', 1, 'New Riverside Hotel', 3, 1, 'normal_banner-4.jpg', '<p>Tourists will be delighted to find the Central Market, Old Market, Angkor Night Market, the National Museum, the Royal Residence, ATM, 24-hour Mart &amp; Pub Street just a short stroll away. It is a 1-minute walk to Pub Street, ATM, KFC, Night Market, Old Market and food street close to the HOTEL.&nbsp;Ideal for both, leisure and business travelers , &nbsp;Moonlight kiss hostel&nbsp; &amp; Pool&nbsp;offers 8 spacious clean rooms that are suitable for singles, couples or even a group stay. A 15-minute drive from the amazing Temples of Angkor and Siem Reap International Airport.</p>', '1,2,3,4,5', '2016-12-08 16:00:48'),
(10, 'King Fisher Angkor Hotel', 'King Fisher Angkor Hotel', 1, 'King Fisher Angkor Hotel', 3, 1, '57715062.jpg', '<p>Tourists will be delighted to find the Central Market, Old Market, Angkor Night Market, the National Museum, the Royal Residence, ATM, 24-hour Mart &amp; Pub Street just a short stroll away. It is a 1-minute walk to Pub Street, ATM, KFC, Night Market, Old Market and food street close to the HOTEL.&nbsp;Ideal for both, leisure and business travelers , &nbsp;Moonlight kiss hostel&nbsp; &amp; Pool&nbsp;offers 8 spacious clean rooms that are suitable for singles, couples or even a group stay. A 15-minute drive from the amazing Temples of Angkor and Siem Reap International Airport.</p>', '1,2,3,5', '2016-12-08 16:01:23'),
(11, 'One Stop Hostel', 'One Stop Hostel', 2, 'One Stop Hostel', 0, 1, '58895072.jpg', NULL, '1,2,5', '2016-12-08 16:01:51'),
(12, 'Funky Flash Packer', 'Funky Flash Packer', 2, 'Funky Flash Packer', 0, 1, 'funky-flashpacker-siem.jpg', NULL, '1,2,4,5', '2016-12-08 16:02:36'),
(13, 'Mad Monkey Siem Reap', 'Mad Monkey Siem Reap', 2, 'Mad Monkey Siem Reap', 0, 1, 'IMG_7683-1024x768.jpg', NULL, '1,2,5', '2016-12-08 16:02:55'),
(14, 'Moonlight Kiss Hostel', 'Moonlight Kiss Hostel', 6, 'Moonlight Kiss Hostel', 0, 1, 'DSCF0311.JPG', '<p>Tourists will be delighted to find the Central Market, Old Market, Angkor Night Market, the National Museum, the Royal Residence, ATM, 24-hour Mart &amp; Pub Street just a short stroll away. It is a 1-minute walk to Pub Street, ATM, KFC, Night Market, Old Market and food street close to the HOTEL.&nbsp;Ideal for both, leisure and business travelers , &nbsp;Moonlight kiss hostel&nbsp; &amp; Pool&nbsp;offers 8 spacious clean rooms that are suitable for singles, couples or even a group stay. A 15-minute drive from the amazing Temples of Angkor and Siem Reap International Airport.</p>\r\n\r\n<p>All rooms are clean, spacious and included breakfast,&nbsp;high quality cotton sheets, duvets and feather pillows, complimentary wireless Internet access, slippers, bottled water and an ensuite bathroom. Daily housekeeping, Free&nbsp;pick up&nbsp;service from bus, ferry and&nbsp;airport.</p>', '1,2,4,5', '2016-12-08 16:04:04'),
(15, 'angkor davann, siem reap hotel, luxury hotel, 5 star hotel, luxury accommodation, amenities, luxury suites, restaurants & bars, meetings venues, spa packages, leisure activities, angkor davann hotel, official site, siem reap, travel in cambodia', 'Angkor Davann Hotel is a 5-star classic luxury hotel offers world-class service with excellence Khmer Hospitality in the heart of Siem Reap, Cambodia.', 1, 'Angkor Davann', 4, 1, 'Angkor-Davann-Hotel-1-960x585.jpg', '<p>Angkor Davann Luxury Hotel &amp; Spa, a classic 5 star hotel in Siem Reap Angkor that symbolized a perfect accommodation for your relaxation and homely stay with an intimate and unforgettable experience, which means &ldquo;Your Home Away from Home&rdquo;. The hotel offers non-stop classic and luxurious 5 star hospitality services with a spectacular experience of true relaxation.</p>\r\n\r\n<p>Angkor Davann Luxury Hotel &amp; Spa has a total of 65 graciously appointed hotel rooms and suites with your choice of pool view or city landmark view. The hotel rooms are respire and compose of wide range selection of room categories such as Premier Suite, Luxury Suite, Davann Suite, Family Room, Family Suite &amp; Presidential Suite at your selective choice of swimming pool view or landmark city view. All rooms are fully equipped with unrivaled hospitality, detail oriented amenities and purposely designed and being arranged to make your stay comfortable and truly convenient.</p>', '1,2,5', '2017-09-04 00:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel_categories`
--

CREATE TABLE `tbl_hotel_categories` (
  `id` int(2) NOT NULL,
  `Category_name` varchar(255) NOT NULL,
  `Descriptipn` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotel_categories`
--

INSERT INTO `tbl_hotel_categories` (`id`, `Category_name`, `Descriptipn`) VALUES
(1, 'Hotel', NULL),
(2, 'Hostel', NULL),
(3, 'Boutique', NULL),
(4, 'Villa', NULL),
(5, 'Apartment', NULL),
(6, 'Villa Boutique Hotel', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel_feature`
--

CREATE TABLE `tbl_hotel_feature` (
  `id` int(6) NOT NULL,
  `feature` varchar(100) NOT NULL,
  `others` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotel_feature`
--

INSERT INTO `tbl_hotel_feature` (`id`, `feature`, `others`, `last_update`) VALUES
(1, 'Restaurant', NULL, '2015-12-27 21:34:44'),
(2, 'Pool', NULL, '2015-12-27 21:34:47'),
(3, 'Garden', NULL, '2015-12-27 21:34:49'),
(4, 'Pub', NULL, '2015-12-27 21:34:53'),
(5, 'Massage & Spa', NULL, '2015-12-27 21:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hotel_vs_room_type`
--

CREATE TABLE `tbl_hotel_vs_room_type` (
  `id` int(8) NOT NULL,
  `site_keyword` text NOT NULL,
  `site_description` text NOT NULL,
  `hotel_id` int(6) NOT NULL,
  `room_type_id` int(6) NOT NULL,
  `room_feature_id` varchar(1000) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `description` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_hotel_vs_room_type`
--

INSERT INTO `tbl_hotel_vs_room_type` (`id`, `site_keyword`, `site_description`, `hotel_id`, `room_type_id`, `room_feature_id`, `image`, `price`, `description`, `last_update`) VALUES
(22, '', '', 7, 7, '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'superior_twins.jpg', '55.00', '<div><strong>* Superior City View</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms : 80 Room(s) - 34 sqm</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>The superior Room features a panoramic view of Siem Reap city and is furnished with wooden flooring, private balcony, separate bathtub and shower cubicle, smoke detector, and in-room emergency exit floor plan.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div><strong>* Terms and Conditions</strong></div>\r\n\r\n<div>\r\n<div>&nbsp;</div>\r\n\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>\r\n</div>', '2016-01-12 03:33:31'),
(23, '', '', 7, 8, '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'balcony_deluxe_room.jpg', '63.00', '<div><strong>* Deluxe Pool View</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms: 67 rooms-36 sqm</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>The Deluxe Room features pool and garden views and is furnished with wooden flooring, private balcony, separate bathtub and shower cubicle, smoke detector, and in-room emergency exit floor plan.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Terms and Conditions</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>', '2016-01-12 03:44:37'),
(24, '', '', 7, 9, '1,2,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'balcony(3).jpg', '67.00', '<div><strong>* Premium Standard Room</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms : 3 room (s)- 45 sqm.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<p>Most suitable for couples and the size enables you to relax and feel at home. They are kept in contemporary equipped with marble bathrooms, wood panelled wardrobes, and flat screen television. A full set of in-room facilities and amenities is we-equipped to gurantee you an utmost staying experience.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div><strong>&nbsp;* Terms and Conditions</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>\r\n</div>', '2016-01-12 04:15:45'),
(25, '', '', 7, 10, '1,2,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'premium_deluxe_double(2).jpg', '80.00', '<div>\r\n<div><strong>* Premium Deluxe Double</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms : 10 room (s)- 45 sqm.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Most suitable for couples and the size enables you to relax and feel at home. They are kept in contemporary equipped with marble bathrooms, wood panelled wardrobes, and flat screen television. A full set of in-room facilities and amenities is we-equipped to gurantee you an utmost staying experience.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div><strong>&nbsp;* Terms and Conditions</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>\r\n</div>\r\n</div>', '2016-01-12 04:16:35'),
(26, '', '', 7, 11, '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'premium_family_room1.jpg', '203.00', '<div><strong>* Premium Family Suite</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms : 3 Room(s) - 72 sqm.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>The 90 sqm size Premium Deluxe Family are the two rooms connected together with the door inside. Accommodated with 3 or 4 adults and 2 children. These rooms are located in the wooden house with private terrace or balcony. They are kept in contemporary equipped with marble bathrooms, wood panelled wardropbes and flat screen television. A full set of in-room facilities and amenities and amenities is well-equipped to guarantee you an utmost staying experience.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>&nbsp;* Terms and Conditions</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>', '2016-01-12 04:18:18'),
(27, '', '', 7, 12, '1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'somadevi_grand_suite(1).jpg', '135.00', '<div><strong>* Somadevi Grand Suite</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Total Rooms : 3 Room(s) - 72sqm.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>Our 72 sqm Grand Suite features a separate living room and bed room, which are well-equipped with wooden flooring and wood panelled wardrobes and grants you a full view of the swimming pool surrounded by our tropical gardens, which gives you and your family a comfort and warm feeling as you were staying at your home.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>&nbsp;* Terms and Conditions</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>\r\n<div>- Room Rates are quoted nightly in US Dollar.</div>\r\n\r\n<div>- Room Rates are included service charge and government tax.</div>\r\n\r\n<div>- Promotion Rates require a minimum of 3-night stay.</div>\r\n\r\n<div>- Room rates and benefit offers above are entitled for 02 persons only.</div>\r\n\r\n<div>- Steam, sauna and Jacuzzi are additional charge at Bayon Spa &amp; Health Club.</div>\r\n\r\n<div>- Children and Extra Bed Policy</div>\r\n\r\n<div>- One child under 4 years stays free of charge when using existing beds.</div>\r\n\r\n<div>- One child under 2 years stays free of charge in a child\'s cot or crib.</div>\r\n\r\n<div>- One child older than 11 years old or adult is charged USD 50 per person per night.</div>\r\n\r\n<div>- An extra bed include package offer.</div>\r\n\r\n<div>- The maximum number of extra bed/children\'s cots permitted only one per room.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><strong>* Cancellation Policy &amp; Payment</strong></div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Accept Visa,Master and JCB Cards.&nbsp;</div>\r\n\r\n<div>- In case of no-show, the total price of the reservation will be charged.</div>\r\n\r\n<div>- If cancelled or modified less than 4 days prior arrival date,</div>\r\n\r\n<div>&nbsp; 100 percent of the first night will be charged.</div>\r\n\r\n<div>- Hotel Somadevi Angkor Resort &amp; Spa accepts these cards and</div>\r\n\r\n<div>&nbsp; reserves the right to pre-authorise your card prior to arrival.</div>\r\n</div>', '2016-01-12 04:28:15'),
(28, '', '', 8, 13, '1,3,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'superior-king-6.jpg', '108.00', '<p>The superior rooms with triple, twin or king size beds are simple yet elegant. These rooms are stylishly decorated with access to everything you might need for a pleasant stay in Siem Reap.</p>', '2016-01-12 04:38:57'),
(29, '', '', 8, 6, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'bath-room-2.jpg.814x407_0_185_7774.jpg', '84.00', '<p>Deluxe rooms are spacious, bright and fresh, offering stylish surroundings. The separate bath and shower make the bathroom spacious. With twin or king size beds their space makes them an extremely comfortable choice. The courtyard view top off magnificent room choice.</p>', '2016-01-12 05:18:17'),
(30, '', '', 8, 14, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'executive-suite-1-1.jpg.814x407_0_28_5898.jpg', '84.00', '<p>The Executive Suites are 57 Sqm, they are spacious and exquisitely decorated offering modern comfort and style. As with all suites in the hotel they have the pleasure of observing both side and front views from the hotel through large windows offering an abundance of natural light. The bathroom off the master bedroom is large with a separate shower and a luxurious spa bath.</p>', '2016-01-12 05:24:59'),
(31, '', '', 8, 15, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'family-suite-2.jpg.814x407_0_71_6329 (1).jpg', '84.00', '<p>The only one in the hotel, this room is ideal for a family or 4 people traveling together. The Family Suite is 75 sqm, with a connecting double room. The Family suite is located on the middle of the 1st floor and has the luxury of observing both side and front views. The bathroom off the master bedroom has a separate shower with a spa bath.</p>', '2016-01-12 05:47:00'),
(32, '', '', 9, 6, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'full_img_9664_5_6_tonemapped_1444379786.jpg', '69.00', '<p>Our suite deluxe room with private balcony with swimming pool that guest can see the garden and restaurant. The primarily location upstairs and ground floor, feature queen size bed with good quality comfortable bed and spacious bathroom. These rooms are suitable for couple &amp; single. The decor features traditional Cambodian art and handicrafts by lotus flower on the wall, the chair with custom designed furniture.</p>\r\n\r\n<div>\r\n<p>Room size:&nbsp;57 m2&nbsp;|&nbsp;Bed size:1 queen bed</p>\r\n</div>\r\n\r\n<p>&nbsp;</p>', '2016-01-13 01:28:39'),
(33, '', '', 9, 13, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', 'full_dsc_0584_1444371425.jpg', '49.00', '<p>Our riverside superior with private balcony and guest can view to the countryside with fresh air, the primary location to ground floor and upstairs, good quality bedding as well, these rooms popular with couple and single.<br />\r\n<br />\r\nThe decor features traditional Cambodian art and handicrafts by lotus flower on the wall. The chair custom designed with furniture in balcony.</p>\r\n\r\n<div>Room size:&nbsp;51 m2&nbsp;|&nbsp;Bed size:1 queen bed</div>', '2016-01-13 01:33:23'),
(34, '', '', 10, 2, '6,8,9,10,11,13,14,16,17,18,19,20,21,22,23,24', '1_view1_y8zt8zcqa23f4dg1y3as.jpg', '100.00', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>Deluxe Double Room with Balcony and Bathtub&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>The best ideal choice for family or group of friends with one King size bed and one Queen Size bed with wooden furnitures and electric amenities in order to give the in depth insight of our traditional decoration. You also can request an extra bed and if you take 2 rooms for your family or friends you also can connect with each other by the connecting balcony. You may enjoy panorama view of the Siem Reap city, Sunset view, and Fresh air.</p>\r\n\r\n			<p>Additional Benefit</p>\r\n\r\n			<p>- Free Around trip airport transfer</p>\r\n\r\n			<p>- Free a plate of fruit (upon arrival)</p>\r\n\r\n			<p>- Free early check in (upon room availability</p>\r\n\r\n			<p>- Free wireless internet access 24hs</p>\r\n\r\n			<p>- Free 24hrs Business</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<h4>Prices</h4>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<th>\r\n						<p>&nbsp;</p>\r\n						</th>\r\n						<th colspan=\"3\">\r\n						<p>&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Adult&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Child&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Extra Bed&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>Mon</p>\r\n						</th>\r\n						<th>\r\n						<p>Tue</p>\r\n						</th>\r\n						<th>\r\n						<p>Wed</p>\r\n						</th>\r\n						<th>\r\n						<p>Thu</p>\r\n						</th>\r\n						<th>\r\n						<p>Fri</p>\r\n						</th>\r\n						<th>\r\n						<p>Sat</p>\r\n						</th>\r\n						<th>\r\n						<p>Sun</p>\r\n						</th>\r\n					</tr>\r\n					<tr>\r\n						<td colspan=\"15\">\r\n						<p>&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td colspan=\"3\">\r\n						<p>Standard Price</p>\r\n						</td>\r\n						<td>\r\n						<p>3</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Oct 01, 2015</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Mar 31, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Apr 01, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Sep 30, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Oct 01, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Mar 31, 2017</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$100.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Apr 01, 2017</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Sep 30, 2017</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$120.00</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '2016-01-13 01:45:36'),
(35, '', '', 10, 2, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '1_view1_c4xpc0ec2ymyn8tnt13h.jpg', '90.00', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><span style=\"font-size:18px\"><strong>Deluxe Double with Balcony&nbsp;</strong></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Single bed with the balcony is the ideal choice for single or couple with wooden furnitures and electric amenities in order to give the in depth insight of our traditional decoration. You may even enjoy with views of the swimming pool from the room and the room is guaranteed a view of the greens.</p>\r\n\r\n			<p>Additional Benefit</p>\r\n\r\n			<ul>\r\n				<li>\r\n				<p>Free Around trip airport transfer</p>\r\n				</li>\r\n				<li>\r\n				<p>Free a plate of fruit (upon arrival)</p>\r\n				</li>\r\n				<li>\r\n				<p>Free early check in (upon room availability</p>\r\n				</li>\r\n				<li>\r\n				<p>Free wireless internet access 24hs</p>\r\n				</li>\r\n				<li>\r\n				<p>Free 24hrs Business</p>\r\n				</li>\r\n			</ul>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<table>\r\n				<tbody>\r\n					<tr>\r\n						<td>\r\n						<p>Count:&nbsp;5</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>Room Area:&nbsp;30.0 m2</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>Max Adults:&nbsp;2</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>Availability:&nbsp;available</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<h4>Prices</h4>\r\n			</td>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<th>\r\n						<p>&nbsp;</p>\r\n						</th>\r\n						<th colspan=\"3\">\r\n						<p>&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Adult&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Child&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>&nbsp;Extra Bed&nbsp;</p>\r\n						</th>\r\n						<th>\r\n						<p>Mon</p>\r\n						</th>\r\n						<th>\r\n						<p>Tue</p>\r\n						</th>\r\n						<th>\r\n						<p>Wed</p>\r\n						</th>\r\n						<th>\r\n						<p>Thu</p>\r\n						</th>\r\n						<th>\r\n						<p>Fri</p>\r\n						</th>\r\n						<th>\r\n						<p>Sat</p>\r\n						</th>\r\n						<th>\r\n						<p>Sun</p>\r\n						</th>\r\n					</tr>\r\n					<tr>\r\n						<td colspan=\"15\">\r\n						<p>&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td colspan=\"3\">\r\n						<p>Standard Price</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>0</p>\r\n						</td>\r\n						<td>\r\n						<p>$0.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$90.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Oct 01, 2015</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Mar 31, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Apr 01, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Sep 30, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n					<tr>\r\n						<td>\r\n						<p>&nbsp;</p>\r\n						</td>\r\n						<td>\r\n						<p>Oct 01, 2016</p>\r\n						</td>\r\n						<td>\r\n						<p>-</p>\r\n						</td>\r\n						<td>\r\n						<p>Sep 30, 2017</p>\r\n						</td>\r\n						<td>\r\n						<p>2</p>\r\n						</td>\r\n						<td>\r\n						<p>1</p>\r\n						</td>\r\n						<td>\r\n						<p>$20.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00</p>\r\n						</td>\r\n						<td>\r\n						<p>$80.00&nbsp;</p>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', '2016-01-13 01:53:49'),
(36, '', '', 10, 10, '1,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '1_view3_ofot9tktq1lqraw2xcio.jpg', '100.00', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>Deluxe Double Room with Balcony and Bathtub&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>The best ideal choice for family or group of friends with one King size bed and one Queen Size bed with wooden furnitures and electric amenities in order to give the in depth insight of our traditional decoration. You also can request an extra bed and if you take 2 rooms for your family or friends you also can connect with each other by the connecting balcony. You may enjoy panorama view of the Siem Reap city, Sunset view, and Fresh air.</p>\r\n\r\n			<p>Additional Benefit</p>\r\n\r\n			<p>- Free Around trip airport transfer</p>\r\n\r\n			<p>- Free a plate of fruit (upon arrival)</p>\r\n\r\n			<p>- Free early check in (upon room availability</p>\r\n\r\n			<p>- Free wireless internet access 24hs</p>\r\n\r\n			<p>- Free 24hrs Business</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table class=\"room_description_inner\" style=\"background-color:rgb(249, 249, 249); border-collapse:collapse; border-spacing:0px; border:0px; font-family:open sans,sans-serif; font-size:15px; font-stretch:inherit; line-height:23px; margin:0px; outline:none; padding:0px; vertical-align:baseline\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Count:</strong>&nbsp;7</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Room Area:</strong>&nbsp;45.0 m<span style=\"font-family:inherit\">2</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Max Adults:</strong>&nbsp;2</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Beds:</strong>&nbsp;2</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Bathrooms:</strong>&nbsp;1</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Availability:</strong>&nbsp;<span style=\"color:rgb(32, 213, 12); font-family:inherit\">available</span></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border=\"0\" class=\"room_description\" style=\"background-color:rgb(249, 249, 249); border-collapse:collapse; border-spacing:0px; border:0px; font-family:open sans,sans-serif; font-size:15px; font-stretch:inherit; line-height:23px; margin:0px; outline:none; padding:0px; text-align:justify; vertical-align:baseline; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" style=\"text-align:left; vertical-align:top\">\r\n			<h4>Prices</h4>\r\n			</td>\r\n			<td style=\"text-align:left; vertical-align:top\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\" style=\"text-align:left; vertical-align:top\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"room_prices\" style=\"border-collapse:collapse; border-spacing:0px; border:1px solid rgb(204, 204, 204); font-family:inherit; font-size:11px; font-stretch:inherit; font-style:inherit; font-variant:inherit; font-weight:inherit; line-height:inherit; margin:0px; outline:none; padding:0px; vertical-align:baseline; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;</th>\r\n						<th colspan=\"3\" style=\"text-align:center; vertical-align:middle\">&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Adult&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Child&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Extra Bed&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Mon</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Tue</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Wed</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Thu</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Fri</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Sat</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Sun</th>\r\n					</tr>\r\n					<tr>\r\n						<td colspan=\"15\" style=\"height:0px; vertical-align:top\">&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td colspan=\"3\" style=\"text-align:center; vertical-align:top\"><strong>Standard Price</strong></td>\r\n						<td style=\"text-align:center; vertical-align:top\">3</td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Oct 01, 2015</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Mar 31, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Apr 01, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Sep 30, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Oct 01, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Mar 31, 2017</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$100.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Apr 01, 2017</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Sep 30, 2017</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$80.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$120.00</span></td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', '2016-01-13 02:03:02'),
(37, '', '', 10, 17, '1,3,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24', '1_view1_s7tq4yt00k3v9dwv3qho.jpg', '160.00', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>Studio Deluxe Twin&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>The only best choice for family, friends or couple for staying or relaxing. In the room aesthetically designed by Cambodian engineers, our hotel is rich with wooden furnitures and electric amenities in order to give the in depth insight of our traditional decoration. There is a small kitchen in room and a balcony that will make you feel fresh with panorama views of Siem Reap, and you also can see sunset from the balcony. Enjoy your day on the balcony with any drinks and snacks.</p>\r\n\r\n			<p>Additional Benefit</p>\r\n\r\n			<p>- Free Around trip airport transfer</p>\r\n\r\n			<p>- Free a plate of fruit (upon arrival)</p>\r\n\r\n			<p>- Free early check in (upon room availability</p>\r\n\r\n			<p>- Free wireless internet access 24hs</p>\r\n\r\n			<p>- Free 24hrs Business</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table class=\"room_description_inner\" style=\"background-color:rgb(249, 249, 249); border-collapse:collapse; border-spacing:0px; border:0px; font-family:open sans,sans-serif; font-size:15px; font-stretch:inherit; line-height:23px; margin:0px; outline:none; padding:0px; vertical-align:baseline\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Count:</strong>&nbsp;1</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Room Area:</strong>&nbsp;90.0 m<span style=\"font-family:inherit\">2</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Max Adults:</strong>&nbsp;3</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Beds:</strong>&nbsp;2</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Bathrooms:</strong>&nbsp;1</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\"><strong>Availability:</strong>&nbsp;<span style=\"color:rgb(32, 213, 12); font-family:inherit\">available</span></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border=\"0\" class=\"room_description\" style=\"background-color:rgb(249, 249, 249); border-collapse:collapse; border-spacing:0px; border:0px; font-family:open sans,sans-serif; font-size:15px; font-stretch:inherit; line-height:23px; margin:0px; outline:none; padding:0px; text-align:justify; vertical-align:baseline; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\" style=\"text-align:left; vertical-align:top\">\r\n			<h4>Prices</h4>\r\n			</td>\r\n			<td style=\"text-align:left; vertical-align:top\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\" style=\"text-align:left; vertical-align:top\">\r\n			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"room_prices\" style=\"border-collapse:collapse; border-spacing:0px; border:1px solid rgb(204, 204, 204); font-family:inherit; font-size:11px; font-stretch:inherit; font-style:inherit; font-variant:inherit; font-weight:inherit; line-height:inherit; margin:0px; outline:none; padding:0px; vertical-align:baseline; width:100%\">\r\n				<tbody>\r\n					<tr>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;</th>\r\n						<th colspan=\"3\" style=\"text-align:center; vertical-align:middle\">&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Adult&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Child&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">&nbsp;Extra Bed&nbsp;</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Mon</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Tue</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Wed</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Thu</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Fri</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Sat</th>\r\n						<th style=\"text-align:center; vertical-align:middle\">Sun</th>\r\n					</tr>\r\n					<tr>\r\n						<td colspan=\"15\" style=\"height:0px; vertical-align:top\">&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td colspan=\"3\" style=\"text-align:center; vertical-align:top\"><strong>Standard Price</strong></td>\r\n						<td style=\"text-align:center; vertical-align:top\">1</td>\r\n						<td style=\"text-align:center; vertical-align:top\">0</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Oct 01, 2015</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Mar 31, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">3</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Apr 01, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Sep 30, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">3</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span>&nbsp;</td>\r\n					</tr>\r\n					<tr>\r\n						<td style=\"text-align:center; vertical-align:top\">&nbsp;</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Oct 01, 2016</td>\r\n						<td style=\"text-align:center; vertical-align:top\">-</td>\r\n						<td style=\"text-align:center; vertical-align:top\">Mar 31, 2017</td>\r\n						<td style=\"text-align:center; vertical-align:top\">3</td>\r\n						<td style=\"text-align:center; vertical-align:top\">2</td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$20.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span></td>\r\n						<td style=\"text-align:center; vertical-align:top\"><span style=\"font-family:inherit\">$160.00</span>&nbsp;</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', '2016-01-13 02:09:36');
INSERT INTO `tbl_hotel_vs_room_type` (`id`, `site_keyword`, `site_description`, `hotel_id`, `room_type_id`, `room_feature_id`, `image`, `price`, `description`, `last_update`) VALUES
(38, '', '', 11, 18, '8,9,10,11,15,18,20,21,22', 'siem-reap-rooms-2.jpg', '8.00', '<p>We have 4 types of dorm rooms, 4 beds mixed dorm, 6 beds mixed dorm, 10 beds mixed dorm and 6 beds female dorm. All rooms have windows.</p>\r\n\r\n<div>\r\n<p>We provide large sleeping space to everyone. Our bunk beds are like boxes that can make you feel having some privacy. You will find electric socket, reading lamp and accessory case in your sleeping space.</p>\r\n\r\n<p>Although we are hostel, our mattresses, blankets and pillows are as good as items you will find in a hotel. All of our rooms are equipped with well maintained air-conditioner (Panasonic)</p>\r\n\r\n<p>We placed shared bathrooms out side the dorm room so your sleep will not be disturbed by noise from bathrooms.</p>\r\n\r\n<p>We provide large locker which size is 40cm*50cm*80cm. We also provide padlock for those who don\'t have their own padlock. So you will get 2 keys when you check in, one for the room door and another for the locker.</p>\r\n</div>', '2016-01-13 02:30:18'),
(39, '', '', 11, 19, '6,8,9,10,11,15,17,18,20,21,22', 'siem-reap-rooms-1.jpg', '7.00', '<p>We have 4 types of dorm rooms, 4 beds mixed dorm, 6 beds mixed dorm, 10 beds mixed dorm and 6 beds female dorm. All rooms have windows.</p>\r\n\r\n<div style=\"line-height: 20.8px;\">\r\n<p>We provide large sleeping space to everyone. Our bunk beds are like boxes that can make you feel having some privacy. You will find electric socket, reading lamp and accessory case in your sleeping space.</p>\r\n\r\n<p>Although we are hostel, our mattresses, blankets and pillows are as good as items you will find in a hotel. All of our rooms are equipped with well maintained air-conditioner (Panasonic)</p>\r\n\r\n<p>We placed shared bathrooms out side the dorm room so your sleep will not be disturbed by noise from bathrooms.</p>\r\n\r\n<p>We provide large locker which size is 40cm*50cm*80cm. We also provide padlock for those who don\'t have their own padlock. So you will get 2 keys when you check in, one for the room door and another for the locker.</p>\r\n</div>', '2016-01-13 02:32:10'),
(40, '', '', 11, 20, '1,6,9,10,11,12,15,18,21,22', 'siem-reap-rooms-3.jpg', '7.00', '<p>We have 4 types of dorm rooms, 4 beds mixed dorm, 6 beds mixed dorm, 10 beds mixed dorm and 6 beds female dorm. All rooms have windows.</p>\r\n\r\n<div style=\"line-height: 20.8px;\">\r\n<p>We provide large sleeping space to everyone. Our bunk beds are like boxes that can make you feel having some privacy. You will find electric socket, reading lamp and accessory case in your sleeping space.</p>\r\n\r\n<p>Although we are hostel, our mattresses, blankets and pillows are as good as items you will find in a hotel. All of our rooms are equipped with well maintained air-conditioner (Panasonic)</p>\r\n\r\n<p>We placed shared bathrooms out side the dorm room so your sleep will not be disturbed by noise from bathrooms.</p>\r\n\r\n<p>We provide large locker which size is 40cm*50cm*80cm. We also provide padlock for those who don\'t have their own padlock. So you will get 2 keys when you check in, one for the room door and another for the locker.</p>\r\n</div>', '2016-01-13 02:35:17'),
(41, '', '', 11, 23, '1,8,9,10,11,18,19,20,21,22', 'siem-reap-rooms-2(1).jpg', '7.00', '<p>We have 4 types of dorm rooms, 4 beds mixed dorm, 6 beds mixed dorm, 10 beds mixed dorm and 6 beds female dorm. All rooms have windows.</p>\r\n\r\n<div style=\"line-height: 20.8px;\">\r\n<p>We provide large sleeping space to everyone. Our bunk beds are like boxes that can make you feel having some privacy. You will find electric socket, reading lamp and accessory case in your sleeping space.</p>\r\n\r\n<p>Although we are hostel, our mattresses, blankets and pillows are as good as items you will find in a hotel. All of our rooms are equipped with well maintained air-conditioner (Panasonic)</p>\r\n\r\n<p>We placed shared bathrooms out side the dorm room so your sleep will not be disturbed by noise from bathrooms.</p>\r\n\r\n<p>We provide large locker which size is 40cm*50cm*80cm. We also provide padlock for those who don\'t have their own padlock. So you will get 2 keys when you check in, one for the room door and another for the locker.</p>\r\n</div>', '2016-01-13 02:37:45'),
(42, '', '', 12, 2, '6,8,9,10,11,15,18,19,20,21,22,23', 'siem-reap-hostel-double-room22-830x420.jpg', '18.00', '<p>Like to have your own space? The Deluxe Double is the perfect room for chilling out or getting much needed rest before the parties ahead!!</p>\r\n\r\n<p>The Deluxe Double Room has all the creature comforts you&rsquo;ll need, including Air Conditioning for additional $5, WI-FI, Desk and open wardrobe, En-Suite Bathroom with &lsquo;Rain forest Shower&rsquo;, as well as lockable storage for your belongings.</p>', '2016-01-13 02:47:38'),
(43, '', '', 12, 17, '1,6,8,9,10,11,14,15,18,21,22', 'siem-reap-hostel-twin-room1-830x420.jpg', '10.00', '<p>Travelling with buddies?? Our Twin Room is the perfect base of operations for those travelling as a pair, visiting the beautiful city of Siem Reap.</p>\r\n\r\n<p>The Deluxe Twin Room has all the creature comforts you&rsquo;ll need, including Air Conditioning additional $5, WI-FI, Desk and open wardrobe, En-Suite Bathroom with &lsquo;Rainforest Shower&rsquo;, as well as lockable storage for your belongings.</p>', '2016-01-13 02:52:13'),
(44, '', '', 12, 26, '6,9,10,11,17,18,19,21,22', 'siem-reap-hostel-quad-room1-830x420.jpg', '7.50', '<p>Travelling with buddies?? Our Deluxe Quad Room is the perfect base of operations for small groups up to four people, with two OVERSIZED-bunks for a great nights rest.</p>\r\n\r\n<p>The Deluxe Quad Room has all the creature comforts you&rsquo;ll need, including FULL Air Conditioning, WI-FI, En-Suite Bathroom with &lsquo;Rainforest Shower&rsquo;, as well as lockable storage for your belongings.</p>', '2016-01-13 03:02:56'),
(45, '', '', 12, 27, '6,9,10,11,17,18,20,21,22', 'siem-reap-hostel-mixed-dorm1-830x420.jpg', '7.00', '<p>Not fussed where you crash, or travelling on a budget?? Check out our Deluxe Mixed Dorm for the ultimate &lsquo;hostel&rsquo; experience!!</p>\r\n\r\n<p>This isn&rsquo;t just ANY dorm, the Funky Flashpacker Deluxe Mixed Dorms include OVERSIZED Bunkbeds, Safety Boxes, Easy Access Powerpoints and &lsquo;Rainforest&rsquo; Power Showers. Aside from these features, the Mixed Dorms also boast FULL Air Conditioning, and WI-FI.</p>\r\n\r\n<p>Tremendous value, and a great way to meet fellow travellers.</p>', '2016-01-13 03:28:36'),
(46, '', '', 12, 28, '6,9,10,11,12,14,15,16,18,19,20,21,22', 'siem-reap-hostel-mixed-dorm2-830x420.jpg', '7.00', '<p>Not fussed where you crash, or travelling on a budget?? Check out our Deluxe Female Dorm for the ultimate &lsquo;hostel&rsquo; experience!!</p>\r\n\r\n<p>This isn&rsquo;t just ANY dorm, the Funky Flashpacker Deluxe Mixed Dorms include OVERSIZED Bunkbeds, Safety Boxes, Easy Access Powerpoints and &lsquo;Rainforest&rsquo; Power Showers. Aside from these features, the Mixed Dorms also boast FULL Air Conditioning, and WI-FI.</p>\r\n\r\n<p>Tremendous value, and a great way to meet fellow travellers.</p>', '2016-01-13 03:35:20'),
(47, '', '', 12, 29, '6,9,10,11,14,17,18,19,20,22', 'siem-reap-hostel-quad-room-details-2-830x420.jpg', '16.00', '<p>A little smaller than our other rooms, the Deluxe Single has OVERSIZED-bunkbeds which will comfortably sleep either one or two.</p>\r\n\r\n<p>The Deluxe Single has all the creature comforts you&rsquo;ll need, including FULL Air Conditioning, WI-FI, En-Suite Bathroom with &lsquo;Rainforest Shower&rsquo;, as well as lockable storage for your belongings.</p>', '2016-01-13 03:39:03'),
(48, '', '', 13, 27, NULL, 'dorm21.jpg', '10.00', NULL, '2016-01-13 04:14:06'),
(49, '', '', 14, 30, '6,8,9,10,11,15,18,20,21,22', 'DSCF0290.JPG', '5.00', '<p>Deluxe 3&nbsp;Beds Female Dorm is the perfect base whether you are traveling for business or as a tourist. The room is bright and spacious, and the interior is designed in a fusion of traditional Cambodian and modern simplistic style.</p>\r\n\r\n<h3>Room Rate</h3>\r\n\r\n<div class=\"uk-overflow-container\" style=\"overflow: auto; color: rgb(68, 68, 68); font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(249, 249, 249);\">\r\n<table class=\"uk-table uk-table-condensed uk-table-hover uk-table-striped\" style=\"border-collapse:collapse; border-spacing:0px; margin-bottom:0px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<th>Time Line</th>\r\n			<th>Adult(s)</th>\r\n			<th>Kid(s)</th>\r\n			<th>Normal Rate/pax</th>\r\n			<th>Offer Rate/pax</th>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">27-Sep-2015 -&gt; 26-Dec-2015</td>\r\n			<td style=\"vertical-align:top\">6</td>\r\n			<td style=\"vertical-align:top\">&nbsp;</td>\r\n			<td style=\"vertical-align:top\">$ 10.00</td>\r\n			<td style=\"vertical-align:top\">$ 5.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">26-Dec-2015 -&gt; 08-Jan-2016</td>\r\n			<td style=\"vertical-align:top\">6</td>\r\n			<td style=\"vertical-align:top\">&nbsp;</td>\r\n			<td style=\"vertical-align:top\">$ 16.00</td>\r\n			<td style=\"vertical-align:top\">$ 5.00</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>', '2016-01-13 04:23:59'),
(50, '', '', 14, 31, '1,6,8,9,10,11,12,14,15,16,18,19,20,21,22', 'DSCF0294(1).JPG', '4.00', '<p>Deluxe 8 Beds&nbsp;Dorm is the perfect base whether you are traveling for business or as a tourist. The room is bright and spacious, and the interior is designed in a fusion of traditional Cambodian and modern simplistic style.</p>\r\n\r\n<h3>Room Rate</h3>\r\n\r\n<div class=\"uk-overflow-container\" style=\"overflow: auto; color: rgb(68, 68, 68); font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(249, 249, 249);\">\r\n<table class=\"uk-table uk-table-condensed uk-table-hover uk-table-striped\" style=\"border-collapse:collapse; border-spacing:0px; margin-bottom:0px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<th>Time Line</th>\r\n			<th>Adult(s)</th>\r\n			<th>Kid(s)</th>\r\n			<th>Normal Rate/pax</th>\r\n			<th>Offer Rate/pax</th>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">27-Sep-2015 -&gt; 17-Dec-2015</td>\r\n			<td style=\"vertical-align:top\">16</td>\r\n			<td style=\"vertical-align:top\">2</td>\r\n			<td style=\"vertical-align:top\">$ 10.00</td>\r\n			<td style=\"vertical-align:top\">$ 4.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">17-Dec-2015 -&gt; 17-Feb-2017</td>\r\n			<td style=\"vertical-align:top\">16</td>\r\n			<td style=\"vertical-align:top\">2</td>\r\n			<td style=\"vertical-align:top\">$ 16.00</td>\r\n			<td style=\"vertical-align:top\">$ 4.00</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>', '2016-01-13 04:35:05'),
(51, '', '', 14, 32, '1,6,8,9,10,11,13,14,15,16,18,19,20,21,22,24', '39797425.jpg', '15.00', '<p>Deluxe Room 2 Beds &nbsp;is the perfect base whether you are traveling for business or as a tourist. The room is bright and spacious, and the interior is designed in a fusion of traditional Cambodian and modern simplistic style.</p>\r\n\r\n<h3>Room Rate</h3>\r\n\r\n<div class=\"uk-overflow-container\" style=\"overflow: auto; color: rgb(68, 68, 68); font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; background-color: rgb(249, 249, 249);\">\r\n<table cellpadding=\"5\" class=\"uk-table uk-table-condensed uk-table-hover uk-table-striped\" style=\"border-collapse:collapse; border-spacing:0px; margin-bottom:0px; width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<th>Time Line</th>\r\n			<th>Adult(s)</th>\r\n			<th>Kid(s)</th>\r\n			<th>Normal Rate/pax</th>\r\n			<th>Offer Rate/pax</th>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">14-Jan-2015 -&gt; 30-Sep-2015</td>\r\n			<td style=\"vertical-align:top\">3</td>\r\n			<td style=\"vertical-align:top\">2</td>\r\n			<td style=\"vertical-align:top\">$ 25.00</td>\r\n			<td style=\"vertical-align:top\">$ 18.00</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"vertical-align:top\">01-Oct-2015 -&gt; 15-Jan-2016</td>\r\n			<td style=\"vertical-align:top\">3</td>\r\n			<td style=\"vertical-align:top\">2</td>\r\n			<td style=\"vertical-align:top\">$ 27.00</td>\r\n			<td style=\"vertical-align:top\">$ 18.00</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n</div>', '2016-01-13 04:37:30'),
(52, 'angkor davann, siem reap hotel, luxury hotel, 5 star hotel, luxury accommodation, amenities, luxury suites, restaurants & bars, meetings venues, spa packages, leisure activities, angkor davann hotel, official site, siem reap, travel in cambodia', 'Angkor Davann Hotel is a 5-star classic luxury hotel offers world-class service with excellence Khmer Hospitality in the heart of Siem Reap, Cambodia.', 15, 33, '1,6,9,11,12,13,14,15,16,17,18,19,20,22,23,24', '1454065505_Premier King 1.jpg', '75.00', '<p><strong>Premier Suite</strong>- Offers beautiful sceneries of swimming pool view or landmark city view with 48 square meters room size, high ceiling, wooden floors, a choice of King size or Twin beds, separate shower stall with bathtub and private balcony. It has a total of 35 (14 King, 21 TW) Premier Suite rooms.</p>\r\n\r\n<p><strong>IN-ROOM AMENITIES &amp; FURNITURES</strong><br />\r\n&ndash; Living room &amp; sofa<br />\r\n&ndash; Private balcony<br />\r\n&ndash; Flat-screen television &ldquo;32&rdquo;<br />\r\n&ndash; Cable / Satellite TV<br />\r\n&ndash; International direct dial telephone<br />\r\n&ndash; Safe deposit box<br />\r\n&ndash; Writing desk &amp; chair<br />\r\n&ndash; Mini-Bar &amp; fridge<br />\r\n&ndash; Individually controlled air-conditioning<br />\r\n&ndash; Individual climate control<br />\r\n&ndash; Coffee &amp; tea making facilities<br />\r\n&ndash; Bathroom with separate bath-tub and shower stall<br />\r\n&ndash; Telephone extension in the bathroom<br />\r\n&ndash; Bathroom amenities<br />\r\n&ndash; Bathrobe &amp; Slippers<br />\r\n&ndash; Hairdryer<br />\r\n&ndash; Toilet<br />\r\n&ndash; Toiletries<br />\r\n&ndash; Wireless Internet access<br />\r\n&ndash; Fire safety system with smoke detector</p>\r\n\r\n<p><strong>SERVICES &amp; FACILITIES</strong><br />\r\n&ndash; 24 Hours Front Office Communication Center<br />\r\n&ndash; Access to Swimming pool &amp; Fitness room<br />\r\n&ndash; Bell Service<br />\r\n&ndash; Multilingual &amp; English speaking staff<br />\r\n&ndash; Parking Service<br />\r\n&ndash; Laundry Service<br />\r\n&ndash; Shoe Cleaning Service<br />\r\n&ndash; Airport Shuttle for pick-up or transfer<br />\r\n&ndash; Tour information &amp; City tour<br />\r\n&ndash; Foreign Exchange Service<br />\r\n&ndash; Air Line ticket confirmation/ booking / buying service<br />\r\n&ndash; Bicycle rental service<br />\r\n&ndash; Limousine &amp; Taxi service<br />\r\n&ndash; WIFI connection in hotel rooms &amp; public areas<br />\r\n&ndash; 24 Hours security in all hotel areas &amp; parking<br />\r\n&ndash; Payment can be settled by Credit card via Master Card &amp; VISA Card</p>\r\n\r\n<p>Extra Bed: $35</p>', '2017-09-04 01:07:19'),
(53, 'angkor davann, siem reap hotel, luxury hotel, 5 star hotel, luxury accommodation, amenities, luxury suites, restaurants & bars, meetings venues, spa packages, leisure activities, angkor davann hotel, official site, siem reap, travel in cambodia', 'Angkor Davann Hotel is a 5-star classic luxury hotel offers world-class service with excellence Khmer Hospitality in the heart of Siem Reap, Cambodia.', 15, 34, '1,6,9,11,12,13,14,15,16,17,18,19,20,22,23,24', 'Luxury2-1140x450.jpg', '81.00', '<p><strong>Luxury Suite </strong>- Designed for luxury comfort with luxurious and high end furnished rooms with bigger space of 61 square meters, swimming pool view, wooden floors, a choice of King size or Twin beds, separate shower stall with bathtub and private balcony. It has a total of 18 (11 king, 7 TW) Luxury Suite rooms.</p>\r\n\r\n<p><strong>IN-ROOM AMENITIES &amp; FURNITURES</strong><br />\r\n&ndash; Living room &amp; sofa<br />\r\n&ndash; Private balcony<br />\r\n&ndash; Flat-screen television &ldquo;32&rdquo;<br />\r\n&ndash; Cable / Satellite TV<br />\r\n&ndash; International direct dial telephone<br />\r\n&ndash; Safe deposit box<br />\r\n&ndash; Writing desk &amp; chair<br />\r\n&ndash; Mini-Bar &amp; fridge<br />\r\n&ndash; Individually controlled air-conditioning<br />\r\n&ndash; Individual climate control<br />\r\n&ndash; Coffee &amp; tea making facilities<br />\r\n&ndash; Bathroom with separate bath-tub and shower stall<br />\r\n&ndash; Telephone extension in the bathroom<br />\r\n&ndash; Bathroom amenities<br />\r\n&ndash; Bathrobe &amp; Slippers<br />\r\n&ndash; Hairdryer<br />\r\n&ndash; Toilet<br />\r\n&ndash; Toiletries<br />\r\n&ndash; Wireless Internet access<br />\r\n&ndash; Fire safety system with smoke detector</p>\r\n\r\n<p><strong>SERVICES &amp; FACILITIES</strong><br />\r\n&ndash; 24 Hours Front Office Communication Center<br />\r\n&ndash; Access to Swimming pool &amp; Fitness room<br />\r\n&ndash; Bell Service<br />\r\n&ndash; Multilingual &amp; English speaking staff<br />\r\n&ndash; Parking Service<br />\r\n&ndash; Laundry Service<br />\r\n&ndash; Shoe Cleaning Service<br />\r\n&ndash; Airport Shuttle for pick-up or transfer<br />\r\n&ndash; Tour information &amp; City tour<br />\r\n&ndash; Foreign Exchange Service<br />\r\n&ndash; Air Line ticket confirmation/ booking / buying service<br />\r\n&ndash; Bicycle rental service<br />\r\n&ndash; Limousine &amp; Taxi service<br />\r\n&ndash; WIFI connection in hotel rooms &amp; public areas<br />\r\n&ndash; 24 Hours security in all hotel areas &amp; parking<br />\r\n&ndash; Payment can be settled by Credit card via Master Card &amp; VISA Card</p>\r\n\r\n<p>Extra Bed: $35</p>', '2017-09-04 01:38:22'),
(54, 'angkor davann, siem reap hotel, luxury hotel, 5 star hotel, luxury accommodation, amenities, luxury suites, restaurants & bars, meetings venues, spa packages, leisure activities, angkor davann hotel, official site, siem reap, travel in cambodia', 'Angkor Davann Hotel is a 5-star classic luxury hotel offers world-class service with excellence Khmer Hospitality in the heart of Siem Reap, Cambodia.', 15, 35, '1,6,9,11,12,13,14,15,16,17,18,19,20,22,23,24', 'Davann6-1140x450.jpg', '87.00', '<p><strong>Davann Suite </strong>- It has an elegant design with separate living room, master bedroom and private balcony with 85 square meters room size, high ceiling, wooden floors, comfortable King size bed, separate shower stall with bathtub and private balcony. It has a total of 10 Davann Suite rooms.</p>\r\n\r\n<p><strong>IN-ROOM AMENITIES &amp; FURNITURES</strong></p>\r\n\r\n<p>- Living room &amp; sofa<br />\r\n- Private balcony<br />\r\n- Flat-screen television &quot;32&quot;<br />\r\n- Cable / Satellite TV<br />\r\n- International direct dial telephone<br />\r\n- Safe deposit box<br />\r\n- Writing desk &amp; chair<br />\r\n- Mini-Bar &amp; fridge<br />\r\n- Individually controlled air-conditioning<br />\r\n- Individual climate control<br />\r\n- Coffee &amp; tea making facilities<br />\r\n- Bathroom with separate bath-tub and shower stall<br />\r\n- Telephone extension in the bathroom<br />\r\n- Bathroom amenities<br />\r\n- Bathrobe &amp; Slippers<br />\r\n- Hairdryer<br />\r\n- Toilet<br />\r\n- Toiletries<br />\r\n- Wireless Internet access<br />\r\n- Fire safety system with smoke detector</p>\r\n\r\n<p><strong>SERVICES &amp; FACILITIES</strong><br />\r\n- 24 Hours Front Office Communication Center<br />\r\n- Access to Swimming pool &amp; Fitness room<br />\r\n- Bell Service<br />\r\n- Multilingual &amp; English speaking staff<br />\r\n- Parking Service<br />\r\n- Laundry Service<br />\r\n- Shoe Cleaning Service<br />\r\n- Airport Shuttle for pick-up or transfer<br />\r\n- Tour information &amp; City tour<br />\r\n- Foreign Exchange Service<br />\r\n- Air Line ticket confirmation/ booking / buying service<br />\r\n- Bicycle rental service<br />\r\n- Limousine &amp; Taxi service<br />\r\n- WIFI connection in hotel rooms &amp; public areas<br />\r\n- 24 Hours security in all hotel areas &amp; parking<br />\r\n- Payment can be settled by Credit card via Master Card &amp; VISA Card</p>\r\n\r\n<p>Extra Bed: $35</p>', '2017-09-04 03:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int(2) NOT NULL,
  `Location_name` varchar(255) NOT NULL,
  `Descriptipn` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `Location_name`, `Descriptipn`) VALUES
(1, 'Siem Reap', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_description`
--

CREATE TABLE `tbl_page_description` (
  `id` int(11) NOT NULL,
  `page_link` varchar(255) NOT NULL,
  `page_s_name` varchar(250) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `site_keyword` text NOT NULL,
  `site_description` text NOT NULL,
  `images_thumbnail` text,
  `page_description` text,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_page_description`
--

INSERT INTO `tbl_page_description` (`id`, `page_link`, `page_s_name`, `page_name`, `site_keyword`, `site_description`, `images_thumbnail`, `page_description`, `last_update`) VALUES
(1, 'index.php', 'Home Page', 'i1booking.com - Bus ticket Best price, Hotel Booking in Siem reap Cambodia', 'nattakan Cambodia co.,ltd, nattakan,direct bus, bus to bangkok, bus ticket,online bus ticket, best price, how to buy direct bus ticket to bangkok, best price online bus ticket, transport co.,ltd, the transport company, I1Booking, direct bus to siem reap, the transport co.,ltd, the transport, transport, direct bus from bangkok to siem reap, direct bus from siem reap to bangkok,vip bus to siem reap, vip bus to bangkok,vip bus from siem reap to bangkok, vip bus from bangkok to siem reap, easy to buy online bus ticket,bus ticket to phnom, bus to sihanouk ville, bangkok to siem reap direct bus(Nattakan Online bus ticket Best price), siem reap to bagkok(nattakan vip bus best price), bus to ho chi minh, transport nattakan, nattakan transport, direct bus, taxi, van, nattakan best price, giant ibis, giant ibis best price, bus ticket, nattakan-transport,  cambodia-siem reap, cambodia-phnom penh, siem reap to bangkok bus schedule, \r\nsiem reap to bangkok by road, siem reap to bangkok bus time, siem reap to bangkok taxi, siem reap to poipet, bangkok to siem reap flights, bangkok to siem reap tour, nattakan bus siem reap to bangkok, nattakan transport,\r\nnattakan/transport co. ltd, nattakan cambodia bus, nattakan bus siem reap, nattakan bus office siem reap, transport co ltd, nattakan, bus phnom penh to bangkok, nattakan bus station bangkok, I1Booking, angkor wat, angkor, temple, mochit bus station, nattakan direct booking, land transport good service, land transport in cambodia, air bus, train in cambodia, boat, boat to koh rong, boat to koh rong saluem, top 1 Nattakan, Top transport booking, Vip transport, Top 5 transport, Top 10 book bus ticket, Lowest price Nattakan, Lowest transport, Zero booking fee tranport,', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'bus(1).jpg', NULL, '2017-08-28 02:53:34'),
(2, 'bus-operator.php', 'Bus operator', 'Bus operator to sell online ticket |i1booking.com', 'giant ibis, vireak buntham, nattakan, the transport co.,ltd, transport, bookme, booking bus ticket, mekong express, giant online ticket, giant bus ticket, taxi, bus, bus operator, capitol bus, ticket service, bus service, landing service, move to cambodia, 12go bus ticket, mochit bus terminal, mochit bus station, mochit 2, night bus, day bus, night bus to sihanouk ville, sleeping bus,', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'daily-booking-02-01.png', '<p>Our website was made to help customers to book their tickets for public transportation. Simple and easy. And we provide additional travel-related information -check it out by clicking on any station name and you will find unique information about that place. With Daily booking you can make reservations for public transport services. the valued customer visiting our website and making a reservation, or via one of our agent ore re -sellers or in any other way.</p>', '2016-05-30 19:49:58'),
(3, 'flights.php', 'Flights', 'Flights Ticket - Bus operator, bus ticket, I1Booking AT ASIA - Booking Bus ticket, i1booking.com', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'Flights Ticket', '308 150p-01.jpg', '<p>I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.</p>', '2016-05-31 21:49:21'),
(4, 'tours-packages.php', 'Tour Package', 'Tour Package- Siem reap, Online bus ticket, i1booking.com', 'tours, siemreap tour, cambodia, travel', 'Daily Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'Angkor-Thom-3.jpg', '<p>A trip to Cambodia isn&rsquo;t complete without a stop in the popular city of Siem Reap. This thriving community serves as the starting point for trips to Angkor Wat and nearby floating villages. It&rsquo;s also a hub for culture, cuisine and shopping.</p>\r\n\r\n<p>If you&rsquo;re going to Siem Reap then you&rsquo;re going to Angkor Wat. This incredible UNESCO World Heritage site is the largest religious monument in the world. Built in the 12th century by Khmer King Suryavarman II.</p>', '2016-05-31 21:51:42'),
(5, 'accommodation.php', 'Accommodation', 'Booking hotel', 'siem reap, Old market, Siem reap central, angkor wat, angkor, Mad monkey siem reap, funky flash back packer, siem reap down town, old market area, good location, cheap hotel, cheap guest house, cheap hostel, dormitory hostel, hotel in siem reap, boutique&hotel, boutique and spa, hotel and spa, somadevi, travel.com, booking, agoda, trip to siem reap, how to see cambodia, hostel in siem reap, hotel in siem reap,', 'Daily Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'sl-2.jpg', '<p>Siem Reap is the best option for an international traveler\'s base from which to explore the Angkor temples. If not for the tourism boom brought on by the awesome sites around the city, Siem Reap might have been another sleepy Khmer village. Instead we find a bustling tourist town, complete with a well-named Pub Street, food vendors, luxury hotels, backpacking hostels, and the international travelers that drive it all. Sure, you\'ll probably want to spend most of your time outside the city, but don\'t underestimate the awesome opportunity to hit the town and mingle, bargain, eat, and drink your way through Siem Reap.</p>', '2016-06-02 16:36:37'),
(6, 'contact.php', 'Contact Us', 'Contact Us - Bus operator, bus ticket, i1booking.com - Online Bus ticket, Booking Hotel | i1booking.com', 'contact, international bus, mochit 2 terminal, 011877727, 070877727, 078877727, Train ticket, I1Booking, hotel in siem reap, siem reap, Ho chi minh, sapaco, sapaco express, kumho samco, kumho, hang tep,', 'Daily Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'preview.jpg', '<p>Daily Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.</p>', '2016-05-30 03:47:02'),
(7, 'privacy-policy.php', 'Privacy Policy', 'Privacy Policy - Bus operator, Hotel operatr, Tour operation, i1booking.com', 'I1Booking, bus ticket, ticket, cambodia, khmer bus, cambodia ticket, thai ticket, siem reap bangkok, I1Booking privacy, I1Booking policy, hotel booking, siem reap, cambodia,', 'We value the trust you place in us. That\'s why we insist upon the highest standards for secure transactions and customer information privacy. Please read the following statement to learn about our information gathering and dissemination practices.', 'web-design1.jpg', NULL, '2016-05-31 21:59:10'),
(8, 'terms-and-conditions.php', 'Term and condition', 'Term and condition- Bus operator, bus ticket, I1Booking AT ASIA - Booking Bus ticket, Flights ticket, Tours destination and accommodation in Asia country - i1booking.com', 'irctc , one direction , pnr status , national rail , train running status , fake taxi , po , greyhound , train times , wiki , 15min , fs , directions , idos , railway , driving directions , taxi , erail , italo , flixbus , train enquiry , ado , eurostar , sbb , pnr , route planner , ns , train , apsrtc , tube map , bus , pamukkale , bahn de , taxi69 , el taxi , polski bus , ido , mta , vreme , spot your train , ouigo , meinfernbus , ams , car rental , tcl , ksrtc , draugas , die bahn , united states map , rent a car , jr , fcc , abcd 2 , delfi lt , elvira , www irctc co in , stuttgart , trenord , live train status , fernbus , national train enquiry system , rrb , ov9292 , her , 9292 , train tickets , london tube map , running train status , mobizen , hearthpwn , 9292ov , reittiopas , rental cars , abhibus , next bus , lirr schedule , national rail enquiries , taxi 69 , tec , trove , indianrail , lirr , dollar , railway enquiry , irctc co in , gilt , irtc , tan , vvs , parking , virginia , cff , stan , db bahn , rhb , red bus , trains , train schedule , bus times , scotrail , cars bg , tfc , irish rail , gulte , nsb , wikiloc , rail nation , get , septa , indianrailway , mpk , ttc , atac , oyster card , bc ferries , yellow cab , mtr , ave , uta , taxis , rail , onnibus , transport for london , schiphol , jfk airport , distance calculator , msrtc', 'Terms and Conditions are usually the most boring content, unless you are a lawyer or like self-inflicted pain. Nobody reads them until Murphy\'s Law strikes and things start to go wrong. Well, we would like to make it a bit less boring here, but keep in mind that this is an important part of business and needs to be clear and legally correct.', 'web.jpg', NULL, '2016-05-28 03:05:07'),
(9, 'about.php', 'About Us', 'About Us : I1Booking Travel booking bus ticket online', 'about I1Booking, about us, about ticket, bus ticket', 'I1Booking travel is the company that give customer the services booking online like bus ticket, accommodation, tour packages...', 'get.jpg', '<p>We\'re &nbsp;small indepensent company based out of Siem Reap, Cambodia. We provide an easy and convenient booking service for land transportation, guided tours and accomodation, all of which are accessible in English.&nbsp;</p>\r\n\r\n<p>Our goal initially, back in April 2016, was to provide the first direct VIP bus transport between Siem Reap and Bangkok. Since then we\'ve grown to provide transport to over 100 destinations across Cambodia, Thailand, Laos and Vietnam .</p>\r\n\r\n<p>In addition to providing transportation, we offer assistance in accomodation bookings anywhere you\'d like to visit in Cambodia. If you choose to stay here in Siem Reap, we\'d love to enhance your stay with one of our guided tours which are available in English. Whether you\'re an experienced travelle, or if it\'s your first time in Asia, we\'ll do our best to make things easy for you.&nbsp;</p>\r\n\r\n<p>We would love to ensure that you have a great experience while travelling and look forward to assisting you in any future bookings with us. Feel free to browse our web pages and if you have any questions at all, please don\'t hesitate to contact us.&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Phone: +85578877727</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : +85570877727&nbsp;</p>\r\n\r\n<p>Email: I1Bookingasia@gmail.com</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; : ticket@i1booking.com</p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;: info@i1booking.com</p>', '2017-02-18 19:39:29'),
(10, 'bus.php', 'Bus Operator', 'Bus Operator', 'giant ibis, vireak buntham, nattakan, the transport co.,ltd, transport, bookme, booking bus ticket, mekong express, giant online ticket, giant bus ticket, taxi, bus, bus operator, capitol bus, ticket service, bus service, landing service, move to cambodia, 12go bus ticket, mochit bus terminal, mochit bus station, mochit 2, night bus, day bus, night bus to sihanouk ville, sleeping bus,station, nattakan direct booking, land transport good service, land transport in cambodia, air bus, train in cambodia, boat, boat to koh rong, boat to koh rong saluem, top 1 Nattakan, Top transport booking, Vip transport, Top 5 transport, Top 10 book bus ticket, Lowest price Nattakan, Lowest transport, Zero booking fee tranport,', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', '13668785_597450017099586_8557305965951150569_o.png', NULL, '2017-05-24 13:34:01'),
(11, 'booking-seat.php', 'Booking Bus form', 'Bus Operator Booking form', 'giant ibis, vireak buntham, nattakan, the transport co.,ltd, transport, bookme, booking bus ticket, mekong express, giant online ticket, giant bus ticket, taxi, bus, bus operator, capitol bus, ticket service, bus service, landing service, move to cambodia, 12go bus ticket, mochit bus terminal, mochit bus station, mochit 2, night bus, day bus, night bus to sihanouk ville, sleeping bus,', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', '13668785_597450017099586_8557305965951150569_o(1).png', NULL, '2016-08-20 16:51:07'),
(12, 'payment-gateway.php', 'Payment Method', 'Payment Method', 'giant ibis, vireak buntham, nattakan, the transport co.,ltd, transport, bookme, booking bus ticket, mekong express, giant online ticket, giant bus ticket, taxi, bus, bus operator, capitol bus, ticket service, bus service, landing service, move to cambodia, 12go bus ticket, mochit bus terminal, mochit bus station, mochit 2, night bus, day bus, night bus to sihanouk ville, sleeping bus,', 'I1Booking offers a wide range of holiday packages that strive to meet your travel needs, your preferences and your trip budget within your desired response time. We talk with you and listen from you, understand you as to better propose suitable and cost-saving itinerary for you, should you need any customize packages apart from this site. Please do contact us for your next holiday planning, we are here ready to serve you and we strive to deliver a memorable and perfect holiday for you and your trip partners.', 'visa-master-card-logo (1).jpg', NULL, '2016-08-20 16:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_slider`
--

CREATE TABLE `tbl_page_slider` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `slide_title` varchar(250) DEFAULT NULL,
  `image` varchar(500) NOT NULL,
  `image_title` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_page_slider`
--

INSERT INTO `tbl_page_slider` (`id`, `page_id`, `slide_title`, `image`, `image_title`) VALUES
(1, 1, 'Guaranteed price. From authorized. Operators only.  E-Ticket & M-Ticket support.  Reschedule.  Book & Save points for rewards. Review & Rate bus operators  VISA Card, Master Card acceptance', 'bus New.jpg', 'Nattakan'),
(3, 2, NULL, 'I1Booking Banner(2).png', 'Booking trip'),
(4, 3, NULL, 'bus(1).jpg', 'Nattakan'),
(5, 4, NULL, 'thailand2(1).jpg', 'Booking trip'),
(6, 5, NULL, 'hotel_room_bed_furniture_luxury_70053_1680x1050.jpg', 'Hotel'),
(7, 6, NULL, 'web.jpg', 'contact us'),
(8, 7, NULL, 'web-design1.jpg', 'Privacy Policy'),
(9, 8, NULL, 'web(1).jpg', 'term and condition');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_privacy_policy`
--

CREATE TABLE `tbl_privacy_policy` (
  `id` int(3) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_privacy_policy`
--

INSERT INTO `tbl_privacy_policy` (`id`, `title`, `description`) VALUES
(1, '1. Collection of Personally Identifiable Information and other Information', '<p>When you use our Website, we store your browsing information. Our primary goal in doing so is to provide you a safe, efficient, smooth and customized experience. This allows us to provide services and features that most likely meet your needs, and to customize our Website to make your experience safer and easier. More importantly, while doing so we collect personal information from you that we consider necessary for achieving this purpose.</p>\r\n\r\n<p>In general, you can browse the Website without telling us who you are or revealing any personal information about yourself. Once you give us your personal information, you are not anonymous to us. Where possible, we indicate which fields are required and which fields are optional. You always have the option to not provide information by choosing not to use a particular service or feature on the Website. We may automatically track certain information about you based upon your behavior on our Website. We use this information to do internal research on our users\' demographics, interests, and behavior to better understand, protect and serve our users. This information is compiled and analyzed on an aggregated basis. This information may include the URL that you just came from (whether this URL is on our Website or not), which URL you next go to (whether this URL is on our Website or not), your computer browser information, and your IP address.</p>\r\n\r\n<p>We use data collection devices such as &quot;cookies&quot; on certain pages of the Website to help analyses our web page flow, measure promotional effectiveness, and promote trust and safety. &quot;Cookies&quot; are small files placed on your hard drive that assist us in providing our services. We offer certain features that are only available through the use of a &quot;cookie&quot;.</p>\r\n\r\n<p>Additionally, you may encounter &quot;cookies&quot; or other similar devices on certain pages of the Website that are placed by third parties. We do not control the use of cookies by third parties.</p>\r\n\r\n<p>If you choose to buy on the Website, we collect information about your buying behavior.</p>\r\n\r\n<p>If you choose to post reviews and tips about buses or post messages or leave feedback, we will collect that information you provide to us. We retain this information as necessary to resolve disputes, provide customer support and troubleshoot problems as permitted by law. If you send us personal correspondence, such as emails or letters, or if other users or third parties send us correspondence about your activities or postings on the Website, we may collect such information into a file specific to you.</p>\r\n\r\n<p>We collect personally identifiable information (email address, name, phone number.) from you when you set up a free account with us. We do use your contact information to send you offers based on your previous orders and your interests.</p>'),
(2, '2. Security Precautions', '<p><span style=\"font-family:source sans pro,helvetica neue,helvetica,arial,sans-serif; font-size:14px\">Our Website has stringent security measures in place to protect the loss, misuse, and alteration of the information under our control. Whenever you change or access your account information, we offer the use of a secure server. Once your information is in our possession we adhere to strict security guidelines, protecting it against unauthorized access.</span></p>'),
(3, '3. Your Consents', '<p><span style=\"font-family:source sans pro,helvetica neue,helvetica,arial,sans-serif; font-size:14px\">By using the Website and/ or by providing your information, you consent to the collection and use of the information you disclose on the Website in accordance with this Privacy Policy, including but not limited to your consent for sharing your information as per this privacy policy. If we decide to change our privacy policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it.</span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_description_photo`
--

CREATE TABLE `tbl_room_description_photo` (
  `id` int(8) NOT NULL,
  `room_description_id` int(8) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `description` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room_description_photo`
--

INSERT INTO `tbl_room_description_photo` (`id`, `room_description_id`, `image`, `description`, `last_update`) VALUES
(19, 22, 'superior_twins.jpg', NULL, '2016-01-12 03:35:21'),
(20, 22, 'balcony_superior.jpg', NULL, '2016-01-12 03:37:38'),
(21, 22, 'bathroom(1).jpg', NULL, '2016-01-12 03:37:58'),
(22, 22, 'bedrobe.jpg', NULL, '2016-01-12 03:38:35'),
(23, 22, 'superior_twin_room.jpg', NULL, '2016-01-12 03:38:55'),
(24, 23, 'balcony_deluxe_room.jpg', NULL, '2016-01-12 03:45:07'),
(25, 23, 'deluxe_double_room7.jpg', NULL, '2016-01-12 03:45:25'),
(26, 23, 'deluxe_double_room8.jpg', NULL, '2016-01-12 03:45:41'),
(27, 23, 'deluxe_twin_room3.jpg', NULL, '2016-01-12 03:45:58'),
(28, 23, 'deluxe_twin_room4.jpg', NULL, '2016-01-12 03:46:17'),
(29, 24, 'balcony(1).jpg', NULL, '2016-01-12 03:59:28'),
(30, 24, 'bathroom_premium.jpg', NULL, '2016-01-12 03:59:39'),
(31, 24, 'bedrobe(1).jpg', NULL, '2016-01-12 03:59:56'),
(32, 24, 'premium_double_room.jpg', NULL, '2016-01-12 04:00:13'),
(33, 24, 'premium_double_room1(1).jpg', NULL, '2016-01-12 04:00:33'),
(34, 24, 'premium_double4.jpg', NULL, '2016-01-12 04:00:57'),
(37, 25, 'premium_double4(1).jpg', NULL, '2016-01-12 04:09:22'),
(38, 25, 'premium_double_room1(2).jpg', NULL, '2016-01-12 04:09:45'),
(39, 25, 'premium_deluxe_double(2).jpg', NULL, '2016-01-12 04:10:36'),
(40, 25, 'bedrobe(2).jpg', NULL, '2016-01-12 04:11:08'),
(41, 25, 'bathroom_premium(1).jpg', NULL, '2016-01-12 04:11:23'),
(42, 25, 'balcony(3).jpg', NULL, '2016-01-12 04:11:38'),
(43, 26, 'premium_family_room3.jpg', NULL, '2016-01-12 04:19:10'),
(44, 26, 'premium_family_room1.jpg', NULL, '2016-01-12 04:19:25'),
(45, 26, 'premium_family_room(1).jpg', NULL, '2016-01-12 04:19:40'),
(46, 26, 'premium_double_room2.jpg', NULL, '2016-01-12 04:21:10'),
(47, 26, 'bedrobe(3).jpg', NULL, '2016-01-12 04:21:45'),
(48, 26, 'bathroom_premium(2).jpg', NULL, '2016-01-12 04:22:10'),
(49, 26, 'balcony(2).jpg', NULL, '2016-01-12 04:22:34'),
(50, 27, 'somadevi_suite.jpg', NULL, '2016-01-12 04:29:30'),
(51, 27, 'somadevi_grand_suite(1).jpg', NULL, '2016-01-12 04:29:59'),
(52, 27, 'living_room_suite.jpg', NULL, '2016-01-12 04:30:17'),
(53, 28, 'superior-king-6.jpg', NULL, '2016-01-12 04:40:41'),
(54, 28, 'superior-triple-1.jpg', NULL, '2016-01-12 04:40:55'),
(55, 28, 'superior-triple-2.jpg', NULL, '2016-01-12 04:41:10'),
(56, 28, 'superior-twin-1.jpg', NULL, '2016-01-12 04:41:26'),
(59, 29, 'bath-room-2.jpg.814x407_0_185_7774.jpg', NULL, '2016-01-12 05:20:00'),
(60, 29, 'deluxe-king-1.jpg.814x407_42_22_6534.jpg', NULL, '2016-01-12 05:20:22'),
(61, 29, 'deluxe-king-2.jpg.814x407_0_20_6007.jpg', NULL, '2016-01-12 05:20:46'),
(62, 29, NULL, NULL, '2016-01-12 05:21:07'),
(63, 29, 'deluxe-king-4.jpg.814x407_0_2_6699.jpg', NULL, '2016-01-12 05:21:24'),
(71, 30, '000 (1).jpg', NULL, '2016-01-12 05:33:43'),
(72, 30, '000 (2).jpg', NULL, '2016-01-12 05:34:10'),
(73, 30, '000 (3).jpg', NULL, '2016-01-12 05:34:30'),
(74, 31, 'family-suite-2.jpg.814x407_0_71_6329 (1).jpg', NULL, '2016-01-12 05:48:16'),
(75, 31, 'family-suite-2.jpg.814x407_0_71_6329.jpg', NULL, '2016-01-12 05:50:37'),
(76, 31, 'family-suite-3.jpg.814x407_32_14_6204.jpg', NULL, '2016-01-12 05:50:58'),
(77, 32, 'full_img_9664_5_6_tonemapped_1444379786.jpg', NULL, '2016-01-13 01:29:34'),
(78, 32, 'full_img_9744_5_6_tonemapped_1444379793.jpg', NULL, '2016-01-13 01:29:43'),
(79, 32, 'full_img_9717_8_9_tonemapped_1446621042.jpg', NULL, '2016-01-13 01:31:23'),
(80, 32, 'sm_thumb_img_9784_5_6_tonemapped_1444387500.jpg', NULL, '2016-01-13 01:31:39'),
(81, 33, 'full_dsc_0584_1444371425.jpg', NULL, '2016-01-13 01:33:59'),
(82, 33, 'sm_thumb_img_9784_5_6_tonemapped_1444387500(1).jpg', NULL, '2016-01-13 01:34:22'),
(83, 33, 'full_dsc_0564_1444380160.jpg', NULL, '2016-01-13 01:34:50'),
(84, 34, '1_view1_y8zt8zcqa23f4dg1y3as.jpg', NULL, '2016-01-13 01:46:44'),
(85, 34, '1_view2_pa1o84r4kf3i9b35ozfy.jpg', NULL, '2016-01-13 01:46:56'),
(86, 34, '1_view5_x1j92tgymsa4vl47prup.jpg', NULL, '2016-01-13 01:47:10'),
(87, 35, '1_view1_c4xpc0ec2ymyn8tnt13h.jpg', NULL, '2016-01-13 01:54:24'),
(88, 35, '1_view3_ofot9tktq1lqraw2xcio (1).jpg', NULL, '2016-01-13 01:54:39'),
(89, 35, '1_view3_ofot9tktq1lqraw2xcio.jpg', NULL, '2016-01-13 01:54:50'),
(90, 36, '1_view3_ofot9tktq1lqraw2xcio(1).jpg', NULL, '2016-01-13 02:03:23'),
(91, 37, '1_view1_s7tq4yt00k3v9dwv3qho.jpg', NULL, '2016-01-13 02:10:00'),
(92, 37, '1_view2_yeg4zunme10gmn9vybmw.jpg', NULL, '2016-01-13 02:10:09'),
(93, 37, '1_view3_ac6pjsuxkmx3182d3n87.jpg', NULL, '2016-01-13 02:10:19'),
(94, 38, 'siem-reap-rooms-2.jpg', NULL, '2016-01-13 02:28:21'),
(95, 38, 'siem-reap-rooms-3.jpg', NULL, '2016-01-13 02:28:30'),
(96, 38, 'siem-reap-rooms-1.jpg', NULL, '2016-01-13 02:29:19'),
(97, 39, 'siem-reap-rooms-3(1).jpg', NULL, '2016-01-13 02:32:38'),
(98, 39, 'siem-reap-rooms-2(1).jpg', NULL, '2016-01-13 02:32:48'),
(99, 39, 'siem-reap-rooms-1(1).jpg', NULL, '2016-01-13 02:32:57'),
(100, 40, 'siem-reap-rooms-2(2).jpg', NULL, '2016-01-13 02:34:07'),
(101, 40, 'siem-reap-rooms-1(2).jpg', NULL, '2016-01-13 02:34:20'),
(102, 40, 'siem-reap-rooms-3(2).jpg', NULL, '2016-01-13 02:34:32'),
(103, 41, 'siem-reap-rooms-1(3).jpg', NULL, '2016-01-13 02:38:00'),
(104, 41, 'siem-reap-rooms-2(3).jpg', NULL, '2016-01-13 02:38:13'),
(105, 41, 'siem-reap-rooms-3(3).jpg', NULL, '2016-01-13 02:38:26'),
(106, 42, 'siem-reap-hostel-double-room12-830x420.jpg', NULL, '2016-01-13 02:48:18'),
(107, 42, 'siem-reap-hostel-double-room22-830x420.jpg', NULL, '2016-01-13 02:48:28'),
(108, 42, 'siem-reap-hostel-bathroom21-830x420.jpg', NULL, '2016-01-13 02:48:47'),
(109, 42, 'siem-reap-hostel-bathroom11-830x420.jpg', NULL, '2016-01-13 02:49:03'),
(110, 43, 'siem-reap-hostel-twin-room2-830x420.jpg', NULL, '2016-01-13 02:52:37'),
(111, 43, 'siem-reap-hostel-twin-room1-830x420.jpg', NULL, '2016-01-13 02:52:45'),
(112, 43, 'siem-reap-hostel-sky-bar-seating2-830x420.jpg', NULL, '2016-01-13 02:52:56'),
(113, 43, 'siem-reap-hostel-bathroom2-830x420.jpg', NULL, '2016-01-13 02:53:10'),
(114, 43, 'siem-reap-hostel-pool-side-seating1-830x420.jpg', NULL, '2016-01-13 02:53:29'),
(115, 43, 'siem-reap-hostel-bathroom1-830x420.jpg', NULL, '2016-01-13 02:53:39'),
(116, 44, 'siem-reap-hostel-quad-room1-830x420.jpg', NULL, '2016-01-13 03:03:20'),
(117, 44, 'siem-reap-hostel-quad-room-details-1-830x420.jpg', NULL, '2016-01-13 03:03:29'),
(118, 44, 'siem-reap-hostel-sky-bar-seating3-830x420.jpg', NULL, '2016-01-13 03:03:43'),
(119, 44, 'siem-reap-hostel-pool-side-seating2-830x420.jpg', NULL, '2016-01-13 03:04:01'),
(120, 44, 'siem-reap-hostel-mixed-dorm31-830x420.jpg', NULL, '2016-01-13 03:04:15'),
(121, 45, 'siem-reap-hostel-mixed-dorm1-830x420.jpg', NULL, '2016-01-13 03:29:01'),
(122, 45, 'siem-reap-hostel-mixed-dorm2-830x420.jpg', NULL, '2016-01-13 03:29:12'),
(123, 45, 'siem-reap-hostel-mixed-dorm3-830x420.jpg', NULL, '2016-01-13 03:29:24'),
(124, 45, 'siem-reap-hostel-pool-side-seating-830x420.jpg', NULL, '2016-01-13 03:32:48'),
(125, 46, 'siem-reap-hostel-mixed-dorm2-830x420(1).jpg', NULL, '2016-01-13 03:35:41'),
(126, 46, 'siem-reap-hostel-mixed-dorm1-830x420(1).jpg', NULL, '2016-01-13 03:35:53'),
(127, 47, 'siem-reap-hostel-quad-room-details-2-830x420.jpg', NULL, '2016-01-13 03:39:27'),
(128, 47, 'siem-reap-hostel-mixed-dorm3-830x420(1).jpg', NULL, '2016-01-13 03:40:28'),
(129, 49, 'DSCF0326.JPG', NULL, '2016-01-13 04:30:39'),
(130, 49, 'DSCF0304.JPG', NULL, '2016-01-13 04:30:53'),
(131, 49, 'DSCF0312.JPG', NULL, '2016-01-13 04:31:33'),
(132, 50, 'DSCF0294(1).JPG', NULL, '2016-01-13 04:38:06'),
(133, 50, 'DSCF0304(1).JPG', NULL, '2016-01-13 04:38:34'),
(134, 51, '39797425.jpg', NULL, '2016-01-13 04:39:15'),
(135, 52, '1454065505_Premier King 1.jpg', NULL, '2017-09-04 01:07:33'),
(136, 52, '1454065505_Premier King 2.jpg', NULL, '2017-09-04 01:08:14'),
(137, 53, 'Luxury2-1140x450.jpg', NULL, '2017-09-04 01:38:38'),
(138, 53, 'Luxury3-1140x450.jpg', NULL, '2017-09-04 01:39:15'),
(139, 53, 'Luxury1-1140x450.jpg', NULL, '2017-09-04 01:40:25'),
(140, 54, 'Davann6-1140x450.jpg', NULL, '2017-09-04 01:51:58'),
(141, 54, 'Davann5-1140x450.jpg', NULL, '2017-09-04 01:53:02'),
(142, 54, 'Davann3-1140x450.jpg', NULL, '2017-09-04 01:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_feature`
--

CREATE TABLE `tbl_room_feature` (
  `id` int(6) NOT NULL,
  `feature` varchar(100) NOT NULL,
  `others` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room_feature`
--

INSERT INTO `tbl_room_feature` (`id`, `feature`, `others`, `last_update`) VALUES
(1, 'Tea and Coffee', NULL, '2015-12-27 21:36:37'),
(3, 'Hair Dryer', NULL, '2015-12-27 21:36:51'),
(4, 'Milk', NULL, '2015-12-27 21:36:55'),
(6, 'Wifi', NULL, '2015-12-27 21:37:07'),
(7, 'Cassete', NULL, '2015-12-27 21:37:13'),
(8, 'TV', NULL, '2015-12-27 21:37:17'),
(9, 'Air Condition', NULL, '2015-12-27 21:37:23'),
(10, 'Fan', NULL, '2015-12-27 21:37:29'),
(11, 'Standby Lamp', NULL, '2015-12-27 21:37:35'),
(12, 'Refrigerator', NULL, '2015-12-27 21:37:56'),
(13, 'Private balcony', NULL, '2016-01-12 03:25:23'),
(14, 'Individual bathtube and shower cubicle', NULL, '2016-01-12 03:25:39'),
(15, 'In-room safe deposit box', NULL, '2016-01-12 03:25:54'),
(16, 'Bedside control panel', NULL, '2016-01-12 03:26:12'),
(17, 'Telephone', NULL, '2016-01-12 03:26:28'),
(18, 'Writing desk', NULL, '2016-01-12 03:26:45'),
(19, 'In-room directory', NULL, '2016-01-12 03:26:59'),
(20, 'Bathroom amenities', NULL, '2016-01-12 03:27:54'),
(21, 'Complimentary bottled water', NULL, '2016-01-12 03:27:54'),
(22, 'Tea/coffee making facilities', NULL, '2016-01-12 03:27:54'),
(23, 'Disposable slipper', NULL, '2016-01-12 03:27:54'),
(24, 'Bathrobe', NULL, '2016-01-12 03:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_type`
--

CREATE TABLE `tbl_room_type` (
  `id` int(6) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_room_type`
--

INSERT INTO `tbl_room_type` (`id`, `room_name`, `last_update`) VALUES
(1, 'Single Room', '2015-12-27 22:26:54'),
(2, 'Double Room', '2015-12-27 22:27:04'),
(3, 'Triple Room', '2015-12-27 22:27:09'),
(4, 'King Size Room', '2015-12-27 22:27:34'),
(5, 'Suite Room', '2015-12-27 22:27:36'),
(6, 'Deluxe Room', '2016-01-12 04:34:11'),
(7, 'Superior City View', '2016-01-12 03:22:56'),
(8, 'Deluxe Pool View', '2016-01-12 03:23:12'),
(9, 'Premium Double Room', '2016-01-12 03:23:36'),
(10, 'Premium Deluxe Double', '2016-01-12 03:23:52'),
(11, 'Premium Family Suite', '2016-01-12 03:24:03'),
(12, 'Somadevi Grand Suite', '2016-01-12 03:24:15'),
(13, 'Superior room', '2016-01-12 04:33:54'),
(14, 'Executive room', '2016-01-12 04:34:51'),
(15, 'Family suite', '2016-01-12 04:34:51'),
(16, 'Tara suite', '2016-01-12 04:34:51'),
(17, 'Deluxe Twin', '2016-01-13 02:06:40'),
(18, '4 beds mixed dorm', '2016-01-13 02:23:11'),
(19, '6 beds mixed dorm', '2016-01-13 02:23:11'),
(20, '8 beds mixed dorm', '2016-01-13 02:23:11'),
(21, '10 beds mixed dorm', '2016-01-13 02:23:11'),
(22, '4 beds female dorm', '2016-01-13 02:23:11'),
(23, '6 beds female dorm', '2016-01-13 02:23:11'),
(24, '8 beds female dorm', '2016-01-13 02:23:11'),
(25, '10 beds female dorm', '2016-01-13 02:23:11'),
(26, 'Deluxe Quad', '2016-01-13 03:30:20'),
(27, 'Deluxe Mixed Dorm', '2016-01-13 03:30:57'),
(28, 'Deluxe Female Dorm', '2016-01-12 19:00:00'),
(29, 'Deluxe Single', '2016-01-12 19:00:00'),
(30, 'Female Dorm room 3beds', '2016-01-13 04:19:43'),
(31, 'Deluxe AC 8 Beds Mixed Dorm', '2016-01-13 04:19:43'),
(32, 'Deluxe Room', '2016-01-13 04:19:43'),
(33, 'Premier Suite', '2017-09-04 01:00:40'),
(34, 'Luxury Suite', '2017-09-04 01:00:40'),
(35, 'Davann Suite', '2017-09-04 01:00:40'),
(36, 'Family Suite', '2017-09-04 01:00:40'),
(37, 'Presidential Suite', '2017-09-04 01:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_terms_and_conditions`
--

CREATE TABLE `tbl_terms_and_conditions` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_terms_and_conditions`
--

INSERT INTO `tbl_terms_and_conditions` (`id`, `title`, `description`) VALUES
(1, 'General Terms and Conditions of our Service', '<p>Terms and Conditions are usually the most boring content, unless you are a lawyer or like self-inflicted pain. Nobody reads them until Murphy\'s Law strikes and things start to go wrong. Well, we would like to make it a bit less boring here, but keep in mind that this is an important part of business and needs to be clear and legally correct.</p>\r\n\r\n<p>Our website was built to help customers book their tickets for public transportation. Simple and easy. And we provide additional travel-related information &ndash; check it out by clicking on any station name to find unique information about that place. With I1Booking you can make reservations for public transportation services. When the text says &ldquo;we&rdquo;, &ldquo;us&rdquo;, &ldquo;our&rdquo; or &ldquo;I1Booking&rdquo; it means i1booking.com. The term &ldquo;you&rdquo; refers to you, the valued customer visiting our website and making a reservation yourself or via one of our agents or re-sellers or in any other way.</p>\r\n\r\n<p>If you use our website, you agree to our terms and conditions and are bound by them. No excuses, no modifications. If you don\'t like it or do not agree to our conditions, stay away and buy your ticket the old-fashioned way &ndash; days in advance at a local ticket counter. Terms and conditions change over time. This is normal and common sense. We can change the terms at any time and will not announce this in advance. But this will happen only when it is absolutely necessary, so don\'t worry, it will not happen frequently.</p>\r\n\r\n<p>I1Booking is an online ticket agent. We are not a charity; we sell tickets. We do not operate any vehicles on our own. To provide excellent service to you, we have connected a network of over 140 operators. We show prices, departure and transit times and some pictures of vehicles you can expect to travel with, and we provide fair prices. We recommend that you use bus operators you are familiar with and whose service you feel comfortable with. Please keep in mind that public transportation in Asia might be different from experiences you have had in your home country and that locals often do not speak English.</p>'),
(2, 'I1Booking responsibilities (What we do)', '<p>For buses and ferries, immediately after payment we will provide you with a ticket that is accepted by your transportation services company. If you need to change or cancel a ticket, there might be fees from the operator. If cancellations are made within the cancellation time allowed by the operator, tickets can be refunded at the corresponding fraction of the fare (not including the fees!). So please, please, double-check your departure times and dates before you click &ldquo;Pay&rdquo;. Some operators do not refund at all, and some tickets cannot be changed. This is out of our control. We will provide support and information in case of any delays or problems we are aware of.</p>\r\n\r\n<p>The process with train tickets is different. After successful payment, we will try to purchase the ticket for you. You will receive a confirmation of successful booking and another one that the tickets were issued, or you will receive a message that your train is fully booked, in which case we will tell you the alternatives. If the alternatives do not suit you, we will fully refund your ticket price. If the alternative ticket is cheaper than the one you paid for, we will refund the price difference. Train tickets have to be ordered a couple of days in advance. The earlier you order, the greater the chance you will actually get your ticket. We are not bound by the 30/60-days-in-advance booking limitation of Thailand State Railways. We can accept bookings for any day in the future. Train tickets have to be purchased by us at the railway counter. We will do this as soon as possible after we have received your payment. There is a chance that during this time your train will become fully booked. Please do not expect that the ticket is yours immediately after you pay &ndash; wait for the final confirmation! The number of available seats shown do not reflect reality; they only indicate that there might be free seats on that train. Tickets can be picked up in Bangkok at our office in the DOB Building opposite the Hua Lamphong railway station (or at the Bosshotel in Chiang Mai) any time after they are issued. If you plan to pick them up outside office hours, please inform our team in advance. Please collect your tickets at least 60 minutes before departure and bring a valid photo ID with you.</p>'),
(3, 'I1Booking responsibilities do NOT include (What we don\'t handle)', '<p>&bull; If the vehicle, train or vessel does not depart or reach the destination on time. Our schedules are the ones we get from the operators; you have to discuss such issues with them.</p>\r\n\r\n<p>&bull; If the transport operator&rsquo;s employees are rude. Actions that are normal in one culture can be offensive in another. And anybody can have a bad night. Keep in mind that we are sitting in an office in Bangkok and do not know your driver (just as your travel office does not know the pilot of the flight you booked).</p>\r\n\r\n<p>&bull; If the operator&rsquo;s seats or vehicles are not up to your expectations.</p>\r\n\r\n<p>&bull; If the operator cancels your trip due to force majeure or unavoidable reasons. If there is a storm, your ferry might not depart. And this is for your safety, so you should be glad about it.</p>\r\n\r\n<p>&bull; If your baggage gets damaged or vanishes into thin air. Keep an eye on your valuables.</p>\r\n\r\n<p>&bull; If the operator has to change your seat to accommodate a monk or handicapped person. This rarely occurs, but there is nothing we can do about it.</p>\r\n\r\n<p>&bull; If you went to the wrong boarding point. Please look at the map we provide on every ticket to find out the exact location of your boarding point.</p>\r\n\r\n<p>&bull; If the operator changes the boarding point and/or changes the vehicle or sends a pick-up vehicle to the boarding point to bring you to the departure point.</p>\r\n\r\n<p>&bull; If you fail to provide contact details or not follow our instructions</p>'),
(4, 'In other words: we waive responsibilities in the following cases', '<p>&bull; you gave us wrong email address. Check it twice (PLEASE)! In this case we try to contact you by text/SMS via the phone number you have given us. Email is very important - that is the main channel you get your confirmations, notifications etc.</p>\r\n\r\n<p>&bull; you gave us wrong phone number or your phone is offline when needed. In emergencies (departure delayed/bad weather: ferry won\'t go, change of departing point, etc) - we will try to contact you via the phone you have provided. If you are in roaming, it is required to have your roaming number working an hour or two before boarding/departure/check-in. We\'ll sent you text/SMS and if that won\'t work, we call - to save your costs.</p>\r\n\r\n<p>&bull; you failed to follow instructions given in the email/PDF: came right at departure time and the bus is gone, went to a station advised by locals instead of following our directions, did not call us in case of uncertainity, etc.</p>\r\n\r\n<p>&bull; your connecting flight/bus/friend is right after your esimated departure, but the bus/train/donkey was late - please do reserve significant time for connections;</p>\r\n\r\n<p>&bull; operator performed not as you have expected: aircon did not work, a cockroach crossed the way, bus took longer than expected, onboard snack was poor, or other serious disasters - please complain to the operator, not to us. We are engineers building travel IT system - we do not run buses, trains neither we fly, train elephants or make your bed in a hostel. The stewardesses at the bus were hired not by us but by operating company - hence may not speak enough English.</p>\r\n\r\n<p>&bull; you have missed the cancellation deadline because of any factors that were not our fault</p>\r\n\r\n<p>&bull; you have missed the departure due to any factors we had no infuence on</p>\r\n\r\n<p>&bull; some other cases, explained in this document - we als strongly advise to read FAQ (and Trains In Thailand FAQ)</p>\r\n\r\n<p>We play fair and if we made a mistake - we refund and try to fix the case by all possible means (yes, everyone in the world make mistakes; if you do not, we have a position open for you!).</p>\r\n\r\n<p>The given departure times on your ticket are the times we got from the operators. It is your responsibility to arrive at the departure point early enough. Normally you have to exchange your voucher for a boarding pass at the operator&rsquo;s booth, depending on the operator. There may be many operators departing from your boarding and/or departure points, so it might take a while to find the right one. Your transport will not leave the departure point before the time given on the ticket.</p>\r\n\r\n<p>The arrival time is given by the operators or in some cases calculated when there is no data available. Keep in mind that there are several reasons why your journey might be delayed. If there is a transit time between stations, be careful. This time is calculated automatically and does not include the extra time you will spend in a taxi in heavy traffic during rush hour. Make sure you are early enough in case things do not go as smoothly as you would expect. And calculate at least 5 hours between your scheduled arrival and the departure of a connecting flight!</p>'),
(5, 'Your duties', '<p>You might have to exchange your voucher for a ticket at the operator&rsquo;s booth, depending on the operator. (Yes, you just read this before. This is not d&eacute;j&agrave; vu. But it is important enough to repeat.) There may be many operators departing from your origin, so it might take a while to find the right one. Please make sure you will arrive in time to exchange your voucher at the operator&rsquo;s booth or office for those operators that do require this.</p>\r\n\r\n<p>Most probably you will have to prove your identity (so please carry and show your ID card, driver&rsquo;s license, student ID card, company ID card, passport, etc.). Operators will usually accept anything with your name and picture on it. Failure to prove your identity may end up in boarding being denied.</p>\r\n\r\n<p>Important! If you have a connecting flight after your trip booked with us, please allow 5 hours between the arrival of your bus/ferry and the flight departure!</p>\r\n\r\n<p>Change of vehicles: The operator may have to change the vehicle or vehicle class because of some important reason; in such a case, I1Booking will refund the difference in fares to you if you contact us within 24 hours of your arrival with the exact details of what happened and why. Pictures always help explain the problem and will make the process easier. (BTW: Please send us your best picture from your trip &ndash; you might win a prize!)</p>\r\n\r\n<p>If you have complained on the operator services, please talk to them directly right after your trip at the station. We are IT system to collect fare payments, which are almost instantly going to the operator once you paid. We cannot re-fund in these cases simply because your money are not with us.</p>'),
(6, 'Cancellation Policy', '<p>If you managed to read all the text above, you are really tough. If you just jumped here, there might be a problem. Dang &ndash; such things happen. Now let\'s try to make the best of it. Please keep in mind that our support staff is there to help you. They are not the ones who caused your problem; they are your friends. Being rude to them does not help you.</p>\r\n\r\n<p>Do-it-yourself-cancellation</p>\r\n\r\n<p>To make it easier for you and to avoid long discussions, you now have the option to cancel your tickets yourself. Please click the &ldquo;Contact us&rdquo; button on the top of the page. Read the whole page to see if you find information useful for your case. When you reach the bottom of the page, enter your booking number and email. You will see the available options. If there are no options, the operator does not allow cancellation or you are simply too late.</p>\r\n\r\n<p>If you are worried about not being able to travel on the day, please ask our support about the specific cancellation details for your operator before you book with us!</p>\r\n\r\n<p>Some of the tickets booked through I1Booking can be cancelled. Some tickets cannot be cancelled. Don\'t expect that your ticket can be refunded! Please note that the cancellation process, the fee and cancellation period differ from one operator to another. And we are connected to over 140 different operators. In general, you have to inform us at least 72 hours before your departure. Anything later than that will almost certainly be too late. You should contact our customer service team immediately and provide complete details, including a solid reason why you have to change your booking. In some cases (depending on the operator / payment gateway used) the money might not be transferred back to your account, but it will be refunded to your internal I1Booking account and can be used for your next booking. Most of the operators allow cancellations made 72 hours prior to departure. Some charge a fee of 80 baht per seat changed paid via 7-Eleven counter service, and some charge a percentage of the total price. Our customer service will tell you which one applies in your case. Changes requested less than 72 hours before departure might not be possible at all.</p>\r\n\r\n<p>Payments with PayPal can be easily refunded immediately. Refunds for payments made with your credit card (Omise system) will take up to 20 working days. To refund payments made with counter service (7-Eleven) is very complicated, if possible at all. They require you to have a bank account in Thailand.</p>\r\n\r\n<p>Train tickets will be fully refunded if we cannot provide them. If you book a long time in advance and want to cancel your ticket before it was issued, the cancellation fee is 20%. Once the ticket is issued and you have received the final confirmation that the ticket is ready to be picked up at our offices, the cancellation fee is 50% of the ticket price. Once it is 72 hours or less to your departure time, we cannot refund your ticket. You still can pick it up, go to the counter and try to get 50% refunded there, but make sure you carry your passport with you.</p>\r\n\r\n<p>In case your booking confirmation gets delayed or fails because of technical reasons and e-mail and/or SMS cannot be delivered or because you provided an incorrect e-mail ID / phone number, a ticket will be considered &ldquo;booked&rdquo; as long as the ticket shows up in the i1booking.com database. In case your tickets vanished into thin air or got lost during the shipping process a passport copy is needed to make a police report about lost tickets. With a copy of this police report the passenger will be allowed to board the train. If the customer wants I1Booking to make the report for them a copy of the passport has to be provided.</p>'),
(7, 'Dispute cases', '<p><span style=\"font-family:source sans pro,helvetica neue,helvetica,arial,sans-serif; font-size:14px\">By using the I1Booking website and services you agree to contact the support to resolve any problem you might have before opening a dispute with the bank. If you fail to do so you agree to pay a US-$ 500 fine for any unreasonable dispute you initiate with the bank to incur operational costs of chargeback processing. At I1Booking our support will do everything possible to help customers to solve problems that might occur during the booking process or until they have their tickets in hand.</span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tour_guide`
--

CREATE TABLE `tbl_tour_guide` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `guide_language` varchar(255) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tour_guide`
--

INSERT INTO `tbl_tour_guide` (`id`, `tour_id`, `guide_language`, `price`) VALUES
(8, 4, 'English Speaking $35 in Siem reap', '35'),
(9, 4, 'Thai Speaking $40 in Siem reap', '40'),
(10, 5, 'English Speaking $35 in Siem reap', '35'),
(11, 5, 'Thai Speaking $40 in Siem reap', '40'),
(12, 10, 'English', '0'),
(13, 10, 'Thai', '0'),
(14, 16, 'English', '50'),
(15, 16, 'Thai', '50'),
(18, 6, 'English Speaking $35 in Siem reap', '35'),
(19, 6, 'Thai Speaking $40 in Siem reap', '40'),
(20, 6, 'Mandarin Speaking', '65'),
(21, 6, 'French Speaking', '45'),
(22, 6, 'Japanese Speaking', '50'),
(23, 6, 'German Speaking', '65');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tour_package`
--

CREATE TABLE `tbl_tour_package` (
  `id` int(8) NOT NULL,
  `site_keyword` text NOT NULL,
  `site_description` text NOT NULL,
  `title` varchar(250) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `short_desc` varchar(500) DEFAULT NULL,
  `tour_destination` text,
  `rate_and_services` text,
  `terms_and_conditions` text,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tour_package`
--

INSERT INTO `tbl_tour_package` (`id`, `site_keyword`, `site_description`, `title`, `image`, `short_desc`, `tour_destination`, `rate_and_services`, `terms_and_conditions`, `last_update`) VALUES
(1, 'angkor, 1 day tour, siem reap, cambodia, temple', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'Share Tours to Angkor Wat $6/Pax', 'Small tour.jpg', 'We would to say many thanks for used our service.\r\nwww.i1booking.com\r\n+85570999666\r\nEmail: i1bookbus@gmail.com\r\nEmail. info@i1booking.com', '<div>\r\n<p><strong>One Day Small Tour</strong></p>\r\n\r\n<p>You can start 4:45AM Sun rise Or 8:30&nbsp;AM (or let\'s know your preferable starting time) We&nbsp;will pick you up from the hotel 45minutes before and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><em><strong>Angkor Wat</strong></em>&nbsp;(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><em><strong>Ta Prohm</strong></em>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li><em><strong>Banteay Kdei</strong></em>&nbsp;(In 2002 the Japanese Archeologists rediscovered 274 Buddhas in the pit)</li>\r\n	<li><em><strong>Lunch break (in restaurant inside the Angkor Archeological Park)</strong></em></li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><em><strong>Bayon</strong></em>&nbsp;(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><em><strong>Baphuon</strong></em>&nbsp;(the tallest pyramidal temple closed 27 years for restoration by French)</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\nRead more about Angkor Temples Small-Group Tour - Siem Reap Asia I1Booking at: www.i1booking.com</div>\r\n\r\n<table class=\"table table-hover table-striped\" style=\"white-space:nowrap; width:100%\">\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Q.ty</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Inclouded</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry <strong>One Day Small Tour</strong></td>\r\n			<td>1-4pax</td>\r\n			<td>$ 8</td>\r\n			<td>&nbsp;English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp; Van <strong>One Day Small Tour</strong></td>\r\n			<td>5-10Pax</td>\r\n			<td>$7</td>\r\n			<td>English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus RX300 <strong>One Day Small Tour</strong></td>\r\n			<td>1-4Pax</td>\r\n			<td>$ 9</td>\r\n			<td>&nbsp; English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk <strong>One Day Small Tour</strong></td>\r\n			<td>1-3Pax</td>\r\n			<td>$ 5</td>\r\n			<td>&nbsp;English Speaking Driver</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Please do not hesitate to contact&nbsp; us:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( if you interested in this tours )</p>', '<table class=\"table table-hover table-striped\" style=\"white-space:nowrap; width:100%\">\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Q.ty</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Inclouded</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry <strong>One Day Small Tour</strong></td>\r\n			<td>1-4pax</td>\r\n			<td>$ 8</td>\r\n			<td>&nbsp;English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp; Van <strong>One Day Small Tour</strong></td>\r\n			<td>5-10Pax</td>\r\n			<td>$7</td>\r\n			<td>English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus RX300 <strong>One Day Small Tour</strong></td>\r\n			<td>1-4Pax</td>\r\n			<td>$ 9</td>\r\n			<td>&nbsp; English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk <strong>One Day Small Tour</strong></td>\r\n			<td>1-3Pax</td>\r\n			<td>$ 5</td>\r\n			<td>&nbsp;English Speaking Driver</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-12 06:39:22'),
(2, 'siem reap, angkor wat, 2nd day, tour', 'Days Angkor temples national park and to go and visiting floating village, paddle there, floating forest, paddle to jungle, how people live, see school and so on, more than a half day, in the afternoon buy Angkor 3 days Ankor pass and without use any days look at sunset- maybe at Phnom Bakhong and then back to our hotel.', 'Share 1days Small tour/Big tour $7/Pax', 'banteay_srey_temple.jpg', 'Let get your unique experience in your life with this few days trip around Angkor Temples and another spectacular place in Siem Reap.', '<p><strong>Share Small Tour + Big Tour</strong></p>\r\n\r\n<p>You can start 4:45AM Sun rise Or 8:30&nbsp;AM (or let\'s know your preferable starting time) my tour guide will pick you up from the hotel and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><strong>Angkor Wat</strong>&nbsp;(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><strong>Ta Prohm</strong>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li><strong>Ta Nei&nbsp;</strong>(located offroad, deeply, quietly and peacefully in jungle)</li>\r\n	<li><strong>Ta Keo</strong></li>\r\n	<li><strong>Banteay Kdei</strong>&nbsp;(In 2002 the Japanese Archeologists rediscovered 274 Buddhas in the pit)</li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><strong>Bayon&nbsp;</strong>(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><strong>Baphuon</strong>&nbsp;(the tallest pyramidal temple closed 27 years for restoration by French)</li>\r\n</ul>\r\n\r\n<p>&nbsp; &nbsp;&nbsp;</p>\r\n\r\n<ul>\r\n	<li><strong>Preah Khan</strong>&nbsp;(the Buddhist King\'s Father temple, restored by WMF project)</li>\r\n	<li><strong>Neak Poan</strong>&nbsp;(located inside artificial lake Jayatataka)</li>\r\n	<li><strong>Ta Som</strong></li>\r\n	<li><strong>East Mebon</strong>&nbsp;(located in the manmade lake called East Baray 7km x 1.8km)</li>\r\n	<li><strong>Pre Rup</strong>&nbsp;(crematorium) it is called crematorium because during 16 century because the local people who lived here cremated the dead body in this temple but actually this dried&nbsp; brick temple was built in the mid 10 century and dedicated to Shiva one of the trinity in Hindu.</li>\r\n</ul>\r\n\r\n<p><strong>Price Included:</strong><br />\r\n- Welcome Drinks and cool towel during the Trip<br />\r\n- All taxed included<br />\r\n- Complementary pickup service from airport to Hotel<br />\r\n- Transportation During and around Town</p>\r\n\r\n<p><strong>Price Excluding:</strong><br />\r\n- Entrance fees on the archaeological site<br />\r\n- Lunch at local restaurant<br />\r\n- Driver&rsquo;s Tips<br />\r\n- Boat Ticket at Floating Village<br />\r\n- Professional Guide not Include<br />\r\n<strong>Note:</strong>&nbsp;If you need to Apsara Traditional Khmer Dancing<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Show+Buffer Dinner cost US$12/person</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;-</p>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports&nbsp;</th>\r\n			<th scope=\"col\">number of Pax</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry Share 1days Small tour/Big tour $7/Pax</td>\r\n			<td>1-4Pax</td>\r\n			<td>$ 7</td>\r\n			<td>&nbsp;English Speaking Driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Van Share 1days Small tour/Big tour $7/Pax</td>\r\n			<td>5-10Pax</td>\r\n			<td>$ 6</td>\r\n			<td>&nbsp;English Speaking Driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus RX300 Share 1days Small tour/Big tour $7/Pax</td>\r\n			<td>1-4Pax</td>\r\n			<td>$ 10</td>\r\n			<td>&nbsp;English Speaking Driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk Share 1days Small tour/Big tour $7/Pax</td>\r\n			<td>1-3Pax</td>\r\n			<td>$ 7</td>\r\n			<td>&nbsp;English Speaking Driver&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', NULL, '2017-07-10 15:26:55'),
(3, 'three, days, tour, siem reap, cambodia, temple, ancient', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'Share 1Days Small Tour + Banteay Srei+ Kbal Spean $15/Pax', 'angkor_complex_cambodia_975021.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<p><strong>Days small tour + Banteay Srei+ Kbal Spean $15/Pax</strong></p>\r\n\r\n<p>You can start 4:45AM Sun rise Or 8:30&nbsp;AM (or let\'s know your preferable starting time) We&nbsp;will pick you up from the hotel 45minutes before and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><strong>Angkor Wat&nbsp;</strong>(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><strong>Ta Prohm</strong>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><strong>Bayon</strong>&nbsp;(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><strong>Preah Khan</strong>&nbsp;(the Buddhist King\'s Father temple, restored by WMF project)</li>\r\n	<li><strong>Kbal Spean&nbsp;</strong>(To visit the carving s of 1000 lingas along the riverbed)</li>\r\n	<li><strong>Banteay Srei&nbsp;</strong>called Lady Temple (38 km form Siem Reap, the most beautiful, intricate and pinkish sandstone carvings of Khmer Art and it was restored by French through the technique of Anastylosis from 1931 to 1936)<br />\r\n	Roluos Group (this site is the earliest temples during the Angkorian era which was founded by The king Jayavarman II, the Angkor-founder and originally called HARIHARALAYA)<br />\r\n	<strong>Price Included:</strong><br />\r\n	- Welcome Drinks and cool towel during the Trip<br />\r\n	- All taxed included<br />\r\n	- Complementary pickup service from airport to Hotel<br />\r\n	- Transportation During and around Town</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Price Excluding:</strong><br />\r\n	- Entrance fees on the archaeological site<br />\r\n	- Lunch at local restaurant<br />\r\n	- Driver&rsquo;s Tips<br />\r\n	- Boat Ticket at Floating Village<br />\r\n	- Professional Guide not Include<br />\r\n	<strong>Note:</strong>&nbsp;If you need to Apsara Traditional Khmer Dancing<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Show+Buffer Dinner cost US$12/person</p>\r\n	</li>\r\n</ul>', '<p><br />\r\n&nbsp;</p>\r\n\r\n<table class=\"table table-hover table-striped\" style=\"height:133px; width:772px\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports With Tour Guide/3days</th>\r\n			<th scope=\"col\">Q.Ty</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Inclouded</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Van&nbsp;</td>\r\n			<td>5-10 Pax</td>\r\n			<td>$ 15</td>\r\n			<td>English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus 300 + safety belts</td>\r\n			<td>1-4 Pax</td>\r\n			<td>$15</td>\r\n			<td>English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', NULL, '2017-07-11 05:54:42'),
(4, 'Relax with Fresh Nature siem reap, cambodia, temple,', 'we would like to say many thanks for used our sevice.\r\nwww.i1booking.com\r\n+85570999666\r\nEmail.i1bookbus@gmail.com\r\nEmail.info@i1booking.com', 'One Day Small Tour $15 (OPTION2)', 'kulen_waterfall.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<p><strong>One Day Small Tour</strong></p>\r\n\r\n<p>Your can start 4:45AM or 8:30 AM (or let\'s know your preferable starting time) We will pick you up from the hotel 40 minutes before and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><em><strong>Angkor Wat</strong></em>&nbsp;(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><em><strong>Ta Prohm</strong></em>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li><em><strong>Banteay Kdei</strong></em>&nbsp;(In 2002 the Japanese Archeologists rediscovered 274 Buddhas in the pit)</li>\r\n	<li><em><strong>Lunch break (in restaurant inside the Angkor Archeological Park)</strong></em></li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><em><strong>Bayon</strong></em>&nbsp;(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><em><strong>Baphuon</strong></em>&nbsp;(the tallest pyramidal temple closed 27 years for restoration by French)</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>\r\n	<p><strong>Price Included:</strong><br />\r\n	- Welcome Drinks and cool towel during the Trip<br />\r\n	- All taxed included<br />\r\n	- Complementary pickup service from airport to Hotel<br />\r\n	- Transportation During and around Town</p>\r\n\r\n	<p><strong>Price Excluding:</strong><br />\r\n	- Entrance fees on the archaeological site<br />\r\n	- Lunch at local restaurant<br />\r\n	- Driver&rsquo;s Tips<br />\r\n	- Boat Ticket at Floating Village<br />\r\n	- Professional Guide not Include<br />\r\n	<strong>Note:</strong>&nbsp;If you need to Apsara Traditional Khmer Dancing<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Show+Buffer Dinner cost US$12/person</p>\r\n	</li>\r\n</ul>', '<p>&nbsp;</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\"><strong>One Day Small Tour</strong></th>\r\n			<th scope=\"col\">Q.Ty</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Inclouded</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Camry2002&nbsp;<strong>One Day Small Tour</strong></td>\r\n			<td>1-4 Pax</td>\r\n			<td>$35</td>\r\n			<td>English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Van&nbsp;<strong>One Day Small Tour</strong></td>\r\n			<td>5-10 Pax</td>\r\n			<td>$45</td>\r\n			<td>English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus RX300&nbsp;<strong>One Day Small Tour</strong></td>\r\n			<td>1-4 Pax</td>\r\n			<td>$40</td>\r\n			<td>English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-11 05:55:03'),
(5, 'five days, tours, siem reap, temple, resort, famous, cambodia', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'One Day Small Tour + Big Tour $20( option1)', 'Beng mealea.jpg', 'With your 5 days tour trip, you will find out all the amazing and wonderful places in Siem Reap, Cambdia.', '<p><strong>1day Small Tour + Big Tour</strong></p>\r\n\r\n<p>You can start 4:45AM Sun rise Or 8:30&nbsp;AM (or let\'s know your preferable starting time) my tour guide will pick you up from the hotel and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><strong>Angkor Wat</strong>&nbsp;(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><strong>Ta Prohm</strong>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li><strong>Ta Nei&nbsp;</strong>(located offroad, deeply, quietly and peacefully in jungle)</li>\r\n	<li><strong>Ta Keo</strong></li>\r\n	<li><strong>Banteay Kdei</strong>&nbsp;(In 2002 the Japanese Archeologists rediscovered 274 Buddhas in the pit)</li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><strong>Bayon&nbsp;</strong>(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><strong>Baphuon</strong>&nbsp;(the tallest pyramidal temple closed 27 years for restoration by French)</li>\r\n</ul>\r\n\r\n<p>&nbsp; &nbsp;&nbsp;</p>\r\n\r\n<ul>\r\n	<li><strong>Preah Khan</strong>&nbsp;(the Buddhist King\'s Father temple, restored by WMF project)</li>\r\n	<li><strong>Neak Poan</strong>&nbsp;(located inside artificial lake Jayatataka)</li>\r\n	<li><strong>Ta Som</strong></li>\r\n	<li><strong>East Mebon</strong>&nbsp;(located in the manmade lake called East Baray 7km x 1.8km)</li>\r\n	<li><strong>Pre Rup</strong>&nbsp;(crematorium) it is called crematorium because during 16 century because the local people who lived here cremated the dead body in this temple but actually this dried&nbsp; brick temple was built in the mid 10 century and dedicated to Shiva one of the trinity in Hindu.</li>\r\n</ul>\r\n\r\n<p><strong>Price Included:</strong><br />\r\n- Welcome Drinks and cool towel during the Trip<br />\r\n- All taxed included<br />\r\n- Complementary pickup service from airport to Hotel<br />\r\n- Transportation During and around Town</p>\r\n\r\n<p><strong>Price Excluding:</strong><br />\r\n- Entrance fees on the archaeological site<br />\r\n- Lunch at local restaurant<br />\r\n- Driver&rsquo;s Tips<br />\r\n- Boat Ticket at Floating Village<br />\r\n- Professional Guide not Include<br />\r\n<strong>Note:</strong>&nbsp;If you need to Apsara Traditional Khmer Dancing<br />\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Show+Buffer Dinner cost US$12/person</p>\r\n\r\n<p style=\"text-align:justify\">&nbsp;</p>', '<table class=\"table table-hover table-striped\" style=\"height:160px; width:672px\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">One Day Small Tour</th>\r\n			<th scope=\"col\">Q.ty</th>\r\n			<th scope=\"col\">Price</th>\r\n			<th scope=\"col\">Inclouded</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 2002<strong>1day Small Tour + Big Tour</strong></td>\r\n			<td>1-4 Pax</td>\r\n			<td>40</td>\r\n			<td>&nbsp;English Speaking Driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Van <strong>1day Small Tour + Big Tour</strong></td>\r\n			<td>5-10 Pax</td>\r\n			<td>$ 50</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking Driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp; Lexus Rx300 <strong>1day Small Tour + Big Tour</strong></td>\r\n			<td>1-4 Pax</td>\r\n			<td>$45</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking Driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk&nbsp;<strong>1day Small Tour + Big Tour</strong></td>\r\n			<td>1-3 Pax</td>\r\n			<td>$20</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>English Speaking Driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', NULL, '2017-07-11 05:46:40'),
(6, 'cambodian, cultural, village, $10, siem reap, tour', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'One Day Angkor wat+Taprohm+Bayon+Bonteay srei+Kbal Spean $35', 'banner2.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<p><strong>One Day Small Tour $15(OPTION3)</strong></p>\r\n\r\n<p>You can &nbsp;4:45 AM or 8:30am (or let\'s know your preferable starting time) We will pick you up from the hotel 40 minutes before and take you to buy the temple pass and then the tour continues.</p>\r\n\r\n<ul>\r\n	<li><em><strong>Angkor Wat</strong></em>&nbsp;(the largest religious monument in the world, only 35 years to be built)</li>\r\n	<li><em><strong>Ta Prohm</strong></em>&nbsp;(the temple in the Tomb Raider movie)</li>\r\n	<li><em><strong>Lunch break (in restaurant inside the Angkor Archeological Park)</strong></em></li>\r\n	<li>South Gate of Angkor Thom (the big walled city to be built by Buddhist King Jayavarman VII)</li>\r\n	<li><em><strong>Bayon</strong></em>&nbsp;(the state temple and temple mountain of Buddhist King, exactly at the middle of Angkor Thom)</li>\r\n	<li><strong>Kbal Spean</strong>&nbsp;(To visit the carving s of 1000 lingas along the riverbed)</li>\r\n	<li><strong>Banteay Srei</strong>&nbsp;called Lady Temple (38 km form Siem Reap, the most beautiful, intricate and pinkish sandstone carvings of Khmer Art and it was restored by French through the technique of Anastylosis from 1931 to 1936)</li>\r\n	<li>\r\n	<p><strong>Price Included:</strong><br />\r\n	- Welcome Drinks and cool towel during the Trip<br />\r\n	- All taxed included<br />\r\n	- Complementary pickup service from airport to Hotel<br />\r\n	- Transportation During and around Town</p>\r\n\r\n	<p><strong>Price Excluding:</strong><br />\r\n	- Entrance fees on the archaeological site<br />\r\n	- Lunch at local restaurant<br />\r\n	- Driver&rsquo;s Tips<br />\r\n	- Boat Ticket at Floating Village<br />\r\n	- Professional Guide not Include<br />\r\n	<strong>Note:</strong>&nbsp;If you need to Apsara Traditional Khmer Dancing<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Show+Buffer Dinner cost US$12/person</p>\r\n	</li>\r\n</ul>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Q.ty</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry <strong>One Day Small Tour</strong></td>\r\n			<td>1-4Pax</td>\r\n			<td>$ 55</td>\r\n			<td>&nbsp;English Speaking driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Van <strong>One Day Small Tour</strong></td>\r\n			<td>5-10Pax</td>\r\n			<td>$80</td>\r\n			<td>&nbsp;English Speaking driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Lexus 300 <strong>One Day Small Tour</strong></td>\r\n			<td>1-4Pax</td>\r\n			<td>$70</td>\r\n			<td>&nbsp;English Speaking driver&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk <strong>One Day Small Tour</strong></td>\r\n			<td>1-4Pax</td>\r\n			<td>$35</td>\r\n			<td>&nbsp;English Speaking driver&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-11 06:00:51'),
(7, 'helicopter, scenic flight, $90, siem reap, tour, cambodia', 'Enjoy the view from the sky with your professional pilot. It is the great experience that you should not missed.', 'Helicopter Scenic Flight ( Start From US$90)', 'helistar-cambodia-helicopter.jpg', 'Enjoy the view from the sky with your professional pilot. It is the great experience that you should not missed.', '<p><strong>- 09 MINUTES ( $90 )</strong></p>\r\n\r\n<p><strong>- 14 MINUTES ( $135 )</strong></p>\r\n\r\n<p><strong>- 20 MINUTES ( $190 )</strong></p>\r\n\r\n<p><strong>- 30 MINUTES ( $280 )</strong></p>\r\n\r\n<p><strong>- 36 MINUTES ( $330 )</strong></p>\r\n\r\n<p><strong>- 48 MINUTES ( $430 )</strong></p>\r\n\r\n<p>This complate package covers all the must see locations making it the total flight,</p>', '<table class=\"table table-hover table-striped\" style=\"height:180px; width:581px\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Duration / Hrs</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 4 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 10</td>\r\n			<td>&nbsp;English Speaking</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Mini Van Mesedez ben&nbsp; 12-15 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$15</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota VIP Mini Lexus 300 + safety belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 10</td>\r\n			<td>&nbsp;\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk 4 Seats</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 5</td>\r\n			<td>&nbsp;\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2016-04-07 21:25:29'),
(8, 'smile, angkor, show, dinner, evening, $30, dance, apsara, siem reap, cambodia', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'Smile Of Angkor Show ( Start From US$30)', 'smile-of-angkor-show.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<p><span style=\"font-size:16px\"><strong>Show Contens List&nbsp;</strong></span></p>\r\n\r\n<ul>\r\n	<li>Perface Ask God&nbsp;</li>\r\n	<li>Chapter One Glorious Kingdom&nbsp;</li>\r\n	<li>Chapter Two Resurrection of Gods&nbsp;</li>\r\n	<li>Chapter Three Churning the occean of Milk&nbsp;</li>\r\n	<li>Chapter Four Prayer of Life</li>\r\n	<li>Ending Smile of Angkor&nbsp;</li>\r\n</ul>\r\n\r\n<p><strong>Ticket:</strong></p>\r\n\r\n<ul>\r\n	<li>Seat A: USD 30</li>\r\n	<li>Seat B: USD 25</li>\r\n</ul>\r\n\r\n<p><strong>(Show Time: 1915-2025 )</strong></p>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Duration / Hrs</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 4 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 7</td>\r\n			<td>&nbsp;English Speaking driver</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Mini Van Mesedez ben&nbsp; 12-15 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 10</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota VIP Mini Lexus 300 + safety belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 15</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk 4 Seats</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 5</td>\r\n			<td>\r\n			<table class=\"table table-hover table-striped\">\r\n				<tbody>\r\n					<tr>\r\n						<td>&nbsp;English Speaking driver</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-11 05:55:54'),
(9, 'quad, bike, adventure, $30, siem reap, cambodia, riding', 'I We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'Quad Bike Adventure ( Start from US$30)', 'quadbikesiemreap.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" style=\"line-height:21px; width:627px\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"height:38px; width:228px\">\r\n			<p>1 HOUR DRIVING</p>\r\n			</td>\r\n			<td style=\"height:38px; width:183px\">\r\n			<p>7:30AM TO 05:00PM</p>\r\n			</td>\r\n			<td style=\"height:38px; width:108px\">\r\n			<p>30 USD</p>\r\n			</td>\r\n			<td style=\"height:38px; width:103px\">\r\n			<p>40USD</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:26px; width:228px\">\r\n			<p>2HOURS DRIVING</p>\r\n			</td>\r\n			<td style=\"height:26px; width:183px\">\r\n			<p>07:30AM TO 05:00PM</p>\r\n			</td>\r\n			<td style=\"height:26px; width:108px\">\r\n			<p>60 USD</p>\r\n			</td>\r\n			<td style=\"height:26px; width:103px\">\r\n			<p>75 USD</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:26px; width:228px\">\r\n			<p>3HOURS DRIVING</p>\r\n			</td>\r\n			<td style=\"height:26px; width:183px\">\r\n			<p>07:30AM TO 05:00PM</p>\r\n			</td>\r\n			<td style=\"height:26px; width:108px\">\r\n			<p>75 USD</p>\r\n			</td>\r\n			<td style=\"height:26px; width:103px\">\r\n			<p>95 USD</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:25px; width:228px\">\r\n			<p>4HOURS DRIVING</p>\r\n			</td>\r\n			<td style=\"height:25px; width:183px\">\r\n			<p>07:30AM TO 05:00PM</p>\r\n			</td>\r\n			<td style=\"height:25px; width:108px\">\r\n			<p>100 USD</p>\r\n			</td>\r\n			<td style=\"height:25px; width:103px\">\r\n			<p>120 USD</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"height:50px; width:228px\">\r\n			<p>5HOURS DRIVING</p>\r\n			</td>\r\n			<td style=\"height:50px; width:183px\">\r\n			<p>07:30AM TO 05:00PM</p>\r\n			</td>\r\n			<td style=\"height:50px; width:108px\">\r\n			<p>120 USD</p>\r\n			</td>\r\n			<td style=\"height:50px; width:103px\">\r\n			<p>140 USD</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<h3>&gt;&gt; Noted: Now Discount: 10%</h3>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Duration / Hrs</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 4 seats + safety Belts</td>\r\n			<td>full day -8-10</td>\r\n			<td>$ 30</td>\r\n			<td>&nbsp;English Speaking Tour&nbsp; guide&nbsp; +&nbsp;&nbsp; $&nbsp; 35 USD</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Mini Van Mesedez ben&nbsp; 12-15 seats + safety Belts</td>\r\n			<td>full day-8-10 HRs</td>\r\n			<td>$ 45</td>\r\n			<td>&nbsp; tour guide + $ 35 USD</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota VIP Mini Lexus 300 + safety belts</td>\r\n			<td>Full Day----</td>\r\n			<td>$ 40</td>\r\n			<td>&nbsp; Tour Guide + 35 USD</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk 4 Seats</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 15</td>\r\n			<td>&nbsp;tour guide + 35 USD</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-11 05:56:29'),
(10, 'bird, sanctuary, prek toal, $90, siem reap, cambodia, nature', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', 'Bird Sanctuary ( Prek Toal ) ( Only US$ 90)', '12695739.jpg', 'We would like to say thanks for used our service\r\nContact : +85570999666\r\nEmail    : i1booktour@gmail.com\r\nWeb      :i1booking.com', '<p>Prek Toal is one of three biospheres on Tonl&eacute; Sap lake, and this stunning bird sanctuary makes it the most worthwhile and straightforward of the three to visit. It is an ornithologist&rsquo;s fantasy, with a significant number of rare breeds gathered in one small area, including the huge lesser and greater adjutant storks, the milky stork and the spot-billed pelican. Even the uninitiated will be impressed, as these birds have a huge wingspan and build enormous nests.<br />\r\nVisitors during the dry season (December to April) will find the concentration of birds like something out of a Hitchcock film. It is also possible to visit from September, but the concentrations may be lower. As water starts to dry up elsewhere, the birds congregate here. Serious twitchers know that the best time to see birds is early morning or late afternoon and this means an early start or an overnight at Prek Toal&rsquo;s environment office, Siem Reap Shuttle Tour, offers trips to Prek Toal . The trips cost about US$100 per person for a group of five or more, with additional charges for smaller groups. Our Tour Agency also runs organised day trips to Prek Toal. The day trips cost US$95 per person with a minimum group of four.<br />\r\nTours include transport, entrance fees, local guides, lunch and water. Binoculars are available on request, Some proceeds from the tours go towards educating children and villagers about the importance of the birds and the unique flooded-forest environment, and the trip includes a visit to one of the local communities. Day trips include a hotel pick-up and Drop off.<br />\r\nSunscreen and head protection are essential, as it can get very hot in the dry season. The guides are equipped with booklets with the bird names in English, but they speak little English themselves,</p>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports</th>\r\n			<th scope=\"col\">Duration / Hrs</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 4 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 25</td>\r\n			<td>&nbsp;English Speaking Tour&nbsp; guide&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Mini Van Mesedez ben&nbsp; 12-15 seats + safety Belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 35</td>\r\n			<td>English Speaking Tour&nbsp; guide</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota VIP Mini Lexus 300 + safety belts</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 25</td>\r\n			<td>English Speaking Tour&nbsp; guide</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk 4 Seats</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 15</td>\r\n			<td>English Speaking Tour&nbsp; guide</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2017-07-11 05:57:00'),
(11, 'Kompong Phluk, Tour, Morning, Siem Reap, 18$, Resort', 'The recommndation from Dailly Booking for all tourists who are looking for a tour package to refresh your feeling with a visit of a nature village in Cambodia.', 'Kompong Phluk Morning Tour 0830am-1330pm ( $18 Per Person)', 'KompongPhluk-.jpg', 'The recommndation from Dailly Booking for all tourists who are looking for a tour package to refresh your feeling with a visit of a nature village in Cambodia.', '<p><strong><span style=\"font-size:16px\">TOUR ITINERARY ( half day tour from 0830am-1330pm )</span></strong></p>\r\n\r\n<p><strong>08.30 hrs. Pick up from the Hotel in SIEM REAP for Kampong Phluk.</strong></p>\r\n\r\n<ul>\r\n	<li>&nbsp;Visit Artisan D\'angkor&nbsp;</li>\r\n	<li>&nbsp;Visit Kampong Phluk</li>\r\n</ul>\r\n\r\n<p><strong>Service Include</strong></p>\r\n\r\n<ul>\r\n	<li>Boat Ticket&nbsp;</li>\r\n	<li>Pick up / Drop Off Hotel</li>\r\n	<li>Van / Mini Bus&nbsp;</li>\r\n	<li>English Speaking Guide</li>\r\n	<li>Cold Drinking Water &amp; Cold Towel</li>\r\n</ul>\r\n\r\n<p><strong>Service Exclude</strong></p>\r\n\r\n<ul>\r\n	<li>Small boat &nbsp;</li>\r\n</ul>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '2016-02-16 02:08:01'),
(12, 'Kompon Phluk, Afternoon, Tour, $18, Siem Reap, Angkor Wat, Cambodia', 'A nature view in the afternoon from Kompong Phluk, one of Siem Reap Resort which you can enjoy visiting a view from a village that is very amazing.', 'Kompong Phluk Afternoon Tour 1400-1830pm ( $18 Per Person)', 'edOEg6S61k2v0a4TTQCPgw.jpg', 'A nature view in the afternoon from Kompong Phluk, one of Siem Reap Resort which you can enjoy visiting a view from a village that is very amazing.', '<p><span style=\"font-size:16px\"><strong>TOUR ITINERARY ( half day tour )&nbsp;</strong></span><br />\r\n<strong>13.30 hrs. Pick up from the Hotel in SIEM REAP for Floating Village Tour.</strong></p>\r\n\r\n<ul>\r\n	<li>&nbsp;Visit Artisan D\'angkor &nbsp;</li>\r\n	<li>&nbsp;Visit Kampong Phluk&nbsp;<br />\r\n	&nbsp;</li>\r\n</ul>\r\n\r\n<p><strong>Service Include</strong></p>\r\n\r\n<ul>\r\n	<li>Boat Ticket&nbsp;</li>\r\n	<li>Pick up / Drop Off Hotel&nbsp;</li>\r\n	<li>Van / Mini Bus&nbsp;</li>\r\n	<li>English Speaking Guide</li>\r\n	<li>Cold Drinking Water and Cold Towel</li>\r\n</ul>\r\n\r\n<p><strong>Service Exclude&nbsp;</strong></p>\r\n\r\n<ul>\r\n	<li>Small boat&nbsp;</li>\r\n</ul>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '2016-02-16 02:08:16'),
(13, 'apsara, dinner, show, siem reap, $12, angkor, cambodia', 'Enjoy your dinner with the magnificent view from Apsara Dancing. One experience that everyone should have.', 'Apsara Dinner Show ( Only US$12 Per Person)', 'maxresdefault.jpg', 'Enjoy your dinner with the magnificent view from Apsara Dancing. One experience that everyone should have.', '<p><span style=\"font-size:16px\"><strong>OUR ITINENARY</strong></span></p>\r\n\r\n<p><strong>18.30 hrs. Pick up from the Hotel in SIEM REAP<br />\r\n19.00 hrs. Arrive Restaurant<br />\r\n19.30 hrs. Show Start with Buffet<br />\r\n20.30 hrs. Show Finish</strong><br />\r\n&nbsp;</p>\r\n\r\n<p><strong>Buffet Vegetarian Food</strong></p>\r\n\r\n<p>01. &nbsp; &nbsp;Grilled Egg Plan<br />\r\n02. &nbsp; &nbsp;Onion Ring &nbsp; &nbsp;<br />\r\n03. &nbsp; &nbsp;Garlic Bread<br />\r\n04. &nbsp; &nbsp;Salad Bar &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n05. &nbsp; &nbsp;Mixed Salad<br />\r\n06. &nbsp; &nbsp;Coconut Spice Cake<br />\r\n07. &nbsp; &nbsp;Vegetable Tempura<br />\r\n08. &nbsp; &nbsp;Vegetable On Stick</p>\r\n\r\n<p><strong>Khmer Food</strong></p>\r\n\r\n<p>01. &nbsp; &nbsp;Chicken and vermicelli salad<br />\r\n02. &nbsp; &nbsp;Fish braised<br />\r\n03. &nbsp; &nbsp;Fish Amok<br />\r\n04. &nbsp; &nbsp;Fried pork with ginger &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\r\n05. &nbsp; &nbsp;Mango salad with pork<br />\r\n06. &nbsp; &nbsp;Lab beef<br />\r\n07. &nbsp; &nbsp;Chicken curry soup<br />\r\n08. &nbsp; &nbsp;Fried chicken with seasame</p>\r\n\r\n<p><strong>Chiness Food&nbsp;</strong></p>\r\n\r\n<p>01. &nbsp; &nbsp;Fried beam curd with bean sprout<br />\r\n02. &nbsp; &nbsp;Steamed pork rib<br />\r\n03. &nbsp; &nbsp;Fried fish rid with sweet and sour sauce<br />\r\n04. &nbsp; &nbsp;Fried vegetable &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br />\r\n05. &nbsp; &nbsp;Fried rice<br />\r\n06. &nbsp; &nbsp;Choy sum with oyster sauce<br />\r\n07. &nbsp; &nbsp;Chicken soup with green cabbage</p>\r\n\r\n<p><strong>Western Food</strong></p>\r\n\r\n<p>01. &nbsp; &nbsp;Red chicken<br />\r\n02. &nbsp; &nbsp;Mixed salad<br />\r\n03. &nbsp; &nbsp;Beef Stew<br />\r\n04. &nbsp; &nbsp;Fried beef with leek<br />\r\n05. &nbsp; &nbsp;Fruit salad<br />\r\n06. &nbsp; &nbsp;Pumpkin cream soup<br />\r\n07. &nbsp; &nbsp;Canapi &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\r\n08. &nbsp; &nbsp;Grilled tomatoes<br />\r\n09. &nbsp; &nbsp;Chicken on stick<br />\r\n10. &nbsp; &nbsp;Vegetable on stick<br />\r\n11. &nbsp; &nbsp;Beef on stick<br />\r\n12. &nbsp; &nbsp;Fish on stick</p>\r\n\r\n<p><strong>Khmer Dessert and Fresh Fruit</strong></p>\r\n\r\n<p>01. &nbsp; &nbsp;Banana with milk coconut<br />\r\n0 2. &nbsp; &nbsp;sweet bean soup<br />\r\n0 3. &nbsp; &nbsp;Banchanerk cake<br />\r\n04. &nbsp; &nbsp;Grass Yelly<br />\r\n05. &nbsp; &nbsp;Fried banana with sugar &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br />\r\n06. &nbsp; &nbsp;Savice cake<br />\r\n07. &nbsp; &nbsp;Pineapple fruit<br />\r\n08. &nbsp; &nbsp;Orange fruit<br />\r\n0 9. &nbsp; &nbsp;Dragon fruit<br />\r\n10. &nbsp; &nbsp;Papaya fruit</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '2016-02-16 02:08:27'),
(14, 'phare, cambodia, circus, $15, tour, entertainment, siem reap', 'Enjoy the magnificent view from the Phare of Cambodia Circus. You all will be amazed with this entertainment.', 'Phare the Cambodia Circus ( Only US$15 Per Person)', 'phare7-925x465.jpg', 'Enjoy the magnificent view from the Phare of Cambodia Circus. You all will be amazed with this entertainment.', '<p><span style=\"font-size:16px\"><strong>Steeped in the culture and Cambodian popular beliefs, Eclipse is a tale about discrimination.</strong></span></p>\r\n\r\n<p><strong>&nbsp;Ticket price:</strong></p>\r\n\r\n<ul>\r\n	<li>$ 15.00 for adult</li>\r\n	<li>$ 8.00 for children (5 to 12 y)</li>\r\n	<li>Free for children less than 5 y</li>\r\n	<li>Performance starts at 08.00pm daily / &nbsp;Gates open at 7.00pm.</li>\r\n</ul>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio id beatae officia praesentium, excepturi, assumenda error dolorem officiis expedita quas, aliquid nostrum velit, sunt adipisci porro dicta earum alias est</p>', '2016-02-16 02:08:38'),
(15, 'angkor, national, museum, $15, cambodia, siem reap', 'A place to feel the history of Cambodia, and also to find out about Cambodian Culture.', 'Angkor National Museum ( Only US$11 Per Person)', 'far-east-vacation-angkor-national-museum.jpg', 'A place to feel the history of Cambodia, and also to find out about Cambodian Culture.', '<ul>\r\n	<li><strong>Ticket per person $15</strong></li>\r\n	<li><strong>Child &nbsp;per person &nbsp;$6&nbsp;</strong></li>\r\n	<li><strong>Audio Tour Guide $3&nbsp;</strong></li>\r\n</ul>', NULL, NULL, '2016-02-16 02:08:44'),
(16, 'Plan your perfect trip, Nice to see country side, Beng mealea temple,temple, amazing temple,Far away temple', 'Best plan to see far away temple', 'Beng Mealea and Kampong Kleang Full Day', 'Beng mealea(1).jpg', 'Enjoy your trip to see the amazing temple', '<p>Depart from your hotel go through the national road No.6 down to Phnom Penh city. Today we visit the most interesting of all the temples outside the main Angkor group and for many people the highlights of their time in Cambodia. A two hour drive from Siem Reap, first we take about 30 minutes stop at one of the local market, Dom Dek market to explore the local lifestyle, then go straight to visit to the jungle temple of Boeng Mealea. Boeng Mealea&rsquo;s layout and style closely mirror that of Angkor wat but here is it the rich, green jungle and the lichen covered stone that dominate. Boeng Mealea is the tangle of tree, towers and vines and has several moody subterranean passageways to explore. Ivy has snaked its way over the bodies of apasara dancers and richly-carved lintels lie strewn in the undergrowth. Fallen block work near the collapsed central tower forces the visitor to scramble over much of the site. We end out stay at this special site with a picnic lunch and then set out one hour journey to the world&rsquo;s second largest freshwater lake, magnificent &lsquo;Tonle Sap&rsquo;. Here, board your boat and head onto the lake, passing the village of Kampong Khlang and viewing daily life on the water. This village is a mix of high stilt houses, built above the highest water level, and floating houses. Cruise through the village and see the unique houses on stilts, and the daily life of the village. Our boat will meander slowly through village and grassland canals, allowing you to catch glimpses of flora and fauna and see a truly beautiful eco-system, before emerging onto the Tonle Sap lake itself. Return to your hotel approximately 6 pm. &nbsp;</p>', '<table class=\"table table-hover table-striped\">\r\n	<tbody>\r\n		<tr>\r\n			<th scope=\"col\">Transports With Tour Guide/3days</th>\r\n			<th scope=\"col\">Duration / Hrs</th>\r\n			<th scope=\"col\">Cost</th>\r\n			<th scope=\"col\">Plus + other extra</th>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota Camry 4 seats + safety Belts</td>\r\n			<td>full day</td>\r\n			<td>$ 132</td>\r\n			<td>With English Speaking tour guide</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Mini Van Mesedez ben&nbsp; 12-15 seats + safety Belts</td>\r\n			<td>full day</td>\r\n			<td>$ 172</td>\r\n			<td>With English Speaking tour guide</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Toyota VIP Mini Lexus 300 + safety belts</td>\r\n			<td>Full Day</td>\r\n			<td>$ 142</td>\r\n			<td>With English Speaking tour guide</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;Tuk Tuk 4 Seats</td>\r\n			<td>&nbsp;</td>\r\n			<td>$ 95</td>\r\n			<td>With English Speaking tour guide</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '2016-04-07 21:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tour_package_photo`
--

CREATE TABLE `tbl_tour_package_photo` (
  `id` int(8) NOT NULL,
  `tour_package_id` int(6) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tour_package_photo`
--

INSERT INTO `tbl_tour_package_photo` (`id`, `tour_package_id`, `image`, `description`, `last_update`) VALUES
(11, 11, 'cambodiajan10floatingvillageandforest.jpg', 'Floating Village', '2016-02-16 02:15:11'),
(12, 11, 'Kampong-Phluk-08481-900x450.jpg', 'Nature View', '2016-02-16 02:15:14'),
(13, 12, 'dsc_0571-copy.jpg', 'Evening View From Kompong Phluk', '2016-02-16 02:15:21'),
(14, 12, 'img_8214_mod.jpg', 'Fishing from Kompong Phluk', '2016-02-16 02:15:24'),
(16, 14, '24486-Phare-Ponleu-Selpak-0677.jpg', 'Phare Cambodia Circus', '2016-02-16 02:15:30'),
(17, 14, 'DSC_0246logo.jpg', 'View from Phare Circus', '2016-02-16 02:15:36'),
(18, 13, 'apsara-garden-dinner.jpg', 'View of Apsara Dancing', '2016-02-16 02:15:40'),
(19, 13, 'slide001.jpg', 'View of Apsara Dancing', '2016-02-16 02:15:44'),
(20, 15, 'angkor-national-museum-artefacts.jpg', 'Inside View of Angkor National Museum', '2016-02-16 02:15:47'),
(21, 15, 'Angkor-Thom.jpg', 'The Statue Sculpture in the Angkor National Museum', '2016-02-16 02:15:51'),
(22, 6, 'fsdfsdfsdf.jpg', 'Kbal Spean', '2016-01-15 02:09:10'),
(23, 7, 'Cambodia-Air.jpg', 'Flying Helicopter', '2016-02-13 01:55:45'),
(24, 7, 'Angor-Wat-from-a-helicopter-Siem-Reap-Cambodia-2013-12-01-10-42-24.jpg', 'Natural View from the Sky', '2016-02-13 01:56:41'),
(26, 8, 'maxresdefault (1).jpg', 'One View from the Show', '2016-02-13 02:11:42'),
(27, 8, 'maxresdefault.jpg', 'Another Great View', '2016-02-13 02:12:15'),
(29, 9, '1.jpg', 'Tourist enjoy the adventure', '2016-02-13 02:20:27'),
(30, 9, 'sunset(1).jpg', 'The Trip in the Evening', '2016-02-13 02:20:54'),
(31, 10, '6-Vulture-BIRDLIFE.jpg', 'Life of the Bird', '2016-02-13 02:42:23'),
(32, 10, 'sam-veasna-02.jpg', 'Natural Life', '2016-02-13 02:42:41'),
(33, 1, 'angkor .jpeg', 'Golden View from Angkor Wat in the Evening', '2017-07-12 05:55:27'),
(34, 1, 'angkor-wat-hd-wallpaper1.jpg', 'Nice Shot of Angkor Wat Temple', '2016-02-16 02:16:03'),
(35, 2, 'img_5616.jpg', 'View of the Gate of Angkor Temples', '2016-02-16 02:16:07'),
(36, 2, 'Preah-Khan-Temple-Snapsot.jpg', 'View of the Gate of Angkor Temples', '2016-02-16 02:16:10'),
(38, 3, 'FloatingVillageTourSiemReap.jpg', 'Floating Village', '2016-02-16 02:16:30'),
(39, 3, 'Banteay_Kdei,_Angkor,_Camboya,_2013-08-16,_DD_13.JPG', 'Banteay Kdei Temple', '2016-02-16 02:16:34'),
(40, 4, 'East-Mebon-Temple.jpg', 'Mebon Temple', '2016-02-16 02:16:37'),
(41, 4, 'phnom_kulen_waterfall.jpg', 'Kulen Mountain', '2016-02-16 02:16:40'),
(42, 5, 'KK-Prasart-Tom-edit.jpg', 'Koh Ker Temple', '2016-02-16 02:16:44'),
(43, 5, 'Beng Mealea (10).jpg', 'Beng Mealea Temple', '2016-02-16 02:16:46'),
(44, 1, 'South gat.jpeg', NULL, '2016-04-07 02:52:40'),
(45, 1, 'Taprom temple.jpg', NULL, '2016-04-07 02:53:24'),
(46, 1, 'angkor-thom-to-siem-reap.jpg', NULL, '2016-04-07 02:53:59'),
(47, 16, '8300be62380c9b1ea9f45026d7ecfe3f.jpg', NULL, '2016-04-07 22:06:31'),
(48, 16, 'kompong-khleang.jpg', NULL, '2016-04-07 22:07:15'),
(49, 16, 'kleang3.jpg', NULL, '2016-04-07 22:08:08'),
(50, 16, 'kompong-kleang281.jpg', NULL, '2016-04-07 22:09:22'),
(51, 16, 'kleang1.jpg', NULL, '2016-04-07 22:10:19'),
(52, 2, 'tonle-sap_08.jpg', NULL, '2016-04-07 22:38:09'),
(53, 2, 'ta keo1.JPG', NULL, '2016-04-07 22:40:02'),
(54, 2, 'Taprom temple(1).jpg', NULL, '2016-04-07 22:40:31'),
(55, 2, 'Baayon.jpg', NULL, '2016-04-07 22:41:07'),
(56, 2, 'bonteay kdei.jpg', NULL, '2016-04-07 22:41:34'),
(57, 2, 'preahkhan.jpg', NULL, '2016-04-07 22:42:27'),
(58, 2, '20081020113248_view--prasat_neak_pean.jpg', NULL, '2016-04-07 22:43:03'),
(59, 2, 'banteay_srey_temple.jpg', NULL, '2016-04-07 22:43:31'),
(60, 2, 'Banteay_Srei_(Sept_2009b).jpg', NULL, '2016-04-07 22:44:29'),
(61, 2, '07-Banteay-Srei-Original-00023.jpg', NULL, '2016-04-07 22:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user_name`, `password`, `avatar`, `email`, `phone`, `description`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', '12.jpg', 'seavichet@live.com', '+85570980998', 'Admin'),
(2, 'seavichet', '202cb962ac59075b964b07152d234b70', 'ACAD_2013_infot3.png', 'info@daily-booking.com', '+85517268000', 'Description');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle`
--

CREATE TABLE `tbl_vehicle` (
  `id` int(3) NOT NULL,
  `vehicle_id` int(5) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `max_people` decimal(3,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_vehicle`
--

INSERT INTO `tbl_vehicle` (`id`, `vehicle_id`, `vehicle_type`, `price`, `max_people`) VALUES
(1, 1, 'Share Car Camary2002 ( A/c with English speaking driver)', '7', '1'),
(2, 1, 'Share Van (A/C with English speaking driver)', '6', '1'),
(3, 1, 'Share Mini Bus', '6', '1'),
(4, 1, 'Share Tuk Tuk (English speaking driver)', '5', '1'),
(5, 1, 'Share tour to Angkor wat', '5', '1'),
(6, 3, 'Lexus RX300/Hight LanderShare 1days Small tour/Big tour $15/Pax', '15', '1'),
(7, 2, 'Toyota Camry Share 1days Small tour/Big tour $7/Pax', '7', '1'),
(8, 2, 'Lexus RX300/Hight LanderShare 1days Small tour/Big tour $7/Pax', '10', '1'),
(9, 2, 'Van Share 1days Small tour/Big tour $6/Pax', '6', '1'),
(10, 3, 'Share Van (A/C with English speaking driver)$15/Pax', '15', '1'),
(13, 4, 'Tyota camary 2002 1day Small tour', '35', '4'),
(14, 4, 'Lexus RX 300/Hight Lander2004', '40', '4'),
(15, 4, 'Van  12 seats(A/C)', '45', '10'),
(16, 5, 'Toyota camary2002 Small tour$35', '35', '4'),
(17, 5, 'LEXUS RX300 (A/C)/ Hight Lander Small tour$40', '40', '4'),
(18, 5, 'Van12 seats Small tour $50', '50', '10'),
(19, 6, 'Toyota camary2004 (A/C)', '15', '4'),
(20, 6, 'LEXUS RX300 (A/C)', '20', '4'),
(21, 6, 'Van 15seats (A/C)', '25', '10'),
(22, 6, 'Tuk tuk', '8', '4'),
(23, 8, 'Toyota camary2004 (A/C)', '10', '4'),
(24, 8, 'LEXUS RX300 (A/C)', '15', '5'),
(25, 8, 'Van 15seats (A/C)', '15', '10'),
(26, 8, 'Tuk tuk', '5', '4'),
(27, 10, 'Toyota camary2004 (A/C)', '25', '4'),
(28, 10, 'LEXUS RX300 (A/C)', '25', '4'),
(29, 10, 'Van 15seats (A/C)', '35', '10'),
(30, 10, 'Tuk tuk', '15', '4'),
(31, 16, 'Tuk tuk', '45', '4'),
(32, 16, 'Toyota camary2004 (A/C)', '82', '4'),
(33, 16, 'LEXUS RX300 (A/C)', '92', '5'),
(34, 16, 'Van 15seats (A/C)', '122', '10'),
(35, 1, 'LexusRX300/High Lander', '9', '1'),
(36, 2, 'Tuk Tuk Share 1days Small tour/Big tour $7/Pax', '7', '1'),
(37, 4, 'Tuk Tuk English Speaking Driver', '15', '4'),
(38, 5, 'Tuk Tuk English Speaking Driver $15', '15', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home_accommodation`
--
ALTER TABLE `tbl_home_accommodation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home_highlight`
--
ALTER TABLE `tbl_home_highlight`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_home_photo_slide`
--
ALTER TABLE `tbl_home_photo_slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hotel_categories`
--
ALTER TABLE `tbl_hotel_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hotel_feature`
--
ALTER TABLE `tbl_hotel_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hotel_vs_room_type`
--
ALTER TABLE `tbl_hotel_vs_room_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page_description`
--
ALTER TABLE `tbl_page_description`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_page_slider`
--
ALTER TABLE `tbl_page_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_privacy_policy`
--
ALTER TABLE `tbl_privacy_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_description_photo`
--
ALTER TABLE `tbl_room_description_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_feature`
--
ALTER TABLE `tbl_room_feature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_room_type`
--
ALTER TABLE `tbl_room_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_terms_and_conditions`
--
ALTER TABLE `tbl_terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tour_guide`
--
ALTER TABLE `tbl_tour_guide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tour_package`
--
ALTER TABLE `tbl_tour_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tour_package_photo`
--
ALTER TABLE `tbl_tour_package_photo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_vehicle`
--
ALTER TABLE `tbl_vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_home_accommodation`
--
ALTER TABLE `tbl_home_accommodation`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_home_highlight`
--
ALTER TABLE `tbl_home_highlight`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_home_photo_slide`
--
ALTER TABLE `tbl_home_photo_slide`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_hotel`
--
ALTER TABLE `tbl_hotel`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_hotel_categories`
--
ALTER TABLE `tbl_hotel_categories`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_hotel_feature`
--
ALTER TABLE `tbl_hotel_feature`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_hotel_vs_room_type`
--
ALTER TABLE `tbl_hotel_vs_room_type`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_page_description`
--
ALTER TABLE `tbl_page_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_page_slider`
--
ALTER TABLE `tbl_page_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_privacy_policy`
--
ALTER TABLE `tbl_privacy_policy`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_room_description_photo`
--
ALTER TABLE `tbl_room_description_photo`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `tbl_room_feature`
--
ALTER TABLE `tbl_room_feature`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `tbl_room_type`
--
ALTER TABLE `tbl_room_type`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tbl_terms_and_conditions`
--
ALTER TABLE `tbl_terms_and_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_tour_guide`
--
ALTER TABLE `tbl_tour_guide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tbl_tour_package`
--
ALTER TABLE `tbl_tour_package`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_tour_package_photo`
--
ALTER TABLE `tbl_tour_package_photo`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_vehicle`
--
ALTER TABLE `tbl_vehicle`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

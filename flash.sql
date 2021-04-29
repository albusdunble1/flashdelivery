-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2020 at 06:26 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flash`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `AdminEmail` varchar(255) NOT NULL,
  `AdminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminEmail`, `AdminPassword`) VALUES
(1, 'admin@flash.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustID` int(10) NOT NULL,
  `CustName` varchar(255) NOT NULL,
  `CustEmail` varchar(255) NOT NULL,
  `CustPhoneNo` varchar(255) NOT NULL,
  `CustImage` varchar(255) NOT NULL,
  `CustPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustID`, `CustName`, `CustEmail`, `CustPhoneNo`, `CustImage`, `CustPassword`) VALUES
(1, 'MUHAMMAD ARIF', 'arif@gmail.com', '01112222222', 'arif.jpeg', 'arif123'),
(2, 'Ahmad Arif', 'ahmad@gmail.com', '0123416578', 'ahmad.jpg', '1234'),
(3, 'Siti Fira', 'fira@gmail.com', '0111222333', 'fira.jpg', '1998'),
(6, 'Ahmad Ali', 'ali@gmail.com', '0340227099', '1594543333hibana_r6s.jpg', '12345'),
(7, 'MUHD ARIFFF', 'arif123@gmail.com', '0145678912', '1594821880GAMBAR 3.jpg', '123456'),
(8, 'Arif Iman', 'iman@gmail.com', '01115176575', '1594869100customer.jpeg', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(10) NOT NULL,
  `CustID` int(10) NOT NULL,
  `OrderDate` varchar(255) NOT NULL,
  `OrderAddress` varchar(255) NOT NULL,
  `total` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustID`, `OrderDate`, `OrderAddress`, `total`) VALUES
(174, 1, 'July 9, 2020', 'UMP Pekan', 9710.00),
(175, 2, 'July 9, 2020', 'UMP Gambang Pahang', 9710.00),
(176, 3, 'July 9, 2020', 'Kuantan Pahang', 7610.00),
(178, 1, 'July 10, 2020', 'UMP Pahang', 29720.00),
(200, 1, 'July 13, 2020', 'Gombak, Selangor', 3910.00),
(202, 1, 'July 13, 2020', 'Gambang, Pahang', 3105.00),
(203, 1, 'July 13, 2020', 'Gambang, Pahang', 2005.00),
(204, 1, 'July 13, 2020', 'Taman Tas, Pahang', 3105.00),
(263, 7, 'July 15, 2020', 'Batu 5, Gombak', 442.71),
(264, 8, 'July 16, 2020', 'NO 10 LOT 2125 KAMPUNG PADANG BALANG', 6205.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `OrderProductID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `DeliveryStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`OrderProductID`, `OrderID`, `ProductID`, `quantity`, `DeliveryStatus`) VALUES
(257, 174, 1, 2, 'Pending'),
(258, 174, 2, 3, 'Pending'),
(259, 175, 2, 2, 'Processing'),
(260, 175, 3, 1, 'Pending'),
(261, 176, 3, 2, 'Pending'),
(262, 176, 1, 3, 'Pending'),
(265, 178, 1, 1, 'Pending'),
(266, 178, 2, 2, 'Delivered'),
(267, 178, 2, 3, 'Delivered'),
(268, 178, 3, 4, 'Delivered'),
(305, 200, 3, 1, 'Delivered'),
(306, 200, 1, 2, 'Delivered'),
(308, 202, 2, 1, 'Pending'),
(310, 204, 2, 1, 'Pending'),
(369, 263, 13, 1, 'Pending'),
(370, 263, 14, 2, 'Pending'),
(371, 263, 20, 3, 'Pending'),
(372, 264, 2, 2, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `OrderID`, `payment_id`, `payer_id`, `payer_email`, `amount`, `currency`, `payment_status`) VALUES
(72, 260, 'PAYID-L4HQL5Q927187932R590292R', '9Z75QZNUFSSSU', 'muhdiman@gmail.com', 634.93, 'MYR', 'approved'),
(75, 263, 'PAYID-L4HSFBI9KX68791KW679173Y', '9Z75QZNUFSSSU', 'muhdiman@gmail.com', 442.71, 'MYR', 'approved'),
(76, 264, 'PAYID-L4H4OXY8NX2340277118240W', '9Z75QZNUFSSSU', 'muhdiman@gmail.com', 6205.00, 'MYR', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(10) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `ProductPrice` double(10,2) NOT NULL,
  `ProductCategory` varchar(255) NOT NULL,
  `ProductDescription` varchar(255) NOT NULL,
  `ProductStatus` varchar(255) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `SpID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductPrice`, `ProductCategory`, `ProductDescription`, `ProductStatus`, `ProductImage`, `SpID`) VALUES
(1, 'Samsung J7 Pro', 599.00, 'Goods', 'The Samsung Galaxy J7 Pro is powered by a Octa-core 1.6 GHz Cortex-A53 CPU processor with 3 GB RAM. The device also has 32 GB internal storage + microSD (up to 256 GB)', 'Available', 'j7pro.png', 1),
(2, 'Iphone 11 Pro', 3100.00, 'Goods', 'The Apple iPhone 11 Pro is powered by a Apple A13 Bionic (7 nm+) CPU processor with 64GB 4GB RAM, 256GB 4GB RAM, 512GB 4GB RAM.', 'Available', '11phone11pro.jpeg', 2),
(3, 'Google Pixel 3', 3500.00, 'Goods', 'The Google Pixel 3 is powered by a Qualcomm SDM845 Snapdragon 845 (10 nm) CPU processor with 64/128 GB, 4 GB RAM.', 'Available', 'googlepixel3.jpg', 3),
(10, 'TORRAS Shockproof Designed for Samsung Galaxy S20 Case 6.2 Inch', 18.99, 'Goods', '[Military Grade Drop Protection] This Galaxy S20 protective case tested by the authoritative SGS agency from a height of 4ft, enduring 1000 times drops with 0 damage,', 'Available', 'case1.png', 1),
(11, 'AICase for Galaxy S20 Case', 13.99, 'Goods', '[Perfectly Fit] AICase Tough+ Protection Series case special designed for Samsung Galaxy S20/Galaxy S20 5G', 'Available', 'case2.png', 1),
(12, 'Adaptive Fast Wall Charger Adapter Compatible Samsung Galaxy S10 ', 15.99, 'Goods', 'Compatible Devices: Samsung Galaxy S10 S10+ S9 S9+ S8 S8+ Note 8 Note 9 & Other and other devices support AFC (Adaptive Fast Charging)\r\nGuaranteed Safety:Intelligent circuit design protects against short', 'Available', 'charger1.png', 1),
(13, 'Apple Pencil', 94.99, 'Goods', 'Compatible with 9.7-inch iPad Pro (Previous Model), 10.5-inch iPad Pro (Previous Model), 12.9-inch iPad Pro (1st Generation - Previous Model and 2nd Generation - Previous Model), iPad Air (3rd Generation - Latest Model)', 'Available', 'apple1.png', 2),
(14, 'Apple Magic Keyboard (Wireless, Rechargable) (US English) - Silver', 94.99, 'Goods', 'Magic Keyboard combines a sleek design with a built-in rechargeable battery and enhanced key features.', 'Available', 'apple2.png', 2),
(15, 'Apple USB-C Digital AV Multiport Adapter', 65.99, 'Goods', 'The USB-C digital AV multiport adapter lets you connect your USB-C enabled Mac or iPad Pro to an HDMI display, while also connecting a standard USB device and a USB-C charging cable.', 'Available', 'apple3.png', 2),
(16, 'Google Pixelbook Go M3 Chromebook 8GB/64GB Just Black', 649.00, 'Goods', 'Made to move: Pixelbook Go is lightweight - barely 2 pounds. It’s 13 mm thin with a grippable design, making it easier to carry.', 'Avaialble', 'google1.png', 3),
(17, 'Google WiFi Router by TP-Link - OnHub AC1900 (Managed by Google Wifi APP)', 87.99, 'Goods', 'The Google Wifi app guides you through setup, shows you which devices are connected to your network, and offers help if there\'s a Wi-Fi slow-down', 'Avaialble', 'google2.png', 3),
(18, 'Google Home Mini Stand Holder, Retro Alarm Clock Stand Mount', 14.99, 'Goods', 'Unique retro alarm clock design, make your Google Home Mini and Nest Mini look adorable. Perfectly fit for decorating your householder, very sleek and stylish.', 'Available', 'google3.png', 3),
(19, 'Google Daydream View VR Headset 2nd Generation for Pixel 2, 2XL 3, 3XL (Charcoal Gray)', 99.00, 'Goods', 'Don\'t just see the world, experience it. With daydream view (2nd GEN 2017 Model), you can teleport from virtually anywhere to Pretty much everywhere and experience reality anywhere', 'Available', 'google3.png', 3),
(20, 'Blackmores Betacarotene 6mg 90 Capsules', 47.58, 'Medical', 'Active Ingredients Per Capsule: Betacarotene (Natural Source) 6 Mg. Certified Halal By AFIC. No Added Yeast, Gluten, Wheat, Milk Derivatives, Preservatives, Artificial Flavours or Sweeteners.', 'Available', 'guardian_1.jpg', 7),
(22, 'Blackmores Bio ACE Plus 90 Tablets Pack-of-2', 191.10, 'Medical', 'Active Ingredients Per Tablet: Vitamin A 5000IU, Vitamin B1 (Thiamine Nitrate) 15mg, Vitamin B5 (Pantothenic Acid) 100mg, Vitamin B6 (Pyridoxine Hydrochloride) 50mg, Vitamin B12 (Cyanocobalamin)', 'Available', 'guardian_2.jpg', 7),
(23, 'Pristin Gold Omega-3 Fish Oil 1200mg 30\'s', 58.27, 'Medical', 'Each 1640mg softgel capsule contains 1200mg fish oil providing: EPA (Eicosapentaenoic Acid) 480mg DHA (Docosahexaenoic Acid) 360mg Total Omega-3 960mg', 'Available', 'guardian_3.jpg', 7),
(24, 'Biogreen Enzymes Vinegar 950ml', 46.80, 'Medical', 'Organic Apple Cider Vinegar, Active Enzymes Honey', 'Available', 'guardian_4.jpg', 7),
(25, 'Dettol Hand Sanitizer 50ml', 6.70, 'Medical', 'Active ingredient:Alcohol Denatured 66%,Ingredients:Water,PEG/PPG 17/6 Copolymer,propylene glycol,Acrylates/C10-30 Alkyl Acrylate', 'Available', 'guardian_5.jpg', 7),
(26, 'Lifebuoy Total 10 Hand Sanitizer 200ml', 16.50, 'Medical', 'Alcohol denatured 62%, Isopropanol 3%, Ethyl Alcohol, Water, Propylene Glycol, Isopropyl Alcohol, Niacinamide, Carbomer, Bis-Peg-18 Methyl Ether Demethyl Silane, Tocopheryl', 'Available', 'guardian_6.jpg', 7),
(27, 'L\'OREAL Paris Hydrafresh Hydration', 59.80, 'Medical', 'Immediately, skin is quenched, feels smooth and supple. Day after day, skin keeps optimal hydration level; feels more bouncy and supple; looks more radiant.', 'Available', 'guardian_7.jpg', 7),
(28, 'Garnier Skin Naturals Serum Mask Sakura White 1\'s', 7.50, 'Medical', 'Pomegranate helps to regenerate skin cells, protect collagen, guards against UV rays and prevents sun damage. It also contains antioxidant and helps with anti-aging.', 'Available', 'guardian_8.jpg', 7),
(29, 'Nivea Intensive Body Milk Lotion 400ml', 23.20, 'Medical', 'Long-lasting & intensive care for dry yo very dry skin. Enriched with high concentrated Vitamin E, the new non-stick formula repairs dry and rough skin to become soft & smooth immediately.', 'Available', 'guardian_9.jpg', 7),
(30, 'Vaseline Intensive Care Lotion Aloe Soothe 400ml', 21.50, 'Medical', 'Hydrating body lotion for fresh and light feeling skin. Absorbing quickly, infusing moisture at the top, core and deep down layers of skin.', 'Available', 'guardian_10.jpg', 7),
(31, 'Kambing Perap', 30.00, 'Food', 'KAMBING PERAP FROZEN 500 gram,1 box 500 gram,sos black pepper', 'Available', 'kambing perap.jpg', 9),
(32, 'Murtabak Frozen', 15.00, 'Food', 'SATU SATUNYA DAGING MURTABAK YANG DIKUKUS DAN DISALUTI TEPUNG YANG RANGUP\r\nSEBUNGKUS ADA EMPAT KEPING YANG DIBIKIN PADU PADAT', 'Available', 'murtabak frozen.jpg', 9),
(33, 'Ramly Chicken Burger Patty', 7.50, 'Food', 'Ramly Chicken Burger Patty (300g/Pkt)', 'Available', 'burger.jpg', 9),
(35, 'Karipap Frozen', 5.00, 'Food', 'KARIPAP FROZEN INTI IKAN HOMEMADE 12PIECES', 'Available', 'karipap.jpg', 9),
(36, 'KAWAN Malaysian Roti Chanai', 8.50, 'Food', 'The Roti Chanai / Roti Canai is a popular flatbread dish in Malaysian-Indian cuisine. Favoured by local Malaysians, this dish is guaranteed to satisfy any appetite.', 'Available', 'rotichanai.jpg', 9),
(40, 'Ramly Nugget Ayam(1KG)', 15.99, 'Food', '-HALAL\r\n			-Well Packing\r\n			-(OTRT) Order Today Receive Tomorrow\r\n			', 'Available', 'nugget.jpg', 9),
(41, 'SARDIN VIRAL de Heritage', 6.49, 'Food', 'KELUARAN BUMIPUTERA ISLAM.\r\n			Sardin Viral, Semudah Koyak Dan Makan', 'Available', 'sardin.jpg', 9),
(42, 'KEREPEK POPIA VIRAL. THE KRUZ CHIPS', 15.00, 'Food', 'READY STOCK KEPEREK VIRAL THE KRUZ CHIPS !!', 'Available', 'popiaviral.jpg', 9),
(43, ' COCHO TUB COCO RICE & COCO CRUNCH', 15.00, 'Food', 'LEBIH BESAR, LEBIH PUAS', 'Available', 'cocojar.jpg', 9),
(44, 'SUSU FARM FRESH 200ML', 55.00, 'Food', 'LEBIH SEGAR , LEBIH SEDAP DAN DIJAMIN HALAL', 'Available', 'fresh.jpg', 9),
(45, 'Dog Food Meat', 12.45, 'Pet', '- Is gently made to keep your adult dog in the best of conditions.\r\n- Made with delicious meaty pieces, this Pedigree® delicacy is sure to leave your dog salivating for more.\r\n- 100% nutritionally complete & balanced diet.\r\n- Quality meat & selected veget', 'Available', '17742c7de937b387bf5ac923e9660985.jpg', 10),
(46, 'Dog Food Beef', 27.17, 'Pet', '- Help your puppy grow into a strong and healthy dog with a Pedigree recipe that is gently cooked to retain vitamins that are more natural.\r\n- 100% nutritionally complete & balanced diet.\r\n- We have improved our formulation, continue making it complete an', 'Available', '445d9049b2a57932598dd518ac631f55.jpg', 10),
(47, 'Dog Food Veg', 6.10, 'Pet', '- High protein, Low fatProduct Marketing\r\n- Pedigree® Meat Jerky Roasted Lamb Flavor\r\n- Share moments of happiness and joy with your dog with Pedigree® Meat Jerky. The perfect combination of great tasting real \r\nmeat and a soft chewy texture make this a s', 'Available', 'ea64650d8534467a2aa35d6530d7c21b.jpg', 10),
(48, 'Cat Bed', 10.30, 'Pet', 'High quality : Made of soft short plush surface and elastic sponge core. Attractive : The unique toast slice shape looks delicious and attractive. Offer your pet a nice place to play, sleep and rest. Multi-Function : The creative pet mattress also', 'Available', 'Luxury-Fluffy-Pet-Bed-Dog-Puppy-Fur-Donut-Cuddler-Soft-Cushion-Plush-Round-Creative-Kennel-Cat.jpg', 10),
(49, 'Cat Cage', 59.69, 'Pet', 'The Catit Hooded Cat Pan provides privacy while retaining the litter inside the pan. The large hood lifts up for easy access for cleaning, while the built-in bag anchor helps keep the bag open and frees hand for scooping.', 'Available', 'catit-hooded-cat-pan-warm-grey-4404-96344485-79d6c9f3ac0dd295e02f6d32a0a413ae-catalog_233.jpg', 10),
(50, 'Cat Claw Scratcher', 49.90, 'Pet', 'This beautiful modern scratcher attaches flush to the wall and easily remove and replace to anywhere. Give your cat something to sink her claws into while eliminating clutter from your floors.', 'Available', '4251ab63c1ddf9b3580b5369dbe716cc.jpg', 10),
(51, 'Royal Kitten Food', 212.00, 'Pet', 'An exclusive combination of nutrients helps support the young kitten\'s digestive health and promotes optimal stool quality. The exclusive complex of antioxidants (vitamins C and E, lutein, taurine) and prebiotics (MOS & FOS) in Royal Canin Kitten help sup', 'Available', 'royal-canin-kitten-10kg-2267-28547756-3444c1057146b62e1ae2a6dc61decf9b-catalog_233.jpg', 10),
(52, 'Cat Dry Seafood ', 59.70, 'Pet', 'Dry cat food suitable for your seafood-loving cats. In flavours of tuna, salmon, whitefish, crab, shrimp. 100% complete and balanced nutrition for cats of all life stages. Strong, lean muscles supported by high-quality protein.', 'Available', 'ea9bc8534a6526704701d56b5630cd8b.jpg', 10),
(53, 'Koi Fish Food', 48.00, 'Pet', 'For Koi and other fish. High growth. High ddigestible. Colour enhancing. Rude protein 39%', 'Available', '4e45be52f8fe276dfd9638bee66da0da.jpg', 10),
(54, 'Premium Arowana Food', 45.00, 'Pet', 'Weight: 330g. Ingredients: Crude Protein > 50%, Crude Ash < 10%, Crude Fat > 8%, Crude Fiber < 3.5%, Moisture < 9%.', 'Available', 'e496143a4ceb4716d8a8727a606aab52.jpg', 10),
(55, 'Parrot Food', 14.20, 'Pet', 'Optimum nutrition formula. 20% protein.', 'Available', 'a6fa5c0f7be316b10eac56a62927963e.jpg', 10),
(56, 'Premium Parrot Food', 25.00, 'Pet', 'No colouring or preservativessugar free recipvitaminsminerals & lodineinmmune active.', 'Available', '71de5a62ad48e6db7d3c2b7e7299a4f6.jpg', 10),
(57, 'Cockatiel Bird Food', 26.50, 'Pet', 'Omega 3 & Omega 6 fatty acid to improve brain function. Vitamin A to improve visual acuity. Vitamin B1 & B2 to nourish nervous system', 'Available', 'cockatiel-amp-lovebird-food-1kg-8506-26011081-f96ab24427d9d7c60293f4d931e04a4b-catalog_233.jpg', 10),
(58, 'Cat Ball Toy', 9.50, 'Pet', 'Toy Ball for Cat Sisal rope Ball / Cat Toy / Cat Toys / Toy for cat / Mainan Kucing.', 'Available', '74c87429e8dc2581b94f07fc49ddb221.jpg', 10),
(59, 'Cat Mouse Toy', 0.80, 'Pet', 'Measurement: 6x3CM. MATERIAL:Rubber and flocking. High quality lovely and funny false mice.USE:A good way to make your pet become more energetic and nimble.SQUEAK NOISE:Can make clear sound, draw your cat\'s attention easily and arouse cat curiosity.', 'Available', '36adc2f80e9744d4c8862061fecab162.jpg', 10),
(60, 'Mouse Logitech', 109.00, 'Goods', 'Gaming pc mouse', 'Out of Stock', 'mouse1.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `runner`
--

CREATE TABLE `runner` (
  `RunnerID` int(10) NOT NULL,
  `RunnerName` varchar(255) NOT NULL,
  `RunnerEmail` varchar(255) NOT NULL,
  `RunnerPassword` varchar(255) NOT NULL,
  `RunnerPhoneNo` varchar(255) NOT NULL,
  `RunnerICNo` varchar(255) NOT NULL,
  `RunnerAddress` varchar(255) NOT NULL,
  `RunnerImage` varchar(255) NOT NULL,
  `RunnerPlateNo` varchar(255) NOT NULL,
  `RunnerRegStatus` varchar(255) NOT NULL,
  `RunnerRegComment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `runner`
--

INSERT INTO `runner` (`RunnerID`, `RunnerName`, `RunnerEmail`, `RunnerPassword`, `RunnerPhoneNo`, `RunnerICNo`, `RunnerAddress`, `RunnerImage`, `RunnerPlateNo`, `RunnerRegStatus`, `RunnerRegComment`) VALUES
(1, 'Ahmad Ahsan', 'ali@gmail.com', '123456', '0125555555', '980201123456', 'Taman Tas, Pahang', 'ali.jpg', 'www 1234', 'PENDING', 'Please wait 1-2 days for us to validate your account'),
(2, 'Nur Fatimah', 'nur@gmail.com', '123456', '0123999888', '950304102234', 'Termerloh Pahang', 'nur.jpg', 'WWY 1998', 'APPROVED', ''),
(4, 'Muhd Arif Iman ', 'iman@gmail.com', '123456', '0123456789', '999999999999', 'Gombak, Selangor', '1594566555Jadual Sem Baru.JPG', 'WTF 1234', '', ''),
(6, 'Ahmad Kamal', 'kamal@gmail.com', '123456', '011111111', '999999999999', 'Gambang Pahang', '1594652120sledge_r6s1.jpeg', 'tyu1234', '', ''),
(7, 'weisheng', 'weisheng@gmail.com', '123456', '01115176575', '980505145093', 'NO 10 LOT 2125 KAMPUNG PADANG BALANG, SENTUL,51100 KUALA LUMPUR', '1594869927runner.jpeg', 'WWT1234', 'APPROVED', 'Please wait 1-2 days for us to validate your account');

-- --------------------------------------------------------

--
-- Table structure for table `runner_order`
--

CREATE TABLE `runner_order` (
  `RunnerOrderID` int(10) NOT NULL,
  `RunnerID` int(10) NOT NULL,
  `OrderProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `runner_order`
--

INSERT INTO `runner_order` (`RunnerOrderID`, `RunnerID`, `OrderProductID`) VALUES
(39, 4, 268),
(40, 4, 259),
(41, 2, 306),
(43, 2, 266),
(44, 2, 267),
(45, 2, 305),
(46, 7, 372);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider`
--

CREATE TABLE `service_provider` (
  `SpID` int(10) NOT NULL,
  `SpName` varchar(255) NOT NULL,
  `SpEmail` varchar(255) NOT NULL,
  `SpAddress` varchar(255) NOT NULL,
  `SpPhoneNo` varchar(255) NOT NULL,
  `SpRegID` varchar(255) NOT NULL,
  `SpType` varchar(255) NOT NULL,
  `SpPassword` varchar(255) NOT NULL,
  `SpImage` varchar(255) NOT NULL,
  `SpRegStatus` varchar(255) NOT NULL,
  `SpRegComment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_provider`
--

INSERT INTO `service_provider` (`SpID`, `SpName`, `SpEmail`, `SpAddress`, `SpPhoneNo`, `SpRegID`, `SpType`, `SpPassword`, `SpImage`, `SpRegStatus`, `SpRegComment`) VALUES
(1, 'Samsung Inc', 'samsung@samsung.com', 'Samsung Store Pekan Pahang', '0123456789', 'RG9876', 'Goods', '123456', 'samsunglogo.png', '', ''),
(2, 'Apple In', 'apple@apple.com', 'Apple Store Taman Kuantan', '0344445555', 'RG1234', 'Goods', '123456', 'applelogo.jpeg', 'APPROVED', ''),
(3, 'Google Inc', 'google@google.com', 'Google Store Taman Tas', '0650551234', 'RG5567', 'Goods', '123456', 'googlelogo.png', 'APPROVED', ''),
(7, 'Guardian', 'guardian@guardian.com', 'Lot B4, Gf, Giant Hypermarket Kuantan, Lot 5197, Jln Tanah Putih Seksyen 124, Mukim Kuantan', '09513 9311', 'RG1556', 'Medical', '123456', 'guardian.png', 'APPROVED', ''),
(9, 'SuperFood', 'superfood@gmail.com', 'No.24 Bangunan Lima, Taman Indera, 27620 Raub, Pahang', '01116932728', 'RG8876', 'Food', '123456', 'superfood.jpg', 'APPROVED', 'Welcome to use the Flash Delivery System'),
(10, 'Pet Master', 'petmaster@petmaster.com', 'No 5, Jalan Kuching, Taman Tas, Pahang', '0923456789', 'RG1098', 'Pet', '123456', 'petmaster.png', 'APPROVED', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustID` (`CustID`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`OrderProductID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `SpID` (`SpID`);

--
-- Indexes for table `runner`
--
ALTER TABLE `runner`
  ADD PRIMARY KEY (`RunnerID`);

--
-- Indexes for table `runner_order`
--
ALTER TABLE `runner_order`
  ADD PRIMARY KEY (`RunnerOrderID`),
  ADD KEY `RunnerID` (`RunnerID`),
  ADD KEY `OrderProductID` (`OrderProductID`);

--
-- Indexes for table `service_provider`
--
ALTER TABLE `service_provider`
  ADD PRIMARY KEY (`SpID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `OrderProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `runner`
--
ALTER TABLE `runner`
  MODIFY `RunnerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `runner_order`
--
ALTER TABLE `runner_order`
  MODIFY `RunnerOrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `service_provider`
--
ALTER TABLE `service_provider`
  MODIFY `SpID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustID`) REFERENCES `customer` (`CustID`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`SpID`) REFERENCES `service_provider` (`SpID`);

--
-- Constraints for table `runner_order`
--
ALTER TABLE `runner_order`
  ADD CONSTRAINT `runner_order_ibfk_1` FOREIGN KEY (`RunnerID`) REFERENCES `runner` (`RunnerID`),
  ADD CONSTRAINT `runner_order_ibfk_2` FOREIGN KEY (`OrderProductID`) REFERENCES `order_product` (`OrderProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE DATABASE edgelink_services_db;

USE edgelink_services;

CREATE TABLE about_us (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT
);



-- Insert initial data
INSERT INTO about_us (title, description) VALUES
('About HighTech Agency And Its Innovative IT Solutions', 'At Edgelink Consultancy, we are committed to empowering businesses through expert consultancy services and innovative solutions...');


DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) DEFAULT NULL,
  `short` varchar(1500) DEFAULT NULL,
  `descrip` varchar(10000) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `short`, `descrip`, `img`, `url`, `date`, `status`) VALUES
(36, 'Import and Export Services', 'We Offer Import & Export assistance foreign businesses in transporting and selling their products in China, India and USA.', '<p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; border: none; outline: none; line-height: inherit;\">We Offer Import &amp; Export assistance foreign businesses in transporting and selling their products in China, India and USA.&nbsp;&nbsp;Most of our channel partner are based into USA, India and China.<br></p>', '544420236news-16.jpg', NULL, 'Mon 08 Feb 2021', '0'),
(37, 'Logistic Services', 'We are one of the best serving logistics company. Here, the clients get real-time pricing. The price for logistics transport service from USA, Canada, India & China', '<p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; border: none; outline: none; line-height: inherit;\">We are one of the best serving logistics company. Here, the clients get real-time pricing. The price for logistics transport service from USA, Canada, India & China with shipping facilities with on-time deliveries in all the major areas around the country.Â <br></p>', '778861706project-16.jpg', NULL, 'Mon 08 Feb 2021', '0'),
(38, 'Home Delivery Services', 'We offer Home delivery service Service, the basic services for handling deliveries in express and cargo mode globally.', '<p open=\"\" sans\",=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; border: none; outline: none; line-height: inherit;\">We offer Home delivery service Service, the basic services for handling deliveries in express and cargo mode globally. There are two services offered under this: Domestic Express Services for delivering documents and small parcels.&nbsp; And Big container &amp; shipment services.<br></p>', '189322611project-8.jpg', NULL, 'Mon 08 Feb 2021', '0');

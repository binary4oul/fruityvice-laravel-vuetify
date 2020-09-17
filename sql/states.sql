/*
Navicat PGSQL Data Transfer

Source Server         : PGSQL
Source Server Version : 90325
Source Host           : localhost:5433
Source Database       : concrete
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90325
File Encoding         : 65001

Date: 2020-09-17 20:39:54
*/


-- ----------------------------
-- Table structure for states
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states` (
`id` varchar(10) NOT NULL,
`countryid` varchar(10) NOT NULL,
`state` varchar(50) NOT NULL
);


-- ----------------------------
-- Records of states
-- ----------------------------
INSERT INTO `states` VALUES ('AB', 'CA', 'Alberta');
INSERT INTO `states` VALUES ('AGS', 'MX', 'Aguascalientes');
INSERT INTO `states` VALUES ('AK', 'US', 'Alaska');
INSERT INTO `states` VALUES ('AL', 'US', 'Alabama');
INSERT INTO `states` VALUES ('AR', 'US', 'Arkansas');
INSERT INTO `states` VALUES ('AZ', 'US', 'Arizona');
INSERT INTO `states` VALUES ('BC', 'CA', 'British Columbia');
INSERT INTO `states` VALUES ('BCN', 'MX', 'Baja California');
INSERT INTO `states` VALUES ('BCS', 'MX', 'Baja California Sur');
INSERT INTO `states` VALUES ('CA', 'US', 'California');
INSERT INTO `states` VALUES ('CAM', 'MX', 'Campeche');
INSERT INTO `states` VALUES ('CHI', 'MX', 'Chihuahua');
INSERT INTO `states` VALUES ('CHP', 'MX', 'Chiapas');
INSERT INTO `states` VALUES ('CO', 'US', 'Colorado');
INSERT INTO `states` VALUES ('COA', 'MX', 'Coahuila');
INSERT INTO `states` VALUES ('COL', 'MX', 'Colima');
INSERT INTO `states` VALUES ('CT', 'US', 'Connecticut');
INSERT INTO `states` VALUES ('DC', 'US', 'District Of Columbia');
INSERT INTO `states` VALUES ('DE', 'US', 'Delaware');
INSERT INTO `states` VALUES ('DIF', 'MX', 'Distrito Federal');
INSERT INTO `states` VALUES ('DUR', 'MX', 'Durango');
INSERT INTO `states` VALUES ('FL', 'US', 'Florida');
INSERT INTO `states` VALUES ('GA', 'US', 'Georgia');
INSERT INTO `states` VALUES ('GRO', 'MX', 'Guerrero');
INSERT INTO `states` VALUES ('GTO', 'MX', 'Guanajuato');
INSERT INTO `states` VALUES ('HGO', 'MX', 'Hidalgo');
INSERT INTO `states` VALUES ('HI', 'US', 'Hawaii');
INSERT INTO `states` VALUES ('IA', 'US', 'Iowa');
INSERT INTO `states` VALUES ('ID', 'US', 'Idaho');
INSERT INTO `states` VALUES ('IL', 'US', 'Illinois');
INSERT INTO `states` VALUES ('IN', 'US', 'Indiana');
INSERT INTO `states` VALUES ('JAL', 'MX', 'Jalisco');
INSERT INTO `states` VALUES ('KS', 'US', 'Kansas');
INSERT INTO `states` VALUES ('KY', 'US', 'Kentucky');
INSERT INTO `states` VALUES ('LA', 'US', 'Louisiana');
INSERT INTO `states` VALUES ('MA', 'US', 'Massachusetts');
INSERT INTO `states` VALUES ('MB', 'CA', 'Manitoba');
INSERT INTO `states` VALUES ('MD', 'US', 'Maryland');
INSERT INTO `states` VALUES ('ME', 'US', 'Maine');
INSERT INTO `states` VALUES ('MEX', 'MX', 'Mexico');
INSERT INTO `states` VALUES ('MI', 'US', 'Michigan');
INSERT INTO `states` VALUES ('MIC', 'MX', 'Michoacan');
INSERT INTO `states` VALUES ('MN', 'US', 'Minnesota');
INSERT INTO `states` VALUES ('MO', 'US', 'Missouri');
INSERT INTO `states` VALUES ('MOR', 'MX', 'Morelos');
INSERT INTO `states` VALUES ('MS', 'US', 'Mississippi');
INSERT INTO `states` VALUES ('MT', 'US', 'Montana');
INSERT INTO `states` VALUES ('NAY', 'MX', 'Nayarit');
INSERT INTO `states` VALUES ('NB', 'CA', 'New Brunswick');
INSERT INTO `states` VALUES ('NC', 'US', 'North Carolina');
INSERT INTO `states` VALUES ('ND', 'US', 'North Dakota');
INSERT INTO `states` VALUES ('NE', 'US', 'Nebraska');
INSERT INTO `states` VALUES ('NH', 'US', 'New Hampshire');
INSERT INTO `states` VALUES ('NJ', 'US', 'New Jersey');
INSERT INTO `states` VALUES ('NL', 'CA', 'Newfoundland and Labrador');
INSERT INTO `states` VALUES ('NLE', 'MX', 'Nuevo Leon');
INSERT INTO `states` VALUES ('NM', 'US', 'New Mexico');
INSERT INTO `states` VALUES ('NS', 'CA', 'Nova Scotia');
INSERT INTO `states` VALUES ('NT', 'CA', 'Northwest Territories');
INSERT INTO `states` VALUES ('NU', 'CA', 'Nunavut');
INSERT INTO `states` VALUES ('NV', 'US', 'Nevada');
INSERT INTO `states` VALUES ('NY', 'US', 'New York');
INSERT INTO `states` VALUES ('OAX', 'MX', 'Oaxaca');
INSERT INTO `states` VALUES ('OH', 'US', 'Ohio');
INSERT INTO `states` VALUES ('OK', 'US', 'Oklahoma');
INSERT INTO `states` VALUES ('ON', 'CA', 'Ontario');
INSERT INTO `states` VALUES ('OR', 'US', 'Oregon');
INSERT INTO `states` VALUES ('PA', 'US', 'Pennsylvania');
INSERT INTO `states` VALUES ('PE', 'CA', 'Prince Edward Island');
INSERT INTO `states` VALUES ('PUE', 'MX', 'Puebla');
INSERT INTO `states` VALUES ('QC', 'CA', 'Quebec');
INSERT INTO `states` VALUES ('QRO', 'MX', 'Queretaro');
INSERT INTO `states` VALUES ('RI', 'US', 'Rhode Island');
INSERT INTO `states` VALUES ('ROO', 'MX', 'Quintana Roo');
INSERT INTO `states` VALUES ('SC', 'US', 'South Carolina');
INSERT INTO `states` VALUES ('SD', 'US', 'South Dakota');
INSERT INTO `states` VALUES ('SIN', 'MX', 'Sinaloa');
INSERT INTO `states` VALUES ('SK', 'CA', 'Saskatchewan');
INSERT INTO `states` VALUES ('SLP', 'MX', 'San Luis Potosi');
INSERT INTO `states` VALUES ('SON', 'MX', 'Sonora');
INSERT INTO `states` VALUES ('TAB', 'MX', 'Tabasco');
INSERT INTO `states` VALUES ('TAM', 'MX', 'Tamaulipas');
INSERT INTO `states` VALUES ('TLX', 'MX', 'Tlaxcala');
INSERT INTO `states` VALUES ('TN', 'US', 'Tennessee');
INSERT INTO `states` VALUES ('TX', 'US', 'Texas');
INSERT INTO `states` VALUES ('UT', 'US', 'Utah');
INSERT INTO `states` VALUES ('VA', 'US', 'Virginia');
INSERT INTO `states` VALUES ('VER', 'MX', 'Veracruz');
INSERT INTO `states` VALUES ('VT', 'US', 'Vermont');
INSERT INTO `states` VALUES ('WA', 'US', 'Washington');
INSERT INTO `states` VALUES ('WI', 'US', 'Wisconsin');
INSERT INTO `states` VALUES ('WV', 'US', 'West Virginia');
INSERT INTO `states` VALUES ('WY', 'US', 'Wyoming');
INSERT INTO `states` VALUES ('YT', 'CA', 'Yukon');
INSERT INTO `states` VALUES ('YUC', 'MX', 'Yucatan');
INSERT INTO `states` VALUES ('ZAC', 'MX', 'Zacatecas');

-- ----------------------------
-- Alter Sequences Owned By
-- ----------------------------

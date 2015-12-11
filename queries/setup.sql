--
-- Setup module module-template
--

-- --------------------------------------------------------

--
-- Table structure for table `module-template_addresses`
--

CREATE TABLE IF NOT EXISTS `module-template_addresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'U' COMMENT 'M male, F female, U undefined',
  `birthday` date DEFAULT NULL,
  `addDate` datetime NOT NULL,
  `addIdAccount` int(11) unsigned NOT NULL,
  `updDate` datetime DEFAULT NULL,
  `updIdAccount` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`firstname`,`lastname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Dati della tabelle `settings_permissions`
--

INSERT INTO `settings_permissions` (`id`, `module`, `action`, `description`, `locked`) VALUES
(NULL, 'module-template', 'address_view', 'View address', 0),
(NULL, 'module-template', 'address_edit', 'Edit address', 0),
(NULL, 'module-template', 'address_del', 'Delete address', 0);

-- --------------------------------------------------------
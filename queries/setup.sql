--
-- Setup module module-template
--

-- --------------------------------------------------------

--
-- Table structure for table `test-module-template`
--

CREATE TABLE IF NOT EXISTS `test-module-template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Dati della tabelle `settings_permissions`
--

INSERT INTO `settings_permissions` (`id`, `module`, `action`, `description`, `locked`) VALUES
(NULL, 'module-template', 'item_list', 'Show item list', 0),
(NULL, 'module-template', 'item_view', 'View item details', 0),
(NULL, 'module-template', 'item_edit', 'Edit item details', 0),
(NULL, 'module-template', 'item_del', 'Delete items', 0);

-- --------------------------------------------------------
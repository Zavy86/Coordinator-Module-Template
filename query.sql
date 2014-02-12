--
-- Database: `coordinator`
--



--
-- Dati della tabelle `settings_permissions`
--

INSERT INTO `settings_permissions` (`id`, `module`, `action`, `description`, `locked`) VALUES
(NULL , 'module-template', 'module-template_list', 'List', '0'),
(NULL , 'module-template', 'module-template_view', 'View', '0'),
(NULL , 'module-template', 'module-template_edit', 'Edit', '0'),
(NULL , 'module-template', 'module-template_del', 'Delete', '0');

-- --------------------------------------------------------
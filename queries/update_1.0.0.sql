--
-- Setup module module-template
--
-- From 1.0.0 to 1.0.1
--

-- --------------------------------------------------------

UPDATE `settings_modules` SET `version`='1.0.1' WHERE `module`='module-template';

-- --------------------------------------------------------

ALTER TABLE `test-module-template` ADD `name` VARCHAR(255) NOT NULL;

-- --------------------------------------------------------
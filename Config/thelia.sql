
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_i18n`;

CREATE TABLE `menu_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `idx_menu_has_menu_i18n` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item`;

CREATE TABLE `menu_item`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `menu_id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`menu_id`),
    INDEX `idx_menu_has_menu_item` (`menu_id`),
    CONSTRAINT `fk_menu_has_menu_item`
        FOREIGN KEY (`menu_id`)
        REFERENCES `menu` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item_i18n`;

CREATE TABLE `menu_item_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`),
    INDEX `idx_menu_item_has_menu_item_i18n` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_version`;

CREATE TABLE `menu_version`
(
    `id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `menu_item_ids` TEXT,
    `menu_item_versions` TEXT,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `menu_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `menu` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_i18n_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_i18n_version`;

CREATE TABLE `menu_i18n_version`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `menu_i18n_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `menu_i18n` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item_version`;

CREATE TABLE `menu_item_version`
(
    `id` INTEGER NOT NULL,
    `menu_id` INTEGER NOT NULL,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    `menu_id_version` INTEGER DEFAULT 0,
    PRIMARY KEY (`id`,`menu_id`,`version`),
    CONSTRAINT `menu_item_version_FK_1`
        FOREIGN KEY (`id`,`menu_id`)
        REFERENCES `menu_item` (`id`,`menu_id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item_i18n_version
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item_i18n_version`;

CREATE TABLE `menu_item_i18n_version`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    `version_created_at` DATETIME,
    `version_created_by` VARCHAR(100),
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `menu_item_i18n_version_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `menu_item_i18n` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

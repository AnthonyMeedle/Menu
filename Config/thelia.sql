
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
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item`;

CREATE TABLE `menu_item`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `menu_id` INTEGER,
    `menu_parent` INTEGER,
    `visible` TINYINT DEFAULT 0 NOT NULL,
    `targetblank` TINYINT DEFAULT 0,
    `sousmenu` TINYINT DEFAULT 0,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `cssclass` VARCHAR(255),
    `icone` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_menu_has_menu_item` (`menu_id`),
    CONSTRAINT `fk_menu_has_menu_item`
        FOREIGN KEY (`menu_id`)
        REFERENCES `menu` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_i18n`;

CREATE TABLE `menu_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `menu_i18n_fk_14b1c0`
        FOREIGN KEY (`id`)
        REFERENCES `menu` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- menu_item_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `menu_item_i18n`;

CREATE TABLE `menu_item_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `url` VARCHAR(255),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `menu_item_i18n_fk_e8a872`
        FOREIGN KEY (`id`)
        REFERENCES `menu_item` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

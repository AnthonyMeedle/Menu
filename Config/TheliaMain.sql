SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `menu` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 0,
    `objet` INTEGER DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `menu_item` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `menu_id` INTEGER NOT NULL,
    `menu_parent` INTEGER DEFAULT 0 NOT NULL,
    `visible` TINYINT DEFAULT 1 NOT NULL,
    `targetblank` TINYINT DEFAULT 0 NOT NULL,
    `sousmenu` TINYINT DEFAULT 0 NOT NULL,
    `position` INTEGER DEFAULT 0 NOT NULL,
    `typobj` INTEGER DEFAULT 4 NOT NULL,
    `objet` INTEGER DEFAULT 0 NOT NULL,
    `cssclass` VARCHAR(255),
    `icone` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fi_menu_has_menu_item` (`menu_id`),
    INDEX `idx_menu_item_tree` (`menu_id`, `menu_parent`, `position`),
    CONSTRAINT `fk_menu_has_menu_item` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `menu_i18n` (
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`, `locale`),
    CONSTRAINT `menu_i18n_fk` FOREIGN KEY (`id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `menu_item_i18n` (
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `url` VARCHAR(2048),
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`, `locale`),
    CONSTRAINT `menu_item_i18n_fk` FOREIGN KEY (`id`) REFERENCES `menu_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

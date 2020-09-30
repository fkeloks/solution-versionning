CREATE TABLE IF NOT EXISTS `migrations`
(
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
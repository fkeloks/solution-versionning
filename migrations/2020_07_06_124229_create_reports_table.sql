CREATE TABLE IF NOT EXISTS `reports`
(
    `id`              INT          NOT NULL AUTO_INCREMENT,
    `reason`          varchar(255) NOT NULL,
    `announcement_id` int(11)      NOT NULL DEFAULT 1,
    `client_ip`       VARCHAR(50)  NULL,
    `created_at`      DATETIME              DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`announcement_id`) REFERENCES announcements (`id`)
) ENGINE = InnoDB;

INSERT INTO `reports` (`reason`, `announcement_id`)
VALUES ('l''annonce est irrespectueuse.', 1),
        ('Les informations sont incorrectes', 2),
        ('Les prix ne respectent pas les normes',3);

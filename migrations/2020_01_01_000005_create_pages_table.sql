CREATE TABLE IF NOT EXISTS `pages`
(
    `id`     INT          NOT NULL AUTO_INCREMENT,
    `title`  varchar(255) NOT NULL,
    `path`   varchar(250) NOT NULL,
    `status` int(11)      NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `pages` (`id`, `title`, `path`, `status`)
VALUES (1, 'Accueil', '/', 1),
       (3, 'Qui sommes-nous', '/qui-sommes-nous', 1),
       (4, 'Informations légales', '/informations-legales', 1),
       (5, 'Contactez nous', '/contactez-nous', 1),
       (6, 'Estimation', '/estimation', 1);

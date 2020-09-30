CREATE TABLE IF NOT EXISTS `settings`
(
    `id`    INT          NOT NULL AUTO_INCREMENT,
    `label` varchar(30)  NOT NULL,
    `key`   varchar(30)  NOT NULL,
    `value` varchar(300) NOT NULL,
    `options` varchar(500) NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `settings` (`label`, `key`, `value`, `options`)
VALUES ('Nom du site', 'site.name', 'EfysImmobilier', null),
       ('Description du site', 'site.description',
        'EfysImmobilier, la solution digitale de référence pour les agences immobilières !', null),
       ('Mots clés du site', 'site.keywords', 'efys, immobilier, france, location, vente', null),
       ('Compte Twitter', 'site.twitter', '@efysimmobilier', null),
       ('Thème', 'site.theme', 'light', '{"light": "Thème clair","dark": "Thème sombre"}');

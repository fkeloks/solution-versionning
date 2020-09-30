CREATE TABLE IF NOT EXISTS `announcements`
(
    `id`          INT           NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(3000) NOT NULL,
    `type`        INT(11)       NOT NULL,
    `price`       FLOAT         NOT NULL,
    `picture`     VARCHAR(500)  NULL,
    `user_id`     INT           NOT NULL,
    `batch_id`    INT           NOT NULL,
    `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users (`id`),
    FOREIGN KEY (`batch_id`) REFERENCES batches (`id`)
) ENGINE = InnoDB;

SET @description = '<p>Au 4e étage avec ascenseur d''un immeuble Haussmannien de standing avec gardien.
Appartement sur cour d''environ 98 m² refait à neuf, composé d''une entrée, un grand séjour, 2 chambres, une salle de bains avec WC, une cuisine séparée vide et un WC indépendant avec lave-mainsChauffage et EC individuels électriques.
Porte blindée, parquet, placards, double-vitrage, digicode et interphone.
Transport:
Métro station ÉTIENNE MARCEL (L 4) à 20 mètres.
* PAS DE COLOCATION
* GARANT UNIQUEMENT POUR LES ÉTUDIANTS.
* REVENU MINIMUM NET MENSUEL: 9 303 €
À propos du prix:
Loyer: 3 101,00 € par mois charges comprises- Provision pour charges avec régularisation annuelle: 210 € par mois.
- Honoraires TTC réalisation état des lieux: 294 €- Localisation: Paris 2ème
- Location non meublée.
Loyer 2 891 €/HC, 3 101 €/CC.</p>';

INSERT INTO `announcements` (`description`, `type`, `price`, `picture`, `user_id`, `batch_id`)
VALUES (@description, 1, 650,
        'https://architecture-vendee.com/wp-content/uploads/2015/10/Photo-du-28.01.09-046_re-2_LR-960x635.jpg', 1, 1),
       (@description, 1, 725,
        'https://architecture-vendee.com/wp-content/uploads/2015/10/Photo-du-28.01.09-014_re_LR-1920x1269.jpg', 2, 2),
       (@description, 1, 1050,
        'https://architecture-vendee.com/wp-content/uploads/2015/10/Photo-du-28.01.09-092_re_LR-960x635.jpg', 3, 3),
       (@description, 1, 1280,
        'https://www.tourisme-vieuxboucau.com/wp-content/uploads/sites/7/2018/03/location-vacances-landes.jpg', 3, 4),
       (@description, 2, 320000, 'https://palmerablue.com/data/img/img5d9233fbc041bf.jpg', 4, 5),
       (@description, 2, 250000,
        'https://justimmo.ch/images/properties/12824/big__apartment-for-sale-3-rooms-monthey-5efd0c139f91e.jpg', 4, 6),
       (@description, 1, 1025,
        'https://agence-py.staticlbi.com/original/images/biens/1/84f7bd3c6c406cc239f032a7b67d7ddc/a1539f5e840e80ae108411352d59ca25.jpg',
        1, 7),
       (@description, 1, 840,
        'https://www.bnb.tn/wp-content/uploads/2018/08/38085565_258539848306909_8508564903273955328_n.jpg', 1, 8),
       (@description, 1, 750, 'https://q-cf.bstatic.com/images/hotel/max1024x768/255/255542412.jpg', 1, 9),
       (@description, 1, 1400, 'https://palmerablue.com/data/img/img5d9233e70039bf.jpg', 1, 10),
       (@description, 1, 900, 'https://www.immocal.nc/wp-content/uploads/2017/10/KAR_4558-960x635.jpg', 1, 11),
       (@description, 1, 800,
        'https://static.barcelona-home.com/960x/galleries/1471/pictures/p19fij4pn61a4p15561g57o411fqra.jpg', 1, 12),
       (@description, 1, 710,
        'https://www.bnb.tn/wp-content/uploads/2018/08/38084937_258540558306838_4823091451267121152_n.jpg', 1, 13),
       (@description, 1, 715,
        'https://media.homegate.ch/v1590494127/listings/a252/images/106648065_4_5eccf89f9df40.jpg/s/975/540', 1, 14),
       (@description, 1, 635, 'https://q-cf.bstatic.com/images/hotel/max1024x768/122/122351989.jpg', 1, 15),
       (@description, 1, 650,
        'https://static.barcelona-home.com/960x/galleries/1745/pictures/p19q3v0vucthe1ahl16b8rpu10q3e.png', 1, 16),
       (@description, 1, 675,
        'https://blog.chaylaimmobilier.com/wp-content/uploads/2017/01/iceberg-houses9517312_n.jpg', 1, 17),
       (@description, 1, 895,
        'https://www.globimmo.net/image/server3-e-a-d-f-8-1bb43f1e2077b1c5bb3c2452899855f76478192a7f91d8d2321fbb26fe2.jpg',
        1, 18),
       (@description, 1, 575, 'https://cdn.pixabay.com/photo/2014/11/13/21/21/interior-design-529904_960_720.jpg', 1,
        18),
       (@description, 2, 322000, 'https://i.pinimg.com/originals/67/78/bf/6778bf2c2ce640fc3133bddbd9400338.jpg', 1, 19),
       (@description, 2, 325000, 'https://a0.muscache.com/im/pictures/9fd8bfdc-c215-4ab7-ba92-a6c876e2d623.jpg', 1, 20),
       (@description, 2, 430500, 'https://www.salon-deco-lille.com/wp-content/uploads/2019/10/Maison-de-Maggy-1.jpg',
        1, 21),
       (@description, 2, 450000,
        'https://lamaisondesarchitectes.com/media/cache/realisation/rc/FTyxjP9K//uploads/images/b044b172fac0456ba0dc9076909f7c11.jpeg',
        1, 22),
       (@description, 2, 515000,
        'https://www.globimmo.net/image/server3-e-a-d-f-8-1bb43f1e2077b1c5bb3c2452899855f76478192a7f91d8d2321fbb26fe2.jpg',
        1, 23),
       (@description, 2, 560000, 'https://www.salon-deco-lille.com/wp-content/uploads/2019/10/Maison-de-Maggy-2.jpg',
        1, 24),
       (@description, 2, 620500,
        'https://www.deco-salonmaroc.com/wp-content/uploads/2018/12/Salons-marocains-de-luxe-Mod%C3%A8le-2019-1.jpg', 1,
        25),
       (@description, 2, 61000,
        'https://wildbirdscollective.com/wp-content/uploads/2012/11/vienna_bakery_header01.jpg', 1, 26),
       (@description, 2, 61000,
        'https://s3-eu-west-1.amazonaws.com/static-cms.s3.travaux.com/170152df-aa87-46d7-810e-8c35da63db36.jpg',
        1, 27);

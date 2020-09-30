CREATE TABLE IF NOT EXISTS `users`
(
    `id`        INT          NOT NULL AUTO_INCREMENT,
    `firstname` varchar(50)  NOT NULL,
    `lastname`  varchar(100) NOT NULL,
    `email`     varchar(255) NOT NULL,
    `password`  varchar(255) NOT NULL,
    `avatar`  varchar(255) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `avatar`)
VALUES ('Florian', 'Bouché', 'flo@immo.fr', '$2y$10$mtSWmjgceQAunIJ.TtYAS.c5oEjbaEeQE5vYIPZTql5HuNKr7Elxu', null),
       ('Yanis', 'Ghlis', 'yan@immo.fr', '$2y$10$mtSWmjgceQAunIJ.TtYAS.c5oEjbaEeQE5vYIPZTql5HuNKr7Elxu', null),
       ('Emilien', 'Gellaerts', 'emi@immo.fr', '$2y$10$mtSWmjgceQAunIJ.TtYAS.c5oEjbaEeQE5vYIPZTql5HuNKr7Elxu', null),
       ('Sabrina', 'Si Hadj Mohand', 'sab@immo.fr', '$2y$10$mtSWmjgceQAunIJ.TtYAS.c5oEjbaEeQE5vYIPZTql5HuNKr7Elxu', null);

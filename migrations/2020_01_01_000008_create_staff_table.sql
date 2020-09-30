CREATE TABLE IF NOT EXISTS `staff`
(
    `id`        INT          NOT NULL AUTO_INCREMENT,
    `firstname` varchar(50)  NOT NULL,
    `lastname`  varchar(100) NOT NULL,
    `function`  varchar(255) NOT NULL,
    `salary`    FLOAT        NOT NULL,
    `status`    int(11)      NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `staff` (`firstname`, `lastname`, `function`, `salary`, `status`)
VALUES ('John', 'OMAR', 'Co-gérant', 4200, 1),
       ('Elena', 'MORGAN', 'Secrétaire', 4200, 1),
       ('Michael', 'STEWART', 'Co-gérant', 2600, 1),
       ('Richard', 'DUPOND', 'Comptable', 3200, 1),
       ('Paul', 'DOPURI', 'Agent', 2800, 1),
       ('Mohammed', 'CHOURAH', 'Agent', 2800, 1),
       ('Catherine', 'TARVA', 'Agent', 2800, 1);

CREATE TABLE IF NOT EXISTS `events`
(
    `id`         INT     NOT NULL AUTO_INCREMENT,
    `name`       varchar(255),
    `type`       INT(11) NOT NULL,
    `date_start` DATE    NOT NULL,
    `date_end`   DATE    NOT NULL,
    `time_start` TIME,
    `time_end`   TIME,
    `user_id`    INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES staff (`id`)
) ENGINE = InnoDB;

INSERT INTO `events` (`user_id`, `type`, `name`, `date_start`, `date_end`, `time_start`, `time_end`)
VALUES (1, 0, 'Work', '2020-05-01', '2020-01-05', '14:00', '16:00'),
       (2, 1, 'Conférence', '2020-09-28', '2020-09-28', '10:00', '12:00'),
       (3, 1, 'Inauguration de la filiale EFYS-PARIS', '2020-09-25', '2020-09-25', '10:00', '12:00');

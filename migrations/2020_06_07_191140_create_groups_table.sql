CREATE TABLE IF NOT EXISTS `groups`
(
    id   int auto_increment,
    name varchar(50) not null,
    primary key (`id`)
);

insert into `groups` (name)
values ('Administrateurs'),
       ('Modérateurs');

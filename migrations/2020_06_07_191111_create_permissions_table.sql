CREATE TABLE IF NOT EXISTS `permissions`
(
    id   int auto_increment,
    name varchar(50) not null,
    primary key (`id`)
);

insert into `permissions` (name)
values ('announcements.index'),
       ('announcements.add'),
       ('announcements.edit'),
       ('announcements.delete'),
       ('batches.index'),
       ('batches.add'),
       ('batches.edit'),
       ('batches.delete'),
       ('events.index'),
       ('events.add'),
       ('events.edit'),
       ('events.delete'),
       ('groups.index'),
       ('groups.add'),
       ('groups.edit'),
       ('groups.delete'),
       ('pages.index'),
       ('pages.add'),
       ('pages.edit'),
       ('pages.delete'),
       ('owners.index'),
       ('owners.add'),
       ('owners.edit'),
       ('owners.delete'),
       ('settings.index'),
       ('settings.add'),
       ('settings.edit'),
       ('settings.delete'),
       ('users.index'),
       ('users.add'),
       ('users.edit'),
       ('users.delete'),
       ('administration.index'),
       ('administration.search'),
       ('staff.index'),
       ('staff.add'),
       ('staff.edit'),
       ('staff.delete'),
       ('medias.index'),
       ('medias.upload'),
       ('medias.delete');

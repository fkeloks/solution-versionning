CREATE TABLE IF NOT EXISTS `groups_permissions`
(
    id            int auto_increment,
    group_id      int not null,
    permission_id int not null,
    primary key (`id`),
    foreign key (`group_id`) references `groups` (`id`),
    foreign key (`permission_id`) references `permissions` (`id`)
);

insert into `groups_permissions` (group_id, permission_id)
values (1, 9),  # Administrateurs - events.index
       (1, 10), # Administrateurs - events.add
       (1, 11), # Administrateurs - events.edit
       (1, 12), # Administrateurs - events.delete
       (1, 13), # Administrateurs - groups.index
       (1, 14), # Administrateurs - groups.add
       (1, 15), # Administrateurs - groups.edit
       (1, 16), # Administrateurs - groups.delete
       (1, 17), # Administrateurs - pages.index
       (1, 18), # Administrateurs - pages.add
       (1, 19), # Administrateurs - pages.edit
       (1, 20), # Administrateurs - pages.delete
       (1, 21), # Administrateurs - owners.index
       (1, 22), # Administrateurs - owners.add
       (1, 23), # Administrateurs - owners.edit
       (1, 24), # Administrateurs - owners.delete
       (1, 25), # Administrateurs - settings.index
       (1, 26), # Administrateurs - settings.add
       (1, 27), # Administrateurs - settings.edit
       (1, 28), # Administrateurs - settings.delete
       (1, 29), # Administrateurs - users.index
       (1, 30), # Administrateurs - users.add
       (1, 31), # Administrateurs - users.edit
       (1, 32), # Administrateurs - users.delete
       (1, 34), # Administrateurs - administration.search
       (1, 35), # Administrateurs - staff.index
       (1, 36), # Administrateurs - staff.add
       (1, 37), # Administrateurs - staff.edit
       (1, 38), # Administrateurs - staff.delete
       (1, 39), # Administrateurs - medias.index
       (1, 40), # Administrateurs - medias.upload
       (1, 41); # Administrateurs - medias.delete

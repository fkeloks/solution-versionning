alter table `properties`
    add `user_id` int not null default 1;

alter table `properties`
    add foreign key (`user_id`) references `users` (`id`);

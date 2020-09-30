alter table `users`
    add group_id int null;

update `users`
set group_id = 1;

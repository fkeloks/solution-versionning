alter table `announcements`
    add status int null default 0;

update `announcements`
set status = 1
where id <= 3
   or id >= 7;

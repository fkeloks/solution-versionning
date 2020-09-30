ALTER TABLE `announcements`
    ADD FULLTEXT (description);

ALTER TABLE `events`
    ADD FULLTEXT (`name`);

ALTER TABLE `groups`
    ADD FULLTEXT (`name`);

ALTER TABLE `staff`
    ADD FULLTEXT (firstname, lastname, function);

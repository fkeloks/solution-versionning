ALTER TABLE `owners`
    ADD FULLTEXT (lastname, firstname, mail, address, phone);

ALTER TABLE `properties`
    ADD FULLTEXT (address);

ALTER TABLE `pages`
    ADD FULLTEXT (title);

ALTER TABLE `users`
    ADD FULLTEXT (lastname, firstname, email);

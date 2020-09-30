alter table `users`
    add `email_confirmation_token` varchar(75) null,
    add `email_confirmed`          int         not null default 0;

update `users`
set email_confirmed = 1;

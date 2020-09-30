ALTER TABLE `modules`
    ADD locked TINYINT DEFAULT 0,
    MODIFY `page_id` INT(11) NULL;

DELETE FROM `modules` WHERE `name` = 'header';
INSERT INTO `modules` (`page_id`, `name`, `order`, `content`, `locked`) VALUES
(NULL, 'header', 1, '{\"links\": [{\"link\": \"/\", \"label\": \"Accueil\"}, {\"link\": \"/annonces\", \"label\": \"Annonces\"}, {\"link\": \"/contactez-nous\", \"label\": \"Contact\"}, {\"link\": \"/estimation\", \"label\": \"Estimation\"},{\"link\": \"/qui-sommes-nous\", \"label\": \"Qui sommes-nous ?\"}]}', 1);

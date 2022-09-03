#
#<?php die('Forbidden.'); ?>
#Date: 2022-09-03 10:13:47 UTC
#Software: Joomla! 4.1.5 Stable [ Kuamini ] 21-June-2022 14:00 GMT

#Fields: datetime	priority clientip	category	message
2022-09-03T10:13:47+00:00	INFO 83.246.166.93	update	Обновление запущено пользователем BankiAdmin (ID 158). Предыдущая версия: 4.1.5
2022-09-03T10:13:49+00:00	INFO 83.246.166.93	update	Загрузка пакета обновления: https://s3-us-west-2.amazonaws.com/joomla-official-downloads/joomladownloads/joomla4/Joomla_4.2.2-Stable-Update_Package.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIA6LXDJLNUINX2AVMH%2F20220903%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20220903T101410Z&X-Amz-Expires=60&X-Amz-SignedHeaders=host&X-Amz-Signature=be1638936bda0cfbc99c97f669e1de00a3a3dee3fdd8ef3255b2e5f56667255e
2022-09-03T10:13:56+00:00	INFO 83.246.166.93	update	Файл Joomla_4.2.2-Stable-Update_Package.zip загружен
2022-09-03T10:13:56+00:00	INFO 83.246.166.93	update	Начало установки новой версии
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Завершение установки
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Начало обновления SQL
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Версия базы данных (#__schemas): 4.1.3-2022-04-08
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: CREATE TABLE IF NOT EXISTS `#__user_mfa` (   `id` int NOT NULL AUTO_INCREMENT,  
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: DELETE FROM `#__postinstall_messages` WHERE `condition_file` = 'site://plugins/t
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, 
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: UPDATE `#__extensions` AS `a` 	INNER JOIN `#__extensions` AS `b` on `a`.`element
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: DELETE FROM `#__extensions` WHERE `type` = 'plugin' AND `folder` = 'twofactoraut
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: INSERT IGNORE INTO `#__postinstall_messages` (`extension_id`, `title_key`, `desc
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-05-15: INSERT IGNORE INTO `#__mail_templates` (`template_id`, `extension`, `language`, 
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-06-15: ALTER TABLE `#__mail_templates` MODIFY `htmlbody` mediumtext NOT NULL COLLATE 'u
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-06-19: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, 
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.0-2022-06-22: UPDATE `#__extensions` SET `locked` = 1 WHERE  (`type` = 'plugin' AND     (     
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Выполнен запрос из файла 4.2.1-2022-08-23: DELETE FROM `#__extensions` WHERE `name` = 'plg_fields_menuitem' AND `type` = 'p
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Завершение обновления SQL
2022-09-03T10:14:02+00:00	INFO 83.246.166.93	update	Удаление устаревших файлов и каталогов
2022-09-03T10:14:03+00:00	INFO 83.246.166.93	update	Очистка после установки
2022-09-03T10:14:03+00:00	INFO 83.246.166.93	update	Обновление до версии 4.2.2 завершено

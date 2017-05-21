#2017-05-21
ALTER TABLE `tv_track`.`series` 
ADD COLUMN `download_link` TEXT NULL AFTER `day_new_episode`,
ADD COLUMN `subtitles_link` TEXT NULL AFTER `download_link`;

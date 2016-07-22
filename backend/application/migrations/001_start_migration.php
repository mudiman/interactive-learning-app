<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_start_migration extends CI_Migration {

    public function up() {
                
        $sql = "CREATE  TABLE IF NOT EXISTS `gomadkids`.`books` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NULL ,
  `author_name` VARCHAR(1000) NULL ,
  `json` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;";
        $this -> db -> query($sql);

        $sql = "CREATE  TABLE IF NOT EXISTS `gomadkids`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(1000) NULL ,
  `email` VARCHAR(1000) NULL ,
  `password` VARCHAR(1000) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;";
        $this -> db -> query($sql);

        $sql = "CREATE  TABLE IF NOT EXISTS `gomadkids`.`pages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `books_id` INT NOT NULL ,
  `page_type` VARCHAR(100) NULL ,
  `page_no` INT NULL ,
  `title` VARCHAR(1000) NULL ,
  `image` VARCHAR(1000) NULL ,
  `body` TEXT NULL ,
  `click_positions` TEXT NULL ,
  `sound_file` TEXT NULL ,
  PRIMARY KEY (`id`, `books_id`) ,
  INDEX `fk_pages_books_idx` (`books_id` ASC) ,
  CONSTRAINT `fk_pages_books`
    FOREIGN KEY (`books_id` )
    REFERENCES `gomadkids`.`books` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;";
        $this -> db -> query($sql);

        $sql = "CREATE  TABLE IF NOT EXISTS `gomadkids`.`pagetypes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `types` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;";
        $this -> db -> query($sql);

        
        
        $insert = "ALTER TABLE books ADD UNIQUE (`name`);";
        $this -> db -> query($insert);
        
        $insert = "insert into users (`name`,`email`,`password`) values ('admin','admin@sovoia.com','admin324');";
        $this -> db -> query($insert);

        $insert = "insert into pagetypes (`types`) values ('COVER_PAGE'),('CONTENT_PAGE'),('QUIZ_PAGE'),('IMAGE_PAGE'),('CLICK_IMAGE_PAGE');";
        $this -> db -> query($insert);

    }

    public function down() {
        ### Drop table activity ##
        $this -> dbforge -> drop_column('activity', 'archive');
    }

}
?>

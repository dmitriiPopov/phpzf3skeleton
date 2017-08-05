<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170804190823 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     *
     * run: ./vendor/bin/doctrine-module migrations:migrate
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

        /*
         CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT, artist varchar(100) NOT NULL, title varchar(100) NOT NULL);
INSERT INTO album (artist, title) VALUES ('The Military Wives', 'In My Dreams');
INSERT INTO album (artist, title) VALUES ('Adele', '21');
INSERT INTO album (artist, title) VALUES ('Bruce Springsteen', 'Wrecking Ball (Deluxe)');
INSERT INTO album (artist, title) VALUES ('Lana Del Rey', 'Born To Die');
INSERT INTO album (artist, title) VALUES ('Gotye', 'Making Mirrors');
         * */

        /*
CREATE TABLE `zend`.`album` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'List of albums';
         *
         * */

        $table = $schema->createTable('album');
        $table->addColumn('id', Type::INTEGER, ['length' => 11, 'unsigned' => true, 'notNull' => true, 'autoincrement' => true]);

        $table->setPrimaryKey(['id']);
        $table->addOption('ENGINE', 'InnoDB');
        $table->addOption('COLLATE', 'utf8_general_ci');
        $table->addOption('COMMENT', 'List of albums');

    }

    /**
     * @param Schema $schema
     *
     *
     * Run: ./vendor/bin/doctrine-module migrations:execute --down 20170804190823
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('album');

    }
}

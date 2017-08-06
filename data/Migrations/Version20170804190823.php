<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
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

        $table->addColumn(
            'id',
            Type::INTEGER,
            [
                'length'        => 11,
                'unsigned'      => true,
                'notNull'       => true,
                'autoincrement' => true,
                'comment'       => 'Unique identifier',
            ]
        );
        $table->addColumn(
            'artist',
            Type::STRING,
            [
                'length'  => 100,
                'notNull' => true,
                'comment' => 'Artist name',
            ]
        );
        $table->addColumn(
            'title',
            Type::STRING,
            [
                'length' => 100,
                'notNull' => true,
                'comment' => 'Album title',
            ]
        );

        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');//InnoDB or MYISAM
        $table->addOption('charset', 'utf8');//https://dev.mysql.com/doc/refman/5.5/en/charset-charsets.html
        $table->addOption('collate', 'utf8_general_ci');//https://dev.mysql.com/doc/refman/5.5/en/charset-charsets.html
        $table->addOption('comment', 'List of albums');


    }

    public function postUp(Schema $schema)
    {
        parent::postUp($schema);

        //insert data
        //http://jcfiala.net/blog/2014/08/29/using-doctrine-migrations-part-2-adding-data-migration
        $this->connection->executeQuery("
            INSERT INTO album (artist, title) VALUES ('The Military Wives', 'In My Dreams');
            INSERT INTO album (artist, title) VALUES ('Adele', '21');
            INSERT INTO album (artist, title) VALUES ('Bruce Springsteen', 'Wrecking Ball (Deluxe)');
            INSERT INTO album (artist, title) VALUES ('Lana Del Rey', 'Born To Die');
            INSERT INTO album (artist, title) VALUES ('Gotye', 'Making Mirrors');
        ");

        $this->connection->executeQuery('
          INSERT INTO album (artist, title)
VALUES
    ("David Bowie", "The Next Day (Deluxe Version)"),
    ("Bastille", "Bad Blood"),
    ("Bruno Mars", "Unorthodox Jukebox"),
    ("Emeli Sandé", "Our Version of Events (Special Edition)"),
    ("Bon Jovi", "What About Now (Deluxe Version)"),
    ("Justin Timberlake", "The 20/20 Experience (Deluxe Version)"),
    ("Bastille", "Bad Blood (The Extended Cut)"),
    ("P!nk", "The Truth About Love"),
    ("Sound City - Real to Reel", "Sound City - Real to Reel"),
    ("Jake Bugg", "Jake Bugg"),
    ("Various Artists", "The Trevor Nelson Collection"),
    ("David Bowie", "The Next Day"),
    ("Mumford & Sons", "Babel"),
    ("The Lumineers", "The Lumineers"),
    ("Various Artists", "Get Ur Freak On - R&B Anthems"),
    ("The 1975", "Music For Cars EP"),
    ("Various Artists", "Saturday Night Club Classics - Ministry of Sound"),
    ("Hurts", "Exile (Deluxe)"),
    ("Various Artists", "Mixmag - The Greatest Dance Tracks of All Time"),
    ("Ben Howard", "Every Kingdom"),
    ("Stereophonics", "Graffiti On the Train"),
    ("The Script", "#3"),
    ("Stornoway", "Tales from Terra Firma"),
    ("David Bowie", "Hunky Dory (Remastered)"),
    ("Worship Central", "Let It Be Known (Live)"),
    ("Ellie Goulding", "Halcyon"),
    ("Various Artists", "Dermot O\'Leary Presents the Saturday Sessions 2013"),
    ("Stereophonics", "Graffiti On the Train (Deluxe Version)"),
    ("Dido", "Girl Who Got Away (Deluxe)"),
    ("Hurts", "Exile"),
    ("Bruno Mars", "Doo-Wops & Hooligans"),
    ("Calvin Harris", "18 Months"),
    ("Olly Murs", "Right Place Right Time"),
    ("Alt-J (?)", "An Awesome Wave"),
    ("One Direction", "Take Me Home"),
    ("Various Artists", "Pop Stars"),
    ("Various Artists", "Now That\'s What I Call Music! 83"),
    ("John Grant", "Pale Green Ghosts"),
    ("Paloma Faith", "Fall to Grace"),
    ("Laura Mvula", "Sing To the Moon (Deluxe)"),
    ("Duke Dumont", "Need U (100%) [feat. A*M*E] - EP"),
    ("Watsky", "Cardboard Castles"),
    ("Blondie", "Blondie: Greatest Hits"),
    ("Foals", "Holy Fire"),
    ("Maroon 5", "Overexposed"),
    ("Bastille", "Pompeii (Remixes) - EP"),
    ("Imagine Dragons", "Hear Me - EP"),
    ("Various Artists", "100 Hits: 80s Classics"),
    ("Various Artists", "Les Misérables (Highlights From the Motion Picture Soundtrack)"),
    ("Mumford & Sons", "Sigh No More"),
    ("Frank Ocean", "Channel ORANGE"),
    ("Bon Jovi", "What About Now"),
    ("Various Artists", "BRIT Awards 2013"),
    ("Taylor Swift", "Red"),
    ("Fleetwood Mac", "Fleetwood Mac: Greatest Hits"),
    ("David Guetta", "Nothing But the Beat Ultimate"),
    ("Various Artists", "Clubbers Guide 2013 (Mixed By Danny Howard) - Ministry of Sound"),
    ("David Bowie", "Best of Bowie"),
    ("Laura Mvula", "Sing To the Moon"),
    ("ADELE", "21"),
    ("Of Monsters and Men", "My Head Is an Animal"),
    ("Rihanna", "Unapologetic"),
    ("Various Artists", "BBC Radio 1\'s Live Lounge - 2012"),
    ("Avicii & Nicky Romero", "I Could Be the One (Avicii vs. Nicky Romero)"),
    ("The Streets", "A Grand Don\'t Come for Free"),
    ("Tim McGraw", "Two Lanes of Freedom"),
    ("Foo Fighters", "Foo Fighters: Greatest Hits"),
    ("Various Artists", "Now That\'s What I Call Running!"),
    ("Swedish House Mafia", "Until Now"),
    ("The xx", "Coexist"),
    ("Five", "Five: Greatest Hits"),
    ("Jimi Hendrix", "People, Hell & Angels"),
    ("Biffy Clyro", "Opposites (Deluxe)"),
    ("The Smiths", "The Sound of the Smiths"),
    ("The Saturdays", "What About Us - EP"),
    ("Fleetwood Mac", "Rumours"),
    ("Various Artists", "The Big Reunion"),
    ("Various Artists", "Anthems 90s - Ministry of Sound"),
    ("The Vaccines", "Come of Age"),
    ("Nicole Scherzinger", "Boomerang (Remixes) - EP"),
    ("Bob Marley", "Legend (Bonus Track Version)"),
    ("Josh Groban", "All That Echoes"),
    ("Blue", "Best of Blue"),
    ("Ed Sheeran", "+"),
    ("Olly Murs", "In Case You Didn\'t Know (Deluxe Edition)"),
    ("Macklemore & Ryan Lewis", "The Heist (Deluxe Edition)"),
    ("Various Artists", "Defected Presents Most Rated Miami 2013"),
    ("Gorgon City", "Real EP"),
    ("Mumford & Sons", "Babel (Deluxe Version)"),
    ("Various Artists", "The Music of Nashville: Season 1, Vol. 1 (Original Soundtrack)"),
    ("Various Artists", "The Twilight Saga: Breaking Dawn, Pt. 2 (Original Motion Picture Soundtrack)"),
    ("Various Artists", "Mum - The Ultimate Mothers Day Collection"),
    ("One Direction", "Up All Night"),
    ("Bon Jovi", "Bon Jovi Greatest Hits"),
    ("Agnetha Fältskog", "A"),
    ("Fun.", "Some Nights"),
    ("Justin Bieber", "Believe Acoustic"),
    ("Atoms for Peace", "Amok"),
    ("Justin Timberlake", "Justified"),
    ("Passenger", "All the Little Lights"),
    ("Kodaline", "The High Hopes EP"),
    ("Lana Del Rey", "Born to Die"),
    ("JAY Z & Kanye West", "Watch the Throne (Deluxe Version)"),
    ("Biffy Clyro", "Opposites"),
    ("Various Artists", "Return of the 90s"),
    ("Gabrielle Aplin", "Please Don\'t Say You Love Me - EP"),
    ("Various Artists", "100 Hits - Driving Rock"),
    ("Jimi Hendrix", "Experience Hendrix - The Best of Jimi Hendrix"),
    ("Various Artists", "The Workout Mix 2013"),
    ("The 1975", "Sex"),
    ("Chase & Status", "No More Idols"),
    ("Rihanna", "Unapologetic (Deluxe Version)"),
    ("The Killers", "Battle Born"),
    ("Olly Murs", "Right Place Right Time (Deluxe Edition)"),
    ("A$AP Rocky", "LONG.LIVE.A$AP (Deluxe Version)"),
    ("Various Artists", "Cooking Songs"),
    ("Haim", "Forever - EP"),
    ("Lianne La Havas", "Is Your Love Big Enough?"),
    ("Michael Bublé", "To Be Loved"),
    ("Daughter", "If You Leave"),
    ("The xx", "xx"),
    ("Eminem", "Curtain Call"),
    ("Kendrick Lamar", "good kid, m.A.A.d city (Deluxe)"),
    ("Disclosure", "The Face - EP"),
    ("Palma Violets", "180"),
    ("Cody Simpson", "Paradise"),
    ("Ed Sheeran", "+ (Deluxe Version)"),
    ("Michael Bublé", "Crazy Love (Hollywood Edition)"),
    ("Bon Jovi", "Bon Jovi Greatest Hits - The Ultimate Collection"),
    ("Rita Ora", "Ora"),
    ("g33k", "Spabby"),
    ("Various Artists", "Annie Mac Presents 2012"),
    ("David Bowie", "The Platinum Collection"),
    ("Bridgit Mendler", "Ready or Not (Remixes) - EP"),
    ("Dido", "Girl Who Got Away"),
    ("Various Artists", "Now That\'s What I Call Disney"),
    ("The 1975", "Facedown - EP"),
    ("Kodaline", "The Kodaline - EP"),
    ("Various Artists", "100 Hits: Super 70s"),
    ("Fred V & Grafix", "Goggles - EP"),
    ("Biffy Clyro", "Only Revolutions (Deluxe Version)"),
    ("Train", "California 37"),
    ("Ben Howard", "Every Kingdom (Deluxe Edition)"),
    ("Various Artists", "Motown Anthems"),
    ("Courteeners", "ANNA"),
    ("Johnny Marr", "The Messenger"),
    ("Rodriguez", "Searching for Sugar Man"),
    ("Jessie Ware", "Devotion"),
    ("Bruno Mars", "Unorthodox Jukebox"),
    ("Various Artists", "Call the Midwife (Music From the TV Series)"
);
        ');
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

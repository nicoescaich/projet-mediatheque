<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503111936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, office_num INT DEFAULT NULL, service VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, employee_id INT DEFAULT NULL, reader_id INT DEFAULT NULL, product_id INT DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, real_end_date DATE DEFAULT NULL, delay INT DEFAULT NULL, INDEX IDX_C5D30D038C03F15C (employee_id), INDEX IDX_C5D30D031717D737 (reader_id), INDEX IDX_C5D30D034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, author VARCHAR(255) DEFAULT NULL, support VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, reader_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, product_id INT DEFAULT NULL, purchase_date DATE DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, INDEX IDX_6117D13B1717D737 (reader_id), INDEX IDX_6117D13B8C03F15C (employee_id), UNIQUE INDEX UNIQ_6117D13B4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reader (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, sub_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_CC3F893CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommandation (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, reader_id INT DEFAULT NULL, INDEX IDX_C7782A284584665A (product_id), INDEX IDX_C7782A281717D737 (reader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, administrator TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D038C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D031717D737 FOREIGN KEY (reader_id) REFERENCES reader (id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B1717D737 FOREIGN KEY (reader_id) REFERENCES reader (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE reader ADD CONSTRAINT FK_CC3F893CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recommandation ADD CONSTRAINT FK_C7782A284584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE recommandation ADD CONSTRAINT FK_C7782A281717D737 FOREIGN KEY (reader_id) REFERENCES reader (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D038C03F15C');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B8C03F15C');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D034584665A');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B4584665A');
        $this->addSql('ALTER TABLE recommandation DROP FOREIGN KEY FK_C7782A284584665A');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D031717D737');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B1717D737');
        $this->addSql('ALTER TABLE recommandation DROP FOREIGN KEY FK_C7782A281717D737');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A76ED395');
        $this->addSql('ALTER TABLE reader DROP FOREIGN KEY FK_CC3F893CA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE reader');
        $this->addSql('DROP TABLE recommandation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

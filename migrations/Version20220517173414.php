<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517173414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D038C03F15C');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B8C03F15C');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D031717D737');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B1717D737');
        $this->addSql('ALTER TABLE recommandation DROP FOREIGN KEY FK_C7782A281717D737');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE reader');
        $this->addSql('DROP TABLE recommandation');
        $this->addSql('DROP INDEX IDX_C5D30D031717D737 ON loan');
        $this->addSql('DROP INDEX IDX_C5D30D038C03F15C ON loan');
        $this->addSql('ALTER TABLE loan ADD user_id INT NOT NULL, DROP employee_id, DROP reader_id');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C5D30D03A76ED395 ON loan (user_id)');
        $this->addSql('DROP INDEX IDX_6117D13B1717D737 ON purchase');
        $this->addSql('DROP INDEX IDX_6117D13B8C03F15C ON purchase');
        $this->addSql('ALTER TABLE purchase ADD user_id INT NOT NULL, DROP reader_id, DROP employee_id');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6117D13BA76ED395 ON purchase (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, office_num INT DEFAULT NULL, service VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_5D9F75A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reader (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, sub_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_CC3F893CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recommandation (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, reader_id INT DEFAULT NULL, INDEX IDX_C7782A281717D737 (reader_id), INDEX IDX_C7782A284584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reader ADD CONSTRAINT FK_CC3F893CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recommandation ADD CONSTRAINT FK_C7782A281717D737 FOREIGN KEY (reader_id) REFERENCES reader (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recommandation ADD CONSTRAINT FK_C7782A284584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03A76ED395');
        $this->addSql('DROP INDEX IDX_C5D30D03A76ED395 ON loan');
        $this->addSql('ALTER TABLE loan ADD employee_id INT DEFAULT NULL, ADD reader_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D031717D737 FOREIGN KEY (reader_id) REFERENCES reader (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D038C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C5D30D031717D737 ON loan (reader_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D038C03F15C ON loan (employee_id)');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA76ED395');
        $this->addSql('DROP INDEX IDX_6117D13BA76ED395 ON purchase');
        $this->addSql('ALTER TABLE purchase ADD reader_id INT DEFAULT NULL, ADD employee_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B1717D737 FOREIGN KEY (reader_id) REFERENCES reader (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6117D13B1717D737 ON purchase (reader_id)');
        $this->addSql('CREATE INDEX IDX_6117D13B8C03F15C ON purchase (employee_id)');
    }
}

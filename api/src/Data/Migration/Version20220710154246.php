<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220710154246 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, role SMALLINT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".email IS \'(DC2Type:auth_user_email)\'');
        $this->addSql('COMMENT ON COLUMN "user".status IS \'(DC2Type:auth_user_status)\'');
        $this->addSql('COMMENT ON COLUMN "user".role IS \'(DC2Type:auth_user_role)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE transaction (id UUID NOT NULL, wallet_id UUID NOT NULL, transaction_id UUID DEFAULT NULL, created_by UUID NOT NULL, type SMALLINT NOT NULL, amount INT NOT NULL, status SMALLINT NOT NULL, confirmed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1712520F3 ON transaction (wallet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_723705D12FC0CB0F ON transaction (transaction_id)');
        $this->addSql('CREATE INDEX IDX_723705D1DE12AB56 ON transaction (created_by)');
        $this->addSql('COMMENT ON COLUMN transaction.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transaction.wallet_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transaction.transaction_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transaction.created_by IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN transaction.type IS \'(DC2Type:wallet_transaction_type)\'');
        $this->addSql('COMMENT ON COLUMN transaction.amount IS \'(DC2Type:amount)\'');
        $this->addSql('COMMENT ON COLUMN transaction.status IS \'(DC2Type:wallet_transaction_status)\'');
        $this->addSql('COMMENT ON COLUMN transaction.confirmed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transaction.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transaction.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE wallet (id UUID NOT NULL, user_id UUID NOT NULL, owner_type SMALLINT NOT NULL, type SMALLINT NOT NULL, balance INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C68921FA76ED395 ON wallet (user_id)');
        $this->addSql('COMMENT ON COLUMN wallet.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN wallet.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN wallet.owner_type IS \'(DC2Type:wallet_wallet_owner_type)\'');
        $this->addSql('COMMENT ON COLUMN wallet.type IS \'(DC2Type:wallet_wallet_type)\'');
        $this->addSql('COMMENT ON COLUMN wallet.balance IS \'(DC2Type:amount)\'');
        $this->addSql('COMMENT ON COLUMN wallet.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN wallet.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D12FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1DE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1DE12AB56');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921FA76ED395');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D12FC0CB0F');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1712520F3');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE wallet');
    }
}

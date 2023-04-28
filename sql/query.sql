CREATE TABLE IF NOT EXISTS accounts (
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(100) NOT NULL,
    PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
    
INSERT INTO accounts (id,username,password,email) VALUES (1,"paolo","123456","berlanda.paolo@gmail.com");

-- aggiunta colonne per nome e cognome
alter table accounts add COLUMN nome varchar(30) not null;
alter table accounts add COLUMN cognome varchar(30) not null

-- aggiunta data di nascita
alter table accounts add COLUMN data_nascita datetime null

update accounts set data_nascita = '1976-12-17' where username = 'paolo'

alter TABLE accounts MODIFY data_nascita DATETIME NOT NULL

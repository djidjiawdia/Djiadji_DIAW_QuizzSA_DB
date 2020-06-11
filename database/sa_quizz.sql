CREATE TABLE role(
	id_role INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	libelle VARCHAR(50) NOT NULL
);

CREATE TABLE user (
	id_user INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	prenom VARCHAR(50) NOT NULL,
	nom VARCHAR(50) NOT NULL,
	login VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	avatar VARCHAR(255) NOT NULL,
	score INT DEFAULT NULL,
	statut TINYINT DEFAULT 0,
	id_role INT(11) NOT NULL,
	FOREIGN KEY (id_role) REFERENCES role(id_role) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE question (
	id_question INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	type VARCHAR(50) NOT NULL,
	question TEXT NOT NULL,
	point INT NOT NULL
);

CREATE TABLE response (
	id_response INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	reponse TEXT NOT NULL,
	coorect TINYINT NOT NULL DEFAULT 0,
	id_question INT(11) NOT NULL,
	FOREIGN KEY (id_question) REFERENCES question(id_question) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE jeu (
	id_jeu INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nbr_question INT(11) NOT NULL DEFAULT 5
);

CREATE TABLE trouver (
	id_user INT(11) NOT NULL,
	id_question INT(11) NOT NULL,
	FOREIGN KEY (id_question) REFERENCES question(id_question) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_user) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
)
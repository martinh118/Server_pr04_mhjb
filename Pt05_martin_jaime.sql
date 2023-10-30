CREATE DATABASE IF NOT EXISTS `pt05_martin_jaime`;
USE `pt05_martin_jaime`;

CREATE TABLE IF NOT EXISTS `articles`(
    ID MEDIUMINT NOT NULL,
    article text NOT NULL,
    autor text NOT NULL,
    PRIMARY KEY (ID)
);


CREATE TABLE IF NOT EXISTS `users`(
    ID MEDIUMINT NOT NULL AUTO_INCREMENT,
    nom_usuari text NOT NULL,
    email_usuari text NOT NULL,
    contra VARCHAR(512) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO `articles`(`ID`, `article`, `autor`) VALUES 
(1,'Voy a hacerle una oferta que no podrá rechazar', 'public'),
(2,'Que la fuerza te acompañe', 'public'),
(3,'¿Hablas conmigo?', 'public'),
(4,'Qué delicia oler napalm por la mañana', 'public'),
(5,'E.T., teléfono, mi casa', 'public'),
(6,'¿Es dura la experiencia de vivir con miedo, verdad? En eso consiste ser esclavo', 'public'),
(7,'Puede que no sea muy listo, pero sé lo que es el amor', 'public'),
(8,'La vida no es más que un interminable ensayo, de una obra que jamás se va a estrenar', 'public'),
(9,'Oh, sí... El pasado puede doler, pero tal como yo lo veo puedes huir de él o aprender', 'public'),
(10,'Pensamos demasiado y sentimos muy poco…', 'public'),
(11,'Sólo tú puedes decidir qué hacer con el tiempo que se te ha dado', 'public'),
(12,'No son las habilidades lo que demuestra lo que somos, son nuestras decisiones', 'public'),
(13,'Sigue nadando', 'public'),
(14,'Mi conclusión es que el odio es un lastre. La vida es demasiado corta para estar siempre cabreado', 'public'),
(15,'Todas las oportunidades marcan el transcurso de nuestra vida, incluso las que dejamos ir', 'public'),
(16,'La muerte nos sonríe a todos. Devolvámosle la sonrisa', 'public'),
(17,'No es un problema grave si no lo conviertes en un problema grave', 'public'),
(18,'Por muy dura que nos parezca la vida, mientras haya vida hay esperanza', 'public'),
(19,'Alicia, no puedes vivir complaciendo a otros, la decisión es completamente tuya', 'public'),
(20,'Lo único que está entre tu meta y tú, es la historia que te sigues contando a ti mismo de por qué no puedes lograrla', 'public'),
(21,'¿Cauntas bombillas harán falta para cambiar a un electricista de su puesto de trabajo?', 'public');

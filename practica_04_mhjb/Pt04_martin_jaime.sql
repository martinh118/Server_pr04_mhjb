CREATE DATABASE IF NOT EXISTS `pt04_martin_jaime`;
USE `pt04_martin_jaime`;

CREATE TABLE IF NOT EXISTS `articles`(
    ID MEDIUMINT NOT NULL,
    article text NOT NULL,
    PRIMARY KEY (ID)
);


CREATE TABLE IF NOT EXISTS `users`(
    ID MEDIUMINT NOT NULL,
    nom_usuari text NOT NULL,
    email_usuari text NOT NULL,
    contra VARCHAR(512) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO `articles`(`ID`, `article`) VALUES 
(1,'Voy a hacerle una oferta que no podrá rechazar'),
(2,'Que la fuerza te acompañe'),
(3,'¿Hablas conmigo?'),
(4,'Qué delicia oler napalm por la mañana'),
(5,'E.T., teléfono, mi casa'),
(6,'¿Es dura la experiencia de vivir con miedo, verdad? En eso consiste ser esclavo'),
(7,'Puede que no sea muy listo, pero sé lo que es el amor'),
(8,'La vida no es más que un interminable ensayo, de una obra que jamás se va a estrenar'),
(9,'Oh, sí... El pasado puede doler, pero tal como yo lo veo puedes huir de él o aprender'),
(10,'Pensamos demasiado y sentimos muy poco…'),
(11,'Sólo tú puedes decidir qué hacer con el tiempo que se te ha dado'),
(12,'No son las habilidades lo que demuestra lo que somos, son nuestras decisiones'),
(13,'Sigue nadando'),
(14,'Mi conclusión es que el odio es un lastre. La vida es demasiado corta para estar siempre cabreado'),
(15,'Todas las oportunidades marcan el transcurso de nuestra vida, incluso las que dejamos ir'),
(16,'La muerte nos sonríe a todos. Devolvámosle la sonrisa'),
(17,'No es un problema grave si no lo conviertes en un problema grave'),
(18,'Por muy dura que nos parezca la vida, mientras haya vida hay esperanza'),
(19,'Alicia, no puedes vivir complaciendo a otros, la decisión es completamente tuya'),
(20,'Lo único que está entre tu meta y tú, es la historia que te sigues contando a ti mismo de por qué no puedes lograrla'),
(21,'¿Cauntas bombillas harán falta para cambiar a un electricista de su puesto de trabajo?');

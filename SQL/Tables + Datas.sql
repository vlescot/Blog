-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `author` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `id_post` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `comment` (`id`, `content`, `date_create`, `author`, `validated`, `id_post`) VALUES
(1,	'He come\'s the sun... tout doux tout doux',	'2018-04-22 11:08:58',	'Scarabée',	1,	2),
(2,	'Lorem adipisci eius cumque quasi voluptas iure?',	'2018-04-22 11:10:13',	'Alias',	1,	3),
(3,	'Iste, sapiente qui molestiae dicta quo.',	'2018-04-22 11:11:20',	'Aspernatur',	1,	3),
(4,	'Who moved my cheese fondue ?',	'2018-04-22 11:21:03',	'Peperoni',	1,	1);

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `reset_password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `date_create` timestamp NOT NULL,
  `id_type` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type` (`id_type`),
  KEY `login` (`login`),
  CONSTRAINT `member_ibfk_3` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `member` (`id`, `login`, `password`, `reset_password`, `email`, `validated`, `date_create`, `id_type`) VALUES
(1,	'root',	'e9b52d9d52eb6bac67cddccb039a78ef9dc7c576658e3cd6ef1e368cdee2e166f37ee4c2d6fd2be0d84fd76bf6e4220c7c436eaac013e396d80d323f57558a9d',	'',	'',	1,	'2018-03-19 23:00:00',	1),
(2,	'Visiteur',	'ba2745b18684715c45e4e8ced8618e3678b208cf6f8da5999f7ee90c613098fa8e09397d01a449de90d8e21ddaf94f2608bd6d14b56daffd9d109ddc0cd8eb7e',	'',	'',	1,	'2018-03-24 23:00:00',	2),
(3,	'NewMember',	'2e18d64c02bf7e44e4dbf66903bc881219b5f96d801a901f688954a1d3d21a98625c54796d4fa3cfb531e0210f3173704d51b7ff17f4bd2d8bc9fe9685ff4fed',	'',	'',	0,	'2018-04-10 10:52:21',	2),
(4,	'Vincent',	'ad820dc118b0ec968e3c0fe921c3116b71a7e20c6f0a3e45dabbc8efcf49de4c76bab479e32a6c3cce77fa65605ebba52f743dda1e3dbc8b29b0541e5ab90f93',	'',	'floyd-24@hotmail.com',	1,	'2018-04-12 17:05:12',	2);

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `lede` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `date_update` timestamp NOT NULL,
  `img` varchar(128) COLLATE latin1_general_ci NOT NULL,
  `id_member` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `post` (`id`, `title`, `lede`, `content`, `date_create`, `date_update`, `img`, `id_member`) VALUES
(1,	' Mon kit de survie en développement',	'Cheesy feet paneer caerphilly babybel jarlsberg mascarpone lancashire goat. ',	'<p>I love cheese, especially dolcelatte red leicester. Port-salut cheesy feet babybel stilton bavarian bergkase the big cheese hard cheese fromage frais. Cauliflower cheese lancashire fondue st. agur blue cheese hard cheese fondue cheese strings cauliflower cheese. Port-salut jarlsberg when the cheese comes out everybody\'s happy ricotta babybel stilton cheesecake who moved my cheese. Croque monsieur fromage fromage frais pecorino rubber cheese cow cauliflower cheese bocconcini. Rubber cheese roquefort fromage cheese strings halloumi.</p>\r\n<p>Croque monsieur taleggio melted cheese. Cheesy feet paneer caerphilly babybel jarlsberg mascarpone lancashire goat. Fondue cheese strings cheeseburger macaroni cheese fondue the big cheese monterey jack cheesy feet. Cheesy grin cottage cheese dolcelatte jarlsberg cheese on toast mascarpone taleggio caerphilly. Rubber cheese paneer ricotta cream cheese monterey jack bavarian bergkase babybel fromage. Macaroni cheese pepper jack lancashire brie rubber cheese cheese slices pepper jack cream cheese. Mozzarella the big cheese stinking bishop cheesy feet cheese and biscuits camembert de normandie cottage cheese cheeseburger. Fondue cheese and biscuits cheesy feet cheesy feet.</p>\r\n<p>Squirty cheese croque monsieur macaroni cheese. Lancashire cauliflower cheese swiss say cheese stilton cheese and wine chalk and cheese emmental. Red leicester cow pecorino jarlsberg mozzarella cheese and biscuits cheese slices cheesy grin. Camembert de normandie stinking bishop emmental cottage cheese cheese triangles cream cheese jarlsberg manchego. Cheeseburger chalk and cheese say cheese lancashire pepper jack feta cheese and biscuits cheese slices. Gouda cream cheese cheese on toast roquefort smelly cheese cheese strings the big cheese cheesecake. Fromage frais danish fontina bavarian bergkase cheesy grin pepper jack mozzarella.</p>\r\n<p>Ricotta boursin stilton. Bocconcini monterey jack dolcelatte babybel port-salut fromage frais brie squirty cheese. Bavarian bergkase dolcelatte bocconcini who moved my cheese camembert de normandie lancashire dolcelatte dolcelatte. Jarlsberg cheesy feet jarlsberg cheeseburger cheese triangles mascarpone cheese triangles mozzarella. The big cheese red leicester pecorino ricotta lancashire cheesecake stilton jarlsberg. Cheeseburger boursin gouda cheesy grin danish fontina smelly cheese macaroni cheese fromage. Fondue roquefort airedale feta stilton cut the cheese melted cheese halloumi. Cheesecake hard cheese stilton red leicester manchego queso.</p>\r\n<p>Ricotta airedale pecorino. Bavarian bergkase cheese and biscuits swiss cheddar manchego fondue hard cheese cheese strings. Airedale manchego cheese and biscuits squirty cheese pepper jack smelly cheese bocconcini squirty cheese. Melted cheese pecorino the big cheese melted cheese red leicester cauliflower cheese goat everyone loves. St. agur blue cheese taleggio caerphilly cheese on toast blue castello swiss cheese triangles pepper jack. St. agur blue cheese halloumi cauliflower cheese stinking bishop st. agur blue cheese bocconcini cheese strings who moved my cheese. Queso.</p>\r\n<p>Goat airedale who moved my cheese. Camembert de normandie paneer airedale cauliflower cheese danish fontina pepper jack who moved my cheese caerphilly. Who moved my cheese fondue pecorino ricotta when the cheese comes out everybody\'s happy the big cheese cheese strings emmental. Cheese and wine cheese on toast cheese triangles feta croque monsieur halloumi fromage ricotta. Cheeseburger cheesecake gouda rubber cheese gouda bocconcini cheese slices airedale. Roquefort goat chalk and cheese gouda paneer bavarian bergkase bavarian bergkase cheesecake. Port-salut cow hard cheese cottage cheese blue castello lancashire caerphilly.</p>\r\n<p>Cheese slices goat brie. Taleggio pepper jack hard cheese cheese and wine monterey jack port-salut taleggio port-salut. Airedale pecorino dolcelatte airedale feta edam monterey jack ricotta. Lancashire cottage cheese squirty cheese goat cottage cheese hard cheese lancashire cheesecake. Fondue edam cheese strings smelly cheese hard cheese red leicester manchego the big cheese. Paneer queso manchego cream cheese port-salut stilton cheese and wine when the cheese comes out everybody\'s happy. Cheeseburger cheesy feet paneer cheese strings cream cheese camembert de normandie gouda manchego. Hard cheese fondue squirty cheese cheesy grin.</p>',	'2018-04-22 10:10:37',	'2018-04-22 10:10:37',	'5651709c905b0692b221e885362add1a.jpg',	4),
(2,	'Développer en musique',	'Because the world is round',	'<p><a href=\"https://www.youtube.com/channel/UC8butISFwT-Wl7EV0hUK0BQ\">Go and Listen to the FreeCodeCamp Channel !</a></p>\r\n<p>Because the world is round. Has left a pool of tears. Oh, I believe in yesterday. Crying for the day. That the rain washed away. Because the world is round. Come on and work it on out (work it on out). Well, shake it up, baby, now (shake it up, baby). You know, you look so good (look so good). Will never disappear. You know, you got me goin\' now (got me goin\'). Twist and shout (twist and shout). Aaaaaaah-aaah. Aaaaaaah-aaah. There\'s a shadow hanging over me</p>\r\n<p>Shine like an electric light to where you are. The night that sets us free is nothing but a dream. Frightening the crowd. Underground. Come on everyone. I\'ve been dreaming ever since I\'ve seen you, heaven when you came my way. And we shout. With more fire power. Always something deeper. And he barks like a dog and he looks at me and says. We were getting round. You and me, we\'d run away to be wherever our adventure waits. Shining so far away in Hollywood. But what\'s this</p>\r\n<p>Come on, let\'s be the paragon of arrogance. Everyone\'s time come, sometime come. You can\'t solve problems with firepower. Have a gun. Shadow\'s in the fog. You remind me now and then, I\'m born again with you. Girl, I say, if only our life would lean our way. There\'s a man over there with a banana in his fist. And I\'d throw it all away to join the stars. I\'m just a hairy man. Murder in the dark, and no apologies. In a waxed world. I heard your heart sing love, love, love. Everyone\'s time come, sometime come</p>\r\n<p>But if you wanna speed it up yo, then grab a gun. Always something deeper. But I\'m just a hairy man. Oh no please desist. Time would be a distant memory, nobody could tell us to stay. There\'s always something deeper.. Like Jesus, like Jesus. Have a gun. Looking like the shit. We\'re all real high. I heard your heart sing love, love, love. No matter how foul you are, there\'s fouler. To getting down. In a waxed world</p>\r\n<p>Here it comes. A desperate man with a keg of powder. Like a reason, like a beacon. We are all very beautiful people. We\'re chillin\' in the club. Rumble in the ground. I heard your heart sing love, love, love. Gorilla\'s in the mist. Come on everyone. Who\'s that over there with his sceptre and crown. It\'s Friday night. I was born but I was blind, I died then I could see. There\'s always someone on a higher tower.</p>',	'2018-04-22 10:34:11',	'2018-04-22 10:39:16',	'5277ab1ae16f4af4feb0eeb9559553ed.jpeg',	4),
(3,	'Le Lorem Ipsus mérite son article',	'Le faux-texte (également appelé lorem ipsum, lipsum, ou bolo bolo)',	'<h4><strong><span id=\"Lorem_ipsum_(version_originale)\" class=\"mw-headline\"><em>Lorem ipsum</em> (version originale)</span></strong></h4>\r\n<p>&laquo;&nbsp;<span class=\"lang-la\" lang=\"la\">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui dolorem ipsum, quia dolor sit, amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt, ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit, qui in ea voluptate velit esse, quam nihil molestiae consequatur, vel illum, qui dolorem eum fugiat, quo voluptas nulla pariatur? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</span>&nbsp;&raquo;</p>\r\n<h4><strong><span id=\"Lorem_ipsum_(version_populaire)\" class=\"mw-headline\"><em>Lorem ipsum</em> (version populaire)</span></strong></h4>\r\n<p>&laquo;&nbsp;<span lang=\"la\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</span></p>\r\n<p><span lang=\"la\">Ut velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non elementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna.</span></p>\r\n<p><span lang=\"la\">Aliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus, felis magna fermentum augue, et ultricies lacus lorem varius purus. Curabitur eu amet.</span></p>\r\n<p style=\"text-align: right;\"><span lang=\"la\"><a href=\"https://fr.wikipedia.org/wiki/Faux-texte\"><em>Source : Wikip&eacute;dia</em></a></span></p>',	'2018-04-22 10:48:49',	'2018-04-22 10:48:49',	'f2ae937d0750e2e42dd7780e198ff1f0.jpg',	4);

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `label` tinytext COLLATE latin1_danish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_danish_ci;

INSERT INTO `type` (`id`, `label`) VALUES
(1,	'admin'),
(2,	'member');

-- 2018-04-22 12:27:35

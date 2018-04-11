-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `comment` (`id`, `content`, `date_create`, `likes`, `dislikes`, `author`, `validated`, `id_post`) VALUES
(3,	'Ceci est un commentaire très pertinent',	'2018-03-20 18:29:43',	0,	0,	'Son blase',	1,	1),
(4,	'Encore un autre commentaire',	'2018-03-22 18:00:38',	0,	0,	'Un autre',	1,	1),
(5,	'Un commentaire en l\'air',	'2018-03-22 20:50:31',	0,	0,	'C\'est l\'autre',	0,	10),
(6,	'gre',	'2018-04-09 11:26:58',	0,	0,	'gre',	0,	13),
(7,	'gre',	'2018-04-09 11:27:53',	0,	0,	'gre',	1,	13),
(8,	'az',	'2018-04-09 11:28:16',	0,	0,	'az',	1,	13);

INSERT INTO `member` (`id`, `login`, `password`, `validated`, `date_create`, `id_type`) VALUES
(1,	'root',	'e9b52d9d52eb6bac67cddccb039a78ef9dc7c576658e3cd6ef1e368cdee2e166f37ee4c2d6fd2be0d84fd76bf6e4220c7c436eaac013e396d80d323f57558a9d',	1,	'2018-03-19 23:00:00',	1),
(2,	'Visiteur',	'ba2745b18684715c45e4e8ced8618e3678b208cf6f8da5999f7ee90c613098fa8e09397d01a449de90d8e21ddaf94f2608bd6d14b56daffd9d109ddc0cd8eb7e',	0,	'2018-03-24 23:00:00',	2);

INSERT INTO `post` (`id`, `title`, `lede`, `content`, `date_create`, `date_update`, `img`, `id_member`) VALUES
(1,	'Un autre titre',	'Le lede là aussi',	'Un autre Lorem ipsum dolor sit amet, consectetur adipisicing elit. Si si vous avez vus',	'2018-03-14 12:45:30',	'2018-04-08 12:42:45',	'cac78367e0c572bbec94d0fa4dfc1fea.jpeg',	1),
(2,	'Titre ici',	'lede la',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ut sollicitudin enim, in vulputate elit. Aenean fringilla luctus nisl in tincidunt. In turpis quam, consequat fringilla nibh non, faucibus cursus nisl. Aliquam ac nulla id nunc euismod tempor nec ac quam. Nulla bibendum est id turpis luctus consectetur. Morbi non ex lacinia turpis eleifend porttitor. Nam vitae tristique tortor. Sed nec mauris nibh. Duis lobortis, leo sed varius semper, eros est elementum est, ut posuere magna purus nec orci. Quisque vel sem sit amet nulla aliquam volutpat vel a est. Morbi eget ex vel erat malesuada vestibulum.\r\n\r\nCras porttitor lacinia ex, vel egestas velit imperdiet non. Pellentesque eu cursus tellus. Integer tempus sapien vitae lorem ullamcorper pellentesque. Cras mollis urna id erat tempus semper. Quisque vel est turpis. Duis non convallis erat. In ultrices in nibh non euismod. Nam vitae ornare nisi. Sed ultrices neque vitae bibendum tincidunt. Vestibulum a mi leo. Sed ac erat at quam luctus pulvinar. Phasellus sed sollicitudin lorem.\r\n\r\nInteger fermentum vitae quam eget ultricies. Nullam pellentesque sem non feugiat ullamcorper. Aenean vestibulum consequat venenatis. Maecenas ipsum lectus, ullamcorper sit amet augue vel, volutpat eleifend turpis. Aliquam vitae ex ex. Fusce commodo risus quis arcu accumsan lobortis. Sed ac fermentum ante.\r\n\r\nCras euismod blandit odio suscipit euismod. Etiam placerat sed turpis bibendum varius. Cras ultrices, velit vel convallis sagittis, est nunc gravida urna, rhoncus dictum risus risus non est. Cras finibus sem semper, posuere justo ut, mattis tellus. Pellentesque suscipit mattis efficitur. Proin interdum eros eget nisl tincidunt, eu elementum magna malesuada. Suspendisse vulputate orci at purus malesuada, non volutpat leo cursus. Duis sit amet quam a est efficitur hendrerit.\r\n\r\nVivamus iaculis nulla a eros convallis posuere. Morbi aliquet turpis id purus luctus volutpat. Etiam ligula eros, ultrices consectetur ante et, interdum auctor enim. Duis tincidunt porttitor sapien eu euismod. Morbi sed nunc suscipit, elementum justo eu, porttitor tortor. In euismod ex vel risus porttitor sagittis. Ut ornare egestas rutrum. Nam tincidunt eros odio, eget tristique ex mattis et. Vestibulum laoreet ex ut diam rutrum mollis. Suspendisse potenti. Nullam lacinia feugiat venenatis. Proin iaculis libero quis neque hendrerit tempor ac at nunc. Suspendisse potenti. Praesent ullamcorper blandit leo scelerisque aliquam.',	'2018-03-14 12:41:14',	'2018-04-08 12:43:09',	'122de8dc8359f9f1ee98eeb5fe749997.jpg',	1),
(3,	'Titre de l\'article est le suivant',	'Salut la compagnie',	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laborum rerum qui fugiat sint ipsum. Dolore possimus ut fugiat quibusdam, nam provident consequatur, dolorem obcaecati veniam facilis rerum distinctio repellendus.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, esse in, facere at totam exercitationem consequatur minus unde laboriosam officia tenetur magnam quia. Enim, quae, ipsum cupiditate quod provident nihil.',	'2018-03-20 18:20:59',	'2018-04-08 12:42:37',	'1963e066871d3372246772150d3915d7.jpg',	1),
(10,	'Titre Lorem',	'Lede Lorem ',	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum atque, mollitia obcaecati alias nam vitae dolore consectetur quos nostrum sit tempore excepturi deserunt omnis. Ipsa labore ratione ea deserunt corporis!',	'2018-03-22 18:09:52',	'2018-04-08 12:42:29',	'10eec71ac2edf51e9a9223404b86be58.jpg',	1),
(12,	'Un nouveau titre d\'article',	'Un lede d\'un super article',	'Un contenu d\'un super article',	'2018-04-08 11:49:19',	'2018-04-08 14:10:38',	'fb46e5f2596e632a6a284f576bc123d2.jpg',	1),
(13,	'Article du dimanche',	'La pluie est tombée',	'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam alias id suscipit officiis, laboriosam voluptas optio voluptatem quasi quis cupiditate soluta fugiat quos, tempore, officia repudiandae nihil, eaque atque autem.',	'2018-04-08 14:28:05',	'2018-04-08 14:34:50',	'7ce0c6c77fe4c5b03ea60319fa9c499a.jpg',	1);

INSERT INTO `type` (`id`, `type`) VALUES
(1,	'admin'),
(2,	'member');

-- 2018-04-09 15:09:42
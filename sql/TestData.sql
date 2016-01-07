-- User Table
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (1,'Taro','Tesuto','test@example.dk','23232323','admin',2); 
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (2, 'Lars', 'Larsen','larsen@example.com','22334455','larslarsen',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (3, 'Hans','Hansen','hansen@example.dk','55224455','hanshansen',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (4, 'Hana','Jacobsen','hj@example.dk', '24455677','hanaJ', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (5,'Hanako','Tesuyama','tesuyama@google.jp','77665544','hanako',1); 
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (6, 'Anna', 'Ford','aFord@yahoo.com','45456767','aFord',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (7, 'Mary','Jepsen','mary12345@yahoo.fi','33445533','mary1',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (8, 'Anders','Nàdhàzi','anders@example.dk', '24423453','Anders', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (9, 'Hisayo', 'Nakayama','hisahisa@yahoo.com','65432123','Hisayo',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (10, 'Philip','Jensen','philip@yahoo.dk','35647854','AdminPhilip',2);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (11, 'Kenneth','Nielsen','kenneth@gmail.dk', '54326543','AdminKenneth', 2);

-- Login Table
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (1, 'edbd881f1ee2f76ba0bd70fd184f87711be991a0401fd07ccd4b199665f00761afc91731d8d8ba6cbb188b2ed5bfb465b9f3d30231eb0430b9f90fe91d136648', '30c4e40e6843abb3502328c14a6b68b3fd200ec3058096e6362dfc7b67c56d4b87f3832b6a5bcd4d4d78bc54c105541c9b2dc8aacd6bdd4764517e35d96a56df', 'e20beaa097ae55e04422e5a54126f9ecee3a24d0ab8ec123f3501d37598909fbe5b3f4ae1b3b7b1db5776535eb036adbb0713a47023a886ab1cd061d1c5e28f8', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (2,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (3,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (4,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (5,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (6,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (7,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (8,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (9,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (10,'','','',0);
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (11,'','','',0);
	
-- Picture table
INSERT INTO `Picture` (`picture_id`,`picture_name`)
	VALUES (1, 'imgtest.png');
INSERT INTO `Picture` (`picture_id`,`picture_name`)
	VALUES (2, 'imgtest1.png');
INSERT INTO `Picture` (`picture_id`,`picture_name`)
	VALUES (3, 'imgtest2.png');
INSERT INTO `Picture` (`picture_id`,`picture_name`)
	VALUES (4, 'imgtest3.png');

-- RecipeType table
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (1,'Italian');	
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (2,'Japanses');	
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (3,'Danish');	

-- Recipe table
INSERT INTO `Recipe`(`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_description`,`favorite_count`,`disabled`)
	VALUES (1,1,2,1,'My bolognaise','This is my first recipe bolognaise. It is very easy and cheap.
	1 onion,
	1 garlic,
	200g minsed beef,
	a tableSp olive oile,
	a tomato can',0,0);
INSERT INTO `Recipe`(`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_description`,`favorite_count`,`disabled`)
	VALUES (2,2,3,2,'Teriyaki beef','My teriyaki beef is very tasty. I will recommend to all.',0,0);
INSERT INTO `Recipe`(`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_description`,`favorite_count`,`disabled`)
	VALUES (3,3,4,3,'Smørbrod med laks','Tradition danish food. Danish eats almost every day with other toppings.',0,0);

-- Step table
INSERT INTO `Step`(`step_id`,`recipe_id`,`picture_id`,`step_number`,`step_description`)
	VALUES (1,1,1,1,'You choppes onion, garlic and put olive oile in a pan.');
INSERT INTO `Step`(`step_id`,`recipe_id`,`picture_id`,`step_number`,`step_description`)
	VALUES (2,1,2,2,'Then put onion and garlic into the pan and put minsed beef in the pan');
INSERT INTO `Step`(`step_id`,`recipe_id`,`picture_id`,`step_number`,`step_description`)
	VALUES (3,1,3,1,'Put tomat can into the pan and ');
	
-- Comment table
INSERT INTO `Comment`(`comment_id`,`user_id`,`comment_path`,`comment_contents`,`sent_at`)
	VALUES (1,2,'','',3);
INSERT INTO `Comment`(`comment_id`,`user_id`,`comment_path`,`comment_contents`,`sent_at`)
	VALUES (2,3,'','',2);
	
-- Favorite table
INSERT INTO `Favorite`(`user_id`,`recipe_id`)
	VALUES (2,1);
INSERT INTO `Favorite`(`user_id`,`recipe_id`)
	VALUES (3,2);
INSERT INTO `Favorite`(`user_id`,`recipe_id`)
	VALUES (4,2);

-- Message table
INSERT INTO `Message` (`message_id`,`user_id`,`message_contents`)
	VALUES (1,3,'Hello user 2, I would like to add your recipe to my favorite!');

-- Report table
INSERT INTO `Report`(`banned_user_id`,`banned_by_user_id`,`report`)
	VALUES(5,6,'It is not recipe!!!! You are banned, stupid!!!');

-- Ban table
INSERT INTO `Ban`(`banned_at`,`banned_until`,`ip_address`,`proxy_ip`,`session_id`)
	VALUES (1452086498,-1,'149.12.131.10',' ','h315gth71f8pirbpbumnauugq7');

-- LoginAttempt
INSERT INTO `LoginAttempt`(`occurred_at`,`username_input`,`successful`)
	VALUES (1452087918,'admin',true);
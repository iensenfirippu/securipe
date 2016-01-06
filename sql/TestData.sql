-- User Table--
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES ('1','Taro','Tesuto','test@example.dk','23232323','admin',2); 
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES ('2', 'Lars', 'Larsen','larsen@example.com','22334455','larslarsen',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (3, 'Hans','Hansen','hansen@example.dk','55224455','hanshansen',1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (4, 'Hana','Jacobsen','hj@example.dk', '24455677','hanaJ', 1);

	
-- Login Table--
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES ('1', 'edbd881f1ee2f76ba0bd70fd184f87711be991a0401fd07ccd4b199665f00761afc91731d8d8ba6cbb188b2ed5bfb465b9f3d30231eb0430b9f90fe91d136648', '30c4e40e6843abb3502328c14a6b68b3fd200ec3058096e6362dfc7b67c56d4b87f3832b6a5bcd4d4d78bc54c105541c9b2dc8aacd6bdd4764517e35d96a56df', 'e20beaa097ae55e04422e5a54126f9ecee3a24d0ab8ec123f3501d37598909fbe5b3f4ae1b3b7b1db5776535eb036adbb0713a47023a886ab1cd061d1c5e28f8', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES ('2','','','','0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES ('3','','','','0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES ('4','','','','0');

	
--Picture--
INSERT INTO Picture (`picture_id`,`pic_name`)
VALUES (1,'');
INSERT INTO Picture (`picture_id`,`pic_name`)
VALUES (2,'');
INSERT INTO Pictur
e (`picture_id`,`pic_name`)
VALUES (3,'');


--Type--
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (1,'Italian');	
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (2,'Japanses');	
INSERT INTO `RecipeType` (`type_id`,`type_name`)
	VALUES (3,'Danish');	

	
--Recipe--
INSERT INTO (`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_des`,`favorite_count`,`disable`);
	VALUES (1,1,2,1,'My bolognaise','This is my first recipe bolognaise. It is very easy and cheap.',0,0);
INSERT INTO (`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_des`,`favorite_count`,`disable`);
	VALUES (2,2,3,2,'Teriyaki beef','My teriyaki beef is very tasty. I will recommend to all.',0,0);
INSERT INTO (`recipe_id`,`picture_id`,`user_id`,`type_id`,`recipe_title`,`recipe_des`,`favorite_count`,`disable`);
	VALUES (3,3,4,3,'Smørbrod med laks','Tradition danish food. Danish eats almost every day with other toppings.',0,0);

--
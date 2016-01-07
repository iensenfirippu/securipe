-- User Table
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (1,'Taro','Tesuto','test@example.dk','23232323','taroKUN',2);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (2, 'Lars', 'Larsen','larsen@example.com','22334455','larslarsen', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (3, 'Hans','Hansen','hansen@example.dk','55224455','hanshansen', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (4, 'Hana','Jacobsen','hj@example.dk', '24455677','hanaJ', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (5,'Hanako','Tesuyama','tesuyama@google.jp','77665544','hanako', 1); 
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (6, 'Anna', 'Ford','aFord@yahoo.com','45456767','aFord', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (7, 'Mary','Jepsen','mary12345@yahoo.fi','33445533','mary1', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (8, 'Anders','Nàdhàzi','anders@example.dk', '24423453','Anders', 3);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (9, 'Hisayo', 'Nakayama','hisahisa@yahoo.com','65432123','Hisayo', 1);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (10, 'Philip','Jensen','philip@yahoo.dk','35647854','Philip', 3);
INSERT INTO `User` (`user_id`,`fname`,`lname`,`email`,`telno`,`user_name`,`privilege_level`)
	VALUES (11, 'Kenneth','Nielsen','kenneth@gmail.dk', '54326543','Kenneth', 2);

-- Login Table
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (1, '0dddcf8a13bea566c51ff606fb837713ad19e9c7cf66db850e63c40ae2e9193fc940f524710b34d77be51be0bcdfd1de1c313f9ea0ec2d9178c1a3988146f6d3',
	'f5edcf41d98335a0f943d437ddcf40b11ef6e8878239f0b61206cf808560f45c03c96bc5221ee4dbc699373cf70f81e41b4e7e4037bbabbddc87e76a3e00b967',
	'2754e876acf31514295e57c7832fb19fd49ad9b8d7679a96887ae5f3cf4bb8467e201e9d228fe559c3968b606d84f7dfc764dc54be4ce165428a0383e103c9d8', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (2, '1da483518d45a3701821f9da72ecc4e0ecd297e7ed2d1211f413e4b6953f66b7f9d139730a18b0e4e11bc8a47503036af0bd81f494fe762f9e6c0f7200e79c53',
	'f713eb8c353dc60669a89ef2b1e2502c895b5e88aa081e4fe1e87ac9e712f5357a80e19bd7d10f0cd55bf0b5842f6ab31a4f97730e181974bcfb639087ce9b13',
	'ea2104a577c319dfc027799fa55d4569705c4a3d9af3e840ceb2b48ebf9b95e4e9d6d40363ad9271c7ad2f72aae779db00b6e95a0a03f247414e9c9986ce7f98', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (3, 'de2b6ac44a388277029e32aebacabd8db221e454073c9ba3a41bf37480d9fcf09dad1969c10a332492301fbd5a22ff6c0227007401fbc48703d7275f8ba03f7a',
	'1aa1e962159bdaaa712ba1436cfdb1fcf1af35bd266b49a2c7714c9236143e26e797ca5dcb234d984d15b76d40e75520a72ad6c2143d9c6307a4b02c6cda17f7',
	'573843a2e76d6ef7d1b588d62fa8b69ce3f9d446bab5d33070aa1335eb580accfac9b3ddbecbbdd42795573d0e60389287dd7d5fc638d719fe771f1ae3f827dd', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (4, '9cc1615331a4572ed91866515fb05fe0ced5f8372caa6a82e60acb3d8933fe36cb0196ac9fe5cc8ac7f8f67fbdbeb1c0b4a808c042c0b52c66ff18f0b086981c',
	'67460449c3c51e9d74fe30f1593a06b9f5123280e920c55af7da11c0d3f8fbe21a237462fb6c3624b3556443229a0449b9b82dea279d11e81860bfa5e26b1373',
	'aa4eda4d9b27f66520c314b819c19e9184aa0dc0a7838ad106190daa3daa81f784a423e2624d007a00fc5027be125dcec956c4e4ed1e05f6aa44022ecbbe5101', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (5, '20da31724346d9a34def787737a7097582c34d88b61347086fd7e4298dca41ab61cbc021a706b5b9248ddea5c4c69cf4f918ae6667b3485214374e345b859b5c',
	'f455163bd6e591ac1c363c341177cf0cfe6d7b27d37c51eb3cda4d8c4d8507bb7bed297512ec6f2e72f8bc4bbdc1847379b5846d5bfe5d7450e964f86c866786',
	'be06a43d721eb112d51afbaa64b53ae7915e682109a5c22814e2412b5c11bae73e2d3bc1babba0cc4e5bf93991b2faecb4596c85c5a5664fecac8a71c9869014', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (6, '27a53903079b6273dad5623c8fe33a11b04ec680c1ba55136896f12168b263d1d7cd79e9d57669de1bd4d51be399e0e4d8efbaa83b88ac83684309ff9f2e4127',
	'1c27265739071fa1c1348a1ea08d9caa75801389e7ee4efcf6109d9adb1f6c2bf59bf8d664fc279db6c3f464044606b578d660e566fa412a43a0a85726fc9513',
	'6a6f1eb002abddf919226f9327c6b0fe6769dcff0af6b937ade1a471fd67eb1fde78ef94d3cb2b378b2f25a6a7807f171c38c6083472f6373b159c8d6c60c074', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (7, 'b1eb670c1e96fb333425be09b9af5179ae03cea52caac1fea7b59f22e1c53e245c2c37df0de7f2f8fb0253fa7753207e8e26b3df34a433daba301230495f5a10',
	'd5cdfaa9b83b92854044765acc13a00d37014af757910ee20ace81a74e9387ebb41c762981214ae711051281afe40f2d353fe2343f2370c09afc65fd41409952',
	'f6825e91ac9597b46596d1a57f7727846520b56a050d8213d13feb75a70d61108bde66306b9c33b28bda169497c3152f22f20fa5123894448fd6fad0bbf385a2', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (8, '744d25bdd08e79d6628ddf52ab90dd62f201994b41d8e78240ad81398377978e31712cac485c97abb4e2166fe3471012b9becb15cee4dfb54bc1af3c82ee194d',
	'0870bbcaa6dd0bea9e18dc0557261a2e53b63e475d7028426a6c441a22c9af77391b048e89f121fd4719cc30231c24ba5ed7fad5f1bf71e693b3d3d7627b1152',
	'6dbd6c569364c7c5386f61c3f7aa07f421756b55ca1ecb72e45492d95b78ca1a2f09be59c40858d2c48c99347fe057a6f76c6a47d5a8938856418f8a716b170b', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (9, '4430160afa998a0f812cfba44effff49409446db3556c798e62edd131da3d1e229c7a7dc55305f69ae9ba2c1318f1b7dc23d029ccacae5429a0169dfe1f23798',
	'2f27109384ae532402ca30df49097073cee7c42b4e51d2e54fc29cdfd7cc2655839abca22202d34a1d67ec5e2b80f95fdc5eaa26e5e1aa745084e906266b4e45',
	'b1237894c7eb884651ed6f85b6fa48d99479e3c77aba4c42e1adb80d729bb44b1cac781a1c10868667b8a4059329b9631e8728f82ac57fdd0a8197682f555cf3', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (10, '51c47d6387b4b6d2b492e78b4abda20d515c3ddaf90770330f67e6e10c51d7552f65594b087bc8115615b040c8d0bf641a6d1d7a0442777956b6968cb4024a1e',
	'35f9cccf177ff01229be3c264c6db6773b25e6ac4547079f70e5992d4907278c216ec2855a27a97e2b2b91355f6b95e579c3feb3e6c5fb2e93b548ef3dbadade',
	'1c2623655e47ab4aaa935fd18d6c705a95009293f1cb7f160515c02a0b821bc433e7e18a5c1fe99b8cac7b30a733cefff6ace9ea606df84ed0e62600722374d2', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (11, '5c390a50a59204523250f642d4b53f2c8fa3f1654b89c0ccf009fcd0a60e1d79b219a8cf7373fc96f039493de3bb511300127951e3a668ce6913ffbac2805f3d',
	'7f54ce360a279d9019941a61812d5cfede54c7ed13587e2c80b8f0ad2d4f2a1e620d3ad4db5a0c6c3b15181fd0f8137b07f20159a5e2acb384faaf11188ff5ea',
	'b98205d0867d78afd7d7c3e47fd18627f659c6bff7936b19daa3635d5e8c48f3b3eabdd0abb411a6c17ca404053f17255e902f132e17dbc50554828f5130613c', '0');

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
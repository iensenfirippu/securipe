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
	'0353e52481c0544ef08c3dc6033c1122e4293f6b4fdd3f458d43f371ef213f59400c0483a38b4adadde76fda7ff327e3820fbe2fc3e6aa17041afce78c9034cf',
	'2754e876acf31514295e57c7832fb19fd49ad9b8d7679a96887ae5f3cf4bb8467e201e9d228fe559c3968b606d84f7dfc764dc54be4ce165428a0383e103c9d8', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (2, '1da483518d45a3701821f9da72ecc4e0ecd297e7ed2d1211f413e4b6953f66b7f9d139730a18b0e4e11bc8a47503036af0bd81f494fe762f9e6c0f7200e79c53',
	'1453bc1a5abe81ad52076e865c5e1c1d314995ca4d8a7b32b2c63364cec6cdc2f18b900dd8aac355e65de24c1e97b6dea7a4573ce955e1ee65de1ac2c7cfe9ac',
	'ea2104a577c319dfc027799fa55d4569705c4a3d9af3e840ceb2b48ebf9b95e4e9d6d40363ad9271c7ad2f72aae779db00b6e95a0a03f247414e9c9986ce7f98', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (3, 'de2b6ac44a388277029e32aebacabd8db221e454073c9ba3a41bf37480d9fcf09dad1969c10a332492301fbd5a22ff6c0227007401fbc48703d7275f8ba03f7a',
	'd71d9034bd5b6ef1f1dc411434bade195d74ffc74af9dc8e9cea9714d895af3f5688004d6a0b1fd5d7b7cdc02c9bfcc4be69e56ccdabbe690da9b767792bdb9c',
	'573843a2e76d6ef7d1b588d62fa8b69ce3f9d446bab5d33070aa1335eb580accfac9b3ddbecbbdd42795573d0e60389287dd7d5fc638d719fe771f1ae3f827dd', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (4, '9cc1615331a4572ed91866515fb05fe0ced5f8372caa6a82e60acb3d8933fe36cb0196ac9fe5cc8ac7f8f67fbdbeb1c0b4a808c042c0b52c66ff18f0b086981c',
	'efc3d9f20c396ed2f2d04a7ad85ec0507aa2609514cf77e9a75aea4d0c56d0e2c5842e0ef48f43e983909ccf548f1ace063e7ce4daa19f32f8592a24459ceb21',
	'aa4eda4d9b27f66520c314b819c19e9184aa0dc0a7838ad106190daa3daa81f784a423e2624d007a00fc5027be125dcec956c4e4ed1e05f6aa44022ecbbe5101', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (5, '20da31724346d9a34def787737a7097582c34d88b61347086fd7e4298dca41ab61cbc021a706b5b9248ddea5c4c69cf4f918ae6667b3485214374e345b859b5c',
	'a121b21ce4be567e80dca4be6c7b445acfc2f0bee704e29e737f658e3d3310446ae686402a1e2cd732efaba7ca3e2e5e80d27ad8a9670f3ca584863aa9df0dec',
	'be06a43d721eb112d51afbaa64b53ae7915e682109a5c22814e2412b5c11bae73e2d3bc1babba0cc4e5bf93991b2faecb4596c85c5a5664fecac8a71c9869014', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (6, '27a53903079b6273dad5623c8fe33a11b04ec680c1ba55136896f12168b263d1d7cd79e9d57669de1bd4d51be399e0e4d8efbaa83b88ac83684309ff9f2e4127',
	'cf2bbe56553aa6ec452e454a4bd79b6cd44bde8334ea0fa9c6213542f78b8d300793a2751f4f2497ecf4083aa79d64a33011a8f07ac32723b564880b9c5a7842',
	'6a6f1eb002abddf919226f9327c6b0fe6769dcff0af6b937ade1a471fd67eb1fde78ef94d3cb2b378b2f25a6a7807f171c38c6083472f6373b159c8d6c60c074', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (7, 'b1eb670c1e96fb333425be09b9af5179ae03cea52caac1fea7b59f22e1c53e245c2c37df0de7f2f8fb0253fa7753207e8e26b3df34a433daba301230495f5a10',
	'f91d13bfcb69c6e0a1b07b6de76de70dc2585653e9e00d8c2e606a90a28ce0263871f747502b7f95457068381c3662141dee52cc23a7f2fc9c1c01555d6a48ae',
	'f6825e91ac9597b46596d1a57f7727846520b56a050d8213d13feb75a70d61108bde66306b9c33b28bda169497c3152f22f20fa5123894448fd6fad0bbf385a2', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (8, '744d25bdd08e79d6628ddf52ab90dd62f201994b41d8e78240ad81398377978e31712cac485c97abb4e2166fe3471012b9becb15cee4dfb54bc1af3c82ee194d',
	'873bda76566aad97459f8f873869cc268162f32f8d9805f7105cc1d20cd6935a8622d94d53e2b568ce1fcedc48c1437d221146f28fe14708cd490a7d5dbb1eac',
	'6dbd6c569364c7c5386f61c3f7aa07f421756b55ca1ecb72e45492d95b78ca1a2f09be59c40858d2c48c99347fe057a6f76c6a47d5a8938856418f8a716b170b', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (9, '4430160afa998a0f812cfba44effff49409446db3556c798e62edd131da3d1e229c7a7dc55305f69ae9ba2c1318f1b7dc23d029ccacae5429a0169dfe1f23798',
	'0a50cc130bf2a75762758e49067ef6b90eccaf66ccc56d6c88806c62e365a321a1a2736c7e6245b9340fb66abb8ae6e56c6c8b2b6e281340332ac9b9968981f0',
	'b1237894c7eb884651ed6f85b6fa48d99479e3c77aba4c42e1adb80d729bb44b1cac781a1c10868667b8a4059329b9631e8728f82ac57fdd0a8197682f555cf3', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (10, '51c47d6387b4b6d2b492e78b4abda20d515c3ddaf90770330f67e6e10c51d7552f65594b087bc8115615b040c8d0bf641a6d1d7a0442777956b6968cb4024a1e',
	'bed964cd0288c52456727e6155b3dbae5c74e396898cfd096e971ad3b4f0207ab82e59ce41515baa35c7ca8aa792a61da399e219af6c18eec4c801d4d908f7d6',
	'1c2623655e47ab4aaa935fd18d6c705a95009293f1cb7f160515c02a0b821bc433e7e18a5c1fe99b8cac7b30a733cefff6ace9ea606df84ed0e62600722374d2', '0');
INSERT INTO `Login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) 
	VALUES (11, '5c390a50a59204523250f642d4b53f2c8fa3f1654b89c0ccf009fcd0a60e1d79b219a8cf7373fc96f039493de3bb511300127951e3a668ce6913ffbac2805f3d',
	'd17936f72f5e92dbc6c7d0e3d399f1dd10582a816b6feabaf84da2cc1f4b054a746ffbc3cdef5c4a7a96f9e0eb236346a141a87c6d7843311e09cab5d1ea71b6',
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
	VALUES (3,3,4,3,'Sm&oslash;rbrod med laks','Tradition danish food. Danish eats almost every day with other toppings.',0,0);

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
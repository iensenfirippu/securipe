-- Default/test data insertion script for securipe

INSERT INTO `login` (`user_id`, `username_hash`, `password_hash`, `personal_salt`, `disabled`) VALUES ('1', 'edbd881f1ee2f76ba0bd70fd184f87711be991a0401fd07ccd4b199665f00761afc91731d8d8ba6cbb188b2ed5bfb465b9f3d30231eb0430b9f90fe91d136648', '30c4e40e6843abb3502328c14a6b68b3fd200ec3058096e6362dfc7b67c56d4b87f3832b6a5bcd4d4d78bc54c105541c9b2dc8aacd6bdd4764517e35d96a56df', 'e20beaa097ae55e04422e5a54126f9ecee3a24d0ab8ec123f3501d37598909fbe5b3f4ae1b3b7b1db5776535eb036adbb0713a47023a886ab1cd061d1c5e28f8', '0');
INSERT INTO `users` (`user_id`, `user_name`, `privilege_level`) VALUES ('1', 'admin', 3); 

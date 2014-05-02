SELECT * FROM note4doc.user_profile;

desc user_profile;

INSERT INTO user_profile (username, password, firstName, lastName, height, weight, dob) 
values ('pradeep123js', MD5('pradeep123js'), 'Pradeep', 'Mani', '182', '85', '1988-12-29');

select * from user_profile where password = md5('pradeep123js');
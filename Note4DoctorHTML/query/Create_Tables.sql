CREATE TABLE user_profile(id integer(3) primary key auto_increment, 
						username VARCHAR(30), password VARCHAR(32),
						firstName VARCHAR(30), lastName VARCHAR(30), 
						height VARCHAR(5), weight VARCHAR(3), dob date);

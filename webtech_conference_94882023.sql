drop database if exists webtech_conference_94882023;
create database webtech_conference_94882023;
use webtech_conference_94882023;

create table Admins(
	admin_id int auto_increment primary key,
	username varchar(30) unique,
    pword char(96) not null
    );
    insert into Admins (username, pword) 
    values ('kiitand', '$argon2i$v=19$m=65536,t=4,p=1$d2locnVCaUJVSzkuNnFKRg$heOt3p2QYq3iUSRd6a/yz5eaeMbMzgycDe0d0ssiRG4');

create table People(
	person_id int auto_increment,
	fname varchar(30) not null,
	lname varchar(30) not null,
	email varchar(30) not null unique,
	pword char(96) not null,
	job_title varchar(30),
	org_name varchar(50),
	is_presenter enum('no', 'yes') not null,
	primary key (person_id)
);
-- All People, presenters and attendees
insert into People (fname, lname, email, pword, job_title, org_name, is_presenter) 
values
	('Dusk', 'Stone', 'dst11@yahoo.com', '$argon2i$v=19$m=65536,t=4,p=1$ak95QlUzWWFxTE93bi8yMQ$CfziXUU1Mavu39VEqkpJV7RvoMteqKDCwf+gXzHRUTY', 'student', 'University of Minnesota', 'no'),
	('Betty', 'Reed', 'betty.reed@rsmag.com', '$argon2i$v=19$m=65536,t=4,p=1$Y0J3UXVhcTF5anpDdmRycw$ncP4UhGt7wsvobio+zCsAjv0NmALUtsX5BpUR4adNrI', 'Writer', 'Rolling Stone Magazine', 'no'),
	('Stephen', 'Herrin', 'sherr15@umg.com', '$argon2i$v=19$m=65536,t=4,p=1$MnZ4VW0zUFBTS25jT3lNUA$jinkZ710j3qjlbD2mx0dfNpJHCOQSREkVZ5kZdi9Jvk', 'A&R Rep', 'Universal Music Group', 'no'),
	('Jim', 'Murphy', 'jim.w.murphy@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$SDlTV1gxeTA4Z1dsWGI5Qg$KE463SjRmXXIu/IVMY+Z+3IJ6XtwZxSowBvYIizYha4', 'Professor', 'San Diego Community College', 'no'),
	('Todd', 'Meier', 'toddme@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$cUJCbTg1LnVqaXowd09ZYQ$XsgO9spqQU9Vtb7MxsKzA4eZ4FpR4BVvlz6slNEG/z8', 'Mastering Engineer', 'Avid', 'no'),
	('Kimberly', 'Lewis', 'klewis@lion.edu', '$argon2i$v=19$m=65536,t=4,p=1$Zll3Y1BxckttUTFUTC80OA$lgU97S9HmMTrGO2wHBRDi3GT8mZcQaXeOp0ZPOfRBmU', 'Student', 'Loyola Marymount University', 'no'),
	('Dale', 'Carnegie', 'dcarn@ecs.vuw.ac.nz', '$argon2i$v=19$m=65536,t=4,p=1$dnpkU29adGNzeXdPNHpETw$fZ+SONichQoyc6Dxd8jQ25mlAAQwIDllmdyOFrlf7nM', 'Professor', 'Victoria University of Wellington', 'no'),
	('Alysha', 'Kassam', 'akassam@lion.edu', '$argon2i$v=19$m=65536,t=4,p=1$ckxRMGRadGpyRzltclpWcA$wbaDtKBQglqVQ102JQ387IZk7RMEz1AyucqH+lL0fG4', 'Student', 'Loyola Marymount University', 'no'),
	('Phoenix', 'Jones', 'pjnb@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZFljaVA1ZGozbnRONzk1eA$8BKr0ZQxYJ+vGCiTwpIxY3oR3fsntb3J5jpb3s2FIBY', 'Studio Assistant', 'Daylight Recording Studio', 'no'),
	('Hannah', 'Durkin', 'hdurkin@apple.com', '$argon2i$v=19$m=65536,t=4,p=1$TXVvYkZMSWZwNGk4S1NCQg$KbG8WXzdtWt7gMYVMO3rrwV2grcMYzCNTG4eG1wC/as', 'Playlist Curator', 'Apple Music', 'no'),
	('Colleen', 'Miller', 'collmill@colum.edu', '$argon2i$v=19$m=65536,t=4,p=1$WnlQRktDYmhYWHJ6Nm51VQ$Xps1h40jrM2AmE6SAJlfxrMhp2uj2naBok8TnCjj9cU', 'Professor', 'Columbia College Chicago', 'yes'),
	('Ajay', 'Kapur', 'ajayk03@calarts.edu', '$argon2i$v=19$m=65536,t=4,p=1$MkZqUDc4eG02aEROSkdGcA$vM84og40pWr5hm00Ms7aGbJVADMwcn9bl9FFn2Q6DsY', 'Professor', 'California Institute of the Arts', 'yes'),
	('Carolyn', 'Chan', 'cacha@spotify.com', '$argon2i$v=19$m=65536,t=4,p=1$OHN4Tm1CeFNkOTBlSktDZQ$lBuwfUT4ckd2QF2FhFEDSpUrXUG999CAyubVa10PHX4', 'Playlist Curator', 'Spotify', 'yes'),
	('John', 'Gomez', 'jgomez85@twinxl.com', '$argon2i$v=19$m=65536,t=4,p=1$OGpjWlVSS2FpQ0lFSk91Yg$TTzy9kIvmgFuXR7c3AK5Ecdtp6BFAci6y88cqIeV49c', 'Mix Engineer', 'Twin XL Studios', 'yes'),
	('John', 'Feldmann', 'john@feldys.com', '$argon2i$v=19$m=65536,t=4,p=1$c1BweW85Ym5KODNvSlpuNg$Vf3N4L1Z+D8ZsdY88H/iqU809IHwjVLlbkF+u2zUWuw', 'Owner', 'Feldy''s Records', 'yes'),
	('Ashley', 'Frangipane', 'halsey@astralwerks.com', '$argon2i$v=19$m=65536,t=4,p=1$QkdweHlxeGtPR1o0UlpJQw$TpfBD6AxzAihFLdIel59lmK+R2LdUzHG9YT9uzoT3uA', 'Mastering Engineer', 'Astralwerks Records', 'yes'),
	('Will', 'Faulkner', 'w.faulkner@goldenvoice.com', '$argon2i$v=19$m=65536,t=4,p=1$aVZkNVlwRVROS3FqaDVzMA$Z9DMY1aL2hVwQHVduGKUEOM+/NuUHAx5FxYMEK9TJfQ', 'Tour Manager', 'Goldenvoice Productions', 'yes'),
	('Maria', 'Sherman', 'msherm@altpress.com', '$argon2i$v=19$m=65536,t=4,p=1$a05aY0VDU0hNT0hFR3dVTA$eOd0khbxt+4pG8C1l5fI9gX2pldw2d+MZxvrB0As868', 'Editor', 'Alternative Press', 'yes'),
	('Linda', 'Johnson', 'l.johnson2@avid.com', '$argon2i$v=19$m=65536,t=4,p=1$Q2plUFh5cDltMkNmdEhNSQ$rMStOomdk4ai/2yCPQSsfjfdDBl5wWNV5uzLKgV53rY', 'Pro Tools Developer', 'Avid', 'yes'),
	('Shelly', 'Knotts', 'sknotts15@durham.ac.uk', '$argon2i$v=19$m=65536,t=4,p=1$YS5ZbEV2YUxnMm45bVhOZw$3sOv82or+63mOP8VX5NS+3q1YMyMPB/COvQ84jEuLqY', 'Professor', 'Durham University', 'yes');


create table Speakers(
    speaker_id int not null,
    bio varchar(500),
    picture varchar(65),
    foreign key (speaker_id) references People (person_id)
);

-- Presenter info (Placeholder bios)
insert into Speakers 
values 
(11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'img/ColleenMiller.jpeg'),
(12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'img/AjayKapur.jpeg'),
(13, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'img/CarolynChan.jpeg'),
(14, 'Ne ius nominavi corrumpit, cu duo dicta neglegentur, quo ex noster fuisset laboramus. Nec ne facilis deseruisse. Usu in zril dignissim voluptatum, ut mei aeque omnes fierent, minimum adipiscing ea vel. Vivendum adversarium deterruisset mei ad, an eam essent causae civibus. In vix virtute quaerendum, et quando nominati duo. Sensibus intellegebat nam at, nulla civibus eu duo.', 'img/JohnGomez.jpeg'),
(15, 'Labitur assueverit suscipiantur an has, vis no elit sapientem forensibus. Ius eu illud electram abhorreant, cu per probo democritum definitiones. Munere feugait dolores sea at, nec altera perpetua deterruisset ea. Eam habeo mediocritatem ne, et cum veritus dissentias. Pericula mediocrem comprehensam eum id. Vis id euismod electram expetenda, eius patrioque ut his, pro ex fuisset salutandi repudiandae.', 'img/JohnFeldmann.jpeg'),
(16, 'Id modus quidam ullamcorper mei, veniam definiebas ne usu, mea copiosae probatus consetetur ei. Tantas splendide te sed, ei reque etiam dolorum mea. Mea iriure minimum postulant cu, ne malorum conceptam definitionem ius, primis interesset cotidieque in duo. Mea ad phaedrum signiferumque, simul timeam necessitatibus ut mel, sonet soluta mollis no sed.', 'img/AshleyFrangipane.jpeg'),
(17, 'Vix erat ubique ocurreret ei, eam saepe recteque no. Sit dicant tincidunt et, ea persius expetendis ius, duo dicat posidonium signiferumque an. Probo mutat posse eam ea. Pri ut rebum constituto. Congue facilisis theophrastus vim in, ei tritani tamquam nonumes per, liber gloriatur an vel.', 'img/WillFaulkner.jpeg'),
(18, 'Mei atqui splendide in. Has alii facer te, vis ad maiorum commune, eripuit tractatos explicari mel id. Cum ut duis diceret probatus, eos dico omnis choro an. Persecuti signiferumque te sea. Phaedrum facilisis inciderint et per, ne movet nobis graecis mel. Vis ad accusata efficiantur reprehendunt, at nulla principes eos, in dicit denique verterem vis.', 'img/MariaSherman.jpeg'),
(19, 'Sit cu probo prompta intellegat, ex dicunt fabulas forensibus mel, cu sed alienum tacimates scripserit. Est vide nullam ne, quo an enim nonumes, fugit equidem usu et. Ei altera scripta principes ius. Pri ut movet dolor epicurei, no dolores voluptua qui. veri ocurreret mea ex, diam periculis no eum.', 'img/LindaJohnson.jpeg'),
(20, 'Vix erat ubique ocurreret ei, eam saepe recteque no. Sit dicant tincidunt et, ea persius expetendis ius, duo dicat posidonium signiferumque an. Probo mutat posse eam ea. Pri ut rebum constituto. Congue facilisis theophrastus vim in, ei tritani tamquam nonumes per, liber gloriatur an vel.', 'img/ShellyKnotts.jpeg');

create table Presentations(
    pres_id int auto_increment primary key,
    pres_title varchar(100),
    venue varchar(8), 
    pres_time datetime,
    is_group enum('yes', 'no'),
    pres_description varchar(500)
) AUTO_INCREMENT = 1001; 
	

insert into Presentations (pres_title, venue, pres_time, is_group, pres_description)
VALUES
    ('Expressive Robotic Guitars: Developments in Musical Robotics for Chordophones','STY 2000', '2021-03-20 13:00:00',	'no', 'This presentation provides a history of robotic guitars and bass guitars as well as a discussion of two new robotic chordophones. Dr Kapur will discuss Swivel and MechBass, two new robots they built. These robots use a variety of techniques, both new and inspired by prior work, to afford composers and performers the ability to precisely control pitch and string-picking parameters. Both new robots will be demonstrated live at the panel.'),
    ('God is a DJ: Girls, Music, Performance, and Negotiating Space', 'STY 2000', '2021-03-19 10:00:00',	'yes', 'Alternative Press editor Maria Sherman moderates this discussion between three women who perform as DJs in addition to their full-time music industry jobs. They share their experiences as women in a male-dominated niche of the industry, and discuss what it means to make space for women and girls to create and enjoy music together.'),
    ('Changing Music''s Constitution: Network Music and Radical Democratization', 'NIC 200', '2021-03-19 10:00:00', 'no', 'Network music ensembles are uniquely positioned to deploy heterarchical technologies that enable them to address radical democratic concerns relating to communication structures and power distribution. This presentation provides an overview of current politically-motivated explorations in network music.'),
    ('Algorithms as Scores: Coding Live Music', 'NIC 100', '2021-03-19 13:00:00', 'no', 'This presentation combines lecture and performance as Dr Colleen Miller discusses live coding as a new path in the evolution of the musical score. Live-coding practice can accentuate the score, and transform the compositional process itself into a live event. Miller will present research in the area as she codes live.'),
    ('Life Lessons from Live Recording', 'STY 2000', '2021-03-19 13:00:00',	'yes', 'Friends and frequent collaborators take the stage together to discuss some of their favorite experiences working in the industry and what they''ve learned along the way.'),
    ('Shimon Sings: How Robotic Musicianship Found its Voice', 'NIC 100', '2021-03-19 10:00:00', 'no', 'A discussion of the upgrades to Shimon, a robotic marimba player. Shimon was originally built in 2008 to play, improvise, and compose music for marimba. In 2019, Shimon was redesigned to allow him to sing while playing. This presentation includes a description of the upgrade process as well as demonstrations of Shimon''s newfound capabilities.'),
	('Inclusivity and Diversity in the Music Education Classroom', 'NIC 200', '2021-03-20 10:00:00',	'yes', 'A discussion of the National Association of Music Education''s position statement on diversity. It addresses the need for music education programs to be inclusive of a variety of music making traditions and opportunities, as well as the importance of building a diverse music educator workforce to support music making by all.'),
    ('Tour Booking 101', 'NIC 100', '2021-03-20 13:00:00',	'yes', 'Panel discussion on important considerations for musicians and their teams when organizing tours, including organizing lineups and support, routing, hiring crew and negotiating merchandise split agreements with venues.'),
    ('Making Virtual Shows Worth It', 'NIC 100', '2021-03-20 10:00:00', 'yes', 'Faulkner and Sherman share tips on how musicians can make live streamed shows engaging and worthwhile for themselves and their audiences. While more artists have turned to virtual shows due to the pandemic, there are other benefits to online concerts such as reaching fans in markets you might not usually have physical access to. Join this discussion to learn how to best leverage these new opportunities.'),
    ('Social Media and Social Impact for Musicians', 'NIC 200', '2021-03-20 13:00:00', 'yes', 'Music has the power to culturally, morally, and emotionally influence our society. Knotts and Sherman discuss this power and the responsibilities it might bestow on musicians. If we can gain a more comprehensive awareness of how our art form is making a difference around us, we will undoubtedly become better musicians – musicians with a purpose.');


create table PresentationSpeakers (
    pres_id int,
    speaker_id int,
    is_moderator enum('no', 'yes'),
    foreign key (pres_id) references Presentations(pres_id) on delete cascade,
    foreign key (speaker_id) references Speakers(speaker_id) on delete cascade 
);

insert into PresentationSpeakers 
values 
	(1001, 12, 'no'),
	(1002, 18, 'yes'),
	(1002, 13, 'no'),
	(1002, 16, 'no'),
	(1003, 20, 'no'),
	(1004, 11, 'no'),
	(1005, 15, 'yes'),
	(1005, 14, 'no'),
	(1005, 16, 'no'),
	(1006, 11, 'no'),
	(1007, 11, 'yes'),
	(1007, 12, 'no'),
	(1007, 19, 'no'),
	(1008, 17, 'yes'),
	(1008, 14, 'no'),
	(1008, 15, 'no'),
	(1009, 17, 'no'),
	(1009, 18, 'no'),
	(1010, 18, 'no'),
	(1010, 20, 'no');
    
create table PresentationAttendees (
    pres_id int,
    attendee_id int,
    foreign key (pres_id) references Presentations(pres_id) on delete cascade,
    foreign key (attendee_id) references People(person_id) on delete cascade
);

insert into PresentationAttendees 
VALUES
	(1002, 1),
    (1002, 2),
    (1002, 4),
    (1002, 6),
    (1002, 8),
    (1002, 10),
    (1003, 7),
    (1004, 7),
    (1004, 8),
    (1004, 10),
    (1005, 1),
    (1005, 4),
    (1005, 8),
    (1005, 10),
    (1006, 7),
    (1006, 8),
    (1008, 2),
    (1008, 3),
    (1008, 10),
    (1009, 4),
    (1009, 8),
    (1009, 10);

SELECT People.fname, People.lname, People.job_title, People.org_name, Speakers.bio, Speakers.picture 
FROM People JOIN Speakers on People.person_id = Speakers.speaker_id
WHERE People.is_presenter = 'yes';

SELECT PresentationSpeakers.is_moderator, Presentations.pres_title
        FROM PresentationSpeakers 
        JOIN Presentations ON PresentationSpeakers.pres_id = Presentations.pres_id
        WHERE PresentationSpeakers.speaker_id = 11;
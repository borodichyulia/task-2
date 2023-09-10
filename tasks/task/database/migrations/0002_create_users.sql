create table if not exists `users` (
    `id` int(10) unsigned not null auto_increment,
    `email` varchar(255) not null,
    `name` varchar(255) not null,
    `gender` varchar(255) not null,
    `status` varchar(255) not null,
    primary key (id)
)
engine = innodb
auto_increment = 1
character set utf8
collate utf8_general_ci;
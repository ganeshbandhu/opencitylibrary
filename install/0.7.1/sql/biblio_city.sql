drop table if exists %prfx%biblio_city;
create table %prfx%biblio_city (
   cityid integer auto_increment not null,
   city_name varchar(30) not null,
   create_dt datetime not null,
   last_change_dt datetime not null,
   last_change_userid integer not null,
   city_latitude decimal(10,6) null,
   city_longitude decimal(10,6) null,
   primary key(cityid)
  )
  ENGINE=InnoDB;

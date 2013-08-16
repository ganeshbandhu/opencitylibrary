drop table if exists %prfx%biblio_location;
create table %prfx%biblio_location (
  locationid integer auto_increment not null
  ,userid integer not null
  ,staffid integer not null
  ,create_dt datetime not null
  ,last_change_dt datetime not null
  ,last_change_userid integer not null
  ,loc_address_one varchar(60) null
  ,loc_address_two varchar(60) null
  ,loc_pincode char(6) null
  ,loc_state varchar(30) null
  ,loc_city   varchar(40) null
  ,loc_days varchar(200) null
  ,loc_time varchar(200) null
  ,loc_latitude decimal(10,6) null
  ,loc_longitude decimal(10,6) null
  ,index location_index (loc_address_two)
  ,primary key(locationid)
  )
  ENGINE=InnoDB
;

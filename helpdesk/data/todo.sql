//contract_id to 
+ update departments set organization_id = (select contract.organization_id from contract where contract.id = departments.contract_id limit 1) where organization_id is null

+ //not null contract importance disable in claim table

+ CREATE TABLE organization_importance (id BIGSERIAL, organization_id BIGINT NOT NULL, importance_id BIGINT NOT NULL, duration BIGINT, PRIMARY KEY(id));
+ ALTER TABLE organization_importance ADD CONSTRAINT organization_importance_organization_id_organization_id FOREIGN KEY (organization_id) REFERENCES organization(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
+ ALTER TABLE organization_importance ADD CONSTRAINT organization_importance_importance_id_importance_id FOREIGN KEY (importance_id) REFERENCES importance(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

+ //добавить поле organization_id в contract_importance
ALTER TABLE contract_importance ADD CONSTRAINT contract_importance_organization_id_organization_id_ FOREIGN KEY (organization_id) REFERENCES organization(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

//patch contract_importance
update contract_importance set organization_id = (select contract.organization_id from contract where contract.id = contract_importance.contract_id limit 1)

insert into organization_importance (id, organization_id, importance_id, duration) select id, organization_id, importance_id, duration from  contract_importance


//!!!! сделать organization_importance_id not null (default = 1)

//add field to claim organization_importance_id
ALTER TABLE claim ADD CONSTRAINT claim_organization_importance_id_organization_importance_id FOREIGN KEY (organization_importance_id) REFERENCES organization_importance(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

// update claim table

update claim set organization_importance_id = contract_importance_id

+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//add tables for grafik

CREATE TABLE department_people (id BIGSERIAL, department_id BIGINT, name VARCHAR(255) NOT NULL, number VARCHAR(255), position VARCHAR(255) NOT NULL, type_id BIGINT, type_string VARCHAR(255) NOT NULL, contacts VARCHAR(255), PRIMARY KEY(id));
ALTER TABLE department_people ADD CONSTRAINT department_people_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people ADD CONSTRAINT department_people_type_id_lookup_id FOREIGN KEY (type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

+++++++

CREATE TABLE department_people_position (id BIGSERIAL, name VARCHAR(128), slug VARCHAR(128), PRIMARY KEY(id));

CREATE TABLE grafik (year BIGINT, month BIGINT, day BIGINT, department_id BIGINT, department_people_id BIGINT, from_time TIME, to_time TIME, total BIGINT, is_sick BOOLEAN DEFAULT 'false', is_skip BOOLEAN DEFAULT 'false', PRIMARY KEY(year, month, day, department_id, department_people_id));
ALTER TABLE grafik ADD CONSTRAINT grafik_department_people_id_department_people_id FOREIGN KEY (department_people_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik ADD CONSTRAINT grafik_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

// make backup
// truncate DepartmentPeople cascade
// add month year field in DepartmentPeople
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//add department_people_type_permanent in lookup
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

ALTER TABLE dogovor ADD CONSTRAINT dogovor_company_role_id_lookup_id FOREIGN KEY (company_role_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

CREATE TABLE organization_user (id BIGSERIAL, organization_id BIGSERIAL, user_id BIGSERIAL, PRIMARY KEY(id));
ALTER TABLE organization_user ADD CONSTRAINT organization_user_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE organization_user ADD CONSTRAINT organization_user_organization_id_organization_id FOREIGN KEY (organization_id) REFERENCES organization(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

+++++++++++

CREATE TABLE organization_stuff (id BIGSERIAL, organization_id BIGSERIAL, stuff_id BIGSERIAL, PRIMARY KEY(id));
ALTER TABLE organization_stuff ADD CONSTRAINT organization_stuff_stuff_id_stuff_id FOREIGN KEY (stuff_id) REFERENCES stuff(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE organization_stuff ADD CONSTRAINT organization_stuff_organization_id_organization_id FOREIGN KEY (organization_id) REFERENCES organization(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
+++++++++

ALTER TABLE organization ADD CONSTRAINT organization_scope_id_lookup_id FOREIGN KEY (scope_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE organization ADD CONSTRAINT organization_client_type_id_lookup_id FOREIGN KEY (client_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE organization ADD CONSTRAINT organization_city_id_lookup_id FOREIGN KEY (city_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;


CREATE TABLE handling (id BIGSERIAL, number VARCHAR(128), createdatetime TIMESTAMP NOT NULL, status VARCHAR(255), status_description TEXT, status_change_date TIMESTAMP, service_offered TEXT, budget VARCHAR(128), square FLOAT, chance TEXT, worktime_withclient VARCHAR(128), description TEXT, result TEXT, status_admin BOOLEAN, user_id BIGINT NOT NULL, organization_id BIGINT NOT NULL, PRIMARY KEY(id));
CREATE TABLE handling_message (id BIGSERIAL, type_id BIGINT, createdatetime DATE, description TEXT, handling_id BIGINT, user_id BIGINT, PRIMARY KEY(id));
CREATE TABLE handling_message_type (id BIGSERIAL, name VARCHAR(128) NOT NULL, slug VARCHAR(128), PRIMARY KEY(id));

ALTER TABLE handling ADD CONSTRAINT handling_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling ADD CONSTRAINT handling_organization_id_organization_id FOREIGN KEY (organization_id) REFERENCES organization(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling_message ADD CONSTRAINT handling_message_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling_message ADD CONSTRAINT handling_message_handling_id_handling_id FOREIGN KEY (handling_id) REFERENCES handling(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
++++++++++++++++++++++++++++++++++++++++++++++

ALTER TABLE handling_message ADD CONSTRAINT handling_message_type_id_handling_message_type_id FOREIGN KEY (type_id) REFERENCES handling_message_type(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
++++++++++++++++=

ALTER TABLE organization ADD CONSTRAINT organization_city_id_city_id FOREIGN KEY (city_id) REFERENCES city(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

++++++++++
1. Добавить к сотрудникам в графике поле Дата рождения

+++++

2.       Добавить кнопку у супервизора Экспорт контактных лиц – в эксель экспортируем

 /Организация/гриффинструктцра/город/область/объект/фио/тел/мобильный/должность/email/дата рождения

 ++++++++

3.       В графике добавить п/п

++++++

4.       Тип трудоустройства  берется из лукап (A-официально, B-неофициально, C-договор ГПХ)



5.       Тип з/п  Оклад, Почасово.

+++++++++++++++++++++++++++++++++++++++++++++




3*2. SalesAdmin – добавлем ему реадктирование справочника Scope  ------------------------

3*4. Назначение исполнителя – выводить только не уволенных -------------------------------


3*6. SalesAdmin- Организация - Закладка Исполнитель заменить на Менеджеры, кнопка добавить исполнителя заменить на добавить менеджера

2*7. SalesAdmin и Sales - таблица организация
Поля
ID |Название/ Город/Область/ Сфера Деятельности (Scope) |Менеджер

Фильтры: Менеджер/Город/Область/Сфера деятельности





Обращения.

1.       1*SalesAdmin – добавляем закладку Менеджеры, где назначаем менеджеров по этому обращению и их долевое участие Менеджер/Доля (в процентах)

CREATE TABLE handling_user (id BIGSERIAL, handling_id BIGINT NOT NULL, user_id BIGINT NOT NULL, part BIGINT, PRIMARY KEY(id));
ALTER TABLE handling_user ADD CONSTRAINT handling_user_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling_user ADD CONSTRAINT handling_user_handling_id_handling_id FOREIGN KEY (handling_id) REFERENCES handling(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

2.       1*Sales – добавляем закладку Менеджеры – только для чтения

+++++++++++++++++++++++++++++++++++++++

3.       1*SalesAdmin и Sales  добавляем закладку Контакты клиента – только для чтения – так удобней будет работать.

4.       1* Добавить возможность редактировать Входящие данные по обращению.

5.       1*Статусы Обращения:- это постараюсь добавить – куда добавлять?
-Стадия прозвона
- Встреча презентация
- Аудит
- Комм. Предложение
- Переговоры по цене
- Переговоры по договору
- Подписан контракт
- Отложено
- Проигран тендер

6.       1*Добавляем к Обращению Тип обращения
- Входящий контакт
- Тендер
- Прямой вход

/*
CREATE TABLE handling_status (id BIGSERIAL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id));
CREATE TABLE handling_type (id BIGSERIAL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id));
ALTER TABLE handling ADD CONSTRAINT handling_type_id_handling_type_id FOREIGN KEY (type_id) REFERENCES handling_type(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling ADD CONSTRAINT handling_status_id_handling_status_id FOREIGN KEY (status_id) REFERENCES handling_status(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

CREATE TABLE grafik (id BIGSERIAL, year BIGINT NOT NULL, month BIGINT NOT NULL, day BIGINT NOT NULL, department_id BIGINT NOT NULL, department_people_id BIGINT NOT NULL, from_time TIME, to_time TIME, total FLOAT, is_sick BOOLEAN DEFAULT 'false', is_skip BOOLEAN DEFAULT 'false', is_fired BOOLEAN DEFAULT 'false', is_vacation BOOLEAN DEFAULT 'false', PRIMARY KEY(id));
ALTER TABLE grafik ADD CONSTRAINT grafik_department_people_id_department_people_id FOREIGN KEY (department_people_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik ADD CONSTRAINT grafik_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;*/

CREATE TABLE salary (id BIGSERIAL, year BIGINT NOT NULL, month BIGINT NOT NULL, days_count BIGINT NOT NULL, weekends VARCHAR(128), day_salary FLOAT, PRIMARY KEY(id));
CREATE UNIQUE INDEX year_month ON salary (year, month);
+++++


CREATE TABLE grafik_old (year BIGINT, month BIGINT, day BIGINT, department_id BIGINT, department_people_id BIGINT, from_time TIME, to_time TIME, total FLOAT, is_sick BOOLEAN DEFAULT 'false', is_skip BOOLEAN DEFAULT 'false', is_fired BOOLEAN DEFAULT 'false', is_vacation BOOLEAN DEFAULT 'false', PRIMARY KEY(year, month, day, department_id, department_people_id));
ALTER TABLE grafik_old ADD CONSTRAINT grafik_old_department_people_id_department_people_id FOREIGN KEY (department_people_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik_old ADD CONSTRAINT grafik_old_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;


CREATE TABLE grafik (year BIGINT, month BIGINT, day BIGINT, department_id BIGINT, department_people_id BIGINT, total FLOAT, total_day FLOAT, total_evening FLOAT, total_night FLOAT, is_sick BOOLEAN DEFAULT 'false', is_skip BOOLEAN DEFAULT 'false', is_fired BOOLEAN DEFAULT 'false', is_vacation BOOLEAN DEFAULT 'false', PRIMARY KEY(year, month, day, department_id, department_people_id));
CREATE TABLE grafik_time (id BIGSERIAL, year BIGINT NOT NULL, month BIGINT NOT NULL, day BIGINT NOT NULL, department_id BIGINT NOT NULL, department_people_id BIGINT NOT NULL, from_time TIME, to_time TIME, total FLOAT, total_day FLOAT, total_evening FLOAT, total_night FLOAT, PRIMARY KEY(id));

ALTER TABLE grafik ADD CONSTRAINT grafik_department_people_id_department_people_id FOREIGN KEY (department_people_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik ADD CONSTRAINT grafik_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik_time ADD CONSTRAINT grafik_time_department_people_id_department_people_id FOREIGN KEY (department_people_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE grafik_time ADD CONSTRAINT grafik_time_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

insert into
grafik_time
  (year, month, day, department_id, department_people_id, from_time, to_time)
select
  year, month, day, department_id, department_people_id, from_time, to_time
from grafik
where grafik.is_sick is false and
grafik.is_skip is false and
grafik.is_fired is false and
grafik.is_vacation is false

+++++++

select count(g.day) from grafik g
where g.is_fired = false and
g.is_vacation = false and
g.is_sick = false and
g.is_skip = false and
g.total_day is null and
g.total_evening is null and
g.total_night is null

select count(gt.day) from grafik_time gt
where gt.total is null and
gt.total_day is null and
gt.total_evening is null and
gt.total_night is null

+++++++++++++++++

CREATE TABLE handling_result (id BIGSERIAL, name VARCHAR(128) NOT NULL, slug VARCHAR(128), PRIMARY KEY(id));
ALTER TABLE handling ADD CONSTRAINT handling_result_id_handling_result_id FOREIGN KEY (result_id) REFERENCES handling_result(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
++++

CREATE TABLE dogovor_handling (id BIGSERIAL, dogovor_id BIGINT NOT NULL, handling_id BIGINT NOT NULL, PRIMARY KEY(id));
ALTER TABLE dogovor_handling ADD CONSTRAINT dogovor_handling_handling_id_handling_id FOREIGN KEY (handling_id) REFERENCES handling(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE dogovor_handling ADD CONSTRAINT dogovor_handling_dogovor_id_dogovor_id FOREIGN KEY (dogovor_id) REFERENCES dogovor(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
+++

CREATE TABLE handling_more_info (id BIGSERIAL, handling_id BIGINT NOT NULL, handling_more_info_type_id BIGINT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE handling_more_info_type (id BIGSERIAL, handling_result_id BIGINT, name VARCHAR(128) NOT NULL, data_type VARCHAR(255), enum_choices VARCHAR(255), PRIMARY KEY(id));
CREATE UNIQUE INDEX handling_result_id_name ON handling_more_info_type (handling_result_id, name);
ALTER TABLE handling_more_info ADD CONSTRAINT hhhi FOREIGN KEY (handling_more_info_type_id) REFERENCES handling_more_info_type(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling_more_info ADD CONSTRAINT handling_more_info_handling_id_handling_id FOREIGN KEY (handling_id) REFERENCES handling(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE handling_more_info_type ADD CONSTRAINT handling_more_info_type_handling_result_id_handling_result_id FOREIGN KEY (handling_result_id) REFERENCES handling_result(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

+++++++

CREATE TABLE idea (id BIGSERIAL, name VARCHAR(255) NOT NULL, user_id BIGINT NOT NULL, createdatetime TIMESTAMP NOT NULL, description TEXT, result TEXT, expert_description TEXT, significance BIGINT, financial BIGINT, originality BIGINT, readiness BIGINT, PRIMARY KEY(id));
CREATE TABLE idea_goal (id BIGSERIAL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE idea_idea_goal (idea_id BIGINT, goal_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(idea_id, goal_id));

ALTER TABLE idea ADD CONSTRAINT idea_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE idea_idea_goal ADD CONSTRAINT idea_idea_goal_idea_id_idea_id FOREIGN KEY (idea_id) REFERENCES idea(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE idea_idea_goal ADD CONSTRAINT idea_idea_goal_goal_id_idea_goal_id FOREIGN KEY (goal_id) REFERENCES idea_goal(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
+++

CREATE TABLE client_organization (client_id BIGINT, organization_id BIGINT, created_at TIMESTAMP NOT NULL, updated_at TIMESTAMP NOT NULL, PRIMARY KEY(client_id, organization_id));
ALTER TABLE client_organization ADD CONSTRAINT client_organization_organization_id_organization_id FOREIGN KEY (organization_id) REFERENCES organization(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE client_organization ADD CONSTRAINT client_organization_client_id_client_id FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
++++++

CREATE TABLE queue (id BIGSERIAL, object_model VARCHAR(128), object_submodel VARCHAR(128), object_id VARCHAR(128), params VARCHAR(255), createdatetime TIMESTAMP, status VARCHAR(255), percent BIGINT DEFAULT 0, PRIMARY KEY(id));
CREATE TABLE queue_log (id BIGSERIAL, object_model VARCHAR(128), object_submodel VARCHAR(128), params VARCHAR(255), createdatetime TIMESTAMP, user_id BIGINT, status VARCHAR(255), persent BIGINT, PRIMARY KEY(id));
ALTER TABLE queue_log ADD CONSTRAINT queue_log_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE INDEX idx_status ON queue (status);
CREATE INDEX idx_object_model_status ON queue (object_model, status);
CREATE INDEX idx_object_model_object_id ON queue (object_model, object_id);

++++
ALTER TABLE department_people ADD COLUMN parent_id integer;

ALTER TABLE department_people
  ADD CONSTRAINT department_people_parent_id_id FOREIGN KEY (parent_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE department_people ADD COLUMN first_name character varying(128);
ALTER TABLE department_people ADD COLUMN middle_name character varying(128);
ALTER TABLE department_people ADD COLUMN last_name character varying(128);
ALTER TABLE department_people ADD COLUMN is_from_one_c boolean;
ALTER TABLE department_people ALTER COLUMN is_from_one_c SET DEFAULT false;;
ALTER TABLE department_people ADD COLUMN is_approved boolean;
ALTER TABLE department_people ALTER COLUMN is_approved SET DEFAULT false;
ALTER TABLE department_people ADD COLUMN drfo character varying(128);
ALTER TABLE department_people ADD COLUMN phone character varying(128);

CREATE TABLE department_people_month_info (department_people_id BIGINT, year BIGINT, month BIGINT, bonus FLOAT, fine FLOAT, salary VARCHAR(128), position_id BIGINT, type_id BIGINT, type_string VARCHAR(255), employment_type_id BIGINT, salary_type_id BIGINT, is_clean_salary BOOLEAN DEFAULT 'false', norma_days BIGINT, department_people_replacement_id BIGINT, real_salary VARCHAR(128), PRIMARY KEY(department_people_id, year, month, department_people_replacement_id));
ALTER TABLE department_people_month_info ADD CONSTRAINT dpdi FOREIGN KEY (position_id) REFERENCES department_people_position(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT dddi_1 FOREIGN KEY (department_people_replacement_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_type_id_lookup_id FOREIGN KEY (type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_salary_type_id_lookup_id FOREIGN KEY (salary_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_employment_type_id_lookup_id FOREIGN KEY (employment_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

php symfony departmentPeople:parent 0 0
php symfony departmentPeople:fio 0 0 1
php symfony departmentPeople:process-parent 0 0
php symfony excel:upload

++++++++++++++++++++

update department_people_month_info set department_people_replacement_id = 0 where department_people_replacement_id is null;
ALTER TABLE department_people_month_info DROP CONSTRAINT department_people_month_info_pkey;

ALTER TABLE department_people_month_info
  ADD CONSTRAINT department_people_month_info_pkey PRIMARY KEY(department_people_id, year, month, department_people_replacement_id);

ALTER TABLE grafik ADD COLUMN department_people_replacement_id integer;
update grafik set department_people_replacement_id = 0 where department_people_replacement_id is null;
ALTER TABLE grafik ALTER COLUMN department_people_replacement_id SET NOT NULL;

ALTER TABLE grafik ADD CONSTRAINT grafik_department_people_replacement_id_department_people_id FOREIGN KEY (department_people_replacement_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;


ALTER TABLE grafik_time ADD COLUMN department_people_replacement_id integer;
update grafik_time set department_people_replacement_id = 0 where department_people_replacement_id is null;
ALTER TABLE grafik_time ALTER COLUMN department_people_replacement_id SET NOT NULL;
ALTER TABLE grafik_time ALTER COLUMN department_people_replacement_id SET DEFAULT 0;
ALTER TABLE grafik_time ADD CONSTRAINT gddi FOREIGN KEY (department_people_replacement_id) REFERENCES department_people(id) NOT DEFERRABLE INITIALLY IMMEDIATE;


ALTER TABLE grafik DROP CONSTRAINT grafik_pkey;

ALTER TABLE grafik
  ADD CONSTRAINT grafik_pkey PRIMARY KEY(year, month, day, department_id, department_people_id, department_people_replacement_id);

++++++++++++++++++++++++++++++

ALTER TABLE department_people ADD COLUMN address character varying(255);

+++++

ALTER TABLE department_people ADD COLUMN admission_date date;
ALTER TABLE department_people ADD COLUMN dismissal_date date;
+++

ALTER TABLE department_people ADD COLUMN person_1c_code character varying(128);
+++++


ALTER TABLE department_people_month_info ADD COLUMN surcharge double precision;
ALTER TABLE department_people_month_info ADD COLUMN surcharge_type_id integer;
ALTER TABLE department_people_month_info ADD COLUMN bonus_type_id integer;
ALTER TABLE department_people_month_info ADD COLUMN fine_type_id integer;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_surcharge_type_id_lookup_id FOREIGN KEY (surcharge_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_fine_type_id_lookup_id FOREIGN KEY (fine_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_people_month_info ADD CONSTRAINT department_people_month_info_bonus_type_id_lookup_id FOREIGN KEY (bonus_type_id) REFERENCES lookup(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

update
  department_people_month_info
set
  surcharge_type_id = employment_type_id
where
  surcharge_type_id is null and
  surcharge is not null and
  employment_type_id is not null;

update
  department_people_month_info
set
  bonus_type_id = employment_type_id
where
  bonus_type_id is null and
  bonus is not null and
  employment_type_id is not null;

update
  department_people_month_info
set
  fine_type_id = employment_type_id
where
  fine_type_id is null and
  fine is not null and
  employment_type_id is not null;

++++++++++++++++++++++++++++

ALTER TABLE salary ADD COLUMN summary_coef double precision;
update salary set summary_coef = 1.3685

+++++++++++++++

13153 2952
13162 2948
13184 2942
13186 2944
13201 2940
13234 2956
13240 2943
13256 2969
13274 2953
13285 2946
13317 2950
13321 2941
13325 2939
13326 2959
13341 2967
13343 2937
13344 2958
13345 2949
13355 2955
13387 2961
13412 2964
13430 2934
13447 8381
13450 2954
13453 2936
13470 2935
13472 2960
13473 2932
13507 2968
13519 2962
13532 2963
13533 2966
13547 2971
13550 2951
13551 2938
13563 2965
13581 2957
13631 2945
13661 2970
13699 2947

+++++++++

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13153 and
  d1.id = 2952;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13162 and
  d1.id = 2948;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13184 and
  d1.id = 2942;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13186 and
  d1.id = 2944;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13201 and
  d1.id = 2940;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13234 and
  d1.id = 2956;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13240 and
  d1.id = 2943;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13256 and
  d1.id = 2969;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13274 and
  d1.id = 2953;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13285 and
  d1.id = 2946;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13317 and
  d1.id = 2950;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13321 and
  d1.id = 2941;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13325 and
  d1.id = 2939;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13326 and
  d1.id = 2959;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13341 and
  d1.id = 2967;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13343 and
  d1.id = 2937;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13344 and
  d1.id = 2958;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13345 and
  d1.id = 2949;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13355 and
  d1.id = 2955;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13387 and
  d1.id = 2961;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13412 and
  d1.id = 2964;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13430 and
  d1.id = 2934;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13447 and
  d1.id = 8381;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13450 and
  d1.id = 2954;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13453 and
  d1.id = 2936;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13470 and
  d1.id = 2935;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13472 and
  d1.id = 2960;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13473 and
  d1.id = 2932;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13507 and
  d1.id = 2968;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13519 and
  d1.id = 2962;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13532 and
  d1.id = 2963;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13533 and
  d1.id = 2966;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13547 and
  d1.id = 2971;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13550 and
  d1.id = 2951;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13551 and
  d1.id = 2938;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13563 and
  d1.id = 2965;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13581 and
  d1.id = 2957;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13631 and
  d1.id = 2945;

update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13661 and
  d1.id = 2970;


update
  department_people d1
set
  (number, drfo, person_code, birthday, admission_date, dismissal_date, phone, address) = (d2.number, d2.drfo, d2.person_code, d2.birthday, d2.admission_date, d2.dismissal_date, d2.phone, d2.address)
from
  department_people d2
where
  d2.id = 13699 and
  d1.id = 2947;
++++++++++++++++++++++++++++++=


ALTER TABLE stuff ADD COLUMN mobilephone_personal character varying(128);
ALTER TABLE stuff ADD COLUMN phone_inside character varying(128);
ALTER TABLE stuff ADD COLUMN birth_place character varying(128);
ALTER TABLE stuff ADD COLUMN hire_date date;
ALTER TABLE stuff ADD COLUMN fire_date date;
ALTER TABLE stuff ADD COLUMN education character varying(128);
ALTER TABLE stuff ADD COLUMN issues character varying(255);

+++++++++++++++++++++++++++++++++++++++++++++++++++

CREATE TABLE individual (id BIGSERIAL, guid VARCHAR(32), first_name VARCHAR(128), middle_name VARCHAR(128), last_name VARCHAR(128), birthday DATE, tin VARCHAR(12), passport VARCHAR(8), phone VARCHAR(32), address VARCHAR(128), PRIMARY KEY(id));

//truncate individual;

insert into individual (id, first_name, last_name, middle_name, birthday, tin, phone, address, passport)
  select id, first_name, last_name, middle_name, birthday, drfo, phone, address, passport from department_people dp
    where dp.parent_id is null and
    NOT EXISTS (select id from individual where individual.id = dp.id);

++++++++++++++++++++++++



SELECT setval('individual_id_seq', (SELECT MAX(id) FROM individual));

+++++++++++++

ALTER TABLE department_people ADD COLUMN individual_id integer;
ALTER TABLE department_people ADD CONSTRAINT department_people_individual_id_individual_id FOREIGN KEY (individual_id) REFERENCES individual(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
update department_people set individual_id = id where exists (select id from individual where id = department_people.id);



++++++++++++++++++

DROP FUNCTION IF EXISTS insert_individual(firstName varchar(128), lastName varchar(128));
CREATE OR REPLACE FUNCTION insert_individual(firstName varchar(128), lastName varchar(128)) RETURNS int AS $$
DECLARE
	return_id int;
BEGIN
    INSERT INTO individual (first_name, last_name) values (firstName, lastName) RETURNING id INTO return_id;
    RETURN return_id;
END$$ LANGUAGE 'plpgsql';

select insert_individual('firstName', 'lastNAme');

DROP FUNCTION IF EXISTS insert_department_people(individualId int, departmentId int);
CREATE OR REPLACE FUNCTION insert_department_people(individualId int, departmentId int) RETURNS int AS $$
DECLARE
	return_id int;
BEGIN
	IF NOT EXISTS (SELECT id from departments where id = departmentId limit 1)
	THEN
		RETURN -2;
	END IF;
	IF NOT EXISTS (SELECT id from individual where id = individualId)
	THEN
		RETURN -3;
	END IF;
	IF EXISTS (SELECT id from department_people where department_id = departmentId and individual_id = individualId limit 1)
	THEN
		RETURN -4;
	END IF;
	INSERT INTO department_people (department_id, individual_id) values (departmentId, individualId) RETURNING id INTO return_id;
    RETURN return_id;
END$$ LANGUAGE 'plpgsql';

select insert_department_people(10, '1200223');
select insert_department_people(individualId, departmentId);

Коды ошибок
// -1 - пустой mpk
// -2 - нет обьекта с таким mpk
// -3 - нет физ лица стаким individualId
// -4 - записть individualId departmentMpk - существует



+++++++

CREATE OR REPLACE FUNCTION stuff_to_region(userId int, regionId int, userKeyParam varchar(10)) RETURNS int AS $$
DECLARE
    claimTypeId int;
    departmentId int;
    totalCount int;
    stuffId int;
BEGIN
    totalCount = 0;
    SELECT id INTO stuffId from stuff where user_id = userId LIMIT 1;
    FOR claimTypeId IN SELECT id FROM claimtype LOOP
	FOR departmentId IN SELECT d.id FROM departments d INNER JOIN city c on d.city_id = c.id WHERE c.region_id = regionId
	    LOOP
	        IF NOT EXISTS (SELECT id FROM stuff_departments WHERE stuff_id = stuffId and departments_id = departmentId and claimtype_id = claimTypeId and userkey = userKeyParam) THEN
		    raise notice '%', departmentId;
		    INSERT INTO stuff_departments (stuff_id, departments_id, claimtype_id, userkey) VALUES (stuffId, departmentId, claimTypeId, userKeyParam);
		    totalCount = totalCount + 1;
	        END IF;
	END LOOP;
    END LOOP;

    RETURN totalCount;
END
$$
LANGUAGE 'plpgsql';

select stuff_to_region(252, 5, 'kurator');

++++++++++++++++++++++++

GRANT USAGE ON SCHEMA public to "1c";
GRANT SELECT ON table individual TO "1c";
GRANT USAGE, SELECT ON SEQUENCE individual_id_seq TO "1c";
GRANT USAGE, SELECT ON SEQUENCE individual_id_seq TO "1c";
GRANT ALL ON table department_people TO "1c";
GRANT USAGE, SELECT ON SEQUENCE department_people_id_seq TO "1c";
GRANT ALL ON table department_people_month_info TO "1c";
GRANT SELECT ON table departments TO "1c";
GRANT USAGE, SELECT ON SEQUENCE departments_id_seq TO "1c";
GRANT SELECT ON table mpk TO "1c";
GRANT USAGE, SELECT ON SEQUENCE mpk_id_seq TO "1c";
++++++++

CREATE OR REPLACE FUNCTION process_individual()
  RETURNS integer AS
$BODY$
DECLARE
	dpRow department_people%ROWTYPE;
	individualRow individual%ROWTYPE;
	totalCount int;
	individualId int;
	isNew boolean;
BEGIN
	totalCount = 0;
	individualId = null;
	isNew = TRUE;
	FOR dpRow IN SELECT * FROM department_people WHERE parent_id IS NULL AND (passport IS NOT NULL or drfo IS NOT NULL)
	LOOP
		individualId = null;

		IF (dpRow.drfo IS NOT NULL AND dpRow.drfo <> '') THEN
			SELECT * INTO individualRow from individual where (tin = dpRow.drfo AND tin <> '') limit 1;

			individualId = individualRow.id;
		END IF;

		IF (individualId IS NULL AND (dpRow.passport IS NOT NULL AND dpRow.passport <> '') AND (dpRow.drfo IS NULL OR dpRow.drfo = ''))
		THEN
			SELECT * INTO individualRow from individual where (passport = dpRow.passport AND passport <> '') limit 1;

			individualId = individualRow.id;
		END IF;


		IF ((dpRow.drfo IS NOT NULL AND dpRow.drfo <> '') OR (dpRow.passport IS NOT NULL AND dpRow.passport <> ''))
		THEN
			IF (individualId IS NULL)
			THEN
				isNew = TRUE;
			ELSE
				isNew = FALSE;
			END IF;

			IF (isNew)
			THEN
				INSERT INTO individual (first_name, last_name, middle_name, birthday, tin, phone, address, passport)
				SELECT first_name, last_name, middle_name, birthday, drfo, phone, address, passport FROM department_people dp
				WHERE dp.id = dpRow.id RETURNING id INTO individualId;
			END IF;

			UPDATE department_people set individual_id = individualId where id = dpRow.id;

			IF (isNew is FALSE AND individualRow.id IS NOT NULL)
			THEN
				IF ((dpRow.drfo IS NOT NULL AND dpRow.drfo <> '') AND (individualRow.tin IS NULL OR individualRow.tin = ''))
				THEN
					UPDATE individual SET tin = dpRow.drfo WHERE id = individualRow.id;
				END IF;

				IF ((dpRow.passport IS NOT NULL AND dpRow.passport <> '') AND (individualRow.passport IS NULL OR individualRow.passport = ''))
				THEN
					UPDATE individual SET passport = dpRow.passport WHERE id = individualRow.id;
				END IF;

				IF ((dpRow.phone IS NOT NULL AND dpRow.phone <> '') AND (individualRow.phone IS NULL OR individualRow.phone = ''))
				THEN
					UPDATE individual SET phone = dpRow.phone WHERE id = individualRow.id;
				END IF;

				IF ((dpRow.address IS NOT NULL AND dpRow.address <> '') AND (individualRow.address IS NULL OR individualRow.address = ''))
				THEN
					UPDATE individual SET address = dpRow.address WHERE id = individualRow.id;
				END IF;

				IF ((dpRow.birthday IS NOT NULL) AND (individualRow.birthday IS NULL))
				THEN
					UPDATE individual SET birthday = dpRow.birthday WHERE id = individualRow.id;
				END IF;
			END IF;

			totalCount = totalCount + 1;
		ELSE
			individualId = NULL;
		END IF;
	END LOOP;
	RETURN totalCount;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

------------------------PROCESS INDIVIDUAL
UPDATE department_people SET individual_id = null;
ALTER TABLE department_people DROP CONSTRAINT department_people_individual_id_individual_id;
TRUNCATE individual;
SELECT setval('individual_id_seq', 1);
select process_individual();
SELECT setval('individual_id_seq', (SELECT MAX(id) FROM individual));

ALTER TABLE department_people
  ADD CONSTRAINT department_people_individual_id_individual_id FOREIGN KEY (individual_id)
      REFERENCES individual (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

select update_department_people_by_month_info(2014, 1);

------------------------EOF PROCESS INDIVIDUAL


-------------------------------------DELETE DEPARTMENT

CREATE OR REPLACE FUNCTION delete_department(oldId int, newId int)
  RETURNS void AS
$BODY$
DECLARE

BEGIN
	UPDATE claim SET departments_id = newId WHERE departments_id = oldId;

	UPDATE
		groupclaim_departments
	SET
		departments_id = newId
	WHERE
		NOT EXISTS (
			SELECT * FROM groupclaim_departments dg
			WHERE dg.departments_id = newId AND
			dg.groupclaim_id = groupclaim_departments.groupclaim_id
			)
		AND
		departments_id = oldId;

	DELETE FROM groupclaim_departments WHERE departments_id = oldId;

	UPDATE
		technical_param_departments
	SET
		department_id = newId
	WHERE
		NOT EXISTS (
			SELECT * FROM technical_param_departments tpd
			WHERE tpd.department_id = newId AND
			tpd.param_id = technical_param_departments.param_id
			)
		AND
		department_id = oldId;

	DELETE FROM technical_param_departments WHERE department_id = oldId;

	UPDATE
		dogovor_department
	SET
		department_id = newId
	WHERE
		NOT EXISTS (
			SELECT * FROM dogovor_department dd
			WHERE dd.department_id = newId AND
			dd.dogovor_id = dogovor_department.dogovor_id
			)
		AND
		department_id = oldId;

	DELETE FROM dogovor_department WHERE department_id = oldId;

	UPDATE model_contact SET model_id = newId WHERE model_id = oldId AND model_name = 'departments';

	DELETE FROM stuff_departments WHERE departments_id = oldId;
	DELETE FROM client_departments WHERE departments_id = oldId;
	DELETE FROM grafik WHERE department_id = oldId;
	DELETE FROM grafik_time WHERE department_id = oldId;
	DELETE FROM department_people_month_info WHERE department_people_id in (
		SELECT
			id
		FROM
			department_people
		WHERE
			department_id = oldId
		);
	DELETE FROM department_people WHERE department_id = oldId;
	DELETE FROM departments where id = oldId;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

BEGIN;
	select delete_department(606, 646);
COMMIT;

-------------------------------------EOF DELETE DEPARTMENT

CREATE OR REPLACE FUNCTION update_department_people_by_month_info(paramYear int, paramMonth int)
  RETURNS void AS
$BODY$
DECLARE

BEGIN
	UPDATE department_people SET position_id =
		(
			SELECT
				position_id
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		)
	WHERE
		EXISTS
		(
			SELECT
				position_id
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		);

	UPDATE department_people SET employment_type_id =
		(
			SELECT
				employment_type_id
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		)
	WHERE
		EXISTS
		(
			SELECT
				employment_type_id
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		);

	UPDATE department_people SET salary =
		(
			SELECT
				salary
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		)
	WHERE
		EXISTS
		(
			SELECT
				salary
			FROM
				department_people_month_info
			WHERE
				year = paramYear AND
				month = paramMonth AND
				type_id = 18 AND
				department_people_replacement_id = 0 AND
				department_people_id = department_people.id
			LIMIT 1
		);

END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

select update_department_people_by_month_info(2014, 2);

------------------------------------

ALTER TABLE department_people_month_info DROP CONSTRAINT dddi_1;
ALTER TABLE grafik DROP CONSTRAINT grafik_department_people_id_department_people_id;
ALTER TABLE grafik DROP CONSTRAINT grafik_department_people_replacement_id_department_people_id;
ALTER TABLE grafik_time DROP CONSTRAINT gddi;
ALTER TABLE grafik_time DROP CONSTRAINT grafik_time_department_people_id_department_people_id;

----------------------------------------------
delete from department_people_month_info
	where
		department_people_id in (select id from department_people where parent_id is not null) or
		department_people_replacement_id in (select id from department_people where parent_id is not null);

delete from
	grafik_time where department_people_id in (select id from department_people where parent_id is not null)
	or
	department_people_replacement_id in (select id from department_people where parent_id is not null);
delete from
	grafik where department_people_id in (select id from department_people where parent_id is not null)
	or
	department_people_replacement_id in (select id from department_people where parent_id is not null);


delete from department_people where parent_id is not null;

------------------------------------------------------------------------------
ALTER TABLE department_people_month_info
  ADD CONSTRAINT dddi_1 FOREIGN KEY (department_people_replacement_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;


ALTER TABLE grafik
  ADD CONSTRAINT grafik_department_people_id_department_people_id FOREIGN KEY (department_people_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE grafik
  ADD CONSTRAINT grafik_department_people_replacement_id_department_people_id FOREIGN KEY (department_people_replacement_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE grafik_time
  ADD CONSTRAINT gddi FOREIGN KEY (department_people_replacement_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE grafik_time
  ADD CONSTRAINT grafik_time_department_people_id_department_people_id FOREIGN KEY (department_people_id)
      REFERENCES department_people (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;


---------------------------------------------------------------

CREATE OR REPLACE FUNCTION department_people_to_other_department(slaveId int, masterId int)
  RETURNS void AS
$BODY$
DECLARE

BEGIN
	UPDATE
		department_people
	SET
		department_id = masterId
	WHERE
		department_id = slaveId;

	UPDATE
		grafik
	SET
		department_id = masterId
	WHERE
		department_id = slaveId;

	UPDATE
		grafik_time
	SET
		department_id = masterId
	WHERE
		department_id = slaveId;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

BEGIN;
	select department_people_to_other_department(606, 646);
COMMIT;

---------------------------

CREATE TABLE mpk (id BIGSERIAL, name VARCHAR(50), PRIMARY KEY(id));
CREATE TABLE department_mpk (department_id BIGINT, mpk_id BIGINT, PRIMARY KEY(department_id, mpk_id));
ALTER TABLE department_mpk ADD CONSTRAINT department_mpk_mpk_id_mpk_id FOREIGN KEY (mpk_id) REFERENCES mpk(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE department_mpk ADD CONSTRAINT department_mpk_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;

-----------------------

--------------------- insert mpk table & dependencies

update department_people set mpk_id = null;

ALTER TABLE department_people DROP CONSTRAINT department_people_mpk_id_mpk_id;

DROP TABLE IF EXISTS department_mpk;
DROP TABLE IF EXISTS mpk;

CREATE TABLE mpk (id BIGSERIAL, name VARCHAR(50) UNIQUE, department_id BIGINT, PRIMARY KEY(id));

ALTER TABLE department_people
  ADD CONSTRAINT department_people_mpk_id_mpk_id FOREIGN KEY (mpk_id)
      REFERENCES mpk (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION;

ALTER TABLE mpk ADD CONSTRAINT mpk_department_id_departments_id FOREIGN KEY (department_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

GRANT SELECT ON table mpk TO "1c";
GRANT USAGE, SELECT ON SEQUENCE mpk_id_seq TO "1c";

CREATE OR REPLACE FUNCTION process_department_mpk()
  RETURNS integer AS
$BODY$
DECLARE
	dRow departments%ROWTYPE;
	totalCount int;
BEGIN
	totalCount = 0;
	FOR dRow IN SELECT * FROM departments where status_id <> 2
	LOOP
		IF NOT EXISTS (SELECT * FROM mpk where name = dRow.mpk) THEN
			INSERT INTO mpk (department_id, name) VALUES (dRow.id, dRow.mpk);
			totalCount = totalCount + 1;
		END IF;
	END LOOP;
	RETURN totalCount;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

select process_department_mpk();

UPDATE
	department_people
set mpk_id = (select id from mpk where department_id = department_people.department_id limit 1);

------------EOF insert mpk table & dependencies

-----------------Function for inserting department_people for 1c

CREATE OR REPLACE FUNCTION insert_department_people_by_mpk(individualid integer, mpkName varchar(50))
  RETURNS integer AS
$BODY$
DECLARE
	mpkId int;
	departmentId int;
	return_id int;
BEGIN
	SELECT id INTO mpkId FROM mpk WHERE name = mpkName;

	IF (mpkId IS NULL) THEN
		RETURN -1;
	END IF;

	SELECT department_id INTO departmentId FROM mpk where id = mpkId;

	IF (departmentId IS NULL) THEN
		RETURN -2;
	END IF;

	IF NOT EXISTS (SELECT id from individual where id = individualId)
	THEN
		RETURN -3;
	END IF;
	IF EXISTS (SELECT id from department_people where department_id = departmentId and individual_id = individualId and mpk_id = mpkId limit 1)
	THEN
		RETURN -4;
	END IF;
	INSERT INTO department_people (department_id, individual_id, mpk_id) values (departmentId, individualId, mpkId) RETURNING id INTO return_id;
    RETURN return_id;
END$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

select insert_department_people_by_mpk(individualId, 'mpk');

----RETURN
-1 - нет такого mpk
-2 - нет связанного отделения
-3 - нет individual
-4 - такой сотрудник уже сужествует

-----------------EOF Function for inserting department_people for 1c

--------------------Update name on department_people
update department_people set name = last_name || ' ' || middle_name || ' ' || first_name;
--------------------EOF Update name on department_people
-- 1903010226创建数据库
create database lizj_edu_sys;
-- 1903010226调用数据库
use lizj_edu_sys;
-- 1903010226创建系部表
create table lizj_dep
(
    depname varchar(30) PRIMARY KEY not NULL
);
-- 1903010226创建专业表
create table lizj_major
(
    majorname varchar(30) PRIMARY KEY NOT NULL,
    majorlength int(4) NOT NULL,
    depname varchar(30) NOT NULL,
    FOREIGN KEY (depname) REFERENCES lizj_dep(depname)
    on DELETE CASCADE
    on UPDATE CASCADE
);
-- 1903010226创建班级表
create table lizj_stuclass
(
    stuclass varchar(30) PRIMARY KEY NOT NULL,
    stuyear int(4) not NULL,
    majorname varchar(30) NOT NULL,
    FOREIGN KEY (majorname) REFERENCES lizj_major(majorname)
    on DELETE CASCADE
    on UPDATE CASCADE
);
-- 1903010226创建学生表
create table lizj_stu
(
    stuid char(10) PRIMARY KEY NOT NULL,
    stuname varchar(30) NOT NULL,
    stupa char(32) NOT NULL,
    stuclass varchar(30) NOT NULL,
    FOREIGN KEY (stuclass) REFERENCES lizj_stuclass(stuclass)
    on DELETE CASCADE
    on UPDATE CASCADE
); 
	-- 增加字段stupic
alter table lizj_stu add stupic char(41) default "student.png";
-- 1903010226创建教师表
create table lizj_te
(
    teid char(10) PRIMARY KEY NOT NULL,
    tename varchar(30) NOT NULL,
    tepa char(32) NOT NULL,
    depname varchar(30) NOT NULL,
    FOREIGN KEY(depname) REFERENCES lizj_dep(depname) 
    on DELETE CASCADE
    on UPDATE CASCADE
);
	-- 增加字段tepic
alter table lizj_te add tepic char(41) default "teacher.png";
-- 1903010226创建课程表
create table lizj_course
(
    cid int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ccode char(10) NOT NULL,
    cname varchar(30) NOT NULL,
    cgrade  int(4) NOT NULL,
    FOREIGN KEY(majorname) REFERENCES lizj_major(majorname)
    on DELETE CASCADE
    on UPDATE CASCADE,
    cterm int(1) NOT NULL,
    cpoint float(2,1) NOT NULL,
    cweekh float(3,1) NOT NULL,
    cweek varchar(5) NOT NULL,
    ctotalh float(3,1) NOT NULL,
    ctype varchar(30) NOT NULL,
    cexam varchar(30) NOT NULL,
    majorname varchar(30) NOT NULL
);
-- 1903010226创建教学任务表
create table lizj_task
(
    taskid int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    teid char(10) NOT NULL,
    FOREIGN KEY(teid) REFERENCES lizj_te(teid),
    cid int NOT null,
    FOREIGN KEY(cid) REFERENCES lizj_course(cid),
    stuclass varchar(30) NOT NULL,
    FOREIGN KEY(stuclass) REFERENCES lizj_stuclass(stuclass)
    on DELETE CASCADE
    on UPDATE CASCADE,
    taskterm varchar(6) NOT NULL,
    tasktime varchar(30) NOT NULL,
    taskroom varchar(30) NOT NULL
);
-- 1903010226创建成绩表
create table lizj_score
(
    scid int PRIMARY KEY NOt NULL AUTO_INCREMENT,
    taskid int NOT NULL,
    FOREIGN KEY(taskid) REFERENCES lizj_task(taskid),
    stuid varchar(10) NOT NULL,
    FOREIGN KEY(stuid) REFERENCES lizj_stu(stuid)
    on DELETE CASCADE
    on UPDATE CASCADE,
    scnormal float(3,1) NOT NULL,
    sclab float(3,1) NOT NULL,
    scmidterm float(3,1) NOT NULL,
    scfinal float(3,1) NOT NULL,
    scoverall float(3,1) NOT NULL,
    scmakeup float(3,1) NOT NULL,
    scagain float(3,1) NOT NULL
);
-- 1903010226系表内容
insert into lizj_dep (depname)
values ('计算机学院'),('软件学院'),('电通学院'),('应用外语学院');
-- 1903010226专业表内容
insert into lizj_major (majorname,majorlength,depname)
values ('计算机应用技术',3,'计算机学院'),('软件技术',3,'软件学院'),('移动通信技术',3,'电通学院');
-- 1903010226班级表内容
insert into lizj_stuclass (stuclass,stuyear,majorname)
values ('19计算机应用3-2班',2019,'计算机应用技术'),('19计算机应用3-1班',2019,'计算机应用技术'),('19计算机应用3-3班',2019,'计算机应用技术'),('19计算机应用3-4班',2019,'计算机应用技术'),('19软件技术3-1班',2019,'软件技术');
-- 1903010226学生表内容
insert into lizj_stu (stuid,stuname,stupa,stuclass)
values (1903010226,'李梓键',md5('123456'),'19计算机应用3-2班'),(1903010227,'林义荣',md5('123456'),'19计算机应用3-2班'),(1903010228,'凌上鑫',md5('123456'),'19计算机应用3-2班');
-- 1903010226老师表内容
insert into lizj_te (teid,tename,tepa,depname)
values (2005100046,'王焕军',md5('123456'),'计算机学院'),(2006100057,'黄智',md5('123456'),'计算机学院'),(2015100221,'李丹',md5('123456'),'计算机学院'),(2018450065,'梁莹',md5('123456'),'应用外语学院');
insert into lizj_course (ccode,cname,cgrade,majorname,cterm,cpoint,cweekh,cweek,ctotalh,ctype,cexam)
values (31630031,'web项目应用',2019,'计算机应用技术',4,3,4,'01-14',56,'专业核心课','集中考试'),
(31630032,'linux服务器管理',2019,'计算机应用技术',4,3,4,'01-14',56,'专业核心课','过程性考核'),
(31602145,'大学英语1',2019,'计算机应用技术',1,3,4,'01-18',72,'公共必修课','集中考试');
insert into lizj_task(teid,cid,stuclass,taskterm)
values (2015100221,1,'19计算机应用3-1班','202102'),
(2015100221,1,'19计算机应用3-2班','202102'),
(2015100221,1,'19计算机应用3-3班','202102'),
(2015100221,1,'19计算机应用3-4班','202102'),
(2005100046,2,'19计算机应用3-1班','202102'),
(2006100057,2,'19计算机应用3-2班','202102'),
(2006100057,2,'19计算机应用3-3班','202102'),
(2006100057,2,'19计算机应用3-4班','202102'),
(2018450065,3,'19计算机应用3-4班','192001'),
(2018450065,3,'19计算机应用3-4班','192001'),
(2018450065,3,'19计算机应用3-4班','192001'),
(2018450065,3,'19计算机应用3-4班','192001');
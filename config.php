<?php
return array(
	'connectionString' => 'pgsql:host=127.0.0.1;port=5432;dbname=test;user=silentium',
	'dataSourceType' => 'SqlDataSource',
	'initSql' => <<<SQL
CREATE TABLE news (
    "id" serial,
    "title" character varying,
    "text" text,
    "date_created" timestamp without time zone,
    "date_edited" timestamp without time zone,
    CONSTRAINT "news_pkey" PRIMARY KEY (id)
) WITHOUT OIDS;

SQL
,
);

TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER sentitems_timestamp BEFORE INSERT ON sentitems\nFOR EACH ROW\nBEGIN\n    IF NEW.InsertIntoDB = \'0000-00-00 00:00:00\' THEN\n        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();\n    END IF;\n    IF NEW.SendingDateTime = \'0000-00-00 00:00:00\' THEN\n        SET NEW.SendingDateTime = CURRENT_TIMESTAMP();\n    END IF;\nEND'
sql_modes=0
definers='root@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='latin1_swedish_ci'

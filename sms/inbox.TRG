TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER inbox_timestamp BEFORE INSERT ON inbox\nFOR EACH ROW\nBEGIN\n    IF NEW.ReceivingDateTime = \'0000-00-00 00:00:00\' THEN\n        SET NEW.ReceivingDateTime = CURRENT_TIMESTAMP();\n    END IF;\nEND'
sql_modes=0
definers='root@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='latin1_swedish_ci'

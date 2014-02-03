delimiter $$

CREATE PROCEDURE dataLoad()
BEGIN
	DECLARE a INT;
	DECLARE b INT;
	DECLARE c INT;
	DECLARE d INT;
	DECLARE stopper INT;
	DECLARE member_holder INT;
	DECLARE order_holder INT;

	/* load books */
	SET a=1;
	WHILE (a<=100) DO
		INSERT INTO books (`b_id`,`title`,`author`,`isbn`,`quantity`,`subject`) VALUES(NULL,CONCAT('title_',a),CONCAT('author_',a),CONCAT('isbn_',a),10000,CONCAT('subject_',a));
		SET a=a+1;
	END WHILE;

	/* load members and addresses */
	SET b=1;
	WHILE (b<=200) DO
		INSERT INTO members (`m_id`,`email`,`password`,`first_name`,`last_name`,`date_of_birth`,`book_limit`,`status`,`admin`) VALUES(NULL,CONCAT('user_',b,'@users.com'),CONCAT('user_',b),CONCAT('first_',b),CONCAT('last_',b),'1111-11-11 11:11:11',100,1,0);
		SET member_holder=LAST_INSERT_ID();
		INSERT INTO addresses (`m_id`,`line_1`,`line_2`,`line_3`,`city`,`zip`,`state`,`country`,`other`) VALUES(member_holder,CONCAT('line1_',b),CONCAT('line2_',b),CONCAT('line3_',b),CONCAT('city_',b),CONCAT('zip_',b),CONCAT('state_',b),CONCAT('country_',b),CONCAT('other_',b));
		SET c=1;
		/* load transactions */
		WHILE (c<=100) DO
			INSERT INTO orders (`o_id`,`m_id`) VALUES(NULL,member_holder);
			SET order_holder=LAST_INSERT_ID();
			SET stopper = FLOOR(1 + RAND() * (6));/* each order will have 1-7 transactions */
			SET d=1;
			WHILE (d<=stopper) DO
				INSERT INTO transactions (`o_id`,`b_id`,`quantity`) SELECT order_holder,books.b_id,1 FROM books WHERE b_id=FLOOR(1 + RAND() * (99)) ON DUPLICATE KEY UPDATE transactions.quantity=transactions.quantity+1;
				SET d=d+1;
			END WHILE;
			SET c=c+1;
		END WHILE;
		SET b=b+1;
	END WHILE;
END$$

delimiter ;

call dataLoad();
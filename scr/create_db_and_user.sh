#!/bin/bash

BASENAME=$1
DB_NAME="dg_auto_$BASENAME"
USER_NAME="u_dg_auto_$BASENAME"

function pwdgen(){
	SYMBOLS=""
	for symbol in {A..Z} {a..z} {0..9}; do SYMBOLS=$SYMBOLS$symbol; done
	SYMBOLS=$SYMBOLS
	PWD_LENGTH=30
	PASSWORD=""
	RANDOM=256

	for i in `seq 1 $PWD_LENGTH`
		do
			PASSWORD=$PASSWORD${SYMBOLS:$(expr $RANDOM % ${#SYMBOLS}):1}
		done

	echo $PASSWORD
}
PASS=$(pwdgen)

echo "under construction"
# import James.lib required

# connect to DB and then do this there
# mysql -e "CREATE DATABASE $DB_NAME;"
# mysql -e "CREATE USER '$USER_NAME'@'localhost';"
# mysql -e "GRANT ALL ON $DB_NAME.* TO '$USER_NAME'@'localhost';"
# mysql -e "ALTER USER '$DB_NAME'@'localhost' IDENTIFIED WITH mysql_native_password BY '$PASS';"
# echo "$USER_NAME $PASS" >> create_base.log
# echo "$PASS"
# get $DB_NAME $USER_NAME $PASS and disconnect from DB

# return $DB_NAME $USER_NAME $PASS
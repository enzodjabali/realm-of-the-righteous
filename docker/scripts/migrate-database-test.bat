docker exec rotr_mysql mysql -uroot -pChangeMe -e "DROP DATABASE IF EXISTS rotr_test;"
docker exec rotr_mysql mysql -uroot -pChangeMe -e "CREATE DATABASE rotr_test;"
docker cp ../rotr.sql rotr_mysql:/
docker exec rotr_mysql mysql -uroot -pChangeMe -e "use rotr_test; SET autocommit=0; source rotr.sql; COMMIT;"
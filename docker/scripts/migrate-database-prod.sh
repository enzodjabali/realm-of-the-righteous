docker exec rotr_mysql mysql -uroot -pChangeMe -e "DROP DATABASE IF EXISTS rotr;"
docker exec rotr_mysql mysql -uroot -pChangeMe -e "CREATE DATABASE rotr;"
docker cp realm-of-the-righteous/docker/scripts/rotr.sql rotr_mysql:/
docker exec rotr_mysql mysql -uroot -pChangeMe -e "use rotr; SET autocommit=0; source rotr.sql; COMMIT;"
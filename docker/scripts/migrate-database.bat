docker exec rotr_mysql mysql -uroot -pdev -e "DROP DATABASE IF EXISTS rotr;"
docker exec rotr_mysql mysql -uroot -pdev -e "CREATE DATABASE rotr;"
docker cp ../rotr.sql rotr_mysql:/
docker exec rotr_mysql mysql -uroot -pdev -e "use rotr; SET autocommit=0; source rotr.sql; COMMIT;"
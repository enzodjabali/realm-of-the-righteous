docker exec rotr_mysql mysql -uroot -pdev -e "DROP DATABASE IF EXISTS rotr_test;"
docker exec rotr_mysql mysql -uroot -pdev -e "CREATE DATABASE rotr_test;"
docker cp ./docker/rotr.sql rotr_mysql:/
docker exec rotr_mysql mysql -uroot -pdev -e "use rotr_test; SET autocommit=0; source rotr.sql; COMMIT;"
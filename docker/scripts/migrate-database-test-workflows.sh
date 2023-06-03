docker exec rotr_mysql mysql -uroot -pG1tHUbW07KF4OVVs -e "DROP DATABASE IF EXISTS rotr_test;"
docker exec rotr_mysql mysql -uroot -pG1tHUbW07KF4OVVs -e "CREATE DATABASE rotr_test;"
docker cp ./docker/rotr.sql rotr_mysql:/
docker exec rotr_mysql mysql -uroot -pG1tHUbW07KF4OVVs -e "use rotr_test; SET autocommit=0; source rotr.sql; COMMIT;"
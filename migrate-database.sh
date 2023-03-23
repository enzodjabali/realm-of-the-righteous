docker exec mysql mysql -uroot -padmin -e "DROP DATABASE IF EXISTS mydatabase1;"
docker exec mysql mysql -uroot -padmin -e "CREATE DATABASE mydatabase1;"
docker cp ./database.sql mysql:/
docker exec mysql mysql -uroot -padmin -e "use mydatabase1; SET autocommit=0; source database.sql; COMMIT;"
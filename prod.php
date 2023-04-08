<?php

shell_exec("docker-compose -f realm-of-the-righteous/docker-compose.prod.yaml down -v");
shell_exec("rm -rf realm-of-the-righteous/");
shell_exec("gh repo clone enzodjabali/realm-of-the-righteous");
shell_exec("docker-compose -f realm-of-the-righteous/docker-compose.prod.yaml up -d");
shell_exec("sleep 20");
shell_exec("sh docker/scripts/migrate-database.sh");
shell_exec("sh docker/scripts/install-composer-dependencies.sh");
shell_exec("sh docker/scripts/install-npm-dependencies.sh");

?>

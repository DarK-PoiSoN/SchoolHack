#!/bin/bash
docker run -p 3306:3306 --net sql --ip 172.18.0.2 --name basedatos -h basedatossql -d davicillo12/basedatos:v1
sleep 2
docker exec basedatos cp -r /backup/mysql/ /var/lib/
docker restart basedatos

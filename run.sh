#!/bin/bash
docker rm -f rqtest
docker run -it -d --name rqtest --link redis -v $(pwd):/root/app -w /root/app arturom/composer /bin/bash
docker exec -it rqtest /bin/bash

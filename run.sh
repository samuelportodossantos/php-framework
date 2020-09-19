if [ $1 = "db" ] 
then
    echo "Acessando container db_server"
    docker exec -ti db_server mysql -u root -peuvacopode
elif [ $1 = "app" ]
then
    echo "Acessando container api_server"
    docker exec -ti api_server bash
fi


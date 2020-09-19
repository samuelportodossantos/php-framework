if [ $1 = "db" ] 
then
    echo "Inicializando banco"
    docker exec -ti db_server mysql -u root -peuvacopode
elif [ $1 = "app" ]
then
    echo "Inicializando app"
    docker exec -ti api_server bash
fi


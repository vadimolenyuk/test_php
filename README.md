# PHP to Smarty
## Launch instructions

- launch: 
~~~bash  
docker-compose up -d
~~~
- create tables and run test data:
~~~bash 
docker exec -it app_php php console/console.php createTables
docker exec -it app_php php console/console.php createData
~~~
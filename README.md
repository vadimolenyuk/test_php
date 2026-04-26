# PHP to Smarty
## Launch instructions

- create an ENV file using the example or simply rename .ENV.EXAMPLE
- launch: 
~~~bash  
docker-compose up -d
~~~
- create tables and run test data:
~~~bash 
docker exec -it app_php php console/console.php createTables
docker exec -it app_php php console/console.php createData
~~~
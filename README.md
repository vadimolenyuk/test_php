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

- Possible problem: no permissions for the templates_c file.
~~~bash 
sudo chmod -R 777 templates_c
~~~
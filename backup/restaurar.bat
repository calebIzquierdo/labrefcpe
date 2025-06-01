
   @echo off
   
   set dbase="coopbajobiavo"
   set BACKUP_FILE="d:\db_backup\bajoviabo.backup"
   echo Se esta Restaurando Base de Datos :%BACKUP_FILE%
   SET PGPATH="C:\Program Files\PostgreSQL\9.3\bin\"
   SET PGPASSWORD=12345
   REM echo off
   %PGPATH%pg_restore -i -h localhost -p 5432 -U postgres --dbname %dbase% --no-owner --disable-triggers --clean --ignore-version --verbose %BACKUP_FILE%

   
	REM este es para la restauracion de la base de datos 
   REM pg_restore.exe --host localhost --port 5432 --username postgres --dbname backup_laboratorio --no-owner --disable-triggers --clean --ignore-version --verbose "D:\laboratorio_17052016_222009.backup"


   